<?
$my_menu = array();
$sql = "select m.bo_table, b.bo_subject from $g4[my_menu_table] as m left join $g4[board_table] as b on m.bo_table = b.bo_table where mb_id = '$member[mb_id]'";
$qry = sql_query($sql);
while ($row = sql_fetch_array($qry))
{
    $my_menu[] = $row;
}
?>

<select class=quick_move onchange="quick_move(this.value)" style="width:160;">
<option value="">게시판 바로가기</option>
<option value="">-------------------------</option>
<? for ($i=0; $i<count($my_menu); $i++) {?>
<option value="<?=$my_menu[$i][bo_table]?>"><?=$my_menu[$i][bo_subject]?></option>
<? } ?>
<option value="">-------------------------</option>
<option value="menu-edit">바로가기 편집</option>
</select>

<script language="JavaScript">
function quick_move(bo_table)
{
    if (!bo_table) return;
    if (bo_table == 'menu-edit') {
        popup_window("<?=$g4[bbs_path]?>/my_menu_edit.php", "my_menu_edit", "width=350, height=400, scrollbars=1");
        return;
    }
    if (bo_table == 'mypage') {
        document.location.href = "<?=$_SERVER[PHP_SELF]?>?menu_id=<?=bo_table?>&url=<?=$g4[path]?>/customer/mypage.php";
        return;
    }
    document.location.href = "<?=$_SERVER[PHP_SELF]?>?menu_id=<?=bo_table?>&url=<?=$g4[bbs_path]?>/board.php?bo_table=" + bo_table;
}
</script>
