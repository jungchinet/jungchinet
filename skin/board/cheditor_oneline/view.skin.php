<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<!-- 게시글 보기 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td>

<!-- 링크 버튼 -->
<? 
ob_start(); 
?>
<table width='100%' cellpadding=0 cellspacing=0>
<tr height=35>
    <td width=75%>
        <? if ($search_href) { echo "<a href=\"$search_href\"><img src='$board_skin_path/img/btn_search_list.gif' border='0' align='absmiddle'></a> "; } ?>
        <? echo "<a href=\"$list_href\"><img src='$board_skin_path/img/btn_list.gif' border='0' align='absmiddle'></a> "; ?>

        <? if ($write_href) { echo "<a href=\"$write_href\"><img src='$board_skin_path/img/btn_write.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($reply_href) { echo "<a href=\"$reply_href\"><img src='$board_skin_path/img/btn_reply.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($update_href) { echo "<a href=\"$update_href\"><img src='$board_skin_path/img/btn_modify.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($delete_href) { echo "<a href=\"$delete_href\"><img src='$board_skin_path/img/btn_del.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($good_href) { echo "<a href=\"$good_href\" target='hiddenframe'><img src='$board_skin_path/img/btn_good.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($nogood_href) { echo "<a href=\"$nogood_href\" target='hiddenframe'><img src='$board_skin_path/img/btn_nogood.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($scrap_href) { echo "<a href=\"javascript:;\" onclick=\"win_scrap('$scrap_href');\"><img src='$board_skin_path/img/btn_scrap.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($copy_href) { echo "<a href=\"$copy_href\"><img src='$board_skin_path/img/btn_copy.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($move_href) { echo "<a href=\"$move_href\"><img src='$board_skin_path/img/btn_move.gif' border='0' align='absmiddle'></a> "; } ?>
    </td>
    <td width=25% align=right>
        <? if ($prev_href) { echo "<a href=\"$prev_href\" title=\"$prev_wr_subject\"><img src='$board_skin_path/img/btn_prev.gif' border='0' align='absmiddle'></a>&nbsp;"; } ?>
        <? if ($next_href) { echo "<a href=\"$next_href\" title=\"$next_wr_subject\"><img src='$board_skin_path/img/btn_next.gif' border='0' align='absmiddle'></a>&nbsp;"; } ?>
    </td>
</tr>
</table>
<?
$link_buttons = ob_get_contents();
ob_end_flush();
?>

<!-- 제목, 글쓴이, 날짜, 조회, 추천, 비추천 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td height=2 bgcolor="#0A7299"></td></tr> 
<tr><td height=30 style="padding:5px 0 5px 0;">
    <table width=100% cellpadding=0 cellspacing=0>
    <tr>
    	<td style='word-break:break-all; height:28px;'>&nbsp;&nbsp;<strong><span id="writeSubject"><? if ($is_category) { echo ($category_name ? "[$view[ca_name]] " : ""); } ?><?=cut_hangul_last(get_text($view[wr_subject]))?></span></strong></td>
    	<td width=70><a href="javascript:scaleFont(+1);"><img src='<?=$board_skin_path?>/img/icon_zoomin.gif' border=0 title='글자 확대'></a> 
            <a href="javascript:scaleFont(-1);"><img src='<?=$board_skin_path?>/img/icon_zoomout.gif' border=0 title='글자 축소'></a></td>
    </tr>
	<tr><td colspan="2" height=3 style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x;"></td></tr>
    </table></td></tr>
