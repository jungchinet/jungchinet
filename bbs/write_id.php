<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$is_member) 
    alert_close("회원만 접속가능한 화면 입니다");

// 연속검색 방지
$delay = $_SESSION['ss_friend'] - $g4['server_time'] + $g4['memo_delay_friend'];
if ($delay > 0 && !$is_admin)
    alert("너무 빠른 시간내에 친구찾기를 연속해서 할 수 없습니다.");
set_session("ss_friend", $g4['server_time']);

$sname = preg_replace('/\%/', '', strip_tags($sname));

if ($sname) {

    // 회원검색은 중요한 사안이므로 stamp를 남겨둡니다.
    $tmp_point = ($member['mb_point'] > 0) ? $member['mb_point'] : 0;
    if ($tmp_point + $g4['memo_friend_point'] < 0 && !$is_admin)
        alert("보유하신 포인트(".number_format($member['mb_point']).")가 없거나 모자라서 회원검색(".number_format($g4['memo_friend_point']).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 해 주십시오.");
    insert_point($member['mb_id'], $g4['memo_friend_point'], "쪽지5 친구찾기 - $sname", '친구찾기', $g4['time_ymdhis'], '쪽지5');
  
    switch ($sfl) {
      case "mb_nick" : $search_sql = " mb_nick like '%$sname%' "; 
                       $order_sql = " order by mb_nick"; break;
      case "mb_name" : $search_sql = " mb_name like '%$sname%' "; 
                       $order_sql = " order by mb_name"; break;
      case "mb_id"   : $search_sql = " mb_id like '%$sname%' "; 
                       $order_sql = " order by mb_id"; break;
      case "mb_all"  : 
      default        :
                       $search_sql = " mb_nick like '%$sname%' or mb_id like '%$sname%' or mb_name like '%$sname%' "; 
                       $order_sql = " order by mb_id"; break;
    }

    $sql = " select count(*) as cnt from $g4[member_table] where ( mb_leave_date = '' and mb_nick != '[삭제됨]' ) and ( $search_sql ) ";
    $result = sql_fetch($sql);
    $total_count = $result['cnt'];

    // guess work을 막기 위해서 최대 결과값 갯수를 - 회원수 많은 사이트에서는 보안 때문에 필수
    if ($total_count > $g4['memo_max_friend'] && $is_admin !== "super")
        $total_count = $g4['memo_max_friend'];

    $one_rows = 10; // 한페이지의 라인수
    $total_page  = ceil($total_count / $one_rows);  // 전체 페이지 계산 
    if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지) 
    $from_record = ($page - 1) * $one_rows; // 시작 열을 구함
    $to_record = $from_record + $one_rows ;

    $sql = " select * from $g4[member_table] where ( mb_leave_date = '' and mb_nick != '[삭제됨]' )and ( $search_sql ) $order_sql limit $from_record, $one_rows";
    $result = sql_query($sql);
    $search_count = mysql_num_rows($result);
    if ($search_count > 0) {
        for ($i=0; $row=mysql_fetch_array($result); $i++) {
            $list[$i]->id = "$row[mb_id]";
            $list[$i]->name = $row['mb_name'];
            $list[$i]->nick = $row['mb_nick'];
            $list[$i]->mb_open = $row['mb_open'];
        }
    } else {
        alert("찾으시는 회원정보가 없습니다.");
    }
    mysql_free_result($result);
}

// 관리자는 최소 1글자부터 검색 가능하게
if ($is_admin == "super")
    $minlength=1;
else
    $minlength=3;

$g4[title] = "사용자ID 검색";
include_once("$g4[path]/head.sub.php");
?>

<table width=100% border=0 cellspacing=0 cellpadding=0>
<form name=frmid method=get autocomplete=off>
<input type=hidden name=frm_name value='<?=$frm_name?>'>
<input type=hidden name=ss_id value='<?=$ss_id?>'>
<tr>
  <td width=14 bgcolor="eeeeee"></td>
  <td height=30 colspan=2 valign=bottom bgcolor="eeeeee"><table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="25"><img src="<?=$g4[bbs_img_path]?>/memo_icon07.gif" width="19" height="19" /></td>
      <td><span style="color: #333333;font-weight: bold;">친구찾기</span>&nbsp;&nbsp;&nbsp;(<?=number_format($g4[memo_friend_point])?> 포인트를 사용합니다)</td>
    </tr>
  </table></td>
