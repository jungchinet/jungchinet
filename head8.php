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


<style type="text/css">
#wrap {
	width: 1100px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
#left_picture0 {
	height: 300px;
	width: 170px;
	padding-top: 10px;
	padding-bottom: 40px;
	float: left;
	text-align:center;
}
#right_picture0 {
	height: 300px;
	width: 170px;
	padding-top: 10px;
	padding-bottom: 40px;
	float: left;
	text-align:center;
}
#center_picture0 {
	height: 300px;
	width: 760px;
	padding-top: 10px;
	padding-bottom: 40px;
	float: left;
}
#center_picture1 {
	height: 70px;
	width: 1100px;
	padding-top: 0px;
	padding-bottom: 0px;
	float: left;
}
#main_picture0 {
	height: 300px;
	width: 1100px;
	padding-top: 10px;
	padding-bottom: 40px;
	
}
#main_picture {
	height: 638px;
	width: 1100px;
	padding-top: 5px;
	padding-bottom: 40px;
}
#main_picture2 {
	height: 1820px;
	width: 1100px;
	padding-top: 10px;
}
#listpagebody1 {
	
	height: 470px;
	width: 1100px;
	padding-top: 5px;
	padding-bottom: 20px;
}
.wrbody1 {
	height: 95px;
	width: 1100px;
	padding-top: 5px;
	padding-bottom: 50px;
	font-size: 10px;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;    
}
.list01 {
	float: left;
	height: 319px;
	width: 148px;

}
.list02 {
	float: left;
	height: 319px;
	width: 148px;

}
.list03 {
	float: left;
	height: 319px;
	width: 148px;

}
.list04 {
	float: left;
	height: 319px;
	width: 148px;

}
.list05 {
	float: left;
	height: 319px;
	width: 148px;

}
ul {
	list-style-type: none;
	color: #000;
	text-decoration: none;
}

a:link {
	text-decoration: none;
}

body,td,th {
	font-family: Verdana, Geneva, sans-serif;
}
#wrap .wrbody1 p {
	font-size: 18px;
}
</style>



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
      	  <?
    // 투표
    include_once("$g4[path]/lib/poll.lib.php");
	poll(); //전체
    ?>
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


<div id="main_picture0">
	<div id="left_picture0">
	  <h1><a href='/bbs/board.php?bo_table=battle01'>자유게시판</a></h1>
    <h2><a href='/bbs/board.php?bo_table=ask01'>운영자게시판</a></h2>  
    <p><a href='/bbs/board.php?bo_table=miniparty10'>백수</a>
    &nbsp;&nbsp;<a href='/bbs/board.php?bo_table=miniparty01'>자영업자</a></p>
    <p><a href='/bbs/board.php?bo_table=miniparty02'>회사원&nbsp; &nbsp; </a>
    <a href='/bbs/board.php?bo_table=miniparty03'> 공무원</a></p>
    <p><a href='/bbs/board.php?bo_table=miniparty04'>비정규직</a>
    <a href='/bbs/board.php?bo_table=miniparty05'>&nbsp;&nbsp; 서비스직</a></p>
    <p><a href='/bbs/board.php?bo_table=miniparty06'>일용직</a>
  &nbsp;&nbsp;<a href='/bbs/board.php?bo_table=miniparty07'> 알바 &nbsp; </a></p>
    <p><a href='/bbs/board.php?bo_table=miniparty08'>학생</a>
    <a href='/bbs/board.php?bo_table=miniparty09'>&nbsp;&nbsp; 주부</a></p>
    <p><a href='/bbs/board.php?bo_table=miniparty11'>영화인</a>
    <a href='/bbs/board.php?bo_table=miniparty12'>&nbsp;&nbsp;뮤지션</a></p>
    <p><a href='/bbs/board.php?bo_table=miniparty13'>게임IT</a>
    <a href='/bbs/board.php?bo_table=miniparty14'>&nbsp;&nbsp;만화가</a></p></div>
    
	<div id="center_picture0">
	<div class="list01"><a href='http://www.president.go.kr/' target="_blank"><img src="/images/newyear1.jpg" width="148" height="319"></a></div>
	<div class="list02"><a href='http://www.saenuriparty.kr/intro.jsp' target="_blank"><img src="/images/newyear2.jpg" width="148" height="319"></a></div>
	<div class="list03"><a href='http://npad.kr/' target="_blank"><img src="/images/newyear3.jpg" width="148" height="319"></a></div>
	<div class="list04"><a href='http://people21.kr/' target="_blank"><img src="/images/newyear4.jpg" width="148" height="319"></a></div>
	<div class="list05"><a href='http://www.justice21.org/' target="_blank"><img src="/images/newyear5.jpg" width="148" height="319"></a></div> 
	</div>
    <!--<div id="center_picture0"><a href='http://info.nec.go.kr/main/showDocument.xhtml?electionId=0020160413&topMenuId=BI&secondMenuId=BIES01' target="_blank"><img src="/images/20vote.gif" width="740" height="303"></a> </div>-->
    
	<div id="right_picture0">
	
    <p><h1><a href='/bbs/board.php?bo_table=mparty03'>불교</a></h1></p>
    <p><h1><a href='/bbs/board.php?bo_table=mparty04'>개신교</a></h1></p>
    <p><h1><a href='/bbs/board.php?bo_table=mparty05'>천주교</a></h1></p>
    <p><h2><a href="/bbs/board.php?bo_table=mparty02">시민단체</a></h2></p>
    <p><a href='/menuhtml/ns/ns.php'><img src="<?=$g4[path]?>/images/news2.gif" width="131" height="105"  align=absmiddle alt="신문"></a></p>
    </div>
</div>

<div id="center_picture1">
<p><center><h1>제20대 국회의원 임기 <font color=#a21e21>5월 30일</font></font> 시작</h1></center></p>
</div>


<div id="main_picture"><img src="../../menuhtml/kh/kh.gif" alt="국회의석배치" width="1100" height="648" usemap="#Map" border="0" />
   <map name="Map" id="Map">
     <area shape="circle" coords="419,195,11" href="/bbs/board.php?bo_table=seoul_b43" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강석진 1-1-2" />
<area shape="circle" coords="443,210,11" href="/bbs/board.php?bo_table=seoul_a07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정유섭 1-1-3" />

<area shape="circle" coords="358,184,11" href="/bbs/board.php?bo_table=seoul_a93" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤종오 1-2-1" />
<area shape="circle" coords="377,206,11" href="/bbs/board.php?bo_table=kmberye01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김삼화 1-2-2" />
<area shape="circle" coords="400,224,11" href="/bbs/board.php?bo_table=seoul_b23" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최교일 1-2-3" />
<area shape="circle" coords="425,240,11" href="/bbs/board.php?bo_table=seoul_b40" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김한표 1-2-4" />

<area shape="circle" coords="317,194,11" href="/bbs/board.php?bo_table=seoul_a92" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김종훈 1-3-1" />
<area shape="circle" coords="331,215,11" href="/bbs/board.php?bo_table=kmberye02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김수민 1-3-2" />
<area shape="circle" coords="347,232,11" href="/bbs/board.php?bo_table=kmberye03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김중로 1-3-3" />
<area shape="circle" coords="366,246,11" href="/bbs/board.php?bo_table=seoul_b28" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박완수 1-3-4" />
<area shape="circle" coords="386,257,11" href="/bbs/board.php?bo_table=seoul_a80" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김상훈 1-3-5" />
<area shape="circle" coords="407,267,11" href="/bbs/board.php?bo_table=seoul_b00" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이진복 1-3-6" />

<area shape="circle" coords="275,205,11" href="/bbs/board.php?bo_table=seoul_a82" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="홍의락 1-4-1" />
<area shape="circle" coords="288,226,11" href="/bbs/board.php?bo_table=kmberye05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박주현 1-4-2" />
<area shape="circle" coords="306,244,11" href="/bbs/board.php?bo_table=kmberye06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="신용현 1-4-3" />
<area shape="circle" coords="324,260,11" href="/bbs/board.php?bo_table=kmberye07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="오세정 1-4-4" />
<area shape="circle" coords="344,274,11" href="/bbs/board.php?bo_table=seoul_b39" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="엄용수 1-4-5" />
<area shape="circle" coords="365,286,11" href="/bbs/board.php?bo_table=seoul_28" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김용태 1-4-6" />
<area shape="circle" coords="386,297,11" href="/bbs/board.php?bo_table=seoul_a67" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정운천 1-4-7" />

<area shape="circle" coords="232,217,11" href="/bbs/board.php?bo_table=jbe04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="추혜선 1-5-1" />
<area shape="circle" coords="245,239,11" href="/bbs/board.php?bo_table=kmberye08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이동섭 1-5-2" />
<area shape="circle" coords="262,259,11" href="/bbs/board.php?bo_table=kmberye11" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="장정숙 1-5-3" />
<area shape="circle" coords="281,274,11" href="/bbs/board.php?bo_table=kmberye12" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최이배 1-5-4" />
<area shape="circle" coords="300,289,11" href="/bbs/board.php?bo_table=kmberye13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최도자 1-5-5" />
<area shape="circle" coords="321,301,11" href="/bbs/board.php?bo_table=seoul_a32" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김태흠 1-5-6" />
<area shape="circle" coords="343,314,11" href="/bbs/board.php?bo_table=berye04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김순례 1-5-7" />
<area shape="circle" coords="367,327,11" href="/bbs/board.php?bo_table=seoul_a39" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정우택 1-5-8" />

<area shape="circle" coords="186,229,11" href="/bbs/board.php?bo_table=jbe03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이정미 1-6-1" />
<area shape="circle" coords="201,251,11" href="/bbs/board.php?bo_table=seoul_a59" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="손금주 1-6-2" />
<area shape="circle" coords="217,273,11" href="/bbs/board.php?bo_table=seoul_a63" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤영일 1-6-3" />
<area shape="circle" coords="240,292,11" href="/bbs/board.php?bo_table=seoul_a56" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이용주 1-6-4" />
<area shape="circle" coords="264,312,11" href="/bbs/board.php?bo_table=seoul_a60" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정인화 1-6-5" />
<area shape="circle" coords="291,328,11" href="/bbs/board.php?bo_table=seoul_b32" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤한홍 1-6-6" />
<area shape="circle" coords="319,342,11" href="/bbs/board.php?bo_table=berye09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="송희경 1-6-7" />
<area shape="circle" coords="347,354,11" href="/bbs/board.php?bo_table=berye08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="문진국 1-6-8" />

<area shape="circle" coords="145,240,11" href="/bbs/board.php?bo_table=jbe02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤소하 1-7-1" />
<area shape="circle" coords="156,262,11" href="/bbs/board.php?bo_table=seoul_a51" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김경진 1-7-2" />
<area shape="circle" coords="170,283,11" href="/bbs/board.php?bo_table=seoul_a66" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김광수 1-7-3" />
<area shape="circle" coords="187,303,11" href="/bbs/board.php?bo_table=kmberye10" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이태규 1-7-4" />
<area shape="circle" coords="209,318,11" href="/bbs/board.php?bo_table=seoul_a73" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이용호 1-7-5" />
<area shape="circle" coords="229,334,11" href="/bbs/board.php?bo_table=seoul_a74" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김종회 1-7-6" />
<area shape="circle" coords="252,347,11" href="/bbs/board.php?bo_table=seoul_39" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="오신환 1-7-7" />
<area shape="circle" coords="275,361,11" href="/bbs/board.php?bo_table=seoul_a14" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김기선 1-7-8" />
<area shape="circle" coords="299,372,11" href="/bbs/board.php?bo_table=berye17" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최연혜 1-7-9" />
<area shape="circle" coords="324,385,11" href="/bbs/board.php?bo_table=berye16" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="조훈현 1-7-10" />

<area shape="circle" coords="100,251,11" href="/bbs/board.php?bo_table=jbe01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김종대 1-8-1" />
<area shape="circle" coords="116,274,11" href="/bbs/board.php?bo_table=kmberye04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박선숙 1-8-2" />
<area shape="circle" coords="134,297,11" href="/bbs/board.php?bo_table=kmberye09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이상돈 1-8-3" />
<area shape="circle" coords="152,319,11" href="/bbs/board.php?bo_table=seoul_a64" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박준영 1-8-4" />
<area shape="circle" coords="175,341,11" href="/bbs/board.php?bo_table=seoul_a48" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="송기석 1-8-5" />
<area shape="circle" coords="199,360,11" href="/bbs/board.php?bo_table=seoul_a52" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최경환 1-8-6" />
<area shape="circle" coords="227,377,11" href="/bbs/board.php?bo_table=seoul_73" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김명연 1-8-7" />
<area shape="circle" coords="254,392,11" href="/bbs/board.php?bo_table=seoul_b04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김도읍 1-8-8" />
<area shape="circle" coords="278,403,11" href="/bbs/board.php?bo_table=seoul_a33" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이명수 1-8-9" />
<area shape="circle" coords="303,417,11" href="/bbs/board.php?bo_table=seoul_b13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김정재 1-8-10" />

<area shape="circle" coords="62,262,11" href="/bbs/board.php?bo_table=seoul_b29" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="노회찬 1-9-1" />
<area shape="circle" coords="74,285,11" href="/bbs/board.php?bo_table=seoul_a61" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="황주홍 1-9-2" />
<area shape="circle" coords="89,306,11" href="/bbs/board.php?bo_table=seoul_a71" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="조배숙 1-9-3" />
<area shape="circle" coords="105,326,11" href="/bbs/board.php?bo_table=seoul_a50" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="장병완 1-9-4" />
<area shape="circle" coords="122,343,11" href="/bbs/board.php?bo_table=seoul_a72" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유성엽 1-9-5" />
<area shape="circle" coords="140,362,11" href="/bbs/board.php?bo_table=seoul_38" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김성식 1-9-6" />
<area shape="circle" coords="161,379,11" href="/bbs/board.php?bo_table=seoul_a54" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="권은희 1-9-7" />
<area shape="circle" coords="184,395,11" href="/bbs/board.php?bo_table=seoul_a69" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김관영 1-9-8" />
<area shape="circle" coords="206,408,11" href="/bbs/board.php?bo_table=seoul_b16" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이철우 1-9-9" />
<area shape="circle" coords="232,421,11" href="/bbs/board.php?bo_table=seoul_a27" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정용기 1-9-10" />
<area shape="circle" coords="258,433,11" href="/bbs/board.php?bo_table=seoul_a31" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정진석 1-9-11" />
<area shape="circle" coords="283,447,11" href="/bbs/board.php?bo_table=seoul_b36" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="여상규 1-9-12" />

