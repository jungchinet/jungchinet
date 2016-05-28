<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/head.sub.php");

// 사용자 화면 상단과 좌측을 담당하는 페이지입니다.
// 상단, 좌측 화면을 꾸미려면 이 파일을 수정합니다.

// layout 정의 및 읽기
$g4[layout_path] = $g4[path] . "/layout";                             // layout을 정의 합니다.
$g4[layout_skin] = "naver";                                           // layout skin을 정의 합니다
$g4[layout_skin_path] = $g4[layout_path] . "/" . $g4[layout_skin];    // layout skin path를 정의 합니다.

// top, side 메뉴의 class를 지정
$top_menu = "menu mc_gray";
$side_menu = "menu_v";

// 필요한 레이아웃 파일등을 읽어 들입니다.
include_once("$g4[layout_skin_path]/layout.php");
include_once("$g4[layout_path]/layout.lib.php");
?>

<!-- 웹페이지 전체의 div -->
<div id="wrap">

<div id="header">

    <!-- 전체 navi 영역 -->
    <div class="gnb">
    </div>
    



    <!-- 상단부 log 같은거 넣어주는 곳 -->
    <div class="sta">
        <!-- 이런 정렬은 table이 div 보다 훨~ 편합니다 -->
        
        
    
        
           <table width=100%>
            <tr>
      	 
      	 <td width="15%" align=left>
      	 
      	</td>
      	 
                <td width="70%" align=center>
                
                
                
                <a href='/'><img src="<?=$g4[path]?>/images/jungchinet.gif" width="103" height="100" align=absmiddle alt="정치넷로고"></a>
                </td>
                
                <td width="15%" align=right>
      	
      	</td>
 
            </tr>
            
        </table>
    </div>



<? include_once("$g4[path]/js_menu11/menu.php");?>

</div><!-- 상단 div - header 끝 -->

<!-- 게시판일 경우 상단내용 뿌리뿌리 -->
<?php

if($bo_table){
	$ttt="<div style='width:100%;clear:both;;overflow:hidden;'>";
	$bbb="</div>";	
	if ($board[bo_content_head]) {
        echo $ttt;
        
        
        if( (strpos($board[bo_table], 'seoul_') !== false) || ($board[bo_table] == 'city05') ) {
            /**
            * 수정: JhChoi. 2016.04.15
            */
            
            $range = array();
            $bo_content_tail_1 = '';
            $bo_content_tail_2 = '';
                
            $tmp_arr = explode("\n",stripslashes($board[bo_content_head]));
            foreach($tmp_arr as $key => $el) {
                if(strpos($el, '<div class="boss_sub">') !== false) {
                    //echo $key;
                    $range[] = $key;
                }
            }
            //print_r($range);
            for($i=0; $i<count($tmp_arr); $i++) {
                if ($i < $range[0]) {
                    $bo_content_tail_1 .= $tmp_arr[$i];
                }
                if ($i >= $range[1]) {
                    $bo_content_tail_2 .= $tmp_arr[$i];
                }
            }
            
            echo $bo_content_tail_1;
            include_once("$g4[path]/j_board_head_lawmaker.php");
            echo $bo_content_tail_2;
        } else {
            echo stripslashes($board[bo_content_head]);
        }

        //echo stripslashes($board[bo_content_head]);
        echo $bbb;
    } 		
}

?>
<!-- 게시판일 경우 상단내용 뿌리뿌리 끝 -->

<!-- 중간의 메인부 시작 -->
<div id="container">

<!-- 왼쪽 side div 시작 -->
<div class="snb">

<?
/*
// 아웃로그인
include_once("$g4[path]/lib/outlogin.lib.php");
echo outlogin("transparent");
*/
?>
<table><tr><td height="1px"></td></tr></table>
    <?
    /*// 투표
    include_once("$g4[path]/lib/poll.lib.php");
	poll(); //전체
	if($member[mb_5]){ poll2(); } //1차지역만
	if($member[mb_5] and $member[mb_6]){ echo poll3(); } //1,2차지역 다
	*/
    ?>
    
    
<div>