</tr>
<tr>
  <td height="2" colspan="3" bgcolor="#d9d9d9"></td>
</tr>
<tr>
  <td height="3" colspan="3"></td>
  </tr>
<tr>
    <td></td>
    <td height=20 colspan=2 valign=bottom>회원정보를 입력하세요 <? if ($is_admin !== "super") { ?>(3자 이상)<? } ?></td>
</tr>

<tr>
  <td height="5" colspan="3"></td>
  </tr>
<tr>
    <td></td>
    <td width=1></td>
    <td>
    <select name=sfl>
      <option value='mb_all'>닉+이름+아이디</option>
      <option value='mb_nick'>닉네임</option>
      <option value='mb_name'>이름</option>
      <option value='mb_id'>아이디</option>
    </select>
    <input type=text name=sname value='<?=$sname?>' required <?=$min_length?> itemname='회원이름' size=14> <input type=image src='<?=$g4[bbs_img_path]?>/search.gif' border=0 align=absmiddle></td>
</tr>
<tr>
  <td height=10 colspan=3></td>
</tr>
</table>

<!-- 검색결과 여기서부터 -->
<script type="text/javascript">
    document.frmid.sname.focus();
</script>

<? if ($search_count > 0) { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="20"></td>
    <td>
        <table width=100% cellpadding=0 cellspacing=0>
        <tr>
            <td height=23 valign=top colspan=2><b>총 <?=$total_count?>명</b> (아이디/닉네임을 누르면 선택됩니다)</td>
        </tr>
        </table>
        <table width=100% cellpadding=0 cellspacing=0>
        <colgroup width="100">
        </colgroup>
        <colgroup width="">
        </colgroup>
        <colgroup width="50">
        </colgroup>
        <tr>
          <td height=2 align="center" bgcolor="d9d9d9"  colspan=3></td>
        </tr>
        <tr>
            <td height=23 >아이디</td><td>닉네임</td><td>정보보기</td>
        </tr>        
        <tr>
          <td height=2 align="center" bgcolor="d9d9d9"  colspan=3></td>
        </tr>
        <?
        for ($i=0; $i<count($list); $i++)
        {
            echo "
            <tr>
            <td height=25>
            <a href=javascript:setid('{$list[$i]->name}','{$list[$i]->id}')>{$list[$i]->id}</a>
            </td>
            <td>
            <a href=javascript:setid('{$list[$i]->name}','{$list[$i]->id}')>{$list[$i]->nick}</a>
            </td>";
            if ($list[$i]->mb_open == 1 || $is_admin == "super") 
                $msg = "<a href=\"javascript:;\" onclick=\"win_profile('" . $list[$i]->id . "')\">정보보기</a>";
            else 
                $msg = "비공개";
            echo "
            <td>{$msg}</td>";
            echo "
            </tr>
            <tr><td height=1 bgcolor=b4c9dd  colspan=3></td></tr>\n";
        }
        ?>
        <tr>

        </table>

        <table width=100% cellpadding=0 cellspacing=0>        
        <tr>
          <td height=10 align="center"></td>
        </tr>
        <tr>
          <td>
          <? 
            $page = get_paging($config[cf_write_pages], $page, $total_page, "?frm_name=$frm_name&ss_id=$ss_id&sname=$sname&sfl=$sfl&page=");
            echo "$page";
          ?> 
          </td>
        </tr>
        <tr>
          <td height=10 align="center"></td>
        </tr>
        <tr>
            <td height=23 align="center">
            <a href="javascript:window.close();"><img src="<?=$g4[bbs_img_path]?>/close.gif" border="0" /></a>
            </td>
        </tr>
        </table>
    <td width="20">    
</tr></form>
</table>
<? } ?>

<script type="text/javascript">

    if ('<?=$sfl?>') document.frmid.sfl.value = '<?=$sfl?>'; 

    function setid(sname, sid)
    {
        var ov = top.opener.document.<?=$frm_name?>.<?=$ss_id?>.value;
        var of = top.opener.document.<?=$frm_name?>.<?=$ss_id?>;

		if(ov.length>0) {
			of.value = ov + "," + sid;
		}else{
        	of.value  = sid;
		}

		top.opener.focus();
        top.close();
        return false;
    }
</script>

<?
include_once("$g4[path]/tail.sub.php");
?>
