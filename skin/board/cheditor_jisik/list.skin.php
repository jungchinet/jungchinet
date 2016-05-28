<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 8;
//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>
?>

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0><tr><td>

<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr height="25">
    <td><span id="my_menu_add"><? include("$g4[bbs_path]/my_menu_add_script.php");?></span><span id="board_subject">게시판 : <b><?=$board[bo_subject]?></b></span></td>
    <? if ($is_category) { ?>
    <form name="fcategory" method="get"><td width="50%">
    <select name=sca onchange="location='<?=$category_location?>'+<?=strtolower($g4[charset])=='utf-8' ? "encodeURIComponent(this.value)" : "this.value"?>;">
    <option value=''>전체</option><?=$category_option?></select>
    </td></form>
    <? } ?>
    <td align="right" style="font:normal 11px tahoma; color:#BABABA;">
        Total <?=number_format($total_count)?> 
        <? if ($rss_href) { ?><a href='<?=$rss_href?>'><img src='<?=$board_skin_path?>/img/btn_rss.gif' border=0 align=absmiddle></a><?}?>
        <? if ($admin_href) { ?><a href="<?=$admin_href?>"><img src="<?=$board_skin_path?>/img/btn_admin.gif" title="관리자" width="63" height="22" border="0" align="absmiddle"></a><?}?></td>
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
<tr>
    <td height=2 bgcolor="#0A7299"></td>
    <? if ($is_checkbox) { ?><td bgcolor="#0A7299"></td><?}?>
    <td bgcolor="#0A7299"></td>
    <td bgcolor="#A4B510"></td>
    <td bgcolor="#A4B510"></td>
    <td bgcolor="#A4B510"></td>
    <? if ($is_good) { ?><td bgcolor="#A4B510"></td><?}?>
    <? if ($is_good) { ?><td bgcolor="#A4B510"></td><?}?>
    <td bgcolor="#A4B510"></td>
    <td bgcolor="#A4B510"></td>
</tr>
<tr height=28 align=center>
    <td width=50>번호</td>
    <?/* if ($is_category) { ?><td width=70>분류</td><?}*/?>
    <? if ($is_checkbox) { ?><td width=40><INPUT onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox></td><?}?>
    <td>제목</td>
    <td width=110>글쓴이</td>
    <td width=40><?=subject_sort_link('wr_datetime', $qstr2, 1)?>날짜</a></td>
    <td width=50><?=subject_sort_link('wr_hit', $qstr2, 1)?>조회</a></td>
    <?/*?><td width=40 title='마지막 코멘트 쓴 시간'><?=subject_sort_link('wr_last', $qstr2, 1)?>최근</a></td><?*/?>
    <? if ($is_good) { ?><td width=40><?=subject_sort_link('wr_good', $qstr2, 1)?>추천</a></td><?}?>
    <? if ($is_nogood) { ?><td width=40><?=subject_sort_link('wr_nogood', $qstr2, 1)?>비추천</a></td><?}?>
    <td widtH=40>포인트</td>
    <td widtH=50>상태</td>
</tr>
<tr><td colspan=<?=$colspan?> height=3 style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x;"></td></tr>

