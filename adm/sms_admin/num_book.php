<?
$sub_menu = "900800";
include_once("./_common.php");

$page_size = 20;
$colspan = 9;

auth_check($auth[$sub_menu], "r");

$g4[title] = "핸드폰번호 관리";

if (!$page) $page = 1;

if (is_numeric($bg_no)) 
    $sql_group = " and bg_no='$bg_no' ";
else
    $sql_group = "";

if ($st == 'all') {
    $sql_search = "and (bk_name like '%{$sv}%' or bk_hp like '%{$sv}%')";
} else if ($st == 'name') {
    $sql_search = "and bk_name like '%{$sv}%'";
} else if ($st == 'hp') {
    $sql_search = "and bk_hp like '%{$sv}%'";
} else {
    $sql_search = '';
}

if ($ap > 0)
    $sql_korean = korean_index('bk_name', $ap-1);
else {
    $sql_korean = '';
    $ap = 0;
}

if ($no_hp == 'yes') {
    set_cookie('cookie_no_hp', 'yes', 60*60*24*365);
    $no_hp_checked = 'checked';
} else if ($no_hp == 'no') {
    set_cookie('cookie_no_hp', '', 0);
    $no_hp_checked = '';
} else {
    if (get_cookie('cookie_no_hp') == 'yes')
        $no_hp_checked = 'checked';
    else
        $no_hp_checked = '';
}

if ($no_hp_checked == 'checked')
    $sql_no_hp = "and bk_hp <> ''";

$total_res = sql_fetch("select count(*) as cnt from $g4[sms4_book_table] where 1 $sql_group $sql_search $sql_korean $sql_no_hp");
$total_count = $total_res[cnt];

$total_page = (int)($total_count/$page_size) + ($total_count%$page_size==0 ? 0 : 1);
$page_start = $page_size * ( $page - 1 );

$paging = get_paging(10, $page, $total_page, "num_book.php?bg_no=$bg_no&st=$st&sv=$sv&ap=$ap&page="); 

$vnum = $total_count - (($page-1) * $page_size);

$res = sql_fetch("select count(*) as cnt from $g4[sms4_book_table] where bk_receipt=1 $sql_group $sql_search $sql_korean $sql_no_hp");
$receipt_count = $res[cnt];
$reject_count = $total_count - $receipt_count;

$res = sql_fetch("select count(*) as cnt from $g4[sms4_book_table] where mb_id='' $sql_group $sql_search $sql_korean $sql_no_hp");
$no_member_count = $res[cnt];
$member_count = $total_count - $no_member_count;

$no_group = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no = 1");

