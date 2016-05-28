<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$downloadCount = 3;

if (!$is_admin) {
    $sql = " select bf_download from $g4[board_file_table]
              where bo_table = '$bo_table'
                and wr_id = '$wr_id'
                and bf_no = 0 ";
    $row = sql_fetch($sql);
    if ($row[bf_download] >= $downloadCount) {
        alert("다운로드수가 {$downloadCount}회 이상이면 삭제 불가합니다. 현재 다운로드수 : {$row[bf_download]}회");
    }
}
?>
