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
$url="https://news.google.co.kr/news?hl=ko&ned=kr&ie=UTF-8&q=%EA%B8%88%EC%9C%B5%EC%9C%84%EC%9B%90%ED%9A%8COR%EA%B8%88%EC%9C%B5%EC%9C%84OR%EA%B8%88%EA%B0%90%EC%9B%90&output=rss";
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
	
	height: 320px;
	width: 1100px;
	padding-top: 20px;
}
.body2 {
	
	height: 2550px;
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
	height: 2550px;
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
 <p><a href="http://www.fsc.go.kr/"><img src="/menuhtml/jb/ent10.gif" width="500" height="148" align=absmiddle /></a></p></td></table>
 
 
 <div id='ns7' >
        <? if($nsConfig[ns7_link]){ ?>
        <a href='<?=$nsConfig[ns7_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	       
        <? if($nsConfig[ns7_link]){ ?>
        </a>
        <? } ?>
        <?

		//추가추가
		$news_cate='jb_10';

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
                          <a class="twitter-timeline"  href="https://twitter.com/search?q=%EA%B8%88%EC%9C%B5%EC%9C%84%20OR%20%EA%B8%88%EC%9C%B5%EC%9C%84%EC%9B%90%ED%9A%8C" data-widget-id="644921734890586112" width="320" height="380" data-chrome="noheader nofooter noscrollbar ">금융위 OR 금융위원회에 대한 트윗</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                   </div>
 
 <div class="body2">
 
  <div class="edu_interval"></div>
  
  <div class="company_sub">금융위원회 산하 공기업 및 공공기관</div>
  <div class="company1_picture"><a href="http://www.kamco.or.kr/">한국자산관리공사</a></div>
  <div class="company1_profile">
    <ul>
      <li>기금관리형 준정부기관</li>
      <li>608-828 부산광역시 남구 문현금융로 40 부산국제금융센터(BIFC)</li>
    </ul>
  </div>
  <div class="company2_picture"><a href="http://www.kibo.or.kr/">기술보증기금</a></div>
  <div class="company2_profile">
    <ul>
      <li>기금관리형 준정부기관</li>
      <li>608-040 부산광역시 남구 문현금융로 33 기술보증기금</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kodit.co.kr/">신용보증기금</a></div>
  <div class="company3_profile">
    <ul>
      <li>기금관리형 준정부기관</li>
      <li>701-300 대구 동구 첨단로 7 신용보증기금</li>
    </ul>
  </div>
  <div class="company4_picture"><a href="http://www.kiep.go.kr/">예금보험공사</a></div>
  <div class="company4_profile">
    <ul>
      <li>기금관리형 준정부기관</li>
      <li>100-180 서울시 중구 청계천로 30</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.hf.go.kr/">한국주택금융공사</a></div>
  <div class="company5_profile">
    <ul>
      <li>기금관리형 준정부기관</li>
      <li>부산시 남구 문현금융로40(문현동) 부산국제금융센터 한국주택금융공사 </li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.ksd.or.kr/">한국예탁결제원</a></div>
  <div class="company6_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>부산광역시 문현금융단지 부산국제금융센터</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.krx.co.kr/">한국거래소</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>부산시 남구 문현금융로 2(문현동) 부산국제금융센터</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.koscom.co.kr/">코스콤</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>서울특별시 영등포구 여의나루로 76</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kedkorea.com/">한국기업데이터</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>서울특별시 영등포구 여의도동 27-3 하나대투증권빌딩 7층</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kdb.co.kr/">산은금융지주</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>150-973 서울특별시 영등포구 은행로 14</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kdb.co.kr/">한국산업은행</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>150-973 서울특별시 영등포구 은행로 14</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.ibk.co.kr/">중소기업은행</a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공공기관</li>
      <li>서울특별시 중구 을지로2가 50</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.fss.or.kr/">금융감독원</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>150-743 서울특별시 영등포구 여의대로 38</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.fsa.or.kr">금융보안연구원</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>서울특별시 영등포구 의사당대로 143 금융투자협회빌딩 8, 9층</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.kfcc.co.kr/">새마을금고중앙회</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>135-538 서울특별시 강남구 봉은사로 114길 20 (삼성동) 새마을금고중앙회 빌딩</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.klia.or.kr/">생명보험협회</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>100-705 서울시 중구 퇴계로 173 (충무로3가), 남산스퀘어빌딩(구.극동빌딩) 16층</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.cu.co.kr/">신용협동조합중앙회</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>302-868 대전광역시 서구 한밭대로 745</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.crefia.or.kr/">여신금융협회</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>100-180 서울특별시 중구 다동길 43 (다동70번지) 한외빌딩13층 여신금융협회</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kdic.or.kr/">KR&C</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>100-180 서울시 중구 청계천로 30</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kofia.or.kr/">한국금융투자협회</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>150-974 서울특별시 영등포구 의사당대로 143 금융투자협회</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="https://www.kait.com">한국자산신탁</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>135-987 서울특별시 강남구 테헤란로 306 (역삼동 706-1) 카이트타워</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.kfpa.or.kr/">한국화재보험협회</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>150-885 서울특별시 영등포구 국제금융로6길 38 (여의도동,한국화재보험협회빌딩)</li>
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