<?
$sub_menu = "900400";
include_once("./_common.php");

$page_size = 20;
$colspan = 11;

auth_check($auth[$sub_menu], "r");

$g4[title] = "문자전송 내역 (번호별)";

if (!$page) $page = 1;

if ($st && trim($sv))
    $sql_search = " and $st like '%$sv%' ";
else
    $sql_search = "";

$total_res = sql_fetch("select count(*) as cnt from $g4[sms4_history_table] where 1 $sql_search");
$total_count = $total_res[cnt];

$total_page = (int)($total_count/$page_size) + ($total_count%$page_size==0 ? 0 : 1);
$page_start = $page_size * ( $page - 1 );

$paging = get_paging(10, $page, $total_page, "history_num.php?st=$st&sv=$sv&page="); 

$vnum = $total_count - (($page-1) * $page_size);

include_once("$g4[admin_path]/admin.head.php");
?>

<?=subtitle($g4[title])?>

<table border=0 cellpadding=0 cellspacing=0 width=100%>
<colgroup width=50>
<!--<colgroup width=30>-->
<colgroup width=80>
<colgroup width=80>
<colgroup width=80>
<colgroup width=100>
<colgroup width=110>
<colgroup width=50>
<colgroup width=50>
<colgroup>
<colgroup width=50>
<tbody align=center>
<tr><td colspan=<?=$colspan?> height=2 bgcolor=#0E87F9></td></tr>
<tr class=ht>
    <td style="font-weight:bold;"> 번호 </td>
    <!--<td> <input type=checkbox> </td>-->
    <td style="font-weight:bold;"> 그룹 </td>
    <td style="font-weight:bold;"> 이름 </td>
    <td style="font-weight:bold;"> 회원ID </td>
    <td style="font-weight:bold;"> 전화번호 </td>
    <td style="font-weight:bold;"> 전송일시 </td>
    <td style="font-weight:bold;"> 예약 </td>
    <td style="font-weight:bold;"> 전송 </td>
    <td style="font-weight:bold;"> 메세지 </td>
    <td> - </td>
</tr>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
<? if (!$total_count) { ?>
<tr height=50>
    <td align=center height=100 colspan=<?=$colspan?> style="color:#999;"> 
        데이터가 없습니다. 
    </td>
</tr>
<?
}
$qry = sql_query("select * from $g4[sms4_history_table] where 1 $sql_search order by hs_no desc limit $page_start, $page_size");
while($res = sql_fetch_array($qry)) {
    if ($line++%2) 
        $bgcolor = '#F8F8F8'; 
    else 
         $bgcolor = '#ffffff';

    $write = sql_fetch("select * from $g4[sms4_write_table] where wr_no='$res[wr_no]' and wr_renum=0");
    $group = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no='$res[bg_no]'");
    if ($group)
        $bg_name = $group[bg_name];
    else
        $bg_name = '없음';

    if ($res[mb_id]) 
        $mb_id = "<a href=\"$g4[admin_path]/member_form.php?&w=u&mb_id=$res[mb_id]\">$res[mb_id]</a>";
    else
        $mb_id = '비회원';
?>
<tr height=30 bgcolor='<?=$bgcolor?>'>
    <td> <?=$vnum--?> </td>
    <!--<td> <input type=checkbox> </td>-->
    <td> <?=$bg_name?> </td>
    <td> <a href="./num_book_write.php?w=u&bk_no=<?=$res[bk_no]?>"><?=$res[hs_name]?></a> </td>
    <td> <?=$mb_id?> </td>
    <td> <?=$res[hs_hp]?> </td>
    <td> <?=date('Y-m-d H:i', strtotime($write[wr_datetime]))?> </td>
    <td> <?=$write[wr_booking]!='0000-00-00 00:00:00'?"<span title='$write[wr_booking]'>√</span>":'';?> </td>
    <td> <?=$res[hs_flag]?'성공':'실패'?> </td>
    <td> <span title="<?=$write[wr_message]?>"><?=cut_str($write[wr_message],20)?></span> </td>
    <td>
        <a href="./history_view.php?page=<?=$page?>&st=<?=$st?>&sv=<?=$sv?>&wr_no=<?=$res[wr_no]?>"><img src="<?=$g4[admin_path]?>/img/icon_modify.gif" align=absmiddle border=0></a>
        <!--
        <a href="./history_del.php?page=<?=$page?>&st=<?=$st?>&sv=<?=$sv?>&wr_no=<?=$res[wr_no]?>"><img src="<?=$g4[admin_path]?>/img/icon_delete.gif" align=absmiddle border=0></a>
        -->
    </td>
</tr>
<?}?>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
</tbody>
</table>

<p align=center>
<?=$paging?>
</p>

<div align=right>
<form name=search_form method=get action=<?=$PHP_SELF?> style="margin:0; padding:0;">
<select name=st>
<option value=hs_name <?=$st=='hs_name'?'selected':''?>>이름</option>
<option value=hs_hp <?=$st=='hs_hp'?'selected':''?>>핸드폰번호</option>
<option value=bk_no <?=$st=='bk_no'?'selected':''?>>고유번호</option>
</select>
<input type=text size=20 name=sv value="<?=$sv?>">
<input type=submit value='검  색' class=btn1>
</form>
</div>



<?
include_once("$g4[admin_path]/admin.tail.php");
?>
