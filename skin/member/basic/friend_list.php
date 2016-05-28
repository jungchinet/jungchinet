<? 
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$g4[title] = "친구관리";

if (! $is_member) alert("회원만 접속할 수 있는 페이지 입니다");

// 쪽지2 프로그램의 location을 정의
$memo_url = $g4[bbs_path] . "/memo.php";

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

$online_sql = " select count(*) as cnt from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id) where b.mb_id <> '$config[cf_admin]' ";
$online_count = sql_fetch($online_sql);

switch ($fr_type) {
  case 'fr_id'    : $total_count = $fr_count[cnt]; break;
  case 'black_id' : $total_count = $black_count[cnt]; break;
  case 'online'   : $total_count = $online_count[cnt]; break;
  case 'mb_connect' : $total_count = $mb_connect_count[cnt]; break;
  case 'mb_id'    : 
  default         : $total_count = $mb_count[cnt];
}

$one_rows = 10; // 한페이지의 라인수
$total_page = ceil($total_count / $one_rows);  // 전체 페이지 계산 
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지) 
$from_record = ($page - 1) * $one_rows; // 시작 열을 구함
$to_record = $from_record + $one_rows ;

switch ($fr_type) {
  case 'fr_id'    : $sql = " select * $fr_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "나를 친구로 등록한 사람"; break;
  case 'black_id' : $sql = " select * $black_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "나의 블랙리스트에 등록된 사람들"; break;
  case 'online'   : $sql = " select a.mb_id, b.mb_nick, b.mb_name, b.mb_email, b.mb_homepage, b.mb_open, b.mb_point, b.mb_today_login from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id) where b.mb_id <> '$config[cf_admin]' order by mb_id desc limit $from_record, $one_rows "; $subj = "접속중인 회원들"; break;
  case 'mb_connect' : $sql = " select * $mb_connect_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "접속중인 나의 친구들"; break;
  case 'mb_id'    : 
  default         : $sql = " select * $mb_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "나의 친구들";
}

$result = sql_query($sql);

echo "<script language='javascript' src='$g4[path]/js/sideview.js'></script>"; // 사이트뷰가 보이도록
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
$fr_width = '100%'; // 친구관리의 폭
$ss_id = 'fr_id'; // 직접 아이디를 지정하니까 오류가 생겨서 어쩔 수 없이... ㅠ..ㅠ
?>