<area shape="circle" coords="27,271,11" href="/bbs/board.php?bo_table=seoul_75" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="심상정 1-10-1" />
<area shape="circle" coords="38,297,11" href="/bbs/board.php?bo_table=seoul_a53" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김동철 1-10-2" />
<area shape="circle" coords="54,321,11" href="/bbs/board.php?bo_table=seoul_a68" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정동영 1-10-3" />
<area shape="circle" coords="71,346,11" href="/bbs/board.php?bo_table=seoul_20" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안철수 1-10-4" />
<area shape="circle" coords="93,368,11" href="/bbs/board.php?bo_table=seoul_a57" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="주승용 1-10-5" />
<area shape="circle" coords="116,388,11" href="/bbs/board.php?bo_table=seoul_a49" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="천정배 1-10-6" />
<area shape="circle" coords="138,406,11" href="/bbs/board.php?bo_table=seoul_a47" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박주선 1-10-7" />
<area shape="circle" coords="161,424,11" href="/bbs/board.php?bo_table=seoul_a55" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박지원 1-10-8" />
<area shape="circle" coords="186,440,11" href="/bbs/board.php?bo_table=seoul_a00" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정병국 1-10-9" />
<area shape="circle" coords="212,454,11" href="/bbs/board.php?bo_table=seoul_b31" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이주영 1-10-10" />
<area shape="circle" coords="235,467,11" href="/bbs/board.php?bo_table=seoul_40" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이혜훈 1-10-11" />
<area shape="circle" coords="264,476,11" href="/bbs/board.php?bo_table=seoul_61" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="심재철 1-10-12" />

<area shape="circle" coords="488,228,11" href="/bbs/board.php?bo_table=seoul_92" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="송석준 2-1-1" />
<area shape="circle" coords="516,234,11" href="/bbs/board.php?bo_table=seoul_701" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김성원 2-1-2" />

<area shape="circle" coords="464,256,11" href="/bbs/board.php?bo_table=seoul_44" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박인숙 2-2-1" />
<area shape="circle" coords="492,264,11" href="/bbs/board.php?bo_table=seoul_b33" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박대출 2-2-2" />
<area shape="circle" coords="522,270,11" href="/bbs/board.php?bo_table=seoul_a86" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤재옥 2-2-3" />

<area shape="circle" coords="444,284,11" href="/bbs/board.php?bo_table=seoul_89" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이현재 2-3-1" />
<area shape="circle" coords="469,295,11" href="/bbs/board.php?bo_table=seoul_a18" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이양수 2-3-2" />
<area shape="circle" coords="496,301,11" href="/bbs/board.php?bo_table=seoul_a20" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="염동열 2-3-3" />
<area shape="circle" coords="525,304,11" href="/bbs/board.php?bo_table=seoul_a23" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이은권 2-3-4" />

<area shape="circle" coords="425,312,11" href="/bbs/board.php?bo_table=seoul_a34" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="성일종 2-4-1" />
<area shape="circle" coords="448,323,11" href="/bbs/board.php?bo_table=seoul_b11" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유재중 2-4-2" />
<area shape="circle" coords="474,332,11" href="/bbs/board.php?bo_table=seoul_a29" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박찬우 2-4-3" />
<area shape="circle" coords="501,335,11" href="/bbs/board.php?bo_table=seoul_a43" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="권석창 2-4-4" />
<area shape="circle" coords="526,337,11" href="/bbs/board.php?bo_table=seoul_99" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김영우 2-4-5" />

<area shape="circle" coords="407,341,11" href="/bbs/board.php?bo_table=berye02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김규환 2-5-1" />
<area shape="circle" coords="430,353,11" href="/bbs/board.php?bo_table=berye03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김성태 2-5-2" />
<area shape="circle" coords="453,361,11" href="/bbs/board.php?bo_table=seoul_a96" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유기준 2-5-3" />
<area shape="circle" coords="475,367,11" href="/bbs/board.php?bo_table=berye05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김승희 2-5-4" />
<area shape="circle" coords="500,372,11" href="/bbs/board.php?bo_table=berye06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김종석 2-5-5" />
<area shape="circle" coords="524,373,11" href="/bbs/board.php?bo_table=seoul_30" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김성태 2-5-6" />

<area shape="circle" coords="389,372,11" href="/bbs/board.php?bo_table=seoul_a01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안상수 2-6-1" />
<area shape="circle" coords="416,385,11" href="/bbs/board.php?bo_table=seoul_a46" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="경대수 2-6-2" />
<area shape="circle" coords="443,394,11" href="/bbs/board.php?bo_table=seoul_b26" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김종태 2-6-3" />
<area shape="circle" coords="470,401,11" href="/bbs/board.php?bo_table=seoul_a17" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이철규 2-6-4" />
<area shape="circle" coords="498,405,11" href="/bbs/board.php?bo_table=berye07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김현아 2-6-5" />
<area shape="circle" coords="524,407,11" href="/bbs/board.php?bo_table=seoul_b27" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강석호 2-6-6" />

<area shape="circle" coords="371,403,11" href="/bbs/board.php?bo_table=seoul_a37" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="홍문표 2-7-1" />
<area shape="circle" coords="401,416,11" href="/bbs/board.php?bo_table=seoul_a85" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="곽대훈 2-7-2" />
<area shape="circle" coords="432,427,11" href="/bbs/board.php?bo_table=seoul_a77" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="곽상도 2-7-3" />
<area shape="circle" coords="462,435,11" href="/bbs/board.php?bo_table=seoul_b15" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김석기 2-7-4" />
<area shape="circle" coords="494,439,11" href="/bbs/board.php?bo_table=seoul_a94" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강길부 2-7-5" />
<area shape="circle" coords="524,439,11" href="/bbs/board.php?bo_table=seoul_a81" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정태옥 2-7-6" />

<area shape="circle" coords="347,433,11" href="/bbs/board.php?bo_table=seoul_b18" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="백승주 2-8-1" />
<area shape="circle" coords="373,443,11" href="/bbs/board.php?bo_table=seoul_b19" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="장석춘 2-8-2" />
<area shape="circle" coords="398,452,11" href="/bbs/board.php?bo_table=seoul_b21" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이만희 2-8-3" />
<area shape="circle" coords="422,461,11" href="/bbs/board.php?bo_table=seoul_b06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤상직 2-8-4" />
<area shape="circle" coords="447,467,11" href="/bbs/board.php?bo_table=seoul_b12" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="장제원 2-8-5" />
<area shape="circle" coords="473,469,11" href="/bbs/board.php?bo_table=seoul_a78" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정종섭 2-8-6" />
<area shape="circle" coords="497,472,11" href="/bbs/board.php?bo_table=seoul_b05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="배덕광 2-8-7" />
<area shape="circle" coords="525,473,11" href="/bbs/board.php?bo_table=seoul_a88" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="추경호 2-8-8" />

<area shape="circle" coords="328,464,11" href="/bbs/board.php?bo_table=seoul_b42" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤영석 2-9-1" />
<area shape="circle" coords="355,473,11" href="/bbs/board.php?bo_table=seoul_821" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="주광덕 2-9-2" />
<area shape="circle" coords="382,483,11" href="/bbs/board.php?bo_table=seoul_74" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박순자 2-9-3" />
<area shape="circle" coords="409,492,11" href="/bbs/board.php?bo_table=seoul_a16" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="권성동 2-9-4" />
<area shape="circle" coords="436,498,11" href="/bbs/board.php?bo_table=seoul_14" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정양석 2-9-5" />
<area shape="circle" coords="464,502,11" href="/bbs/board.php?bo_table=seoul_b35" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이군현 2-9-6" />
<area shape="circle" coords="495,504,11" href="/bbs/board.php?bo_table=seoul_431" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이은재 2-9-7" />
<area shape="circle" coords="522,507,11" href="/bbs/board.php?bo_table=seoul_96" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김학용 2-9-8" />

<area shape="circle" coords="307,495,11" href="/bbs/board.php?bo_table=seoul_a89" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정갑윤 2-10-1" />
<area shape="circle" coords="337,505,11" href="/bbs/board.php?bo_table=seoul_a84" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="주호영 2-10-2" />
<area shape="circle" coords="368,514,11" href="/bbs/board.php?bo_table=seoul_a79" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유승민 2-10-3" />
<area shape="circle" coords="399,521,11" href="/bbs/board.php?bo_table=seoul_37" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="나경원 2-10-4" />
<area shape="circle" coords="430,527,11" href="/bbs/board.php?bo_table=seoul_a58" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이정현 2-10-5" />
<area shape="circle" coords="461,531,11" href="/bbs/board.php?bo_table=seoul_a03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤상현 2-10-6" />
<area shape="circle" coords="492,534,11" href="/bbs/board.php?bo_table=seoul_84" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="서청원 2-10-7" />
<area shape="circle" coords="522,535,11" href="/bbs/board.php?bo_table=seoul_a97" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김무성 2-10-8" />

<area shape="circle" coords="574,234,11" href="/bbs/board.php?bo_table=seoul_41" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박성중 3-1-1" />
<area shape="circle" coords="600,229,11" href="/bbs/board.php?bo_table=seoul_b10" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김해영 3-1-2" />

<area shape="circle" coords="571,269,11" href="/bbs/board.php?bo_table=seoul_a45" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박덕흠 3-2-1" />
<area shape="circle" coords="597,266,11" href="/bbs/board.php?bo_table=seoul_a99" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이헌승 3-2-2" />
<area shape="circle" coords="625,260,11" href="/bbs/board.php?bo_table=seoul_b02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박재호 3-2-3" />

<area shape="circle" coords="571,303,11" href="/bbs/board.php?bo_table=seoul_b061" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="하태경 3-3-1" />
<area shape="circle" coords="596,300,11" href="/bbs/board.php?bo_table=seoul_93" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이우현 3-3-2" />
<area shape="circle" coords="622,294,11" href="/bbs/board.php?bo_table=seoul_a02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="홍일표 3-3-3" />
<area shape="circle" coords="647,287,11" href="/bbs/board.php?bo_table=seoul_b03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전재수 3-3-4" />

<area shape="circle" coords="571,337,11" href="/bbs/board.php?bo_table=seoul_05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="지상욱 3-4-1" />
<area shape="circle" coords="597,335,11" href="/bbs/board.php?bo_table=seoul_b25" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이완영 3-4-2" />
<area shape="circle" coords="622,331,11" href="/bbs/board.php?bo_table=berye01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강효상 3-4-3" />
<area shape="circle" coords="647,324,11" href="/bbs/board.php?bo_table=berye10" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="신보라 3-4-4" />
<area shape="circle" coords="671,317,11" href="/bbs/board.php?bo_table=seoul_b07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최인호 3-4-5" />

<area shape="circle" coords="571,373,11" href="/bbs/board.php?bo_table=seoul_b14" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박명재 3-5-1" />
<area shape="circle" coords="596,372,11" href="/bbs/board.php?bo_table=seoul_54" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="신상진 3-5-2" />
<area shape="circle" coords="622,368,11" href="/bbs/board.php?bo_table=seoul_a22" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이장우 3-5-3" />
<area shape="circle" coords="646,362,11" href="/bbs/board.php?bo_table=seoul_a13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김진태 3-5-4" />
<area shape="circle" coords="669,354,11" href="/bbs/board.php?bo_table=mbe10" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김성수 3-5-5" />
<area shape="circle" coords="692,347,11" href="/bbs/board.php?bo_table=mbe11" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="권미혁 3-5-6" />

<area shape="circle" coords="570,407,11" href="/bbs/board.php?bo_table=seoul_a42" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이종배 3-6-1" />
<area shape="circle" coords="595,407,11" href="/bbs/board.php?bo_table=berye15" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전희경 3-6-2" />
<area shape="circle" coords="620,404,11" href="/bbs/board.php?bo_table=berye14" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="임이자 3-6-3" />
<area shape="circle" coords="645,401,11" href="/bbs/board.php?bo_table=berye13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이종명 3-6-4" />
<area shape="circle" coords="669,394,11" href="/bbs/board.php?bo_table=berye12" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤종필 3-6-5" />
<area shape="circle" coords="692,386,11" href="/bbs/board.php?bo_table=mbe07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="문미옥 3-6-6" />
<area shape="circle" coords="714,377,11" href="/bbs/board.php?bo_table=mbe06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김현권 3-6-7" />

<area shape="circle" coords="572,439,11" href="/bbs/board.php?bo_table=seoul_86" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="함진규 3-7-1" />
<area shape="circle" coords="608,438,11" href="/bbs/board.php?bo_table=seoul_971" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="홍철호 3-7-2" />
<area shape="circle" coords="639,435,11" href="/bbs/board.php?bo_table=seoul_b09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김세연 3-7-3" />
<area shape="circle" coords="670,428,11" href="/bbs/board.php?bo_table=seoul_b30" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김성찬 3-7-4" />
<area shape="circle" coords="700,417,11" href="/bbs/board.php?bo_table=mbe03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="송옥주 3-7-5" />
<area shape="circle" coords="727,406,11" href="/bbs/board.php?bo_table=mbe01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박경미 3-7-6" />