<tr><td height=30>&nbsp;&nbsp;<font style="font:normal 11px 돋움; color:#BABABA;">글쓴이 :</font> <?=$view[name]?><? if ($is_ip_view) { echo "&nbsp;($ip)"; } ?>&nbsp;&nbsp;&nbsp;&nbsp;
    <font style="font:normal 11px 돋움; color:#BABABA;">날짜 :</font><font style="font:normal 11px tahoma; color:#BABABA;"> <?=substr($view[wr_datetime],2,14)?>&nbsp;&nbsp;&nbsp;&nbsp;</font>
    <font style="font:normal 11px 돋움; color:#BABABA;">조회 :</font><font style="font:normal 11px tahoma; color:#BABABA;"> <?=$view[wr_hit]?>&nbsp;&nbsp;&nbsp;&nbsp;</font>
    <? if ($is_good) { ?><font style="font:normal 11px 돋움; color:#BABABA;">추천</font> :<font style="font:normal 11px tahoma; color:#BABABA;"> <?=$view[wr_good]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?></font>
    <? if ($is_nogood) { ?><font style="font:normal 11px 돋움; color:#BABABA;">비추천</font> :<font style="font:normal 11px tahoma; color:#BABABA;"> <?=$view[wr_nogood]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?></font>
    </td>
</tr>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>

<?
// 가변 파일
$cnt = 0;
for ($i=0; $i<count($view[file]); $i++) {
    if ($view[file][$i][source] && !$view[file][$i][view]) {
        $cnt++;
        //echo "<tr><td height=22>&nbsp;&nbsp;<img src='{$board_skin_path}/img/icon_file.gif' align=absmiddle> <a href='{$view[file][$i][href]}' title='{$view[file][$i][content]}'><strong>{$view[file][$i][source]}</strong> ({$view[file][$i][size]}), Down : {$view[file][$i][download]}, {$view[file][$i][datetime]}</a></td></tr>";
        echo "<tr><td height=30>&nbsp;&nbsp;<img src='{$board_skin_path}/img/icon_file.gif' align=absmiddle> <a href=\"javascript:file_download('{$view[file][$i][href]}', '{$view[file][$i][source]}');\" title='{$view[file][$i][content]}'><font style='normal 11px 돋움;'>{$view[file][$i][source]} ({$view[file][$i][size]}), Down : {$view[file][$i][download]}, {$view[file][$i][datetime]}</font></a></td></tr><tr><td height='1'  bgcolor='#E7E7E7'></td></tr>";
    }
}

// 링크
$cnt = 0;
for ($i=1; $i<=$g4[link_count]; $i++) {
    if ($view[link][$i]) {
        $cnt++;
        $link = cut_str($view[link][$i], 70);
        echo "<tr><td height=30>&nbsp;&nbsp;<img src='{$board_skin_path}/img/icon_link.gif' align=absmiddle> <a href='{$view[link_href][$i]}' target=_blank><font  style='normal 11px 돋움;'>{$link} ({$view[link_hit][$i]})</font></a></td></tr><tr><td height='1' bgcolor='#E7E7E7'></td></tr>";
    }
}
?>

<!-- <tr><td height=1 bgcolor=#"E7E7E7"></td></tr> //-->
<tr> 
    <td height="150" style='word-break:break-all;padding:10px;'>
        <? 
        // 파일 출력
        for ($i=0; $i<=count($view[file]); $i++) {
            if ($view[file][$i][view]) 
                echo $view[file][$i][view] . "<p>";
        }
        ?>

        <!-- 내용 출력 -->
        <span id="writeContents" class="ct lh"><?=$view[content];?></span>
        
        <?//echo $view[rich_content]; // {이미지:0} 과 같은 코드를 사용할 경우?>
        <!-- 테러 태그 방지용 --></xml></xmp><a href=""></a><a href=''></a>
        
</td>
</tr>
<tr><td height="1" bgcolor="#E7E7E7"></td></tr>
        <? if ($is_signature) { echo "<tr><td align='center' style='border-bottom:1px solid #E7E7E7; padding:5px 0;'>$signature</td></tr>"; } // 서명 출력 ?>

</table><br>

<?
// 코멘트 입출력
include_once("./view_comment.php");
?>

<?=$link_buttons?>

</td></tr></table><br>

<script language="JavaScript">
function file_download(link, file) {
    <? if ($board[bo_download_point] < 0) { ?>if (confirm("'"+file+"' 파일을 다운로드 하시면 포인트가 차감(<?=number_format($board[bo_download_point])?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?"))<?}?>
    document.location.href=link;
}
</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script language="JavaScript">
window.onload=function() {
    resizeBoardImage(<?=(int)$board[bo_image_width]?>);
    drawFont();
}
</script>
<!-- 게시글 보기 끝 -->
