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

</div><!-- 가운데 영역 div - content 끝 -->

<!-- 오른쪽 컬럼 div - side 시작 -->

<div class="aside">
    <div>
    
    <?
    //인기게시물
		function favLat(){
			include_once('/home/hosting_users/jungchinet2/www/mFav.php');
		}
		{
		//echo db_cache('favorite_latest', 1, "include_once(/home/hosting_users/jinwaters/www/mFav.php)");
		echo db_cache('favorite_latest', $rowsInfo[term1], "favLat()");
		}
		//include_once('/home/hosting_users/jinwaters/www/mFav.php');
     
     //전체 최근글
		{
			echo db_cache('all_latest', 1, "latest_group(naver, , $rowsInfo[row6], 40, , 전체최근글, '$g4[path]/bbs/new.php')");
		}
     
     {
		//게시판랭킹
    include_once("$g4[path]/lib/popular.lib.php");
    echo board_popular("board","", 1, 10);
		}
		
		
  {
		//검색어랭킹
    include_once("$g4[path]/lib/popular.lib.php");
    echo popular("mw.popular",10);
		}
		?>
		
    <? 
// 항상 광고노출
    include_once("$g4[path]/adsense_aside2.php");  

    ?>
    
    </div>
</div><!-- 오른쪽 컬럼 div - side 끝 -->

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
      	</td>
      	 
                <td width="78%" align=center>

                
               <ul  class="footer-nav" >
        
	  		
		</ul>   
		
    
    <p class="info"><strong>"Please be political"</strong>
    </p>
    
    
              <p class="copyright">Copyright &copy; <a href="<?=$g4[path]?>/menuhtml/logout/notice.php" target="_top">정치.net</a>. All rights reserved.
    </p>  
          
           </td>
                
                <td width="11%" align=right>
      	<div class="fb-like" data-href="https://www.facebook.com/jungchinet/" data-width="200" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
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
