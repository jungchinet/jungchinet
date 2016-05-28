function clipboard_trackback(str) 
{
    if (g4_is_gecko)
        prompt("이 글의 고유주소입니다. Ctrl+C를 눌러 복사하세요.", str);
    else if (g4_is_ie) {
        window.clipboardData.setData("Text", str);
        alert("게시글 주소가 복사되었습니다.\n\n" + str + " ");
    }
}

jQuery.trackback_send_server = function(url){
    $.post(g4_path + "/" + g4_bbs + '/tb_token.php', function(data) {
        if (g4_is_gecko)
            prompt("Ctrl+C를 눌러 아래 주소를 복사하세요. 이 주소는 스팸을 막기 위하여 한번만 사용 가능합니다.", url+"/"+data);
        else if (g4_is_ie) {
            window.clipboardData.setData("Text", url+"/"+data);
            alert("trackback 주소가 복사되었습니다. 이 주소는 스팸을 막기 위하여 한번만 사용 가능합니다.\n\n"+url+"/"+data);
        }
    });
}