<area shape="circle" coords="571,473,11" href="/bbs/board.php?bo_table=berye11" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유민봉 3-8-1" />
<area shape="circle" coords="599,473,11" href="/bbs/board.php?bo_table=seoul_a041" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="민경욱 3-8-2" />
<area shape="circle" coords="627,472,11" href="/bbs/board.php?bo_table=seoul_69" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유의동 3-8-3" />
<area shape="circle" coords="653,469,11" href="/bbs/board.php?bo_table=seoul_a11" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이학재 3-8-4" />
<area shape="circle" coords="678,463,11" href="/bbs/board.php?bo_table=seoul_a21" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="황영철 3-8-5" />
<area shape="circle" coords="702,456,11" href="/bbs/board.php?bo_table=seoul_b08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="조경태 3-8-6" />
<area shape="circle" coords="728,447,11" href="/bbs/board.php?bo_table=mbe05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이재정 3-8-7" />
<area shape="circle" coords="750,437,11" href="/bbs/board.php?bo_table=mbe12" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이용득 3-8-8" />

<area shape="circle" coords="574,504,11" href="/bbs/board.php?bo_table=seoul_a91" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박맹우 3-9-1" />
<area shape="circle" coords="604,506,11" href="/bbs/board.php?bo_table=seoul_42" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이종구 3-9-2" />
<area shape="circle" coords="632,504,11" href="/bbs/board.php?bo_table=seoul_17" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김선동 3-9-3" />
<area shape="circle" coords="661,498,11" href="/bbs/board.php?bo_table=seoul_b17" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김광림 3-9-4"  />
<area shape="circle" coords="689,495,11" href="/bbs/board.php?bo_table=seoul_a90" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이채익 3-9-5" />
<area shape="circle" coords="717,486,11" href="/bbs/board.php?bo_table=seoul_b34" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김재경 3-9-6" />
<area shape="circle" coords="743,478,11" href="/bbs/board.php?bo_table=mbe09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="제윤경 3-9-7" />
<area shape="circle" coords="770,467,11" href="/bbs/board.php?bo_table=mbe13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정춘숙 3-9-8" />

<area shape="circle" coords="574,535,11" href="/bbs/board.php?bo_table=seoul_68" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="원유철 3-10-1" />
<area shape="circle" coords="608,534,11" href="/bbs/board.php?bo_table=seoul_b01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김정훈 3-10-2" />
<area shape="circle" coords="640,530,11" href="/bbs/board.php?bo_table=seoul_58" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="홍문종 3-10-3" />
<area shape="circle" coords="672,527,11" href="/bbs/board.php?bo_table=seoul_94" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="한선교 3-10-4" />
<area shape="circle" coords="703,521,11" href="/bbs/board.php?bo_table=seoul_b24" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최경환 3-10-5" />
<area shape="circle" coords="734,513,11" href="/bbs/board.php?bo_table=seoul_a87" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="조원진 3-10-6" />
<area shape="circle" coords="762,506,11" href="/bbs/board.php?bo_table=mbe08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이철희 3-10-7" />
<area shape="circle" coords="791,494,11" href="/bbs/board.php?bo_table=seoul_55" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김병관 3-10-8" />

<area shape="circle" coords="644,211,11" href="/bbs/board.php?bo_table=seoul_27" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="황희 4-1-1" />
<area shape="circle" coords="663,197,11" href="/bbs/board.php?bo_table=seoul_851" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="권칠승 4-1-2" />

<area shape="circle" coords="666,242,11" href="/bbs/board.php?bo_table=seoul_a06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤관석 4-2-1" />
<area shape="circle" coords="690,229,11" href="/bbs/board.php?bo_table=seoul_a05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박남춘 4-2-2" />
<area shape="circle" coords="711,212,11" href="/bbs/board.php?bo_table=seoul_85" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이원욱 4-2-3" />
<area shape="circle" coords="723,190,11" href="/bbs/board.php?bo_table=seoul_a30" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박완주 4-2-4" />

<area shape="circle" coords="686,270,11" href="/bbs/board.php?bo_table=seoul_53" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김태년 4-3-1" />
<area shape="circle" coords="708,262,11" href="/bbs/board.php?bo_table=seoul_b46" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="위성곤 4-3-2" />
<area shape="circle" coords="728,252,11" href="/bbs/board.php?bo_table=seoul_a08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="홍영표 4-3-3" />
<area shape="circle" coords="745,237,11" href="/bbs/board.php?bo_table=mbe04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최운열 4-3-4" />
<area shape="circle" coords="756,219,11" href="/bbs/board.php?bo_table=seoul_56" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김병욱 4-3-5" />
<area shape="circle" coords="766,200,11" href="/bbs/board.php?bo_table=seoul_66" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="백재현 4-3-6" />

<area shape="circle" coords="707,300,11" href="/bbs/board.php?bo_table=seoul_a41" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="도종환 4-4-1" />
<area shape="circle" coords="730,292,11" href="/bbs/board.php?bo_table=seoul_51" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김영진 4-4-2" />
<area shape="circle" coords="751,279,11" href="/bbs/board.php?bo_table=seoul_46" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="남인순 4-4-3" />
<area shape="circle" coords="770,267,11" href="/bbs/board.php?bo_table=seoul_88" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김정우 4-4-4" />
<area shape="circle" coords="788,252,11" href="/bbs/board.php?bo_table=seoul_72" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김철민 4-4-5" />
<area shape="circle" coords="801,232,11" href="/bbs/board.php?bo_table=seoul_82" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김한정 4-4-6" />
<area shape="circle" coords="809,210,11" href="/bbs/board.php?bo_table=seoul_91" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박정 4-4-7" />

<area shape="circle" coords="729,330,11" href="/bbs/board.php?bo_table=seoul_50" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="백혜련 4-5-1" />
<area shape="circle" coords="751,319,11" href="/bbs/board.php?bo_table=seoul_16" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="인재근 4-5-2" />
<area shape="circle" coords="774,308,11" href="/bbs/board.php?bo_table=seoul_98" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="소병훈 4-5-3" />
<area shape="circle" coords="796,297,11" href="/bbs/board.php?bo_table=seoul_301" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="한정애 4-5-4" />
<area shape="circle" coords="815,281,11" href="/bbs/board.php?bo_table=seoul_79" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="신창현 4-5-5" />
<area shape="circle" coords="831,262,11" href="/bbs/board.php?bo_table=seoul_47" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="진선미 4-5-6" />
<area shape="circle" coords="847,244,11" href="/bbs/board.php?bo_table=seoul_981" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="임종성 4-5-7" />
<area shape="circle" coords="856,221,11" href="/bbs/board.php?bo_table=seoul_76" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정재호 4-5-8" />

<area shape="circle" coords="750,361,11" href="/bbs/board.php?bo_table=seoul_a301" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="양승조 4-6-1" />
<area shape="circle" coords="777,348,11" href="/bbs/board.php?bo_table=seoul_941" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="표창원 4-6-2" />
<area shape="circle" coords="802,333,11" href="/bbs/board.php?bo_table=seoul_31" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이인영 4-6-3" />
<area shape="circle" coords="827,318,11" href="/bbs/board.php?bo_table=seoul_19" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="우원식 4-6-4" />
<area shape="circle" coords="851,298,11" href="/bbs/board.php?bo_table=seoul_34" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김영주 4-6-5" />
<area shape="circle" coords="870,277,11" href="/bbs/board.php?bo_table=seoul_35" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="신경민 4-6-6" />
<area shape="circle" coords="885,255,11" href="/bbs/board.php?bo_table=seoul_48" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="심재권 4-6-7" />
<area shape="circle" coords="899,232,11" href="/bbs/board.php?bo_table=seoul_80" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤호중 4-6-8" />

<area shape="circle" coords="773,388,11" href="/bbs/board.php?bo_table=seoul_90" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="윤후덕 4-7-1" />
<area shape="circle" coords="798,376,11" href="/bbs/board.php?bo_table=seoul_a04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박찬대 4-7-2" />
<area shape="circle" coords="822,362,11" href="/bbs/board.php?bo_table=seoul_a12" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="신동근 4-7-3" />
<area shape="circle" coords="845,351,11" href="/bbs/board.php?bo_table=seoul_a09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유동수 4-7-4" />
<area shape="circle" coords="864,335,11" href="/bbs/board.php?bo_table=seoul_a15" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="송기헌 4-7-5" />
<area shape="circle" coords="884,320,11" href="/bbs/board.php?bo_table=seoul_71" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전해철 4-7-6" />
<area shape="circle" coords="901,302,11" href="/bbs/board.php?bo_table=seoul_10" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="서영교 4-7-7" />
<area shape="circle" coords="918,283,11" href="/bbs/board.php?bo_table=seoul_a44" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="변재일 4-7-8" />
<area shape="circle" coords="933,264,11" href="/bbs/board.php?bo_table=seoul_78" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김현미 4-7-9" />
<area shape="circle" coords="944,242,11" href="/bbs/board.php?bo_table=seoul_a261" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="조승래 4-7-10" />

<area shape="circle" coords="795,417,11" href="/bbs/board.php?bo_table=seoul_08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안규백 4-8-1" />
<area shape="circle" coords="822,401,11" href="/bbs/board.php?bo_table=seoul_b38" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김경수 4-8-2" />
<area shape="circle" coords="851,386,11" href="/bbs/board.php?bo_table=seoul_a331" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강훈식 4-8-3" />
<area shape="circle" coords="876,369,11" href="/bbs/board.php?bo_table=seoul_a65" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이개호 4-8-4" />
<area shape="circle" coords="899,351,11" href="/bbs/board.php?bo_table=seoul_a35" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김종민 4-8-5" />
<area shape="circle" coords="921,334,11" href="/bbs/board.php?bo_table=seoul_a38" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="어기구 4-8-6" />
<area shape="circle" coords="941,315,11" href="/bbs/board.php?bo_table=seoul_95" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김민기 4-8-7" />
<area shape="circle" coords="957,296,11" href="/bbs/board.php?bo_table=seoul_a75" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안호영 4-8-8" />
<area shape="circle" coords="974,276,11" href="/bbs/board.php?bo_table=seoul_67" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이언주 4-8-9" />
<area shape="circle" coords="986,252,11" href="/bbs/board.php?bo_table=seoul_77" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유은혜 4-8-10" />

<area shape="circle" coords="815,447,11" href="/bbs/board.php?bo_table=seoul_b421" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="서형수 4-9-1" />
<area shape="circle" coords="839,435,11" href="/bbs/board.php?bo_table=seoul_23" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="우상호 4-9-2" />
<area shape="circle" coords="862,419,11" href="/bbs/board.php?bo_table=seoul_b45" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="오영훈 4-9-3" />
<area shape="circle" coords="885,405,11" href="/bbs/board.php?bo_table=seoul_a98" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김영춘 4-9-4" />
<area shape="circle" coords="906,392,11" href="/bbs/board.php?bo_table=seoul_87" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="조정식 4-9-5" />
<area shape="circle" coords="926,377,11" href="/bbs/board.php?bo_table=seoul_26" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="손혜원 4-9-6" />
<area shape="circle" coords="946,361,11" href="/bbs/board.php?bo_table=seoul_81" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="조응천 4-9-7" />
<area shape="circle" coords="968,345,11" href="/bbs/board.php?bo_table=seoul_52" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박광온 4-9-8" />
<area shape="circle" coords="986,326,11" href="/bbs/board.php?bo_table=seoul_09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="민병두 4-9-9" />
<area shape="circle" coords="1002,305,11" href="/bbs/board.php?bo_table=seoul_b37" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="민홍철 4-9-10" />
<area shape="circle" coords="1016,283,11" href="/bbs/board.php?bo_table=seoul_a70" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이춘석 4-9-11" />
<area shape="circle" coords="1027,260,11" href="/bbs/board.php?bo_table=seoul_97" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김두관 4-9-12" />

<area shape="circle" coords="836,474,11" href="/bbs/board.php?bo_table=seoul_32" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박영선 4-10-1" />
<area shape="circle" coords="864,460,11" href="/bbs/board.php?bo_table=seoul_01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정세균 4-10-2" />
<area shape="circle" coords="889,445,11" href="/bbs/board.php?bo_table=seoul_57" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="문희상 4-10-3" />
<area shape="circle" coords="914,430,11" href="/bbs/board.php?bo_table=city05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이해찬 4-10-4" />
<area shape="circle" coords="936,415,11" href="/bbs/board.php?bo_table=seoul_07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="추미애 4-10-5" />
<area shape="circle" coords="960,399,11" href="/bbs/board.php?bo_table=seoul_12" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유승희 4-10-6" />
<area shape="circle" coords="980,379,11" href="/bbs/board.php?bo_table=seoul_a83" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김부겸 4-10-7" />
<area shape="circle" coords="1000,361,11" href="/bbs/board.php?bo_table=mbe02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김종인 4-10-8" />
<area shape="circle" coords="1018,341,11" href="/bbs/board.php?bo_table=seoul_521" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김진표 4-10-9" />
<area shape="circle" coords="1035,319,11" href="/bbs/board.php?bo_table=seoul_83" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안민석 4-10-10" />
<area shape="circle" coords="1052,295,11" href="/bbs/board.php?bo_table=seoul_59" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이종걸 4-10-11" />
<area shape="circle" coords="1067,269,11" href="/bbs/board.php?bo_table=seoul_a10" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="송영길 4-10-12" />

<area shape="circle" coords="767,159,11" href="/bbs/board.php?bo_table=seoul_18" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="고용진 5-1-1" />
<area shape="circle" coords="774,136,11" href="/bbs/board.php?bo_table=seoul_22" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강병원 5-1-2" />
<area shape="circle" coords="777,112,11" href="/bbs/board.php?bo_table=seoul_11" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박홍근 5-1-3" />

<area shape="circle" coords="811,168,11" href="/bbs/board.php?bo_table=seoul_13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="기동민 5-2-1" />
<area shape="circle" coords="823,140,11" href="/bbs/board.php?bo_table=seoul_881" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이학영 5-2-2" />
<area shape="circle" coords="823,111,11" href="/bbs/board.php?bo_table=seoul_29" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="금태섭 5-2-3" />

<area shape="circle" coords="854,179,11" href="/bbs/board.php?bo_table=seoul_b44" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강창일 5-3-1" />
<area shape="circle" coords="867,157,11" href="/bbs/board.php?bo_table=seoul_15" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박용진 5-3-2" />
<area shape="circle" coords="870,133,11" href="/bbs/board.php?bo_table=seoul_24" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김영호 5-3-3" />
<area shape="circle" coords="867,108,11" href="/bbs/board.php?bo_table=seoul_36" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김병기 5-3-4" />

