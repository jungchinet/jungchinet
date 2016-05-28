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
$url="https://news.google.co.kr/news?hl=ko&ned=kr&ie=UTF-8&q=%EA%B5%90%EC%9C%A1%EB%B6%80&output=rss";
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
	
	height: 4550px;
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
	height: 4550px;
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
 <p><a href="http://www.moe.go.kr/"><img src="/menuhtml/jb/ent14.gif" width="400" height="180" align=absmiddle /></a></p></td></table>
 
 
 <div id='ns7' >
        <? if($nsConfig[ns7_link]){ ?>
        <a href='<?=$nsConfig[ns7_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	       
        <? if($nsConfig[ns7_link]){ ?>
        </a>
        <? } ?>
        <?

		//추가추가
		$news_cate='jb_14';

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
                         <a class="twitter-timeline"  href="https://twitter.com/search?q=%EA%B5%90%EC%9C%A1%EB%B6%80" data-widget-id="644923864833634304" width="320" height="380" data-chrome="noheader nofooter noscrollbar ">교육부에 대한 트윗</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
 
 <div class="body2">
 
  <div class="edu_interval"></div>
  
  <div class="company_sub">교육부 산하 공기업 및 공공기관</div>
  <div class="company1_picture"><a href="http://www.tp.or.kr/">사립학교교직원연금공단</a></div>
  <div class="company1_profile">
    <ul>
      <li>기금관리형 준정부기관</li>
    </ul>
  </div>
  <div class="company1_picture"><a href="http://www.keris.or.kr/">한국교육학술정보원</a></div>
  <div class="company1_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
    </ul>
  </div>
  <div class="company2_picture"><a href="https://www.kofac.re.kr/">한국과학창의재단</a></div>
  <div class="company2_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.nrf.re.kr/">한국연구재단</a></div>
  <div class="company3_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
    </ul>
  </div>
  <div class="company4_picture"><a href="http://www.kosaf.go.kr/">한국장학재단</a></div>
  <div class="company4_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="https://www.gwnudh.or.kr/">강릉원주대학교치과병원</a></div>
  <div class="company5_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="https://www.knuh.or.kr">강원대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://knuh.kr/">경북대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.gnuh.co.kr/">경상대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="https://www.gist.ac.kr/">광주과학기술원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.nile.or.kr/">국가평생교육진흥원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.ust.ac.kr/">과학기술연합대학원대학교</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.krcf.re.kr/">기초기술연구회</a></div>
  <div class="company5_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.dgist.ac.kr/">대구경북과학기술원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.historyfoundation.or.kr/">동북아역사재단</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.pnuh.or.kr/">부산대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.pnudh.co.kr/">부산대학교치과병원</a></div>
  <div class="company5_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.snuh.org/">서울대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="https://www.snudh.org">서울대학교치과병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.unist.ac.kr/">울산과학기술대학교</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.cnuh.com/">전남대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.cuh.co.kr/">전북대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.jejunuh.co.kr/">제주대학교병원</a></div>
  <div class="company5_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="https://www.cnuh.co.kr">충남대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="https://www.cbnuh.or.kr/">충북대학교병원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kaist.ac.kr/">KAIST</a></div>
  <div class="company6_profile">
    <ul>
    <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.itkc.or.kr/">한국고전번역원</a></div>
  <div class="company5_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="https://www.kfpp.or.kr">한국사학진흥재단</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.aks.ac.kr/">한국학중앙연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kisti.re.kr/">한국과학기술정보연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kbsi.re.kr/">한국기초과학지원연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.kribb.re.kr/">한국생명공학연구원</a></div>
  <div class="company5_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kasi.re.kr/">한국천문연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kriss.re.kr/">한국표준과학연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="https://www.kiom.re.kr/">한국한의학연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kari.re.kr/">한국항공우주연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.kordi.re.kr/">한국해양연구원</a></div>
  <div class="company5_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="https://www.kist.re.kr">한국과학기술연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kaeri.re.kr/">한국원자력연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kirams.re.kr/">한국원자력의학원</a></div>
  <div class="company6_profile">
    <ul>
      <li>기타공공기관</li>
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