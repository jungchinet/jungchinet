<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

include_once("$board_skin_path/auction.lib.php");

$info = get_info_auction($wr_id);

// 경매전 -> 시작시간이 지났을 때 -> 경매진행중
if ($info[status] == "0" && $info[start_datetime] <= $g4[time_ymdhis])
{
    sql_query(" update $write_table set wr_8 = '1' where wr_id = '$wr_id' ");
    $info[status] = "1";
}

// 경매진행중 -> 종료시간이 지났을 때 -> 경매종료
if ($info[status] == "1" && $info[end_datetime] <= $g4[time_ymdhis])
{
    $result = auction_successful($wr_id);
    if ($result[wr_8] > 1) {
        $info[tender_count] = $result[wr_7];
        $info[status] = $result[wr_8];
        $info[td_id] = $result[wr_9];
        $info[mb_id] = $result[wr_10];
    }
}

// 낙찰
if ($info[status] == "2")
{
    $success_member = get_member($info[mb_id]);
}

$end_time = strtotime($info[end_datetime])-$g4[server_time];

if ($is_admin) {
    // 명수
    $sql = "select count( distinct mb_id ) as cnt from $tender_table where wr_id = '$wr_id' ";
    $row = sql_fetch($sql);

    $tender_mb_id_count = number_format($row[cnt]);


    // 최저로 입찰된 내역을 조회 (현재 1위)
    $row = sql_fetch(" select td_tender_point as point, count(td_tender_point) as cnt from $tender_table where wr_id = '$wr_id' group by td_tender_point order by cnt, td_tender_point limit 1 ");
    $super = array("point"=>$row[point], "count"=>$row[cnt]);

    $qry = sql_query(" select mb_id from $tender_table where td_tender_point = '$row[point]' and wr_id = '$wr_id' ");
    while ($row = sql_fetch_array($qry))
    {
        $super_mb_id[] = $row[mb_id];
    }
}

// 상품이미지 (중)
$img = "{$view[file][1][path]}/{$view[file][1][file]}";
if (!file_exists($img) or trim($img) == "/")
    $img = "$board_skin_path/img/noimage.gif";

?>

