<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 스킨에서 사용하는 lib 읽어들이기
include_once("$g4[path]/lib/view.skin.lib.php");
?>

<!-- 게시글 보기 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0" id="view_<?=$wr_id?>"><tr><td>

<!-- 링크 버튼 -->
<?

//이 글이 프리미엄인가아아...
$ip_sql="select count(prem_wr_id) from prem_info where del_date='0000-00-00 00:00:00' and prem_board='$bo_table' and prem_wr_id='$wr_id' and now() between prem_date and exp_date order by no desc limit 1";
$rst=mysql_query($ip_sql);
$ip_data=mysql_fetch_row($rst);

$prSql=mysql_query("select * from prem_config");
$premConfig=mysql_fetch_array($prSql);
		
		
ob_start();

//이 게시판이 강제썸넬 사용중인지...
$tf=$board['bo_use_thumb']; //Thumbnail Force..

?>
<table width='100%' cellpadding=0 cellspacing=0>
<tr height=35>
    <td width=92%>
        <? if ($search_href) { echo "<a href=\"$search_href#board\"><img src='$board_skin_path/img/btn_search_list.gif' border='0' align='absmiddle' alt='search'></a> "; } ?>
        <? echo "<a href=\"$list_href#board\"><img src='$board_skin_path/img/btn_list.gif' border='0' align='absmiddle' alt='list'></a> "; ?>

        <? if ($write_href) { echo "<a href=\"$write_href#board\"><img src='$board_skin_path/img/btn_write.gif' border='0' align='absmiddle' alt='write'></a> "; } ?>
        <? if ($reply_href) { echo "<a href=\"$reply_href#board\"><img src='$board_skin_path/img/btn_reply.gif' border='0' align='absmiddle' alt='reply'></a> "; } ?>

        <? if ($update_href) {
			
			if($ip_data[0]==1){
				if($member[mb_id]==$view[mb_id] or $is_admin=='super' or ($is_admin=='board' and $premConfig[modiFlag])){
					echo "<a href=\"$update_href#board\"><img src='$board_skin_path/img/btn_modify.gif' border='0' align='absmiddle' alt='update'></a> ";
				}
			}else{
				if($member[mb_id]==$view[mb_id] or $is_admin=='super' or ($is_admin=='board' and $premConfig[modiFlag])){
					echo "<a href=\"$update_href#board\"><img src='$board_skin_path/img/btn_modify.gif' border='0' align='absmiddle' alt='update'></a> ";
				}
			}
			
		} ?>
        <? if ($delete_href) {
			
			if($ip_data[0]==1){
				if($member[mb_id]==$view[mb_id] or $is_admin=='super' or ($is_admin=='board' and $premConfig[modiFlag])){
					echo "<a href=\"$delete_href\"><img src='$board_skin_path/img/btn_del.gif' border='0' align='absmiddle' alt='delete'></a> ";
				}
			}else{
				if($member[mb_id]==$view[mb_id] or $is_admin=='super' or ($is_admin=='board' and $premConfig[modiFlag])){
					echo "<a href=\"$delete_href\"><img src='$board_skin_path/img/btn_del.gif' border='0' align='absmiddle' alt='delete'></a> ";
				}
			}
			
		} ?>


        <? if ($scrap_href) { echo "<a href=\"javascript:;\" onclick=\"win_scrap('$scrap_href');\"><img src='$board_skin_path/img/btn_scrap.gif' border='0' align='absmiddle' alt='scrap'></a> "; } ?>

        <? if ($copy_href) { echo "<a href=\"$copy_href\"><img src='$board_skin_path/img/btn_copy.gif' border='0' align='absmiddle' alt='copy'></a> "; } ?>
        <? if ($move_href) { echo "<a href=\"$move_href\"><img src='$board_skin_path/img/btn_move.gif' border='0' align='absmiddle' alt='move'></a> "; } ?>

        <? if ($nosecret_href) {
			
			if($ip_data[0]==1){
				if($member[mb_id]==$view[mb_id] or $is_admin=='super'){
					echo "<a href=\"$nosecret_href\"><img src='$board_skin_path/img/btn_nosecret.gif' border='0' align='absmiddle' alt='no secret'></a> ";
				}
			}else{
				echo "<a href=\"$nosecret_href\"><img src='$board_skin_path/img/btn_nosecret.gif' border='0' align='absmiddle' alt='no secret'></a> ";
			}
			
		} ?>
        <? if ($secret_href) {
			
			if($ip_data[0]==1){
				if($member[mb_id]==$view[mb_id] or $is_admin=='super'){
					echo "<a href=\"$secret_href\"><img src='$board_skin_path/img/btn_secret.gif' border='0' align='absmiddle' alt='secret'></a> ";
				}
			}else{
				echo "<a href=\"$secret_href\"><img src='$board_skin_path/img/btn_secret.gif' border='0' align='absmiddle' alt='secret'></a> ";
			}
			
		} ?>
        <? if ($now_href) { echo "<a href=\"$now_href\">갱신</a> "; } ?>
        
        <? if ($board[bo_use_premium]/*$[cf_use_premium]*/ and !$ip_data[0] and ($is_admin or ($member[mb_id]==$view['mb_id']))){ ?>
        <a href='javascript:payWin();'><img src='<?=$board_skin_path?>/img/prem_app.jpg' border='0' align='absmiddle' alt='프리미엄등록'></a>
        <? } ?>
        
        <? if($is_admin=='super' and !$ip_data[0]){ ?>
        <a href='javascript:premReg();'><img src='<?=$board_skin_path?>/img/prem_reg.jpg' border='0' align='absmiddle' alt='임의등록'></a>
        <? } ?>
        
        <? if ($good_href) { echo "<a href=\"$good_href\" target='hiddenframe'><img src='$board_skin_path/img/btn_good.gif' border='0' align='absmiddle' alt='good'>추천</a> "; } ?>
        <? if ($nogood_href) { echo "<a href=\"$nogood_href\" target='hiddenframe'><img src='$board_skin_path/img/btn_nogood.gif' border='0' align='absmiddle' alt='nogood'>비추천</a> "; } ?>
        
    </td>
    <td width=8% align=right>
        <? if ($prev_href) { echo "<a href=\"$prev_href#board\" title=\"$prev_wr_subject\"><img src='$board_skin_path/img/btn_prev.gif' border='0' align='absmiddle' alt='prev href'></a>&nbsp;"; } ?>
        <? if ($next_href) { echo "<a href=\"$next_href#board\" title=\"$next_wr_subject\"><img src='$board_skin_path/img/btn_next.gif' border='0' align='absmiddle' alt='next href'></a>&nbsp;"; } ?>
    </td>