$group = array();
$qry = sql_query("select * from $g4[sms4_book_group_table] where bg_no>1 order by bg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

include_once("$g4[admin_path]/admin.head.php");
?>

<script language=javascript>

function book_all_checked(chk) 
{
    var bk_no = document.getElementsByName('bk_no');

    if (chk) {
        for (var i=0; i<bk_no.length; i++) {
            bk_no[i].checked = true;
        }
    } else {
        for (var i=0; i<bk_no.length; i++) {
            bk_no[i].checked = false;
        }
    }
}

function book_del(bk_no)
{
    if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n그래도 삭제하시겠습니까?"))
        hiddenframe.location.href = "./num_book_update.php?w=d&bk_no=" + bk_no + "&page=<?=$page?>&bg_no=<?=$bg_no?>&st=<?=$st?>&sv=<?=$sv?>&ap=<?=$ap?>";
}

function multi_update(sel)
{
    var bk_no = document.getElementsByName('bk_no');
    var ck_no = '';
    var count = 0;

    if (!sel.value) {
        sel.selectedIndex = 0;
        return;
    }

    for (i=0; i<bk_no.length; i++) {
        if (bk_no[i].checked==true) {
            count++;
            ck_no += bk_no[i].value + ',';
        }
    }

    if (!count) {
        alert('하나이상 선택해주세요.');
        sel.selectedIndex = 0;
        return;
    }

    if (sel.value == 'del') {
        if (!confirm("선택한 핸드폰번호를 삭제합니다.\n\n비회원만 삭제됩니다.\n\n회원을 삭제하려면 회원관리 메뉴를 이용해주세요.\n\n실행하시겠습니까?")) 
        {
            sel.selectedIndex = 0;
            return;
        }
    } else if (!confirm("선택한 핸드폰번호를 " + sel.options[sel.selectedIndex].innerHTML + "\n\n실행하시겠습니까?")) {
        sel.selectedIndex = 0;
        return;
    }

    hiddenframe.location.href = "num_book_multi_update.php?w=" + sel.value + "&ck_no=" + ck_no;
}

function no_hp_click(val)
{
    var url = './num_book.php?bg_no=<?=$bg_no?>&st=<?=$st?>&sv=<?=$sv?>';

    if (val == true)
        location.href = url + '&no_hp=yes';
    else
        location.href = url + '&no_hp=no';
}
</script>

<?=subtitle($g4[title])?>

<table width=100% cellpadding=0 cellspacing=0 height=30 border=0>
<tr>
    <td height=30 colspan=2>
        <form style="margin:0; padding:0;">
        <select name="bg_no" onchange="location.href='<?=$PHP_SELF?>?bg_no='+this.value;">
        <option value="" <?=$bg_no?'':'selected'?>> 전체 </option>
        <option value="<?=$no_group[bg_no]?>" <?=$bg_no==$no_group[bg_no]?'selected':''?>> <?=$no_group[bg_name]?> (<?=number_format($no_group[bg_count])?> 명) </option>
        <? for($i=0; $i<count($group); $i++) {?>
        <option value="<?=$group[$i][bg_no]?>" <?=($bg_no==$group[$i][bg_no])?'selected':''?>> <?=$group[$i][bg_name]?> (<?=number_format($group[$i][bg_count])?> 명) </option>
        <? } ?>
        </select>
        <input type=checkbox name=no_hp onclick="no_hp_click(this.checked)" <?=$no_hp_checked?>> 핸드폰 소유자만 보기
        </form>
    </td>
</tr>
<tr>
    <td height=30 style="color:#999;">
        회원정보 최근 업데이트 : <?=$sms4[cf_datetime]?>
    </td>
    <td align=right style="color:#999;">
        총 건수 : <?=number_format($total_count)?> /
        회원 : <?=number_format($member_count)?> /
        비회원 : <?=number_format($no_member_count)?> /
        수신 : <?=number_format($receipt_count)?> /
        거부 : <?=number_format($reject_count)?>
    </td>
</tr>
</table>

<!--
<?
$hangul = array('전체', '가', '나', '다', '라', '마', '바', '사', '아', '자', '차', '카', '타', '파', '하');
?>
<table border=0 cellpadding=0 cellspacing=0 height=30>
<tr><td colspan=15 height=2 bgcolor=#0E87F9></td></tr>
<tr>
<?for ($i=0; $i<15; $i++) {?>
<?if ($i == $ap) $bgcolor = '#C1E0FD'; else $bgcolor = '#ffffff'; ?>
<?if ($i == 0) $width = 60; else $width = 60; ?>
    <td align=center bgcolor='<?=$bgcolor?>' width=<?=$width?> onclick="location.href='./num_book.php?bg_no=<?=$bg_no?>&st=<?=$st?>&sv=<?=$sv?>&ap=<?=$i?>'" style="cursor:pointer;">
        <?=$hangul[$i]?>
    </td>
<?}?>
</tr>
</table>
-->

<table cellpadding=0 cellspacing=0 width=100% border=0>
<tbody align=center>
<tr><td colspan=<?=$colspan?> height=2 bgcolor=#0E87F9></td></tr>
<tr class=ht>
    <td width=60 style="font-weight:bold;"> 번호 </td>
    <td width=50 style="font-weight:bold;"> <input type=checkbox onclick="book_all_checked(this.checked)"> </td>
    <td width=100 style="font-weight:bold;"> 그룹 </td>
    <td width=100 style="font-weight:bold;"> 이름 </td>
    <td style="font-weight:bold;"> 핸드폰 </td>
    <td width=50 style="font-weight:bold;"> 수신 </td>
    <td width=50 style="font-weight:bold;"> 등급 </td>
    <td width=130 style="font-weight:bold;"> 업데이트 </td>
    <td width=120> 
        <input type=image src="<?=$g4[admin_path]?>/img/icon_insert.gif" align=absmiddle alt='추가' onclick="location.href='./num_book_write.php?page=<?=$page?>&bg_no=<?=$bg_no?>';" accesskey='w'>
    </td>
</tr>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
<? if (!$total_count) { ?>
<tr>
    <td align=center height=100 colspan=<?=$colspan?> style="color:#999;"> 
        데이터가 없습니다. 
    </td>
</tr>
<?
}
$line = 0;
$qry = sql_query("select * from $g4[sms4_book_table] where 1 $sql_group $sql_search $sql_korean $sql_no_hp order by bk_no desc limit $page_start, $page_size");
while($res = sql_fetch_array($qry)) 
{
    if ($line++%2) 
        $bgcolor = '#F8F8F8'; 
    else 
        $bgcolor = '#ffffff';

    $tmp = sql_fetch("select bg_name from $g4[sms4_book_group_table] where bg_no='$res[bg_no]'");
    $group_name = $tmp[bg_name];
?>
<tr bgcolor='<?=$bgcolor?>' height=30>
    <td> <?=number_format($vnum--)?> </td>
    <td> <input type=checkbox name=bk_no value='<?=$res[bk_no]?>'> </td>
    <td> <span style="overflow:hidden; width:95px;"><?=$group_name?></span> </td>
    <td> <span style="overflow:hidden; width:95px;"><?=$res[bk_name]?></span> </td>
    <td> <?=$res[bk_hp]?> </td>
    <td> <?=$res[bk_receipt] ? '<font color=blue>수신</font>' : '<font color=red>거부</font>'?> </td>
    <!--<td> <?=$res[bk_receipt] ? '√' : ''?> </td>-->
    <td> <?=$res[mb_id] ? '회원' : '비회원'?> </td>
    <td> <?=$res[bk_datetime]?> </td>
    <td> 
        <a href="./num_book_write.php?w=u&bk_no=<?=$res[bk_no]?>&page=<?=$page?>&bg_no=<?=$bg_no?>&st=<?=$st?>&sv=<?=$sv?>&ap=<?=$ap?>"><img src="<?=$g4[admin_path]?>/img/icon_modify.gif" align=absmiddle alt='수정'></a>
        <a href="javascript:void(book_del(<?=$res[bk_no]?>));"><img src="<?=$g4[admin_path]?>/img/icon_delete.gif" align=absmiddle alt='삭제'></a>
        <a href="./sms_write.php?bk_no=<?=$res[bk_no]?>"><img src="<?=$g4[admin_path]?>/img/icon_view.gif" align=absmiddle alt='문자보내기'></a>
        <a href="./history_num.php?st=bk_no&sv=<?=$res[bk_no]?>"><img src="<?=$g4[admin_path]?>/img/icon_group.gif" align=absmiddle alt='전송내역'></a>
    </td>
</tr>
<?}?>

<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
</tbody>
</table>

<p align=center style="margin:20px;">
<?=$paging?>
</p>

<div>

<div style="float:left;">
<select onchange="multi_update(this);" style="width:250px;">
<option value=''>선택한 번호를 어떻게 할까요?</option>
<option value=''>-------------------------------------</option>
<? for($i=0; $i<count($group); $i++) {?>
<option value="m:<?=$group[$i][bg_no]?>"> '<?=$group[$i][bg_name]?>' 그룹으로 [이동]합니다. </option>
<? } ?>
<option value=''>-------------------------------------</option>
<? for($i=0; $i<count($group); $i++) {?>
<option value="c:<?=$group[$i][bg_no]?>"> '<?=$group[$i][bg_name]?>' 그룹으로 [복사]합니다. </option>
<? } ?>
<option value=''>-------------------------------------</option>
<option value='receipt' style="color:blue;">수신허용 합니다.</option>
<option value='reject' style="color:red;">수신거부 합니다.</option>
<option value=''>-------------------------------------</option>
<option value='del' style="color:red;">삭제합니다.</option>
</select>

</div>

<div style="float:right;">
<form name=search_form method=get action=<?=$PHP_SELF?> style="margin:0; padding:0;">
<input type=hidden name=bg_no value=<?=$bg_no?>>
<select name=st>
<option value=all <?=$st=='all'?'selected':''?>>이름 + 핸드폰번호</option>
<option value=name <?=$st=='name'?'selected':''?>>이름</option>
<option value=hp <?=$st=='hp'?'selected':''?>>핸드폰번호</option>
</select>
<input type=text size=20 name=sv value="<?=$sv?>">
<input type=submit value='검  색' class=btn1>
</form>
</div>

</div>

<?
include_once("$g4[admin_path]/admin.tail.php");
?>
