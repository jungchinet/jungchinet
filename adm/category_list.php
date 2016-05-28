<?
$sub_menu = "300250";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "카테고리관리";
include_once ("$g4[admin_path]/admin.head.php");

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

$sql_common = " from $g4[category_table] ";
$sql_common .= $sql_search;


// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = $config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst) 
{
    $sst  = "ca_id";
    $sod = "asc";
}
$sql_order = "order by $sst $sod";

// 출력할 레코드를 얻음
$sql  = " select *
           $sql_common
           $sql_order
           limit $from_record, $rows ";
$result = sql_query($sql);

$qstr  = "$qstr&sca=$sca&page=$page&save_stx=$stx";
?>

<table width=100% cellpadding=4 cellspacing=0>
<form name=flist>
<input type=hidden name=page value="<?=$page?>">
<tr>
    <td width=20%><a href='<?=$_SERVER[PHP_SELF]?>'>처음</a></td>
    <td width=60% align=center>
        <select name=sfl>
            <option value='ca_subject'>카테고리제목
            <option value='ca_id'>카테고리ID
        </select>
        <? if ($sfl) echo "<script> document.flist.sfl.value = '$sfl';</script>"; ?>

        <input type=hidden name=save_stx value='<?=$stx?>'>
        <input type=text name=stx value='<?=$stx?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle>
    </td>
    <td width=20% align=right>건수 : <? echo $total_count ?>&nbsp;</td>
</tr>
</form>
</table>

<form name=fcategorylist method='post' action='./category_list_update.php' autocomplete='off' style="margin:0px;">

<table cellpadding=0 cellspacing=0 width=100%>
<input type=hidden name=page  value='<? echo $page ?>'>
<input type=hidden name=sort1 value='<? echo $sort1 ?>'>
<input type=hidden name=sort2 value='<? echo $sort2 ?>'>
<tr><td colspan=11 height=2 bgcolor=#0E87F9></td></tr>
<tr align=center class=ht>
    <td rowspan=2><input type=checkbox name=chkall value="1" onclick="check_all(this.form)"></td>
    <td width=180><?=subject_sort_link("ca_id");?>카테고리ID</a></td>
    <td width='' ><?=subject_sort_link("ca_subject");?>카테고리제목</a></td>
    <td width=60 ><?=subject_sort_link("ca_use");?>사용</a></td>
    <td width=60 ><?=subject_sort_link("ca_order");?>순서</a></td>
    <td width=120>
        <? 
        if ($is_admin == 'super')
            echo "<a href='./category_form.php'><img src='$g4[admin_path]/img/icon_insert.gif' border=0 title='1단계카테고리 추가'></a>";
        else
            echo "&nbsp;";
        ?>
    </td>
</tr>
<tr><td colspan=11 height=1 bgcolor=#CCCCCC></td></tr>

<?
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $s_level = "";
    $level = strlen($row[ca_id]) / 4 - 1;
    if ($level > 0) // 2단계 이상
    {
        $s_level = "&nbsp;&nbsp;<img src='./img/icon_catlevel.gif' border=0 width=17 height=15 align=absmiddle alt='".($level+1)."단계 카테고리'>";
        for ($k=1; $k<$level; $k++)
            $s_level = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $s_level;
        $style = " ";
    } 
    else // 1단계
    {
        $style = " style='border:1 solid; border-color:#0071BD;' ";
    }

    $s_add = icon("추가", "./category_form.php?ca_id=$row[ca_id]&$qstr");
    $s_upd = icon("수정", "./category_form.php?w=u&ca_id=$row[ca_id]&$qstr");

    if ($is_admin == 'super')
        $s_del = "<a href=\"javascript:post_delete('category_form_update.php', '$row[ca_id]');\"><img src='img/icon_delete.gif' border=0 title='삭제' align=absmiddle></a>";

    $list = $i%2;
    echo "
    <input type=hidden name='ca_id[$i]' value='$row[ca_id]'>
    <tr class='list$list center ht'>
        <td height=25><input type=checkbox name=chk[] value='$i'></td>
        <td align=left>$row[ca_id]</td>
        <td align=left>$s_level <input type=text name='ca_subject[$i]' value='".get_text($row[ca_subject])."' title='$row[ca_id]' required itemname='카테고리명' class=ed size=35 $style></td>";

    echo "
        <td><input type=checkbox name='ca_use[$i]' ".($row[ca_use] ? "checked" : "")." value='1'></td>
        <td><input type=text name='ca_order[$i]' size=6 style='text-align:right;' class=ed value='$row[ca_order]'></td>
        <td>$s_upd $s_del $s_vie $s_add</td>
    </tr>";
}

if ($i == 0) {
    echo "<tr><td colspan=20 height=100 bgcolor='#ffffff' align=center><span class=point>자료가 한건도 없습니다.</span></td></tr>\n";
}
?>
<tr><td colspan=11 height=1 bgcolor=#CCCCCC></td></tr>

</table>


<table width=100%>
<tr>
    <td width=50%><input type=submit class=btn1 value='일괄수정'></td>
    <td width=50% align=right><?=get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");?></td>
</tr>
</form>
</table>

<script type="text/javascript">
// POST 방식으로 삭제
function post_delete(action_url, val)
{
	var f = document.fpost;

	if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
    f.ca_id.value = val;
		f.action         = action_url;
		f.submit();
	}
}
</script>

<form name='fpost' method='post'>
<input type='hidden' name='sst'   value='<?=$sst?>'>
<input type='hidden' name='sod'   value='<?=$sod?>'>
<input type='hidden' name='sfl'   value='<?=$sfl?>'>
<input type='hidden' name='stx'   value='<?=$stx?>'>
<input type='hidden' name='page'  value='<?=$page?>'>
<input type='hidden' name='token' value='<?=$token?>'>
<input type='hidden' name='qstr' value='<?=$qstr?>'>
<input type='hidden' name='ca_id'>
<input type='hidden' name='w' value='d'>
</form>

<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
