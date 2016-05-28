<?
$sub_menu = "300700";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

if ($is_admin != "super")
    alert("휴지통정리는 최고관리자만 가능합니다.");

$g4[title] = "휴지통 정리";

include_once("./admin.head.php");
echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

echo "<script>document.getElementById('ct').innerHTML += '<p>휴지통 정리중...';</script>\n";
flush();

// 회원 삭제 함수 인클루드.
include_once("$g4[admin_path]/admin.lib.php");

$rc_datetime = $config[cf_recycle_days]; // 휴지통에 들어온지 몇일이 지난글을 삭제할지를 결정
$today_login_time = date("Y-m-d H:i:s", $g4['server_time'] - ($rc_datetime * 86400));

$sql = " update $g4[recycle_table] set rc_delete='1' where rc_datetime < '$today_login_time'";
sql_query($sql);

$j = mysql_modified_rows();

// 게시글을 완전히 삭제
if ($ok == 1) {

}
?>
</table>

<br><br>

<?
echo "<script>document.getElementById('ct').innerHTML += '<p>총 ".$j."명의 휴지글이 정리 되었습니다.';</script>\n";
?>

