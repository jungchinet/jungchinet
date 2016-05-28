<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($is_dhtml_editor) {
    include_once("$g4[path]/lib/cheditor4.lib.php");
    echo "<script type='text/javascript' src='$g4[cheditor4_path]/cheditor.js'></script>";
    echo cheditor1('wr_content', '100%', '250px');
}

// 스킨에서 사용하는 lib 읽어들이기
include_once("$g4[path]/lib/write.skin.lib.php");

// 설정값이 없으면 초기화 시켜 버립니다 ----------------------------------------------

// 질답에 필요한 최소 포인트
if (!$board[bo_1]) {
    sql_query(" update $g4[board_table] set bo_1 = '$board[bo_write_point]', bo_1_subj = '답에 필요한 최소 포인트' where bo_table = '$bo_table' ");
    $board[bo_1] = $board[bo_write_point];
}
// 가입며칠후부터 질문할 수 있는지
if (!$board[bo_2] || $board[bo_2] < 0) {
    sql_query(" update $g4[board_table] set bo_2 = '3', bo_2_subj = '가입며칠후부터 질문가능' where bo_table = '$bo_table' ");
    $board[bo_2] = 3;
}
// 채택된 사람에게 포인트를 지급하는 비율
if (!$board[bo_3] || $board[bo_3] < 0) {
    sql_query(" update $g4[board_table] set bo_3 = '0.9', bo_3_subj = '채택자에게 지급하는 포인트비율' where bo_table = '$bo_table' ");
    $board[bo_3] = 0.9;
}
// 며칠동안
if (!$board[bo_5] || $board[bo_5] < 0) {
    sql_query(" update $g4[board_table] set bo_5 = '7', bo_5_subj = '며칠동안' where bo_table = '$bo_table' ");
    $board[bo_5] = 7;
}
// 몇개의 미결 질문이 있으면 질문 못하게 할 것인지
if (!$board[bo_4] || $board[bo_4] < 0) {
    sql_query(" update $g4[board_table] set bo_4 = '3', bo_4_subj = '몇개의 미결질문을 허용' where bo_table = '$bo_table' ");
    $board[bo_4] = 3;
}

//불친절하신 서기님의 가입후 몇일후에 글작성하기 이며 게시판 환경설정의 여분필드 bo_2 에 원하는 날짜를 입력함
$wtime = date("Y-m-d", $g4[server_time] - ($board[bo_2] * 86400)); 
$jtime = $member[mb_datetime]; 
if ($jtime >= $wtime ) { 
  alert("이게시판은 가입후 $board[bo_2] 일이 지나야 글을 작성할수 있습니다.","./board.php?bo_table=$bo_table"); 
} 

// 현재의 포인트가 등록게시판의 최소 포인트보다 작으면 등록할 수 없슴
if ($board[bo_1] > $member[mb_point])
  alert("이게시판은 최소 $board[bo_1] 포인트가 있어야 글을 작성할수 있습니다.","./board.php?bo_table=$bo_table"); 


if ($w=='') {
    // 원글에서만 미해결된 질문을 얻는다
    $sql = " select count(*) as cnt from $write_table 
              where mb_id = '$member[mb_id]' 
                and wr_2 = '' 
                and wr_is_comment = 0
                and wr_datetime > '" . date("Y-m-d H:i:s", $g4[server_time] - (86400 * $board[bo_5])) . "' ";

    $row = sql_fetch($sql);

    if ($row[cnt] > $board[bo_4]) {
        alert("올리신 질문중에 아직 채택하지 않은 질문이 $row[tmp]건 있어 글을 등록 할 수 없습니다.\\n\\n미해결된 질문. 즉 채택되지 않은 질문은 $board[bo_5]일 동안 최대 $board[bo_4]건까지 가능 합니다.\\n\\n미해결된 질문을 채택하거나 삭제한 후 다시 올리시기 바랍니다.", 
            "$g4[bbs_path]/board.php?bo_table=$bo_table&sca=&sfl=mb_id,1&stx=$member[mb_id]");
    }
}
                           
if ($w != 'u') $content = '';
?>

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

