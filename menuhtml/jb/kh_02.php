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
	height: 150px;
	width: 1100px;
	padding-top: 20px;
    border-radius:10px;
}
.body3 {
	background-color: #e4cfb0;
	height: 400px;
	width: 1100px;
	padding-top: 20px;
    border-radius:10px;
}
.listpagebody1 {
	background-color: #e4cfb0;
	height: 2850px;
	width: 1100px;
	padding-top: 20px;
	padding-bottom: 20px;
        border-radius:10px;
}
.blank {
	float: left;
	height: 2000px;
	width: 60px;
}
.blank2 {
	float: left;
	height: 400px;
	width: 60px;
}
.subject {
	float: left;
	height: 50px;
	width: 1100px;
	color: #000;
	text-decoration: none;
	margin: 0px;
	padding: 0px;
	list-style-type: none;
	text-align: center;
}
.subject2 {
	float: left;
	height: 50px;
	width: 1100px;
	color: #000;
	text-decoration: none;
	margin: 0px;
	padding: 0px;
	list-style-type: none;
	text-align: center;
}
.list1 {
	float: left;
	height: 600px;
	width: 170px;
	color: #000;
	text-decoration: none;
	margin: 0px;
	padding: 0px;
	list-style-type: none;
}
.list2 {
	float: left;
	height: 600px;
	width: 170px;
}
.list3 {
	float: left;
	height: 600px;
	width: 170px;
}
.list4 {
	float: left;
	height: 600px;
	width: 170px;
}
.list5 {
	float: left;
	height: 600px;
	width: 170px;
}
.list6 {
	float: left;
	height: 600px;
	width: 170px;
}
.list7 {
	float: left;
	height: 600px;
	width: 170px;
}
.list8 {
	float: left;
	height: 600px;
	width: 170px;
}
.list9 {
	float: left;
	height: 600px;
	width: 170px;
}
.list10 {
	float: left;
	height: 600px;
	width: 170px;
}
.list11 {
	float: left;
	height: 600px;
	width: 170px;
}
.list12 {
	float: left;
	height: 600px;
	width: 170px;
}
.list13 {
	float: left;
	height: 600px;
	width: 170px;
}
.list14 {
	float: left;
	height: 600px;
	width: 170px;
}
.list15 {
	float: left;
	height: 600px;
	width: 170px;
}
.list16 {
	float: left;
	height: 600px;
	width: 170px;
}
.list17 {
	float: left;
	height: 900px;
	width: 170px;
}
.list18 {
	float: left;
	height: 900px;
	width: 170px;
}
.list19 {
	float: left;
	height: 400px;
	width: 170px;
}
.list20 {
	float: left;
	height: 400px;
	width: 170px;
}
.list21 {
	float: left;
	height: 400px;
	width: 170px;
}
.list22 {
	float: left;
	height: 400px;
	width: 170px;
}
.list23 {
	float: left;
	height: 400px;
	width: 170px;
}
.list24 {
	float: left;
	height: 400px;
	width: 170px;
}
ul {
	list-style-type: none;
	color: #09F;
	text-decoration: none;
}

a:link {
	text-decoration: none;
}