</tr>
</table>
<?
$link_buttons = ob_get_contents();
ob_end_flush();
?>

<!-- 제목, 글쓴이, 날짜, 조회, 추천, 비추천 -->
<table width="100%" cellspacing="0" cellpadding="0" id="view_Contents">
<tr><td height=2 style="background:#d5d5d5;"></td></tr> 
<tr><td height=30 style="padding:5px 0 5px 0;">
    <table width=100% cellpadding=0 cellspacing=0>
    <tr>
    	<td style='word-break:break-all; height:28px;'>&nbsp;&nbsp;<strong><span id="writeSubject"><? if ($is_category) { echo ($category_name ? "[$view[ca_name]] " : ""); } ?>
		<? //if($view[wr_1]) { echo "[".trim($view[wr_1])."] "; } ?><?=cut_hangul_last(get_text(stripslashes($view[wr_subject])))?></span></strong></td>
    	<td width=100>
    	      <a href="javascript:scaleFont(+1);"><img src='<?=$board_skin_path?>/img/icon_zoomin.gif' border=0 title='글자 확대' alt='zoom in'></a>
            <a href="javascript:scaleFont(-1);"><img src='<?=$board_skin_path?>/img/icon_zoomout.gif' border=0 title='글자 축소' alt='zoom out'></a>
            <? if ($board['bo_print_level'] && $member[mb_level] >= $board['bo_print_level']) { ?>
            <script type="text/javascript" src="<?=$board_skin_path?>/../print_contents.cheditor.js"></script>
            <a href="#" onclick="javascript:print_contents2('view_Contents', 'commentContents', '<?=$g4[title]?>')"><img src='<?=$board_skin_path?>/img/btn_print.gif' border=0 title='프린트' alt='print'></a>
            <? }?>
    </td>
    </tr>
	  <tr><td colspan="2" height=3 style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x;"></td></tr>
    </table></td></tr>
