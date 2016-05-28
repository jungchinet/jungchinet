<?
$sub_menu = "300310";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

//print_r2($_POST);

for ($i=0; $i<count($chk); $i++) {
    // 실제 번호를 넘김
    $k = $_POST[chk][$i];

    // 신고해제 테이블에서 게시판 테이블과 아이디를 읽어
    $sql = " select bo_table, wr_id from $g4[unsingo_table] where unsg_id = '$unsg_id[$k]' ";
    $row = sql_fetch($sql);

    // 신고 자료를 삭제
    $sql = " delete from $g4[unsingo_table] where unsg_id = '$unsg_id[$k]' ";
    sql_query($sql);

    // 신고 필드의 신고 카운트를 수정한다
    $sql = " select count(*) as cnt from $g4[singo_table] where bo_table = '$row[bo_table]' and wr_id = '$row[wr_id]' ";
    $sg_result = sql_fetch($sql);
    $sql = " select count(*) as cnt from $g4[unsingo_table] where bo_table = '$row[bo_table]' and wr_id = '$row[wr_id]' ";
    $unsg_result = sql_fetch($sql);
    $sg_count = $sg_result[cnt] - $unsg_result[cnt];

    if ($row['bo_table'] == '@memo') {
        ;
    } else if ($row['bo_table'] == '@member') {
        ;
    } else if ($row['bo_table'] == '@hidden_comment') {
        ;
    } else {      
        $write_table = $g4['write_prefix'].$row[bo_table];
        $sql = " update $write_table set wr_singo = '$sg_count' where wr_id = '$row[wr_id]' ";
        sql_query($sql);
    }
}

goto_url("unsingo_list.php?$qstr");
?>