<style type="text/css">
.colon { color:#000; font-weight:normal; margin-right:20px; }
</style>

<!-- 게시글 보기 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td>

<!-- 링크 버튼 -->
<? 
ob_start(); 
?>
<table width='100%' cellpadding=0 cellspacing=0>
<tr height=35>
    <td width=25%>
        <? if ($prev_href) { echo "<a href=\"$prev_href\" title=\"$prev_wr_subject\"><img src='$board_skin_path/img/btn_prev.gif' border='0' align='absmiddle'></a>&nbsp;"; } ?>
        <? if ($next_href) { echo "<a href=\"$next_href\" title=\"$next_wr_subject\"><img src='$board_skin_path/img/btn_next.gif' border='0' align='absmiddle'></a>&nbsp;"; } ?>
    </td>
    <td width=75% align=right>
        <? if ($copy_href) { echo "<a href=\"$copy_href\"><img src='$board_skin_path/img/btn_copy.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($move_href) { echo "<a href=\"$move_href\"><img src='$board_skin_path/img/btn_move.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($search_href) { echo "<a href=\"$search_href\"><img src='$board_skin_path/img/btn_list_search.gif' border='0' align='absmiddle'></a> "; } ?>
        <? echo "<a href=\"$list_href\"><img src='$board_skin_path/img/btn_list.gif' border='0' align='absmiddle'></a> "; ?>

        <? if ($update_href) { echo "<a href=\"$update_href\"><img src='$board_skin_path/img/btn_modify.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($delete_href) { echo "<a href=\"$delete_href\"><img src='$board_skin_path/img/btn_delete.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($good_href) { echo "<a href=\"$good_href\" target='hiddenframe'><img src='$board_skin_path/img/btn_good.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($nogood_href) { echo "<a href=\"$nogood_href\" target='hiddenframe'><img src='$board_skin_path/img/btn_nogood.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($scrap_href) { echo "<a href=\"javascript:;\" onclick=\"win_scrap('$scrap_href');\"><img src='$board_skin_path/img/btn_scrap.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($reply_href) { echo "<a href=\"$reply_href\"><img src='$board_skin_path/img/btn_reply.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($write_href) { echo "<a href=\"$write_href\"><img src='$board_skin_path/img/btn_write.gif' border='0' align='absmiddle'></a> "; } ?>
        
        <? if ($singo_href) { ?><span style="float:right;padding-right:5px;"><a href="javascript:win_singo('<?=$singo_href?>');"><img src='<?=$board_skin_path?>/img/icon_singo.gif'></a></span><?}?>
        <? if ($unsingo_href) { ?><span style="float:right;padding-right:5px;"><a href="javascript:win_unsingo('<?=$unsingo_href?>');"><img src='<?=$board_skin_path?>/img/icon_unsingo.gif'></a></span><?}?>

        <? if ($nosecret_href) { echo "<a href=\"$nosecret_href\"><img src='$board_skin_path/img/btn_nosecret.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($secret_href) { echo "<a href=\"$secret_href\"><img src='$board_skin_path/img/btn_secret.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($now_href) { echo "<a href=\"$now_href\"><img src='$board_skin_path/img/btn_now.gif' border='0' align='absmiddle'></a> "; } ?>
    </td>
</tr>
</table>
<?
$link_buttons = ob_get_contents();
ob_end_flush();
?>

<table border=0 cellpadding=0 cellspacing=0 width=100% height=4>
<tr>
    <td background="<?=$board_skin_path?>/img/top_line_1.gif" width="30%"></td>
    <td background="<?=$board_skin_path?>/img/top_line_2.gif" width="70%"></td>
</tr>
</table>

<div style="clear:both; height:35px; line-height:31px; font-size:15px; font-family:dotum; color:#898989; font-weight:bold; padding-left:10px;">

    <div style="padding-top:2px; float:left;">
    <?=$info[company]?> 
    <? if ($is_admin) echo "<span style=\"color:#888; font-size:11px; font-weight:normal;\">(hit : {$view[link_hit][1]})</span>"; ?>
    | 
    <span style="color:#000;"><?=$info[product]?></span>
    <? if ($is_admin) echo "<span style=\"color:#888; font-size:11px; font-weight:normal;\">(hit : {$view[link_hit][2]})</span>"; ?>
    </div>

    <div style="float:right; font-weight:normal; color:#888; font-size:11px; margin-right:10px;">
    hit : <?=$view[wr_hit]?>
    </div>

</div>

<table border=0 cellpadding=0 cellspacing=0 width=100% height=7>
<tr>
    <td background="<?=$board_skin_path?>/img/view_head_bottom.gif"></td>
</tr>
</table>


<table border=0 cellpadding=0 cellspacing=0 width=100% style="margin-top:24px;">
<tr>
    <td width=330 align=center>

        <div style="border:5px solid #f4f4f4; width:270px;"><div style="border:1px solid #dedede;"><img src="<?=$img?>" width=268 height=228></div></div>

    </td>
    <td width=10></td>
    <td>
        <div style="width:337px; height:55px; border:1px solid #DDDDDD; background-color:#fafafa; font-weight:bold; font-family:dotum; color:#555555; line-height:25px;">
            <div style="margin-left:10px; margin-top:5px; font-size:15px;">
                <? if ($view[link][1]) { ?><a href="<?=$view[link_href][1]?>" target=_blank style="text-decoration:none;"><? } ?>
                제공 : <?=$info[company]?> 
                <!--<? if ($view[link][1]) { ?>(<?=str_replace("http://", "", $view[link][1])?>)<? }?>-->
                <? if ($view[link][1]) { ?></a><? } ?>
            </div>
            <div style="margin-left:10px; font-size:12px;">
                <? if ($view[link][2]) { ?><a href="<?=$view[link_href][2]?>" target=_blank style="text-decoration:none;"><? } ?>
                제품명 : <?=$info[product]?>
                <? if ($view[link][2]) { ?></a><? } ?>
            </div>
        </div>
        

        <table border=0 cellpadding=0 cellspacing=0 width=100% style="margin:18px 0 0 5px;">
        <tr>
            <td height=20 style="padding-left:5px;" width=100> 경매시작일시 </td>
            <td style="color:#898989; font-weight:bold;"> <span class=colon>:</span> <?=date("Y년 m월 d일 H시 i분", strtotime($info[start_datetime]))?> </td>
        </tr>
        <tr>
            <td height=20 style="padding-left:5px;"> 경매종료일시 </td>
            <td style="color:#898989; font-weight:bold;"> <span class=colon>:</span> <?=date("Y년 m월 d일 H시 i분", strtotime($info[end_datetime]))?> </td>
        </tr>
        <? if ($info[status] == 1) {?>
        <tr>
            <td height=20 style="padding-left:5px;"> 남은시간 </td>
            <td> <span class=colon>:</span> <span id=end_timer></span>  </td>
        </tr>
        <? } ?>
        <tr><td height=5 bgcolor="#ffffff" colspan=2></td></tr>
        <tr><td height=1 bgcolor="#dddddd" colspan=2></td></tr>
        <tr><td height=5 bgcolor="#ffffff" colspan=2></td></tr>
        <tr>
            <td height=20 style="padding-left:5px;"> 입찰 포인트 </td>
            <td> 
                <span class=colon>:</span> 
                <span style="color:#FF2E6E; font-weight:bold;"><?=number_format($info[tender_lower])?> ~ <?=number_format($info[tender_higher])?> 포인트</span>
            </td>
        </tr>
        <tr>
            <td height=20 style="padding-left:5px;"> 입찰수 </td>
            <td>
                <span class=colon>:</span> 
                <span style="color:#3A72A9; font-weight:bold;">
                    <? if ($is_admin) echo "$tender_mb_id_count 명, "; ?>
                    <?=number_format($info[tender_count])?> 건 참여
                </span>
            </td>
        </tr>
        <tr>
            <td height=20 style="padding-left:5px;"> 경매상태 </td>
            <td> 
                <? if ($info[status] == 3) { ?>
                <span class=colon>:</span> <span style="color:#888; font-weight:bold;">경매가 유찰되었습니다.</span>
                <? } elseif ($info[status] == 2) { ?>
                <span class=colon>:</span> <span style="color:#950000; font-weight:bold;">경매가 종료되었습니다.</span>
                <? } elseif ($info[status] == 1) { ?>
                <span class=colon>:</span> <span style="color:#009520; font-weight:bold;">입찰가능</span>
                <? } else { ?>
                <span class=colon>:</span> <span style="color:#888; font-weight:bold;">시작전입니다.</span>
                <? } ?>
            </td>
        </tr>
        <tr><td height=5 bgcolor="#ffffff" colspan=2></td></tr>
        <tr><td height=1 bgcolor="#dddddd" colspan=2></td></tr>
        <tr><td height=5 bgcolor="#ffffff" colspan=2></td></tr>
        </table>
        <div style="color:#000; line-height:20px; font-family:dotum;">
        <div style="margin-left:5px;">* 입찰 참여 시 <b>참여포인트 <?=number_format($info[inter_point])?>점</b>이 차감됩니다.</div>
        <div style="margin-left:5px;">* 본 상품은 <b>하루 최대 <?=$info[day_limit]?>번</b> 입찰 하실 수 있습니다.</div>
        </div>
    </td>
</tr>
</table>

<div style="height:54px; background:url(<?=$board_skin_path?>/img/tender_bg.gif); margin-top:16px;">

<? if ($info[status] == '0') { ?>

    <div style="text-align:center; padding-top:20px; font-weight:bold;">
        경매는 <u><?=date("Y년 m월 d일 H시 i분", strtotime($info[start_datetime]))?></u> 에 시작됩니다.
    </div>

<? } elseif ($info[status] == '2') { ?>

    <div style="height:54px; background:url(<?=$board_skin_path?>/img/tender_result_bg.gif) no-repeat;">
        <? if ($info[mb_id]) { ?>
            <div style="position:absolute; margin:15px 0 0 280px; line-height:25px;"><?=get_sideview($success_member[mb_id], $success_member[mb_nick], $success_member[mb_email], $success_member[mb_homepage])?></div>
            <div style="position:absolute; margin:20px 0 0 455px; color:#888888; font-weight:bold;"><?=number_format($info[td_id])?> 포인트</div>
        <? } ?>
        <? if ($info[tender_count]) { ?>
            <div style="position:absolute; cursor:pointer; margin:8px 0 0 560px;"><img src="<?=$board_skin_path?>/img/btn_tender_list.gif" onclick="tender_list()"></div>
        <? } ?>
    </div>

<? } elseif ($info[status] == '3') { ?>

    <div style="">
        <div style="float:left;"><img src="<?=$board_skin_path?>/img/tender_lost.gif"></div>
        <div style="float:left; cursor:pointer; margin-top:8px;"><img src="<?=$board_skin_path?>/img/btn_tender_list.gif" onclick="tender_list()"></div>
    </div>

<? } else { ?>

    <div style="float:left;"><img src="<?=$board_skin_path?>/img/tender_left.gif"></div>
    <form name=auction_tender id=auction_tender method=post action="<?=$board_skin_path?>/tender.php" target=hiddenframe style="margin:18px 0 0 0; float:left;">
    <input type=hidden name=bo_table value=<?=$bo_table?>>
    <input type=hidden name=wr_id value=<?=$wr_id?>>
    <input type=text name=point id=point value="" required numeric itemname="입찰 포인트" style=" border:1px solid #D3D3D3; width:80px; text-align:right; padding-right:10px;">
    포인트를 입찰하겠습니다.
    </form>
    <div style="float:left; cursor:pointer; margin:8px 0 0 10px;"><img src="<?=$board_skin_path?>/img/btn_tender.gif" onclick="tender_send()"></div>
    <? if ($info[tender_count]) { ?><div style="float:left; cursor:pointer; margin:8px 0 0 5px;"><img src="<?=$board_skin_path?>/img/btn_tender_list.gif" onclick="tender_list()"></div><? } ?>
    <? if ($view[link][2]) { ?><div style="float:left; margin:8px 0 0 5px;"><a href="<?=$view[link_href][2]?>" target=_blank><img src="<?=$board_skin_path?>/img/btn_buy.gif"></a></div><? } ?>

<? } ?>

</div>

<? /*if ($is_member) { ?>
<div style="margin-top:5px; padding:10px; color:#888; border:1px solid #ddd;">
<b><?=$member[mb_nick]?></b>님께서는 <b><?=number_format($member[mb_point])?> 포인트</b>를 가지고 계십니다.
</div>
<? } */?>

<? if ($is_admin && $super[point] && $info[status] == '1') { ?>
    <div style="padding:10px; border:1px solid #ddd; margin-top:10px;">
    (1위: <?=number_format($super[point])?> 포인트, <?=number_format($super[count])?> 건)
    <? 
    foreach($super_mb_id as $mb_id) { 
        $mb = get_member($mb_id);
        echo get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]);
    }
    ?>
    </div>