<tr><td height=30>
    <span style="float:left;">
    &nbsp;&nbsp; <?=$view[name]?><? if ($is_ip_view) { if ($view[mb_id]==$config[cf_admin]){ echo "&nbsp;"; } else { echo "&nbsp;($ip)";} }?>&nbsp;
    <?
        
		$cates=explode('|', $view[wr_5]);
		$catesNum=count($cates);
		
		if($catesNum==3){
			
			$data=mysql_fetch_array(mysql_query("select name from cate_3rd where no='$cates[2]'"));
			echo " <strong>[".$data[name]."]</strong>";
			$data[name]='';
			
		}else if($catesNum==2){
			
			$data=mysql_fetch_array(mysql_query("select name from cate_2nd where no='$cates[1]'"));
			echo " <strong>[".$data[name]."]</strong>";
			$data[name]='';
		
		}else if($catesNum==1){
			
			$data=mysql_fetch_array(mysql_query("select name from cate_1st where no='$cates[0]'"));
			echo " <strong>[".$data[name]."]</strong>";
			$data[name]='';
		
		}
		
		echo "&nbsp;";
		
		?>
        
    <strong><?=trim($view[wr_1])?></strong>&nbsp; 
     <?=substr($view[wr_datetime],0,16)?>&nbsp;&nbsp;&nbsp;&nbsp;
    <? if($is_admin) { ?>조회 : <?=$view[wr_hit]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?>
    <? if ($is_good) { ?><font style="font:normal 15px 돋움; color:#1b57df;">추천</font> :<font style="font:normal 15px tahoma; color:#1b57df;"> <?=$view[wr_good]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?></font>
    <? if ($is_nogood) { ?><font style="font:normal 15px 돋움; color:#df1b1b;">반대</font> :<font style="font:normal 15px tahoma; color:#df1b1b;"> <?=$view[wr_nogood]?>&nbsp;&nbsp;&nbsp;&nbsp;<?}?></font>
    </span>
    <?//if ($singo_href) { ?><!--span style="float:right;padding-right:5px;"><a href="javascript:win_singo('<?//=$singo_href?>');"><img src='<?//=$board_skin_path?>/img/icon_singo.gif' alt='singo'></a></span--><?//}?>
    <? if(empty($ip_data[0])){ ?>
    <? if ($singo_href) { ?><span style="float:right;padding-right:5px;"><a href="<?=$g4[path]?>/bbs/singo_popin_update.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&wr_parent=<?=$view[wr_parent]?>">신고</a></span><? } ?>
    <? if ($unsingo_href) { ?><span style="float:right;padding-right:5px;"><a href="<?=$g4[path]?>/bbs/unsingo_popin_update.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&wr_parent=<?=$view[wr_parent]?>"><img src='<?=$board_skin_path?>/img/icon_unsingo.gif' alt='unsingo'></a></span><? } ?>
    <iframe src='about:blank' name='hdn' width='0' height='0' style='display:none'></iframe>
    <? } ?>
</td></tr>


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
        <a href="javascript:send_to_gblog('<?=$bo_table?>','<?=$wr_id?>')">블로그로보내기</a>
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
        echo "<tr><td height=30>&nbsp;&nbsp;<img src='{$board_skin_path}/img/icon_file.gif' align=absmiddle alt='file'> <a href=\"javascript:file_download('{$view[file][$i][href]}', '{$view[file][$i][source]}');\" title='{$view[file][$i][content]}'><font style='normal 11px 돋움;'>{$view[file][$i][source]} ({$view[file][$i][size]}), Down : {$view[file][$i][download]}, {$view[file][$i][datetime]}</font></a></td></tr><tr><td height='1'  bgcolor='#E7E7E7'></td></tr>";
    }
}

