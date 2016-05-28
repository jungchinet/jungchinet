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

if(basename($PHP_SELF)=='ns.php'){
	$wrap_stl=" style='width:960px;'";
	//$head_stl=" style='width:960px;margin:0 auto;'";
	//$content_stl=" style='width:960px;margin:0 auto;'";
}
?>

<!-- 웹페이지 전체의 div -->
<div id="wrap"<?=$wrap_stl?>>

<div id="header"<?=$head_stl?>>

    <!-- 전체 navi 영역 -->
    <div class="gnb">
    </div>

    <!-- 상단부 log 같은거 넣어주는 곳 -->
    <div class="sta">
        <!-- 이런 정렬은 table이 div 보다 훨~ 편합니다 -->
      
       <table width=100%>
            <tr>
      	 
      	 <td width="15%" align=left>
      	 <?
    // 투표
    include_once("$g4[path]/lib/poll.lib.php");
	poll(); //전체
    ?>
      	</td>
      	 
                <td width="70%" align=center>
                
                
                
                <a href='/bbs/board.php?bo_table=battle01'><img src="<?=$g4[path]?>/images/jungchinet.gif" width="103" height="100" align=absmiddle alt="정치넷로고"></a>
                </td>
                
                <td width="15%" align=right>
                <a href='http://info.nec.go.kr/'><img src="<?=$g4[path]?>/images/comming2.jpg" width="96" height="105"  align=absmiddle alt="다음선거"></a>
      	</td>
 
            </tr>
            
        </table>
    </div>

    
<? include_once("$g4[path]/js_menu11/menu.php");?>
</div><!-- 상단 div - header 끝 -->

<!-- 중간의 메인부 시작 -->
<div id="container"<?=$content_stl?>>

<!-- 메인 content 메뉴 시작 -->
<div id="content" style='width:100%;float:left;'>

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