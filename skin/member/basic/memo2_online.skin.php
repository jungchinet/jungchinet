<? 
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sql_from = " $g4[friend_table] ";
$mb_sql_common = " from $sql_from where mb_id = '$member[mb_id]' and fr_type = '' ";
$mb_connect_sql_common = " from $g4[login_table] a left join  $g4[friend_table] b on (a.mb_id = b.fr_id) where a.mb_id != '' and b.mb_id = '$member[mb_id]' ";

$fr_sql_common = " from $sql_from where fr_id = '$member[mb_id]' ";
$black_sql_common = " from $sql_from where mb_id = '$member[mb_id]' and fr_type = 'black_id' ";

$mb_sql = " select count(*) as cnt $mb_sql_common";
$mb_count = sql_fetch($mb_sql);

$mb_connect_sql = " select count(*) as cnt $mb_connect_sql_common";
$mb_connect_count = sql_fetch($mb_connect_sql);

$fr_sql = " select count(*) as cnt $fr_sql_common";
$fr_count = sql_fetch($fr_sql);

$black_sql = " select count(*) as cnt $black_sql_common";
$black_count = sql_fetch($black_sql);

$search_sql = " 1 "; 
$order_sql = " group by a.mb_id order by b.mb_id asc";
if ($sname) {
  switch ($sfl) {
  case "mb_nick" : $search_sql = " b.mb_nick like '%$sname%' "; 
                   $order_sql = " order by b.mb_nick asc"; break;
  case "mb_name" : $search_sql = " b.mb_name like '%$sname%' "; 
                   $order_sql = " order by b.mb_name asc"; break;
  case "mb_id"   : $search_sql = " b.mb_id like '%$sname%' "; 
                   $order_sql = " order by b.mb_id asc"; break;
  case "mb_all"  :
  default        :
                   $search_sql = " b.mb_nick like '%$sname%' or b.mb_id like '%$sname%' or b.mb_name like '%$sname%' "; 
                   $order_sql = " order by b.mb_id asc"; break;
  }
}
    
$online_sql = " select count(*) as cnt 
                  from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id) 
                 where b.mb_id <> '$config[cf_admin]' and $search_sql ";
$online_count = sql_fetch($online_sql);

switch ($fr_type) {
  case 'fr_id'    : $total_count = $fr_count['cnt']; break;
  case 'black_id' : $total_count = $black_count['cnt']; break;
  case 'online'   : $total_count = $online_count['cnt']; break;
  case 'mb_connect' : $total_count = $mb_connect_count['cnt']; break;
  case 'mb_id'    : 
  default         : $total_count = $mb_count['cnt'];
}

$one_rows = $config['cf_memo_page_rows'] - 4;   // 한페이지의 라인수 (밑부분 때문에 -4)
$total_page = ceil($total_count / $one_rows);   // 전체 페이지 계산 
if ($page == 0)   // 페이지가 없으면 첫 페이지 (1 페이지) 
    $page = 1; 
$from_record = ($page - 1) * $one_rows;         // 시작 열을 구함
$to_record = $from_record + $one_rows ;

switch ($fr_type) {
  case 'fr_id'    : $sql = " select * $fr_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "나를 친구로 등록한 사람"; break;
  case 'black_id' : $sql = " select * $black_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "나의 블랙리스트에 등록된 사람들"; break;
  case 'online'   : 
                    $sql = " select a.mb_id, b.mb_nick, b.mb_name, b.mb_email, b.mb_homepage, b.mb_open, b.mb_point, b.mb_today_login 
                        from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id) 
                        where a.mb_id!='$member[mb_id]' and b.mb_id <> '$config[cf_admin]' and $search_sql $order_sql limit $from_record, $one_rows "; $subj = "접속중인 회원들"; 
                    break;
  case 'mb_connect' : $sql = " select * $mb_connect_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "접속중인 나의 친구들"; break;
  case 'mb_id'    : 
  default         : $sql = " select * $mb_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "나의 친구들";
}
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
$ss_id = 'fr_id'; // 직접 아이디를 지정하니까 오류가 생겨서 어쩔 수 없이... ㅠ..ㅠ
?>

