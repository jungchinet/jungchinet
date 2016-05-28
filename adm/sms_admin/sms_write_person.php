<?
$sub_menu = "900300";
include_once("./_common.php");

$page_size = 10;
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

//if ($no_hp_checked == 'checked')
    $sql_no_hp = "and bk_hp <> '' and bk_receipt=1";

$total_res = sql_fetch("select count(*) as cnt from $g4[sms4_book_table] where 1 $sql_group $sql_search $sql_korean $sql_no_hp");
$total_count = $total_res[cnt];

$total_page = (int)($total_count/$page_size) + ($total_count%$page_size==0 ? 0 : 1);
$page_start = $page_size * ( $page - 1 );

$paging = get_paging(5, $page, $total_page, "sms_write_person.php?bg_no=$bg_no&st=$st&sv=$sv&ap=$ap&page="); 

$vnum = $total_count - (($page-1) * $page_size);

$res = sql_fetch("select count(*) as cnt from $g4[sms4_book_table] where bk_receipt=1 $sql_group $sql_search $sql_korean $sql_no_hp");
$receipt_count = $res[cnt];
$reject_count = $total_count - $receipt_count;

$res = sql_fetch("select count(*) as cnt from $g4[sms4_book_table] where mb_id='' $sql_group $sql_search $sql_korean $sql_no_hp");
$no_member_count = $res[cnt];
$member_count = $total_count - $no_member_count;

$no_group = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no=1");

$group = array();
$qry = sql_query("select * from $g4[sms4_book_group_table] where bg_no>1 order by bg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

include_once("$g4[path]/head.sub.php");
?>

<link rel=StyleSheet href='<?=$g4[admin_path]?>/admin.style.css' type=text/css />

<script language=javascript>

parent.document.getElementById('all_checked').checked = false;

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

function person_add(bk_no, bk_name, bk_hp)
{
    var hp_list = parent.document.getElementById('hp_list');
    var item    = bk_name + " (" + bk_hp + ")";
    var value   = 'p,' + bk_no;

    for (i=0; i<hp_list.length; i++) {
        if (hp_list[i].value == value) {
            alert('이미 같은 목록이 있습니다.');
            return;
        }
    }

    hp_list.options[hp_list.length] = new Option(item, value);
}

function person_multi_add()
{
    var bk_no = document.getElementsByName('bk_no');
    var ck_no = '';
    var count = 0;

    for (i=0; i<bk_no.length; i++) {
        if (bk_no[i].checked==true) {
            count++;
            ck_no += bk_no[i].value + ',';
        }
    }

    if (!count) {
        alert('하나이상 선택해주세요.');
        return;
    }

    var hp_list = parent.document.getElementById('hp_list');
    var item    = "개인 (" + count + " 명)";
    var value   = 'p,' + ck_no;

    for (i=0; i<hp_list.length; i++) {
        if (hp_list[i].value == value) {
            alert('이미 같은 목록이 있습니다.');
            return;
        }
    }

    hp_list.options[hp_list.length] = new Option(item, value);
}

</script>


<table cellpadding=0 cellspacing=0 width=100% border=0>
<colgroup width=30>
<colgroup width=100>
<colgroup>
<colgroup width=70>
<!--<colgroup width=50>-->
<tbody align=center>
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
    if (!$tmp)
        $group_name = '미분류';
    else
        $group_name = $tmp[bg_name];
?>
<tr bgcolor='<?=$bgcolor?>' height=30>
    <td> <input type=checkbox name=bk_no value='<?=$res[bk_no]?>'> </td>
    <!--<td> <span style="overflow:hidden; width:95px;"><?=$group_name?></span> </td>-->
    <td> <span style="overflow:hidden; width:95px;"><?=$res[bk_name]?></span> </td>
    <td> <?=$res[bk_hp]?> </td>
    <!--<td> <?=$res[bk_receipt] ? '<font color=blue>수신</font>' : '<font color=red>거부</font>'?> </td>-->
    <!--<td> <?=$res[bk_receipt] ? '√' : ''?> </td>-->
    <td> <?=$res[mb_id] ? '회원' : '비회원'?> </td>
    <td>
        <input type=button value='추가' onfocus="this.blur()" class=btn1 onclick="person_add(<?=$res[bk_no]?>, '<?=$res[bk_name]?>', '<?=$res[bk_hp]?>')">
    </td>
</tr>
<?}?>

<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
</tbody>
</table>

<div style="margin:10px 0 10px 10px;">
<input type=button value='선택추가' class=btn1 onclick="person_multi_add()" onfocus="this.blur()">
<input type=button value='그룹목록' class=btn1 onclick="parent.book_change('book_group')" onfocus="this.blur()">
</div>

<div style="margin:20px 0 30px 0; text-align:center;">
<?=$paging?>
</div>

<div style="margin-left:30px; padding-bottom:100px;">

<form name=search_form method=get action=<?=$PHP_SELF?> style="margin:0; padding:0;">
<input type=hidden name=bg_no value=<?=$bg_no?>>

<div style="margin-bottom:10px;">
그룹 : <select name="bg_no">
<option value="" <?=$bg_no?'':'selected'?>> 전체 </option>
<option value="1" <?=$bg_no=='1'?'selected':''?>> <?=$no_group[bg_name]?> (<?=number_format($no_group[bg_receipt])?> 명) </option>
<? for($i=0; $i<count($group); $i++) {?>
<option value="<?=$group[$i][bg_no]?>" <?=($bg_no==$group[$i][bg_no])?'selected':''?>> <?=$group[$i][bg_name]?> (<?=number_format($group[$i][bg_receipt])?> 명) </option>
<? } ?>
</select>
</div>

검색 : 
<select name=st>
<option value=all <?=$st=='all'?'selected':''?>>이름 + 번호</option>
<option value=name <?=$st=='name'?'selected':''?>>이름</option>
<option value=hp <?=$st=='hp'?'selected':''?>>번호</option>
</select>

<input type=text size=15 name=sv value="<?=$sv?>">
<input type=submit value='검  색' class=btn1>
</form>

</div>
<!--
총 건수 : <?=number_format($total_count)?> /
회원 : <?=number_format($member_count)?> /
비회원 : <?=number_format($no_member_count)?> /
수신 : <?=number_format($receipt_count)?> /
거부 : <?=number_format($reject_count)?>
-->



<?
include_once("$g4[path]/tail.sub.php");
?>
