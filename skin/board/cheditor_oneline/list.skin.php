<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 이모티콘 적용하기
function emoticon_html($str, $board_skin_path)
{
  if ($str <= 1 or $str > 44) return ""; // 범위를 벗어나거나 기본표정의 경우 출력하지 않음
	$emo_id = "$str";
	$img_src = "<img src='$board_skin_path/emoticons/$str.gif' width=18 height=18 border=0>";
	$str = preg_replace("/{$emo_id}/i", $img_src, $str);
	return $str;
}

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 4;

if ($is_checkbox) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>

// cdn을 사용하려는 경우, 아래 경로에 cdn의 이미지 경로를 넣으면 됩니다.
$board_skin_path1 = $board_skin_path;
?>

<? if (!$member[mb_id] || $member[mb_level] >= $board[bo_write_level] ||($is_admin && $w == 'u' && $member[mb_id] != $write[mb_id]))
      include ("$board_skin_path/write.skin.php"); 
?>

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0><tr><td>

<!-- 게시판 제목, 게시물 몇건, 관리자화면 링크 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr height="25">
    <td align="left">&nbsp;<img src="<?=$board_skin_path1?>/img/icon_home.gif" border=0 align="absmiddle">&nbsp;&nbsp;<b><?=$board[bo_subject]?></b></td>
    <td align="right" style="font:normal 11px tahoma; color:#BABABA;">
        Total <?=number_format($total_count)?> 
        <? if ($admin_href) { ?><a href="<?=$admin_href?>"><img src="<?=$board_skin_path1?>/img/btn_admin.gif" title="관리자" width="63" height="22" border="0" align="absmiddle"></a><?}?></td>
</tr>
<tr><td height=5></td></tr>
</table>

<!-- 제목 -->
<form name="fboardlist" method="post" style="margin:0px;">
<input type='hidden' name='bo_table' value='<?=$bo_table?>'>
<input type='hidden' name='sfl'  value='<?=$sfl?>'>
<input type='hidden' name='stx'  value='<?=$stx?>'>
<input type='hidden' name='spt'  value='<?=$spt?>'>
<input type='hidden' name='page' value='<?=$page?>'>
<input type='hidden' name='sw'   value=''>

<table width=100% border="0" cellpadding=0 cellspacing="2">
<colgroup width=24>
<? if ($is_checkbox) { ?><colgroup width=25><?}?>
<colgroup width=''>
<colgroup width=40>
<colgroup width=80>
<tr>
    <td height=2 bgcolor="#0A7299"></td>
    <? if ($is_checkbox) { ?><td bgcolor="#0A7299"></td><?}?>
    <td bgcolor="#0A7299"></td>
    <td bgcolor="#A4B510"></td>
    <td bgcolor="#A4B510"></td>
</tr>

<!-- 목록 -->
<? for ($i=0; $i<count($list); $i++) { ?>
<tr height=23 align=center> 
    <td>
        <? 
        if ($list[$i][is_notice]) // 공지사항 
            echo "<img src=\"$board_skin_path1/img/icon_notice.gif\">";
        else {
         		$list[$i][subject] = emoticon_html($list[$i][subject], $board_skin_path1);
          
            }
        ?></td>
    <? if ($is_checkbox) { ?><td><input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"></td><? } ?>
    <td align=left style='word-break:break-all;'>
        <? 
        switch ($list[$i][wr_1]) {
            case "1" : $font_color = "#FF0000"; break;
            case "2" : $font_color = "#E9A252"; break;
            case "3" : $font_color = "#C1CE1E"; break;
            case "4" : $font_color = "#2DC501"; break;
            case "5" : $font_color = "#01B6C5"; break;
            case "6" : $font_color = "#8CABEC"; break;
            case "7" : $font_color = "#8000FF"; break;
            default  : $font_color = ""; 
            }
        echo $nobr_begin;

     		$list[$i][wr_content] = conv_content($list[$i][wr_content], 0);

     		echo "<font color='$font_color'>&nbsp;";
     		echo $list[$i][wr_content];
     		echo "</font>";
        echo " " . $list[$i][icon_new];
        echo " " . $list[$i][icon_secret];
        ?>

        <?
		    if (($member[mb_id] && ($member[mb_id] == $list[$i][mb_id])) || $is_admin) {
		    ?>
	          &nbsp;<a href="<?=$write_href?>&w=u&wr_id=<?=$list[$i][wr_id]?>&page=<?=$page?>&sca=<?=$ca_name?>">
  	  			<img src="<?=$board_skin_path1?>/img/btn_edit.gif" alt="수정" border="0" align="absmiddle" title="수정하기"></a>
	          <a href="javascript:if (confirm('삭제하시겠습니까?')) { location='./delete.php?w=d&bo_table=<?=$bo_table?>&wr_id=<?=$list[$i][wr_id]?>&sca=<?=$sca?>';}">
				    <img src="<?=$board_skin_path1?>/img/btn_delete.gif" alt="삭제" border="0" align="absmiddle" title="삭제하기"></a>
        <?
        }

        echo $nobr_end;
        ?></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][datetime2]?></span></td>
    <td><nobr style='display:block; overflow:hidden;'><?=$list[$i][name]?></nobr></td>
</tr>
<!-- 줄 구분 -->
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#E7E7E7></td></tr>
<?}?>