<style type="text/css">
<!--
.style5 {
	color: #333333;
	font-weight: bold;
}
.style6 {color: #f36823}
.style7 {color: #0c4473}
.style8 {
	font-size: 11px;
	color: #444444;
}
.style9 {color: #0a4fa3}
.style10 {color: #666666;font-weight: bold}
-->
</style>

<!-- 친구관리 제목 -->
<table width="<?=$fr_width?>" height="30" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="14">&nbsp;</td>
        <td width="25"><img src="<?=$memo_skin_path?>/img/memo_icon05.gif" width="19" height="19" /></td>
        <td ><span class="style5">친구관리</span> :: <?=$subj?> ::</td>
    </tr>
</table>

<table width="<?=$fr_width?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="5" background="<?=$memo_skin_path?>/img/memo_box2_tl.gif"></td>
    <td width="" background="<?=$memo_skin_path?>/img/memo_line2_top.gif"></td>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_box2_tr.gif"></td>
  </tr>
  <tr>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_line2_left.gif">&nbsp;</td>
    <td align="center">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="50">
                <font style="font-size:9pt;">
                내 친구 <b><a href='<?=$memo_url?>?kind=online&fr_type=mb_id'>
                <?=$mb_count[cnt]?>명</a></b> (접속중<b> <a href='<?=$_SERVER[PHP_SELF]?>?kind=online&fr_type=mb_connect'><?=$mb_connect_count[cnt]?>명</a/></b>), 
                나의 팬 <b><a href='<?=$memo_url?>?kind=online&fr_type=fr_id'>
                <?=$fr_count[cnt]?>명</a></b>, 
                블랙리스트 <b><a href='<?=$memo_url?>?kind=online&fr_type=black_id'>
                <?=$black_count[cnt]?>명</a></b>,
                현재접속자 <b><a href='<?=$memo_url?>?kind=online&fr_type=online'>
                <?=$online_count[cnt]?>명</a></b>                
                </font></td>
      </tr>
      <tr>
          <td height="1"  bgcolor="#d9d9d9"></td>
      </tr>   
      </table>
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <colgroup width="30">
        </colgroup>
        <colgroup width="50">
        </colgroup>
        <colgroup width="100">
        </colgroup>
        <colgroup width=''>
        </colgroup>
        <colgroup width="40">
        </colgroup>
        <colgroup width="80">
        </colgroup>
        <tr>
          <td colspan="<?=$cols?>" height="2"></td>
        </tr>
        <form name='friendlist' id="friendlist" method='post' onsubmit="return friendlist_submit(this);">
          <input type="hidden" class="ed" name="fr_edit" value="<?=$fr_edit?>" />
          <tr>
            <td height="20"></td>
            <td width="75" align="center"><strong>아이디</strong></td>
            <td width="120" align="center"><strong>이 름</strong></td>
            <td align="center"><strong>메 모 </strong></td>
            <td width="60" align="center"><strong>접속</strong></td>
            <td width="60" align="center"><strong>등록일</strong></td>
          </tr>
          <tr>
            <td height="3"></td>
          </tr>
          <tr>
            <td colspan="<?=$cols?>"  height="1" bgcolor="#d9d9d9"></td>
          </tr>
          <tr>
            <td height="7"></td>
          </tr>
          <?//출력
  for ($i=0; $row = sql_fetch_array($result); $i++) { // Join 또는 검색으로 하지 않고 개별로 member 정보를 fetch 하는 것은 효율 때문
    switch ($fr_type) {
        case 'online'   : 
        case 'fr_id'    : $mb = get_member($row[mb_id]); 
                          break;
        case 'black_id' :
        case 'mb_id'    :
        default         : $mb = get_member($row[fr_id]);
    }
?>
          <tr>
            <td height="20">
              <? if ($fr_type == 'online') { ?>
                <input type="checkbox" name="chk_fr_no[]" value="<?=$row[mb_id]?>" />
              <? } else { ?>
                <input type="checkbox" name="chk_fr_no[]" value="<?=$row[fr_no]?>" />
                <? } ?>
            </td>
            <td width="75" align="center"><span class="style7">
              <?=$mb[mb_id]?>
            </span></td>
            <td width="120" align="center"><?=get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]); ?>
                <? 
          if ($fr_type == 'fr_id') {
              //$sql1 = " select count(*) as cnt from (select * from $sql_from where fr_type != 'black_id') a 
              //    where (mb_id = '$member[mb_id]' and fr_id = '$row[mb_id]') or (mb_id = '$row[mb_id]' and fr_id = '$member[mb_id]') ";  
              $sql1 = " select count(*) as cnt from $sql_from 
                  where fr_type != 'black_id' and (mb_id = '$member[mb_id]' and fr_id = '$row[mb_id]') or (mb_id = '$row[mb_id]' and fr_id = '$member[mb_id]') ";  
          }
          else if ($fr_type == 'black_id') {} 
          else {
              //$sql1 = " select count(*) as cnt from (select * from $sql_from where fr_type != 'black_id') a 
              //    where (mb_id = '$member[mb_id]' and fr_id = '$row[fr_id]') or (mb_id = '$row[fr_id]' and fr_id = '$member[mb_id]') ";
              $sql1 = " select count(*) as cnt from $sql_from
                  where fr_type != 'black_id' and (mb_id = '$member[mb_id]' and fr_id = '$row[fr_id]') or (mb_id = '$row[fr_id]' and fr_id = '$member[mb_id]') ";
          }
          if ($sql1 ) $result1 = sql_fetch($sql1);
          if ($result1[cnt] == 2) echo " <img src='$memo_skin_path/img/icon_friends.gif' align='absmiddle'> ";
    ?>            </td>
            <td align="center"><span class="style10">
              <? if ($fr_type == 'fr_id' or $fr_type== 'online') {} else echo get_text(stripslashes($row[fr_memo])); // 친구들이 나를 추가하면서 작성한 메모는 볼 수 없슴?>
              </span>
              <? 
                if ($fr_type == 'fr_id' or $fr_type == 'online') {}
                else {
                    echo "&nbsp;&nbsp;<a href=\"javascript:memo_box('{$row[fr_no]}')\"><img src='$memo_skin_path/img/btn_c_modify.gif' border='0' align='absmiddle'></a>";
                }
              ?>
              <span id='memo_<?=$row[fr_no]?>' style='display:none;'>
              <input type="type" class="ed" name="fr_edit_<?=$row[fr_no]?>" size="25" value="<?=preg_replace("/\"/", "&#034;", stripslashes(get_text($row[fr_memo],0)))?>" />
              <a href='javascript:memo_update(<?=$row[fr_no]?>)'><img src='<?=$memo_skin_path?>/img/btn_c_ok.gif' border='0'/></a> </span> </td>
            <td width="60" align="center">
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
                  }
                  else {
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
            <td width="60" align="center"><span class="style8">
              <?=cut_str($row[fr_datetime],10,'')?>
            </span></td>
          </tr>
          <tr>
            <td height="3"></td>
          </tr>
          <? } ?>
        </form>
        <tr>
          <td height="1" colspan="<?=$cols?>" bgcolor="#d9d9d9"></td>
        </tr>
        <tr>
          <td height="10" colspan="<?=$cols?>"></td>
        </tr>
        <? if ($total_page > 0) { ?>
        <tr>
          <td colspan="<?=$cols?>" >
          <?
            $page = get_paging($config[cf_write_pages], $page, $total_page, "?fr_type=$fr_type&page="); 
            echo "$page";
         ?>
          </td>
        </tr>
        <tr>
          <td height="10" colspan="<?=$cols?>"></td>
        </tr>
        <? } ?> 
        <? if ($fr_type == 'fr_id') { ?>
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_update();">친구등록</a>&nbsp;&nbsp; 
          <a href="javascript:select_black();">블랙리스트 등록</a> 
          </td>
        </tr>
        <? } else if ($fr_type == 'online') { ?>
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_update();">친구등록</a>&nbsp;&nbsp; 
          </td>
        </tr>
        <? } else if ($fr_type == 'black_id') { ?>
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_delete();">블랙리스트 삭제</a> </td>
        </tr>
        <? } else { ?>
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_delete();">친구삭제</a> </td>
        </tr>
        <? } ?>
      </table></td>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_line2_right.gif">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" background="<?=$memo_skin_path?>/img/memo_box2_dl.gif"></td>
    <td background="<?=$memo_skin_path?>/img/memo_line2_down.gif"></td>
    <td background="<?=$memo_skin_path?>/img/memo_box2_dr.gif"></td>
  </tr>
</table>

<table width="<?=$fr_width?>" border="0" cellpadding="0" cellspacing="0" bgcolor="ededed">
  <tr>
    <td height="10" colspan="3" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td width="5" height="5" background="<?=$memo_skin_path?>/img/memo_box4_tl.gif"></td>
    <td width=""></td>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_box4_tr.gif"></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center">
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
      <colgroup width="180"></colgroup>
      <colgroup width="50"></colgroup>
      <colgroup width=""></colgroup>
      <colgroup width=""></colgroup>
      <? if ($fr_type == 'black_id') { ?>
      <tr>
        <td height="20" colspan="4" class="style5" style="padding-left:5px;">          블랙리스트 등록하기</td>
      </tr>
      <? } else { ?>
      <tr>
        <td height="20" colspan="4" class="style5" style="padding-left:5px;">          새로운 친구 등록하기</td>
      </tr>
      <? } ?>
      <tr>
        <td colspan="4" height="1" bgcolor="#dcdcdc"></td>
      </tr>
      <tr>
        <td height="10"></td>
      </tr>
      <form name='fr_register' id="fr_register" method='post' onsubmit="return fr_register_submit(this);" enctype="multipart/form-data" autocomplete="off" >
        <input type="hidden" class="ed" name="mb_id" value="<?=$member[mb_id]?>" />
        <input type="hidden" class="ed" name="fr_type" value="<?=$fr_type?>" />

        <tr class='ht center'>
          <td>아이디 : 
            <input name='<?=$ss_id?>' type="text" class="ed" size="10" required="required" itemname='친구아이디' />
            &nbsp;<a href="javascript:popup_id('fr_register','<?=$ss_id?>',300,500);"><img src='<?=$memo_skin_path?>/img/friend_search.gif' border="0" align="absmiddle" /></a> </td>
          <td align="right">메모 : </td>
          <td align=left >&nbsp;<input name="fr_memo" type="text" class="ed" itemname='메모' size="24" /></td>
          <? if ($fr_type == 'black_id') { ?>
          <td >&nbsp;<input type="submit" class="btn1" value='블랙리스트' /></td>
          <? } else { ?>
          <td >&nbsp;<input type="submit" class="btn1" value='친구등록' /></td>
          <? } ?>
        </tr>
      </form>
    </table></td>
    <td width="5">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" background="<?=$memo_skin_path?>/img/memo_box4_dl.gif"></td>
    <td></td>
    <td background="<?=$memo_skin_path?>/img/memo_box4_dr.gif"></td>
  </tr>
</table>

<script language="JavaScript">
function fr_register_submit(f)
{
    f.action = "<?=$memo_skin_path?>/friend_update.php";
    return true;
}

var save_before = '';
function check_confirm(str) {
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
function select_delete() {
    var f = document.friendlist;

    str = "삭제";
    if (!check_confirm(str))
        return false;

    if (!confirm("선택한 친구를 정말 "+str+" 하시겠습니까?\n\n"))
        return false;

    f.action = "<?=$memo_skin_path?>/friend_delete.php";
    return true;
}

// 선택한 친구 추가
function select_update() {
    var f = document.friendlist;

    str = "추가";
    if (!check_confirm(str))
        return false;

    if (!confirm("선택한 친구를 정말 "+str+" 하시겠습니까?\n\n"))
        return false;

    f.action = "<?=$memo_skin_path?>/friend_update.php?fr_type=<?=$fr_type?>";
    return true;
}

// 선택한 친구 블랙 리스트에 추가
function select_black() {
    var f = document.friendlist;

    str = "블랙리스트에 추가";
    if (!check_confirm(str))
        return false;

    if (!confirm("선택한 친구를 정말 "+str+" 하시겠습니까?\n\n"))
        return false;

    f.action = "<?=$memo_skin_path?>/friend_update.php?fr_type=black_id";
    return true;
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
    f.action = "<?=$memo_skin_path?>/friend_memo_update.php?fr_no=" + fr_no + "&fr_type=<?=$fr_type?>";
    return true;
}
</script>

