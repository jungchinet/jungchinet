<?
include_once("../_common.php");
$g4['title'] = "";
include_once("../_head.php");

include_once("$g4[path]/lib/popup.lib.php");        // 팝업

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
$url="https://news.google.co.kr/news?hl=ko&ned=kr&ie=UTF-8&q=%EB%B0%A9%EC%86%A1%ED%86%B5%EC%8B%A0%EC%9C%84%EC%9B%90%ED%9A%8COR%EB%B0%A9%ED%86%B5%EC%9C%84&output=rss";
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
	
	height: 1250px;
	width: 1100px;
	padding-top: 20px;
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
	height: 1250px;
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
</style>


<div id="wrap">
 <div class="body1">
  <table width=100%><td width="100%" align=center>
 <p><a href="http://www.kcc.go.kr/"><img src="/menuhtml/jb/ent02.gif" width="500" height="128" align=absmiddle /></a></p></td></table>
 
 
 <div id='ns7' >
        <? if($nsConfig[ns7_link]){ ?>
        <a href='<?=$nsConfig[ns7_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	       
        <? if($nsConfig[ns7_link]){ ?>
        </a>
        <? } ?>
        <?
		$nsCont="<div id='ns7_1'>";
		$cnt=2;
        for($z=0;$z<$nsConfig[ns7_num];$z++){ 
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns7_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$nsCont.="<div class='titWrp'><a href='".$ns[7]->channel[0]->item[$z]->link."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ns[7]->channel[0]->item[$z]->title, 90, '..')."</strong>
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
 
  <div class="edu_interval"></div>
  
  <div class="company_sub">방송통신위원회 산하 공기업 및 공공기관</div>
  <div class="company1_picture"><a href="http://www.kobaco.co.kr">한국방송광고진흥공사</a></div>
  <div class="company1_profile">
    <ul>
      <li>준시장형 공기업</li>
      <li>서울 중구 세종대로 124 (태평로1가 25)</li>
    </ul>
  </div>
  <div class="company1_picture"><a href="http://www.kca.kr/">한국방송통신전파진흥원</a></div>
  <div class="company1_profile">
    <ul>
      <li>기금관리형 준정부기관</li>
      <li>520-822 전남 나주시 빛가람로 760 (빛가람동)</li>
    </ul>
  </div>
  <div class="company2_picture"><a href="http://www.kisa.or.kr/">한국인터넷진흥원</a></div>
  <div class="company2_profile">
    <ul>
      <li>위탁집행형 준정부기관</li>
      <li>[대동 청사] 138-803 서울시 송파구 중대로 109 (가락동 79-3) 대동빌딩</li>
      <li>[118 청사] 138-950 서울시 송파구 중대로 135 (가락동 78) IT벤처타워</li>
      <li>[서초 청사] 137-857 서울시 서초구 서초로 398 (서초2동 1321-11) 플래티넘타워</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.fbc.or.kr/">방송문화진흥회</a></div>
  <div class="company3_profile">
    <ul>
      <li>비지정기관</li>
      <li>150-877 서울시 영등포구 여의도동 24-1 율촌빌딩 6층</li>
    </ul>
  </div>
  <div class="company4_picture"><a href="http://www.kocsc.or.kr/">방송통신심의위원회</a></div>
  <div class="company4_profile">
    <ul>
      <li>비지정기관</li>
      <li>158-715 서울시 양천구 목동동로 233 방송회관 방송통신심의위원회</li>
    </ul>
  </div>
  <div class="company5_picture"><a href="http://www.ebs.co.kr/">한국교육방송공사</a></div>
  <div class="company5_profile">
    <ul>
      <li>비지정기관</li>
      <li>137-900 서울시 서초구 바우뫼로1길 35 한국교육방송공사</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kbs.co.kr/">한국방송공사</a></div>
  <div class="company6_profile">
    <ul>
      <li>비지정기관</li>
      <li>본관주소 :150-790 서울시 영등포구 여의공원로 13      </li>
      <li>별관주소 :150-892 서울시 영등포구 여의대방로 359      </li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kica.or.kr/">한국정보통신공사협회</a></div>
  <div class="company6_profile">
    <ul>
      <li>비지정기관</li>
      <li>140-801 서울시 용산구 한강대로 308(갈월동)</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.tta.or.kr/">한국정보통신기술협회</a></div>
  <div class="company6_profile">
    <ul>
      <li>비지정기관</li>
      <li>463-824 경기도 성남시 분당구 분당로 47 (구. 서현동 267-2)</li>
    </ul>
  </div>
  <div class="company6_picture"><a href="http://www.kici.re.kr/">한국정보통신산업연구원</a></div>
  <div class="company6_profile">
    <ul>
      <li>비지정기관</li>
      <li>440-330 경기도 수원시 장안구 하률로 12번길 80(천천동 571-2)</li>
    </ul>
  </div>
 </div>
  <table width=100%></table>

<a name="board"> </a>
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