<!-- 친구관리 제목 -->
<form name=frmid2 method=get autocomplete=off>
<input type=hidden name=kind value='<?=$kind?>'>
<input type=hidden name=fr_type value='<?=$fr_type?>'>
<table width="100%" height="30" border="0" cellspacing="0">
    <tr>
    <td>
        &nbsp;<img src="<?=$memo_skin_path?>/img/memo_icon05.gif" width="19" height="19" align=absmiddle /> 친구관리:: <?=$subj?> :: 
    </td>
    <? if ($fr_type == 'online') { // 접속중인 회원 검색 ?>
    <td align=right>
        <select name=sfl>
          <option value='mb_all'>닉+이름+아이디</option>
          <option value='mb_nick'>닉네임</option>
          <option value='mb_name'>이름</option>
          <option value='mb_id'>아이디</option>
        </select>
        <input type=text name=sname value='<?=$sname?>' required minlength=2 itemname='회원이름' size=14>
        <a href='<?=$memo_url?>'>
        <input type=image src='<?=$g4[bbs_img_path]?>/search.gif' border=0 align=absmiddle>
        </a>
    </td>
    <? } ?>
    </tr>
</table>
</form>

<form method="post" name="friendlist" id="friendlist">
<input type="hidden" class="ed" name="fr_edit" id="fr_edit" value="<?=$fr_edit?>" />

