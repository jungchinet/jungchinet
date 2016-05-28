<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<table height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td>
    &nbsp;<img src="<?=$memo_skin_path?>/img/memo_icon06.gif"/> 주소록
    (<?=number_format($tot_cnt)?>)
    </td>
</tr>
</table>

<table class="tbl_type" border="1" cellspacing="0">
<colgroup> 
    <col width="35">
    <col width="">
    <col width="70">
    <col width="70">
    <col width="70">
    <col width="70">
</colgroup> 
<thead>
<tr>
    <th>no</th>
    <th>회원</th>
    <th>수신함</th>
    <th>발신함</th>
    <th>보관(수신)</th>
    <th>보관(발신)</th>
</tr>
</thead>
<?
if (is_array($list)) {
$i=0;
foreach ($list as $val) { 
    $i++;
    ?>
    <tr>
    <td><?=$i?></td>
    <td><?=$val[name]?></td>
    <td>
        <? if ($val['recv']) { ?><a href="<?=$memo_url?>?kind=recv&sfl=me_send_mb_id&stx=<?=$val[mb_id]?>"><?echo $val['recv'];?></a><? } else echo '-'; ?>
    </td>
    <td>
        <? if ($val['send']) { ?><a href="<?=$memo_url?>?kind=send&sfl=me_recv_mb_id&stx=<?=$val[mb_id]?>"><?echo $val['send'];?></a><? } else echo '-'; ?>
    </td>
    <td>
        <? if ($val['save_recv']) { ?><a href="<?=$memo_url?>?kind=save&sfl=me_send_mb_id&stx=<?=$val[mb_id]?>"><?echo $val['save_recv'];?></a><? } else echo '-'; ?>
    </td>
    <td>
        <? if ($val['save_send']) { ?><a href="<?=$memo_url?>?kind=save&sfl=me_recv_mb_id&stx=<?=$val[mb_id]?>"><?echo $val['save_send'];?></a><? } else echo '-'; ?>
    </td>
    </tr>
<? } ?>
<? } ?>
</table>
