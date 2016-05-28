document.write("<span id='span_output' class='span_result_box'></span>"); 

document.write("<style type='text/css'>");
document.write("span{font-size:9pt;}");
document.write("span.span_result_box{position:absolute;z-index:101;background-color:#FFFFFF;border:1px solid #555555;padding:0px 5px 0px 5px;overflow:visible;display:none;text-align:left;}");
document.write("span.span_match_text{text-decoration:underline;font-weight:bold;color:#FF6600;}");
document.write("span.span_normal{background:#FFFFFF;}");
document.write("span.span_highlight{background:#000000;color:#ffffff;cursor:pointer;}");
document.write("</style>");
document.write("<div id='msg'></div>");

var req;
var result_js_object; // 서버에서 넘어온 자료 eval
var save_js_object; // 실제 출력된 자료만 보관하는 변수

var textbox;
var save_textbox; // 화살표가 이동하기전에 텍스트박스의 내용을 저장하고 다시 화살표가 돌아오면 원래값을 복원
var before_textbox; // 바로전 텍스트박스 내용
var current_line = -1; // 결과에서 현재 선택된 라인
var count_for_id;

var is_timer;
var auto_request = false; // 자동 요청 (한글처리시 사용)

var msg = document.getElementById('msg');

function sug_set_properties(xelement, xserver_url, xignore_case, xany_where, xresult_box_width) {
    var props={
        element: xelement,
        server_url: xserver_url,
        ignore_case: ((xignore_case) ? "i" : ""),
        any_where: ((xany_where) ? "" : "^"), // 중간에 있는 글자를 검색되게 할것인지?
        like: ((xany_where) ? 1 : 0), // SQL QUERY LIKE 앞 %
        result_box_width: xresult_box_width // 결과 박스를 textbox 의 폭과 같게 할것인지?
    };
    
    if (textbox == null)
        textbox = xelement;
    sug_add_handler(xelement);
    return props;
}

//var isOpera = (navigator.userAgent.toLowerCase().indexOf("opera")!= -1);
function sug_add_handler(objText){
    objText.onkeydown = sug_textbox_keydown;
    objText.onfocus = sug_textbox_focus;
    //if (isOpera) objText.onkeypress = sug_textbox_keydown;
}
function sug_textbox_keydown(e) {
    if(window.event){
      key = event.keyCode;
      textbox = event.srcElement;
      _event = event;
    }
    else{
      key = e.which;
      textbox = e.target;
      _event = e;
    }

    auto_request = false;

    if (key == 13) { // 엔터키
        if (current_line >= 0)
            textbox.value = save_js_object[current_line];
        return;
    } else if (key == 38) { // 위 화살표
        sug_move_key(-1);
        return;
    } else if (key == 40) { // 아래 화살표
        if (current_line < 0) {
            // 화살표가 아래로 이동하기 전에 텍스트박스의 값을 저장
            save_textbox = textbox.value;
        }
        sug_move_key(1);
        return;
    } else if (key == 219 || key == 220 || key == 221 || key == 222) {
        cancel_event(_event);
        return;
    } else if (key == 229) { //  한글
        auto_request = true;
        is_timer = setTimeout("sug_request_han();", 100);
    }

    //msg.innerHTML += ","+key;

    is_timer = setTimeout("sug_request_eng()", 100);
}

function sug_textbox_focus() {
    textbox = this;
    current_line = -1;
    count_for_id = -1;
    sug_send_server(textbox.value);
}

function sug_make_matches(xcompare_str){
    count_for_id = 0;
    save_js_object = new Array();
    var match_array = new Array();
    var reg_exp = new RegExp(textbox.obj.any_where + xcompare_str, textbox.obj.ignore_case);
    for (i=0;i<result_js_object.length;i++) {
        var is_match = result_js_object[i].match(reg_exp);
        if(is_match){
            match_array[match_array.length] = sug_create_underline(result_js_object[i], xcompare_str, count_for_id);
            save_js_object[count_for_id] = result_js_object[i];
            count_for_id++;
        }
    }
    return match_array;
}


var underline_head = "<span class='span_match_text'>";
var underline_tail = "</span>";
var select_span_head = "<span style='width:100%;display:block;' class='span_normal' onmouseover='sug_set_color(this)' onmouseout='current_line=-1; sug_set_color(null);'";
var select_span_tail ="</span>";
function sug_create_underline(xstr, xtextmatch, xindex){
    select_span_mid = " onclick='sug_set_text(" + xindex + ")'" + "id='options_list_" + xindex + "' index_no='" + xindex + "'>";
    var reg_exp = new RegExp(textbox.obj.any_where + xtextmatch, textbox.obj.ignore_case);
    var start_pos = xstr.search(reg_exp);
    var matched_text = xstr.substring(start_pos, start_pos + xtextmatch.length);
    return select_span_head + select_span_mid + xstr.replace(reg_exp, underline_head + matched_text + underline_tail) + select_span_tail;
}

