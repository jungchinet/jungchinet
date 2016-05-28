<?
include_once("./_common.php");

// bo_table이 없으면 죽는다.
if( empty($bo_table) ) die("101");

// wr_id가 없어도 죽는거다.
if( empty($wr_id) ) die("102");

// 게시글이 있는지는 확인 안한다. 왜? 없으면 실행이 안될테니까. ㅋㅋ

// bitly_url이 있는지 본다. 없으면 죽어야지
if( empty($bitly_url) ) die("104");

$tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

$sql = " update {$tmp_write_table} set bitly_url = '$bitly_url' where wr_id='{$wr_id}' ";
$result = sql_query($sql, FALSE);

if (!$result) {
    //db를 업데이트
    $sql2 = " ALTER TABLE $tmp_write_table ADD `bitly_url` VARCHAR( 255 ) NOT NULL ";
    sql_query($sql2);
    
    // 다시 한번 더~!
    sql_query($sql);
}

die("000");
?>
