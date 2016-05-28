<?
$sub_menu = "300930";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();


//$sql_common = " from g4_member a LEFT OUTER JOIN mileage_withdraw b ON a.mb_id = b.mb_id";
$sql_common = " from prem_info";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "mb_id" :
            $sql_search .= " ({$sfl} = '$stx') ";
            break;
        default : 
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "no";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(distinct(mb_id)) as cnt
         $sql_common 
         $sql_search 
         $sql_order ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = 20;//$config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page == "") $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select distinct(mb_id)
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$listall = "<a href='$_SERVER[PHP_SELF]'>처음</a>";

if ($sfl == "mb_id" && $stx)
    $mb = get_member($stx);

$g4[title] = "서비스 이용 회원";
include_once ("./admin.head.php");

$colspan = 5;
?>

<script type="text/javascript">
var list_update_php = "";
var list_delete_php = "point_list_delete.php";

function open_info(num){
	if(document.getElementById('pinfo_'+num).value!=1){
		document.getElementById('pinfo_'+num).style.display='block';
		document.getElementById('pinfo_'+num).value=1;
	}else{
		document.getElementById('pinfo_'+num).style.display='none';
		document.getElementById('pinfo_'+num).value=0;
	}
}

function pinfo(id, brd, uid){
		window.open("pinfo.php?id="+id+"&brd="+brd+"&uid="+uid, "PaymentInfo", "scrollbars=yes,toolbars=no,resizable=no,status=no,menubar=no,width=600,height=600");
}

function pmodify(id, brd, uid){
		window.open("../prem_adm_ok2.php?ord_id="+id+"&bo_table="+brd+"&wr_id="+uid, "PaymentModify", "scrollbars=yes,toolbars=no,resizable=no,status=no,menubar=no,width=400,height=130");
}