<? } ?>

<div id=writeContents style="margin:20px 0 20px 0;">
<?=resize_content($view[wr_content])?>
</div>

<?
// 코멘트 입출력
if (!$board['bo_comment_read_level'])
  include_once("./view_comment.php");
else if ($member['mb_level'] >= $board['bo_comment_read_level'])
  include_once("./view_comment.php");
?>

<?=$link_buttons?>

</td></tr></table><br>

<script language="JavaScript">
function file_download(link, file) {
    <? if ($board[bo_download_point] < 0) { ?>if (confirm("'"+file+"' 파일을 다운로드 하시면 포인트가 차감(<?=number_format($board[bo_download_point])?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?"))<?}?>
    document.location.href=link;
}
function tender_send()
{
    var p = document.getElementById("point").value;

    if (!p) {
        alert("포인트를 입력해주세요.");
        return;
    }

    if (confirm("정말 입찰하시겠습니까?"))
        document.auction_tender.submit();
}
function tender_list()
{
    tender_list_win = window.open("<?=$board_skin_path?>/tender_list.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>","tender_list","width=500, height=500, scrollbars=1");
    tender_list_win.focus();
}
</script>

<? if ($info[status] == 1 && $end_time > 0) {?>

<script language="JavaScript">

var end_time = <?=$end_time?>;

function run_timer()
{
    var timer = document.getElementById("end_timer");

    dd = Math.floor(end_time/(60*60*24));
    hh = Math.floor((end_time%(60*60*24))/(60*60));
    mm = Math.floor(((end_time%(60*60*24))%(60*60))/60);
    ii = Math.floor((((end_time%(60*60*24))%(60*60))%60));

    var str = "";

    if (dd > 0) str += dd + "일 ";
    if (hh > 0) str += hh + "시간 ";
    if (mm > 0) str += mm + "분 ";
    str += ii + "초 ";

    timer.style.color = "red";
    timer.style.fontWeight = "bold";
    timer.innerHTML = str;

    end_time--;

    if (end_time < 0) clearInterval(tid);
}

run_timer();

tid = setInterval('run_timer()', 1000); 

</script>

<? } ?>

<script type="text/javascript"  src="<?="$g4[path]/js/board.js"?>"></script>
<script language="JavaScript">
window.onload=function() {
    resizeBoardImage(<?=(int)$board[bo_image_width]?>);
    drawFont();
    OnclickCheck(document.getElementById("writeContents"), '<?=$config[cf_link_target]?>'); 
}
</script>
<!-- 게시글 보기 끝 -->
