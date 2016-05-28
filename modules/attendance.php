<?
include_once("./_common.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/_head.php");

// 출석시간 설정

echo "<script language=\"javascript\" src=\"$g4[path]/js/sideview.js\"></script>\n";
?>

<table width="100%" cellspacing="0" cellpadding="0" align="center" valign="top">
  <tr>
    <td align=center>
    <br>
    00:00:00부터 출석순서로 30명을 출력 합니다(시간이 같은 경우는 포인트가 적은 분이 우선됩니다).<br>
    가장 먼저 출석한 분에게는 아무런 선물(?)이나 혜택이 없습니다.
    <br>
    <br>
    </td>
  </tr>
	<tr>
		<td width="100%">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" valign="top">
				<tr><td colspan="9" height="3" bgcolor="#F2F2F2"></td></tr>
				<tr><td colspan="9" height="1" bgcolor="#D9D9D9"></td></tr>
				<tr height="30">
					<td width="100" align="center"><span class="at_rk_s">순서</span></td>
					<td width="1"></td>
					<td width="150" align="center"><span class="at_rk_s">출석시간</span></td>
					<td width="1"></td>
					<td width="100" align="center"><span class="at_rk_s">접속상태</span></td>
					<td width="1"></td>
					<td align="center"><span class="at_rk_s">닉네임</span></td>
					<td width="1"></td>
					<td width="100" align="center" style="padding:0 0 0 5px;"><span class="at_rk_s">포인트</span></td>
				</tr>
				<tr><td colspan="9" height="1" bgcolor="#D9D9D9"></td></tr>
				<tr><td colspan="9" height="3" bgcolor="#F2F2F2"></td></tr>
<?
// 시작시간
$str_today_time = date("Y-m-d 00:00:00");

// 회원테이블 연결
$sql_select = " mb_id, mb_nick, mb_email, mb_homepage, mb_today_login, mb_point ";
$sql = " select $sql_select from $g4[member_table] where mb_today_login >= '$str_today_time' and mb_id != '$config[cf_admin]' order by mb_today_login asc, mb_point asc limit 30";
$result = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result); $i++) {

// 접속자테이블 연결
$sql2 = " select mb_id from $g4[login_table] where mb_id = '$row[mb_id]' ";
$row2 = sql_fetch($sql2);

// 접속상태
if ($row2['mb_id']) {
$on = "접속중";
} else {
$on = "";
}

// 닉네임
$name = get_sideview($row[mb_id], $row[mb_nick], $row[mb_email], $row[mb_homepage]);

// 랭킹
$rank = $i + 1;

// 색상
if ($member['mb_id'] == $row['mb_id']) {
$list = "2";
} else {
$list = ($i%2);
}
?>

				<tr class='list<?=$list?>' height="25" onMouseOver='this.style.backgroundColor="#ffe9e9"' onMouseOut='this.style.backgroundColor=""'>
					<td width="100" align="center"><span class="at_rk_n"><?=$rank?></span></td>
					<td width="1"></td>
					<td width="150" align="center"><span class="at_rk_n"><?=substr($row['mb_today_login'],10,16);?></span></a></td>
					<td width="1"></td>
					<td width="100" align="center"><span class="at_rk_n"><?=$on?></span></td>
					<td width="1"></td>
					<td align="center"><span class="at_rk_n"><?=$name?></span></td>
					<td width="1"></td>
					<td width="100" align="right" style="padding:0 5 0 0px;"><span class="at_rk_n"><?=number_format($row['mb_point']);?> 점</span></td>
				</tr>
				<tr><td bgcolor="#EEEEEE" colspan="9"></td></tr>
<? } ?>
				<tr><td colspan="9" height="3" bgcolor="#FAFAFA"></td></tr>
			</table></td>
	</tr>
</table>