<area shape="circle" coords="898,189,11" href="/bbs/board.php?bo_table=seoul_64" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김상희 5-4-1" />
<area shape="circle" coords="910,163,11" href="/bbs/board.php?bo_table=seoul_49" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이찬열 5-4-2" />
<area shape="circle" coords="912,133,11" href="/bbs/board.php?bo_table=seoul_62" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김경협 5-4-3" />
<area shape="circle" coords="910,106,11" href="/bbs/board.php?bo_table=seoul_21" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박주민 5-4-4" />

<area shape="circle" coords="944,199,11" href="/bbs/board.php?bo_table=seoul_33" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이훈 5-5-1" />
<area shape="circle" coords="952,168,11" href="/bbs/board.php?bo_table=seoul_a25" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박범계 5-5-2" />
<area shape="circle" coords="957,134,11" href="/bbs/board.php?bo_table=seoul_70" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정성호 5-5-3" />
<area shape="circle" coords="956,103,11" href="/bbs/board.php?bo_table=seoul_63" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="설훈 5-5-4" />

<area shape="circle" coords="986,207,11" href="/bbs/board.php?bo_table=seoul_a40" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="오제세 5-6-1" />
<area shape="circle" coords="995,179,11" href="/bbs/board.php?bo_table=seoul_04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="홍익표 5-6-2" />
<area shape="circle" coords="1000,153,11" href="/bbs/board.php?bo_table=seoul_43" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전현희 5-6-3" />
<area shape="circle" coords="1000,126,11" href="/bbs/board.php?bo_table=seoul_06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전혜숙 5-6-4" />
<area shape="circle" coords="1000,99,11" href="/bbs/board.php?bo_table=seoul_45" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="최명길 5-6-5" />

