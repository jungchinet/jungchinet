<!-- 메인화면 최신글 시작 -->

<?
include_once("$g4[path]/lib/latest.lib.php");       // 최신글


echo "<table width=100%><tr>";

// $snb_list의 최신글을 출력
$snb_list = get_snb_list($snb_arr[$mnb]);
$ja = 0;
if ($snb_list) {
foreach ($snb_list as $bo_id) {

   if ($ja == 2) { // 줄바꿈
     echo "</tr><tr valign=top>";
     $ja = 0;
    }

    echo "<td width='50%' valign=top>";
    //function latest($skin_dir="", $bo_table, $rows=10, $subject_len=40, $gallery_view=0, $notice=0, $options="")
    $opt = array('fill'=>'1');
    echo db_cache($bo_id, 1, "latest('naver', $bo_id, 12, 40, 0, 0, $opt)");
    $ja++;
    echo "</td>";
}
if ($ja = 2)
    echo "<td></td>";
echo "</tr>";
}
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
