<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 원래 게시판으로 이동 - bbs/delete.php의 앞부분과 비슷한 코드
$recycle = "";

$rc_no = $_POST[rc_no];
$rc_row = sql_fetch(" select * from $g4[recycle_table] where rc_no = '$rc_no' ");
if ($rc_row) {

    // 관리자 또는 글쓴이가 아니면, 안됩니다
    if ($is_admin == "super")
        ;
    else if ($member[mb_id] || $member[mb_id] == $rc_row[mb_id])
        ;
    else
        alert("복구할 수 없는 권한 입니다.");

    // recycle action임을 지정
    $recycle = "recycle";

    // 복사/이동에 대한 log를 남기지 않게 설정
    $config[cf_use_copy_log] = 0;

    // 복구할 휴지통 게시판을 지정
    $bo_table = $rc_row[rc_bo_table];
    
    // 복구에 필요한 변수값을 설정
    $write_table = $g4[write_prefix] . $rc_row[rc_bo_table];
    $wr_id = $rc_row[rc_wr_id];

    $sql = " select * from $g4[write_prefix]$rc_row[rc_bo_table] where wr_id = '$wr_id' ";
    $write = sql_fetch($sql);

    // 게시글에 대한 정보에서 원글이 아니면, return
    if ($write[wr_id] !== $write[wr_parent])
        alert("원글에 대해서만 가능한 작업 입니다");

    // 복구할 게시판
    $board['bo_move_bo_table'] = $rc_row[bo_table];
    $new_bo_table = sql_fetch(" select * from $g4[board_table] where bo_table = '$rc_row[bo_table]' ");

    // 게시글을 복구
    include_once("$g4[bbs_path]/move2_update.php");
    
    // 휴지통의 정보를 삭제
    $sql2 = " delete from $g4[recycle_table] where rc_no = '$rc_no' ";
    sql_query($sql2);

    goto_url("./recycle_list.php?$qstr");
}
