<?
include_once("./_common.php");

if($mode=='ww'){
	
	$board_path = "$g4[data_path]/file/nsTitle";

	// 게시판 디렉토리 생성
	@mkdir($board_path, 0707);
	@chmod($board_path, 0707);
	
	// 디렉토리에 있는 파일의 목록을 보이지 않게 한다.
	$file = $board_path . "/index.php";
	$f = @fopen($file, "w");
	@fwrite($f, "");
	@fclose($f);
	@chmod($file, 0606);
	
	$img_path='';
	if ($ns1_img_del) {
		@unlink("$board_path/$ns1_img_path");
		$img_path .= " , ns1_img = '' ";
	}else if($_FILES[ns1_img][name]) {
		$ns1_img_name = "ns1_img";
		$ns1_img_path = "$board_path/$ns1_img_name";
		move_uploaded_file($_FILES[ns1_img][tmp_name], $ns1_img_path);
		chmod($ns1_img_path, 0606);
		$img_path .= " , ns1_img = '$ns1_img_name' ";
	}
	if ($ns2_img_del) {
		@unlink("$board_path/$ns2_img_path");
		$img_path .= " , ns2_img = '' ";
	}else if($_FILES[ns2_img][name]) {
		$ns2_img_name = "ns2_img";
		$ns2_img_path = "$board_path/$ns2_img_name";
		move_uploaded_file($_FILES[ns2_img][tmp_name], $ns2_img_path);
		chmod($ns2_img_path, 0606);
		$img_path .= " , ns2_img = '$ns2_img_name' ";
	}
	if ($ns3_img_del) {
		@unlink("$board_path/$ns3_img_path");
		$img_path .= " , ns3_img = '' ";
	}else if($_FILES[ns3_img][name]) {
		$ns3_img_name = "ns3_img";
		$ns3_img_path = "$board_path/$ns3_img_name";
		move_uploaded_file($_FILES[ns3_img][tmp_name], $ns3_img_path);
		chmod($ns3_img_path, 0606);
		$img_path .= " , ns3_img = '$ns3_img_name' ";
	}
	if ($ns4_img_del) {
		@unlink("$board_path/$ns4_img_path");
		$img_path .= " , ns4_img = '' ";
	}else if($_FILES[ns4_img][name]) {
		$ns4_img_name = "ns4_img";
		$ns4_img_path = "$board_path/$ns4_img_name";
		move_uploaded_file($_FILES[ns4_img][tmp_name], $ns4_img_path);
		chmod($ns4_img_path, 0606);
		$img_path .= " , ns4_img = '$ns4_img_name' ";
	}
	if ($ns5_img_del) {
		@unlink("$board_path/$ns5_img_path");
		$img_path .= " , ns5_img = '' ";
	}else if($_FILES[ns5_img][name]) {
		$ns5_img_name = "ns5_img";
		$ns5_img_path = "$board_path/$ns5_img_name";
		move_uploaded_file($_FILES[ns5_img][tmp_name], $ns5_img_path);
		chmod($ns5_img_path, 0606);
		$img_path .= " , ns5_img = '$ns5_img_name' ";
	}
	if ($ns6_img_del) {
		@unlink("$board_path/$ns6_img_path");
		$img_path .= " , ns6_img = '' ";
	}else if($_FILES[ns6_img][name]) {
		$ns6_img_name = "ns6_img";
		$ns6_img_path = "$board_path/$ns6_img_name";
		move_uploaded_file($_FILES[ns6_img][tmp_name], $ns6_img_path);
		chmod($ns6_img_path, 0606);
		$img_path .= " , ns6_img = '$ns6_img_name' ";
	}
	if ($ns7_img_del) {
		@unlink("$board_path/$ns7_img_path");
		$img_path .= " , ns7_img = '' ";
	}else if($_FILES[ns7_img][name]) {
		$ns7_img_name = "ns7_img";
		$ns7_img_path = "$board_path/$ns7_img_name";
		move_uploaded_file($_FILES[ns7_img][tmp_name], $ns7_img_path);
		chmod($ns7_img_path, 0606);
		$img_path .= " , ns7_img = '$ns7_img_name' ";
	}
    if ($ns8_img_del) {
        @unlink("$board_path/$ns8_img_path");
        $img_path .= " , ns8_img = '' ";
    }else if($_FILES[ns8_img][name]) {
        $ns8_img_name = "ns8_img";
        $ns8_img_path = "$board_path/$ns8_img_name";
        move_uploaded_file($_FILES[ns8_img][tmp_name], $ns8_img_path);
        chmod($ns8_img_path, 0606);
        $img_path .= " , ns8_img = '$ns8_img_name' ";
    }
    if ($ns9_img_del) {
        @unlink("$board_path/$ns9_img_path");
        $img_path .= " , ns9_img = '' ";
    }else if($_FILES[ns9_img][name]) {
        $ns9_img_name = "ns9_img";
        $ns9_img_path = "$board_path/$ns9_img_name";
        move_uploaded_file($_FILES[ns9_img][tmp_name], $ns9_img_path);
        chmod($ns9_img_path, 0606);
        $img_path .= " , ns9_img = '$ns9_img_name' ";
    }
    if ($ns10_img_del) {
        @unlink("$board_path/$ns10_img_path");
        $img_path .= " , ns10_img = '' ";
    }else if($_FILES[ns10_img][name]) {
        $ns10_img_name = "ns10_img";
        $ns10_img_path = "$board_path/$ns10_img_name";
        move_uploaded_file($_FILES[ns10_img][tmp_name], $ns10_img_path);
        chmod($ns10_img_path, 0606);
        $img_path .= " , ns10_img = '$ns10_img_name' ";
    }
	
	if ($_FILES[ns1_img][name]) {
		$ns1_img_urlencode = bo_table."_head_".time();
		$sql_common .= " , bo_image_head = '$bo_image_head_urlencode' ";
	}
	
	if ($_FILES[ns1_img][name]) { 
		$ns1_img_path = "$board_path/$bo_image_head_urlencode";
		move_uploaded_file($_FILES[bo_image_head][tmp_name], $bo_image_head_path);
		chmod($bo_image_head_path, 0606);
	}
	
	$sql="update news_config
			set ns1_title = '$ns1_title',
				ns1_link = '$ns1_link',
				ns1_rss = '$ns1_rss',
				ns1_num = '$ns1_num',
				ns2_title = '$ns2_title',
				ns2_link = '$ns2_link', 
				ns2_rss = '$ns2_rss',
				ns2_num = '$ns2_num',
				ns3_title = '$ns3_title',
				ns3_link = '$ns3_link', 
				ns3_rss = '$ns3_rss',
				ns3_num = '$ns3_num',
				ns4_title = '$ns4_title',
				ns4_link = '$ns4_link', 
				ns4_rss = '$ns4_rss',
				ns4_num = '$ns4_num',
				ns5_title = '$ns5_title',
				ns5_link = '$ns5_link', 
				ns5_rss = '$ns5_rss',
				ns5_num = '$ns5_num',
				ns6_title = '$ns6_title',
				ns6_link = '$ns6_link', 
				ns6_rss = '$ns6_rss',
				ns6_num = '$ns6_num',
				ns7_title = '$ns7_title',
				ns7_link = '$ns7_link', 
				ns7_rss = '$ns7_rss',
				ns7_num = '$ns7_num',
                ns8_title = '$ns8_title',
                ns8_link = '$ns8_link',
                ns8_rss = '$ns8_rss',
                ns8_num = '$ns8_num',
                ns9_title = '$ns9_title',
                ns9_link = '$ns9_link',
                ns9_rss = '$ns9_rss',
                ns9_num = '$ns9_num',
                ns10_title = '$ns10_title',
                ns10_link = '$ns10_link',
                ns10_rss = '$ns10_rss',
                ns10_num = '$ns10_num',
				twt1_id = '$twt1_id', 
				twt2_id = '$twt2_id',
                load_time1 = '$load_time1',
                load_time2 = '$load_time2',
                load_time3 = '$load_time3',
                load_time4 = '$load_time4'
				$img_path";
	$rst=mysql_query($sql);
	
	if($rst){
		echo "<script>alert('정상적으로 수정되었습니다.');</script>";
		echo "<script>location.href='news.php';</script>";
	}else{
		
		echo "<script>alert('수정에 실패했습니다.');</script>";
		echo "<script>location.href='news.php';</script>";
	}
	
}else{
	
	$sql=mysql_query("select * from news_config");
	$nsConfig=mysql_fetch_array($sql);

auth_check($auth[$sub_menu], "r");

$token = get_token();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");


$g4['title'] = "뉴스환경설정";
include_once ("./admin.head.php");
?>

<form name='fconfigform' method='post' onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type=hidden name=mode value='ww'>
<input type=hidden name=token value='<?=$token?>'>
<input type=hidden name=cf_region_change_term_last value='<?=$config[cf_region_change_term_last]?>'>
<style>
.ht input {
	width:300px;	
}
</style>
<table width=100% cellpadding=0 cellspacing=0 border=0>
<colgroup width=12% class='col1 pad1 bold right'>
<colgroup class='col2 pad2'>
<colgroup class='col1 pad1 bold right'>
<colgroup class='col2 pad2'>
<tr class='ht'>
    <td colspan=4 align=left><?=subtitle("뉴스 설정")?></td>
</tr>
<tr><td colspan=4 class=line1></td></tr>
<tr class='ht'>
  <td colspan="4"></td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스1 제목</td>
    <td colspan="3">
    	<input type=text class=ed name='ns1_title' value='<?=$nsConfig[ns1_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스1 링크</td>
    <td colspan="3">
    	<input type=text class=ed name='ns1_link' value='<?=$nsConfig[ns1_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스1 RSS 주소</td>
    <td colspan=3>
    	<input type=text class=ed name='ns1_rss' size='30' value='<?=$nsConfig[ns1_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스1 출력갯수</td>
    <td colspan=3>
    	<input type=text class=ed name='ns1_num' size='30' value='<?=$nsConfig[ns1_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스1 타이틀 이미지</td>
    <td colspan=3>
    	<input type=file class=ed name='ns1_img' size='30' value='<?=$nsConfig[ns1_img]?>'> <? if($nsConfig[ns1_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns1_img]'>$nsConfig[ns1_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns1_img_del' value='1' <? if($nsConfig[ns1_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns1_img_path' size='30' value='<?=$nsConfig[ns1_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스2 제목</td>
    <td colspan="3">
    	<input type=text class=ed name='ns2_title' size='30' value='<?=$nsConfig[ns2_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스2 링크</td>
    <td colspan="3">
    	<input type=text class=ed name='ns2_link' value='<?=$nsConfig[ns2_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스2 RSS 주소</td>
    <td colspan=3>
    	<input type=text class=ed name='ns2_rss' size='30' value='<?=$nsConfig[ns2_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스2 출력갯수</td>
    <td colspan=3>
    	<input type=text class=ed name='ns2_num' size='30' value='<?=$nsConfig[ns2_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스2 타이틀 이미지</td>
    <td colspan=3>
    	<input type=file class=ed name='ns2_img' size='30' value='<?=$nsConfig[ns2_img]?>'> <? if($nsConfig[ns2_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns2_img]'>$nsConfig[ns2_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns2_img_del' value='1' <? if($nsConfig[ns2_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns2_img_path' size='30' value='<?=$nsConfig[ns2_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스3 제목</td>
    <td colspan="3">
    	<input type=text class=ed name='ns3_title' size='30' value='<?=$nsConfig[ns3_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스3 링크</td>
    <td colspan="3">
    	<input type=text class=ed name='ns3_link' value='<?=$nsConfig[ns3_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스3 RSS 주소</td>
    <td colspan=3>
    	<input type=text class=ed name='ns3_rss' size='30' value='<?=$nsConfig[ns3_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스3 출력갯수</td>
    <td colspan=3>
    	<input type=text class=ed name='ns3_num' size='30' value='<?=$nsConfig[ns3_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스3 타이틀 이미지</td>
    <td colspan=3>
    	<input type=file class=ed name='ns3_img' size='30' value='<?=$nsConfig[ns3_img]?>'> <? if($nsConfig[ns3_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns3_img]'>$nsConfig[ns3_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns3_img_del' value='1' <? if($nsConfig[ns3_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns3_img_path' size='30' value='<?=$nsConfig[ns3_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스4 제목</td>
    <td colspan="3">
    	<input type=text class=ed name='ns4_title' size='30' value='<?=$nsConfig[ns4_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스4 링크</td>
    <td colspan="3">
    	<input type=text class=ed name='ns4_link' value='<?=$nsConfig[ns4_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스4 RSS 주소</td>
    <td colspan=3>
    	<input type=text class=ed name='ns4_rss' size='30' value='<?=$nsConfig[ns4_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스4 출력갯수</td>
    <td colspan=3>
    	<input type=text class=ed name='ns4_num' size='30' value='<?=$nsConfig[ns4_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스4 타이틀 이미지</td>
    <td colspan=3>
    	<input type=file class=ed name='ns4_img' size='30' value='<?=$nsConfig[ns4_img]?>'> <? if($nsConfig[ns4_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns4_img]'>$nsConfig[ns4_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns4_img_del' value='1' <? if($nsConfig[ns4_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns4_img_path' size='30' value='<?=$nsConfig[ns4_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스5 제목</td>
    <td colspan="3">
    	<input type=text class=ed name='ns5_title' size='30' value='<?=$nsConfig[ns5_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스5 링크</td>
    <td colspan="3">
    	<input type=text class=ed name='ns5_link' value='<?=$nsConfig[ns5_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스5 RSS 주소</td>
    <td colspan=3>
    	<input type=text class=ed name='ns5_rss' size='30' value='<?=$nsConfig[ns5_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스5 출력갯수</td>
    <td colspan=3>
    	<input type=text class=ed name='ns5_num' size='30' value='<?=$nsConfig[ns5_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스5 타이틀 이미지</td>
    <td colspan=3>
    	<input type=file class=ed name='ns5_img' size='30' value='<?=$nsConfig[ns5_img]?>'> <? if($nsConfig[ns5_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns5_img]'>$nsConfig[ns5_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns5_img_del' value='1' <? if($nsConfig[ns5_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns5_img_path' size='30' value='<?=$nsConfig[ns5_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스6 제목</td>
    <td colspan="3">
    	<input type=text class=ed name='ns6_title' size='30' value='<?=$nsConfig[ns6_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스6 링크</td>
    <td colspan="3">
    	<input type=text class=ed name='ns6_link' value='<?=$nsConfig[ns6_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스6 RSS 주소</td>
    <td colspan=3>
    	<input type=text class=ed name='ns6_rss' size='30' value='<?=$nsConfig[ns6_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스6 출력갯수</td>
    <td colspan=3>
    	<input type=text class=ed name='ns6_num' size='30' value='<?=$nsConfig[ns6_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스6 타이틀 이미지</td>
    <td colspan=3>
    	<input type=file class=ed name='ns6_img' size='30' value='<?=$nsConfig[ns6_img]?>'> <? if($nsConfig[ns6_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns6_img]'>$nsConfig[ns6_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns6_img_del' value='1' <? if($nsConfig[ns6_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns6_img_path' size='30' value='<?=$nsConfig[ns6_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스7 제목</td>
    <td colspan="3">
    	<input type=text class=ed name='ns7_title' size='30' value='<?=$nsConfig[ns7_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스7 링크</td>
    <td colspan="3">
    	<input type=text class=ed name='ns7_link' value='<?=$nsConfig[ns7_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스7 RSS 주소</td>
    <td colspan=3>
    	<input type=text class=ed name='ns7_rss' size='30' value='<?=$nsConfig[ns7_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스7 출력갯수</td>
    <td colspan=3>
    	<input type=text class=ed name='ns7_num' size='30' value='<?=$nsConfig[ns7_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스7 타이틀 이미지</td>
    <td colspan=3>
    	<input type=file class=ed name='ns7_img' size='30' value='<?=$nsConfig[ns7_img]?>'> <? if($nsConfig[ns7_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns7_img]'>$nsConfig[ns7_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns7_img_del' value='1' <? if($nsConfig[ns7_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns7_img_path' size='30' value='<?=$nsConfig[ns7_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스8 제목</td>
    <td colspan="3">
    	<input type=text class=ed name='ns8_title' size='30' value='<?=$nsConfig[ns8_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스8 링크</td>
    <td colspan="3">
    	<input type=text class=ed name='ns8_link' value='<?=$nsConfig[ns8_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스8 RSS 주소</td>
    <td colspan=3>
    	<input type=text class=ed name='ns8_rss' size='30' value='<?=$nsConfig[ns8_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스8 출력갯수</td>
    <td colspan=3>
    	<input type=text class=ed name='ns8_num' size='30' value='<?=$nsConfig[ns8_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스8 타이틀 이미지</td>
    <td colspan=3>
    	<input type=file class=ed name='ns8_img' size='30' value='<?=$nsConfig[ns8_img]?>'> <? if($nsConfig[ns8_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns8_img]'>$nsConfig[ns8_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns8_img_del' value='1' <? if($nsConfig[ns8_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns8_img_path' size='30' value='<?=$nsConfig[ns8_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스9 제목</td>
    <td colspan="3">
        <input type=text class=ed name='ns9_title' size='30' value='<?=$nsConfig[ns9_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">뉴스9 링크</td>
    <td colspan="3">
        <input type=text class=ed name='ns9_link' value='<?=$nsConfig[ns9_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스9 RSS 주소</td>
    <td colspan=3>
        <input type=text class=ed name='ns9_rss' size='30' value='<?=$nsConfig[ns9_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스9 출력갯수</td>
    <td colspan=3>
        <input type=text class=ed name='ns9_num' size='30' value='<?=$nsConfig[ns9_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스9 타이틀 이미지</td>
    <td colspan=3>
        <input type=file class=ed name='ns9_img' size='30' value='<?=$nsConfig[ns9_img]?>'> <? if($nsConfig[ns9_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns9_img]'>$nsConfig[ns9_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns9_img_del' value='1' <? if($nsConfig[ns9_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns9_img_path' size='30' value='<?=$nsConfig[ns9_img]?>'>
    </td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
    <td>뉴스10 제목</td>
    <td colspan="3">
        <input type=text class=ed name='ns10_title' size='30' value='<?=$nsConfig[ns10_title]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">10 링크</td>
    <td colspan="3">
        <input type=text class=ed name='ns10_link' value='<?=$nsConfig[ns10_link]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스10 RSS 주소</td>
    <td colspan=3>
        <input type=text class=ed name='ns10_rss' size='30' value='<?=$nsConfig[ns10_rss]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스10 출력갯수</td>
    <td colspan=3>
        <input type=text class=ed name='ns10_num' size='30' value='<?=$nsConfig[ns10_num]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스10 타이틀 이미지</td>
    <td colspan=3>
        <input type=file class=ed name='ns10_img' size='30' value='<?=$nsConfig[ns10_img]?>'> <? if($nsConfig[ns10_img]){ echo "<a href='/data/file/nsTitle/$nsConfig[ns10_img]'>$nsConfig[ns10_img]</a>"; } ?> <input type=checkbox style='width:auto;' name='ns10_img_del' value='1' <? if($nsConfig[ns10_img_del]==1){ echo 'checked=checked'; } ?>> 삭제
        <input type=hidden class=ed name='ns10_img_path' size='30' value='<?=$nsConfig[ns10_img]?>'>
    </td>
</tr>

<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr><td colspan=4 class=line1></td></tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>

<tr class='ht'>
    <td>트위터 좌측 아이디</td>
    <td colspan=3>
    	<input type=text class=ed name='twt1_id' size='30' value='<?=$nsConfig[twt1_id]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>트위터 우측 아이디</td>
    <td colspan=3>
    	<input type=text class=ed name='twt2_id' size='30' value='<?=$nsConfig[twt2_id]?>'>
    </td>
</tr>


<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr><td colspan=4 class=line1></td></tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>


<tr class='ht'>
    <td>뉴스로딩시간 A</td>
    <td colspan=3>
        <input type=text class=ed name='load_time1' size='30' value='<?=$nsConfig[load_time1]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스로딩시간 B</td>
    <td colspan=3>
        <input type=text class=ed name='load_time2' size='30' value='<?=$nsConfig[load_time2]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>뉴스 크로닝시간</td>
    <td colspan=3>
        <input type=text class=ed name='load_time3' size='30' value='<?=$nsConfig[load_time3]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>PHP 최대 실행시간</td>
    <td colspan=3>
        <input type=text class=ed name='load_time4' size='30' value='<?=$nsConfig[load_time4]?>'>
    </td>
</tr>


<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<? for ($i=1; $i<=10; $i=$i+2) { $k=$i+1; ?>
<? } ?>
<tr><td colspan=4 class=line2></td></tr>
<tr><td colspan=4 class=ht></td></tr>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>
</form>

<script type="text/javascript">
function fconfigform_submit(f)
{
    f.action = "./news.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php"); }
?>