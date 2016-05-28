<?
include_once("../_common.php");
$g4['title'] = "";
include_once("../_head.php");

include_once("$g4[path]/lib/popup.lib.php");        // 팝업
//뉴스관리 불러오기
$nsSql=mysql_query("select * from news_config");
$nsConfig=mysql_fetch_array($nsSql);
// 팝업출력
//echo popup("","test");

?>


<?




function cutStr($str, $len, $suffix="…") 
{ 

$CharSet = "UTF-8"; 

    $s = substr($str, 0, $len); 
    $cnt = 0; 
    for ($i=0; $i<strlen($s); $i++) 
        if (ord($s[$i]) > 127) 
            $cnt++;
    if ($CharSet == "UTF-8") 
        $s = substr($s, 0, $len - ($cnt % 3)); 
    else 
        $s = substr($s, 0, $len - ($cnt % 2)); 
    if (strlen($s) >= strlen($str)) 
        $suffix = ""; 
	
	$s=eregi_replace('&lt;br&gt;', '', $s);
	$s=eregi_replace('�', '', $s);
	$s=eregi_replace('�', '', $s);
    return $s . $suffix; 
}

//파싱할 뉴스 갯수
//$parseNum=40;

//뉴스관리 불러오기
$nsSql=mysql_query("select * from news_config");
$nsConfig=mysql_fetch_array($nsSql);

function simplexml_load_file_curl($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$xml = simplexml_load_string(curl_exec($ch));
	return $xml;
}



//서울신문
$url="https://news.google.co.kr/news?hl=ko&ned=kr&ie=UTF-8&q=%EB%AF%B8%EB%9E%98%EC%B0%BD%EC%A1%B0%EA%B3%BC%ED%95%99%EB%B6%80&output=rss";
$ns[7] = simplexml_load_file_curl($url);



$tg='_blank';

function newsPrint($num){
	
	$nsContent='';
	for($z=0;$z<$parseNum;$z++){
		$nsContent.="<a href='".$ns[1]->channel[0]->item[$z]->link."' target='".$tg."' onfocus='this.blur()'><strong>".$ns[1]->channel[0]->item[$z]->title."</strong></a><br>";
	}
	echo $nsContent.=("<a href='".$ns[1]->channel[0]->item[$z]->link."' target='".$tg."' onfocus='this.blur()'><strong>".$ns[1]->channel[0]->item[$z]->title."</strong></a><br>");
	echo $nsContent;
}

//이전 다음 버튼
$prevBtn="<img src='/menuhtml/ns/prev.jpg'>";
$nextBtn="<img src='/menuhtml/ns/next.jpg'>";

?>

<link rel="stylesheet" type="text/css" href="<?=$g4[path]?>/ixRolling/themes/base.css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?=$g4[path]?>/ixRolling/ixRolling.min.js"></script>
<script type="text/javascript">
// iframe resize
function autoResize(i)
{
    var iframeHeight=
    (i).contentWindow.document.body.scrollHeight;
    (i).height=iframeHeight+20;
}
</script>

<style>
#nsWrap {
	width:1100px;
	text-align:center;
	margin-top:30px;
}


#ns7 {
	width:310px;
	float:right;
	position: relative; 
    left: -30%;
	padding:25px	

}

#cont1 div div {
	line-height:180%;
	text-align:left;
	padding-left:10px;
}

#cont1 strong {
	text-align:left;
}

#cont:link, #cont:hover {
	text-decoration:none;	
}
.nsBox {
	width:320px;
	height:200px;
	overlfow:hidden;
	text-align:center;
}
.titWrp {
	width:290px;
	height:17px;
	overflow:hidden;
	margin-bottom:-17px;
	z-index:1;
}

.lh {
	line-height:50%;	
}
/*
#fb {
	font: 9pt tahoma;
	height: 200px;
	overflow: hidden;
	border: 1px #ddd solid;
	width: 100%;
	position: relative;
	background-color: #fff;
	color: #333;
	background: #fff url("<?=$g4[path]?>/ix_rolling/images/loading.gif") center center no-repeat;
	text-align: left
}*/
</style>

<script>
function nextP(ns){
	var num=document.getElementById('ns'+ns+'_num').value;
	var now=document.getElementById('ns'+ns+'_now').value;
	if(now==num){ next=1; }else{ next=parseInt(now)+1; }
	document.getElementById('ns'+ns+'_'+now).style.display='none';
	document.getElementById('ns'+ns+'_'+next).style.display='block';
	document.getElementById('ns'+ns+'_now').value=next;
}
function prevP(ns){
	var num=document.getElementById('ns'+ns+'_num').value;
	var now=document.getElementById('ns'+ns+'_now').value;
	if(now==1){ prev=num; }else{ prev=parseInt(now)-1; }
	document.getElementById('ns'+ns+'_'+now).style.display='none';
	document.getElementById('ns'+ns+'_'+prev).style.display='block';
	document.getElementById('ns'+ns+'_now').value=prev;
}
</script>



<style type="text/css">
#wrap {
	width: 1100px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