<area shape="circle" coords="1024,215,11" href="/bbs/board.php?bo_table=seoul_a24" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="박병석 5-7-1" />
<area shape="circle" coords="1031,193,11" href="/bbs/board.php?bo_table=seoul_60" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이석현 5-7-2" />
<area shape="circle" coords="1039,170,11" href="/bbs/board.php?bo_table=seoul_25" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="노웅래 5-7-3" />
<area shape="circle" coords="1042,145,11" href="/bbs/board.php?bo_table=seoul_03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="진영 5-7-4" />
<area shape="circle" coords="1043,122,11" href="/bbs/board.php?bo_table=seoul_65" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="원혜영 5-7-5" />
<area shape="circle" coords="1042,97,11" href="/bbs/board.php?bo_table=seoul_a26" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이상민 5-7-6" />

    <area shape="rect" coords="41,672,109,714" href="http://www.justice21.org" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정의당홈피" />
    <area shape="rect" coords="855,603,1056,646" href="/bbs/board.php?bo_table=main07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="더불어민주당 홈피" />
   <area shape="rect" coords="452,603,625,647" href="/bbs/board.php?bo_table=main06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="새누리당 홈피" />
      <area shape="rect" coords="4,583,173,606" href="/bbs/board.php?bo_table=main09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="국민의당 의원" />
      <area shape="rect" coords="33,544,166,576" href="/bbs/board.php?bo_table=main08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정의당 의원" />
      <area shape="rect" coords="34,615,166,637" target="_top" alt="무소속" href="/menuhtml/kh/free.php" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" />
      <area shape="rect" coords="928,555,1073,577" href="/menuhtml/jb/kh_02.php" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="상임위원회" />
      
      <area shape="poly" coords="541,93,553,100,563,107,569,115,589,124,592,135,581,159,577,187,545,185,514,187,505,156,495,129,520,114" href="http://www.assembly.go.kr/" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="국회" />
      <area shape="rect" coords="480,1,601,80" href="/menuhtml/jb/kh_01.php" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="국회의장" />
      <area shape="poly" coords="2,74,311,105,309,125,315,146,320,157,328,168,27,244,14,202,7,175,1,126" href="/bbs/board.php?bo_table=main01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="국무위원석" />
   </map>
      </div>
   
   
   
   
  <div id="main_picture2"><img src="/menuhtml/jk/jk2.gif" width="1100" height="1767" usemap="#Map2" border="0" />
      <map name="Map2" id="Map2"><area shape="poly" coords="929,1209,936,1198,940,1192,942,1187,950,1183,960,1187,963,1190,964,1198,961,1206,956,1209,947,1215,946,1222,940,1231,929,1240,919,1245,914,1245,911,1242,907,1235,909,1218,918,1213,922,1216,924,1219,928,1217" href="/bbs/board.php?bo_table=seoul_b421" area="area" onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="양산을" /><area shape="poly" coords="344,714,353,712,355,704,361,700,361,696,359,693,363,686,368,697,375,693,380,696,379,702,371,708,372,717,358,724,356,728,358,736,354,752,336,751,325,748,325,738,331,732,341,728" href="/bbs/board.php?bo_table=seoul_a301" area="area" onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="천안병" /><area shape="poly" coords="319,696,321,704,318,710,313,713,310,715,306,714,301,713,296,715,295,722,294,729,289,729,283,718,274,717,268,707,272,694,269,679,274,679,285,690,293,691,306,696" href="/bbs/board.php?bo_table=seoul_a33" area="area" onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="아산갑" /><area shape="poly" coords="351,386,347,373,362,362,369,366,369,375,380,381,385,379,390,387,403,387,393,407,390,418,384,409,375,408,363,392" href="/bbs/board.php?bo_table=seoul_821" area="area" onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="남양주병" /><area shape="poly" coords="351,485,358,487,363,486,368,480,380,481,388,488,392,493,394,504,398,510,405,510,410,506,415,494,425,486,424,472,416,466,405,463,404,460,393,455,389,458,390,467,377,474,363,478,357,471,353,472,349,478" href="/bbs/board.php?bo_table=seoul_981" area="area" onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="광주을(경기)" /><area shape="poly" coords="348,252,352,243,342,229,347,225,358,224,362,219,357,201,360,181,371,190,386,188,395,208,428,214,442,251,451,255,460,254,476,277,466,297,458,305,453,350,463,360,466,375,478,384,475,391,464,392,460,396,454,391,452,372,439,358,419,371,414,368,414,359,402,333,452,331,452,299,390,301,390,319,396,328,384,328,360,335,343,319,344,304,352,270,347,262,336,260,336,253" href="/bbs/board.php?bo_table=seoul_99" area="area" onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="포천 가평" />
      
      <area shape="poly" coords="480,737,497,727,514,734,520,741,527,755,532,762,530,764,524,767,508,767,498,772,493,780,478,788,474,823,457,817,450,813,452,800,449,789,457,783,457,780,453,774,454,770,460,766,460,759,457,746" href="/bbs/board.php?bo_table=seoul_a39" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="상당구" /><area shape="poly" coords="446,751,454,747,455,754,455,764,449,769,448,774,453,779,451,783,446,788,448,807,444,813,426,811,426,797,418,789,417,779,414,772,421,763,432,759,442,758" href="/bbs/board.php?bo_table=seoul_a40" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="서원구" /><area shape="poly" coords="460,705,467,705,473,704,481,708,487,713,489,720,494,724,492,727,485,729,476,735,468,738,456,743,452,736,440,725,424,713,428,705,433,700,440,707,454,707" href="/bbs/board.php?bo_table=seoul_a44" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="청원구" /><area shape="poly" coords="420,714,432,722,436,727,439,731,445,734,450,741,449,745,447,746,442,749,440,753,436,755,433,755,431,756,429,756,425,757,419,759,415,762,411,767,405,761,403,757,397,750,396,742,397,734,403,727,409,721,414,718" href="/bbs/board.php?bo_table=seoul_a41" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="흥덕구" />
        
        <area shape="rect" coords="14,125,153,174" href="/bbs/board.php?bo_table=main06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="새누리당" />
        <area shape="rect" coords="13,179,154,216" href="/bbs/board.php?bo_table=main07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="새정치민주연합" />
        <area shape="rect" coords="3,231,154,260" href="/bbs/board.php?bo_table=main09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="국민의당" />
        <area shape="rect" coords="37,276,155,307" href="/bbs/board.php?bo_table=main08" area="area" onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정의당" />
        
        <area shape="poly" coords="251,396,268,402,283,394,284,383,297,376,306,376,311,371,312,365,327,363,331,372,333,377,332,385,334,393,333,407,338,413,350,412,354,416,349,427,350,438,343,445,331,448,322,452,313,448,303,448,291,453,284,451,278,439,265,432,257,417,248,414" href="/bbs/board.php?bo_table=city01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="서울" />
        <area shape="poly" coords="243,415,253,420,260,432,266,438,275,442,282,455,290,456,304,451,309,452,318,457,323,456,331,451,339,450,347,445,355,458,354,465,347,476,345,485,347,496,351,500,348,542,346,550,332,564,316,568,301,549,297,527,291,519,277,512,272,512,264,516,259,515,255,509,248,504,234,501,224,493,228,481,234,475,235,466,242,457,242,447,231,435,233,430,235,425,239,420" href="/menuhtml/jk/kk.php" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="경기중심부" />
        <area shape="poly" coords="393,303,450,301,450,330,400,330,396,325,393,318" href="/bbs/board.php?bo_table=city02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()"target="_top" alt="경기" />
        <area shape="poly" coords="181,402,196,395,203,390,211,389,219,398,224,400,229,405,240,406,240,411,235,413,228,424,226,431,225,439,234,446,234,451,226,458,221,472,213,483,203,491,197,498,185,518,180,524,173,527,159,530,129,531,117,527,107,528,97,530,86,530,78,527,70,527,67,521,63,512,54,503,53,496,58,493,67,493,72,497,77,501,79,506,88,508,92,510,102,510,111,508,127,512,134,512,145,506,163,501,171,492,170,483,154,444,150,426,136,413,131,407,130,389,117,369,110,367,102,362,75,354,74,346,93,330,101,322,121,322,128,314,139,312,149,313,156,316,159,332,158,343,163,353,164,363,161,375,167,386,173,398" href="/bbs/board.php?bo_table=city03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="인천" />
        <area shape="poly" coords="718,382,776,379,775,409,725,410,720,405,718,397" href="/bbs/board.php?bo_table=city04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강원" />
        <area shape="poly" coords="423,818,446,819,464,830,470,833,473,844,466,854,462,868,461,879,466,901,444,909,434,908,423,906,412,909,404,908,402,889,396,876,394,869,392,862,401,839,413,824" href="/bbs/board.php?bo_table=city06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="대전" />
        <area shape="poly" coords="362,727,372,724,378,731,391,731,390,754,397,761,399,768,404,770,407,776,410,779,409,792,418,798,417,816,409,821,402,829,397,834,388,859,377,860,373,826,367,817,367,812,372,805,370,787,366,766,360,756,364,746" href="/bbs/board.php?bo_table=city05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" alt="세종" />
        <area shape="poly" coords="210,862,260,861,264,842,258,833,241,836,226,834,216,833,209,836,204,846" href="/bbs/board.php?bo_table=city07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="충남" />
        <area shape="poly" coords="449,641,496,641,500,654,494,663,468,658,464,668,444,669,441,655" href="/bbs/board.php?bo_table=city08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="충북" />
        <area shape="poly" coords="225,1501,273,1502,279,1482,272,1474,244,1473,220,1477" href="/bbs/board.php?bo_table=city10" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전남" />
        <area shape="poly" coords="446,1010,470,1007,500,1008,504,1021,500,1037,477,1029,472,1036,451,1036" href="/bbs/board.php?bo_table=city11" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전북" />
        <area shape="poly" coords="231,1262,239,1263,245,1267,258,1266,272,1269,281,1275,290,1278,298,1284,305,1287,310,1307,306,1312,302,1316,296,1321,279,1322,266,1326,260,1330,249,1331,244,1327,239,1315,217,1309,212,1304,211,1293,218,1285,223,1270" href="/bbs/board.php?bo_table=city09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="광주" />
        <area shape="poly" coords="982,1097,981,1108,984,1111,990,1113,994,1110,1011,1102,1015,1103,1025,1110,1032,1109,1044,1120,1044,1136,1047,1149,1038,1165,1038,1179,1008,1221,973,1198,969,1180,940,1163,909,1147,905,1129,916,1124,923,1114,935,1111,943,1095,973,1089" href="/bbs/board.php?bo_table=city13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="울산" />
        <area shape="poly" coords="725,1117,763,1107,776,1075,793,1076,802,1083,814,1069,815,1045,824,1038,831,1018,829,993,806,984,784,995,756,1015,742,1015,737,1020,745,1045,731,1060,718,1109" href="/bbs/board.php?bo_table=city12" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="대구" />
        <area shape="poly" coords="914,1262,948,1238,958,1217,973,1207,1000,1227,985,1267,967,1277,956,1277,953,1281,957,1283,953,1294,952,1302,948,1306,946,1315,936,1320,935,1329,923,1332,916,1328,909,1341,902,1341,893,1335,892,1327,853,1356,847,1325,858,1296,869,1294,877,1275" href="/bbs/board.php?bo_table=city14" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="부산" />
        <area shape="poly" coords="941,711,965,710,995,710,998,724,995,740,967,729,966,739,947,740,941,726" href="/bbs/board.php?bo_table=city16" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="경북" />
        <area shape="poly" coords="532,1198,555,1196,567,1199,584,1196,590,1205,585,1226,538,1227,532,1212" href="/bbs/board.php?bo_table=city15" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="경남" />
        <area shape="poly" coords="169,1719,187,1715,225,1715,229,1732,215,1745,200,1734,195,1745,183,1739,169,1739" href="/bbs/board.php?bo_table=city17" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="제주" />
        
        <area shape="poly" coords="256,244,265,226,278,218,291,194,292,172,294,166,306,162,320,150,329,154,335,165,354,178,350,202,355,216,354,223,341,220,337,230,344,242,342,248,333,250,330,262,340,265,348,270,341,297,327,289,323,283,314,277,312,270,304,268,297,268,300,252,278,249,273,257,259,253" href="/bbs/board.php?bo_table=seoul_701" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="동두천 연천" />
        <area shape="poly" coords="214,264,219,261,228,265,249,249,252,249,259,257,268,260,276,257,278,252,296,254,288,276,289,288,285,297,279,300,276,306,268,315,253,317,247,325,240,329,233,328,232,316,223,302,221,284,222,276" href="/bbs/board.php?bo_table=seoul_91" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="파주을" />
        <area shape="poly" coords="208,306,219,306,226,315,231,332,238,334,247,330,254,322,267,318,273,327,269,339,260,345,236,347,219,352,214,352,213,334,216,325,207,313" href="/bbs/board.php?bo_table=seoul_90" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="파주갑" />
        <area shape="poly" coords="293,275,306,273,309,282,318,285,323,295,332,296,341,302,340,315,335,323,309,335,303,332,294,338,296,347,295,356,287,355,280,360,279,351,281,344,276,328,275,313,283,306,288,301,294,293" href="/bbs/board.php?bo_table=seoul_70" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="양주" />
        <area shape="poly" coords="404,390,421,375,439,366,450,383,451,395,464,401,470,395,481,395,483,385,489,390,503,394,516,400,524,404,535,409,544,410,546,422,540,428,540,442,534,449,536,458,529,464,526,473,523,481,523,490,519,502,520,514,522,523,520,537,511,547,504,558,488,554,477,551,463,551,465,542,470,530,471,512,466,505,465,492,452,482,433,479,429,474,427,467,420,462,416,451,421,443,417,426,401,420" href="/bbs/board.php?bo_table=seoul_a00" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="여주 양평 가평" />
        <area shape="poly" coords="205,516,237,510,248,514,258,519,270,520,280,518,288,529,291,539,296,545,297,558,303,561,305,571,301,577,298,588,281,595,267,594,261,604,252,607,236,595,232,577,235,566,225,564,216,571,209,568,211,557,208,539,201,528" href="/bbs/board.php?bo_table=seoul_84" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="화성갑" />
        <area shape="poly" coords="255,613,261,609,267,611,267,601,274,596,285,600,300,593,313,592,323,604,330,607,340,602,346,606,347,616,323,635,313,635,300,628,289,638,272,630,259,622" href="/bbs/board.php?bo_table=seoul_69" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="평택을" />
        <area shape="poly" coords="309,584,310,573,317,569,331,570,334,577,339,583,341,592,334,602,327,601,324,593" href="/bbs/board.php?bo_table=seoul_68" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="평택갑" />
        <area shape="poly" coords="343,590,369,586,391,590,401,590,410,582,428,585,431,575,439,572,448,577,450,593,441,604,429,612,421,619,413,631,401,637,384,638,378,629,352,620,350,602,343,597" href="/bbs/board.php?bo_table=seoul_96" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안성" />
        <area shape="poly" coords="343,583,354,581,373,581,384,585,393,585,403,582,410,578,417,579,421,579,425,574,425,566,422,554,416,549,408,546,404,540,399,519,391,512,389,504,384,493,378,487,372,485,367,492,363,494,358,490,352,490,351,493,356,495,361,507,361,517,355,523,353,527,355,533,355,551,341,565,338,572,339,577" href="/bbs/board.php?bo_table=seoul_93" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="용인갑" />
        <area shape="poly" coords="433,566,438,568,449,569,453,574,454,593,463,596,477,591,485,580,490,565,490,561,485,556,462,556,458,546,461,542,466,530,466,519,467,512,460,494,451,485,444,483,435,484,426,493,421,500,409,510,406,516,409,540,426,546,429,550" href="/bbs/board.php?bo_table=seoul_92" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="이천" />
        <area shape="poly" coords="386,463,385,456,395,448,396,454,403,453,411,462,415,460,412,449,415,441,415,435,408,427,394,426,382,427,384,432,382,435,362,435,357,438,357,441,363,456,359,467,365,471,376,470" href="/bbs/board.php?bo_table=seoul_98" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="광주갑(경기)" />
        <area shape="poly" coords="335,376,339,376,340,373,345,376,346,382,347,390,351,392,355,391,358,395,356,399,343,407,338,405,337,399,338,392,338,388,335,383" href="/bbs/board.php?bo_table=seoul_80" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" alt="구리" />
        <area shape="poly" coords="358,401,363,402,376,416,379,420,378,425,374,429,359,430,354,426,355,419,359,414,357,406" href="/bbs/board.php?bo_table=seoul_89" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="하남" />
        <area shape="poly" coords="377,377,372,373,374,367,385,366,388,352,379,353,380,335,386,333,395,333,403,342,407,352,411,359,412,371,408,378,402,382,394,385,389,380,389,376" href="/bbs/board.php?bo_table=seoul_81" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="남양주갑" />
        <area shape="poly" coords="337,358,349,351,353,345,365,339,378,336,376,344,377,350,372,352,383,356,381,362,368,362,364,359,358,362,350,364,348,368,345,372,336,372,335,365" href="/bbs/board.php?bo_table=seoul_82" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="남양주을" />
        <area shape="poly" coords="225,392,207,378,209,375,214,374,220,375,226,379,232,380,241,389,241,393,241,395,237,399,234,398" href="/bbs/board.php?bo_table=seoul_97" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김포갑" />
        
        <area shape="poly" coords="171,323,173,329,178,330,181,336,186,336,190,329,196,329,201,334,206,352,207,359,207,368,210,372,199,379,194,383,189,387,185,392,178,392,171,378,169,370,171,355,168,349,166,332,167,327" href="/bbs/board.php?bo_table=seoul_971" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김포을" />
        <area shape="poly" coords="302,335,309,338,316,334,321,335,323,338,324,345,324,351,319,359,310,360,306,362,303,357,299,355,298,347,296,341" href="/bbs/board.php?bo_table=seoul_57" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="의정부갑" />
        <area shape="poly" coords="328,333,336,332,340,327,345,326,349,330,354,336,353,340,349,343,347,347,344,351,337,356,332,357,327,357,325,354,327,340,325,337" href="/bbs/board.php?bo_table=seoul_58" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="의정부을" />
        <area shape="poly" coords="258,347,264,347,268,345,271,338,275,337,278,341,276,349,278,353,278,359,271,364,261,369,256,371,251,367,254,363,255,356" href="/bbs/board.php?bo_table=seoul_75" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="고양덕양갑" />
        <area shape="poly" coords="249,371,254,374,257,374,273,366,277,361,282,361,285,359,300,359,302,362,300,366,301,370,296,372,291,370,285,374,278,378,277,390,273,393,271,396,266,397,250,387,245,387,243,383,247,378" href="/bbs/board.php?bo_table=seoul_76" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="고양덕양을" />
        <area shape="poly" coords="235,350,243,351,249,349,253,351,252,361,246,371,244,377,241,381,236,379,231,377,235,372,238,367,237,356" href="/bbs/board.php?bo_table=seoul_77" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="고양일산동" />
        <area shape="poly" coords="214,355,220,356,226,353,231,353,234,357,234,368,231,372,226,374,220,372,215,371,211,367,211,358" href="/bbs/board.php?bo_table=seoul_78" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="고양일산서" />
        <area shape="poly" coords="485,228,493,233,496,242,501,245,509,250,528,251,543,258,558,256,562,247,577,248,590,243,598,243,601,254,594,265,595,276,591,284,584,298,575,303,563,303,550,306,545,315,551,324,550,339,544,347,524,349,513,357,499,361,493,356,485,347,474,350,466,346,467,332,473,326,468,314,473,306,485,299,491,275,490,265,482,262,478,257,488,248" href="/bbs/board.php?bo_table=seoul_a13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="춘천" />
        <area shape="poly" coords="545,462,566,466,574,469,577,466,579,457,583,453,590,451,591,455,585,460,584,472,585,483,578,489,575,484,561,486,551,494,546,510,554,524,566,526,570,530,570,537,566,548,555,557,549,554,540,551,530,540,532,531,535,524,529,510,529,501,534,486,536,472" href="/bbs/board.php?bo_table=seoul_a14" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="원주갑" />
        <area shape="poly" coords="571,488,576,496,586,489,589,468,591,459,598,452,626,457,632,461,631,467,619,472,617,481,613,485,617,500,627,512,646,518,651,522,650,527,639,532,638,540,628,545,623,546,614,530,609,525,605,520,596,518,579,523,569,523,561,521,556,516,550,511,554,499,564,492" href="/bbs/board.php?bo_table=seoul_a15" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="원주을" />
        
        <area shape="poly" coords="782,327,774,310,773,299,783,293,786,287,793,285,806,291,814,290,820,284,833,278,841,278,848,287,849,297,852,312,871,316,880,322,890,343,901,354,904,360,907,386,907,405,903,415,891,413,880,419,876,413,862,408,853,407,845,423,839,428,831,429,828,420,810,415,803,404,809,400,815,390,815,385,821,376,816,356,813,339,807,334" href="/bbs/board.php?bo_table=seoul_a16" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="강릉" />
        <area shape="poly" coords="895,419,907,417,914,413,915,401,912,395,914,390,927,396,929,410,938,425,940,445,946,448,956,459,959,468,967,473,968,482,973,492,984,497,991,506,999,521,996,534,1003,552,983,564,971,577,949,584,938,578,924,575,925,563,910,548,907,517,908,507,898,494,881,493,875,506,867,505,866,493,861,483,868,473,869,463,881,455,888,445,887,428,888,422" href="/bbs/board.php?bo_table=seoul_a17" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="동해 삼척" />
        <area shape="poly" coords="697,29,711,28,726,49,736,63,739,71,739,91,748,100,751,108,750,125,755,136,771,155,785,184,791,188,791,198,803,218,806,236,818,241,825,254,829,272,814,282,801,283,788,281,777,290,765,294,754,295,741,286,732,280,735,263,745,252,736,237,728,237,722,232,723,219,736,210,740,200,740,193,731,187,721,164,713,155,703,157,696,152,694,135,682,125,681,112,673,107,673,98,681,95,677,87,682,83,690,78,696,68,693,56,692,41" href="/bbs/board.php?bo_table=seoul_a18" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="속초 고성 양양" />
        <area shape="poly" coords="685,386,683,378,687,369,693,359,719,357,727,360,737,347,741,343,753,347,755,340,764,332,767,325,771,322,777,332,785,332,790,338,801,338,808,343,808,361,814,370,813,376,809,381,805,394,797,403,797,415,801,422,817,423,825,433,834,435,846,431,855,414,861,412,881,428,881,444,878,450,870,453,867,458,858,466,854,479,860,499,861,507,869,521,875,521,881,512,882,504,890,500,898,511,900,525,900,544,903,553,917,564,918,568,914,581,905,582,897,577,893,581,864,588,853,584,831,585,819,591,806,592,796,588,770,582,757,568,742,572,717,554,697,559,689,535,674,528,667,518,661,514,655,517,643,513,624,499,620,484,627,473,641,468,639,453,591,443,577,446,573,462,548,456,552,429,556,419,570,411,581,412,583,394,611,383,633,380,634,373,642,372,646,366,669,373,680,380,694,409,776,411,778,378,717,381,717,400,720,409,693,409,687,393" href="/bbs/board.php?bo_table=seoul_a20" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="태백 영월 평창 정선" />
        <area shape="poly" coords="419,125,440,131,447,135,468,132,488,132,493,123,501,120,506,127,516,129,522,131,531,125,538,125,550,130,587,131,595,128,617,129,628,132,639,121,653,111,665,111,671,115,674,124,681,131,683,146,691,158,693,169,700,170,708,166,713,167,721,181,721,190,728,196,727,205,719,213,717,234,730,246,731,254,722,278,748,299,763,299,770,316,752,334,752,341,735,339,729,345,725,355,692,353,682,359,681,371,676,373,672,368,646,359,639,366,630,367,625,374,602,376,592,385,577,389,573,407,561,408,557,401,541,401,525,391,506,383,490,376,481,375,476,368,479,355,495,369,516,367,525,354,547,353,558,336,557,326,551,318,553,309,577,308,594,298,603,273,599,266,612,250,603,232,584,241,573,243,568,237,560,240,551,250,504,240,487,219,479,222,483,242,475,248,457,242,444,215,444,203,435,203,430,198,409,200,401,194,395,180,373,179,339,148,341,139,359,133,373,128" href="/bbs/board.php?bo_table=seoul_a21" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="철원 화천 양구 인제" />
        
        <area shape="poly" coords="382,704,382,693,376,690,369,695,367,687,366,683,373,681,385,682,397,678,421,692,421,696,414,707,408,712,402,717,387,727,380,727,374,719,375,709" href="/bbs/board.php?bo_table=seoul_a29" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="천안갑" />
        <area shape="poly" coords="353,691,346,673,346,654,345,640,355,632,366,635,371,638,378,647,394,649,400,653,397,675,387,680,373,679,364,681,355,692" href="/bbs/board.php?bo_table=seoul_a30" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="천안을" />
        <area shape="poly" coords="353,756,361,767,366,803,360,810,360,817,368,828,370,840,370,862,362,868,355,866,351,860,345,860,337,866,333,876,315,900,304,910,302,923,292,925,285,931,273,936,267,952,258,954,260,935,258,922,247,916,236,905,236,889,227,879,229,871,233,863,261,863,266,842,258,831,238,834,233,831,225,827,222,822,225,816,237,815,247,797,274,785,289,787,298,764,298,752,307,746,316,755" href="/bbs/board.php?bo_table=seoul_a31" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="공주 부여 청양" />
        <area shape="poly" coords="167,818,190,814,202,816,210,820,223,832,214,832,206,835,202,846,208,863,226,863,221,873,220,887,228,893,232,900,230,912,248,929,253,937,252,953,249,961,241,968,225,974,217,971,211,958,202,947,194,932,176,915,174,904,180,884,176,865,178,859,180,851,172,844,161,839,159,833" href="/bbs/board.php?bo_table=seoul_a32" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" alt="보령 서천" />
        <area shape="poly" coords="304,646,330,644,335,648,344,698,342,705,332,726,320,730,313,738,302,735,299,729,300,718,309,722,317,720,321,717,326,708,327,699,325,694,319,692,309,691,301,689,296,685,290,686,284,681,279,678,274,673,273,666,278,657,287,655,295,654" href="/bbs/board.php?bo_table=seoul_a331" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="아산을" />
        <area shape="poly" coords="132,610,140,615,146,615,154,626,159,642,155,663,163,671,168,689,183,692,188,689,194,691,202,701,202,712,196,718,197,728,192,747,182,749,176,755,163,757,157,754,157,746,140,748,123,743,118,750,128,758,129,771,135,786,138,801,141,816,135,823,125,823,122,808,111,789,110,767,99,753,101,733,97,729,76,733,69,729,61,720,54,709,60,694,63,683,76,673,77,651,94,640,99,629,109,626,119,632,123,627,124,613" href="/bbs/board.php?bo_table=seoul_a34" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="서산 태안" />
        <area shape="poly" coords="312,910,325,904,332,889,338,885,342,873,350,871,355,876,364,875,370,867,378,866,385,869,387,878,393,886,395,905,402,915,410,918,421,914,440,917,463,909,472,909,475,913,476,921,483,927,481,938,493,962,493,969,486,977,477,976,471,978,460,986,445,984,441,977,431,977,428,965,429,954,421,938,404,935,397,939,374,945,358,948,345,947,333,938,325,926,312,923" href="/bbs/board.php?bo_table=seoul_a35" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="논산 계룡 금산" />
        <area shape="poly" coords="160,765,169,764,182,758,194,754,203,734,202,721,210,714,211,705,220,704,224,699,239,702,243,707,255,710,259,715,262,727,278,726,286,734,296,737,296,744,290,763,283,779,272,778,265,784,245,792,234,806,223,812,213,812,198,809,189,810,170,808,163,803,155,788,156,779" href="/bbs/board.php?bo_table=seoul_a37" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="홍성 예산" />
        <area shape="poly" coords="175,594,194,606,201,615,220,615,228,619,237,619,250,634,254,643,257,660,262,666,263,676,262,682,265,688,263,696,256,702,246,703,232,691,222,696,208,696,200,683,192,682,177,685,166,666,160,659,160,654,166,647,160,627,162,619,153,614,154,607,165,597" href="/bbs/board.php?bo_table=seoul_a38" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="당진" />
        <area shape="poly" coords="530,552,543,564,555,566,569,561,577,561,594,571,603,587,615,602,620,629,614,634,624,655,626,666,619,670,613,677,599,683,590,681,588,672,580,668,574,660,562,655,554,640,536,635,526,623,517,617,521,595,525,582,524,574,518,570,518,556,524,549" href="/bbs/board.php?bo_table=seoul_a42" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="충주" />
        <area shape="poly" coords="597,529,609,535,614,547,632,554,636,550,646,548,649,541,658,533,663,532,679,541,682,547,688,561,703,571,715,567,728,573,733,580,750,581,758,588,765,591,768,595,759,607,751,613,748,625,743,631,730,642,728,664,722,675,696,678,683,674,661,683,644,683,627,685,622,682,624,676,635,664,633,653,623,641,621,632,625,605,621,596,606,582,602,569,579,554,579,545,582,535" href="/bbs/board.php?bo_table=seoul_a43" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="제천 단양" />
        <area shape="poly" coords="584,726,584,743,579,750,557,749,543,758,543,763,549,777,556,786,563,796,569,802,571,812,568,827,568,851,558,859,557,867,563,879,570,881,580,890,597,895,616,897,613,909,600,914,595,926,586,940,584,948,582,957,572,966,568,976,552,972,503,958,494,946,490,936,493,925,486,918,481,904,473,900,471,883,470,866,473,858,482,848,480,838,479,822,481,812,482,794,487,789,495,784,501,774,510,769,524,771,534,765,535,759,532,754,522,740,519,727,505,724,507,709,501,705,497,685,493,682,494,671,498,668,507,669,511,663,528,660,534,655,535,641,544,640,551,646,557,658,567,662,571,670,580,675,588,688,610,686,613,690,613,702,617,711,613,715,605,711,596,712,590,715" href="/bbs/board.php?bo_table=seoul_a45" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="보은 옥천 영동 괴산" />
        <area shape="poly" coords="444,704,462,702,474,700,490,708,493,719,502,724,502,710,498,708,493,687,490,683,490,668,494,665,503,663,510,658,524,656,529,656,531,653,531,646,530,639,524,627,516,624,512,615,517,591,520,583,519,578,508,571,501,572,498,588,482,601,474,603,466,607,459,606,454,612,439,621,434,632,424,638,414,652,411,661,414,670,427,680,436,696,442,703,442,670,441,662,440,655,448,639,497,639,502,655,494,664,469,660,465,670,445,671" href="/bbs/board.php?bo_table=seoul_a46" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="증평 진천 음성" />
        
        <area shape="poly" coords="95,1431,108,1430,114,1429,118,1426,119,1419,125,1415,133,1413,140,1415,147,1421,149,1427,150,1434,147,1440,141,1444,133,1446,129,1447,124,1454,118,1459,112,1462,106,1461,97,1458,89,1457,81,1455,76,1452,76,1446,79,1440" href="/bbs/board.php?bo_table=seoul_a55" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="목포" />
      <area shape="poly" coords="501,1447,522,1419,535,1408,539,1411,544,1441,544,1454,541,1459,542,1463,543,1467,545,1471,545,1477,547,1481,547,1486,541,1494,541,1501,545,1509,546,1514,543,1519,544,1530,540,1536,541,1543,538,1549,534,1547,531,1540,526,1536,524,1532,524,1527,522,1525,517,1522,514,1523,507,1524,504,1519,500,1513,500,1508,503,1505,513,1501,517,1495,517,1484,519,1478,530,1468,530,1462,527,1459,520,1458" href="/bbs/board.php?bo_table=seoul_a56" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="여수갑" />
      <area shape="poly" coords="494,1399,504,1399,513,1396,518,1390,519,1384,522,1383,531,1385,535,1385,540,1383,543,1385,543,1390,540,1393,540,1397,538,1402,528,1410,510,1428,498,1449,493,1453,491,1458,495,1466,494,1473,497,1479,497,1483,494,1489,490,1489,487,1486,477,1487,473,1483,473,1477,477,1468,477,1464,474,1460,480,1444,480,1440,477,1438,476,1433,472,1430,466,1428,464,1423,465,1417,467,1411,467,1407,476,1403,481,1398,481,1390,484,1387,487,1390,489,1395" href="/bbs/board.php?bo_table=seoul_a57" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="여수을" />
      <area shape="poly" coords="454,1316,454,1321,458,1326,460,1332,463,1336,464,1346,471,1356,475,1364,476,1370,481,1379,478,1390,477,1396,473,1400,465,1402,459,1402,453,1400,447,1405,441,1410,432,1411,426,1410,421,1410,418,1404,409,1404,403,1401,395,1401,391,1398,386,1399,379,1387,379,1374,377,1370,370,1366,367,1357,368,1350,367,1343,371,1332,371,1316,383,1320,392,1331,406,1333,429,1309,432,1295,438,1295,449,1304" href="/bbs/board.php?bo_table=seoul_a58" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="곡성순천" />
      <area shape="poly" coords="189,1321,196,1322,202,1322,202,1318,206,1315,211,1316,216,1317,221,1319,230,1319,234,1323,236,1331,246,1339,252,1341,258,1340,265,1339,271,1334,287,1329,296,1329,302,1329,307,1321,314,1318,315,1311,320,1310,329,1311,335,1311,337,1305,337,1294,338,1289,337,1285,350,1281,358,1277,360,1278,364,1281,363,1290,365,1294,369,1302,371,1310,368,1319,368,1326,366,1333,364,1341,364,1354,365,1360,358,1364,353,1364,345,1369,344,1369,341,1373,337,1376,335,1387,331,1397,326,1404,324,1409,313,1413,309,1408,305,1408,299,1412,294,1413,293,1411,288,1409,283,1400,279,1397,274,1396,271,1392,257,1392,241,1391,235,1388,232,1383,217,1374,211,1372,208,1369,204,1369,203,1374,197,1378,197,1384,193,1385,189,1385,185,1379,181,1377,180,1371,178,1367,180,1363,185,1360,186,1351,187,1341" href="/bbs/board.php?bo_table=seoul_a59" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="나주 화순" />
      <area shape="poly" coords="440,1228,444,1227,451,1228,459,1226,467,1231,473,1233,477,1237,478,1244,479,1250,483,1256,484,1261,485,1268,489,1274,490,1282,493,1288,502,1294,505,1298,506,1306,509,1311,519,1316,525,1324,533,1334,535,1344,535,1353,533,1361,532,1367,534,1373,534,1379,531,1382,524,1382,519,1381,516,1385,511,1390,503,1395,498,1394,491,1391,454,1302,436,1283,424,1292,422,1308,401,1330,373,1311,375,1297,366,1289,366,1276,358,1270,347,1267,345,1250,366,1239,399,1244,413,1240,424,1241,435,1231" href="/bbs/board.php?bo_table=seoul_a60" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="구례광양" />
      <area shape="poly" coords="201,1475,207,1458,204,1448,212,1443,219,1448,230,1446,241,1425,242,1420,254,1412,255,1399,270,1398,286,1416,321,1416,341,1391,341,1376,355,1369,362,1367,363,1369,369,1369,373,1375,375,1383,375,1393,383,1402,388,1403,391,1404,403,1404,409,1408,415,1410,416,1417,425,1427,426,1432,424,1436,426,1440,424,1447,423,1453,430,1457,434,1466,437,1470,452,1477,459,1484,463,1490,461,1499,461,1506,457,1518,461,1529,461,1538,471,1550,473,1557,472,1567,466,1571,461,1572,457,1569,445,1568,437,1566,432,1561,432,1549,431,1544,426,1541,420,1553,416,1556,412,1559,410,1565,406,1568,401,1568,391,1561,389,1555,382,1550,378,1545,378,1536,371,1539,373,1544,372,1557,371,1564,368,1569,358,1573,348,1577,343,1578,339,1572,335,1565,328,1560,328,1550,326,1543,326,1537,338,1524,337,1525,337,1517,342,1511,352,1506,358,1496,358,1490,369,1485,374,1479,379,1475,380,1467,383,1464,393,1467,396,1474,403,1472,404,1468,406,1463,401,1452,396,1450,391,1452,384,1456,373,1456,368,1457,365,1463,359,1466,350,1470,338,1475,309,1493,294,1549,284,1557,235,1552,239,1515,228,1544,201,1543,203,1503,274,1503,281,1481,272,1472,242,1472,218,1475,223,1500,203,1500" href="/bbs/board.php?bo_table=seoul_a61" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="고흥보성장흥강진" />
      <area shape="poly" coords="-1,1599,-1,1594,4,1587,10,1583,19,1580,28,1574,30,1567,35,1559,40,1543,47,1536,58,1531,71,1526,75,1519,75,1513,69,1501,72,1497,80,1494,85,1486,85,1478,81,1472,83,1465,83,1460,91,1461,106,1468,109,1473,115,1480,121,1482,134,1481,145,1483,158,1487,168,1487,176,1483,183,1477,189,1474,194,1476,197,1481,198,1489,198,1496,199,1501,199,1512,198,1521,198,1532,197,1542,202,1547,217,1550,220,1554,221,1560,225,1564,229,1567,237,1568,246,1562,252,1560,265,1560,277,1561,291,1561,307,1558,316,1556,322,1556,327,1561,327,1566,321,1572,314,1573,311,1577,314,1583,326,1586,337,1595,340,1598,340,1603,335,1607,326,1608,313,1606,306,1610,299,1611,292,1607,276,1613,261,1615,252,1612,246,1606,232,1606,227,1610,227,1616,220,1619,204,1606,203,1601,194,1592,191,1594,190,1602,184,1607,165,1606,162,1599,157,1595,156,1590,160,1575,157,1569,146,1561,138,1544,137,1527,131,1523,119,1528,118,1533,120,1539,120,1544,116,1550,116,1555,116,1564,115,1570,109,1572,98,1573,89,1571,85,1574,82,1580,73,1584,68,1591,53,1599,43,1605,33,1609,21,1617,12,1618" href="/bbs/board.php?bo_table=seoul_a63" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="해남진도완도" />
      <area shape="poly" coords="112,1288,114,1297,143,1330,150,1349,167,1361,178,1380,189,1390,206,1386,206,1379,214,1378,228,1384,237,1397,250,1400,250,1408,239,1417,238,1426,225,1441,215,1437,207,1438,200,1449,201,1461,198,1470,176,1473,167,1484,159,1482,123,1474,121,1465,133,1454,153,1446,158,1427,150,1412,144,1407,129,1407,119,1410,111,1419,104,1423,92,1424,80,1426,69,1437,65,1447,67,1458,67,1467,65,1473,65,1477,67,1482,65,1492,59,1494,52,1500,46,1505,45,1512,39,1518,35,1526,34,1533,30,1538,18,1547,14,1548,10,1541,9,1527,5,1514,5,1503,6,1498,3,1493,9,1485,19,1477,19,1468,22,1461,21,1448,17,1439,24,1430,22,1422,14,1417,7,1399,4,1394,9,1390,15,1389,32,1384,39,1377,39,1370,34,1363,35,1355,34,1350,35,1344,29,1340,25,1336,15,1335,20,1310,70,1300,79,1292" href="/bbs/board.php?bo_table=seoul_a64" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="영암무안신안" />
      <area shape="poly" coords="98,1258,103,1253,107,1247,118,1242,123,1232,123,1221,128,1210,128,1202,131,1200,133,1192,137,1192,143,1198,146,1210,147,1216,153,1223,162,1231,168,1236,181,1240,197,1232,208,1232,213,1229,223,1230,226,1227,228,1218,230,1212,234,1207,234,1197,239,1190,241,1185,248,1180,257,1180,272,1187,276,1189,281,1194,286,1199,289,1204,294,1205,303,1203,306,1197,315,1192,319,1195,322,1204,321,1210,320,1217,326,1226,327,1236,341,1251,341,1260,343,1268,349,1273,348,1276,334,1281,331,1284,331,1294,333,1301,333,1305,323,1305,319,1301,314,1291,313,1284,305,1281,296,1276,287,1271,277,1262,268,1262,265,1259,249,1261,244,1256,233,1254,224,1258,218,1264,213,1279,208,1286,203,1292,205,1307,198,1319,188,1318,185,1323,184,1332,180,1344,180,1361,173,1362,163,1354,157,1344,154,1340,147,1331,148,1324,137,1318,131,1313,129,1306,125,1301,119,1291,119,1282,114,1276,107,1276,101,1269" href="/bbs/board.php?bo_table=seoul_a65" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="함평영광장성담양" />
        
        <area shape="poly" coords="361,1032,375,1033,383,1043,387,1051,387,1056,383,1060,374,1061,367,1065,363,1065,356,1058,353,1052,354,1047,351,1045,351,1041" href="/bbs/board.php?bo_table=seoul_a66" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전주 완산갑" />
        <area shape="poly" coords="332,1046,347,1046,350,1049,352,1057,359,1064,358,1070,355,1073,350,1074,346,1075,338,1075,328,1074,324,1070,323,1065,327,1061,330,1060,328,1056,328,1049" href="/bbs/board.php?bo_table=seoul_a67" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전주 완산을" />
        <area shape="poly" coords="328,1016,345,1017,350,1024,357,1028,356,1033,350,1037,347,1043,329,1044,326,1041,324,1033,323,1024" href="/bbs/board.php?bo_table=seoul_a68" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="전주 덕진" />
        <area shape="poly" coords="194,991,206,987,215,987,220,983,242,981,250,971,258,967,263,967,267,973,271,974,276,980,276,986,280,989,285,1000,284,1005,268,1012,261,1010,238,1021,226,1021,215,1020,208,1023,200,1020,197,1016,198,1007,193,1003,189,997" href="/bbs/board.php?bo_table=seoul_a69" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="군산" />
        <area shape="poly" coords="270,961,279,952,280,946,284,942,291,940,294,935,303,932,308,937,313,946,314,955,309,977,313,987,314,1002,315,1016,310,1017,303,1017,300,1014,293,1012,292,1004,289,1001,288,992,278,981,277,974,271,969" href="/bbs/board.php?bo_table=seoul_a70" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="익산갑" />
        <area shape="poly" coords="314,935,318,934,324,943,329,951,345,967,347,972,341,1006,334,1015,323,1015,320,1011,322,995,317,981,316,973,319,954" href="/bbs/board.php?bo_table=seoul_a71" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="익산을" />
        <area shape="poly" coords="252,1108,258,1095,278,1081,297,1095,308,1108,315,1110,322,1116,328,1118,329,1119,333,1125,331,1137,332,1150,336,1160,333,1171,319,1160,313,1159,304,1153,291,1159,289,1171,281,1180,269,1180,252,1171,237,1169,229,1185,224,1190,224,1205,217,1219,202,1219,181,1228,162,1219,155,1201,153,1190,142,1183,145,1169,169,1154,191,1151,195,1147,227,1140,229,1125,240,1111" href="/bbs/board.php?bo_table=seoul_a72" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="정읍 고창" />
      <area shape="poly" coords="344,1170,342,1158,336,1151,337,1139,337,1126,348,1122,354,1108,361,1096,368,1094,381,1108,400,1105,420,1115,422,1123,416,1129,422,1144,433,1151,445,1153,454,1165,465,1171,471,1168,480,1163,493,1167,494,1180,500,1186,499,1193,493,1199,493,1209,485,1222,478,1228,459,1217,449,1222,437,1219,426,1232,392,1235,374,1228,361,1229,355,1237,349,1240,334,1234,329,1212,329,1199,327,1188,319,1184,301,1184,296,1191,292,1193,285,1185,297,1162,306,1159,336,1177" href="/bbs/board.php?bo_table=seoul_a73" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="남원임실순창" />
      <area shape="poly" coords="246,1067,236,1048,226,1047,222,1033,251,1028,261,1021,267,1022,281,1017,292,1016,302,1023,317,1024,322,1037,326,1059,321,1064,321,1070,324,1075,332,1077,329,1086,330,1100,327,1105,318,1105,308,1099,301,1089,286,1077,279,1075,256,1088,241,1103,231,1104,226,1120,215,1128,191,1127,165,1125,159,1114,161,1107,179,1098,196,1076,196,1059,233,1057,243,1074" href="/bbs/board.php?bo_table=seoul_a74" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김제부안" />
      <area shape="poly" coords="367,1087,360,1086,354,1100,343,1117,334,1118,330,1109,333,1102,332,1088,337,1078,347,1078,358,1074,360,1071,382,1062,389,1058,391,1051,377,1031,357,1026,355,1022,349,1020,349,1016,343,1014,339,1011,347,1003,352,988,351,982,356,973,350,959,374,958,405,945,417,953,420,984,459,997,459,1006,444,1008,451,1038,473,1038,478,1031,501,1039,506,1022,501,1006,461,1005,461,996,477,985,489,987,509,967,564,985,561,1003,565,1012,564,1021,504,1049,505,1056,494,1074,497,1092,490,1105,491,1131,481,1140,484,1152,469,1167,457,1163,448,1149,430,1145,425,1137,425,1131,429,1119,429,1113,397,1099,387,1102,379,1100,376,1094" href="/bbs/board.php?bo_table=seoul_a75" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="완주진안무주장수" />
      
     
        <area shape="poly" coords="930,903,937,896,942,900,949,900,954,898,963,898,969,895,973,886,973,878,973,872,977,867,983,867,1001,882,1008,889,1010,900,1017,910,1018,923,1029,939,1033,946,1030,953,1030,958,1022,960,1020,964,1018,966,1016,974,1008,970,1006,965,993,964,986,959,959,963,947,952,940,943,933,941,923,924,917,919,916,913" href="/bbs/board.php?bo_table=seoul_b13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="포항북" />
        <area shape="poly" coords="1003,968,1005,972,1009,973,1012,977,1017,977,1019,973,1019,967,1022,967,1025,970,1027,975,1032,976,1047,965,1050,954,1055,948,1059,947,1059,938,1047,929,1043,913,1051,899,1066,903,1074,897,1082,897,1086,906,1094,956,1092,964,1098,984,1074,986,1087,910,1083,925,1079,930,1072,937,1063,941,1061,948,1066,949,1069,954,1070,961,1070,976,1066,981,1063,983,1062,989,1058,996,1057,1001,1054,1009,1053,1022,1049,1032,1045,1032,1039,1023,1030,1022,1022,1025,1018,1025,1011,1019,1007,1008,1004,1003,1003,991,1001,986,997,978,997,971" href="/bbs/board.php?bo_table=seoul_b14" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="포항남 울릉" />
        <area shape="poly" coords="953,968,970,966,977,964,983,963,989,970,994,974,994,981,999,993,1000,1004,1004,1015,1006,1021,1012,1027,1022,1030,1028,1033,1028,1030,1029,1027,1032,1025,1038,1028,1044,1036,1050,1039,1053,1043,1054,1054,1050,1063,1043,1073,1042,1088,1039,1096,1033,1100,1025,1101,1019,1097,1008,1095,999,1102,993,1104,988,1100,990,1094,979,1080,971,1080,963,1082,953,1083,942,1084,937,1086,934,1092,930,1095,930,1101,925,1107,920,1097,914,1093,905,1080,905,1073,914,1064,917,1058,915,1054,913,1049,920,1045,927,1043,938,1045,940,1039,942,1031,932,1022,927,1014,927,1008,931,1006,934,1006,939,1011,947,1007,947,1000,946,993,945,988,948,986,953,986,954,981,952,974" href="/bbs/board.php?bo_table=seoul_b15" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="경주" />
        <area shape="poly" coords="579,972,591,962,594,950,595,947,607,922,609,917,613,915,616,915,621,911,622,902,625,900,630,901,638,903,644,903,649,905,655,905,660,909,674,912,680,912,685,918,689,931,689,940,688,948,691,964,688,971,683,973,671,976,663,982,660,989,655,995,653,999,641,1003,632,1003,629,1006,630,1014,631,1028,632,1040,626,1044,620,1044,615,1041,605,1040,601,1037,600,1033,596,1030,594,1024,589,1023,584,1020,578,1018,575,1007,573,1002,574,996,576,991,574,987" href="/bbs/board.php?bo_table=seoul_b16" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김천" />
        <area shape="poly" coords="744,795,754,787,755,778,760,773,763,763,767,758,777,754,788,740,786,732,788,726,792,727,798,731,813,731,824,725,829,719,833,709,832,698,830,693,835,690,844,689,852,694,861,702,875,706,884,711,889,713,897,720,900,729,899,744,898,753,893,764,895,772,889,782,891,788,894,800,896,808,894,825,891,835,893,848,893,858,889,865,887,871,881,876,873,876,867,873,866,858,864,844,851,831,842,819,822,815,810,824,803,830,782,828,778,825,770,814,766,809,762,805,755,802,744,801" href="/bbs/board.php?bo_table=seoul_b17" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안동" />
        <area shape="poly" coords="694,926,705,922,711,928,720,928,724,929,732,943,734,954,727,962,720,964,716,960,712,957,709,952,705,952,699,956,692,950,692,943,697,937" href="/bbs/board.php?bo_table=seoul_b18" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="구미갑" />
        <area shape="poly" coords="662,878,672,876,684,868,691,864,697,869,704,869,710,873,717,878,721,884,723,891,731,895,734,899,737,905,741,905,746,902,750,901,756,907,764,910,767,913,769,926,771,936,774,940,773,945,768,948,757,948,751,950,748,956,746,957,737,957,737,948,735,943,729,933,726,928,723,925,713,925,709,921,703,920,697,921,693,921,690,910,683,906,678,904,669,905,663,902,655,900,650,894,651,888,658,884" href="/bbs/board.php?bo_table=seoul_b19" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="구미을" />
        <area shape="poly" coords="637,1044,638,1040,639,1030,639,1023,636,1015,636,1009,641,1008,650,1007,661,1001,666,996,667,992,668,990,668,987,680,980,687,979,696,974,696,966,698,965,702,960,708,959,718,966,725,967,734,963,746,960,750,958,752,953,768,952,778,958,782,959,787,962,791,969,794,973,792,979,787,984,768,993,761,1004,754,1005,738,1007,727,1020,728,1027,733,1035,733,1045,723,1053,719,1061,720,1072,718,1080,713,1088,711,1094,707,1105,697,1109,681,1108,673,1107,671,1104,673,1100,677,1096,678,1091,672,1080,670,1075,670,1065,652,1051,641,1051,637,1049" href="/bbs/board.php?bo_table=seoul_b25" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="고령 성주 칠곡" />
        <area shape="poly" coords="905,722,937,723,947,742,968,741,968,731,996,742,1000,724,995,708,940,710,938,721,905,720,901,712,894,708,886,704,877,704,873,700,866,697,856,689,847,685,838,684,832,680,829,670,823,664,810,661,805,656,802,647,811,641,813,632,816,624,816,613,820,603,834,600,843,595,866,600,884,601,895,593,901,592,913,595,924,589,931,589,945,596,957,597,975,591,987,584,992,577,1007,569,1012,572,1024,585,1023,595,1025,602,1023,609,1022,619,1019,628,1023,638,1025,651,1021,658,1025,666,1029,674,1036,678,1043,688,1041,695,1039,703,1041,718,1040,731,1035,740,1031,747,1031,760,1025,770,1026,778,1034,794,1037,801,1036,808,1031,815,1032,832,1030,840,1024,851,1018,865,1007,875,997,874,989,866,976,859,971,853,963,847,962,838,957,833,957,827,958,813,950,803,949,792,937,780,921,777,908,769,902,759,905,746,906,738" href="/bbs/board.php?bo_table=seoul_b27" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="영양 영덕 봉화 울진" />
        
        <area shape="poly" coords="605,792,595,792,591,789,590,777,589,771,589,766,591,761,594,755,595,745,595,739,594,731,593,727,598,722,604,723,614,727,622,725,626,720,626,714,628,710,627,705,623,700,631,694,641,692,648,692,655,694,671,692,683,685,717,688,728,683,739,672,741,651,744,642,759,629,763,616,775,610,778,597,790,598,808,604,812,610,801,641,797,650,800,666,820,671,826,682,826,700,817,722,808,726,798,725,786,719,780,728,782,742,764,753,757,761,742,792,706,803,698,816,691,815,682,794,663,778,649,763,635,762,629,767,624,782,622,787,620,790,614,793" href="/bbs/board.php?bo_table=seoul_b23" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="영주 문경 예천" />

