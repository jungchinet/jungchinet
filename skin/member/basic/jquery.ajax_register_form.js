// 회원아이디 검사
function reg_mb_id_check() {
   var check_mb_id_val = document.fregisterform.mb_id.value;
   var check_mb_id_len = document.fregisterform.mb_id.value.length;
    if(check_mb_id_len >= 3){
      $.ajax({
        type: 'POST',
        url: member_skin_path+'/ajax_mb_id_check.php',
        data: {
            'reg_mb_id': encodeURIComponent(check_mb_id_val)
        },
        async: false,
        cache: false,
        success: function(msg){
            return_reg_mb_id_check(msg);
        }
      });
    } else {
        return_reg_mb_id_check('120');
    }
}

function return_reg_mb_id_check(req) {
    var msg = $('#msg_mb_id');

    switch(req) {
        case '110' : msg.text('영문자, 숫자, _ 만 입력하세요.').css( "color", "red" ); break;
        case '120' : msg.text('최소 3자이상 입력하세요.').css( "color", "red" ); break;
        case '130' : msg.text('이미 사용중인 아이디 입니다.').css( "color", "red" ); break;
        case '140' : msg.text('예약어로 사용할 수 없는 아이디 입니다.').css( "color", "red" ); break;
        case '000' : msg.text('사용하셔도 좋은 아이디 입니다.').css( "color", "blue" );break;
        default : alert( '잘못된 접근입니다.\n\n' + req ); break;
    }
    $('#mb_id_enabled').val(req);    
}

// 별명 검사
function reg_mb_nick_check() {
    var reg_mb_nick = $('#mb_nick').val();
    if (check_byte2(reg_mb_nick) < 4) {
        return_reg_mb_nick_check('120');
    }
    
    $.ajax({
        type: 'POST',
        url: member_skin_path + "/ajax_mb_nick_check.php",
        data: "reg_mb_nick="+encodeURIComponent(reg_mb_nick),
        async: false,
        success: function(msg){
            return_reg_mb_nick_check(msg);
        }
    });
}

function return_reg_mb_nick_check(req) {
    var msg = $('#msg_mb_nick');
    switch(req) {
        case '110' : msg.text('별명은 공백없이 한글, 영문, 숫자만 입력 가능합니다.').css( "color", "red" ); break;
        case '120' : msg.text('한글 2글자, 영문 4글자 이상 입력 가능합니다.').css( "color", "red" ); break;
        case '130' : msg.text('이미 존재하는 별명입니다.').css( "color", "red" ); break;
        case '140' : msg.text('예약어로 사용할 수 없는 별명 입니다.').css( "color", "red" ); break;
        case '150' : msg.text('기타 사유로 닉네임을 변경할 수 없습니다.').css( "color", "red" ); break;
        case '000' : msg.text('사용하셔도 좋은 별명 입니다.').css( "color", "blue" ); break;
        default : alert( '잘못된 접근입니다.\n\n' + req ); break;
    }
    $('#mb_nick_enabled').val(req);
}

// E-mail 주소 검사
function reg_mb_email_check() {
    if($('#mb_email').val().length >= 4){
        $.ajax({
            type: 'POST',
            url: member_skin_path + "/ajax_mb_email_check.php",
            data: "reg_mb_email="+encodeURIComponent($('#mb_email').val())+"&"+"reg_mb_id="+encodeURIComponent($('#mb_id').val()),
            async: false,
            success: function(msg){
                return_reg_mb_email_check(msg);
            }
        });
    } else {
        return_reg_mb_email_check('120');
    }
}

function return_reg_mb_email_check(req) {
    var msg = $('#msg_mb_email');
    switch(req) {
        case '110' : msg.text('E-mail 주소를 입력하십시오.').css( "color", "red" ); break;
        case '120' : msg.text('E-mail 주소가 형식에 맞지 않습니다.').css( "color", "red" ); break;
        case '130' : msg.text('이미 존재하는 E-mail 주소입니다.').css( "color", "red" ); break;
        case '140' : msg.text('예약어로 사용할 수 없는 별명 입니다.').css( "color", "red" ); break;
        case '150' : msg.text('금지된 메일 도메인 입니다.').css( "color", "red" ); break;
        case '000' : msg.text('사용하셔도 좋은 E-mail 주소입니다.').css( "color", "blue" ); break;
        default : alert( '잘못된 접근입니다.\n\n' + req ); break;
    }
    $('#mb_email_enabled').val(req);
}

// 회원이름 검사
function reg_mb_name_check() {
   if($('#mb_name').val().length >= 2){
      $.ajax({
        type: 'POST',
        url: member_skin_path + "/ajax_mb_name_check.php",
        data: "mb_name="+encodeURIComponent($('#mb_name').val()),
        async: false,
        success: function(msg){
            return_reg_mb_name_check(msg);
        }
      });
    } else {
        return_reg_mb_name_check('120');
    }
}

function return_reg_mb_name_check(req) {
    var msg = $('#msg_mb_name');
    switch(req) {
        case '110' : msg.text('한글, 영문자만 입력하세요.').css( "color", "red" ); break;
        case '120' : msg.text('최소 2자이상 입력하세요.').css( "color", "red" ); break;
        case '140' : msg.text('예약어로 사용할 수 없는 별명 입니다.').css( "color", "red" ); break;
        case '000' : msg.text('').css( "color", "blue" ); break;
        default : alert( '잘못된 접근입니다.\n\n' + req ); break;
    }
    $('#mb_name_enabled').val(req);
}
