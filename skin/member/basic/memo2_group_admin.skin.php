<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 그룹의 카운트 구하기
$mb_sql = " select count(*) as cnt from $g4[memo_group_table] where mb_id = '$member[mb_id]' ";
$result = sql_fetch($mb_sql);
$total_count = $result['cnt'];

$one_rows = $config['cf_memo_page_rows'];       // 한페이지의 라인수
$total_page = ceil($total_count / $one_rows);   // 전체 페이지 계산 
if ($page == 0)   // 페이지가 없으면 첫 페이지 (1 페이지) 
    $page = 1; 
$from_record = ($page - 1) * $one_rows; // 시작 열을 구함
$to_record = $from_record + $one_rows ;

$sql = " select * from $g4[memo_group_table] where mb_id = '$member[mb_id]' order by gr_id desc limit $from_record, $one_rows"; 
$subj = "나의 메모그룹 목록";
$result = sql_query($sql);

$cols = 6; 
$gr_width = '100%'; // 그룹관리의 폭
$ss_id = 'gr_id'; // 직접 아이디를 지정하니까 오류가 생겨서 어쩔 수 없이... ㅠ..ㅠ
?>

<!-- 그룹관리 제목 -->
<table width="100%" height="30" border="0" cellspacing="0">
    <tr>
    <td>
        &nbsp;<img src="<?=$memo_skin_path?>/img/memo_icon06.gif" align=absmiddle /> <a href="<?=$memo_url?>?kind=memo_group_admin">그룹관리</a> :: <?=$subj?> ::
    </td>
    </tr>
</table>

<form method="post" name="grouplist" id="grouplist">
<input type="hidden" class="ed" name="gr_edit" id="gr_edit" value="<?=$gr_edit?>" />
<table class="tbl_type" width="100%" border="1" cellspacing="0">
    <colgroup> 
      <col width="30">
      <col width="">
      <col width="100">
      <col width="100">
      <col width="100">
    </colgroup>
    <thead>
    <tr>
        <th colspan=5>
        내 메모그룹은 <b>( <a href='<?=$memo_url?>?kind=memo_group_admin'><?=$total_count?></a> )</b>
        </th>
    </tr>
    <tr>
        <th></th>
        <th align="left">&nbsp;그룹명</th>
        <th>멤버수</th>
        <th>보내기</th>
        <th>등록일</th>
    </tr>
    </thead>
    <?//출력
    for ($i=0; $row = sql_fetch_array($result); $i++) { // Join 또는 검색으로 하지 않고 개별로 member 정보를 fetch 하는 것은 효율 때문
    ?>
    <tr>
        <td>
        <input type="checkbox" name="chk_gr_id[]" value="<?=$row[gr_id]?>" />
        </td>
        <td align="left">&nbsp;
        <a href="<?=$memo_url?>?kind=memo_group&gr_id=<?=$row[gr_id]?>"><?=get_text(stripslashes($row['gr_name']));?></a>
        &nbsp;&nbsp;<a href="javascript:memo_box(<?=$row['gr_id']?>)"><img src='<?=$memo_skin_path?>/img/btn_c_modify.gif' border='0' align='absmiddle'></a>
        <span id='memo_<?=$row[gr_id]?>' style='display:none;'>
        <input type="type" class="ed" id="gr_edit_<?=$row[gr_id]?>" name="gr_edit_<?=$row[gr_id]?>" size="30" value="<?=preg_replace("/\"/", "&#034;", stripslashes(get_text($row['gr_name'],0)))?>" />
        <a href="javascript:memo_update('<?=$row[gr_id]?>')"><img src='<?=$memo_skin_path?>/img/btn_c_ok.gif' border='0'/></a> </span>
        </td>
        <td>
        <? 
        $sql1 = " select count(*) as cnt from $g4[memo_group_member_table] where gr_id = '$row[gr_id]' ";
        $result1 = sql_fetch($sql1);
        echo $result1['cnt'];
        ?>
        </td>
        <td>
        <? if ($result1['cnt'] > 0) { ?>
            <a href="<?=$memo_url?>?kind=write&gr_id=<?=$row[gr_id]?>">write</a>
        <? } ?>
        </td>
        <td><?=get_datetime($row['gr_datetime'])?></td>
    </tr>
    <? } ?>
    <tfoot>
    <? if ($total_page > 1) { ?>
    <tr>
        <td colspan=5 style="padding:2px 0 2px;" height=30px>
        <?
        $page = get_paging($config[cf_write_pages], $page, $total_page, "?kind=memo_group_admin&page="); 
        echo "$page";
        ?>
        </td>
    </tr>
    <? } ?>
    <tr>
        <td colspan=5 align=left style="padding:2px 0 2px 10px;" height=30px><a href="javascript:select_delete_gr();">그룹삭제</a>
        </td>
    </tr>
    </tfoot>
</table>
</form>

<br>

<table class="tbl_type" width="100%" border="1" cellspacing="0">
    <thead>
    <tr>
    <th>새로운 그룹 등록하기</th>
    </tr>
    </thead>
    <tr>
        <td>
        <form name="gr_register" action="javascript:gr_register_submit(document.gr_register);" method="post" enctype="multipart/form-data" autocomplete="off" >
        <input type="hidden" class="ed" name="mb_id" value="<?=$member[mb_id]?>" />
        메모그룹 : 
        &nbsp;<input name="gr_name" type="text" class="ed" itemname='메모그룹' size="45" />
        &nbsp;<input type="submit" class="btn1" value=' 메모그룹등록' />
        </form>
        </td>
    </tr>
</table>

<script type="text/javascript">
function gr_register_submit(f)
{
    f.action = "<?=$memo_skin_path?>/memo2_group_update.php";
    f.submit();
}

var save_before = '';
function check_confirm_gr(str) {
    var f = document.grouplist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_gr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 그룹을 한개 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 그룹 삭제
function select_delete_gr() {
    var f = document.grouplist;

    str = "삭제";
    if (!check_confirm_gr(str))
        return;

    if (!confirm("선택한 그룹을 정말 "+str+" 하시겠습니까?\n\n"))
        return;

    f.action = "<?=$memo_skin_path?>/memo2_group_delete.php";
    f.submit();
}

function memo_box(memo_id)
{
    var el_id= 'memo_' + memo_id;

    if (save_before != el_id) {
      
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
        }

        document.getElementById(el_id).style.display = 'block';
        save_before = el_id;
    }
}

// 선택한 메모를 업데이트
function memo_update(gr_id) {
    var f = document.grouplist;
    var el_id = 'gr_edit_' + gr_id;

    document.getElementById('gr_edit').value = document.getElementById(el_id).value;
    f.action = "<?=$memo_skin_path?>/memo2_group_name_update.php?gr_id=" + gr_id;
    f.submit();
}
</script>

<form method="post" name="fboardlist" id="fboardlist">
</form>