body,td,th {
	font-family: Verdana, Geneva, sans-serif;
}
.assem99_profile {
	float: left;
	height: 100px;
	width: 395px;
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
$url="https://news.google.co.kr/news?hl=ko&ned=kr&ie=UTF-8&q=%EA%B5%AD%ED%9A%8C%EC%83%81%EC%9E%84%EC%9C%84&output=rss";
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

<div id="wrap">
 <div class="body1">
        
        <div id='ns7' >
        <? if($nsConfig[ns7_link]){ ?>
        <a href='<?=$nsConfig[ns7_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	       
        <? if($nsConfig[ns7_link]){ ?>
        </a>
        <? } ?>
        <?

		//추가추가
		$news_cate='kh_02';

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
  <div class="assem99_profile"></div>
  <a class="twitter-timeline" href="https://twitter.com/search?q=%EC%83%81%EC%9E%84%EC%9C%84%20OR%20%EC%83%81%EC%9E%84%EC%9C%84%EC%9B%90%ED%9A%8C" data-widget-id="642851846327939073" width="320" height="380" data-chrome="noheader nofooter noscrollbar ">상임위 OR 상임위원회에 대한 트윗</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
 </div>


  <div class="listpagebody1">
<div class="subject">
    <h1>상임위원회</h1></p>
  </div>
<div class="subject">
    <font color=#bf2410>새누리당</font><font color=#1689da>더불어민주당</font></a><font color=#cf6d17>정의당</font></p>
</div>
<div class="blank"></div>
    <div class="list1">
    <h2><strong>국회운영</strong>
    </h2>
    <ul>
        <p><a href="/bbs/board.php?bo_table=seoul_68"><font color=#bf2410>원유철(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_a87"><font color=#bf2410>조원진(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=berye01"><font color=#bf2410>강은희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a81"><font color=#bf2410>권은희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_51"><font color=#bf2410>김용남</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b22"><font color=#bf2410>김종태</font></a><br />
          <a href="/bbs/board.php?bo_table=berye07"><font color=#bf2410>문정림</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b28"><font color=#bf2410>박성호</font></a><br />
          <a href="/bbs/board.php?bo_table=berye10"><font color=#bf2410>박윤옥</font></a><br />
          <a href="/bbs/board.php?bo_table=berye19"><font color=#bf2410>이상일</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a17"><font color=#bf2410>이이재</font></a><br />
          <a href="/bbs/board.php?bo_table=berye23"><font color=#bf2410>이재영</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a42"><font color=#bf2410>이종배</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_86"><font color=#bf2410>함진규</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_97"><font color=#bf2410>홍철호</font></a><br /></p>
   
      <p> <a href="/bbs/board.php?bo_table=seoul_a70"><font color=#1689da>이춘석(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a54"><font color=#1689da>권은희</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe04"><font color=#1689da>김용익</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a31"><font color=#1689da>박수현</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe09"><font color=#1689da>백군기</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_74"><font color=#1689da>부좌현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a59"><font color=#1689da>신정훈</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_67"><font color=#1689da>이언주</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_59"><font color=#1689da>이종걸</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe14"><font color=#1689da>진선미</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe17"><font color=#1689da>최민희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a10"><font color=#1689da>최원식</font></a><br /></p>
          
      <p> <a href="/bbs/board.php?bo_table=jbe04"><font color=#cf6d17>정진후</font></a></p>
    </ul>
    <p> </p>
    <p> </p>
    <p> </p>
    </div>
    
<div class="list2">
  <h2>법제사법</h2>
  <ul>
    <p><a href="/bbs/board.php?bo_table=seoul_a26"><font color=#1689da>이상민(위원장)</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_b23"><font color=#bf2410>이한성(간사)</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b04"><font color=#bf2410>김도읍</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b34"><font color=#bf2410>김재경</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a13"><font color=#bf2410>김진태</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_98"><font color=#bf2410>노철래</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b13"><font color=#bf2410>이병석</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a89"><font color=#bf2410>정갑윤</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a02"><font color=#bf2410>홍일표</font></a><br /></p>
   
    <p><a href="/bbs/board.php?bo_table=seoul_71"><font color=#1689da>전해철(간사)</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a55"><font color=#1689da>박지원</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_10"><font color=#1689da>서영교</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a60"><font color=#1689da>우윤근</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a70"><font color=#1689da>이춘석</font></a>
       <a href="/bbs/board.php?bo_table=seoul_a52"><font color=#1689da>임내현</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=jbe03"><font color=#cf6d17>서기호</font></a></p>
  </ul>
  </div>
<div class="list3">
  <h2>정무
  </h2>
  <ul>
    <p><a href="/bbs/board.php?bo_table=seoul_a39"><font color=#bf2410>정우택(위원장)</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_28"><font color=#bf2410>김용태(간사)</font></a><br />
      <a href="/bbs/board.php?bo_table=berye02"><font color=#bf2410>김상민</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_46"><font color=#bf2410>김을동</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b01"><font color=#bf2410>김정훈</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b19"><font color=#bf2410>김태환</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a93"><font color=#bf2410>박대동</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_47"><font color=#bf2410>신동우</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_39"><font color=#bf2410>오신환</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_69"><font color=#bf2410>유의동</font></a><br />
      <a href="/bbs/board.php?bo_table=berye21"><font color=#bf2410>이운룡</font></a><br />
      <a href="/bbs/board.php?bo_table=berye23"><font color=#bf2410>이재영</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b24"><font color=#bf2410>최경환</font></a><br /></p>
        
    <p><a href="/bbs/board.php?bo_table=mbe02"><font color=#1689da>김기식(간사)</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a51"><font color=#1689da>강기정</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe03"><font color=#1689da>김기준</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_72"><font color=#1689da>김영환</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe05"><font color=#1689da>김현</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_09"><font color=#1689da>민병두</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a24"><font color=#1689da>박병석</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a09"><font color=#1689da>신학용</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a67"><font color=#1689da>이상직</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_59"><font color=#1689da>이종걸</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_88"><font color=#1689da>이학영</font></a><br /></p>
        
    
  </ul>
   
  </div>
    <div class="list4">
      <h2>기획재정
      </h2>
      <ul>
        <p><a href="/bbs/board.php?bo_table=seoul_b21"><font color=#bf2410>정희수(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_41"><font color=#bf2410>강석훈(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b17"><font color=#bf2410>김광림</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a32"><font color=#bf2410>김태흠</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a98"><font color=#bf2410>나성린</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a78"><font color=#bf2410>류성걸</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a91"><font color=#bf2410>박맹우</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b14"><font color=#bf2410>박명재</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_61"><font color=#bf2410>심재철</font></a><br />
          <a href="/bbs/board.php?bo_table=berye18"><font color=#bf2410>이만우</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a83"><font color=#bf2410>이한구</font></a><br /> 
          <a href="/bbs/board.php?bo_table=seoul_a18"><font color=#bf2410>정문헌</font></a><br />
          <a href="/bbs/board.php?bo_table=berye24"><font color=#bf2410>조명철</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b41"><font color=#bf2410>조현룡</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_80"><font color=#1689da>윤호중(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a69"><font color=#1689da>김관영</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a63"><font color=#1689da>김영록</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_78"><font color=#1689da>김현미</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_52"><font color=#1689da>박광온</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a25"><font color=#1689da>박범계</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_32"><font color=#1689da>박영선</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_13"><font color=#1689da>신계륜</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a40"><font color=#1689da>오제세</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_81"><font color=#1689da>최재성</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe21"><font color=#1689da>홍종학</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=jbe02"><font color=#cf6d17>박원석</font></a></p>
      </ul>
  </div>
    <div class="list5">
      <h2>교육문화체육관광</h2>
      <ul>
<p><a href="/bbs/board.php?bo_table=seoul_a47"><font color=black>박주선(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_b43"><font color=#bf2410>신성범(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=berye01"><font color=#bf2410>강은희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_96"><font color=#bf2410>김학용</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_40"><font color=#bf2410>김회선</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b07"><font color=#bf2410>문대성</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b33"><font color=#bf2410>박대출</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_44"><font color=#bf2410>박인숙</font></a><br />
          <a href="/bbs/board.php?bo_table=berye11"><font color=#bf2410>박창식</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b02"><font color=#bf2410>서용교</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b32"><font color=#bf2410>안홍준</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a20"><font color=#bf2410>염동열</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b11"><font color=#bf2410>유재중</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a86"><font color=#bf2410>윤재옥</font></a><br />
          <a href="/bbs/board.php?bo_table=berye19"><font color=#bf2410>이상일</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_55"><font color=#bf2410>이종훈</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_94"><font color=#bf2410>한선교</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_53"><font color=#1689da>김태년(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe07"><font color=#1689da>도종환</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a48"><font color=#1689da>박혜자</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_11"><font color=#1689da>박홍근</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe08"><font color=#1689da>배재정</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_63"><font color=#1689da>설훈</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_83"><font color=#1689da>안민석</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_38"><font color=#1689da>유기홍</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_77"><font color=#1689da>유은혜</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_17"><font color=#1689da>유인태</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a06"><font color=#1689da>윤관석</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_87"><font color=#1689da>조정식</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=jbe04"><font color=#cf6d17>정진후</font></a></p>
      </ul>
      
     
    </div>
    <div class="list6">
      <h2>미래창조과학<br />
      방송통신</h2>
      <ul>
        <p><a href="/bbs/board.php?bo_table=seoul_58"><font color=#bf2410>홍문종(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_b03"><font color=#bf2410>박민식(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a94"><font color=#bf2410>강길부</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a81"><font color=#bf2410>권은희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a97"><font color=#bf2410>김무성</font></a><br />
          <a href="/bbs/board.php?bo_table=berye06"><font color=#bf2410>류지영</font></a><br />
          <a href="/bbs/board.php?bo_table=berye08"><font color=#bf2410>민병주</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b05"><font color=#bf2410>배덕광</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a82"><font color=#bf2410>서상기</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_45"><font color=#bf2410>유일호</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b39"><font color=#bf2410>조해진</font></a><br /></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_23"><font color=#1689da>우상호(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a07"><font color=#1689da>문병호</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_79"><font color=#1689da>송호창</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_12"><font color=#1689da>유승희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a65"><font color=#1689da>이개호</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a50"><font color=#1689da>장병완</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_36"><font color=#1689da>전병헌</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_02"><font color=#1689da>정호준</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe17"><font color=#1689da>최민희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a10"><font color=#1689da>최원식</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe20"><font color=#1689da>홍의락</font></a></p>
        
       
      </ul>
    </div><div class="list7">
      <h2>외교통일</h2>
      <ul>
        <p><a href="/bbs/board.php?bo_table=seoul_37"><font color=#bf2410>나경원(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_42"><font color=#bf2410>심윤조(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a23"><font color=#bf2410>강창희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b09"><font color=#bf2410>김세연</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_99"><font color=#bf2410>김영우</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b38"><font color=#bf2410>김태호</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b10"><font color=#bf2410>김희정</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a01"><font color=#bf2410>박상은</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_68"><font color=#bf2410>원유철</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a96"><font color=#bf2410>유기준</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a03"><font color=#bf2410>윤상현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_22"><font color=#bf2410>이재오</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b31"><font color=#bf2410>이주영</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a00"><font color=#bf2410>정병국</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_48"><font color=#1689da>심재권(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a56"><font color=#1689da>김성곤</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b46"><font color=#1689da>김재윤</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_06"><font color=#1689da>김한길</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_35"><font color=#1689da>신경민</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_65"><font color=#1689da>원혜영</font></a><br />
          <a href="/bbs/board.php?bo_table=city05"><font color=#1689da>이해찬</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_01"><font color=#1689da>정세균</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_04"><font color=#1689da>최재천</font></a></p>
      
      </ul>
      </div>
<div class="list8">
  <h2>국방</h2>
  <ul>
    <p><a href="/bbs/board.php?bo_table=seoul_24"><font color=#bf2410>정두언(위원장)</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_b30"><font color=#bf2410>김성찬(간사)</font></a><br />
      <a href="/bbs/board.php?bo_table=berye12"><font color=#bf2410>손인춘</font></a><br />
      <a href="/bbs/board.php?bo_table=berye13"><font color=#bf2410>송영근</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a79"><font color=#bf2410>유승민</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_50"><font color=#bf2410>정미경</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a84"><font color=#bf2410>주호영</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a21"><font color=#bf2410>한기호</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_97"><font color=#bf2410>홍철호</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_91"><font color=#bf2410>황진하</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_90"><font color=#1689da>윤후덕(간사)</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a54"><font color=#1689da>권은희</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe01"><font color=#1689da>김광진</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_b12"><font color=#1689da>문재인</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe09"><font color=#1689da>백군기</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_08"><font color=#1689da>안규백</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe15"><font color=#1689da>진성준</font></a></p>
 
  </ul>
  </div><div class="list9">
    <h2>안전행정</h2>
    <ul>
        <p><a href="/bbs/board.php?bo_table=seoul_03"><font color=#bf2410>진영(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_b29"><font color=#bf2410>강기윤(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=berye03"><font color=#bf2410>김장실</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_84"><font color=#bf2410>서청원</font></a><br />
          <a href="/bbs/board.php?bo_table=berye15"><font color=#bf2410>신의진</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b42"><font color=#bf2410>윤영석</font></a><br />
          <a href="/bbs/board.php?bo_table=berye20"><font color=#bf2410>이에리사</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b16"><font color=#bf2410>이철우</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a27"><font color=#bf2410>정용기</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a87"><font color=#bf2410>조원진</font></a><br />
          <a href="/bbs/board.php?bo_table=berye27"><font color=#bf2410>황인자</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_26"><font color=#1689da>정청래(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b44"><font color=#1689da>강창일</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a53"><font color=#1689da>김동철</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_95"><font color=#1689da>김민기</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_25"><font color=#1689da>노웅래</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_57"><font color=#1689da>문희상</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a05"><font color=#1689da>박남춘</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_15"><font color=#1689da>유대운</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe11"><font color=#1689da>임수경</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe14"><font color=#1689da>진선미</font></a></p>
        
        
      </ul>
      </div>
      <div class="list10">
        <h2>보건복지</h2>
        <ul>
          <p><a href="/bbs/board.php?bo_table=seoul_a76"><font color=#1689da>김춘진(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_a33"><font color=#bf2410>이명수(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a14"><font color=#bf2410>김기선</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_73"><font color=#bf2410>김명연</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b26"><font color=#bf2410>김재원</font></a><br />
          <a href="/bbs/board.php?bo_table=berye04"><font color=#bf2410>김정록</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a34"><font color=#bf2410>김제식</font></a><br />
          <a href="/bbs/board.php?bo_table=berye07"><font color=#bf2410>문정림</font></a><br />
          <a href="/bbs/board.php?bo_table=berye10"><font color=#bf2410>박윤옥</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a43"><font color=#bf2410>송광호</font></a><br />
          <a href="/bbs/board.php?bo_table=berye14"><font color=#bf2410>신경림</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a88"><font color=#bf2410>이종진</font></a>
          <a href="/bbs/board.php?bo_table=berye05"><font color=#bf2410>장정은</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_a68"><font color=#1689da>김성주(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe04"><font color=#1689da>김용익</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe06"><font color=#1689da>남인순</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_20"><font color=#1689da>안철수</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a29"><font color=#1689da>양승조</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_33"><font color=#1689da>이목희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_16"><font color=#1689da>인재근</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe16"><font color=#1689da>최동익</font></a></p>
        
        </ul>
</div><div class="list11">
          <h2>산업통상자원 </h2>
  <ul>
            <p><a href="/bbs/board.php?bo_table=seoul_a41"><font color=#1689da>노영민(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_b00"><font color=#bf2410>이진복(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_27"><font color=#bf2410>길정우</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a38"><font color=#bf2410>김동완</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a80"><font color=#bf2410>김상훈</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_43"><font color=#bf2410>김종훈</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b40"><font color=#bf2410>김한표</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b36"><font color=#bf2410>여상규</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a15"><font color=#bf2410>이강후</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a58"><font color=#bf2410>이정현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a90"><font color=#bf2410>이채익</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_89"><font color=#bf2410>이현재</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b20"><font color=#bf2410>장윤석</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_56"><font color=#bf2410>전하진</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b15"><font color=#bf2410>정수성</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a85"><font color=#bf2410>홍지만</font></a>
          <a href="/bbs/board.php?bo_table=seoul_a04"><font color=#bf2410>황우여</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_a08"><font color=#1689da>홍영표(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a30"><font color=#1689da>박완주</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_66"><font color=#1689da>백재현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_74"><font color=#1689da>부좌현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_14"><font color=#1689da>오영식</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_85"><font color=#1689da>이원욱</font></a><br />
    	  <a href="/bbs/board.php?bo_table=mbe13"><font color=#1689da>전순옥</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a71"><font color=#1689da>전정희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b08"><font color=#1689da>조경태</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a57"><font color=#1689da>주승용</font></a><br />
    	  <a href="/bbs/board.php?bo_table=seoul_07"><font color=#1689da>추미애</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_05"><font color=#1689da>홍익표</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=jbe01"><font color=#cf6d17>김제남</font></a></p>
          </ul>
          </div><div class="list12">
            <h2>농림축산식품<br />
        해양수산</h2>
            <ul>
              <p><a href="/bbs/board.php?bo_table=seoul_b45"><font color=#1689da>김우남(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_a92"><font color=#bf2410>안효대(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a46"><font color=#bf2410>경대수</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b22"><font color=#bf2410>김종태</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a12"><font color=#bf2410>안상수</font></a><br />
          <a href="/bbs/board.php?bo_table=berye17"><font color=#bf2410>윤명희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b35"><font color=#bf2410>이군현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a36"><font color=#bf2410>이완구</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a17"><font color=#bf2410>이이재</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a42"><font color=#bf2410>이종배</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a37"><font color=#bf2410>홍문표</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_a75"><font color=#1689da>박민수(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a61"><font color=#1689da>김승남</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe18"><font color=#1689da>신문식</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a59"><font color=#1689da>신정훈</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a72"><font color=#1689da>유성엽</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a74"><font color=#1689da>최규성</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a62"><font color=#1689da>황주홍</font></a></p>
       
       <p><a href="/bbs/board.php?bo_table=seoul_92"><font color=black>유승우</font></a><br /></p>
       
            </ul>
          </div>
<div class="list13">
  <h2>환경노동</h2>
        <ul>
          <p><a href="/bbs/board.php?bo_table=seoul_34"><font color=#1689da>김영주(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_a16"><font color=#bf2410>권성동(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_51"><font color=#bf2410>김용남</font></a><br />
          <a href="/bbs/board.php?bo_table=berye09"><font color=#bf2410>민현주</font></a><br />
          <a href="/bbs/board.php?bo_table=berye16"><font color=#bf2410>양창영</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a35"><font color=#bf2410>이인제</font></a><br />
          <a href="/bbs/board.php?bo_table=berye22"><font color=#bf2410>이자스민</font></a><br />
          <a href="/bbs/board.php?bo_table=berye25"><font color=#bf2410>주영순</font></a><br />
          <a href="/bbs/board.php?bo_table=berye26"><font color=#bf2410>최봉홍</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_31"><font color=#1689da>이인영(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_19"><font color=#1689da>우원식</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe10"><font color=#1689da>은수미</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_60"><font color=#1689da>이석현</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe12"><font color=#1689da>장하나</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe19"><font color=#1689da>한정애</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_75"><font color=#cf6d17>심상정</font></a></p>
        </ul>
</div><div class="list14">
  <h2>국토교통</h2>
  <ul>
              <p><a href="/bbs/board.php?bo_table=seoul_82"><font color=black>박기춘(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_76"><font color=#bf2410>김태원(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b27"><font color=#bf2410>강석호</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_30"><font color=#bf2410>김성태</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a77"><font color=#bf2410>김희국</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a45"><font color=#bf2410>박덕흠</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b28"><font color=#bf2410>박성호</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_54"><font color=#bf2410>신상진</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_18"><font color=#bf2410>이노근</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b25"><font color=#bf2410>이완영</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_93"><font color=#bf2410>이우현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a22"><font color=#bf2410>이장우</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a11"><font color=#bf2410>이학재</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a99"><font color=#bf2410>이헌승</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b06"><font color=#bf2410>하태경</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_86"><font color=#bf2410>함진규</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a19"><font color=#bf2410>황영철</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_70"><font color=#1689da>정성호(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a73"><font color=#1689da>강동원</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_62"><font color=#1689da>김경협</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_64"><font color=#1689da>김상희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a66"><font color=#1689da>김윤덕</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b37"><font color=#1689da>민홍철</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a31"><font color=#1689da>박수현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a44"><font color=#1689da>변재일</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_29"><font color=#1689da>신기남</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_21"><font color=#1689da>이미경</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_67"><font color=#1689da>이언주</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a64"><font color=#1689da>이윤석</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_49"><font color=#1689da>이찬열</font></a></p>
          
       <p><a href="/bbs/board.php?bo_table=seoul_a49"><font color=black>천정배</font></a></p>
        
            </ul>
          </div><div class="list15">
            <h2>정보</h2>
            <ul>
                <p><a href="/bbs/board.php?bo_table=seoul_a84"><font color=#bf2410>주호영(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_b16"><font color=#bf2410>이철우(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a94"><font color=#bf2410>강길부</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a16"><font color=#bf2410>권성동</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b03"><font color=#bf2410>박민식</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_68"><font color=#bf2410>원유철</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_35"><font color=#1689da>신경민(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe01"><font color=#1689da>김광진</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a07"><font color=#1689da>문병호</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_57"><font color=#1689da>문희상</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a55"><font color=#1689da>박지원</font></a>
          <a href="/bbs/board.php?bo_table=seoul_59"><font color=#1689da>이종걸</font></a><br /></p>
        
   
            </ul>
              </div><div class="list16">
                <h2>여성가족</h2>
                <ul>
                  <p><a href="/bbs/board.php?bo_table=seoul_12"><font color=#1689da>유승희(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=berye06"><font color=#bf2410>류지영(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=berye01"><font color=#bf2410>강은희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_73"><font color=#bf2410>김명연</font></a><br />
          <a href="/bbs/board.php?bo_table=berye10"><font color=#bf2410>박윤옥</font></a><br />
          <a href="/bbs/board.php?bo_table=berye17"><font color=#bf2410>윤명희</font></a><br />
          <a href="/bbs/board.php?bo_table=berye22"><font color=#bf2410>이자스민</font></a><br />
          <a href="/bbs/board.php?bo_table=berye05"><font color=#bf2410>장정은</font></a><br />
          <a href="/bbs/board.php?bo_table=berye27"><font color=#bf2410>황인자</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=mbe06"><font color=#1689da>남인순(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a48"><font color=#1689da>박혜자</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_31"><font color=#1689da>이인영</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe11"><font color=#1689da>임수경</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe14"><font color=#1689da>진선미</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_05"><font color=#1689da>홍익표</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=jbe01"><font color=#cf6d17>김제남</font></a></p>
                </ul>
              </div><div class="list17">
                  <h2>예산결산특별</h2>
                  <ul>
                    <p><a href="/bbs/board.php?bo_table=seoul_b34"><font color=#bf2410>김재경(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_30"><font color=#bf2410>김성태(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a38"><font color=#bf2410>김동완</font></a><br />
          <a href="/bbs/board.php?bo_table=berye02"><font color=#bf2410>김상민</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_51"><font color=#bf2410>김용남</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a34"><font color=#bf2410>김제식</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b40"><font color=#bf2410>김한표</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a98"><font color=#bf2410>나성린</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a91"><font color=#bf2410>박맹우</font></a><br />
		  <a href="/bbs/board.php?bo_table=seoul_b14"><font color=#bf2410>박명재</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a01"><font color=#bf2410>박상은</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a82"><font color=#bf2410>서상기</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_54"><font color=#bf2410>신상진</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a12"><font color=#bf2410>안상수</font></a><br />
          <a href="/bbs/board.php?bo_table=berye16"><font color=#bf2410>양창영</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_39"><font color=#bf2410>오신환</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a86"><font color=#bf2410>윤재옥</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_18"><font color=#bf2410>이노근</font></a><br />
          <a href="/bbs/board.php?bo_table=berye20"><font color=#bf2410>이에리사</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_93"><font color=#bf2410>이우현</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a58"><font color=#bf2410>이정현</font></a><br />
		  <a href="/bbs/board.php?bo_table=seoul_a42"><font color=#bf2410>이종배</font></a><br />
		  <a href="/bbs/board.php?bo_table=seoul_b16"><font color=#bf2410>이철우</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_50"><font color=#bf2410>정미경</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a27"><font color=#bf2410>정용기</font></a><br />
		  <a href="/bbs/board.php?bo_table=seoul_a21"><font color=#bf2410>한기호</font></a></p>
        
	   <p><a href="/bbs/board.php?bo_table=seoul_83"><font color=#1689da>안민석(간사)</font></a><br />
 		  <a href="/bbs/board.php?bo_table=seoul_b44"><font color=#1689da>강창일</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a54"><font color=#1689da>권은희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a69"><font color=#1689da>김관영</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_64"><font color=#1689da>김상희</font></a><br />
		  <a href="/bbs/board.php?bo_table=seoul_a63"><font color=#1689da>김영록</font></a><br />
  		  <a href="/bbs/board.php?bo_table=seoul_b37"><font color=#1689da>민홍철</font></a><br />
		  <a href="/bbs/board.php?bo_table=seoul_a25"><font color=#1689da>박범계</font></a><br />
 		  <a href="/bbs/board.php?bo_table=seoul_a48"><font color=#1689da>박혜자</font></a><br />
 		  <a href="/bbs/board.php?bo_table=mbe08"><font color=#1689da>배재정</font></a><br />
		  <a href="/bbs/board.php?bo_table=seoul_a44"><font color=#1689da>변재일</font></a><br />
 		  <a href="/bbs/board.php?bo_table=seoul_74"><font color=#1689da>부좌현</font></a><br />
  		  <a href="/bbs/board.php?bo_table=seoul_48"><font color=#1689da>심재권</font></a><br />
 		  <a href="/bbs/board.php?bo_table=seoul_a72"><font color=#1689da>유성엽</font></a><br />
  		  <a href="/bbs/board.php?bo_table=seoul_a65"><font color=#1689da>이개호</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a67"><font color=#1689da>이상직</font></a><br />
 		  <a href="/bbs/board.php?bo_table=seoul_31"><font color=#1689da>이인영</font></a><br />
  		  <a href="/bbs/board.php?bo_table=seoul_70"><font color=#1689da>정성호</font></a><br />
  		  <a href="/bbs/board.php?bo_table=seoul_a57"><font color=#1689da>주승용</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a10"><font color=#1689da>최원식</font></a><br />
		  <a href="/bbs/board.php?bo_table=seoul_a10"><font color=#1689da>홍의락</font></a><br />
 		  <a href="/bbs/board.php?bo_table=seoul_05"><font color=#1689da>홍익표</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=jbe03"><font color=#cf6d17>서기호</font></a><br /></p>
                 </ul> </div>
<div class="list18">
  <h2>윤리특별</h2>
  <ul>
  <p><a href="/bbs/board.php?bo_table=seoul_b15"><font color=#bf2410>정수성(위원장)</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_a02"><font color=#bf2410>홍일표(간사)</font></a><br />
      <a href="/bbs/board.php?bo_table=berye07"><font color=#bf2410>문정림</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_44"><font color=#bf2410>박인숙</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a20"><font color=#bf2410>염동열</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a83"><font color=#bf2410>이한구</font></a><br />
      <a href="/bbs/board.php?bo_table=berye24"><font color=#bf2410>조명철</font></a><br />
      <a href="/bbs/board.php?bo_table=berye27"><font color=#bf2410>황인자</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_64"><font color=#1689da>최동익(간사)</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_64"><font color=#1689da>김상희</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a06"><font color=#1689da>윤관석</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe10"><font color=#1689da>은수미</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_70"><font color=#1689da>정성호</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_87"><font color=#1689da>조정식</font></a><br /></p>
        
    <p><a href="/bbs/board.php?bo_table=jbe03"><font color=#cf6d17>서기호</font></a></p>
  
  </ul></div>
<div class="subject2">
    <h1>특별위원회</h1>
  </div>
  <div class="blank2"></div>
<div class="list19">
  <h2>정치개혁</h2>
  <ul>
         <p><a href="/bbs/board.php?bo_table=seoul_b13"><font color=#bf2410>이병석(위원장)</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_a11"><font color=#bf2410>이학재(간사)</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a46"><font color=#bf2410>경대수</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a14"><font color=#bf2410>김기선</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_73"><font color=#bf2410>김명연</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a80"><font color=#bf2410>김상훈</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_40"><font color=#bf2410>김회선</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a93"><font color=#bf2410>박대동</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b03"><font color=#bf2410>박민식</font></a>
      <a href="/bbs/board.php?bo_table=seoul_b36"><font color=#bf2410>여상규</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_53"><font color=#1689da>김태년(간사)</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe02"><font color=#1689da>김기식</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_64"><font color=#1689da>김상희</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a66"><font color=#1689da>김윤덕</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a25"><font color=#1689da>박범계</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_32"><font color=#1689da>박영선</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_66"><font color=#1689da>백재현</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a59"><font color=#1689da>신정훈</font></a>
       <a href="/bbs/board.php?bo_table=seoul_17"><font color=#1689da>유인태</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=jbe04"><font color=#cf6d17>정진후</font></a></p>
       </ul>
</div>

<div class="list24">
  
  <h2>서민주거복지</h2>
              <ul>
                <p><a href="/bbs/board.php?bo_table=seoul_21"><font color=#1689da>이미경(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_30"><font color=#bf2410>김성태(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_41"><font color=#bf2410>강석훈</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b04"><font color=#bf2410>김도읍</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a77"><font color=#bf2410>김희국</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a98"><font color=#bf2410>나성린</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a45"><font color=#bf2410>박덕흠</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b03"><font color=#bf2410>박민식</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_18"><font color=#bf2410>이노근</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_b06"><font color=#bf2410>하태경</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_80"><font color=#1689da>윤호중(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_62"><font color=#1689da>김경협</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_64"><font color=#1689da>김상희</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_78"><font color=#1689da>김현미</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_67"><font color=#1689da>이언주</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_71"><font color=#1689da>전해철</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe21"><font color=#1689da>홍종학</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=jbe03"><font color=#cf6d17>서기호</font></a></p>
        

  </ul>
</div>  
          
          <div class="list21">
          
          <h2>동북아<br />
        역사왜곡대책</h2>
  <ul>
                 
    <p><a href="/bbs/board.php?bo_table=seoul_b31"><font color=#bf2410>이주영(위원장)</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_b09"><font color=#bf2410>김세연(간사)</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a34"><font color=#bf2410>김제식</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b14"><font color=#bf2410>박명재</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a33"><font color=#bf2410>이명수</font></a><br />
      <a href="/bbs/board.php?bo_table=berye19"><font color=#bf2410>이상일</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_a18"><font color=#bf2410>정문헌</font></a><br />
      <a href="/bbs/board.php?bo_table=berye26"><font color=#bf2410>최봉홍</font></a><br />
      <a href="/bbs/board.php?bo_table=seoul_b06"><font color=#bf2410>하태경</font></a></p>
        
    <p><a href="/bbs/board.php?bo_table=seoul_a52"><font color=#1689da>임내현(간사)</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_b44"><font color=#1689da>강창일</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe07"><font color=#1689da>도종환</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_52"><font color=#1689da>박광온</font></a><br />
       <a href="/bbs/board.php?bo_table=mbe08"><font color=#1689da>배재정</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_38"><font color=#1689da>유기홍</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_a67"><font color=#1689da>이상직</font></a><br />
       <a href="/bbs/board.php?bo_table=seoul_85"><font color=#1689da>이원욱</font></a></p>
            
            
    <p><a href="/bbs/board.php?bo_table=seoul_92"><font color=black>유승우</font></a></p>  
            </ul>
              </div>     
              
              <div class="list20">
            <h2>공적연금 강화와<br /> 노후빈곤 해소</h2>
            <ul>
              <p><a href="/bbs/board.php?bo_table=seoul_a51"><font color=#1689da>강기정(위원장)</font></a></p>
        
        <p><a href="/bbs/board.php?bo_table=seoul_41"><font color=#bf2410>강석훈(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a14"><font color=#bf2410>김기선</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_51"><font color=#bf2410>김용남</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a78"><font color=#bf2410>류성걸</font></a><br />
          <a href="/bbs/board.php?bo_table=berye10"><font color=#bf2410>박윤옥</font></a><br />
          <a href="/bbs/board.php?bo_table=berye26"><font color=#bf2410>최봉홍</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a86"><font color=#bf2410>함진규</font></a></p>
        
       <p><a href="/bbs/board.php?bo_table=seoul_a68"><font color=#1689da>김성주(간사)</font></a><br />
          <a href="/bbs/board.php?bo_table=seoul_a50"><font color=#1689da>장병완</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe16"><font color=#1689da>최동익</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe19"><font color=#1689da>한정애</font></a><br />
          <a href="/bbs/board.php?bo_table=mbe21"><font color=#1689da>홍종학</font></a><br /></p>
        
        <p><a href="/bbs/board.php?bo_table=jbe02"><font color=#cf6d17>박원석</font></a></p>
  </ul>
          </div>      

  </div>
업데이트 2015.10.24
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