.body1 {
	
	height: 350px;
	width: 1100px;
	padding-top: 20px;
}
.body2 {
	
	height: 4350px;
	width: 1100px;
	padding-top: 20px;
}
.body3 {
	
	height: 410px;
	width: 1100px;
	padding-top: 20px;
}
.assem1_profile {
	float: left;
	height: 130px;
	width: 420px;
}
.main_picture {
	float: left;
	height: 624px;
	width: 720px;
}
.boss_sub {
	float: left;
	height: 50px;
	width: 380px;
	text-align: left;
	padding-top: 10px;
	font-size: 25px;
	font-family: Verdana, Geneva, sans-serif;
	color: #09F;
}
.boss_picture {
	float: left;
	height: 121px;
	width: 90px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.boss_profile {
	float: left;
	height: 121px;
	width: 290px;
}
#wrap .body1  ul li {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
}
.interval {
	float: left;
	height: 453px;
	width: 380px;
}
.edu_interval {
	float: left;
	height: 4350px;
	width: 20px;
}
.boss2_sub {
	float: left;
	height: 33px;
	width: 1080px;
	text-align: left;
	padding-top: 10px;
	font-size: 23px;
	font-family: Verdana, Geneva, sans-serif;
	color: #09F;
	font-weight: bold;
}
.boss2_picture {
	float: left;
	height: 130px;
	width: 70px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.boss2_profile {
	float: left;
	height: 130px;
	width: 1010px;
}

.company_sub {
	margin-top: 20px;
	float: left;
	height: 31px;
	width: 1080px;
	text-align: left;
	font-size: 20px;
	font-family: Verdana, Geneva, sans-serif;
	color: #09F;
	font-weight: bold;
}
.company1_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo1_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company1_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company2_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo2_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company2_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company3_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo3_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company3_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company4_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo4_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company4_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company5_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo5_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company5_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company6_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo6_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company6_profile {
	float: left;
	height: 111px;
	width: 810px;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
}
</style>


<div id="wrap">
 <div class="body1">
  <table width=100%><td width="100%" align=center>
 <p><a href="http://www.msip.go.kr/"><img src="/menuhtml/jb/ent13.gif" width="400" height="181" align=absmiddle /></a></p></td></table>
 
 
 <div id='ns7' >
        <? if($nsConfig[ns7_link]){ ?>
        <a href='<?=$nsConfig[ns7_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	       
        <? if($nsConfig[ns7_link]){ ?>
        </a>
        <? } ?>
        <?

		//추가추가
		$news_cate='jb_13';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time2']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns7_num];$z++){

				$news_sql.="('".addslashes($ns[7]->channel[0]->item[$z]->title)."', '".addslashes($ns[7]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
			}
			$news_sql=substr($news_sql,0,-1);
			$rst=mysql_query($news_sql);

			if($rst){

				$cateNum=mysql_fetch_row(mysql_query("select count(*) from news_rss_config where cate='$news_cate'"));

				if($cateNum[0]>0){
					$newsql="update news_rss_config set last_update=now() where cate='$news_cate'";
				}else{
					$newsql="insert into news_rss_config set cate='$news_cate', last_update=now()";
				}
				mysql_query($newsql);

			}

		}
		//추가추가



		$ngsql="select * from news_rss where cate='$news_cate' and subj!='' order by idx asc";
		$ngrst=mysql_query($ngsql);
		$ngnum=mysql_num_rows($ngrst);
		$nsCont="<div id='ns7_1'>";
		$cnt=2;
		for($z=0;$z<$ngnum;$z++){ 

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns7_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ngr['subj'], 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }			
		}

		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns7_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns7_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(7)'><?=$prevBtn?></a> <a href='javascript:nextP(7)'><?=$nextBtn?></a></center>
        </div>
 
 </div>
 
 <div class="body3">
 
  <div class="assem1_profile"></div>
                          <a class="twitter-timeline"  href="https://twitter.com/search?q=%EB%AF%B8%EB%9E%98%EC%B0%BD%EC%A1%B0%EA%B3%BC%ED%95%99%EB%B6%80%20OR%20%EB%AF%B8%EB%9E%98%EB%B6%80" data-widget-id="644923458229415936" width="320" height="380" data-chrome="noheader nofooter noscrollbar ">미래창조과학부 OR 미래부에 대한 트윗</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
              </div>
 
 <div class="body2">
 
  <div class="edu_interval"></div>
  
  <div class="company_sub">미래창조과학부 산하 공기업 및 공공기관</div>
  <div class="company1_picture"><a href="http://www.posid.or.kr/">우체국금융개발원</a></div>
  <div class="company1_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>서울특별시 영등포구 경인로 841 (영등포동4가)</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.pola.or.kr/">우체국물류지원단</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li> 서울특별시 광진구 자양로 76</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.nipa.kr/">정보통신산업진흥원</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>서울특별시 송파구 중대로 113 NIPA빌딩</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kofac.re.kr/">한국과학창의재단</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>135-867 서울특별시 강남구 선릉로 602, 5~14층(삼성동)</li>
    </ul>
  </div>
   <div class="company3_picture"><a href="http://www.nrf.re.kr/">한국연구재단</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>서울청사 [137-748] 서울특별시 서초구 헌릉로 25</li>
      <li>대전청사 [305-754] 대전광역시 유성구 가정로 201</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.posa.or.kr">한국우편사업진흥원</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>서울시 영등포구 영중로83</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kisa.or.kr/">한국인터넷진흥원</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>대동 청사 (138-803) 서울시 송파구 중대로 109 (가락동 79-3) 대동빌딩</li>
      <li>118 청사 (138-950) 서울시 송파구 중대로 135 (가락동 78) IT벤처타워</li>
      <li>서초 청사 (137-857) 서울시 서초구 서초로 398 (서초2동 1321-11) 플래티넘타워</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.nia.or.kr/">한국정보화진흥원</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>무교청사 : 100-775 서울특별시 중구 청계천로 (무교동 77번지) 14 NIA빌딩</li>
      <li>등촌청사 : 157-715 서울특별시 강서구 공항대로 489 (등촌동)</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kca.kr/">한국방송통신전파진흥원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기금관리형 준정부기관</li>
      <li>520-822 전남 나주시 빛가람로 760</li>
    </ul>
  </div>
  <div class="company2_picture"><a href="http://www.poma.or.kr/">우체국시설관리단</a></div>
  <div class="company2_profile">
    <ul>
      <li>기타공공기관</li>
      <li>서울 광진구 강변역로 2 동서울우편물류센터 4층</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.gist.ac.kr/">광주과학기술원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>광주광역시 북구 첨단과기로 123 (오룡동)</li>
    </ul>
  </div>
  <div class="company4_picture"><a href="http://www.nst.re.kr/">국가과학기술연구회</a></div>
  <div class="company4_profile">
    <ul>
      <li>기타공공기관</li>
      <li>세종특별자치시 시청대로 370 세종국책연구단지 연구지원동 6, 7층</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.ibs.re.kr/">기초과학연구원</a></div>
  <div class="company5_profile">
    <ul>
      <li>기타공공기관</li>
      <li>305-811 대전광역시 유성구 유성대로 1689번길 70(전민동) 기초과학연구원</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.dgist.ac.kr/">대구경북과학기술원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대구광역시 달성군 현풍면 테크노중앙대로 333번지</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.popa.or.kr/">별정우체국연금관리단</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>서울특별시 마포구 마포대로 130(공덕동) 별정우체국연금관리단빌딩</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.innopolis.or.kr/">연구개발특구진흥재단</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전 유성구 엑스포로 123번길 27-5</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kist.re.kr/">한국건설기술연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>136-791 서울특별시 성북구 화랑로 14길 5</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kistep.re.kr/">한국과학기술기획평가원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>서울시 서초구 마방길68(양재동) 동원산업빌딩 4층, 8층~12층</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.fss.or.kr/">한국과학기술연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>서울시 성북구 화랑로 14길 5</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kaist.ac.kr/">한국과학기술원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 대학로 291</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kisti.re.kr/">한국과학기술정보연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 대학로 245</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.kimm.re.kr/">한국기계연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 가정북로 156번지 (장동)</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kbsi.re.kr/">한국기초과학지원연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 과학로 169-148</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kribb.re.kr/">한국생명공학연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 과학로 125번지</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kitech.re.kr/">한국생산기술연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>331-822 충청남도 천안시 서북구 입장면 양대기로길 89 한국생산기술연구원</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kfri.re.kr/">한국식품연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>경기도 성남시 분당구 안양판교로 1201번길 62</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kier.re.kr/">한국에너지기술연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 가정로 152번</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kaeri.re.kr/">한국원자력연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 대덕대로 989번길 111</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kirams.re.kr/">한국원자력의학원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>서울특별시 노원구 노원길 75</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.keri.re.kr/">한국전기연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>창원본원 642-120 경상남도 창원시 성산구 불모산로10번길 12 (성주동)<br />
        </li>
      <li>안산분원 426-170 경기도 안산시 상록구 항가울로 111 (사동)  <br />
        </li>
      <li>의왕분원 437-808 경기도 의왕시 내손순환로 138 (내손동)</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.etri.re.kr">한국전자통신연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>305-700, 대전광역시 유성구 가정로 218</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kigam.re.kr/">한국지질자원연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 과학로 124</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kasi.re.kr/">한국천문연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 대덕대로 776번지</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.krri.re.kr/">한국철도기술연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>437-757 경기도 의왕시 철도박물관로 176 한국철도기술연구원 </li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kriss.re.kr/">한국표준과학연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 가정로 267 (305-340)</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.kiom.re.kr/">한국한의학연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전시 유성구 유성대로 1672</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kari.re.kr/">한국항공우주연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 과학로 169-84(어은동)</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.krict.re.kr/">한국화학연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>대전광역시 유성구 가정로 141</li>
    </ul>
  </div>
  
 </div>
  <table width=100%></table>

</div>

<!--중간 광고부분-->
<div style='clear:both;margin:10px 0 10px 10px'>
<?
{
	$bGroup='uBanner1';
}
?>
</div>
<!--중간 광고부분 꿑-->

<?
include_once("../../tail2.php");
?>