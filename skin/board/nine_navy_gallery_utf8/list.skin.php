<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

include_once("$board_skin_path/skin.lib.php");


if (!$board[bo_1]) {
    $board[bo_1] = "160";
    $sql = " update $g4[board_table] set bo_1 = '$board[bo_1]', bo_1_subj = '목록 가로 픽셀' where bo_table = '$bo_table' ";
    sql_query($sql);
}

if (!$board[bo_2]) {
    $board[bo_2] = "100";
    $sql = " update $g4[board_table] set bo_2 = '$board[bo_2]', bo_2_subj = '목록 세로 픽셀' where bo_table = '$bo_table' ";
    sql_query($sql);
}

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
<script type="text/javascript" src="<?=$g4[path]?>/js/b4.common.js"></script>
<link href="<?=$board_skin_path?>/style.css" rel="stylesheet" type="text/css" />

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0">
    <tr>
	    <td>
<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
<div style="float:left;height:22px;">
<? if ($is_category) { ?> 
<? if (!$wr_id) {  ?> 
<?   
    $cnt_bo_1 = $bo_1[0] ? $bo_1[0] : 10; // 한줄당 분류 갯수(현재:10) 
    $cnt = 1; 
    $cnt0 = 0; 
    $bb_s=""; $bb_e=""; 
    $b_s=""; $b_e=""; 
    $arr = explode("|", $board[bo_category_list]); // 구분자가 , 로 되어 있음 
    $str = "&nbsp;<span style='font-family: Tahoma; font-size:10px; color:#D2D2D2;'>|</span>&nbsp;"; 
    for ($i=0; $i<count($arr); $i++) 
        if (trim($arr[$i]))  { 
        if ($sca == $arr[$i]) { $cnt0++; $b_s="<b>"; $b_e="</b>"; } else {$b_s=""; $b_e="";} 
            $str .= " <a href='./board.php?bo_table=$bo_table&sca=".urlencode($arr[$i])."#board'>$b_s$arr[$i]$b_e</a>&nbsp;&nbsp;<span style='font-family: Tahoma; font-size:10px; color:#D2D2D2;'>|</span>&nbsp;"; 

if ($cnt == $cnt_bo_1) { $cnt = 0; $str .= "<br>"; } 
    $cnt++; 
    } 
    if ($cnt0 == 0 ) { $bb_s="<b>"; $bb_e="</b>"; } 
?> 
<?echo "  ";echo $bb_s;?><a href='./board.php?bo_table=<?=$bo_table?>&page=<?=$page?>#board'>전체</a><?=$bb_e?> <span style="font-size:8pt; color=#AEAEAE;">(<?=number_format($total_count)?>)</span>
<?=$str?>
<? } ?> 
<? } ?>
</div>
<div class='bbs_count'>
    <? if ($is_checkbox) { ?><INPUT onclick="if (this.checked) all_checked(true); else all_checked(false);" type='checkbox'><?}?>
    TOTAL <?=number_format($total_count)?> 
    <? if ($rss_href) { ?><a href='<?=$rss_href?>'><img src='<?=$board_skin_path?>/img/btn_rss.gif' border='0' align='absmiddle'></a><?}?>
    <? if ($admin_href) { ?><a href="<?=$admin_href?>"><img src="<?=$board_skin_path?>/img/admin_button.gif" title="관리자" border="0" align="absmiddle"></a><?}?>
</div>

