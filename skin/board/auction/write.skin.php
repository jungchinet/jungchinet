<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($is_dhtml_editor) {
    include_once("$g4[path]/lib/cheditor4.lib.php");
    echo "<script type='text/javascript' src='$g4[cheditor4_path]/cheditor.js'></script>";
    echo cheditor1('wr_content', '100%', '250px');
}

// 스킨에서 사용하는 lib 읽어들이기
include_once("$g4[path]/lib/write.skin.lib.php");

if ($w == '') {
    $write[wr_1] = date("Y-m-d H:i", strtotime($g4[time_ymd]." 00:00") + 60*60*24);
    $write[wr_2] = date("Y-m-d H:i", strtotime($write[wr_1]) + 60*60*24*7);

    $write[wr_3] = $board[bo_1]; // 참여 포인트 기본값
    $write[wr_4] = $board[bo_2]; // 입찰 최소 포인트 기본값
    $write[wr_5] = $board[bo_3]; // 입찰 최대 포인트 기본값
    $write[wr_6] = $board[bo_4]; // 하루 참여 횟수 기본값
    $write[wr_7] = 0;
    $write[wr_8] = 0;
}
?>
<style type="text/css">
.write_head { padding:5px 0 5px 20px; height:30px; background-color:#F9F9F9; width:130px; font-weight:bold; color:#000; font-family:dotum; line-height:15px; }
.write_main { padding:5px 0 5px 10px; }
.write_size { color:#999999; font-size:11px; font-weight:normal; margin-left:10px; }
</style>

<div style="height:14px; line-height:1px; font-size:1px;">&nbsp;</div>

<style type="text/css">
.write_head { height:30px; text-align:center; color:#8492A0; }
.field { border:1px solid #ccc; }
</style>

<script language="javascript">
// 글자수 제한
var char_min = parseInt(<?=$write_min?>); // 최소
var char_max = parseInt(<?=$write_max?>); // 최대
</script>

<form name="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin:0px;">
<input type=hidden name=null> 
<input type=hidden name=w        value="<?=$w?>">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=wr_id    value="<?=$wr_id?>">
<input type=hidden name=sca      value="<?=$sca?>">
<input type=hidden name=sfl      value="<?=$sfl?>">
<input type=hidden name=stx      value="<?=$stx?>">
<input type=hidden name=spt      value="<?=$spt?>">
<input type=hidden name=sst      value="<?=$sst?>">
<input type=hidden name=sod      value="<?=$sod?>">
<input type=hidden name=page     value="<?=$page?>">
<input type=hidden name=wr_7     value="<?=$write[wr_7]?>">
<input type=hidden name=wr_8     value="<?=$write[wr_8]?>">
<input type=hidden name=wr_9     value="<?=$write[wr_9]?>">
<input type=hidden name=wr_10     value="<?=$write[wr_10]?>">

<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0><tr><td>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<colgroup width=100>
<colgroup width=''>
<tr><td colspan=2 height=2 bgcolor="#0A7299"></td></tr>
<tr><td style='padding-left:20px' colspan=2 height=38 bgcolor="#FBFBFB"><strong><?=$title_msg?></strong></td></tr>
<tr><td colspan="2" style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x; height:3px;"></td></tr>
<? if ($is_name) { ?>
<tr>
    <td class=write_head>· 이름</td>
    <td class=write_main><input class='field_pub_01' maxlength=20 size=15 name=wr_name itemname="이름" required value="<?=$name?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_password) { ?>
<tr>
    <td class=write_head>· 패스워드</td>
    <td class=write_main><input class='field_pub_01' type=password maxlength=20 size=15 name=wr_password itemname="패스워드" <?=$password_required?>></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_email) { ?>
<tr>
    <td class=write_head>· 이메일</td>
    <td class=write_main><input class='field_pub_01' maxlength=100 size=50 name=wr_email email itemname="이메일" value="<?=$email?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_homepage) { ?>
<tr>
    <td class=write_head>· 홈페이지</td>
    <td class=write_main><input class='field_pub_01' size=50 name=wr_homepage itemname="홈페이지" value="<?=$homepage?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? 
$option = "";
$option_hidden = "";
if ($is_notice || $is_html || $is_secret || $is_mail) { 
    $option = "";
    if ($is_notice) { 
        $option .= "<input type=checkbox name=notice value='1' $notice_checked>공지&nbsp;";
    }

    // 불당팩 - 전체 공지
    if ($is_g_notice) {
        $option .= "<input type=checkbox name=g_notice value='1' $g_notice_checked>전체공지&nbsp;";
    }

    if ($is_html) {
        if ($is_dhtml_editor) {
            $option_hidden .= "<input type=hidden value='html1' name='html'>";
        } else {
            $option .= "<input onclick='html_auto_br(this);' type=checkbox value='$html_value' name='html' $html_checked><span class=w_title>html</span>&nbsp;";
        }
    }

    if ($is_secret) {
        if ($is_admin || $is_secret==1) {
            $option .= "<input type=checkbox value='secret' name='secret' $secret_checked><span class=w_title>비밀글</span>&nbsp;";
        } else {
            $option_hidden .= "<input type=hidden value='secret' name='secret'>";
        }
    }
    
    if ($is_mail) {
        $option .= "<input type=checkbox value='mail' name='mail' $recv_email_checked>답변메일받기&nbsp;";
    }
}

echo $option_hidden;
if ($option) {
?>
<tr>
    <td class=write_head>옵 션</td>
    <td style='padding-left:20px; height:30px;'><?=$option?></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_category) { ?>
<tr>
    <td class=write_head>· 분류</td>
    <td class=write_main><select name=ca_name required itemname="분류"><option value="">선택하세요<?=$category_option?></select></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<tr>
    <td class=write_head style="height:60px;">· 업체명|상품명</td>
    <td class=write_main>
        <input class="field_pub_01" style="width:100%;" name=wr_subject id="wr_subject" itemname="제목" required value="<?=$subject?>">
        <div class=write_size style="line-height:25px;">제공업체명과 상품명을 | 구분자로 함께 작성해주세요. 예) 아이리버|mp3 플레이어</div>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<tr>
    <td class=write_head>· 경매시작일시</td>
    <td class=write_main>
        <input type=text size=20 name=wr_1 id=wr_1 value="<?=$write[wr_1]?>" itemname="경매시작일시" required>
        <input type=button value="오늘자정" onclick="document.getElementById('wr_1').value='<?=date("Y-m-d 00:00", $g4[server_time]+60*60*24)?>';">
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<tr>
    <td class=write_head>· 경매종료일시</td>
    <td class=write_main>
        <input type=text size=20 name=wr_2 id=wr_2 value="<?=$write[wr_2]?>" itemname="경매종료일시" required>
        <input type=button value="1일" onclick="end_date(1)">
        <input type=button value="3일" onclick="end_date(3)">
        <input type=button value="5일" onclick="end_date(5)">
        <input type=button value="7일" onclick="end_date(7)">
        <input type=button value="14일" onclick="end_date(14)">
        <input type=button value="30일" onclick="end_date(30)">
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<tr>
    <td class=write_head>· 참여포인트</td>
    <td class=write_main>
        <input type=text size=7 name=wr_3 id=wr_3 value="<?=$write[wr_3]?>" itemname="참여포인트" required numeric> 포인트
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<tr>
    <td class=write_head>· 입찰포인트</td>
    <td class=write_main>
        <input type=text size=7 name=wr_4 id=wr_4 value="<?=$write[wr_4]?>" itemname="입찰 최소 포인트" required numeric> ~
        <input type=text size=7 name=wr_5 id=wr_5 value="<?=$write[wr_5]?>" itemname="입찰 최대 포인트" required numeric> 포인트
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<tr>
    <td class=write_head>· 하루입찰제한</td>
    <td class=write_main>
        <input type=text size=7 name=wr_6 id=wr_6 value="<?=$write[wr_6]?>" itemname="하루 참여 횟수 제한" required numeric>
        번
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<tr>
    <td class=write_head>· 내용</td>
    <td class=write_main style='padding:5px;'>
        <? if ($is_dhtml_editor) { ?>
            <?=cheditor2('wr_content', $content);?>
        <? } else { ?>
        <table width=100% cellpadding=0 cellspacing=0>
        <tr>
            <td width=50% align=left valign=bottom>
                <span style="cursor: pointer;" onclick="textarea_decrease('wr_content', 10);"><img src="<?=$board_skin_path?>/img/up.gif"></span>
                <span style="cursor: pointer;" onclick="textarea_original('wr_content', 10);"><img src="<?=$board_skin_path?>/img/start.gif"></span>
                <span style="cursor: pointer;" onclick="textarea_increase('wr_content', 10);"><img src="<?=$board_skin_path?>/img/down.gif"></span></td>
            <td width=50% align=right><? if ($write_min || $write_max) { ?><span id=char_count></span>글자<?}?></td>
        </tr>
        </table>
        <textarea id="wr_content" name="wr_content" class=tx style='width:100%; word-break:break-all;' rows=10 itemname="내용" required 
        <? if ($write_min || $write_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?>><?=$content?></textarea>
        <? if ($write_min || $write_max) { ?><script language="javascript"> check_byte('wr_content', 'char_count'); </script><?}?>
        <? } ?>
        </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<tr>
    <td class=write_head>· 업체 URL</td>
    <td class=write_main><input type='text' class='field_pub_01' size=50 name='wr_link1' itemname='업체 URL' value='<?=$write["wr_link1"]?>'></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<tr>
    <td class=write_head>· 상품 URL</td>
    <td class=write_main><input type='text' class='field_pub_01' size=50 name='wr_link2' itemname='상품 URL' value='<?=$write["wr_link2"]?>'></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<? if ($is_file) { ?>
<tr>
    <td class=write_head>· 목록 이미지 <div class=write_size>size 98 x 98</div> </td>
    <td class=write_main>
        <input type='file' class='field_pub_01' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'>        
        <span id=file1></span>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<tr>
    <td class=write_head>· 내용 이미지 <div class=write_size>size 268 x 228</div> </td>
    <td class=write_main>
        <input type='file' class='field_pub_01' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'>        
        <span id=file2></span>

        <script language="JavaScript">
        var flen = 1;
        function add_file(delete_code)
        {
            var obj = document.getElementById("file"+flen++);

            if (delete_code)
                obj.innerHTML += delete_code;
        }

        <?=$file_script; //수정시에 필요한 스크립트?>
        </script>

    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<? } ?>

<? if ($is_guest) { ?>
<tr>
    <td class=write_head>
    <script type="text/javascript" src="<?="$g4[path]/zmSpamFree/zmspamfree.js"?>"></script>
    <img id="zsfImg">
    </td>
    <td><input class='ed' type=input size=10 name=wr_key id=wr_key itemname="자동등록방지" required >&nbsp;&nbsp;왼쪽의 글자를 입력하세요.</td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<tr><td colspan=2 height=2 bgcolor="#0A7299"></td></tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="100%" align="center" valign="top" style="padding-top:30px;">
        <input type=image id="btn_submit" src="<?=$board_skin_path?>/img/btn_write.gif" border=0 accesskey='s'>&nbsp;
        <a href="./board.php?bo_table=<?=$bo_table?>"><img id="btn_list" src="<?=$board_skin_path?>/img/btn_list.gif" border=0></a></td>
</tr>
</table>

</td></tr></table>
</form>

<script type="text/javascript">

<?
// 관리자라면 분류 선택에 '공지' 옵션을 추가함
if ($is_admin) 
{
    echo "
    if (typeof(document.fwrite.ca_name) != 'undefined')
    {
        document.fwrite.ca_name.options.length += 1;
        document.fwrite.ca_name.options[document.fwrite.ca_name.options.length-1].value = '공지';
        document.fwrite.ca_name.options[document.fwrite.ca_name.options.length-1].text = '공지';
    }";
} 
?>

with (document.fwrite) {
    if (typeof(wr_name) != "undefined")
        wr_name.focus();
    else if (typeof(wr_subject) != "undefined")
        wr_subject.focus();
    else if (typeof(wr_content) != "undefined")
        wr_content.focus();

    if (typeof(ca_name) != "undefined") {
        if (w.value == "u")
            ca_name.value = "<?=$write[ca_name]?>";
        if (w.value == "r")
            ca_name.value = "<?=$write[ca_name]?>"; 
    }
}

function html_auto_br(obj) {
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f) {
    /*
    var s = "";
    if (s = word_filter_check(f.wr_subject.value)) {
        alert("제목에 금지단어('"+s+"')가 포함되어있습니다");
        return false;
    }

    if (s = word_filter_check(f.wr_content.value)) {
        alert("내용에 금지단어('"+s+"')가 포함되어있습니다");
        return false;
    }
    */

    if (document.getElementById('char_count')) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(document.getElementById('char_count').innerHTML);
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            } 
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?
    if ($is_dhtml_editor) echo cheditor3('wr_content'); 
    if ($is_dhtml_editor) echo cheditor4('wr_content'); 
    ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: "<?=$g4[bbs_path]?>/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined") 
            ed_wr_content.returnFalse();
        else 
            f.wr_content.focus();
        return false;
    }

    if (typeof(f.wr_key) != 'undefined') {
        if (!checkFrm()) {
            alert ("스팸방지코드(Captcha Code)가 틀렸습니다. 다시 입력해 주세요.");
            return false;
        }
    }

    document.getElementById('btn_submit').disabled = true;
    document.getElementById('btn_list').disabled = true;

    <?
    if ($g4[https_url])
        echo "f.action = '$g4[https_url]/$g4[bbs]/write_update.php';";
    else
        echo "f.action = './write_update.php';";
    ?>
    
    return true;
}

function end_date(day)
{
    var wr_1 = document.getElementById("wr_1");
    var wr_2 = document.getElementById("wr_2");

    if (typeof(wr_1) == 'undefined') {
        alert('경매시작일시를 먼저 지정하세요');
        return false;
    }

    var tmp = wr_1.value.split(" ");

    if (typeof(tmp[0]) == 'undefined' || typeof(tmp[1]) == 'undefined') {
        alert('경매시작일시를 먼저 지정하세요');
        return false;
    }

    var date = tmp[0].split("-");
    var time = tmp[1].split(":");

    var yyyy = date[0];
    var mm = --date[1];
    var dd = Number(date[2]) + Number(day);

    var hh = time[0];
    var ii = time[1];

    oDate = new Date(yyyy, mm, dd)

    yyyy = oDate.getFullYear();
    mm = oDate.getMonth() + 1;
    dd = oDate.getDate();

    if (String(mm).length == 1) mm = "0" + mm;
    if (String(dd).length == 1) dd = "0" + dd;

    wr_2.value = yyyy + "-" + mm + "-" + dd + " " + hh + ":" + ii;
}

</script>

<script type="text/javascript">
// 업로드한 이미지 정보를 리턴 받는 예제입니다.
function showImageInfo() {
    var data = ed_wr_content.getImages();
    if (data == null) {
        return 0;
    }

    var img_sum = 0;
    for (var i=0; i<data.length; i++) {
        img_sum += parseInt(data[i].fileSize);
    }
}

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script language="JavaScript">
window.onload=function() {
    drawFont();
}
</script>
