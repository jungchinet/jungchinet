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
                <td align=center>
                <a href="<?=$g4['path']?>/"><img src="<?=$g4[path]?>/images/logo_opencode.jpg" align=absmiddle alt=""></a>
                </td>
                
                
            </tr>
        </table>
    </div>

    <div id="menu" class="<?=$top_menu?>">
        <div class="inset">
        <!-- 주메뉴 -->
        <div class="major">
            <?=print_mnb($mnb_arr)?>
        </div>
        <!-- 우측으로 쏠려 있는 메뉴 -->
        <div class="aside">
            <ul>
            <li>
            <!-- 검색창 -->
            <form name="fsearchbox" method="get" onsubmit="return fsearchbox_submit(this);" style="margin:0px;" class="srch" style="border:0">
            <input type="hidden" name="sfl" value="wr_subject||wr_content">
            <input type="hidden" name="sop" value="and">
            <span><input accesskey="s" class="keyword" title=검색어 name="stx" type="text" maxlength="20" value="<?=$stx;?>" > <input alt=검색 src="<?=$g4[layout_skin_path]?>/img/btn_srch.gif" type="image" alt=""></span>
            </form>
            </li>
            </ul>
        </div>
        <span class="gradient"></span>
    </div>
    <span class="shadow"></span>
    </div><!-- 상단 메뉴 div - menu 끝 -->

</div><!-- 상단 div - header 끝 -->

<!-- 중간의 메인부 시작 -->
<div id="container">

<!-- 왼쪽 side div 시작 -->
<div class="snb">

<?
// 아웃로그인
include_once("$g4[path]/lib/outlogin.lib.php");
echo outlogin("transparent");
?>
<table><tr><td height="1px"></td></tr></table>
    <?
    // 투표
    include_once("$g4[path]/lib/poll.lib.php");
    echo poll();
    ?>
<div>
    <?
	// 와이즈넛 광고를 봐주셔야 합니다. ㅠ..ㅠ...
        include_once("$g4[path]/adsense_aside.php"); 
       ?>
       
       <?
	   // 왔숑 다시 넣어봤음
include_once("$g4[path]/lib/whatson.lib.php");
echo whatson("basic");

include_once "$g4[path]/lib/latest.my.lib.php";
        echo "<div id='my_post'>$loading_msg</div>";
		echo "<div id='my_comment'>$loading_msg</div>";
		
		if($is_member){
		echo "<div id='my_board'>".latest_my_board($skin_dir='naver', $skin_title='내가 본 게시판', $rows=10, $subject_len=40, $options='nb')."</div>";
		}
		echo "<div id='my_latest_read'>";
		if($is_admin){
			echo db_cache('all_latest', 1, "latest_group(naver, , 10, 40, , 전체최근글, '$g4[bbs_path]/new.php')");
		}
		echo "</div>";
		
		if(!$bo_table){
			$bo_table='seoul01';	
		}
		
		echo "<div class='popular_latest'>";
		echo db_cache('popular_{$bo_table}', 600, "latest_popular('naver','$bo_table', 10, 40, '', 4)");
		echo "</div>";
		
		?>
        
       </div>

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
// 항상 광고노출
    include_once("$g4[path]/adsense_aside2.php");  
?>

  
<!--//ui object -->

<!-- 로그인박스와의 여백 -->
    
    
    <table><tr><td height="1px"></td></tr></table>
    <?  //게시판랭킹
    include_once("$g4[path]/lib/popular.lib.php");
    echo board_popular("board","", 14, 5);
    ?>
    
    <table><tr><td height="1px"></td></tr></table>
    <? // 현재접속자
    include_once("$g4[path]/lib/connect.lib.php");
    echo connect();
    ?>
    
    <table><tr><td height="1px"></td></tr></table>
    <?
    // 방문자
    include_once("$g4[path]/lib/visit.lib.php");
    echo visit();
    ?>

    <table><tr><td height="1px"></td></tr></table>
    <center>
    <a href="http://idc.gabia.com/colo/" target=new><img src="<?=$g4[path]?>/images/vote.jpg" width='100%' alt=""></a>
    </center>

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