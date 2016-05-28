<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if (!$board[bo_1]) {
    //alert("게시판 설정 : 여분 필드 1 에 목록에서 보여질 이미지의 폭(높이)을 설정하십시오. (픽셀 단위)");
    $board[bo_1] = "550";
    $sql = " update $g4[board_table] set bo_1_subj = 'view 폭', bo_1 = '$board[bo_1]' where bo_table = '$bo_table' ";
    sql_query($sql);
}

if (!$board[bo_2]) {
    $board[bo_2] = "130x70";
    $sql = " update $g4[board_table] set bo_2_subj = '리스트 썸네일 폭x높이', bo_2 = '$board[bo_2]' where bo_table = '$bo_table' ";
    sql_query($sql);
}

list($img2_width, $img2_height) = explode("x", $board[bo_2]);

$mod = $board[bo_gallery_cols];
$td_width = (int)(100 / $mod);

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;
if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>

// 불당썸을 include
include_once("$g4[path]/lib/thumb.lib.php");
?>

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0><tr><td>

<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr height="25">
    <? if ($is_category) { ?>
    <form name="fcategory" method="get"><td width="50%">
    <select name=sca onchange="location='<?=$category_location?>'+<?=strtolower($g4[charset])=='utf-8' ? "encodeURIComponent(this.value)" : "this.value"?>;">
    <option value=''>전체</option><?=$category_option?></select>
    </td></form>
    <? } ?>
    <?=subject_sort_link('wr_good', $qstr2, 1)?>추천순</a>
    |
    <?=subject_sort_link('wr_hit', $qstr2, 1)?>조회순</a>
    |
    <?=subject_sort_link('wr_comment', $qstr2, 1)?>코멘트순</a>
    <? if ($is_checkbox) { ?> <input onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox><?}?>
    </td></form>
    <td align="right">
        게시물 <?=number_format($total_count)?>건 
        <? if ($rss_href) { ?><a href='<?=$rss_href?>'><img src='<?=$board_skin_path?>/img/btn_rss.gif' border=0 align=absmiddle></a><?}?>
        <? if ($admin_href) { ?><a href="<?=$admin_href?>"><img src="<?=$board_skin_path?>/img/admin_button.gif" title="관리자" width="63" height="22" border="0" align="absmiddle"></a><?}?></td>
</tr>
<tr><td height=5></td></tr>
</table>

