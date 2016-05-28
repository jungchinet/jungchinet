<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$g4_board = array();

$g4_board_select = "*";
$g4_board_sql = " select $g4_board_select from $g4[board_table] order by bo_order_search, gr_id, bo_table ";
$g4_board_result = mysql_query($g4_board_sql);
for($i=0; $g4_board_row = mysql_fetch_array($g4_board_result); $i++){
	$g4_board[$i] = $g4_board_row;
}

$g4_group = array();
$g4_group_select = "gr_id, gr_subject, gr_admin, gr_use_access, gr_1";
$g4_group_sql = " select $g4_group_select from $g4[group_table] order by gr_1 asc ";
$g4_group_result = mysql_query($g4_group_sql);
for($i=0; $g4_group_row = mysql_fetch_array($g4_group_result); $i++)
	$g4_group[$i] = $g4_group_row;
	
for ($i=0; $i<count($g4_group); $i++){
	$g_menu[$i] = $g4_group[$i][gr_subject];
	$g_menu_s[$i] = $g4_group[$i][gr_subject];
	$g_menu_h[$i] = "$g4[path]/index.php?gr_id={$g4_group[$i][gr_id]}";
	$group_id[$i] = $g4_group[$i][gr_id];
	
	$gr_bo_c[$i] = 0;
}
	
$gmc = $i;	

for ($i=0; $i<count($g4_board); $i++) {
	for($k=0; $k<$gmc; $k++){
		if($g4_board[$i][gr_id] == $group_id[$k]){	
			$s_href[$k][$gr_bo_c[$k]] = "$g4[bbs_path]/board.php?bo_table={$g4_board[$i][bo_table]}";
			$s_menu[$k][$gr_bo_c[$k]] = $g4_board[$i][bo_subject];
			
			$gr_bo_c[$k]++;
		}
	}
}

$smc = count($g4_board);

if($bo_table){
	for($gr=0; $gr<$smc; $gr++){
		if($bo_table == $g4_board[$gr]){
			$gr_id = $g4_board[$gr][gr_id];
			break;
		}
	}
}

