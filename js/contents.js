if (typeof(CONTENTS_JS) == 'undefined') // 한번만 실행
{
    if (typeof g4_is_member == 'undefined')
        alert('g4_is_member 변수가 선언되지 않았습니다. js/contents.js');
    if (typeof g4_path == 'undefined')
        alert('g4_path 변수가 선언되지 않았습니다. js/contents.js');

    var CONTENTS_JS = true;
    
    function win_shop_point(url)
    {
        win_open(g4_path + "/" + g4_bbs + "/shop_point.php", "winPoint", "left=20, top=20, width=616, height=635, scrollbars=1");
    }
}