<!-- 목록 -->
    <form name="fboardlist" method="post">
    <input type='hidden' name='bo_table' value='<?=$bo_table?>'>
    <input type='hidden' name='sfl'  value='<?=$sfl?>'>
    <input type='hidden' name='stx'  value='<?=$stx?>'>
    <input type='hidden' name='spt'  value='<?=$spt?>'>
    <input type='hidden' name='page' value='<?=$page?>'>
    <input type='hidden' name='sw'   value=''>

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan=<?=$colspan?> class="bbs_line2"></td>
    </tr>
    <tr> 
    
    
    <? 
    for ($i=0; $i<count($list); $i++)
{
	$e_text = array("(",")"); //괄호 표시
	$list[$i][comment_cnt] = str_replace($e_text, "", $list[$i][comment_cnt]); //괄호 표시 변환으로 삭제

	// 이미지가 있으면 썸을 생성, 아니면 pass~!
    if ($list[$i][file][0][file])
    {
    $file = $list[$i][file][0][path] .'/'. $list[$i][file][0][file];
    $img = "<div style='width:{$img2_width}px; padding:4px;'><a href=\"{$list[$i][href]}#board\"><img src='" . thumbnail($file,$board[bo_1],$board[bo_2],false,1,100) . "' style='border:0px solid #797979;'></a></div>";
    }
    else
    {
    $img = "<div style='width:{$img2_width}px; padding:4px;'><a href=\"{$list[$i][href]}#board\"><img src='../skin/board/nine_navy_gallery_utf8/img/noimage.gif' width='76% 'style='border:0px solid #797979; /></a></div>";
    }

    if ($i && $i%$mod==0)
    echo "</tr><tr><td colspan='{$mod}' height='0' bgcolor='#e8e8e8';\"></td></tr><tr>";

	echo "<td width='{$td_width}%' valign=top style='word-break:break-all;'>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
    echo "<tr><td height=15></td></tr>";
    echo "<tr><td align=center>";
    echo "$img";
    echo "</td></tr>";
    echo "<tr><td align=center style='padding-top:3px;padding-bottom:5px;'><div style='width:150px;'>";
//  if ($is_category) {
// 	echo "<font class='color_category'>[".$list[$i][ca_name]."]</font><br>"; }
    echo "<a href='".$list[$i][href]."#board'>".stripslashes($list[$i][subject])."</a>";
	if ($list[$i][comment_cnt])
    echo " <font style='font:normal 12px Tahoma; color:#ff8700'>{$list[$i][comment_cnt]}</font>";
	echo " " . $list[$i][icon_new];
	echo "</div></td></tr>";
	echo "<tr><td align=center height='20'>";
	echo "<font style='font:normal 13px ; color:#a9a7a7;'>{$list[$i][wr_name]}</font>";
	echo "<br />";
	echo "<font style='font:normal 9px Tahoma; color:#c7c7c7'>{$list[$i][datetime2]}&nbsp; View:{$list[$i][wr_hit]}</font>";

//	echo "<br />";
//  밑에 아이피표시는 그누질문에 답으로 알려준것, 아예 아무것도 안나온다
//	if ($list[$i]['mb_id'] != 'admin') { echo "<span style=\"color:#B2B2B2; font-size:9px;\">{$list[$i][wr_ip]}</span>"; }
//뷰스킨     if ($is_ip_view) { if ($view[mb_id]==$config[cf_admin]){ echo "&nbsp;"; } else { echo "&nbsp;($ip)";} }
//  밑에 아이피표시는 뷰스킨것을 붙인것인데, 리스트에서는 괄호만 나오고, 뷰스킨에서 리스트엔 관리자아이피 일부만 나온다- 리스트에서 글쓴이 아이피 일부만 나오게 고쳐야한다
//뷰스킨수정  if ($is_ip_view) { if ($list[$i][mb_id]==$config[cf_admin]){ echo "&nbsp;"; } else { echo "<span style=\"color:#B2B2B2; font-size:9px;\">&nbsp;($ip)</span>";} }
//뷰코멘트    if ($list[$i]['mb_id'] != 'jungchinet' && $is_ip_view) { echo "&nbsp;<span style=\"color:#B2B2B2; font-size:11px;\">{$list[$i][ip]}</span>"; } 
	
	if ($is_checkbox) {
    echo "<br /><input type=checkbox name=chk_wr_id[] value='".$list[$i][wr_id]."'> "; }
	echo "</td></tr>";

	echo "</table><br></td>\n";

}
// 나머지 td
$cnt = $i%$mod;
if ($cnt)
    for ($i=$cnt; $i<$mod; $i++)
        echo "<td width='{$td_width}%'>&nbsp;</td>";
echo "</tr>";
//echo "<tr><td colspan='{$mod}' height='1' bgcolor=000000 left;\"></td></tr>";

