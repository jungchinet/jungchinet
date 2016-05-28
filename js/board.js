// HTML 로 넘어온 <img ... > 태그의 폭이 테이블폭보다 크다면 테이블폭을 적용한다.
function resizeBoardImage(imageWidth, borderColor) {
    var target = document.getElementsByName('target_resize_image[]');
    var imageHeight = 0;

    if (target) {
        for(i=0; i<target.length; i++) { 
            // 원래 사이즈를 저장해 놓는다
            target[i].tmp_width  = target[i].width;
            target[i].tmp_height = target[i].height;
            // 이미지 폭이 테이블 폭보다 크다면 테이블폭에 맞춘다
            if(target[i].width >= imageWidth) {
                imageHeight = parseFloat(target[i].width / target[i].height)
                target[i].width = imageWidth;
                target[i].height = parseInt(imageWidth / imageHeight);
                target[i].style.cursor = 'pointer';

                // 스타일에 적용된 이미지의 폭과 높이를 삭제한다
                target[i].style.width = '';
                target[i].style.height = '';
            }

            if (borderColor) {
                target[i].style.borderWidth = '1px';
                target[i].style.borderStyle = 'solid';
                target[i].style.borderColor = borderColor;
            }
        }
    }
}

function getFontSize() {
    var fontSize = parseInt(get_cookie("ck_fontsize")); // 폰트크기 조절
    if (isNaN(fontSize)) { fontSize = 12; }
    return fontSize;
}

function scaleFont(val) {
    var fontSize = getFontSize();
    var fontSizeSave = fontSize;
    if (val > 0) {
        if (fontSize <= 18) {
            fontSize = fontSize + val; 
        }
    } else {
        if (fontSize > 12) {
            fontSize = fontSize + val; 
        }
    }
    if (fontSize != fontSizeSave) {
        drawFont(fontSize);
    }
    set_cookie("ck_fontsize", fontSize, 30, g4_cookie_domain); 
}

function drawFont(fontSize) {
    if (!fontSize) {
        fontSize = getFontSize();
    }

    var subject=document.getElementById("writeSubject"); 
    var content=document.getElementById("writeContents"); 
    var comment=document.getElementById("commentContents");
    var wr_subject=document.getElementById("wr_subject");
    var wr_content=document.getElementById("wr_content");

    if (comment) {
        var commentDiv = comment.getElementsByTagName("div");
        var lineHeight = fontSize+Math.round(1.1*fontSize); 
    }

    fontSize = fontSize + "px";

    if (subject)
        subject.style.fontSize=fontSize;
    if (content)
        content.style.fontSize=fontSize; 
    if (wr_subject)
        wr_subject.style.fontSize=fontSize; 
    if (wr_content)
        wr_content.style.fontSize=fontSize; 
    if (commentDiv) {
        for (i=0;i<commentDiv.length;i++) {
            commentDiv[i].style.fontSize=fontSize;
        }
    }
}

jQuery.resimg = function(element, options){
    var setting = { imageWidth:false, minusSize:30, borderColor:false, imageWindow:false } 
    $.extend(setting, options); 

    var imageWidth = setting.imageWidth; 
    var borderColor = setting.borderColor;
    var minusSize = setting.minusSize;
    var imageWindow = setting.imageWindow;
    
    if(!imageWidth){
        // 이미지가 로딩되면 부모의 사이즈도 변경됨으로 잠시 띄운다.
        $(element).css("position", "absolute");
        // 이미지 교정 값이 없다면 부모의 폭 크기를 구한다 이때 페딩값을 제외 한다.
        var pw = $(element).parent().innerWidth();
        var plp = parseInt($(element).parent().css("padding-left").replace("px", ""));
        var prp = parseInt($(element).parent().css("padding-right").replace("px", ""));
        var tp = plp + prp;
        // 줄어들 사이즈 보다 페딩값이 크거나 같다면 줄어들 사이즈를 페딩값으로 교정하여 엘리먼트가 트러지는것을 방지한다.
        if(minusSize <= tp) minusSize = tp;
        // 이미지 사이즈를 엘리먼트 사이즈에서 minusSize 값을 뺀값
        imageWidth = pw - minusSize;
        $(element).css("position", "");
    }

    // 엘리먼트의 자식중 img 를 선택한다.
    var element = element + " img";
    $(element).each(function(){
        var img_width = $(this).outerWidth(); 
        var img_height = $(this).outerHeight(); 

        //원래 사이즈를 저장한다. 
        var i = $(element).index($(this));
        $(element)[i].tmp_width = img_width; 
        $(element)[i].tmp_height = img_height; 
 
        // 이미지 폭이 테이블 폭보다 크다면 테이블폭에 맞춘다 
        if(img_width > imageWidth) { 
            imageHeight = parseFloat(img_width/ img_height); 
            $(this).width(imageWidth).height(parseInt(imageWidth / imageHeight)).css("cursor", "pointer");
        } 
 
        if (borderColor) $(this).css({ "border" : "1px solid "+ borderColor }); 
 
        if (!imageWindow) {
            $(this).bind("contextmenu",function(e){
                alert("그림에는 오른쪽마우스버튼을 사용할 수 없습니다."); 
                return false; 
            })
            .bind("selectstart",function(e){
                return false;
            });
        }

    }).click(function(){
        if (imageWindow) { // 관리자의 경우
            if (!$(this).parents("a").attr("href"))
                image_window(this);
        }
    });
}

// 컨텐츠의 target 바꾸기 - http://sir.co.kr/bbs/board.php?bo_table=g4_qa&wr_id=146854
function OnclickCheck(Contents, Target) 
{ 
    var A_tags = Contents.getElementsByTagName("A"); 
    var A_tag = null; 
    var MAP_tags = document.getElementsByTagName("MAP"); 
    var MAP_tag = null; 
    var AREA_tags = null; 
    var IMG_tag = null; 
    var IMG_MapName = ""; 

    for (var i=0; i<A_tags.length; i++) 
    { 
        MAP_tag = null; 
        IMG_tag = null; 
        AREA_tags = null; 

        A_tag = A_tags[i]; 

        if (!A_tag.getAttribute("HREF")) 
            continue; 

        if (A_tag.getAttribute("HREF").toLowerCase().indexOf("javascript") >= 0) 
            continue; 

        A_tag.target = Target ? Target : "_blank"; 

        if(typeof(A_tag.getElementsByTagName("IMG")[0]) != "undefined") 
        { 
            IMG_tag = A_tag.getElementsByTagName("IMG")[0]; 

            // 이미지 맵이 있다면 
            if (IMG_tag.getAttribute("USEMAP")) 
            { 
                IMG_MapName = IMG_tag.getAttribute("USEMAP").replace(/#/, ""); 

                for (var k=0; k<MAP_tags.length; k++) 
                { 
                    // 이미지의 USEMAP 속성과 일치 한다면 
                    if (MAP_tags[i].getAttribute("NAME") == IMG_MapName) 
                    { 
                        AREA_tags = MAP_tags[i].getElementsByTagName("AREA"); 

                        // A 태그에서 HREF 속성 삭제 
                        A_tag.removeAttribute("href"); 
                        A_tag.removeAttribute("HREF"); 

                    } 
                } 
            } 

            if (IMG_tag.getAttribute("onCLICK") != null) 
            { 
                IMG_tag.onclick = null; 
            } 
        } 
    } 

    return; 
} 
