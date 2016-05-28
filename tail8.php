 <?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!--중간 윗쪽 광고부분-->
<div style='clear:both;margin:10px 0 10px 10px' align="center">
<?

if(basename($PHP_SELF)=='index.php'){
	$bGroup='banner5';
}else if(basename($PHP_SELF)=='board.php'){
	$bGroup='banner5';	
}


if($bGroup!=''){
echo get_banner($bGroup, 'basic', '', 1, 0);
}

?>
</div>
<!--중간 윗쪽 광고부분 꿑-->

<center>
<h1><a href="/bbs/board.php?bo_table=ab_01" >미국</a>
<a href="/bbs/board.php?bo_table=ab_02" >중국</a>
<a href="/bbs/board.php?bo_table=ab_03" >일본</a>
<a href="/bbs/board.php?bo_table=ab_04" >유럽</a></h1>

<h2><a href="/bbs/board.php?bo_table=ab_05" >호주</a>
<a href="/bbs/board.php?bo_table=ab_06" >캐나다</a></h2>

<h1><a href="/bbs/board.php?bo_table=ab_07" >동남아</a></h1>
<h2><a href="/bbs/board.php?bo_table=ab_08" >남미</a>
<a href="/bbs/board.php?bo_table=ab_09" >중동</a>
<a href="/bbs/board.php?bo_table=ab_10" >인도</a>
<a href="/bbs/board.php?bo_table=ab_12" >러시아</a>
<a href="/bbs/board.php?bo_table=ab_11" >아프리카</a>
<a href="/bbs/board.php?bo_table=ab_13" >중앙아시아</a></h2>


<p>
<iframe width="640" height="360" src="https://www.youtube.com/embed/?list=UUeFUGS2VCOb6DO3BiUgvwNA" frameborder="0" allowfullscreen></iframe>
</p>
</center>





</div><!-- 가운데 영역 div - content 끝 -->



</div><!-- 중간부 div - container 끝 -->

<!-- 게시판일 경우 하단내용 뿌리뿌리 -->
<?

if($bo_table){
	if ($board[bo_content_tail]) {
		echo $ttt;
    	echo stripslashes($board[bo_content_tail]);
		echo $bbb;	
	}
}

?>
<!-- 게시판일 경우 하단내용 뿌리뿌리 끝 -->

<!--중간 광고부분-->
<div style='clear:both;margin:10px 0 10px 10px' align="center">
<?

if(basename($PHP_SELF)=='index.php'){
	$bGroup='banner3';
}else if(basename($PHP_SELF)=='jb.php'){
	$bGroup='uBanner1';
}else if(basename($PHP_SELF)=='kh.php'){
	$bGroup='uBanner2';
}else if(basename($PHP_SELF)=='jk.php'){
	$bGroup='uBanner3';
}else if(basename($PHP_SELF)=='ab.php'){
	$bGroup='uBanner4';
}else if(basename($PHP_SELF)=='un.php'){
	$bGroup='uBanner5';
}else if(basename($PHP_SELF)=='ns.php'){
	$bGroup='';
}else if(basename($PHP_SELF)=='logout.php'){
	$bGroup='logout';
}else if(basename($PHP_SELF)=='board.php'){
	$bGroup='banner3';	
}


if($bGroup!=''){
echo get_banner($bGroup, 'basic', '', 1, 0);
}

?>
</div>
<!--중간 광고부분 꿑-->


<!-- 페이지 하단부 footer -->
<div id="footer">
		
        <table width=100%>
            <tr>
      	 
      	 <td width="11%" align=left>
		
    <a href='http://info.nec.go.kr/'><img src="<?=$g4[path]?>/images/comming.jpg" width="140" height="179"  align=absmiddle alt="다음선거"></a>
    <? // 현재접속자
		if($is_admin)
    {include_once("$g4[path]/lib/connect.lib.php");
	echo db_cache('now_connected', $rowsInfo[term2], "connect()");}
    //echo connect();
    ?>
    
    
    <?
    // 방문자
    if($is_admin)
    {include_once("$g4[path]/lib/visit.lib.php");
    echo visit();}
    ?>
      	</td>
      	 
                <td width="78%" align=center>

                <br></br>
               <ul  class="footer-nav" >
        
	  		
		</ul>   
		
    
    <p class="note"><font color=#bf2410>
      	"정치를 외면한 가장 큰 대가는 가장 저질스러운 인간들에게 지배당한다는 것이다" -플라톤(BC428~348)</font> </p>
    
    
               <p class="copyright">Copyright &copy; <a href="<?=$g4[path]?>/menuhtml/logout/notice.php" target="_top">정치.net</a>. All rights reserved.
    </p>    
          <br></br>
           </td>
                
                <td width="11%" align=right>
      	<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="200" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
      	</td>
 
            </tr>
            
        
        
		
 
    </table>
                
</div>

</div><!-- 전체 div : wrap 끝 -->

<script type="text/javascript">
// jquery를 이용한 비동기 페이지 로딩 입니다

<? if ($is_member) { ?>

$("#my_whatson").html( " <? echo remove_nr( trim(  whatson('basic')   ))?> " );

<? if ($g4[path] == ".") { ?>

$("#my_post").html( " <? echo remove_nr( trim(   db_cache("$member[mb_id]_latest_my_post", 1, "latest_my('naver','내가올린글',80,$rowsInfo[row2],25)")   ))?> " );
<?} else { ?>
$("#my_post").html( " <? echo remove_nr( trim(   db_cache("$member[mb_id]_latest_my_post_sub", 1, "latest_my('naver','내가올린글',80,$rowsInfo[row2],25)")   ))?> " );
<? } ?>

<? if ($g4[path] == ".") { ?>
$("#my_comment").html( " <? echo remove_nr( trim(   db_cache("$member[mb_id]_latest_my_comment", 1, "latest_my('naver','내가 단 댓글',80,$rowsInfo[row3],25,'comment')")   ))?> " );
<?} else { ?>
$("#my_comment").html( " <? echo remove_nr( trim(   db_cache("$member[mb_id]_latest_my_comment_sub", 1, "latest_my('naver','내가 단 댓글',80,$rowsInfo[row3],25,'comment')")   ))?> " );
<? } ?>

<? if ($g4[path] == ".") { ?>
$("#my_response").html( " <? echo remove_nr( trim(   db_cache("$member[mb_id]_latest_my_update", 1, "latest_my_update('naver','내글의반응',80,10,25)")   ))?> " );
<?} else { ?>
$("#my_response").html( " <? echo remove_nr( trim(   db_cache("$member[mb_id]_latest_my_update_sub", 1, "latest_my_update('naver','내글의반응',80,10,25)")   ))?> " );
<? } ?>

<? } ?>

</script> 

<?
include_once("$g4[path]/tail.sub.php");
?>