if (count($list) == 0) { echo "<tr><td colspan='$mod' height=100 align=center>게시물이 없습니다.</td></tr>"; }

    ?>
    </tr>
    <? if (count($list) == 0) { echo "<tr><td colspan='$mod' height=400 align=center>게시물이 없습니다.</td></tr>"; } ?>
	<tr><td colspan='<?=$mod?>' height="25"></td></tr>
    <tr><td colspan=<?=$mod?> class='bbs_line'>
    </table>
    </form>

<!-- 페이징 -->
<div class="paginate_complex">
    <? if ($prev_part_href) { echo "<a href='$prev_part_href' class=\"direction prev\">	<span> </span><span> </span> 이전검색</a>"; } ?>
    <?
    // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
    /*
    $write_pages = str_replace("처음", "<img src='$board_skin_path/img/page_begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
    $write_pages = str_replace("이전", "<img src='$board_skin_path/img/page_prev.gif' border='0' align='absmiddle' title='이전'>", $write_pages);
    $write_pages = str_replace("다음", "<img src='$board_skin_path/img/page_next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
    $write_pages = str_replace("맨끝", "<img src='$board_skin_path/img/page_end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
    $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><span style=\"color:#4D6185; font-size:12px; text-decoration:underline;\">$1</span></b>", $write_pages);
    */
    $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<strong>$1</strong>", $write_pages);
    $write_pages = str_replace(">처음", " class=\"direction prev\">	<span> </span><span> </span> ", $write_pages);
    $write_pages = str_replace(">이전", " class=\"direction prev\"><span> </span> ", $write_pages);
    $write_pages = str_replace(">다음", " class=\"direction next\" > <span> </span> ", $write_pages);
    $write_pages = str_replace(">맨끝", " class=\"direction next\" ><span> </span><span> </span> ", $write_pages);
    $write_pages = str_replace("&nbsp;", "", $write_pages);
    ?>
    <?=$write_pages?>
    <? if ($next_part_href) { echo "<a href='$next_part_href'> class=\"direction next\">다음검색 <span> </span><span> </span></a>"; } ?>
</div>

<!-- 검색&버튼 -->
<div style="float:left;">
<table cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
        <form name="fsearch" method="get" style="margin:0px;" action="<?=$_SERVER['REQUEST_URI']?>#board">
        <input type="hidden" name="bo_table" value="<?=$bo_table?>">
        <input type="hidden" name="sca" value="<?=$sca?>">
        <select name="sfl" class="sel">
            <option value="wr_subject">제목</option>
            <option value="wr_content">내용</option>
            <option value="wr_subject||wr_content">제목+내용</option>
            <option value="mb_id,1">아이디</option>
            <option value="mb_id,0">아이디(코)</option>
            <option value="wr_name,1">글쓴이</option>
            <option value="wr_name,0">글쓴이(코)</option>
        </select>		
		</td>
        <td align="left"><input name="stx" class="bbs_search" maxlength="33" itemname="검색어" required value='<?=stripslashes($stx)?>'></td>
        <td><input type=image src="<?=$board_skin_path?>/img/btn_search.gif" border="0" align="absmiddle"></td>
    </tr>
</table>	
</form>
</div>

<div style="float:right;">
    <? if ($is_checkbox) { ?>
    <a href="javascript:select_delete();"><img src="<?=$board_skin_path?>/img/btn_select_delete.gif" border='0'></a><a href="javascript:select_copy('copy');"><img src="<?=$board_skin_path?>/img/btn_select_copy.gif" border='0'></a><a href="javascript:select_copy('move');"><img src="<?=$board_skin_path?>/img/btn_select_move.gif" border='0'></a>
    <? } ?>	
   <!-- <? if ($list_href) { ?><a href="<?=$list_href?>#board"><img src="<?=$board_skin_path?>/img/btn_list.gif" border='0'></a><? } ?>-->
    <? if ($write_href) { ?><a href="<?=$write_href?>#board"><img src="<?=$board_skin_path?>/img/btn_write.gif" border='0'></a><? } ?>
</div>

    </td>
    </tr>
</table>


<script language="JavaScript">
if ("<?=$sca?>") document.fcategory.sca.value = "<?=$sca?>";
if ("<?=$stx?>") {
    document.fsearch.sfl.value = "<?=$sfl?>";
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