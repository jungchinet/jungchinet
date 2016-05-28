<?
include_once("./_common.php");

if($mode=='ww'){
	
	$kwd1=$_POST['kwd1'];
    $kwd2=$_POST['kwd2'];
    $date=date('Y-m-d');
    $sql="select count(*) from g4_popular_sum where pp_word='$kwd1' and pp_date='$date'";
    $rst=mysql_query($sql);
    $num=mysql_fetch_row($rst);

    if($num[0]>0){

        $mtd=1;
        $sql="update g4_popular_sum set pp_count='$kwd2' where pp_date='$date' and pp_word='$kwd1'";

    }else{

        $mtd=2;
        $sql="insert into g4_popular_sum set pp_word='$kwd1', pp_date='$date', pp_count='$kwd2', pp_level='0', bo_table='admin', mb_info='0'";

    }
	
	$rst=mysql_query($sql);
	
	if($rst){

        if($mtd==1){
            $mtd='수정';
        }else{
            $mtd='입력';
        }

		echo "<script>alert('정상적으로 ".$mtd."되었습니다.');</script>";
		echo "<script>location.href='keyword.php';</script>";
	}else{
		
		echo "<script>alert('".$mtd."에 실패했습니다.');</script>";
		echo "<script>location.href='keyword.php';</script>";
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

$date=date('Y-m-d');
$sql="select * from g4_popular_sum where pp_date='$date' order by pp_count desc";
$rst=mysql_query($sql);

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
    <td colspan=4 align=left><?=subtitle("키워드 설정")?></td>
</tr>
<tr><td colspan=4 class=line1></td></tr>
<tr class='ht'>
  <td colspan="4"></td>
</tr>
<tr class='ht'>
    <td width="14%">추가할 키워드</td>
    <td colspan="3">
    	<input type=text class=ed name='kwd1'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">키워드 검색 수</td>
    <td colspan="3">
        <input type=text class=ed name='kwd2'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">금일 키워드 현황</td>
    <td colspan="3" style='padding:10px;'>
        <style>
            li {
                height:15px;
            }
        </style>
        <ul>
        <?
            $r=mysql_num_rows($rst);
            $z=1;
            while($r=mysql_fetch_array($rst)){

                echo '<li>'.$r['pp_word'].' ('.$r['pp_count'].')</li>';
                if($z<$r) echo '<br>';
                $z++;

            }

        ?>
        </ul>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">설명</td>
    <td colspan="3">
        키워드명은 추가하거나 수정할 키워드명을 입력하고, 검색 수는 원하는 숫자를 입력하면 됩니다.<br>
        금일 키워드 현황을 보고 적절히 카운트를 조절하면 됩니다.
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
    f.action = "./keyword.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php"); }
?>