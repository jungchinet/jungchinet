<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<? if (count($list)) { ?>
<? if (!jQuery) { ?>
<script src="<?=$g4[path]?>/js/jquery.js" type="text/javascript"></script>
<? } ?>
<script src="<?=$g4[path]?>/js/jquery.ui.core.min.js" type="text/javascript"></script>
<script src="<?=$g4[path]?>/js/jquery.ui.widget.min.js" type="text/javascript"></script>
<script src="<?=$g4[path]?>/js/jquery.ui.mouse.min.js" type="text/javascript"></script>
<script src="<?=$g4[path]?>/js/jquery.ui.draggable.min.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
function hideMe(popupid, days){
    if ( document.getElementById('chkbox_'+popupid).checked ) {
    	set_cookie( 'divpop_'+popupid, "done", days*24, g4_cookie_domain);
 		  document.getElementById('chkbox_'+popupid).checked = false;
  	}

  	document.getElementById('divpop_'+popupid).style.visibility="hidden";
}

// 이미지맵 위로 마우스가 이동할 때 마우스 커서를 바꿔주기
function over(id, cursorVal) 
{ 
    document.getElementById(id).style.cursor = cursorVal; 
} 

// 이미지맵 밖으로 마우스가 이동할 때 마우스 커서를 바꿔주기
function out(id) 
{ 
    document.getElementById(id).style.cursor = 'move'; 
} 
//-->
</script>
<? } ?>

<?
// wr_content의 내용을 역으로 풀어줍니다 - 이미지맵에 꼭 필요합니다. /board/cheditor_popup/view.skin.php에도 같은 코드를 넣어야 합니다.
function conv_content_rev($content, $writeContents_id, $wr_option)
{
    $content = preg_replace("/\&lt\;/", "<", $content);
    $content = preg_replace("/\&gt\;/", ">", $content);
    $content = preg_replace("/area/", "area onmouseover=\"over('{$writeContents_id}', 'pointer');\" onmouseout=\"out('{$writeContents_id}');\" ", $content);

		if (!strstr($wr_option, "html1")) {
		    $html = 0;
        $content = conv_content($content, $html);
    }

    // map과 area 태그를 남기고 모든 태그를 없앤다 - http://kr.php.net/manual/kr/function.strip-tags.php
    $content = strip_tags($content, "<map>,<area>"); 

    return $content;
}
?>

