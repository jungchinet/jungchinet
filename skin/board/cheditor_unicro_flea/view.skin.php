<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 스킨에서 사용하는 lib 읽어들이기
include_once("$g4[path]/lib/view.skin.lib.php");
?>

<?
// 유니크로
if ($write[wr_1] > 0)
{
    // 아이템 삭제 여부를 확인 (아이템만 삭제되고 게시글이 남아 있는 경우가 있을 수 있으므로...)
    $unicro_table = "$g4[table_prefix]unicro_item";
    $result = sql_fetch( "select item_no from $unicro_table where bo_table = '$bo_table' and wr_id = '$wr_id' ");
    $item_exist = $result['item_no'];
    
    if ($delete_href && $member['mb_id'] == $view['mb_id'] && $item_exist) {
        $delete_href = "javascript:del('http://unicro{$g4[cookie_domain]}/item/itemDelete.jsp?CHECKID={$write[wr_1]}&asp_url=Y');";
        $target_href = "target=\"_top\"";
    }
    
    if ($update_href && $member['mb_id'] == $view['mb_id'] && $item_exist) {
        $update_href = "http://unicro{$g4[cookie_domain]}/item/itemUpdate.jsp?item_no={$write[wr_1]}&asp_url=Y";
        $target_href = "target=\"_top\"";
    }
    
    $view[content] = $write[wr_content];
}

if ($write_href) 
   $write_href = "$g4[path]/unicro/unicro_select.php?bo_table=$bo_table";

if ($reply_href) 
   $reply_href = "$g4[path]/unicro/unicro_select.php?w=r&bo_table=$bo_table&wr_id=$wr_id";
   

// 전화번호가 없으면, 게시글 등록불가
if ($group[gr_id] == "unicro_sel") {
    $time_on = strtotime($view[wr_datetime]) - ($g4['server_time'] - 86400*30);
    if ($time_on > 0)
        $tmp_mb = get_member($write[mb_id], "mb_tel");
        $tel_str = " (tel. $tmp_mb[mb_tel]) ";
}

// 비추천은 본인만 볼 수 있게
if ($member[mb_id] !== $view[mb_id])
    $is_nogood = false;
?>


<!-- 게시글 보기 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0" id="view_<?=$wr_id?>"><tr><td>

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

        <? if ($nosecret_href) { echo "<a href=\"$nosecret_href\"><img src='$board_skin_path/img/btn_nosecret.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($secret_href) { echo "<a href=\"$secret_href\"><img src='$board_skin_path/img/btn_secret.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($now_href) { echo "<a href=\"$now_href\"><img src='$board_skin_path/img/btn_now.gif' border='0' align='absmiddle'></a> "; } ?>
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
<table width="100%" cellspacing="0" cellpadding="0" id="view_Contents">
<tr><td height=2 bgcolor="#0A7299"></td></tr> 
<tr><td height=30 style="padding:5px 0 5px 0;">
    <table width=100% cellpadding=0 cellspacing=0>
    <tr>
    	<td style='word-break:break-all; height:28px;'>&nbsp;&nbsp;<strong>
      <?
        $subject_img = "";
        // 유니크로 판매중단
        if ($view[wr_5] == "판매중지") 
            $subject_img .= "<img src='$board_skin_path/img/sell_stop.gif' border=0 align=absmiddle > ";
        else if ($view[wr_5] == "판매완료")
            $subject_img .= "<img src='$board_skin_path/img/sell__done.gif' border=0 align=absmiddle > ";

        // 유니크로 거래 - 안전거래 이미지를 출력
        if ($view[wr_1]) 
            $subject_img .= "<img src='$board_skin_path/img/safe_ico.gif' border=0 align=absmiddle > ";

        // 유니크로 거래 - 판매자 지정상품의경우 
        if ($view[wr_8]) 
            $subject_img .= "<img src='$board_skin_path/img/secret_ico.gif' border=0 align=absmiddle > ";
      ?>
    	<span id="writeSubject"><?=$subject_img?><? if ($is_category) { echo ($category_name ? "[$view[ca_name]] " : ""); } ?><?=cut_hangul_last(get_text($view[wr_subject]))?></span></strong>
    	</td>
    	<td width=230>
    	      <a href="http://thecheat.co.kr/bbs/zboard.php?id=cheat" target="_blank"><b>더치트(사기꾼검색)<a/></a>
    	      <a href="javascript:scaleFont(+1);"><img src='<?=$board_skin_path?>/img/icon_zoomin.gif' border=0 title='글자 확대' align=absmiddle></a>
            <a href="javascript:scaleFont(-1);"><img src='<?=$board_skin_path?>/img/icon_zoomout.gif' border=0 title='글자 축소' align=absmiddle></a></td>
            <? if ($board['bo_print_level'] && $member[mb_level] >= $board['bo_print_level']) { ?>
            <script type="text/javascript" src="<?=$board_skin_path?>/../print_contents.cheditor.js"></script>
            <a href="#" onclick="javascript:print_contents2('view_Contents', 'commentContents', '<?=$g4[title]?>')"><img src='<?=$board_skin_path?>/img/btn_print.gif' border=0 title='프린트'></a>
            <? }?>
    </tr>
	  <tr><td colspan="2" height=3 style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x;"></td></tr>
    </table></td></tr>