function sug_set_color(xtextbox){
    if(xtextbox){
        //current_line = xtextbox.id.slice(xtextbox.id.indexOf("_") + 1, xtextbox.id.length);
        //xtextbox.id.slice(xtextbox.id.indexOf("_") + 1, xtextbox.id.length);
        current_line = xtextbox.getAttribute("index_no");
    }

    var opt;
    for(i=0; i<count_for_id; i++){
        opt = document.getElementById('options_list_' + i);
        if (opt)
            opt.className = 'span_normal';
    }

    var opt = document.getElementById('options_list_' + current_line);
    if (opt) {
        opt.className = 'span_highlight';
    }
}


function sug_set_text(xindex){
    textbox.value = save_js_object[xindex]; //set text value
    current_line = -1; //remove the selected index
    self.textbox.form.submit();
}

// 위 아래 화살표 이동
function sug_move_key(number) {
    current_line = parseInt(current_line);
    if (number < 0) {
        if (current_line < 0) {
            return;
        }
    } else {
        if (current_line >= count_for_id - 1) {
            return;
        }
    }

    current_line = parseInt(current_line) + parseInt(number);
    if (current_line < 0) {
        document.getElementById('options_list_' + 0).className = 'span_normal';
        // 화살표가 이동하기 전에 저장된 값을 텍스트박스 값으로 넘김
        textbox.value = save_textbox;
    } else if (current_line < count_for_id) {
        sug_set_color(null);
        textbox.value = save_js_object[current_line];
    }
}

// request 생성
function create_request() {
    var request = null;
    try {
        request = new XMLHttpRequest();
    } catch (trymicrosoft) {
        try {
            request = new ActiveXObject("Msxml12.XMLHTTP");
        } catch (othermicrosoft) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                request = null;
            }
        }
    }
    if (request == null)
        alert("Error creating request object!");
    else
        return request;
}

// 서버로 보낸다
function sug_send_server(query_string) {
    req = create_request();

    link = "q=" + query_string + "&like=" + textbox.obj.like;
    //url = "suggest_do.php?q=" + encodeURIComponent(q);
    req.onreadystatechange = sug_result_server;
    req.open("POST", textbox.obj.server_url, true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    req.send(link);
}

// 넘어온 결과가 정상이라면 출력한다
function sug_result_server() {
    if (req.readyState == 4) {
        if (req.status == 200) {
            sug_result_box_position(textbox);
            
            // 새로운 결과가 나오면 현재 라인을 -1 로 설정
            current_line = -1;
            count_for_id = -1;
            
            document.getElementById('span_output').style.display = "none";
            document.getElementById('span_output').innerHTML = "";
            
            var str = "";

            // 넘어온 데이타를 자바스크립트 배열로 만든다
            save_js_object = new Array();
            result_js_object = eval(req.responseText);
            
            if (result_js_object) {
                // 매치된 결과에 언더라인을 출력
                var result = sug_make_matches(textbox.value);
                for(i=0;i<count_for_id;i++) {
                    str += "<div style='width:100%;padding:0px 0 0 0px;height:18px;cursor:pointer;' id='f"+i+"'>" + result[i] + "</div>";
                }
            }
            
            if (count_for_id > 0) {
                document.getElementById('span_output').innerHTML = str;
                document.getElementById('span_output').style.display = "block";
            }
        }
    }
}

// 결과박스의 포지션 설정
function sug_result_box_position(xelement){
    var el_width = xelement.offsetWidth;
    var el_height = xelement.offsetHeight;

    var el_x = el_y = 0;
    var obj = xelement;
    while (obj.offsetParent) {
        el_x += obj.offsetLeft;
        el_y += obj.offsetTop;
        obj = obj.offsetParent;
    }

    span_el = document.getElementById("span_output");
    span_el.style.left = el_x;
    span_el.style.top = el_y + el_height;
    if (xelement.obj.result_box_width) 
        span_el.style.width = el_width;
    span_el.style.display = "block";
}

// 한글 키보드 입력 처리
function sug_request_han() {
    if (before_textbox != textbox.value && auto_request) {
        before_textbox = textbox.value;
        try {
            sug_send_server(textbox.value);
        } catch (e) {
            if (auto_request)
                is_timer = setTimeout("sug_request_han();", 100);
            return 0;
        }
    }

    if (auto_request)
        is_timer = setTimeout("sug_request_han();", 100);
}

// 영문+기타 키보드 입력 처리
function sug_request_eng() {
    // 검색어가 20글자 미만이라면
    if(textbox.value.length < 20) {
        sug_send_server(textbox.value);
    }
    
    if (!auto_request)
        clearTimeout(is_timer);
}

function cancel_event(e) { 
  e.returnValue = false;
  if (e && e.preventDefault) 
      e.preventDefault();
}