<?
for ($i=0; $i<count($list); $i++) {

// cookie 정보를 읽어서, done인 경우에는 출력을 하지 않고 통과합니다. 불필요한 창을 여는 것은 낭비입니다.
if (!$cate) 
    $cate = "popup2143_"; // $cate가 없는 경우 html 페이지의 이름과 겹치는 경우가 발생해서 임의로 값을 넣어줍니다.
$popup_id = $cate . $list[$i]['wr_id'];
$cookie_name = "divpop_" . $popup_id;
$chkbox_id = "chkbox_" . $popup_id;
$writeContents_id = "writeContents_" . $popup_id;

if ($_COOKIE[$cookie_name] == "done")
    continue;

// 팝업관리 - 파일 출력 (/board/cheditor_popup/view.skin.php에도 같은/수정된 코드를 넣어야 합니다.)
$back_img = "";
if ($list[$i][file][0][view]) {
    $img_url = $list[$i][file][0][path]."/".$list[$i][file][0][file];
    if ($list[$i][wr_9]) { // 맵을 사용하는 경우
        // 기본값 정의
        $popup_padding = "0px";
        $popup_offset_x = 0;
    } else if ($list[$i][link][1]) { // 맵을 안쓰면서 - 링크1에 값이 있는 경우 - 이미지로
        // 기본값 정의
        $popup_padding = "0px";
        $popup_offset_x = 0;
    } else { //  맵을 안쓰면서 - 링크1에 값이 없는 경우 - 배경이미지로
        // 기본값 정의
        $popup_padding = "20px";
        $popup_offset_x = 12;
        
        // 배경이미지 반복
        if ($list[$i][wr_10])
            $back_img_repeat = "background-repeat:repeat";
        else
            $back_img_repeat = "background-repeat:no-repeat";
        $back_img = "style=\"background-image:url('$img_url');{$back_img_repeat};width:{$list[$i][wr_5]}\"";
    }
} else {
        // 기본값 정의
        $popup_padding = "20px";
        $popup_offset_x = 12;
}

// 팝업창 넓이
$popup_width = $list[$i]['wr_5'];

// 팝업창의 title 상하단 높이
$popup_t = 25;
?>

<div class="popups" id="divpop_<?=$popup_id?>" style="border-style:solid;border-width:1px;border-color:#333333;position:absolute;width:<?=$popup_width?>px;left:<?=$list[$i]['wr_3']?>px;top:<?=$list[$i]['wr_4']?>px;z-index:<?=$i?>;" >

<div style="background-color:#888888;height:<?=$popup_t?>px;padding-left:<?=$popup_padding?>;padding-top:5px;">

    <span style="float:left">
    <!-- 제목의 폰트 스타일과 타입을 정의 -->
    <font face="Arial" color="#FFFFFF">&nbsp;<?=$list[$i]['subject']?></font>
    </span>

    <!-- 창을 닫아주는 x를 정의 -->
    <span style="float:right;width=<?=$popup_t?>px;">
    <a href="#" onclick="hideMe('<?=$popup_id?>', <?=$list[$i]['wr_7'];?>);"><font color=#ffffff size=2 face=arial style="text-decoration:none">X</font></a>&nbsp;
    </span>

</div>

<div style="background-color:#FFFFFF;height:<?=$list[$i]['wr_6']?>px;padding-left:<?=$popup_padding?>;padding-top:<?=$popup_padding?>;padding-right:<?=$popup_padding?>;">
		<!-- 내용 출력 -->
		<? if ($list[$i][wr_9]) { // 맵을 쓰는 경우 ?>
        <span id="<?=$writeContents_id?>" style="overflow:hidden;width:<?=$list[$i][wr_5]?>;height:<?=$list[$i][wr_6]?>;"><img src="<?=$img_url;?>" usemap="#<?=$list[$i][wr_9]?>"><?=conv_content_rev($list[$i][wr_content], $writeContents_id, $list[$i][wr_option]);?></span>
    <? } else if ($list[$i][link][1]) {
      
    		// wr_link1이 있는 경우에는 wr_link1으로 내용의 link를 걸어줍니다.
        $popup_link = $list[$i][link][1];
  	    if ($list[$i][link][2])
	          $target_link = " target='new' ";
	      else
	          $target_link = "";
    		?>
        <span id="<?=$writeContents_id?>" ><a href="<?=$popup_link?>" onfocus="this.blur()" style="text-decoration:none;" <?=$target_link?>><img src="<?=$img_url;?>"></a></span>
    <? } else { ?>
        <?
        $wr_content = $list[$i]['wr_content'];
    		if (!strstr($list[$i]['wr_option'], "html1")) {
		        $html = 0;
            $wr_content = conv_content($wr_content, $html);
        }
        ?>
        <span id="<?=$writeContents_id?>" style="overflow:hidden;width:<?=$list[$i][wr_5]?>;height:<?=$list[$i][wr_6]?>;cursor:move;"><?=$wr_content?></span>
    <? } ?>
    </td></tr>
</div>

<div style="background-color:#EFEFEF;height:<?=$popup_t?>px;text-align:right;padding-right:5px;">
  	<input type="checkbox" name="<?=$chkbox_id?>" id="<?=$chkbox_id?>" value="checkbox" onclick="hideMe('<?=$popup_id?>', <?=$list[$i]['wr_7'];?>);" style="cursor:pointer;"> <a href="#" onclick="hideMe('<?=$popup_id?>', <?=$list[$i]['wr_7'];?>);"><?=$list[$i]['wr_8'];?></a> &nbsp;
</div>



</div>

<script type="text/javascript">
$(document).ready(function() {
	  $('.popups').draggable( { cursor: 'hand' } );
});
</script>

<?
} // end of for loop
?>