?>
<link href="<?=$g4['path']?>/js_menu11/css/menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript"> 
jQuery(function($){
	function eMenuAction(){
	  $('ul.active').removeClass('active'); // 기존에 선택된 것 제거
	  $(this).parent('li').children('ul').addClass('active'); // 선택된 것의 하위 ul에 active를 추가해준다.
	}
	$('ul.mother>li>a').mouseover(eMenuAction).focus(eMenuAction); /* 작동 */
	function eMenuHide(){
		$('ul.active').removeClass('active'); // 기존에 선택된 것 제거
	}
	$('ul.mother').mouseleave(eMenuHide); //마우스가 떠나면 삭제
	$('*:not("#eMenu *")').focus(eMenuHide);/* 메뉴밖에 포커스가 잡히면 모두 숨김*/
})
</script>

 <div id="eMenu">
 
	<ul class="mother">
		<? for($i=3; $i<4; $i++){ ?>
		<li><a href="/menuhtml/ns/ns.php"><span><img src="/images/news.gif" width="30" height="26" align="absmiddle"></span></a>

		<li><a href="/bbs/board.php?bo_table=main01"><span><img src="/images/jb.gif" width="37" height="26" align="absmiddle"></span></a>
			<ul class="child">
				<li><a href="/menuhtml/jb/jb_boardlist.php"><?=전체부처?></a></li>
				<li><a href="/bbs/board.php?bo_table=mgov01"><?=외교부?></a></li>
				<li><a href="/bbs/board.php?bo_table=mgov02"><?=국방부?></a></li>
				
			</ul>
			<!--<ul class="child">
				<li><a href="/menuhtml/jb/jk_03.php"><?=경찰청?></a></li>
				<li><a href="/menuhtml/jb/jb_25.php"><?=고용노동부?></a></li>
				<li><a href="/menuhtml/jb/jb_09.php"><?=공정거래위원회?></a></li>
				<li><a href="/menuhtml/jb/jb_30.php"><?=관세청?></a></li>
				<li><a href="/menuhtml/jb/jb_14.php"><?=교육부?></a></li>
				<li><a href="/menuhtml/jb/jb_07.php"><?=국가보훈처?></a></li>
				<li><a href="/menuhtml/jb/jb_03.php"><?=국무총리실?></a></li>
				<li><a href="/menuhtml/jb/jb_04.php"><?=국민안전처?></a></li>
				<li><a href="/menuhtml/jb/jb_18.php"><?=국방부?></a></li>
				<li><a href="/menuhtml/jb/jb_29.php"><?=국세청?></a></li>
				<li><a href="/menuhtml/jb/jb_27.php"><?=국토교통부?></a></li>
				<li><a href="/menuhtml/jb/jb_10.php"><?=금융위원회?></a></li>
				<li><a href="/menuhtml/jb/jb_39.php"><?=기상청?></a></li>
				<li><a href="/menuhtml/jb/jb_12.php"><?=기획재정부?></a></li>
				<li><a href="/menuhtml/jb/jb_21.php"><?=농림축산식품부?></a></li>
				<li><a href="/menuhtml/jb/jb_35.php"><?=농촌진흥청?></a></li>
				<li><a href="/menuhtml/jb/jb_34.php"><?=문화재청?></a></li>
				<li><a href="/menuhtml/jb/jb_20.php"><?=문화체육관광부?></a></li>
				<li><a href="/menuhtml/jb/jb_13.php"><?=미래창조과학부?></a></li>
				<li><a href="/menuhtml/jb/jb_02.php"><?=방송통신위원회?></a></li>
				<li><a href="/menuhtml/jb/jb_33.php"><?=방위사업청?></a></li>
				<li><a href="/menuhtml/jb/jb_17.php"><?=법무부?></a></li>
				<li><a href="/menuhtml/jb/jb_06.php"><?=법제처?></a></li>
				<li><a href="/menuhtml/jb/jb_23.php"><?=보건복지부?></a></li>
				<li><a href="/menuhtml/jb/jb_36.php"><?=산림청?></a></li>
				<li><a href="/menuhtml/jb/jb_22.php"><?=산업통상자원부?></a></li>
				<li><a href="/menuhtml/jb/jb_08.php"><?=식품의약품안전처?></a></li>
				<li><a href="/menuhtml/jb/jb_26.php"><?=여성가족부?></a></li>
				<li><a href="/menuhtml/jb/jb_15.php"><?=외교부?></a></li>
				<li><a href="/menuhtml/jb/jb_11.php"><?=원자력안전위원회?></a></li>
				<li><a href="/menuhtml/jb/jb_05.php"><?=인사혁신처?></a></li>

				<li><a href="/menuhtml/jb/jb_31.php"><?=조달청?></a></li>
				<li><a href="/menuhtml/jb/jb_37.php"><?=중소기업청?></a></li>
				<li><a href="/menuhtml/jb/jb_32.php"><?=통계청?></a></li>
				<li><a href="/menuhtml/jb/jb_16.php"><?=통일부?></a></li>
				<li><a href="/menuhtml/jb/jb_38.php"><?=특허청?></a></li>
				<li><a href="/menuhtml/jb/jb_28.php"><?=해양수산부?></a></li>
				<li><a href="/menuhtml/jb/jb_19.php"><?=행정자치부?></a></li>
				<li><a href="/menuhtml/jb/jb_24.php"><?=환경부?></a></li>
			</ul> -->
		<li><a href="/bbs/board.php?bo_table=main02"><span><img src="/images/kh.gif" width="27" height="26" align="absmiddle"></span></a>
			<ul class="child">
				<li><a href="/menuhtml/jb/kh_01.php"><?=국회의장?></a></li>
				<li><a href="/menuhtml/jb/kh_02.php"><?=상임위원회?></a></li>
			</ul>
		<li><a href="/menuhtml/jb/kh_03.php"><span><img src="/images/jk.gif" width="15" height="26" align="absmiddle"></span></a>
			<ul class="child">
				<li><a href="/menuhtml/jk/jk_boardlist.php"><?=전국지역구?></a></li>
			    <li><a href="/bbs/board.php?bo_table=city01"><?=서울?></a></li>
				<li><a href="/bbs/board.php?bo_table=city02"><?=경기도?></a></li>
				<li><a href="/bbs/board.php?bo_table=city03"><?=인천?></a></li>

				<li><a href="/bbs/board.php?bo_table=city14"><?=부산?></a></li>
				<li><a href="/bbs/board.php?bo_table=city12"><?=대구?></a></li>
				<li><a href="/bbs/board.php?bo_table=city13"><?=울산?></a></li>
				<li><a href="/bbs/board.php?bo_table=city16"><?=경상북도?></a></li>
				<li><a href="/bbs/board.php?bo_table=city15"><?=경상남도?></a></li>
				
				<li><a href="/bbs/board.php?bo_table=city05"><?=세종시?></a></li>
				<li><a href="/bbs/board.php?bo_table=city06"><?=대전?></a></li>
				<li><a href="/bbs/board.php?bo_table=city08"><?=충청북도?></a></li>
				<li><a href="/bbs/board.php?bo_table=city07"><?=충청남도?></a></li>
				
				<li><a href="/bbs/board.php?bo_table=city09"><?=광주?></a></li>
				<li><a href="/bbs/board.php?bo_table=city11"><?=전라북도?></a></li>
				<li><a href="/bbs/board.php?bo_table=city10"><?=전라남도?></a></li>
				<li><a href="/bbs/board.php?bo_table=city17"><?=제주도?></a></li>
				
				<li><a href="/bbs/board.php?bo_table=city04"><?=강원도?></a></li>
				
				<li><a href="/bbs/board.php?bo_table=main05"><?=북한?></a></li>
			</ul>
		</li>
		<li><a href="/menuhtml/ab/ab.php"><span><img src="/images/ab.gif" width="26" height="26" align="absmiddle"></span></a>
			<ul class="child">

				
				<li><a href="/bbs/board.php?bo_table=ab_01"><?=미국?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_03"><?=일본?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_02"><?=중국?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_06"><?=캐나다?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_05"><?=호주?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_04"><?=유럽?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_07"><?=동남아?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_08"><?=남미?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_09"><?=중동?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_10"><?=인도?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_11"><?=아프리카?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_12"><?=러시아?></a></li>
				<li><a href="/bbs/board.php?bo_table=ab_13"><?=중앙아시아?></a></li>
			</ul>  
		</li>
		
		
		<li><a href="/bbs/board.php?bo_table=mlaw01"><span><img src="/images/law.gif" width="27" height="26" align="absmiddle"></span></a>
			<ul class="child">
			    <li><a href="/bbs/board.php?bo_table=mlaw02"><?=대검찰청?></a></li>
			    <li><a href="/bbs/board.php?bo_table=mlaw03"><?=경찰청?></a></li>
				<li><a href="/bbs/board.php?bo_table=mlaw04"><?=헌법재판소?></a></li>
			</ul>
		</li>
		
		<li><a href="/bbs/board.php?bo_table=main06"><span><img src="/images/senuri.gif" width="37" height="26" align="absmiddle"></span></a>
		<li><a href="/bbs/board.php?bo_table=main07"><span><img src="/images/minju.gif" width="37" height="26" align="absmiddle"></span></a>
		<li><a href="/bbs/board.php?bo_table=main09"><span><img src="/images/peopledang.gif" width="37" height="26" align="absmiddle"></span></a>
		<li><a href="/bbs/board.php?bo_table=main08"><span><img src="/images/junge.gif" width="37" height="26" align="absmiddle"></span></a>
		<!--<li><a href="/bbs/board.php?bo_table=main09"><span><img src="/images/tongjin.gif" width="37" height="26" align="absmiddle"></span></a>-->
		
		<li><a href="/bbs/board.php?bo_table=mparty01"><span><img src="/images/jungdang.gif" width="37" height="26" align="absmiddle"></span></a>
			<ul class="child">
				<li><a href="/bbs/board.php?bo_table=mparty02"><?=시민단체?></a></li>

			 </ul>
		
	<!--	<li><a href="/menuhtml/jk/unlist.php"><span><img src="/images/un.gif" width="34" height="26" align="absmiddle"></span></a>
				<ul class="child">
				<li><a href="/bbs/board.php?bo_table=mparty03"><?=불교?></a></li>
				<li><a href="/bbs/board.php?bo_table=mparty04"><?=개신교?></a></li>
				<li><a href="/bbs/board.php?bo_table=mparty05"><?=천주교?></a></li>
				
				<li><a href="/bbs/board.php?bo_table=miniparty01"><?=자영업자?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty02"><?=회사원?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty03"><?=공무원?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty04"><?=비정규직?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty05"><?=서비스직?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty06"><?=일용직?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty07"><?=알바?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty08"><?=학생?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty09"><?=주부?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty10"><?=백수?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty11"><?=영화인?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty12"><?=뮤지션?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty13"><?=게임IT?></a></li>
				<li><a href="/bbs/board.php?bo_table=miniparty14"><?=만화가?></a></li>	
			</ul>  -->
		
	    <li><a href="/bbs/login.php"><span><img src="/images/login.gif" width="37" height="26" align="absmiddle"></span></a>
	    <!--<li><a href="/menuhtml/ns/ns2.php"><span><img src="/images/tongjin.gif" width="37" height="26" align="absmiddle"></span></a>-->
	    	<ul class="child">
	    		<li><a href="/bbs/board.php?bo_table=battle01"><?=자유게시판?></a></li>
	    		<li><a href="/bbs/board.php?bo_table=ask01"><?=운영자게시판?></a></li>
				<li><a href="/menuhtml/logout/notice.php"><?=설립취지?></a></li>
				
			 </ul>
		
            

		<? } ?>
	</ul>

</div>