// 링크
$cnt = 0;
for ($i=1; $i<=$g4[link_count]; $i++) {
    if ($view[link][$i]) {
        $cnt++;
        $link = cut_str($view[link][$i], 70);
        echo "<tr><td height=30>&nbsp;&nbsp;<img src='{$board_skin_path}/img/icon_link.gif' align=absmiddle alt='link'> <a href='{$view[link_href][$i]}' target=_blank><font  style='normal 11px 돋움;'>{$link} ({$view[link_hit][$i]})</font></a></td></tr><tr><td height='1' bgcolor='#E7E7E7'></td></tr>";
    }
}

//강제썸 퀄리티
$tfsql="select bo_thumb_percent tp, bo_thumb_width tw from g4_board where bo_table='{$bo_table}'";
$tfrst=sql_fetch($tfsql);
$tfp=$tfrst['tp'];
$tfw=$tfrst['tw'];

?>

<!-- <tr><td height=1 bgcolor=#"E7E7E7"></td></tr> //-->
<tr> 
    <td height="150" style='word-break:break-all;padding:10px;'>
    <div id="resContents" class="resContents">

        <?
        // 파일 출력
        ob_start();
        for ($i=0; $i<=$view[file][count]; $i++) {
            if ($view[file][$i][view]) {
                // function resize_content($content, $width=0, $height=0, $quality=0, $thumb_create=0, $image_window=1, $water_mark="", $image_filter="", $image_min=0, $imgage_min_kb=0)
                //echo resize_dica($view[file][$i][view],250,300) . "<br/>&nbsp;&nbsp;&nbsp;" . $view[file][$i][content] . "<br/>"; if (trim($view[file][$i][content])) echo "<br/>"; 
                //echo resize_content($view[file][$i][view], 0,0,0,1,1,"","",300,90) . "<br/>&nbsp;&nbsp;&nbsp;" . $view[file][$i][content] . "<br/>"; if (trim($view[file][$i][content])) echo "<br/>";
                //echo $view[file][$i][view] . "<br/>&nbsp;&nbsp;&nbsp;" . $view[file][$i][content] . "<br/>"; if (trim($view[file][$i][content])) echo "<br/>";
                if($tf==1){

                    $ha=explode('/', $view[file][$i]['file']);
                    $real_img=$g4[path].'/data/file/'.$bo_table.'/'.$ha[0].'/'.$ha[1];
                    $psize=getimagesize($real_img);

                    if($psize[0]<$tfw){ //설정 사이즈가 원본 사이즈보다 작을 때 그냥 원본사이즈 유지

                        $pwidth=$psize[0];
                        $pheight=$psize[1];

                    }else{ //설정 사이즈가 원본 사이즈보다 클 때 비율 유지하며 
                        
                        //비율로 높이 구하기
                        //$psize[0] : $psize[1] = $tfw : x

                        $pwidth=$tfw;
                        $pheight=round(($psize[1]*$tfw)/$psize[0]);

                    }

                    $img_path=$g4[path].'/data/file/'.$bo_table.'/'.$ha[0].'/_thumb/'.$pwidth.'x'.$pheight.'_'.$tfp.'/'.$ha[1];

                    if(!file_exists($img_path)){

                        //echo '<br>WIDTH :'.$pwidth.' / HEIGHT :'.$pheight.'<br>';

                        thumbnail($real_img, $pwidth, $pheight, $is_create=false, $is_crop=2, $tfp, $small_thumb=1, $watermark="", $filter="", $noimg="", $thumb_type="");

                    }

                    $rImg=substr($img_path,2);
                    echo "<img src='".$rImg."' /><br />";

                }else{
                    echo resize_dica($view[file][$i][view],250,300) . "<br/>&nbsp;&nbsp;&nbsp;" . $view[file][$i][content] . "<br/>"; if (trim($view[file][$i][content])) echo "<br/>"; 
                }
            }
        }
        $file_viewer = ob_get_contents();
        ob_end_clean();

        // 신고된 게시글의 이미지를 선택하여 출력하기
        if ($view['wr_singo'] and ($view['wr_singo']==$board[bo_singo_action]) and trim($file_viewer)) {
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
        <a rel="license" href="<?=$view[wr_ccl][link]?>" title="<?=$view[wr_ccl][msg]?>" target=_blank><img src="<?=$board_skin_path?>/img/ccls_by.gif" alt='ccl'>
        <? if ($view[wr_ccl][nc] == "nc") { ?><img src="<?=$board_skin_path?>/img/ccls_nc.gif" alt='ccl nc'><? } ?>
        <? if ($view[wr_ccl][nd] == "nd") { ?><img src="<?=$board_skin_path?>/img/ccls_nd.gif" alt='ccl nd'><? } ?>
        <? if ($view[wr_ccl][nd] == "sa") { ?><img src="<?=$board_skin_path?>/img/ccls_sa.gif" alt='ccl sa'><? } ?>
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

        <?
        if ($board[bo_chimage])  {
            include_once("$g4[path]/lib/chimage.lib.php");
            $ch_list = chimage('', $bo_table, $wr_id);
            if ($ch_list) {
                echo "<tr>
                      <td>
                      $ch_list
                      </td>
                      </tr>
                ";
            }
        } ?>
</div>
</td>
</tr>

</table><br>

<?

// 코멘트 입출력
if (!$board['bo_comment_read_level'])
  include_once("./view_comment.php");
else if ($member['mb_level'] >= $board['bo_comment_read_level'])
  include_once("./view_comment.php");
  
// 광고가 있는 경우 광고를 연결
//if (file_exists("$board_skin_path/adsense_view_comment.php"))
    //include_once("$board_skin_path/adsense_view_comment.php");
	//include_once("$g4[path]/prem_top.php");
echo $link_buttons;
?>

<br />

<div style='text-align:center'>
<?
echo get_banner('banner4', 'basic', '', 1, 0);
?>
</div>

</td></tr>
<tr><td>
<? include_once("$g4[path]/prem_top.php"); ?>
</td></tr>
</table><br>

<script type="text/javascript"  src="<?="$g4[path]/js/board.js"?>"></script>
<script language="JavaScript">
window.onload=function() {
    resizeBoardImage(<?=(int)$board[bo_image_width]?>);
    drawFont();
    OnclickCheck(document.getElementById("writeContents"), '<?=$config[cf_link_target]?>'); 
}

function payWin(){
	window.open( '<?=$g4[path]?>/payment.php?ord_id=<?=$member[mb_id]?>&ord_name=<?=$member[mb_name]?>&ord_email=<?=$member[mb_email]?>&ord_hp=<? if($member[mb_hp]){echo $member[mb_hp];}else{$member[mb_tel];}?>&bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>','payWin','left=100, top=100, width=600, height=450, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=no')	
}

function premReg(){
	window.open( '<?=$g4[path]?>/prem_adm_ok.php?ord_id=<?=$view[mb_id]?>&bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>','premReg','left=100, top=100, width=400, height=130, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=no')	
}
</script>
<!-- 게시글 보기 끝 -->
