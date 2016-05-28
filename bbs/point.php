<?
include_once("./_common.php");

if (!$member[mb_id]) 
    alert_close("회원만 조회하실 수 있습니다.");

$g4[title] = $member[mb_nick] . "님의 포인트 내역";
include_once("$g4[path]/head.sub.php");

$list = array();

$sql_common = " from $g4[point_table] a left join $g4[board_new_table] b 
                on (a.po_rel_table = b.bo_table and a.po_rel_id = b.wr_id) ";
$sql_where = " where a.mb_id = '".mysql_real_escape_string($member[mb_id])."' ";

if($stx && $sfl && $stx != 'all'){
   $sql_where .= " and a.$sfl = '$stx' ";
}

$sql_order = " order by a.po_id desc ";

$sql = " select count(*) as cnt $sql_common $sql_where ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = $config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.po_point, a.po_datetime, a.po_content, b.bo_table, b.wr_id
                $sql_common
                $sql_where 
                $sql_order
                limit $from_record, $rows ";
$result = sql_query($sql);

$point_list = array();

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $point_list[$i]['po_point'] = $row['po_point'];
    $point_list[$i]['po_datetime'] = $row['po_datetime'];
    $point_list[$i]['po_content'] = $row['po_content'];
    // 게시글의 경우에는 url link를 걸어준다
    if ($row['bo_table'] && $row['wr_id'])
        $point_list[$i]['po_url'] = $g4['bbs_path'] . "/board.php?bo_table=" . $row['bo_table'] . "&wr_id=" . $row['wr_id'];
    else
        $point_list[$i]['po_url'] = "";
}

$bo_str = "<select name='bo_table' onchange=\"location='$g4[bbs_path]/point.php?sfl=po_rel_table&stx='+this.value;\">";
$bo_str .= "<option value='all'>전체목록보기</option>";

$sql = " select distinct po_rel_table from $g4[point_table] where mb_id = '$member[mb_id]' ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {

        // g4_point 테이블과 g4_board 테이블을 left join 하지 않도록 코드 수정
        $row[bo_table] = $row[po_rel_table];
        $temp = sql_fetch(" select bo_subject from $g4[board_table] where bo_table = '$row[po_rel_table]' ");
        if ($temp) 
            $row[bo_subject] = $temp[bo_subject];
        else
            $row[bo_subject] = $row[bo_table];

        $bo_str .= "<option value='$row[bo_table]'";
        if ($sfl=='po_rel_table' and $row['bo_table'] == $stx) $bo_str .= " selected";
        $bo_str .= ">$row[bo_subject]</option>";
}
$bo_str .= "</select>";

$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";
include_once("$member_skin_path/point.skin.php");

include_once("$g4[path]/tail.sub.php");
?>