<tr><td height=30>
    <span style="float:left;">
    &nbsp;&nbsp;글쓴이 : <?=$view[name]?><? if ($is_ip_view) { echo "&nbsp;($ip)"; } ?><? if ($tel_str) echo $tel_str?>&nbsp;&nbsp;&nbsp;&nbsp;
    날짜 : <?=substr($view[wr_datetime],2,14)?>&nbsp;&nbsp;&nbsp;&nbsp;
    조회 : <?=$view[wr_hit]?>&nbsp;&nbsp;&nbsp;&nbsp;
    <? if ($is_good) { ?><font style="font:normal 11px 돋움; color:#BABABA;">추천</font> :<font style="font:normal 11px tahoma; color:#BABABA;"> <?=$view[wr_good]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?></font>
    <? if ($is_nogood) { ?><font style="font:normal 11px 돋움; color:#BABABA;">비추천</font> :<font style="font:normal 11px tahoma; color:#BABABA;"> <?=$view[wr_nogood]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?></font>
    <? if ($trackback_url) { ?><a href="javascript:$.trackback_send_server('<?=$trackback_url?>');" style="letter-spacing:0;" title='주소 복사'><img src="<?=$board_skin_path?>/img/icon_trackback.gif" alt="" align="absmiddle"></a><?}?>
    </span>
    <?if ($singo_href) { ?><span style="float:right;padding-right:5px;"><a href="javascript:win_singo('<?=$singo_href?>');"><img src='<?=$board_skin_path?>/img/icon_singo.gif'></a></span><?}?>
    <?if ($unsingo_href) { ?><span style="float:right;padding-right:5px;"><a href="javascript:win_unsingo('<?=$unsingo_href?>');"><img src='<?=$board_skin_path?>/img/icon_unsingo.gif'></a></span><?}?>
</td></tr>

<!-- 게시글 주소를 복사하기 쉽게 하기 위해서 아랫 부분을 삽입 -->
<tr><td height=30>
        <? $posting_url = "$g4[url]/$g4[bbs]/board.php?bo_table=$bo_table&wr_id=$wr_id"; ?>
        <font style="font:normal 11px 돋움; color:#BABABA;">&nbsp;&nbsp;게시글 주소 : <a href="javascript:clipboard_trackback('<?=$posting_url?>');" style="letter-spacing:0;" title='이 글을 소개할 때는 이 주소를 사용하세요'><?=$posting_url;?></a></font>
</td></tr>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>

<tr>
    <td height=30>
        <!-- 유니크로 주소 복사하기 -->
        <? if ($item_exist) { ?>
        <? $unicro_url = "http://www.unicro.co.kr/main/itemDetail.jsp?item_no=" . $item_exist; ?>
        <font style="font:normal 11px 돋움; color:#BABABA;">&nbsp;&nbsp;유니크로 주소 : <a href="javascript:clipboard_trackback('<?=$unicro_url?>');" style="letter-spacing:0;" title='유니크로에서 거래할 때는 이 주소를 사용하세요'><?="$unicro_url";?></a></font>
        <? } ?>
        <? if ($g4[use_bitly]) { ?>
            <? if ($view[bitly_url]) { ?>
            &nbsp;bitly : <span id="bitly_url" class=bitly style="font:normal 11px 돋움; color:#BABABA;"><a href=<?=$view[bitly_url]?> target=new><?=$view[bitly_url]?></a></span>
            <? } else { ?>
            &nbsp;bitly : <span id="bitly_url" class=bitly style="font:normal 11px 돋움; color:#BABABA;"></span>
            <script language=javascript>
            // encode 된 것을 넘겨주면, 알아서 decode해서 결과를 return 해준다.
            // encode 하기 전의 url이 있어야 결과를 꺼낼 수 있기 때문에, 결국 2개를 넘겨준다.
            // 왜? java script에서는 urlencode, urldecode가 없으니까. ㅎㅎ
            // 글쿠 이거는 마지막에 해야 한다. 왜??? 그래야 정보를 html page에 업데이트 하쥐~!
            get_bitly_g4('#bitly_url', '<?=$bo_table?>', '<?=$wr_id?>');
        </script>
            <?}?>
        <?}?>
        
        <? 
        if ($is_member && $g4[use_gblog]) {
            $gb4_path="../blog";
            include_once("$gb4_path/common.php");
        ?>
        <script language=javascript>
        // gblog에서 쓰는 java script 변수들을 설정
        var gb4_blog        = "<?=$gb4['bbs_path']?>";
        </script>
        <script type="text/javascript"  src="<?="$gb4[path]/js/blog.js"?>"></script>
        <a href="javascript:send_to_gblog('<?=$bo_table?>','<?=$wr_id?>')">블로그로 글보내기</a>
        <? } ?>
</td></tr>
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
    <div id="resContents" class="resContents">

        <?
        $subject_img = "";
        // 유니크로 판매중단
        if ($view[wr_5] == "판매중지") 
            $subject_img = "<img src='http://unicro.co.kr/images/main/t_txt03.gif' border=0 align=absmiddle > ";
        else if ($view[wr_5] == "판매완료")
            $subject_img = "<img src='http://unicro.co.kr/images/main/t_txt02.gif' border=0 align=absmiddle > ";
        if($subject_img)
            echo "<BR>" . $subject_img . "<BR><BR>";
            
        if ($write[wr_1] && !$item_exist)
            echo "<BR><font size=3><b>이 상품은 유니크로에서 삭제되었습니다.<b></font><BR><BR><BR>"
        ?>
        
        <?

        // 파일 출력
        ob_start(); 
        for ($i=0; $i<=$view[file][count]; $i++) {
            if ($view[file][$i][view]) {
                echo resize_content($view[file][$i][view]) . "<br/>&nbsp;&nbsp;&nbsp;" . $view[file][$i][content] . "<br/>"; if (trim($view[file][$i][content])) echo "<br/>";
            }
        }
        $file_viewer = ob_get_contents();
        ob_end_clean();

        // 신고된 게시글의 이미지를 선택하여 출력하기
        if ($view['wr_singo'] and trim($file_viewer)) {
            $singo = "<div id='singo_file_title{$view[wr_id]}' class='singo_title'><font color=gray>신고가 접수된 게시물입니다. ";
            $singo .= "<span class='singo_here' style='cursor:pointer;font-weight:bold;' onclick=\"document.getElementById('singo_file{$view[wr_id]}').style.display=(document.getElementById('singo_file{$view[wr_id]}').style.display=='none'?'':'none');\"><font color=red>여기</font></span>를 클릭하시면 첨부 이미지를 볼 수 있습니다.</font></div>";
            $singo .= "<div id='singo_file{$view[wr_id]}' style='display:none;'><p>";
            $singo .= $file_viewer;
            $singo .= "</div>";
            echo $singo;
        } else {
            echo $file_viewer;
        }
        ?>

        <!-- 내용 출력 -->
        <span id="writeContents" class="ct lh">
        <?
            $write_contents=resize_dica($view[content],400,300);
            
            // 과도한 이미지 첨부가 있는 경우 
            $maxmb = $board[bo_image_max_size];
            $curmb = (int) $g4[resize][image_size];
            if ($board[bo_image_info] && $maxmb > 0 && $curmb > $maxmb) {
                $write_msg="<font color=red><b>이미지 첨부가 $maxmb kb를 초과한 $curmb kb이므로 출력할 수 없습니다.<br>편집기로 이미지를 줄여주시기 바랍니다.<br></b></font>";
                if (($member[mb_id] && $member[mb_id] == $view[mb_id]) || $is_admin)
                    echo $write_msg;
                else
                    $write_contents = $write_msg;
            }
            echo $write_contents;
        ?>
        </span>

        <?//echo $view[rich_content]; // {이미지:0} 과 같은 코드를 사용할 경우?>
        <!-- 테러 태그 방지용 --></xml></xmp><a href=""></a><a href=''></a>

        <tr><td height="1" bgcolor="#E7E7E7"></td></tr>
        <? if ($is_signature) { echo "<tr><td align='center' style='border-bottom:1px solid #E7E7E7; padding:5px 0;'>$signature</td></tr>"; } // 서명 출력 ?>

        <?
        // CCL 정보
        $view[wr_ccl] = $write[wr_ccl] = mw_get_ccl_info($write[wr_ccl]);
        ?>

        <? if ($board[bo_ccl] && $view[wr_ccl][by]) { ?>
        <tr style='padding:10px;' class=mw_basic_ccl><td>
        <a rel="license" href="<?=$view[wr_ccl][link]?>" title="<?=$view[wr_ccl][msg]?>" target=_blank><img src="<?=$board_skin_path?>/img/ccls_by.gif">
        <? if ($view[wr_ccl][nc] == "nc") { ?><img src="<?=$board_skin_path?>/img/ccls_nc.gif"><? } ?>
        <? if ($view[wr_ccl][nd] == "nd") { ?><img src="<?=$board_skin_path?>/img/ccls_nd.gif"><? } ?>
        <? if ($view[wr_ccl][nd] == "sa") { ?><img src="<?=$board_skin_path?>/img/ccls_sa.gif"><? } ?>
        </a>
        </td></tr>
        <? } ?>
        
        <? if ($board[bo_related] && $view[wr_related]) { ?>
        <? $rels = mw_related($view[wr_related], $board[bo_related]); ?>
        <? if (count($rels)) {?>
        <tr>
            <td>
            <b>관련글</b> : <?=$view[wr_related]?>
            </td>
        </tr>
        <tr>
            <td>
                <ul>
                <? for ($i=0; $i<count($rels); $i++) { ?>
                <li> <a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>&wr_id=<?=$rels[$i][wr_id]?>"> <?=$rels[$i][wr_subject]?> </a> </li>
                <? } ?>
                </ul>
            </td>
        </tr>
        <? } ?>
        <? } ?>

        <? 
        // 인기검색어
        if ($board[bo_popular]) { 
        
        unset($plist);
        $plist = popular_list($board[bo_popular], $board[bo_popular_days], $bo_table);
        
        if (count($plist) > 0) {
        ?>
        <tr>
            <td>
                <b>인기검색어</b> : 
                <? 
                for ($i=0; $i<count($plist); $i++) {
                    if (trim($plist[$i][sfl]) == '' || strstr($plist[$i][sfl], '\%7C')) $plist[$i][sfl] = "wr_subject||wr_content";
                ?>
                <a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>&sfl=<?=urlencode($plist[$i][sfl])?>&stx=<?=$plist[$i]['pp_word']?>"><?=$plist[$i]['pp_word']?></a>&nbsp;&nbsp;
                <? } ?>
            </td>
        </tr>
        <? } ?>
        <? } ?>
</div>
</td>
</tr>

<?
  if ($view[wr_10]) { // 내용이 있는 경우

    $write_time = strtotime($view[wr_datetime]); // 글쓴 시간
    $before_time = $g4[server_time] - (86400 * 90); // 지정된 일자 이전
    $diff_time = $write_time - $before_time;
    $view_status = 0;

    if ($view[mb_id] == $member[mb_id] or $is_admin) { // 내글인 경우에는 무조건 보여줍니다
      $view_status = 1;
    } else if ($diff_time > 0) { // 지정된 기간 이내의 글인 경우에는 코멘트가 있어야 보여줍니다
      $tmp_write_table = $g4[write_prefix] . $board[bo_table]; // 게시판 테이블 실제이름
      $sql = "select count(*) as cnt from $tmp_write_table where wr_parent = $wr_id and mb_id = '$member[mb_id]' and wr_is_comment = 1";
      $result = sql_fetch($sql);
      if ($result[cnt] > 0) { // 해당글에 코멘트를 달았을 경우
        $view_status = 1;
      }
    } else { // 지정된 이후의 글인 경우에는 지정된 일자 이전에 달았던 코멘트가 있어야지만 보여줍니다
      $tmp_write_table = $g4[write_prefix] . $board[bo_table]; // 게시판 테이블 실제이름
      $min_datetime = date("Y-m-d H:i:s", strtotime($view[wr_datetime]) + (86400 * 30));
      $sql = "select count(*) as cnt from $tmp_write_table where wr_parent = $wr_id and mb_id = '$member[mb_id]' and wr_is_comment = 1 and wr_datetime < '$min_datetime' ";
      $result = sql_fetch($sql);
      if ($result[cnt] > 0) { // 해당글에 지정된 기간 이내에 코멘트를 달았을 경우
        $view_status = 1;
      }
    }

    if ($view_status == 1) {
?>

<tr>
    <td height="50" style='word-break:break-all;padding:10px;'>
    <table width='100%'>
      <tr><td height="1" bgcolor="#E7E7E7" colspan=2></td></tr>
      <tr>
        <td>
        <!--<span id="writeAccount"><?=$view[wr_10];?></span>-->
        <?=nl2br($view[wr_10]);?>
        </td>
        <? if ($view[mb_id] == '$member[mb_id]' or $is_admin) { ?>
        <td width=50>
          <a href="javascript:memo_box()"><img src='<?=$board_skin_path?>/img/btn_modify.gif' border='0' align='absmiddle'></a>
        </td>
        <? } ?>
      </tr>
      <tr>
        <td colspan=1>
          <span id='mart_memo' style='display:none;'>
          <form method="post" name="mart_memo" id="mart_memo">
          <input type="hidden" class="ed" name="bo_table" value="<?=$bo_table?>" />
          <table width='100%'><tr><td>
          <textarea id="wr_10" name="wr_10" class=tx style='width:100%; word-break:break-all;' rows=5 itemname="연락처.계좌"><?=$view[wr_10]?></textarea>
          </td><td width=50>
          <a href='javascript:memo_update(<?=$wr_id?>)'><img src='<?=$board_skin_path?>/img/btn_c_ok.gif' border='0'/ width=50></a>
          </td></tr></table>
          </form>
          </span>
        </td>
      </tr>
      <script language="JavaScript">
          // 메모박스 toggle
          function memo_box() {
            if (document.getElementById('mart_memo').style.display == 'block')
            {
                document.getElementById('mart_memo').style.display = 'none';
            } else {
                document.getElementById('mart_memo').style.display = 'block';
            }
          }
          // 선택한 메모를 업데이트
          function memo_update(wr_id) {
              var f = document.mart_memo;
              f.action = "<?=$g4[bbs_path]?>/mart_memo_update.php?wr_id=" + wr_id;
              f.submit();
          }
      </script>
    </table>
    </td>
</tr>
<? } ?>
<? } ?>

<!-- 딴지걸기 기능 -->
<? if ($board[bo_hidden_comment]) {
  include_once("$board_skin_path/hidden_comment.skin.php");
} ?>

</table><br>

<?
// 광고가 있는 경우 광고를 연결
if (file_exists("$board_skin_path/adsense_view_comment.php"))
    include_once("$board_skin_path/adsense_view_comment.php");

// 코멘트 입출력
if (!$board['bo_comment_read_level'])
  include_once("./view_comment.php");
else if ($member['mb_level'] >= $board['bo_comment_read_level'])
  include_once("./view_comment.php");
?>

<?=$link_buttons?>

</td></tr>
<tr><td>
<? include_once("$g4[path]/adsense_page_bottom.php"); ?>
</td></tr>
</table><br>

<script type="text/javascript"  src="<?="$g4[path]/js/board.js"?>"></script>
<script language="JavaScript">
window.onload=function() {
    resizeBoardImage(<?=(int)$board[bo_image_width]?>);
    drawFont();
    OnclickCheck(document.getElementById("writeContents"), '<?=$config[cf_link_target]?>'); 
}
</script>
<!-- 게시글 보기 끝 -->

<?
// 유니크로
if ($write[wr_1] > 0)
{
?>
<script>
function link_target()
{
    if (document.getElementById('writeContents')) {
        var target = '_top';
        var link = document.getElementById('writeContents').getElementsByTagName("a");
        for(i=0;i<link.length;i++) {
            if (link[i].target != "_blank")
              link[i].target = target;
        }
    }
}
link_target();
</script>
<? } ?>
