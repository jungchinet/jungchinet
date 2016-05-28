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

<style type="text/css">
#wrap {
	width: 1100px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
.body1 {
	background-color: #e4cfb0;
	height: 580px;
	width: 1100px;
	padding-top: 20px;
	padding-bottom: 20px;
        border-radius:10px;
	
}
.main_picture {
	float: left;
	height: 624px;
	width: 720px;
}
.boss_sub {
	float: left;
	height: 50px;
	width: 673px;
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
	width: 400px;
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
	height: 500px;
	width: 250px;
}
.edu_interval2 {
	float: left;
	height: 300px;
	width: 170px;
}
.boss2_sub {
	float: left;
	height: 33px;
	width: 843px;
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
	width: 350px;
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
$url="https://news.google.co.kr/news?hl=ko&ned=kr&ie=UTF-8&q=%EA%B5%AD%ED%9A%8C%EC%9D%98%EC%9E%A5&output=rss";
$ns[7] = simplexml_load_file_curl($url);



$tg='_blank';

function newsPrint($num){
	
	$news_cate='kh_01';
	$news_sql="insert into news_rss (subj, link, cate, reg_date) values";
	$nsContent='';
	for($z=0;$z<$parseNum;$z++){

		$news_sql.="('$ns[1]->channel[0]->item[$z]->title', '$ns[1]->channel[0]->item[$z]->link', '$news_cate', now()),";

		$nsContent.="<a href='".$ns[1]->channel[0]->item[$z]->link."' target='".$tg."' onfocus='this.blur()'><strong>".$ns[1]->channel[0]->item[$z]->title."</strong></a><br>";

	}
	echo $nsContent.=("<a href='".$ns[1]->channel[0]->item[$z]->link."' target='".$tg."' onfocus='this.blur()'><strong>".$ns[1]->channel[0]->item[$z]->title."</strong></a><br>");
	echo $nsContent;

	echo $news_sql=substr($news,0,-1);
	mysql_query($news_sql);
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
    left: -32%;
	padding:30px	
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

        
        <div id='ns7' >
        <? if($nsConfig[ns7_link]){ ?>
        <a href='<?=$nsConfig[ns7_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	       
        <? if($nsConfig[ns7_link]){ ?>
        </a>
        <? } ?>
        <?

		//추가추가
		$news_cate='kh_01';

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
        




<div id="wrap">
 <div class="body1">
  <div class="edu_interval"></div>
  <div class="edu_interval2"></div>
  <div class="boss_sub"><strong>국회의장</strong></div>
  <div class="boss_picture">
    <p><a href="/bbs/board.php?bo_table=seoul_a95"><img src="/menuhtml/kh/khboss.gif" width="90" height="121" /></a>정의화</p>
  </div>
  <div class="boss_profile">
    <ul>
      <li>1948년 12월 18일</li>
      <li>부산 중구동구</li>
      <li>새누리당</li>
    </ul>
  </div>
  
 <div class="boss2_sub"></div>
  <div class="boss2_sub">국회부의장</div>
  <div class="boss2_picture">
    <p><a href="/bbs/board.php?bo_table=seoul_a89"><img src="/menuhtml/kh/khboss2.gif" width="70" height="94" /></a>정갑윤</p>
  </div>
  <div class="boss2_profile">
    <ul>
      <li>1950년 11월 8일</li>
      <li>울산 중구</li>
      <li>새누리당</li>
    </ul>
  </div>
  <div class="boss2_picture">
    <p><a href="/bbs/board.php?bo_table=seoul_60"><img src="/menuhtml/kh/khboss3.gif" width="70" height="94" /></a>이석현</p>
  </div>
  <div class="boss2_profile">
    <ul>
      <li>1951년 3월 16일</li>
      <li>경기 안양시동안구갑</li>
      <li>더불어민주당</li>
    </ul>
  </div>
  
  
 </div>
</div>

<!--중간 광고부분-->
<div style='clear:both;margin:10px 0 10px 10px'>
<?
{
	$bGroup='uBanner2';
}
?>
</div>
<!--중간 광고부분 꿑-->

<?
include_once("../../tail2.php");
?>