<area shape="poly" coords="854,989,843,981,830,984,822,975,829,955,840,955,849,954,856,953,860,951,864,947,867,941,869,937,874,931,875,928,878,922,887,922,897,921,910,922,915,926,924,937,929,943,936,948,943,954,947,963,947,974,951,979,948,981,943,982,940,986,941,993,943,998,942,1005,939,1003,935,999,929,998,922,1004,920,1010,923,1018,935,1033,930,1038,916,1039,909,1049,912,1060,899,1074,905,1093,919,1104,918,1109,909,1120,895,1123,888,1119,878,1118,872,1123,852,1132,828,1135,791,1131,780,1123,775,1104,779,1091,785,1086,804,1091,822,1076,827,1077,829,1083,830,1094,838,1093,843,1085,845,1075,853,1073,868,1078,875,1071,888,1067,896,1055,899,1047,882,1045,875,1039,871,1019,864,1003" href="/bbs/board.php?bo_table=seoul_b21" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" alt="영천 청도" />

<area shape="poly" coords="895,1051,882,1066,870,1066,867,1072,846,1065,840,1071,837,1087,833,1086,831,1075,823,1071,823,1052,839,1030,841,1015,839,1000,834,988,844,987,850,992,856,1000,865,1015,867,1029,869,1038,877,1047" href="/bbs/board.php?bo_table=seoul_b24" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="경산" />