<table class="tbl_type" width="100%" border="1" cellspacing="0">
    <colgroup> 
      <col width="35">
      <col width="75">
      <col width="120">
      <col width="">
      <col width="60">
      <col width="60">
    </colgroup>
    <thead>
    <tr>
        <th colspan=6 height=30px>
        내 친구 <b><a href='<?=$memo_url?>?kind=online&fr_type=mb_id'>
        <?=$mb_count['cnt']?>명</a></b> (접속중<b> <a href='<?=$_SERVER[PHP_SELF]?>?kind=online&fr_type=mb_connect'><?=$mb_connect_count['cnt']?>명</a/></b>), 
        나의 팬 <b><a href='<?=$memo_url?>?kind=online&fr_type=fr_id'>
        <?=$fr_count['cnt']?>명</a></b>, 
        블랙리스트 <b><a href='<?=$memo_url?>?kind=online&fr_type=black_id'>
        <?=$black_count['cnt']?>명</a></b>,
        <? if ($sname) { ?>
        현재접속자 <b><?=$online_count['cnt']?>명 (<a href='<?=$memo_url?>?kind=online&fr_type=online'>전체보기</a>)</b>
        <? } else { ?>
        현재접속자 <b><a href='<?=$memo_url?>?kind=online&fr_type=online'>
        <?=$online_count['cnt']?>명</a></b>
        <? } ?>
        </th>
    </tr>
    <tr>
        <th></th>
        <th>아이디</th>
        <th>이 름</th>
        <th>메 모</th>
        <th>접속</th>
        <th>등록일</th>
    </tr>
    </thead>

    <?//출력 - Join 또는 검색으로 하지 않고 개별로 member 정보를 fetch 하는 것은 효율 때문
    for ($i=0; $row = sql_fetch_array($result); $i++) { 
        switch ($fr_type) {
        case 'online'   : 
        case 'fr_id'    : $mb = get_member($row['mb_id']); 
                          break;
        case 'black_id' :
        case 'mb_id'    :
        default         : $mb = get_member($row['fr_id']);
        }
        if ($config['cf_memo_mb_name']) $mb['mb_nick'] = $mb['mb_name'];
    ?>
    <tr>
        <td>
        <? if ($fr_type == 'online') { ?>
            <input type="checkbox" id="chk_fr_no[]" name="chk_fr_no[]" value="<?=$row[mb_id]?>" />
        <? } else { ?>
            <input type="checkbox" id="chk_fr_no[]" name="chk_fr_no[]" value="<?=$row[fr_no]?>" />
        <? } ?>
        </td>
        <td><?=$mb['mb_id']?></td>
        <td><?=get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']); ?>
        <? 
        if ($fr_type == 'fr_id') {
            $sql1 = " select count(*) as cnt from $sql_from 
                where fr_type != 'black_id' and (mb_id = '$member[mb_id]' and fr_id = '$row[mb_id]') or (mb_id = '$row[mb_id]' and fr_id = '$member[mb_id]') ";  
        }
        else if ($fr_type == 'black_id') {} 
        else {
            $sql1 = " select count(*) as cnt from $sql_from
                where fr_type != 'black_id' and (mb_id = '$member[mb_id]' and fr_id = '$row[fr_id]') or (mb_id = '$row[fr_id]' and fr_id = '$member[mb_id]') ";
        }
        if ($sql1 ) $result1 = sql_fetch($sql1);
        if ($result1[cnt] == 2) echo " <img src='$memo_skin_path/img/icon_friends.gif' align='absmiddle'> ";
        ?>
        </td>
        <td align=left>
        <? if ($fr_type == 'fr_id' or $fr_type== 'online') {} else echo get_text(stripslashes($row['fr_memo'])); // 친구들이 나를 추가하면서 작성한 메모는 볼 수 없슴?>
        <? 
        if ($fr_type == 'fr_id' or $fr_type == 'online') {}
        else {
            echo "&nbsp;&nbsp;<a href=\"javascript:memo_box('{$row[fr_no]}')\"><img src='$memo_skin_path/img/btn_c_modify.gif' border='0' align='absmiddle'></a>";
        }
        ?>
        <span id='memo_<?=$row[fr_no]?>' style='display:none;'>
        <input type="type" class="ed" name="fr_edit_<?=$row[fr_no]?>" id="fr_edit_<?=$row[fr_no]?>" size="25" value="<?=preg_replace("/\"/", "&#034;", stripslashes(get_text($row[fr_memo],0)))?>" />
        <a href='javascript:memo_update(<?=$row[fr_no]?>)'><img src='<?=$memo_skin_path?>/img/btn_c_ok.gif' border='0'/></a> </span> 
        </td>
        <td>
        <?
        if ($fr_type == 'fr_id') {
            $sql2 = " select count(*) as cnt 
                from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id)
                       where a.mb_id = '$row[mb_id]' ";
            $result2 = sql_fetch($sql2);
            $sql3 = " select mb_today_login from $g4[member_table]
                       where mb_id = '$row[mb_id]' and mb_open = 1 ";
            $result3 = sql_fetch($sql3);
            if ($result3[mb_today_login] =='') $last_datetime = "정보 비공개"; else $last_datetime = $result3[mb_today_login];
        } else {
            $sql2 = " select count(*) as cnt 
                       from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id)
                       where a.mb_id = '$row[fr_id]' ";
            $result2 = sql_fetch($sql2);
            $sql3 = " select mb_today_login from $g4[member_table]
                       where mb_id = '$row[fr_id]' and mb_open = 1 ";
            $result3 = sql_fetch($sql3);
            if ($result3[mb_today_login] =='') $last_datetime = "정보 비공개"; else $last_datetime = $result3[mb_today_login];
        }
        if ($result2[cnt] > 0 or $fr_type =='online') 
            echo "<img src='$memo_skin_path/img/friend_on.gif' align='absmiddle' alt='$last_datetime'>";
        else {
            echo "<img src='$memo_skin_path/img/friend_off.gif' align='absmiddle' alt='$last_datetime'>";
        }
        ?>
        </td>
        <td><?=get_datetime($row['fr_datetime'])?></td>
    </tr>
    <? } ?>
    <tfoot>
    <? if ($total_page > 1) { ?>
    <tr>
        <td colspan=6 style="padding:2px 0 2px;" height=30px>
        <?
        $page = get_paging($config['cf_write_pages'], $page, $total_page, "?kind=$kind&fr_type=online&sfl=$sfl&stx=$stx&unread=$unread&page="); 
        echo "$page";
        ?>
        </td>
    </tr>
    <? } ?>
    <? if ($fr_type == 'fr_id') { ?>
    <tr>
        <td colspan=6 align=left style="padding:2px 0 2px 10px;" height=30px><a href="javascript:select_update_friend();">친구등록</a>&nbsp;&nbsp; 
        <a href="javascript:select_black_friend();">블랙리스트 등록</a> 
        </td>
    </tr>
    <? } else if ($fr_type == 'online') { ?>
    <tr>
        <td colspan=6 align=left style="padding:2px 0 2px 10px;" height=30px><a href="javascript:select_update_friend();">친구등록</a>&nbsp;&nbsp; 
        </td>
    </tr>
    <? } else if ($fr_type == 'black_id') { ?>
    <tr>
      <td colspan=6 align=left style="padding:2px 0 2px 10px;" height=30px><a href="javascript:select_delete_friend();">블랙리스트 삭제</a> </td>
    </tr>
    <? } else { ?>
    <tr>
        <td colspan=6 align=left style="padding:2px 0 2px 10px;" height=30px><a href="javascript:select_delete_friend();">친구삭제</a> </td>
    </tr>
    <? } ?>
    </tfoot>
