<?
include_once("../_common.php");
$g4['title'] = "";
include_once("../_head3.php");

include_once("$g4[path]/lib/popup.lib.php");        // 팝업

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

//조선일보
$url=$nsConfig[ns1_rss];
$ns[1] = simplexml_load_file_curl($url);

//중앙일보
$url=$nsConfig[ns3_rss];
$ns[3] = simplexml_load_file_curl($url);

//동아
$url=$nsConfig[ns5_rss];
$ns[5] = simplexml_load_file_curl($url);

//뉴데일리
$url=$nsConfig[ns7_rss];
$ns[7] = simplexml_load_file_curl($url);

//한겨레
$url=$nsConfig[ns2_rss];
$ns[2] = simplexml_load_file_curl($url);

//경향
$url=$nsConfig[ns4_rss];
$ns[4] = simplexml_load_file_curl($url);

//데일리안
$url=$nsConfig[ns6_rss];
$ns[6] = simplexml_load_file_curl($url);

//오마이뉴스
$url=$nsConfig[ns8_rss];
$ns[8] = simplexml_load_file_curl($url);

//미래한국
$url=$nsConfig[ns9_rss];
$ns[9] = simplexml_load_file_curl($url);

//시사인
$url=$nsConfig[ns10_rss];
$ns[10] = simplexml_load_file_curl($url);

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
$prevBtn="<img src='prev.jpg'>";
$nextBtn="<img src='next.jpg'>";

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
	width:100%;
	text-align:center;
	margin-top:30px;
}
#bn_side1 {
	float:left;
	width:130px;
}
#bn_side1 img {
	width:130px;	
}
#bn_side2 {
	float:right;
	margin-left:20px;
	width:130px;
}
#bn_side2 img {
	width:130px;	
}
#bn_side3 {
	clear:both;	
	margin-top:300px;
}
#cont1 {
	width:660px;
	float:left;
	margin-left:20px;
	text-align:center;
}
#ns1 {
	width:310px;
	float:left;
	padding:10px
}
#ns2 {
	width:310px;
	float:right;
	padding:10px	
}
#ns3 {
	width:310px;
	float:left;
	padding:10px	
}
#ns4 {
	width:310px;
	float:right;
	padding:10px	
}
#ns5 {
	width:310px;
	float:left;
	padding:10px	
}
#ns6 {
	width:310px;
	float:right;
	padding:10px	
}
#ns7 {
	width:310px;
	float:left;
	padding:10px	
}
#ns8 {
	width:310px;
	float:right;
	padding:10px	
}
#ns9 {
	width:310px;
	float:left;
	padding:10px	
}
#ns10 {
	width:310px;
	float:right;
	padding:10px	
}
#twt1 {
	clear:left;
	float:left;
	width:45%;
	margin-top:30px;
	overflow:hidden;
}
#twt2 {
	float:left;
	width:45%;
	margin-top:30px;
	margin-left:30px;
	overflow:hidden;
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

