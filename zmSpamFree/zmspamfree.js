if (typeof(ZM_SPAMFREE_JS) == 'undefined') { // 한번만 실행
    var ZM_SPAMFREE_JS = true;

if (typeof g4_path == 'undefined')
    alert('g4_path 변수가 선언되지 않았습니다. zmSpamFree/zmspamfree.js');

// 회원 form에서 캡챠를 체크한다.
function checkFrm() {

    zsfCode = $('#wr_key').val();
    zsfCode = $.trim(zsfCode);

    // 스팸방지코드값이 없을 경우
    if (!zsfCode) {
        alert ("스팸방지코드(Captcha Code)를 입력해 주세요.");
        $('#wr_key').focus();
        return false;
    }

    // AJAX를 이용한 스팸방지코드 검사
    url = g4_path + '/zmSpamFree/zmSpamFree.php';
    send = 'zsfCode='+zsfCode;
    
    $.ajax({
        type: 'GET',
        url: url,
        data: send,
        cache: false,
        async: false,
        success: function(result) {

            result      = result.split(',');
            zsfResult   = result[0];
            
            // 0의 경우에는 때로는 undefined.
            if (typeof(zsfResult) == 'undefined')
                zsfResult = 0;

            // 검사결과값이 거짓(0)일 경우
            if (zsfResult < 1) {
                changeZsfImg('retry');	// 캅챠 이미지 새로 바꿈
                check_value = false;
            } else {
                check_value = true;
                // 입력 값을 session에 기록해 둡니다.
            }

            }
    });

    // 검사결과 값을 리턴해 줍니다.
    return check_value;

}

// 스팸방지코드 이미지를 새로운 문제로 바꿈
function changeZsfImg(changer) {
    $('#zsfImg').attr('src',g4_path + '/zmSpamFree/zmSpamFree.php?re&zsfimg=' + new Date().getTime());

    $('#wr_key').val('');
    if (changer !== 'initial')
        $('#wr_key').focus();
}

$(document).ready( function() {
    // 캡차 이미지의 속성을 변경해 줍니다.
    $('#zsfImg').attr('align', 'absmiddle');
    $('#zsfImg').attr('alt', '여기를 클릭해 주세요.');
    $('#zsfImg').attr('title', '클릭하시면 다른 문제로 바뀝니다. SpamFree.kr');
    
    // 캡챠입력창의 autocomplete를 off 합니다.
    $('#wr_key').attr('autocomplete', 'off');

    // 캡챠 이미지를 누르면 할일을 지정해 줍니다.
    $('#zsfImg').click( function() {
            changeZsfImg();
    });

    // 기본 캡챠 이미지를 올려줍니다.
    changeZsfImg('initial');
});

}
