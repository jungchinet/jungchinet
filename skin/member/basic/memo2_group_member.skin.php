<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// gr_id가 없으면 그룹 관리로 이동...
if ($gr_id =="")
    alert("메모그룹이 지정되지 않았습니다.", "$g4[bbs_path]/memo.php?kind=memo_group_admin");
    
$sql = " select * from $g4[memo_group_table] where gr_id = '$gr_id' and mb_id = '$member[mb_id]' ";
$result = sql_fetch($sql);

if ($result['gr_name'] == '')
    alert("메모그룹이 지정되지 않았습니다.", "$g4[bbs_path]/memo.php?kind=memo_group_admin");
else
    $gr_name = $result['gr_name'];

$sql = " select count(*) as cnt from $g4[memo_group_member_table] where gr_id = '$gr_id' ";
$result = sql_fetch($sql);
$total_count = $result['cnt'];

$one_rows = $config['cf_memo_page_rows'];       // 한페이지의 라인수
$total_page = ceil($total_count / $one_rows);   // 전체 페이지 계산 
if ($page == 0)   // 페이지가 없으면 첫 페이지 (1 페이지) 
    $page = 1;
$from_record = ($page - 1) * $one_rows; // 시작 열을 구함
$to_record = $from_record + $one_rows ;

$sql = " select * from $g4[memo_group_member_table] where gr_id = '$gr_id' order by gr_mb_id desc limit $from_record, $one_rows";
$result = sql_query($sql);
?>

<script type="text/javascript">
<!-- // 회원ID 찾기  
function popup_id(frm_name, ss_id, top, left)
{
    url = '<?=$g4[bbs_path]?>/write_id.php?frm_name='+frm_name+'&ss_id='+ss_id;
    opt = 'scrollbars=yes,width=320,height=470,top='+top+',left='+left;
    window.open(url, "write_id", opt);
}
//-->
</script>

<? 
$cols = 7; 
$fr_width = 490; // 테이블의 폭
$ss_id = 'gr_mb_id'; // 직접 아이디를 지정하니까 오류가 생겨서 어쩔 수 없이... ㅠ..ㅠ
?>

<!-- 그룹관리 제목 -->
<table width="100%" height="30" border="0" cellspacing="0">
    <tr>
    <td>
        &nbsp;<img src="img/memo_icon05.gif" width="19" height="19"  align=absmiddle /> <a href="<?=$memo_url?>?kind=memo_group_admin">그룹관리</a> :: <?=$gr_name?> ::
    </td>
    </tr>
</table>

<form method="post" name="friendlist" id="friendlist">
<input type="hidden" class="ed" name="gr_id" value="<?=$gr_id?>" />
<table class="tbl_type" width="100%" border="1" cellspacing="0">
    <colgroup> 
      <col width="30">
      <col width="50">
      <col width="80">
      <col width="">
      <col width="80">
      <col width="80">
    </colgroup>
    <thead>
    <tr>
        <th colspan=6>
        그룹 멤버는 <b><?=$total_count?>명</b> 입니다.
        </th>
    </tr>
    <tr>
        <th></th>
        <th>no</th>
        <th>아이디</th>
        <th>이름</th>
        <th>접속</th>
        <th>등록일</th>
    </tr>
    </thead>
    <?//출력
    for ($i=0; $row = sql_fetch_array($result); $i++) { // Join 또는 검색으로 하지 않고 개별로 member 정보를 fetch 하는 것은 효율 때문
        $mb = get_member($row['gr_mb_id']); 
    ?>
    <tr>
        <td><input type="checkbox" name="chk_fr_no[]" value="<?=$row[gr_mb_no]?>" /></td>
        <td><?=$i+1?></td>
        <td><?=$mb[mb_id]?></td>
        <td><?=get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]); ?></td>
        <td>
        <?
        $sql2 = " select count(*) as cnt 
                     from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id)
                    where a.mb_id = '$row[gr_mb_id]' ";
        $result2 = sql_fetch($sql2);
        $sql3 = " select mb_today_login from $g4[member_table]
                   where mb_id = '$row[gr_mb_id]' and mb_open = 1 ";
        $result3 = sql_fetch($sql3);
        if ($result3['mb_today_login'] =='') $last_datetime = "정보 비공개"; else $last_datetime = $result3['mb_today_login'];
        if ($result2['cnt'] > 0 or $fr_type =='online') 
            echo "<img src='$memo_skin_path/img/friend_on.gif' align='absmiddle' alt='$last_datetime'>";
        else {
            echo "<img src='$memo_skin_path/img/friend_off.gif' align='absmiddle' alt='$last_datetime'>";
        }
        ?>
        </td>
        <td><?=get_datetime($row['gr_mb_datetime'])?></td>
    </tr>
    <? } ?>    
    <tfoot>
    <? if ($total_page > 1) { ?>
    <tr>
        <td colspan=6 style="padding:2px 0 2px;" height=30px>
        <?
        $page = get_paging($config[cf_write_pages], $page, $total_page, "?kind=memo_group&gr_id=$gr_id&page="); 
        echo "$page";
        ?>
        </td>
    </tr>
    <? } ?>
    <tr>
        <td colspan=6 align=left style="padding:2px 0 2px 10px;" height=30px><a href="javascript:select_delete_gr_member();">멤버삭제</a>
        </td>
    </tr>
    </tfoot>
</table>
</form>

<table class="tbl_type" width="100%" border="1" cellspacing="0">
    <thead>
    <tr>
    <th>새로운 멤버 등록하기</th>
    </tr>
    </thead>
    <tr>
        <td>
        <form name="fr_register" action="javascript:gr_register_submit(document.fr_register);" method="post" enctype="multipart/form-data" autocomplete="off" >
        <input type="hidden" class="ed" name="mb_id" value="<?=$member[mb_id]?>" />
        <input type="hidden" class="ed" name="gr_id" value="<?=$gr_id?>" />
        아이디 : 
        <input name='<?=$ss_id?>' type="text" class="ed" size="10" required="required" itemname='친구아이디' />
        &nbsp;<a href="javascript:popup_id('fr_register','<?=$ss_id?>',300,500);"><img src='<?=$memo_skin_path?>/img/friend_search.gif' border="0" align="absmiddle" /></a>
        &nbsp;<input type="submit" class="btn1" value='멤버등록' />
        </form>
        </td>
    </tr>
</table>

<script type="text/javascript">
function gr_register_submit(f)
{
    f.action = "<?=$memo_skin_path?>/memo2_group_member_update.php";
    f.submit();
}

var save_before = '';
function check_confirm_gr_member(str) {
    var f = document.friendlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_fr_no[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 멤버를 한명 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 멤버 삭제
function select_delete_gr_member() {
    var f = document.friendlist;

    str = "삭제";
    if (!check_confirm_gr_member(str))
        return;

    if (!confirm("선택한 멤버를 정말 "+str+" 하시겠습니까?\n\n"))
        return;

    f.action = "<?=$memo_skin_path?>/memo2_group_member_delete.php";
    f.submit();
}

</script>

<form method="post" name="fboardlist" id="fboardlist">
</form>
