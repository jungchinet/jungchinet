<?
include_once("./_common.php");

$g4[title] = $member[mb_nick] . "님의 프로모션";
//include_once("$g4[path]/head.sub.php");
include_once("$g4[path]/head.php");

$po_id = (int) $po_id;
$po_url = strip_tags($po_url);
$mb_id = $member[mb_id];

// 공통사항
$sql_order = " order by po_no desc ";

if ($po_id == 0) {

    // 나의 프로모션 코드
    $sql = " select * from $g4[promotion_sign_table] where mb_id = '$mb_id' $sql_order ";
    $result = sql_query($sql);

    echo "나의 프로모션";
    echo "<ul>";
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    {
        $po = sql_fetch(" select * from $g4[promotion_table] where po_id = '$row[po_id]' ");
        echo "<li><a href='$g4[bbs_path]/promotion.php?po_id=$row[po_id]'>$po[po_name]</a>";
        $po_url = "$g4[url]/$g4[bbs]/promotion.php?po_id=$row[po_id]&po_url=$row[po_url]";
        echo "<br><a href='$po_url' target=new>$po_url</a>";
        echo "<br>$row[po_password]";
    }
    echo "</ul>";

    // 프로모션 코드가 없으면, 모든 프로모션을 보여 줍니다.
    $sql = " select * from $g4[promotion_table] order by po_id desc ";
    $result = sql_query($sql);

    echo "전체 프로모션";
    echo "<ul>";
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    {
        echo "<li><a href='$g4[bbs_path]/promotion.php?po_id=$row[po_id]'>$row[po_name]</a>";
    }
    echo "</ul>";

} else if ($po_id > 0 && $po_url == "") {

    if (!$member[mb_id]) 
        alert("회원만 조회하실 수 있습니다.", "./login.php?&url=".urlencode("promotion.php?po_id=$bo_$po_id"));

    // 지정된 프로모션만 보여 줍니다.
    $sql = " select * from $g4[promotion_table] where po_id = '$po_id' ";
    $po = sql_fetch($sql);

    echo "<ul>";
    echo "<li>프로모션 : " . $po[po_name];
    echo "</ul>";
    
    ?>
    
<form name=fpointlist2 method=post onsubmit="return fpointlist2_submit(this);" autocomplete="off">
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>

<input type=hidden name=mb_id value='<?=$member[mb_id]?>'>
<input type=hidden name=w value='add'>
<input type=hidden name=po_id value='<?=$po[po_id]?>'>

<table width=100% cellpadding=0 cellspacing=1 class=tablebg>
<colgroup width=''>
<colgroup width=100>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td>참여사항</td>
    <td>입력</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<tr class='ht center'>
    <td><input type=text class=ed name=po_content required itemname='내용' style='width:99%;'></td>
    <td><input type=submit class=btn1 value='  확  인  '></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
</table>
</form>

    <?
    // 참여중인 프로모션 회원들
    $sql = " select * from $g4[promotion_sign_table] where po_id = '$po_id' $sql_order ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    {
    }
} else if ($po_id > 0 && $po_url !== "") {
    // 프로모션 코드 체크
    ?>
<form name=fpointlist2 method=post onsubmit="return fpointlist2_submit(this);" autocomplete="off">
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>

<input type=hidden name=mb_id value='<?=$member[mb_id]?>'>
<input type=hidden name=w value='check'>
<input type=hidden name=po_url value='<?=$po_url?>'>


<table width=100% cellpadding=0 cellspacing=1 class=tablebg>
<colgroup width=300>
<colgroup width=100>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td>체크 패스워드</td>
    <td>입력</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<tr class='ht center'>
    <td><input type=text class=ed name=po_password required itemname='내용' style='width:99%;'></td>
    <td><input type=submit class=btn1 value='  확  인  '></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
</table>
</form>

    <?
}
?>

<script type="text/javascript">
function fpointlist2_submit(f)
{
    f.action = "./promotion_update.php";
    return true;
}
</script>

<?
//$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";
//include_once("$member_skin_path/promotion_sign.skin.php");

include_once("$g4[path]/tail.php");
//include_once("$g4[path]/tail.sub.php");
?>
