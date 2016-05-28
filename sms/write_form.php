<?
include_once("./_common.php");

$page_size = 6;
$colspan = 2;

$g4[title] = "이모티콘";

if (!$page) $page = 1;

if (is_numeric($fg_no)) 
    $sql_group = " and fg_no='$fg_no' ";
else
    $sql_group = "";

/*
if ($st == 'all') {
    $sql_search = "and (fo_name like '%{$sv}%' or fo_content like '%{$sv}%')";
} else if ($st == 'name') {
    $sql_search = "and fo_name like '%{$sv}%'";
} else if ($st == 'content') {
    $sql_search = "and fo_content like '%{$sv}%'";
} else {
    $sql_search = '';
}
*/

$total_res = sql_fetch("select count(*) as cnt from $g4[sms4_form_table] where fg_member = 1 $sql_group $sql_search");
$total_count = $total_res[cnt];

$total_page = (int)($total_count/$page_size) + ($total_count%$page_size==0 ? 0 : 1);
$page_start = $page_size * ( $page - 1 );

$paging = get_paging(10, $page, $total_page, "write_form.php?fg_no=$fg_no&page="); 

$vnum = $total_count - (($page-1) * $page_size);

$group = array();
$qry = sql_query("select * from $g4[sms4_form_group_table] where fg_member = 1 order by fg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

$res = sql_fetch("select count(*) as cnt from $g4[sms4_form_table] where fg_no=0");
$no_count = $res[cnt];

include_once("$g4[path]/head.sub.php");
?>


<script language=javascript>
window.onload = function () 
{
    try { 
        parent.document.all.form_list.height = document.body.scrollHeight; 
    }
    catch(e) {} 
}

function go(fo_no)
{
    var wr_message = parent.document.getElementById('mh_message');
    wr_message.value = document.getElementById('fo_contents_' + fo_no).value;
    parent.byte_check('mh_message', 'sms_bytes');
}
</script>

<table border=0 width=100% cellpadding=0 cellspacing=0 height=30>
<tr>
    <td>
        <form style="margin:0; padding:0;">
        <select name="fg_no" onchange="location.href='<?=$PHP_SELF?>?fg_no='+this.value;">
        <option value="" <?=$fg_no?'':'selected'?>> 전체 </option>
        <? for($i=0; $i<count($group); $i++) {?>
        <option value="<?=$group[$i][fg_no]?>" <?=($fg_no==$group[$i][fg_no])?'selected':''?>> <?=$group[$i][fg_name]?> (<?=number_format($group[$i][fg_count])?>) </option>
        <? } ?>
        </select>
        </form>
    </td>
</tr>
</table>

<table cellpadding=0 cellspacing=0 width=100% border=0>
<tr>
    <td colspan=<?=$colspan?>>


<table border=0 cellpadding=0 cellspacing=0>
<tr>
<? if (!$total_count) { ?>
    <td align=center width height=100 style="color:#999;"> 

        <div style="width:500px;">
        데이터가 없습니다. 
        </div>

    </td>
<?
}
$count = 1;
$qry = sql_query("select * from $g4[sms4_form_table] where fg_member = 1 $sql_group $sql_search order by fo_no desc limit $page_start, $page_size");
while($res = sql_fetch_array($qry)) 
{
    $tmp = sql_fetch("select fg_name from $g4[sms4_form_group_table] where fg_no='$res[fg_no]'");
    if (!$tmp)
        $group_name = '미분류';
    else
        $group_name = $tmp[fg_name];
?>
    <td width=140 height=140>
        <table border=0 cellpadding=0 cellspacing=5 bgcolor="#F8F8F8" style="border:1px solid #ccc;">
        <tr>
            <td background="img/smsbg.gif" width=120 height=120 align=center>
                <textarea style="font-family:굴림체; color:#000; line-height:15px; margin-top:10px; overflow:hidden; width:100px; height:88px; font-size: 9pt; background-color:#88C8F8; text-align:left; word-break:break-all; border:0; padding:0; cursor:pointer" readonly onclick="go(<?=$res[fo_no]?>)"><?=$res[fo_content]?></textarea>
            </td>
        </tr>
        </table>
        <textarea id=fo_contents_<?=$res[fo_no]?> style="display:none; width:0; height:0"><?=$res[fo_content]?></textarea>
    </td>

<?
    if ($count++ % 3 == 0) echo "</tr><tr>";
}
?>

</tr>
</table>

    </td>
</tr>
<!--
<tr><td height=1 colspan=<?=$colspan?> bgcolor=#CCCCCC></td></tr>
-->
</table>

<p align=center style="margin:20px;">
<?=$paging?>
</p>

<!--
<div style="float:right;">
<form name=search_form method=get action=<?=$PHP_SELF?> style="margin:0; padding:0;">
<input type=hidden name=fg_no value=<?=$fg_no?>>
<select name=st>
<option value=all <?=$st=='all'?'selected':''?>>제목 + 이모티콘</option>
<option value=name <?=$st=='name'?'selected':''?>>제목</option>
<option value=content <?=$st=='content'?'selected':''?>>이모티콘</option>
</select>
<input type=text size=20 name=sv value="<?=$sv?>">
<input type=submit value='검  색' class=btn1>
</form>
</div>
-->
</div>

<?
include_once("$g4[path]/tail.sub.php");
?>