<!--<table><tr><td height="1px"></td></tr></table>
    <center>
    <a href="<?=$g4[path]?>/" target="_top" ><img src="<?=$g4[path]?>/images/jido.gif" width="100" height="154" alt=""></a>
    </center>-->

    
       
       <?
       if($is_member){
       // 아웃로그인
include_once("$g4[path]/lib/outlogin.lib.php");
echo outlogin("transparent");
       }
       ?>

<!--<table><tr><td height="1px"></td></tr></table>
    <center>
    <a href="/bbs/board.php?bo_table=freewr01" target="_top" ><img src="<?=$g4[path]?>/images/kyopo.gif" width="160" height="38" alt=""></a>
    </center>

<table><tr><td height="1px"></td></tr></table>
    <center>
    <a href="/bbs/board.php?bo_table=freewr01" target="_top" ><img src="<?=$g4[path]?>/images/chunjo.gif" width="160" height="38" alt=""></a>
    </center>-->
       
       <?
	   // 왔숑 다시 넣어봤음
include_once("$g4[path]/lib/whatson.lib.php");
echo whatson("basic", $rowsInfo[row1]);

include_once "$g4[path]/lib/latest.my.lib.php";
        echo "<div id='my_post'>$loading_msg</div>";
		echo "<div id='my_comment'>$loading_msg</div>";
		
		
		
		//내가 본 게시판
		if($is_member){
		echo "<div id='my_board'>".latest_my_board($skin_dir='naver', $skin_title='내가 본 게시판', $rowsInfo[row5], $subject_len=40, $options='nb')."</div>";
		}
		echo "<div id='my_latest_read'>";
		
		/*
		//전체 최근글
		if($is_admin){
			echo db_cache('all_latest', 1, "latest_group(naver, , $rowsInfo[row6], 40, , 전체최근글, '$g4[path]/bbs/new.php')");
		} */
	
		
		echo "</div>";
		
		
		if(!$bo_table){
			$bo_table='seoul01';	
		}
		
		
		
		/*
		echo "<div class='popular_latest'>";
		echo db_cache('popular_{$bo_table}', 600, "latest_popular('naver','$bo_table', 10, 40, '', 4)");
		echo "</div>";
		*/
		
		?>
        
       </div>
<?
	// 와이즈넛 광고를 봐주셔야 합니다. ㅠ..ㅠ...
        include_once("$g4[path]/adsense_aside.php"); 
       ?>
    <?   
	
	 /*   
    if ($is_member) {
        $loading_msg = "Loading...";
        include_once("$g4[path]/lib/whatson.lib.php");
        echo "<div id='my_whatson' style='height:80px'>$loading_msg</div>";
        //echo whatson("basic");
    
        include_once "$g4[path]/lib/latest.my.lib.php";
        echo "<div id='my_post' style='height:80px'>$loading_msg</div>";
        echo "<div id='my_comment' style='height:80px'>$loading_msg</div>";
    };
	
	*/
	
    ?>
    
    
    <?
    /*
// 항상 광고노출
    include_once("$g4[path]/adsense_aside2.php");  
    */
?>

  
<!--//ui object -->

<!-- 로그인박스와의 여백 -->
    
    

</div>
<!-- 왼쪽 side 메뉴 끝 -->

<!-- 메인 content 메뉴 시작 -->
<div id="content">

<script type="text/javascript">
function fsearchbox_submit(f)
{
    if (f.stx.value.length < 2) {
        alert("검색어는 두글자 이상 입력하십시오.");
        f.stx.select();
        f.stx.focus();
        return false;
    }

    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
    var cnt = 0;
    for (var i=0; i<f.stx.value.length; i++) {
        if (f.stx.value.charAt(i) == ' ')
            cnt++;
    }

    if (cnt > 1) {
        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
        f.stx.select();
        f.stx.focus();
        return false;
    }

    f.action = "<?=$g4['bbs_path']?>/search.php";
    return true;
}
</script>

<?
// 줄바꿈 문자를 없앤다
$reg_e = array('/\n/','/\r/','/\"/'); 
$reg_p = array(' ',' ','\'');
?>
<script type="text/javascript">
$("#naver_popular").html( " <? echo preg_replace($reg_e, $reg_p, trim( db_cache("main_top_naver_cache", 300, "naver_popular('naver_popular', 4)")))?> " );
</script>