<!-- 목록 -->
<? for ($i=0; $i<count($list); $i++) { ?>
<tr height=28 align=center> 
    <td>
        <? 
        if ($list[$i][is_notice]) // 공지사항 
            echo "<img src=\"$board_skin_path/img/icon_notice.gif\">";
        else if ($wr_id == $list[$i][wr_id]) // 현재위치
            echo "<span style='font:bold 11px tahoma; color:#E15916;'>{$list[$i][num]}</span>";
        else
            echo "<span style='font:normal 11px tahoma; color:#BABABA;'>{$list[$i][num]}</span>";
        ?></td>
    <?/* if ($is_category) { ?><td><a href="<?=$list[$i][ca_name_href]?>"><span class=small style='color:#BABABA;'><?=$list[$i][ca_name]?></span></a></td><? } */?>
    <? if ($is_checkbox) { ?><td><input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"></td><? } ?>
    <td align=left style='word-break:break-all;'>
        <? 
        echo $nobr_begin;
        echo $list[$i][reply];
        echo $list[$i][icon_reply];
        if ($is_category && $list[$i][ca_name]) { 
            echo "<span class=small><font color=gray>[<a href='{$list[$i][ca_name_href]}'>{$list[$i][ca_name]}</a>]</font></span> ";
        }
        $style = "";
        if ($list[$i][is_notice]) $style .= " style='font-weight:bold;'";
        if ($list[$i][wr_singo]) $style .= " style='color:#B8B8B8;'";
        
        echo "<a href='{$list[$i][href]}' $style>";
        echo $list[$i][subject];
        echo "</a>";

        if ($list[$i][comment_cnt]) 
            echo " <a href=\"{$list[$i][comment_href]}\"><span style='font-family:Tahoma;font-size:10px;color:#EE5A00;'>{$list[$i][comment_cnt]}</span></a>";

        // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
        // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

        echo " " . $list[$i][icon_new];
        echo " " . $list[$i][icon_file];
        echo " " . $list[$i][icon_link];
        echo " " . $list[$i][icon_hot];
        echo " " . $list[$i][icon_secret];
        echo $nobr_end;
        ?></td>
    <td><nobr style='display:block; overflow:hidden; width:105px;'><?=$list[$i][name]?></nobr></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][datetime2]?></span></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_hit]?></span></td>
    <?/*?><td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][last2]?></span></td><?*/?>
    <? if ($is_good) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_good]?></span></td><? } ?>
    <? if ($is_nogood) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_nogood]?></span></td><? } ?>
    <td align=right><?=number_format($list[$i][wr_1])?></td>
    <td class=small>
        <?
        if ($list[$i][wr_2]) {
            echo "<img src='$board_skin_path/img/icon_select.gif' align=absmiddle>";
        } else {
            if ($list[$i][wr_datetime] > '2006-10-17')
                echo "<img src='$board_skin_path/img/icon_standby.gif' align=absmiddle>";
            else
                echo '&nbsp;';
        } 
        ?>
    </td>
</tr>
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
        <? if ($prev_part_href) { echo "<a href='$prev_part_href'><img src='$board_skin_path/img/btn_search_prev.gif' border=0 align=absmiddle title='이전검색'></a>"; } ?>
        <?
        // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
        //echo $write_pages;
        $write_pages = str_replace("처음", "<img src='$board_skin_path/img/begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
        $write_pages = str_replace("이전", "<img src='$board_skin_path/img/prev.gif' border='0' align='absmiddle' title='이전'>", $write_pages);
        $write_pages = str_replace("다음", "<img src='$board_skin_path/img/next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
        $write_pages = str_replace("맨끝", "<img src='$board_skin_path/img/end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
        $write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "<b><font style=\"font-family:tahoma; font-size:11px; color:#000000\">$1</font></b>", $write_pages);
        $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><font style=\"font-family:tahoma; font-size:11px; color:#E15916;\">$1</font></b>", $write_pages);
        ?>
        <?=$write_pages?>
        <? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/btn_search_next.gif' border=0 align=absmiddle title='다음검색'></a>"; } ?>
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
        <? if ($list_href) { ?><a href="<?=$list_href?>"><img src="<?=$board_skin_path?>/img/btn_list.gif" border="0"></a><? } ?>
        <? if ($write_href) { ?><a href="<?=$write_href?>"><img src="<?=$board_skin_path?>/img/btn_write.gif" border="0"></a><? } ?>
        <? if ($is_checkbox) { ?>
            <a href="javascript:select_delete();"><img src="<?=$board_skin_path?>/img/btn_select_delete.gif" border="0"></a>
            <a href="javascript:select_copy('copy');"><img src="<?=$board_skin_path?>/img/btn_select_copy.gif" border="0"></a>
            <a href="javascript:select_copy('move');"><img src="<?=$board_skin_path?>/img/btn_select_move.gif" border="0"></a>
        <? } ?>
    </td>
    <td width="50%" align="right">
        <select name=sfl>
            <option value='wr_subject||wr_content'>제목+내용</option>
            <option value='wr_subject'>제목</option>
            <option value='wr_content'>내용</option>
            <option value='mb_id,1'>회원아이디</option>
            <option value='mb_id,0'>회원아이디(코)</option>
            <option value='wr_name,1'>이름</option>
            <option value='wr_name,0'>이름(코)</option>
        </select><input name=stx maxlength=15 size=10 itemname="검색어" required value='<?=stripslashes($stx)?>'><select name=sop>
            <option value=and>and</option>
            <option value=or>or</option>
        </select>
        <input type=image src="<?=$board_skin_path?>/img/search_btn.gif" border=0 align=absmiddle></td>
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
