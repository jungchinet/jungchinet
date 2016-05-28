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
	background-color: #d2e9f2;
	height: 150px;
	width: 1100px;
	padding-top: 0px;
	border-radius:10px;
}
#main_picture {
	background-color: #d2e9f2;
	height: 659px;
	width: 1100px;
	padding-top: 10px;
	padding-bottom: 60px;
	border-radius:10px;
	
	
}
.boardlink {
	float: left;
	height: 60px;
	width: 1100px;
	
	text-align: center;
}
#wrap .boardlink p {
	font-family: Arial, Helvetica, sans-serif;
}
#wrap .boardlink p a {
	color: #000;
	text-decoration: none;
	font-size: 30px;
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
$url="https://news.google.co.kr/news?hl=ko&ned=kr&ie=UTF-8&q=%EC%9E%AC%EC%99%B8%EA%B5%AD%EC%9D%B8&output=rss";
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
		$news_cate='ab';

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

<div id="main_picture"><img src="/menuhtml/ab/ab.gif" width="1100" height="659" usemap="#Map" border="0" />
    <map name="Map" id="Map">
      <area shape="poly" coords="725,96,775,86,809,90,798,107,769,129,773,136,780,138,784,152,774,169,784,185,798,184,891,182,905,186,924,192,926,213,975,199,979,194,984,192,987,203,975,218,943,247,913,292,906,292,881,277,845,288,837,285,832,270,822,270,814,261,802,262,779,258,764,248,760,229,765,211,770,189,763,170,767,150,748,138,707,155,692,129,704,118,706,106" href="/bbs/board.php?bo_table=ab_01" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="미국" />
      <area shape="poly" coords="456,167,478,174,487,172,500,178,523,175,531,177,531,163,551,161,587,184,602,183,605,199,605,228,619,246,606,253,610,295,604,316,585,315,560,330,550,328,549,316,539,306,515,310,505,300,509,287,488,274,458,281,415,262,412,242,394,236,387,224,406,217,405,202,427,175,449,174" href="/bbs/board.php?bo_table=ab_02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="동북아시아" />
      <area shape="poly" coords="639,192,662,201,658,217,671,225,704,224,705,247,665,250,631,269,619,256,629,242,647,229,638,212" href="/bbs/board.php?bo_table=ab_03" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="일본" />
      <area shape="poly" coords="4,99,32,100,72,133,129,90,172,79,176,89,176,101,184,120,192,127,183,135,182,144,201,158,212,170,231,176,229,187,220,199,200,207,195,218,179,227,191,244,179,251,138,237,98,222,73,239,51,239,42,230,45,208,59,185,41,166,1,109" href="/bbs/board.php?bo_table=ab_04" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="유럽" />
      <area shape="poly" coords="496,284,503,290,501,300,514,314,537,309,544,318,540,330,570,357,583,342,587,326,600,325,623,353,659,355,665,380,723,385,724,412,689,428,678,459,633,462,601,475,529,458,480,395,490,347,481,325" href="/bbs/board.php?bo_table=ab_07" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="동남아시아" />
      <area shape="poly" coords="773,261,799,266,811,265,818,274,827,274,837,291,845,293,880,305,896,295,913,296,970,315,981,353,1097,425,1098,461,1015,654,972,657,883,452,803,326,772,287" href="/bbs/board.php?bo_table=ab_08" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="중남미" />
      <area shape="poly" coords="817,91,983,79,1052,152,1052,195,994,206,989,186,974,192,932,207,932,194,924,181,911,181,795,178,783,171,788,152,786,135,777,132,788,119,802,112" href="/bbs/board.php?bo_table=ab_06" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="캐나다" />
      <area shape="poly" coords="557,519,541,581,552,593,615,573,640,605,680,611,723,652,772,616,704,486,727,469,740,435,691,430,683,460,675,473,647,469,608,483" href="/bbs/board.php?bo_table=ab_05" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="오세아니아" />
      <area shape="poly" coords="187,229,210,217,252,219,276,229,290,238,313,235,332,250,336,270,342,284,345,296,333,324,319,341,272,359,227,283,221,266,223,249,198,247" href="/bbs/board.php?bo_table=ab_09" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="중동" />
      <area shape="poly" coords="345,280,348,297,367,301,379,319,419,386,437,395,447,389,436,368,455,328,477,319,492,284,486,277,462,285,418,267,410,263,410,251,392,241,382,243,377,263,363,277" href="/bbs/board.php?bo_table=ab_10" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="서남아시아" />
      <area shape="poly" coords="181,86,190,119,196,131,187,136,216,166,237,173,237,181,231,190,231,199,261,219,281,224,269,194,263,174,282,165,305,168,308,154,335,146,413,171,462,162,499,171,524,170,526,154,549,157,589,180,601,179,607,183,609,207,619,207,633,192,629,175,601,152,580,147,581,135,620,134,631,145,662,176,673,168,671,151,659,133,672,131,685,119,698,113,700,102,636,82,455,65,378,51,275,53" href="/bbs/board.php?bo_table=ab_12" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="러시아" />
      <area shape="poly" coords="269,175,281,169,309,171,312,158,334,149,412,178,400,199,399,215,382,225,386,238,377,242,371,262,358,273,343,274,337,250,318,232,304,231,284,203,274,197,268,181" href="/bbs/board.php?bo_table=ab_13" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="중앙아시아" />
      <area shape="poly" coords="3,351,37,394,110,404,129,465,125,503,154,592,281,543,300,493,280,411,300,369,294,358,266,364,254,342,213,263,100,230,76,243,55,243,6,306" href="/bbs/board.php?bo_table=ab_11" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="아프리카" />
    </map></div>


  
  <!--<div class="boardlink">
    <p><a href="ab_boardlist.php" target="_top">게시판 전체</a></p>
  </div>--!>
</div>

<!--중간 광고부분-->
<div style='clear:both;margin:10px 0 10px 10px'>
<?
{
	$bGroup='uBanner4';
}
?>
</div>
<!--중간 광고부분 꿑-->

<?
include_once("../../tail9.php");
?>