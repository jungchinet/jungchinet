<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>
<script>    
function cclickshow(num){
	menu=eval("document.all.cblock"+num+".style");
	menu2=eval("document.all.cblockl"+num+".style");
	if (menu.display=="block"){
		menu.display="none"; //닫고
	} else{
		menu.display="block";//하위메뉴를 펼친다.
	}
	menu2.display="none";
}
</script>

<!-- 게시글 보기 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspcing="0"><tr><td>


<table width="100%" cellspacing="0" cellpadding="0">
<tr><td height=2 bgcolor=#B0ADF5></td></tr> 
<tr><td height=30 bgcolor=#F8F8F9 style="padding:5 0 5 0;">&nbsp;&nbsp;<strong><? if ($is_category) { echo ($category_name ? "[$view[ca_name]] " : ""); } ?><?=$view[subject]?></strong>
&nbsp;&nbsp;<span id=cblockl1><a href="javascript:;" onclick="cclickshow(1)">+</a></span></td></tr>

<tr><td>
<span id=cblock1 style=display:none;cursor:hand;padding-left:0 height=0> 
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td height=30>&nbsp;&nbsp;<font color=#7A8FDB>글쓴이</font> : <?=$view[name]?><? if ($is_ip_view) { echo "&nbsp;($ip)"; } ?>&nbsp;&nbsp;&nbsp;&nbsp;
       <font color=#7A8FDB>날짜</font> : <?=substr($view[wr_datetime],2,14)?>&nbsp;&nbsp;&nbsp;&nbsp;
       <font color=#7A8FDB>조회</font> : <?=$view[wr_hit]?>&nbsp;&nbsp;&nbsp;&nbsp;
       <? if ($is_good) { ?><font color=#7A8FDB>추천</font> : <?=$view[wr_good]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?>
       <? if ($is_nogood) { ?><font color=#7A8FDB>비추천</font> : <?=$view[wr_nogood]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?></td></tr>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>

<? if ($trackback_url) { ?>
<tr><td height=30>&nbsp;&nbsp;트랙백 주소 : <a href="javascript:clipboard_trackback('<?=$trackback_url?>');" style="letter-spacing:0;" title='이 글을 소개할 때는 이 주소를 사용하세요'><?=$trackback_url?></a>
<script language="JavaScript">
function clipboard_trackback(str) 
{
    if (g4_is_gecko)
        prompt("이 글의 고유주소입니다. Ctrl+C를 눌러 복사하세요.", str);
    else if (g4_is_ie) {
        window.clipboardData.setData("Text", str);
        alert("트랙백 주소가 복사되었습니다.\n\n<?=$trackback_url?>");
    }
}
</script></td></tr>
<?}?>
</table>

</span>
</td></tr>


<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr> 
    <td height="150" style='word-break:break-all; padding:10px;'>
        <? 
        // 파일 출력
        for ($i=0; $i<=count($view[file]); $i++) {
            if ($view[file][$i][view]) 
                echo "<table><tr><td>{$view[file][$i][view]}</td></tr><tr><td align=center>{$view[file][$i][content]}</td></tr></table><p>";
        }
        ?>

        <span class="ct lh"><?=$view[content];?></span>
        <?//echo $view[rich_content]; // {이미지:0} 과 같은 코드를 사용할 경우?>
        <!-- 테러 태그 방지용 --></xml></xmp><a href=""></a><a href=''></a>
        
<?
// 가변 파일
$cnt = 0;
for ($i=0; $i<count($view[file]); $i++) 
{
    if ($view[file][$i][source] && !$view[file][$i][view]) 
    {
        $cnt++;
        //echo "<tr><td height=22>&nbsp;&nbsp;<img src='{$board_skin_path}/img/icon_file.gif' align=absmiddle> <a href='{$view[file][$i][href]}' title='{$view[file][$i][content]}'><strong>{$view[file][$i][source]}</strong> ({$view[file][$i][size]}), Down : {$view[file][$i][download]}, {$view[file][$i][datetime]}</a></td></tr>";
        echo "<div style='padding:5'><img src='{$board_skin_path}/img/icon_file.gif' align=absmiddle> <a href=\"javascript:file_download('{$view[file][$i][href]}', '{$view[file][$i][source]}');\" title='{$view[file][$i][content]}'><strong>{$view[file][$i][source]}</strong> ({$view[file][$i][size]}), Down : {$view[file][$i][download]}, {$view[file][$i][datetime]}</a></div>";
    }
}

// 링크
$cnt = 0;
for ($i=1; $i<=$g4[link_count]; $i++) 
{
    if ($view[link][$i]) 
    {
        $cnt++;
        $link = cut_str($view[link][$i], 70);
        echo "<div style='padding:5'><img src='{$board_skin_path}/img/icon_link.gif' align=absmiddle> <a href='{$view[link_href][$i]}' target=_blank><strong>{$link}</strong> ({$view[link_hit][$i]})</a></div>";
    }
}
?>


        <? if ($is_signature) { echo "<br>$signature<br><br>"; } // 서명 출력 ?></td>
</tr>


</table><br>
<?
//include_once("./view_comment.php");
?>

<!-- 링크 버튼 -->
<? 
ob_start(); 
?>
<table width='100%' cellpadding=0 cellspacing=0>
<tr height=35>
    <td width=75%>
        <? if ($search_href) { echo "<a href=\"$search_href\">검색목록</a>&nbsp; "; } ?>
        <? echo "<a href=\"$list_href\">목록으로</a>&nbsp; "; ?>
		<? // 글쓰기, 답변, 수정, 삭제 버튼 숨김 : 변수명 뒤에 _ 붙였음?>
        <? if ($write_href_) { echo "<a href=\"$write_href\">글작성</a>&nbsp; "; } ?>
        <? if ($reply_href_) { echo "<a href=\"$reply_href\">답변</a>&nbsp; "; } ?>

        <? if ($update_href) { echo "<a href=\"$update_href\">수정</a>&nbsp; "; } ?>
        <? if ($delete_href_) { echo "<a href=\"$delete_href\">삭제</a>&nbsp; "; } ?>

        <? if ($good_href) { echo "<a href=\"$good_href\" target='hiddenframe'>추천</a>&nbsp; "; } ?>
        <? if ($nogood_href) { echo "<a href=\"$nogood_href\" target='hiddenframe'>비추천</a>&nbsp; "; } ?>

        <? if ($scrap_href) { echo "<a href=\"javascript:;\" onclick=\"win_scrap('./scrap_popin.php?bo_table=$bo_table&wr_id=$wr_id');\">스크랩</a>&nbsp; "; } ?>

        <? if ($copy_href) { echo "<a href=\"$copy_href\">복사</a>&nbsp; "; } ?>
        <? if ($move_href) { echo "<a href=\"$move_href\">이동</a>&nbsp; "; } ?>
    </td>
    <td width=25% align=right>
        <? if ($prev_href) { echo "<a href=\"$prev_href\" title=\"$prev_wr_subject\">이전글</a>&nbsp;"; } ?>
        <? if ($next_href) { echo "<a href=\"$next_href\" title=\"$next_wr_subject\">다음글</a>&nbsp;"; } ?>
    </td>
</tr>
</table>
<?
$link_buttons = ob_get_contents();
ob_end_flush();
?>


<?=//$link_buttons?>

</td></tr></table><br>

<script language="JavaScript">
// HTML 로 넘어온 <img ... > 태그의 폭이 테이블폭보다 크다면 테이블폭을 적용한다.
function resize_image()
{
    var target = document.getElementsByName('target_resize_image[]');
    var image_width = parseInt('<?=$board[bo_image_width]?>');
    var image_height = 0;

    for(i=0; i<target.length; i++) { 
        // 원래 사이즈를 저장해 놓는다
        target[i].tmp_width  = target[i].width;
        target[i].tmp_height = target[i].height;
        // 이미지 폭이 테이블 폭보다 크다면 테이블폭에 맞춘다
        if(target[i].width > image_width) {
            image_height = parseFloat(target[i].width / target[i].height)
            target[i].width = image_width;
            target[i].height = parseInt(image_width / image_height);
        }
    }
}

window.onload = resize_image;

function file_download(link, file)
{
<? if ($board[bo_download_point] < 0) { ?>if (confirm("'"+file+"' 파일을 다운로드 하시면 포인트가 차감(<?=number_format($board[bo_download_point])?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?"))<?}?>
document.location.href = link;
}
</script>
<!-- 게시글 보기 끝 -->