</script>
<div id='prt'>
<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=50% align=left>
        <?=$listall?> (건수 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='mb_id'>회원아이디</option>
        </select>
        <input type=text name=stx class=ed itemname='검색어' value='<?=$stx?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
</tr>
</form>
</table>

<form name=fpointlist method=post>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>

<table width=100% cellpadding=0 cellspacing=1>
<colgroup width=30>
<colgroup width=160>
<colgroup width=80>
<colgroup width=160>
<colgroup width=''>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td>회원이름 (아이디)</td>
    <td>이용현황</td>
    <td>만료일</td>
    <td>세부내역보기</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>

<?
for ($i=0; $row=sql_fetch_array($result); $i++) 
{

//해당 회원의 이름
$mn_sql="select mb_name from g4_member where mb_id='$row[mb_id]'";
$mn_rst=sql_fetch($mn_sql);

//이용현황파악
$state='기간만료';
$ssql="select count(*) from prem_info where mb_id='$row[mb_id]' and now() between prem_date and exp_date order by no desc";
$srst=mysql_query($ssql);
$sdata=mysql_fetch_row($srst);
if($sdata>0){
	$state='이용중';	
}

//가장 가까운 만료일...
$esql="select min(exp_date) exp_date from prem_info where mb_id='$row[mb_id]'";
$erst=sql_fetch($esql);

$prem_detail="
<table width=100%>
    <colgroup width=100>
    <colgroup width=70>
    <colgroup width=200>
    <colgroup width=90>
    <colgroup width=90>
    <colgroup width=90>
    <colgroup width=>
    <tr>
        <th height=30 style='font-size:10pt;'>적용보드명</th>
        <th style='font-size:10pt;'>글번호</th>
        <th style='font-size:10pt;'>글제목</th>
        <th style='font-size:10pt;'>신청일</th>
        <th style='font-size:10pt;'>만료일</td>
        <th style='font-size:10pt;'>글삭제일</th>
        <th style='font-size:10pt;'>결제정보</th>
    </tr>
	<tr>
		<td colspan='7'><hr></td>
	</tr>
";

$dsql="select * from prem_info where mb_id='$row[mb_id]' order by no desc";
$drstt=mysql_query($dsql);

$cnt=0;

while($drst=mysql_fetch_array($drstt)){;

	//게시판제목
	$bsdata[0]='';
	$bssql="select bo_subject from g4_board where bo_table='$drst[prem_board]'";
	$bsrst=mysql_query($bssql);
	$bsdata=mysql_fetch_row($bsrst);
	if($bsdata[0]){
		$bsdata[0].=' ';
	}
	
	if($drst[del_date]=='0000-00-00 00:00:00'){
		
		//글제목
		$ssql="select wr_subject from g4_write_".$drst[prem_board]." where wr_id='".$drst[prem_wr_id]."'";
		$srst=mysql_query($ssql);
		$sdata=mysql_fetch_row($srst);
		
		$sl_board="<td align='center' style='border-right:solid 2px #12415f;'><a href='{$g4[path]}/bbs/board.php?bo_table=$drst[prem_board]&wr_id=$drst[prem_wr_id]#board' target='_blank'>{$bsdata[0]}($drst[prem_board])</a></td>";
        $sl_wrid="<td align='center' style='border-right:solid 2px #12415f;'><a href='{$g4[path]}/bbs/board.php?bo_table=$drst[prem_board]&wr_id=$drst[prem_wr_id]#board' target='_blank'>$drst[prem_wr_id]</a></td>";
		$sl_subj="<td align='center' style='border-right:solid 2px #12415f;'><a href='{$g4[path]}/bbs/board.php?bo_table=$drst[prem_board]&wr_id=$drst[prem_wr_id]#board' target='_blank'>$sdata[0]</a></td>";
			
	}else{
		
		$sl_board="<td align='center' style='border-right:solid 2px #12415f;'><a href='{$g4[path]}/bbs/board.php?bo_table=$drst[prem_board]' target='_blank'>{$bsdata[0]}($drst[prem_board])</a></td>";
        $sl_wrid="<td align='center' style='border-right:solid 2px #12415f;'>$drst[prem_wr_id]</td>";
		$sl_subj="<td align='center' style='border-right:solid 2px #12415f;'>게시물이 삭제되었습니다.</td>";
		
	}

    $prem_detail.="
    
        <tr>
        	$sl_board
            $sl_wrid
			$sl_subj
            <td align='center' style='border-right:solid 2px #12415f;'>$drst[prem_date]</td>
            <td align='center' style='border-right:solid 2px #12415f;'>$drst[exp_date]</td>
            <td align='center' style='border-right:solid 2px #12415f;'>$drst[del_date]</td>
            <td align='center'>
				<input type='button' class='bill_btn' value='내역' onclick=\"pinfo('$drst[mb_id]', '$drst[prem_board]', '$drst[prem_wr_id]');\">
				<input type='button' class='bill_btn' value='변경' onclick=\"pmodify('$drst[mb_id]', '$drst[prem_board]', '$drst[prem_wr_id]');\">
			</td>
        </tr>

    ";
	
	$cnt++;
}


$prem_detail.="
<tr>
	<td colspan='7' align='right'>
    <hr>
    총 이용건수 : {$cnt}
    <hr>
    <div align='left'>$m_chkd_cmt</div>
    </td>
</tr>
</table>
";




//////////////////////////////////////////////////////////////////////////////////

    $list = $i%2;
    echo "
        <tr class='list$list col1 ht center'>
            <td><input type=checkbox name=chk[] value='$i'></td>
            <td><strong>$mn_rst[mb_name]</strong> ($row[mb_id])</td>
            <td>$state</td>
            <td>{$erst[exp_date]}</td>
            <td align=center><input type='button' class='wd_btn' value='세부정보' onclick='open_info($i)';></td>
        </tr>
		<tr><td colspan='6'>
        <div id='pinfo_$i' style='display:none;padding:10px;border:solid 3px #22628a;'>
        	$prem_detail
        </div>
        </td></tr>
    ";
	
	$amt='';
} 

if ($i == 0)
    echo "</td></tr><tr><td colspan='$colspan' align=center height=100 bgcolor=#ffffff>자료가 없습니다.</td></tr>";

echo "</td></tr><tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";
echo "</div>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");
echo "<table width=100% cellpadding=3 cellspacing=1>";
echo "<tr><td width=50%>";
echo "&nbsp;<input type=button class='btn1' value='페이지인쇄' onclick=\"pagePrint(document.getElementById('prt'))\">";
echo "</td>";
echo "<td width=50% align=right>$pagelist</td></tr></table>\n";

if ($stx)
    echo "<script type='text/javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";

if (strstr($sfl, "mb_id"))
    $mb_id = $stx;
else
    $mb_id = "";
?>
</form>

<script type="text/javascript">
function pagePrint(Obj) { 
    var W = Obj.offsetWidth;        //screen.availWidth; 
    var H = Obj.offsetHeight;       //screen.availHeight;

    var features = "menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,width=" + W + ",height=" + H + ",left=0,top=0"; 
    var PrintPage = window.open("about:blank",Obj.id,features); 

    PrintPage.document.open(); 
    PrintPage.document.write("<html><head><title>페이지인쇄</title><style type='text/css'>body, tr, td, input, textarea { font-family:Tahoma; font-size:9pt; }</style>\n<link rel='stylesheet' href='./admin.style.css' type='text/css'>\n</head>\n<body>" + Obj.innerHTML + "\n</body></html>"); 
    PrintPage.document.close(); 

    PrintPage.document.title = document.domain; 
    PrintPage.print(PrintPage.location.reload()); 
}
</script>

<style>
.wd_btn {width:95%;border:solid 2px #c6def0;background-color:#2b618a;color:#fff;}
.bill_btn {width:45%;border:solid 2px #666;background-color:#CCC;color:#fff;}
</style>

<?
include_once ("./admin.tail.php");
?>