<table>
</form>

<br>
<table class="tbl_type" width="100%" border="1" cellspacing="0">
    <thead>
    <tr>
    <? if ($fr_type == 'black_id') { ?>
        <th>블랙리스트 등록하기</th>
    <? } else { ?>
        <th>새로운 친구 등록하기</th>
    <? } ?>
    </tr>
    </thead>
    <tr>
        <td>
        <form name="fr_register" action="javascript:fr_register_submit(document.fr_register);" method="post" enctype="multipart/form-data" autocomplete="off" >
        <input type="hidden" class="ed" name="mb_id" value="<?=$member[mb_id]?>" />
        <input type="hidden" class="ed" name="fr_type" value="<?=$fr_type?>" />
        아이디 : 
        <input name='<?=$ss_id?>' type="text" class="ed" size="10" required="required" itemname='친구아이디' />
        &nbsp;<a href="javascript:popup_id('fr_register','<?=$ss_id?>',300,500);"><img src='<?=$memo_skin_path?>/img/friend_search.gif' border="0" align="absmiddle" /></a>
        메모 : 
        &nbsp;<input name="fr_memo" type="text" class="ed" itemname='메모' size="24" />
        <? if ($fr_type == 'black_id') { ?>
        &nbsp;<input type="submit" class="btn1" value='블랙리스트' />
        <? } else { ?>
        &nbsp;<input type="submit" class="btn1" value='친구등록' />
        <? } ?>
        </form>
        </td>
    </tr>
</table>

<script type="text/javascript">
function fr_register_submit(f)
{
    f.action = "<?=$memo_skin_path?>/friend_update.php?kind=<?=$kind?>&";
    f.submit();
}

var save_before = '';
function check_confirm_friend(str) {
    var f = document.friendlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_fr_no[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 친구를 한명 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 친구 삭제
function select_delete_friend() {
    var f = document.friendlist;

    str = "삭제";
    if (!check_confirm_friend(str))
        return;

    if (!confirm("선택한 친구를 정말 "+str+" 하시겠습니까?\n\n"))
        return;

    f.action = "<?=$memo_skin_path?>/friend_delete.php?kind=<?=$kind?>&fr_type=<?=$fr_type?>";
    f.submit();
}

// 선택한 친구 추가
function select_update_friend() {
    var f = document.friendlist;

    str = "추가";
    if (!check_confirm_friend(str))
        return;

    if (!confirm("선택한 친구를 정말 "+str+" 하시겠습니까?\n\n"))
        return;

    f.action = "<?=$memo_skin_path?>/friend_update.php?kind=<?=$kind?>&fr_type=<?=$fr_type?>";
    f.submit();
}

// 선택한 친구 블랙 리스트에 추가
function select_black_friend() {
    var f = document.friendlist;

    str = "블랙리스트에 추가";
    if (!check_confirm_friend(str))
        return;

    if (!confirm("선택한 친구를 정말 "+str+" 하시겠습니까?\n\n"))
        return;

    f.action = "<?=$memo_skin_path?>/friend_update.php?kind=<?=$kind?>&fr_type=black_id";
    f.submit();
}

function memo_box(memo_id)
{
    var el_id;

    el_id = 'memo_' + memo_id;

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
function memo_update(fr_no) {
    var f = document.friendlist;
    var el_id;

    el_id = 'fr_edit_' + fr_no;
    document.getElementById('fr_edit').value = document.getElementById(el_id).value;
    f.action = "<?=$memo_skin_path?>/friend_memo_update.php?kind=<?=$kind?>&fr_no=" + fr_no + "&fr_type=<?=$fr_type?>";
    f.submit();
}
</script>
