<!-- 메인화면 최신글 시작 -->

<?



echo "<table width=100%><tr>";

/*
// 한개의 게시글을 출력
echo "<tr valign=top>";
echo "<td width='50%' valign=top>";
include_once("$g4[path]/lib/latest.my.lib.php");
echo latest_scrap("scrap", "", "echo4me", 9, 40);
echo "</td>";
echo "<td width='50%' valign=top>";
echo db_cache('main_notice2', 1, "latest_one('one', 'gnu4_pack_skin, 118, 0, 430)");
echo "</td>";
echo "</tr>";
*/

// 전체 최근글 출력
// function latest_group($skin_dir="", $gr_id="", $rows=10, $subject_len=40, $content_len="", $skin_title="", $skin_title_link="")
echo "<td width='50%' valign=top>";
echo db_cache('all_latest', 1, "latest_group(naver, , 12, 40, , 전체최근글, '$g4[path]/bbs/new.php')");
$ja++;
echo "</td>";

// 최근에 답글이나 코멘트가 달린 글
// function latest_group($skin_dir="", $gr_id="", $rows=10, $subject_len=40, $content_len="", $skin_title="", $skin_title_link="")
echo "<td width='50%' valign=top>";
$db_key = $member[mb_id] . "_all_my_latest";
echo db_cache("$db_key", 1, "latest_group(naver, , 12, 40, , 전체내글의반응, '$g4[bbs_path]/new.php','my_datetime')");
echo "</td></tr>";

/*
// 블로그 최신글을 출력
echo "<tr valign=top>";
echo "<td width='50%' valign=top>";
include_once("$g4[path]/lib/latest.gblog.lib.php");
echo latest_gblog('naver','',12,40);
$ja=1;
echo "</td>";
*/

// 클럽 최신글을 출력
echo "<td width='50%' valign=top>";
include_once("$g4[path]/lib/latest.club.lib.php");
echo cb_latest_main('naver',12,40);
$ja++;
echo "</td>";

// 그룹 최신글을 출력
$sql = " select * from $g4[group_table] where gr_use_search = 1";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {

   if ($ja == 2) { // 줄바꿈
     echo "</tr><tr valign=top>";
     $ja = 0;
    }

    echo "<td width='50%' valign=top>";
    $gr_key = $row[gr_id] . "_key";
    echo db_cache($gr_key, 1, "latest_group('naver', $row[gr_id], 12, 40)");
    $ja++;
    echo "</td>";
}
echo "</tr>";

// 최근글 - 내가 그냥 출력하고 싶은거 지정할 때,
echo "<tr valign=top>";
echo "<td>" . db_cache('gr_trash', 1, "latest(naver, gnu4_pack)") . "</td>";
echo "<td>" . db_cache('gr_turning', 1, "latest(naver, gnu4_turning)") . "</td>";
echo "</td>";

// sitemap을 출력
echo "<tr valign=top>";
echo "<td width='100%' valign=top colspan=2>";
include_once("$g4[path]/lib/sitemap.lib.php");
echo sitemap("naver");
echo "</td>";
echo "</tr>";

echo "</table>";
?>
<!-- 메인화면 최신글 끝 -->
