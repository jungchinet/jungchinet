<?
$sub_menu = "200100";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

if ($is_admin != "super")
    alert("회원정리는 최고관리자만 가능합니다.");

$g4[title] = "장기미접속회원 정리";

include_once("./admin.head.php");
echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

echo "<script>document.getElementById('ct').innerHTML += '<p>장기미접속회원 정리중...';</script>\n";
flush();

// 회원 삭제 함수 인클루드.
include_once("$g4[admin_path]/admin.lib.php");

// 개별 삭제
if ($w == 'd' && $mb_id) {

    // 데이터
    $mb = get_member($mb_id);

    // 체크
    if (!$mb['mb_id']) {

        alert("회원 데이터가 존재하지 않습니다.");

    }

    // 회원삭제
    member_delete($mb_id);

    // 이동
    goto_url("./member_delete.php");

}

// 사이드뷰
echo "<script language=\"javascript\" src=\"$g4[path]/js/sideview.js\"></script>\n";

$login_time = "365"; //지난 몇일 동안 접속하지 않은 회원을 삭제할지를 결정?
$today_login_time = date("Y-m-d H:i:s", $g4['server_time'] - ($login_time * 86400));

// $login_time일 이전에 로그인한 회원 출력. 즉 최근 $login_time일안에 로그인한 사람이 없다는 것이다.
$sql = " select * from $g4[member_table] where mb_today_login < '$today_login_time' and mb_level > '1' order by mb_today_login desc ";
$result = sql_query($sql);

$j = 0;
for ($i=0; $row=sql_fetch_array($result); $i++) { 

    // 게시물 체크. 코멘트 및 원글 포함
    $sql2 = " select count(*) as cnt from $g4[board_new_table] where mb_id = '$row[mb_id]' ";
    $new = sql_fetch($sql2); 

    // 내역이 없다면 않았다면? 삭제하지 않습니다. 혹시 모르니까요.
    if (!$new['cnt']) {

        // 닉네임
        $nick = get_sideview($row['mb_id'], $row['mb_nick'], $row['mb_email'], $row['mb_homepage']);

        // 일단 삭제할 아이디와 최종 로그인 출력
        //echo "<tr height='25'>";
        //echo "<td align='center'>{$nick}</td>";
        //echo "<td align='right'>". number_format($row['mb_point']) . "</td>";
        //echo "<td></td>";
        //echo "<td align='center'>{$row['mb_today_login']}</td>";
        //echo "<td align='center'><a href='?w=d&mb_id={$row['mb_id']}'>삭제</a></td>";
        //echo "</tr>";
        //echo "<tr><td height='1' bgcolor='#f3f3f3' colspan='6'></td></tr>";

        $j++;
        // 회원삭제
        member_delete($row['mb_id']);

    } // end if

} // end for
?>
</table>

<br><br>

<?
echo "<script>document.getElementById('ct').innerHTML += '<p>총 ".$j."명의 회원이 정리 되었습니다.';</script>\n";
?>