<area shape="poly" coords="657,781,668,794,681,807,688,826,698,826,712,810,725,805,739,806,750,807,760,815,763,818,768,821,771,828,780,832,789,836,799,838,809,835,815,828,821,824,832,825,836,831,845,833,850,839,853,845,857,853,858,864,859,869,859,877,864,881,877,883,886,885,896,878,902,861,902,846,903,833,904,817,904,806,901,789,897,779,903,776,917,782,924,782,931,785,937,791,941,800,943,807,950,818,950,832,956,840,956,848,960,856,971,859,972,864,968,869,969,878,968,886,963,890,953,895,945,895,934,890,929,892,926,897,920,903,915,904,914,907,911,911,906,917,886,915,878,914,873,916,873,922,868,926,862,932,859,944,849,949,834,949,822,952,822,959,818,968,810,975,803,974,794,961,791,956,785,953,778,942,773,925,772,911,768,905,760,904,755,898,751,898,742,901,735,892,727,890,725,885,725,878,715,869,707,866,699,864,692,857,671,873,662,873,644,886,641,898,631,896,622,888,605,887,587,883,576,875,566,870,567,864,574,862,577,860,580,855,580,847,578,839,583,802,555,771,555,765,568,762,574,759,582,766,586,794,599,800,620,797,629,792,633,777,641,771,649,774" href="/bbs/board.php?bo_table=seoul_b26" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="상주 군위 의성 청송" />
        
        <area shape="poly" coords="791,1207,798,1212,804,1213,815,1213,829,1220,829,1229,825,1233,821,1236,817,1241,814,1249,811,1250,800,1251,795,1247,791,1242,790,1233,787,1218,787,1212" href="/bbs/board.php?bo_table=seoul_b28" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="창원 의창" />
        <area shape="poly" coords="789,1254,805,1254,814,1255,820,1257,820,1261,824,1263,825,1267,826,1271,827,1282,823,1284,800,1284,795,1281,791,1283,788,1280,789,1267,790,1264,786,1260" href="/bbs/board.php?bo_table=seoul_b29" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="창원 성산" />
        <area shape="poly" coords="800,1287,818,1287,822,1289,827,1298,830,1300,837,1300,841,1302,845,1306,845,1311,840,1316,832,1319,827,1319,819,1315,814,1314,810,1316,802,1315,798,1312,796,1305,788,1295,787,1290,792,1286" href="/bbs/board.php?bo_table=seoul_b30" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="창원 진해" />
        <area shape="poly" coords="722,1272,729,1272,733,1274,735,1279,738,1281,743,1281,749,1277,760,1272,767,1271,771,1267,769,1263,769,1258,773,1257,778,1257,781,1261,784,1266,783,1275,781,1283,781,1288,787,1304,786,1309,785,1315,787,1319,792,1323,792,1328,789,1332,783,1332,775,1329,772,1320,769,1314,764,1313,760,1309,757,1311,747,1311,747,1314,749,1321,746,1325,741,1323,736,1317,729,1311,721,1310,717,1307,717,1303,722,1298,724,1293,720,1287,720,1277" href="/bbs/board.php?bo_table=seoul_b31" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="창원 마산합포" />
        <area shape="poly" coords="749,1236,751,1233,754,1230,758,1229,775,1228,782,1228,786,1232,786,1239,791,1246,791,1250,785,1253,772,1253,766,1254,766,1257,767,1263,765,1266,756,1267,753,1264,750,1257,748,1254,743,1251,741,1241" href="/bbs/board.php?bo_table=seoul_b32" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="창원 마산회원" />
        <area shape="poly" coords="585,1264,596,1264,598,1262,602,1254,610,1249,612,1245,616,1245,617,1249,624,1256,626,1260,626,1263,623,1269,622,1274,631,1282,636,1284,644,1283,650,1278,656,1278,661,1282,670,1289,673,1294,677,1300,677,1305,673,1309,667,1312,663,1317,663,1324,664,1330,663,1335,658,1334,655,1330,653,1318,647,1313,633,1313,626,1309,620,1304,606,1303,602,1299,599,1294,593,1293,587,1288,581,1281,580,1271" href="/bbs/board.php?bo_table=seoul_b33" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="진주갑" />
        <area shape="poly" coords="621,1237,631,1237,639,1234,646,1231,653,1229,659,1234,659,1239,664,1250,668,1254,688,1257,693,1254,696,1253,706,1274,713,1273,716,1278,717,1285,719,1291,719,1296,715,1298,710,1301,705,1301,701,1298,694,1299,686,1299,681,1296,675,1286,664,1276,659,1273,651,1273,642,1278,634,1278,628,1274,628,1269,631,1264,631,1258,620,1245" href="/bbs/board.php?bo_table=seoul_b34" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="진주을" />
        <area shape="poly" coords="652,1377,654,1370,657,1364,663,1356,670,1350,672,1346,668,1344,669,1330,667,1325,665,1321,670,1316,679,1313,682,1310,695,1305,701,1304,703,1307,708,1307,715,1312,720,1313,724,1316,731,1318,736,1325,736,1330,732,1334,724,1337,724,1340,732,1341,735,1337,744,1334,749,1334,753,1342,755,1350,751,1355,746,1357,742,1361,738,1362,738,1367,737,1372,736,1376,734,1379,734,1383,733,1386,733,1392,733,1396,735,1400,740,1399,741,1395,743,1392,747,1392,748,1396,747,1400,741,1417,740,1425,735,1436,731,1438,726,1436,724,1434,717,1433,715,1429,718,1424,716,1419,713,1420,709,1422,705,1423,701,1416,700,1411,704,1409,712,1408,717,1406,717,1403,705,1402,699,1393,700,1391,705,1387,704,1384,697,1385,692,1388,688,1387,687,1384,688,1379,673,1377,670,1383,669,1389,662,1394,645,1393,643,1388,646,1384,650,1382" href="/bbs/board.php?bo_table=seoul_b35" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="통영 고성" />
        <area shape="poly" coords="496,1231,500,1236,509,1237,517,1245,521,1248,527,1258,534,1261,541,1268,556,1270,564,1269,567,1266,576,1269,577,1272,575,1277,575,1283,580,1286,584,1291,595,1297,603,1305,615,1306,627,1313,631,1317,642,1318,648,1322,649,1329,653,1335,657,1339,660,1344,660,1349,656,1355,648,1364,647,1377,645,1380,630,1389,628,1393,625,1395,626,1409,621,1416,622,1420,626,1427,627,1432,623,1439,624,1445,624,1458,619,1465,615,1466,608,1462,605,1462,601,1467,595,1465,588,1453,588,1446,584,1444,579,1450,574,1457,570,1460,564,1459,559,1453,558,1449,560,1444,560,1431,554,1422,552,1412,552,1407,549,1402,554,1392,560,1386,559,1378,557,1374,550,1372,546,1371,540,1366,541,1362,544,1360,543,1348,545,1342,545,1331,543,1328,537,1326,529,1318,522,1310,517,1307,514,1303,512,1294,501,1286,497,1281,497,1277,498,1274,493,1266,490,1252,486,1244,486,1236,491,1230" href="/bbs/board.php?bo_table=seoul_b36" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="남해 하동 사천" />
        <area shape="poly" coords="854,1210,866,1210,871,1214,879,1218,883,1223,888,1226,892,1231,906,1243,908,1252,902,1260,878,1266,875,1258,873,1250,845,1244,839,1245,837,1248,832,1248,829,1253,821,1250,824,1240,844,1222,848,1222" href="/bbs/board.php?bo_table=seoul_b37" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김해갑" />
        <area shape="poly" coords="846,1249,864,1253,870,1258,871,1266,867,1278,864,1286,860,1288,852,1289,850,1291,845,1297,841,1297,832,1297,827,1294,827,1289,832,1282,832,1267,828,1258,837,1251,844,1248" href="/bbs/board.php?bo_table=seoul_b38" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="김해을" />
        <area shape="poly" coords="726,1123,742,1125,759,1117,769,1116,776,1129,780,1137,789,1140,796,1140,801,1144,819,1144,832,1144,837,1142,847,1140,860,1140,888,1126,898,1134,900,1154,896,1183,883,1185,878,1196,867,1204,851,1207,838,1218,820,1208,809,1209,790,1201,782,1209,783,1221,778,1225,754,1227,745,1234,739,1237,736,1253,745,1258,749,1267,746,1274,738,1277,732,1267,712,1271,701,1250,693,1248,688,1252,672,1252,664,1241,665,1232,660,1227,650,1226,645,1210,659,1212,669,1206,668,1194,686,1167,722,1168,722,1145,725,1137,724,1128" href="/bbs/board.php?bo_table=seoul_b39" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" alt="밀양 창녕" />
        <area shape="poly" coords="778,1386,782,1391,791,1391,792,1388,787,1384,783,1377,783,1368,785,1366,791,1367,792,1364,788,1359,789,1355,800,1349,802,1349,805,1354,808,1353,806,1348,810,1345,810,1341,813,1339,817,1340,822,1345,823,1350,818,1355,818,1362,822,1372,821,1383,819,1388,814,1392,814,1395,818,1397,823,1397,828,1394,831,1394,833,1398,831,1404,829,1409,826,1412,834,1428,830,1432,823,1432,818,1429,814,1431,811,1434,805,1438,809,1444,806,1458,799,1461,797,1465,790,1468,780,1461,781,1457,783,1452,785,1447,783,1443,774,1443,773,1436,770,1433,774,1427,784,1422,782,1412,772,1412,762,1417,755,1409,755,1401,759,1390" href="/bbs/board.php?bo_table=seoul_b40" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="거제" />
        <area shape="poly" coords="878,1203,884,1198,885,1190,900,1186,902,1182,902,1174,904,1170,902,1168,907,1160,912,1159,918,1165,932,1165,936,1166,939,1173,942,1177,943,1179,943,1181,938,1183,926,1201,926,1207,923,1209,914,1207,906,1211,902,1232,894,1226,890,1221,883,1217,878,1210" href="/bbs/board.php?bo_table=seoul_b42" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="양산갑" />
        <area shape="poly" coords="512,1194,531,1197,555,1195,567,1198,584,1195,591,1205,586,1227,537,1228,531,1213,530,1199,511,1195,505,1206,500,1209,498,1213,499,1225,503,1230,514,1232,523,1242,526,1248,533,1252,541,1261,559,1263,570,1260,580,1259,593,1259,600,1250,607,1246,611,1240,619,1236,632,1234,641,1231,644,1220,640,1211,644,1203,659,1202,664,1193,664,1186,675,1166,692,1156,710,1161,718,1159,715,1144,718,1134,714,1123,710,1117,682,1120,664,1114,660,1109,668,1091,661,1079,660,1067,643,1059,634,1060,629,1057,624,1054,617,1053,613,1048,598,1047,595,1037,591,1034,586,1034,585,1029,576,1026,572,1027,569,1031,561,1034,553,1038,547,1040,541,1043,526,1049,518,1054,515,1059,514,1068,507,1074,505,1079,509,1085,508,1091,502,1104,500,1112,502,1132,493,1142,492,1148,495,1154,506,1161,505,1172,511,1182" href="/bbs/board.php?bo_table=seoul_b43" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="산청 함양 거창" />
        
        <area shape="poly" coords="132,1656,143,1655,152,1652,158,1651,165,1646,176,1643,184,1641,187,1639,196,1640,199,1636,206,1636,215,1639,217,1646,224,1660,224,1669,215,1684,211,1692,193,1704,174,1707,163,1708,149,1707,109,1724,98,1730,92,1730,88,1727,79,1725,73,1720,71,1713,71,1703,75,1696,82,1690,89,1688,99,1680,102,1675,127,1661" href="/bbs/board.php?bo_table=seoul_b44" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="제주갑" />
        <area shape="poly" coords="224,1630,231,1630,238,1633,251,1633,261,1629,267,1627,284,1624,300,1634,305,1640,312,1643,313,1647,312,1652,307,1656,276,1670,270,1678,265,1681,249,1682,246,1687,237,1690,230,1691,225,1687,221,1686,221,1683,229,1678,230,1664,225,1653,221,1645,221,1638" href="/bbs/board.php?bo_table=seoul_b45" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="제주을" />
        <area shape="poly" coords="181,1711,182,1713,226,1713,231,1732,215,1747,201,1737,195,1747,182,1741,168,1740,167,1718,180,1714,178,1711,166,1712,153,1711,143,1715,138,1717,130,1717,125,1721,120,1723,112,1726,102,1732,93,1733,84,1731,77,1730,75,1733,76,1737,81,1741,84,1748,91,1757,94,1761,103,1766,115,1765,132,1754,145,1753,157,1753,166,1761,193,1761,211,1758,225,1758,247,1746,276,1736,292,1728,299,1720,304,1709,310,1703,320,1681,326,1676,328,1666,323,1658,311,1656,304,1662,290,1666,282,1672,277,1675,270,1684,251,1687,238,1693,229,1694,222,1690,216,1694,208,1697,203,1702" href="/bbs/board.php?bo_table=seoul_b46" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="서귀포" />
</map></div>
   
   



</div><!-- 상단 div - header 끝 -->

<!-- 게시판일 경우 상단내용 뿌리뿌리 -->
<?

if($bo_table){
	$ttt="<div style='width:100%;clear:both;;overflow:hidden;'>";
	$bbb="</div>";	
	if ($board[bo_content_head]) {
		echo $ttt;
    	echo stripslashes($board[bo_content_head]);
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

    
       
       

<!--<table><tr><td height="1px"></td></tr></table>
    <center>
    <a href="/bbs/board.php?bo_table=freewr01" target="_top" ><img src="<?=$g4[path]?>/images/kyopo.gif" width="160" height="38" alt=""></a>
    </center>

<table><tr><td height="1px"></td></tr></table>
    <center>
    <a href="/bbs/board.php?bo_table=freewr01" target="_top" ><img src="<?=$g4[path]?>/images/chunjo.gif" width="160" height="38" alt=""></a>
    </center>-->
       
       
        
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