<div id='nsWrap'>
    <div id='bn_side1'>
    <? echo get_banner('ns1', 'basic', '', 1, 0); ?>
    <br /><br />
    <div style='height:825px;'></div>
    <? echo get_banner('ns2', 'basic', '', 1, 0); ?>
    <br /><br />
    </div>
    
    <div id='cont1'>
        
    <div>
        <div id='ns1' class='nsBox'>
        <? if($nsConfig[ns1_link]){ ?>
        <a href='<?=$nsConfig[ns1_link]?>' target='<?=$tg?>'  onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns1_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns1_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />
        <? if($nsConfig[ns1_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns01';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns1_num];$z++){

				$news_sql.="('".addslashes($ns[1]->channel[0]->item[$z]->title)."', '".addslashes($ns[1]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns1_1' class='lh'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns1_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ngr['subj'], 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns1_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns1_now' value='1'>";
		echo $nsCont;
		?><div style='z-index:100;'>
        <center style='margin-top:10px;'><a href='javascript:prevP(1)'><?=$prevBtn?></a> <a href='javascript:nextP(1)'><?=$nextBtn?></a></center></div>
        </div>
        
        <div id='ns2' class='nsBox'>
        <? if($nsConfig[ns2_link]){ ?>
        <a href='<?=$nsConfig[ns2_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns2_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns2_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />
        <? if($nsConfig[ns2_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns02';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns2_num];$z++){

				$news_sql.="('".addslashes($ns[2]->channel[0]->item[$z]->title)."', '".addslashes($ns[2]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns2_1'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns2_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ngr['subj'], 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns2_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns2_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(2)'><?=$prevBtn?></a> <a href='javascript:nextP(2)'><?=$nextBtn?></a></center>
        </div>
        
    	<div id='ns3' class='nsBox'>
        <? if($nsConfig[ns3_link]){ ?>
        <a href='<?=$nsConfig[ns3_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns3_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns3_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />
        <? if($nsConfig[ns3_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns03';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns3_num];$z++){

				$news_sql.="('".addslashes($ns[3]->channel[0]->item[$z]->title)."', '".addslashes($ns[3]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns3_1'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns3_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ngr['subj'], 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns3_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns3_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(3)'><?=$prevBtn?></a> <a href='javascript:nextP(3)'><?=$nextBtn?></a></center>
        </div>
    
    	<div id='ns4' class='nsBox'>
        <? if($nsConfig[ns4_link]){ ?>
        <a href='<?=$nsConfig[ns4_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns4_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns4_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />
        <? if($nsConfig[ns4_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns04';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns4_num];$z++){

				$news_sql.="('".addslashes($ns[4]->channel[0]->item[$z]->title)."', '".addslashes($ns[4]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns4_1'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns4_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ngr['subj'], 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns4_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns4_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(4)'><?=$prevBtn?></a> <a href='javascript:nextP(4)'><?=$nextBtn?></a></center>
        </div>
        
    	<div id='ns5' class='nsBox'>        
        <? if($nsConfig[ns5_link]){ ?>
        <a href='<?=$nsConfig[ns5_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns5_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns5_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />
        <? if($nsConfig[ns5_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns05';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns5_num];$z++){

				$news_sql.="('".addslashes($ns[5]->channel[0]->item[$z]->title)."', '".addslashes($ns[5]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns5_1'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns5_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ngr['subj'], 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns5_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns5_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(5)'><?=$prevBtn?></a> <a href='javascript:nextP(5)'><?=$nextBtn?></a></center>
        </div>
        
    	<div id='ns6' class='nsBox'>
        
        <? if($nsConfig[ns6_link]){ ?>
        <a href='<?=$nsConfig[ns6_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns6_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns6_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />        
        <? if($nsConfig[ns6_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns06';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns6_num];$z++){

				$news_sql.="('".addslashes($ns[6]->channel[0]->item[$z]->title)."', '".addslashes($ns[6]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns6_1'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns6_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$ctn=str_replace("<br>", " ", $ngr['subj']);
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ctn, 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns6_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns6_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(6)'><?=$prevBtn?></a> <a href='javascript:nextP(6)'><?=$nextBtn?></a></center>
        </div>
        
        <div id='ns7' class='nsBox'>
        <? if($nsConfig[ns7_link]){ ?>
        <a href='<?=$nsConfig[ns7_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns7_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns7_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />       
        <? if($nsConfig[ns7_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns07';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

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
        
        <div id='ns8' class='nsBox'>
        <? if($nsConfig[ns8_link]){ ?>
        <a href='<?=$nsConfig[ns8_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns8_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns8_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />
        <? if($nsConfig[ns8_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns08';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns8_num];$z++){

				$news_sql.="('".addslashes($ns[8]->channel[0]->item[$z]->title)."', '".addslashes($ns[8]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns8_1'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns8_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$ctn=str_replace("<br>", " ", $ngr['subj']);
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ctn, 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns8_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns8_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(8)'><?=$prevBtn?></a> <a href='javascript:nextP(8)'><?=$nextBtn?></a></center>
        </div>
    	
    	<div id='ns9' class='nsBox'>
        <? if($nsConfig[ns9_link]){ ?>
        <a href='<?=$nsConfig[ns9_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns9_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns9_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />       
        <? if($nsConfig[ns9_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns09';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns9_num];$z++){

				$news_sql.="('".addslashes($ns[9]->channel[0]->item[$z]->title)."', '".addslashes($ns[9]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns9_1'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns9_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ngr['subj'], 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns9_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns9_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(9)'><?=$prevBtn?></a> <a href='javascript:nextP(9)'><?=$nextBtn?></a></center>
        </div>
        
        <div id='ns10' class='nsBox'>
        <? if($nsConfig[ns10_link]){ ?>
        <a href='<?=$nsConfig[ns10_link]?>' target='<?=$tg?>' onfocus='this.blur()'>
        <? } ?>
        	<center><img src='<? if($nsConfig[ns10_img]){ echo '/data/file/nsTitle/'.$nsConfig[ns10_img]; }else{ echo '/data/file/nsTitle/noimg.jpg'; } ?>' height='40' class='nsImg' /></center><br />
        <? if($nsConfig[ns10_link]){ ?>
        </a>
        <? } ?>
        <?

        //추가추가
		$news_cate='ns10';

		//업데이트 시간 체크
		$updsql="select last_update from news_rss_config where cate='$news_cate'";
		$updrst=mysql_query($updsql);
		$updrst=mysql_fetch_row($updrst);

		$gap=strtotime(date('Y-m-d H:i:s'))-strtotime($updrst[0]);

		//최근 업데이트된 시간이 10분 이상되어야 다시 읽어
		if($gap>$nsConfig['load_time1']){

			//가져오기 전에 모든 게시물 삭제
			mysql_query("delete from news_rss where cate='$news_cate'");

			$news_sql="insert into news_rss (subj, link, cate, reg_date) values ";
	        for($z=0;$z<$nsConfig[ns10_num];$z++){

				$news_sql.="('".addslashes($ns[10]->channel[0]->item[$z]->title)."', '".addslashes($ns[10]->channel[0]->item[$z]->link)."', '$news_cate', now()),";
				
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
		$nsCont="<div id='ns10_1'>";
		$cnt=2;
        for($z=0;$z<$ngnum;$z++){

			$ngr=mysql_fetch_array($ngrst);
			if($z%5==0 and $z!=0){
					$nsCont.="</div><div id='ns10_$cnt' style='display:none;'>";
					$nsCont.='';
					$cnt++;
			}
			$ctn=str_replace("<br>", " ", $ngr['subj']);
			$nsCont.="<div class='titWrp'><a href='".$ngr['link']."' target='$tg' onfocus='this.blur()'>
				<strong>".cutStr($ctn, 90, '..')."</strong>
			</a></div>";
			if($z==($parseNum-1)){}else{ $nsCont.='<br>'; }
			
		}
		$nsCont.="</div>";
		$nsCont.="<input type='hidden' id='ns10_num' value='".($cnt-1)."'>";
		$nsCont.="<input type='hidden' id='ns10_now' value='1'>";
		echo $nsCont;
		?>
        <center style='margin-top:10px;'><a href='javascript:prevP(10)'><?=$prevBtn?></a> <a href='javascript:nextP(10)'><?=$nextBtn?></a></center>
        </div>
    	
        
    </div>
    
        <div id='snsCont' style='width:100%;'>
            <div id='twt1' class="ixr-widget" style='margin-left:-0px;'>
            	<a class="twitter-timeline" href="https://twitter.com/jungchinet/lists/%EC%A0%95%EC%B9%98%EB%84%B7-%EB%B3%B4%EC%88%98" data-widget-id="458256652517376001" data-chrome="noscrollbar">https://twitter.com/jungchinet/lists/%EC%A0%95%EC%B9%98%EB%84%B7-%EB%B3%B4%EC%88%98 트윗</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
            <div id='twt2' class="ixr-widget" style='margin-right:0px;'>
            	<a class="twitter-timeline" href="https://twitter.com/jungchinet2/lists/%EC%A0%95%EC%B9%98%EB%84%B7-%EC%A7%84%EB%B3%B4" data-widget-id="458235863680299008" data-chrome="noscrollbar">https://twitter.com/jungchinet2/lists/%EC%A0%95%EC%B9%98%EB%84%B7-%EC%A7%84%EB%B3%B4 트윗</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
        </div>
    
    </div>
    
    
    <div id='bn_side2'>
    <? echo get_banner('ns3', 'basic', '', 1, 0); ?>
    <br /><br />
    <div style='height:830px;'></div>
    <? echo get_banner('ns4', 'basic', '', 1, 0); ?>
    <br /><br />
    </div>
    
    
    
    <div id='bn_side3'>
    <br /><br />
    <? echo get_banner('ns5', 'basic', '', 1, 0); ?>
    </div>
</div>





<?

mysql_query("delete from news_rss where subj=''");

include_once("../../tail9.php");
?>