<? if (count($list) == 0) { echo "<tr><td colspan='$colspan' height=100 align=center>게시물이 없습니다.</td></tr>"; } ?>
<tr><td colspan=<?=$colspan?> bgcolor="#0A7299" height="2"></td></tr>
</table>
</form>

<!-- 페이지 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr> 
    <td width="100%" align="center" height=30 valign=bottom>
        <? if ($prev_part_href) { echo "<a href='$prev_part_href'><img src='$board_skin_path1/img/btn_search_prev.gif' border=0 align=absmiddle title='이전검색'></a>"; } ?>
        <?
        // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
        //echo $write_pages;
        $write_pages = str_replace("처음", "<img src='$board_skin_path1/img/begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
        $write_pages = str_replace("이전", "<img src='$board_skin_path1/img/prev.gif' border='0' align='absmiddle' title='이전'>", $write_pages);
        $write_pages = str_replace("다음", "<img src='$board_skin_path1/img/next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
        $write_pages = str_replace("맨끝", "<img src='$board_skin_path1/img/end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
        $write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "<b><font style=\"font-family:tahoma; font-size:11px; color:#000000\">$1</font></b>", $write_pages);
        $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><font style=\"font-family:tahoma; font-size:11px; color:#E15916;\">$1</font></b>", $write_pages);
        ?>
        <?=$write_pages?>
        <? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path1/img/btn_search_next.gif' border=0 align=absmiddle title='다음검색'></a>"; } ?>
    </td>
</tr>
</table>

<!-- 링크 버튼, 검색 -->
<form name=fsearch method=get style="margin:0px;">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=sca      value="<?=$sca?>">
<table width=100% cellpadding=0 cellspacing=0>
<tr> 
    <td width="50%" height="40">
        <? if ($list_href) { ?><a href="<?=$list_href?>"><img src="<?=$board_skin_path1?>/img/btn_list.gif" border="0"></a><? } ?>
        <? if ($is_checkbox) { ?>
            <a href="javascript:select_delete();"><img src="<?=$board_skin_path1?>/img/btn_select_delete.gif" border="0"></a>
            <a href="javascript:select_copy('copy');"><img src="<?=$board_skin_path1?>/img/btn_select_copy.gif" border="0"></a>
            <a href="javascript:select_copy('move');"><img src="<?=$board_skin_path1?>/img/btn_select_move.gif" border="0"></a>
        <? } ?>
    </td>
    <td width="50%" align="right">
        <select name=sfl>
            <option value='wr_content'>내용</option>
            <option value='mb_id,1'>회원아이디</option>
            <option value='wr_name,1'>이름</option>
        </select><input name=stx maxlength=15 size=10 itemname="검색어" required value='<?=stripslashes($stx)?>'><select name=sop>
            <option value=and>and</option>
            <option value=or>or</option>
        </select>
        <input type=image src="<?=$board_skin_path1?>/img/search_btn.gif" border=0 align=absmiddle></td>
</tr>
</table>
</form>

</td></tr></table>

<script language="JavaScript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
    document.fsearch.sop.value = '<?=$sop?>';
}
</script>

<? if ($is_checkbox) { ?>
<script language="JavaScript">
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";
                       
    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<? } ?>
<!-- 게시판 목록 끝 -->