<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0><tr><td>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<colgroup width=100>
<colgroup width=''>
<tr><td colspan=2 height=2 bgcolor="#0A7299"></td></tr>
<tr><td style='padding-left:20px' colspan=2 height=38 bgcolor="#FBFBFB"><strong><?=$title_msg?></strong></td></tr>
<tr><td colspan="2" style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x; height:3px;"></td></tr>
<? if ($is_name) { ?>
<tr>
    <td style='padding-left:20px; height:30px;'>· 이름</td>
    <td><input class='field_pub_01' maxlength=20 size=15 name=wr_name itemname="이름" required value="<?=$name?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_password) { ?>
<tr>
    <td style='padding-left:20px; height:30px;'>· 패스워드</td>
    <td><input class='field_pub_01' type=password maxlength=20 size=15 name=wr_password itemname="패스워드" <?=$password_required?>></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_email) { ?>
<tr>
    <td style='padding-left:20px; height:30px;'>· 이메일</td>
    <td><input class='field_pub_01' maxlength=100 size=50 name=wr_email email itemname="이메일" value="<?=$email?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_homepage) { ?>
<tr>
    <td style='padding-left:20px; height:30px;'>· 홈페이지</td>
    <td><input class='field_pub_01' size=50 name=wr_homepage itemname="홈페이지" value="<?=$homepage?>"></td></tr>
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
    <td style='padding-left:20px; height:30px;'>· 분류</td>
    <td><select name=ca_name required itemname="분류"><option value="">선택하세요<?=$category_option?></select></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<tr>
    <td style='padding-left:20px; height:30px;'>· 제목</td>
    <td><input class="field_pub_01" style="width:100%;" name=wr_subject id="wr_subject" itemname="제목" required value="<?=$subject?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<tr>
    <td style='padding-left:20px;'>· 내용</td>
    <td style='padding:5 0 5 0;'>
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

<? if ($board[bo_1]) { ?>
<tr>
    <td style='padding-left:20px; height:30px;'>· 포인트걸기</td>
    <td><input class=ed size=5 maxlength=5 name=wr_1 required numeric itemname="포인트걸기" value="<?=$write[wr_1]?>" <?=$w=='u'?'readonly':'';?>>
    포인트 (현재 회원님의 포인트 <?=number_format($member[mb_point])?>점, 걸어야 하는 최저 포인트 <?=number_format($board[bo_1])?>점)</td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } else { ?>
    <input type=hidden name=wr_1 value="0">
<? } ?>

<? if ($board[bo_ccl]) {
// CCL 정보
$view[wr_ccl] = $write[wr_ccl] = mw_get_ccl_info($write[wr_ccl]);
?>
<tr>
    <td style='padding-left:20px;'>· CCL</td>
    <td style='padding:5 0 5 0;'>
        <select name="wr_ccl_by"><option value="by">사용</option><option value="">사용안함</option></select>
        영리목적 : <select name="wr_ccl_nc"><option value="nc">사용불가</option><option value="">사용가능</option></select>
        변경 : <select name="wr_ccl_nd"><option value="nd">변경불가</option><option value="sa">동일조건변경가능</option><option value="">변경가능</option></select>
        <a href="http://www.creativecommons.or.kr/info/about" target=_blank>CCL이란?</a>
        <? if ($w == "u") {?>
        <script type="text/javascript">
        document.fwrite.wr_ccl_by.value = "<?=$write[wr_ccl][by]?>";
        document.fwrite.wr_ccl_nc.value = "<?=$write[wr_ccl][nc]?>";
        document.fwrite.wr_ccl_nd.value = "<?=$write[wr_ccl][nd]?>";
        </script>
        <? } ?>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($board[bo_related]) { ?>
<tr>
    <td>· 관련글 키워드</td>
    <td height=50>
        <input type="text" size=50 name="wr_related" itemname="관련글 키워드" value="<?=$write[wr_related]?>"> (예 : 키워드1, 키워드2, 키워드3)
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_link) { ?>
<? for ($i=1; $i<=$g4[link_count]; $i++) { ?>
<tr>
    <td style='padding-left:20px; height:30px;'>· 링크 #<?=$i?></td>
    <td><input type='text' class='field_pub_01' size=50 name='wr_link<?=$i?>' itemname='링크 #<?=$i?>' value='<?=$write["wr_link{$i}"]?>'></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>
<? } ?>

<? if ($is_file) { ?>
<tr>
    <td style='padding-left:20px; height:30px;' valign=top><table cellpadding=0 cellspacing=0><tr><td style=" padding-top: 10px;">· 파일 <span onclick="add_file();" style='cursor:pointer; font-family:tahoma; font-size:12pt;'>+</span> <span onclick="del_file();" style='cursor:pointer; font-family:tahoma; font-size:12pt;'>-</span></td></tr></table></td>
    <td style='padding:5 0 5 0;'><table id="variableFiles" cellpadding=0 cellspacing=0></table><?// print_r2($file); ?>
        <script language="JavaScript">
        var flen = 0;
        function add_file(delete_code)
        {
            var upload_count = <?=(int)$board[bo_upload_count]?>;
            if (upload_count && flen >= upload_count)
            {
                alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
                return;
            }

            var objTbl;
            var objRow;
            var objCell;
            if (document.getElementById)
                objTbl = document.getElementById("variableFiles");
            else
                objTbl = document.all["variableFiles"];

            objRow = objTbl.insertRow(objTbl.rows.length);
            objCell = objRow.insertCell(0);

            objCell.innerHTML = "<input type='file' class='field_pub_01' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'>";
            if (delete_code)
                objCell.innerHTML += delete_code;
            else
            {
                <? if ($is_file_content) { ?>
                objCell.innerHTML += "<br><input type='text' class='field_pub_01' size=50 name='bf_content[]' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'> 파일의 내용을 입력하세요.";
                <? } ?>
                ;
            }

            flen++;
        }

        <?=$file_script; //수정시에 필요한 스크립트?>

        function del_file()
        {
            // file_length 이하로는 필드가 삭제되지 않아야 합니다.
            var file_length = <?=(int)$file_length?>;
            var objTbl = document.getElementById("variableFiles");
            if (objTbl.rows.length - 1 > file_length)
            {
                objTbl.deleteRow(objTbl.rows.length - 1);
                flen--;
            }
        }
        </script></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_guest) { ?>
<tr>
    <td  class=write_head>
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
        <a href="./board.php?bo_table=<?=$bo_table?>&page=<?=$page?>"><img id="btn_list" src="<?=$board_skin_path?>/img/btn_list.gif" border=0></a></td>
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
</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script language="JavaScript">
window.onload=function() {
    drawFont();
}
</script>