<form name="fboardlist" method="post" style="margin:0px;">
<input type="hidden" name="bo_table" value="<?=$bo_table?>">
<input type="hidden" name="sfl"  value="<?=$sfl?>">
<input type="hidden" name="stx"  value="<?=$stx?>">
<input type="hidden" name="spt"  value="<?=$spt?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="sw"   value="">
<table width=100% cellpadding=0 cellspacing=0>
<tr><td colspan='<?=$mod?>' height=2 bgcolor=#B0ADF5></td></tr>
<tr> 
<? 
for ($i=0; $i<count($list); $i++) { 
    if ($i && $i%$mod==0)
        echo "</tr><tr>";

    // 이미지가 있으면 썸을 생성, 아니면 pass~!
    if ($list[$i][file][0][file]) 
    {
        $file = $list[$i][file][0][path] .'/'. $list[$i][file][0][file];

        if (function_exists('exif_read_data') && !$list[$i][wr_10]) {
            $exif = @exif_read_data($file);

        if ($exif) {
            $sql = " update $write_table set wr_10 = '$exif[Model]' where wr_id = '{$list[$i][wr_id]}' ";
            sql_query($sql);
        }
        else
            $exif = " ";
    }

    $img = "<div style='width:{$img2_width}px; border:1px solid #cccccc;background:#EEEEEE;padding:4px;'><a href=\"{$list[$i][href]}\"><img src='" . thumbnail($file,$img2_width,$img2_height) . "' border=0></a></div>";
    }
    else
    {
    $img = "<div style='width:{$img2_width}px; height:{$img2_height}px; border:1px solid #FFFFFF;background:#FFFFFF;padding:4px;'></div>";
    }
    
    $style = "";
    if ($list[$i][icon_new]) $style = " style='font-weight:bold;' ";
    $subject = "<span $style>".cut_str($list[$i][subject],20)."</span>";

    $comment_cnt = "";
    if ($list[$i][comment_cnt]) 
        $comment_cnt = " <a href=\"{$list[$i][comment_href]}\"><span class='commentFont'>{$list[$i][comment_cnt]}</span></a>";

    $list[$i][name] = preg_replace("/<img /", "<img style='display:none;' ", $list[$i][name]);
    $list[$i][name] = preg_replace("/> <span/", "><span", $list[$i][name]);
    $list[$i][name] = preg_replace("/class='member'/", "", $list[$i][name]);

    //echo "<td width='{$td_width}%' valign=bottom style='word-break:break-all;padding-left:10px;padding-right:10px;'>";
    echo "<td width='{$td_width}%' valign=bottom style='word-break:break-all;padding:0 10 0 10px;'>";
    echo "<table align=center>";
    echo "<tr><td height=5></td></tr>";
    echo "<tr><td align=center><a href='{$list[$i][href]}'>$img</a></td></tr>";
    echo "<tr><td align=center class=lh>";
    if ($is_category) echo "<nobr style='display:block;overflow:hidden;width:145px;'><span class=small><a href='{$list[$i][ca_name_href]}'>[{$list[$i][ca_name]}]</a></span> ";
    echo "<a href='{$list[$i][href]}'>$subject</a>{$comment_cnt}</nobr>";
    /*
    echo "<span class=small><font color=gray>";
    echo "<span class='lsm'><a href='$g4[bbs_path]/board.php?bo_table=$bo_table&sca=$sca&sfl=wr_10&stx=$exif[Model]&sop=and'>";
    echo "$exif[Model]</a></span>";
    echo "<br><span class='lsm'>촬영 : $exif[DateTimeOriginal]</span>";
    echo "<br>조회 ({$list[$i][wr_hit]}) / 추천 ({$list[$i][wr_good]})";
    echo "</font></span>";
    */
    echo "</td></tr>";
    if ($is_category) echo "<tr><td align=center><span class=small></span></td></tr>";
    echo "<tr><td align=center><span class=small>{$list[$i][name]}</span></td></tr>";
    if ($is_checkbox) echo "<tr><td align=center><input type=checkbox name=chk_wr_id[] value='{$list[$i][wr_id]}'></td></tr>";
    echo "<tr><td height=10></td></tr>";
    echo "</table></td>\n";
}

// 나머지 td
$cnt = $i%$mod;
if ($cnt)
    for ($i=$cnt; $i<$mod; $i++)
        echo "<td width='{$td_width}%'>&nbsp;</td>";
?>
</tr>
<tr><td colspan=<?=$mod?> height=1 bgcolor=#E7E7E7></td></tr>

<? if (count($list) == 0) { echo "<tr><td colspan='$mod' height=100 align=center>게시물이 없습니다.</td></tr>"; } ?>
<tr><td colspan=<?=$mod?> bgcolor=#5C86AD height=1>
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
        $write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "<b><font style=\"font-family:돋움; font-size:9pt; color:#797979\">$1</font></b>", $write_pages);
        $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><font style=\"font-family:돋움; font-size:9pt; color:orange;\">$1</font></b>", $write_pages);
        ?>
        <?=$write_pages?>
        <? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/btn_search_next.gif' border=0 align=absmiddle title='다음검색'></a>"; } ?>
    </td>
</tr>
</table>

<!-- 버튼 링크 -->
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
            <option value='mb_id'>회원아이디</option>
            <option value='wr_name'>이름</option>
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
if ("<?=$sca?>") document.fcategory.sca.value = "<?=$sca?>";
if ("<?=$stx?>") {
    document.fsearch.sfl.value = "<?=$sfl?>";
    document.fsearch.sop.value = "<?=$sop?>";
}
</script>

<? if ($is_checkbox) { ?>
<script language="JavaScript">
function all_checked(sw)
{
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str)
{
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
function select_delete()
{
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
function select_copy(sw)
{
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";
                       
    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=396, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<? } ?>
<!-- 게시판 목록 끝 -->
