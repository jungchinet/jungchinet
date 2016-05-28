<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($board[bo_4]) { // bo_4에 값이 있는 경우 exit를 적용
if ($_FILES[bf_file][name][0]) {
    $exif = @exif_read_data($_FILES[bf_file][tmp_name][0]);
    if (!$exif[Make]) {
        alert("EXIF 정보가 없는 이미지는 등록이 불가합니다.");
        exit;
    }
}
}
?>
