<?
include_once("./_common.php");

$g4[title] = "최근 게시물";
include_once("./_head.php");

// 관리자에게는 모두 검색이 가능하게 수정
if ($is_admin)
    $search_sql = "";
else
    $search_sql = " and b.bo_use_search = '1' ";

$sql_common = " from $g4[board_new_table] a left join $g4[board_table] b on (a.bo_table = b.bo_table)
               where (1) $search_sql ";

if ($gr_id)
    $sql_common .= " and a.gr_id = '$gr_id' ";

if ($bo_table_search)
    $sql_common .= " and a.bo_table = '$bo_table_search' ";
  
// 조회 범위 지정
if ($view_type == "a")
    // 모든 글 + 코멘트
    ;
else if ($view_type == "c")
    // 코멘트
    $sql_common .= " and a.wr_is_comment = '1' ";
else 
    // 원글
    $sql_common .= " and a.wr_is_comment = '0' ";

if ($mb_id) {
    if ($mb_id == "_m_")
        $sql_common .= " and a.mb_id = '$member[mb_id]' ";
    else
        $sql_common .= " and a.mb_id = '$mb_id' ";
}

$sql_order = " order by a.bn_id desc ";

$sql = " select count(*) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = $config[cf_new_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$group_select = "<select name=gr_id id=gr_id onchange='select_change();'><option value=''>전체그룹";
$sql = " select gr_id, gr_subject from $g4[group_table] where gr_use_search = 1 order by gr_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $group_select .= "<option value='$row[gr_id]'>$row[gr_subject]";
}
$group_select .= "</select>";

$sql_select = " a.bo_table, a.wr_id, a.wr_parent, a.bn_id, b.bo_1, b.bo_subject, b.gr_id ";
$list = array();
$sql = " select $sql_select
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    // 게시판은 없어지고, 최신글만 남은 경우?
    if (trim($row[bo_table]) == "") {
        $sql = " delete from $g4[board_new_table] where bn_id = '$row[bn_id]' ";
        sql_query($sql);
        continue;
    }

    $tmp_write_table = $g4[write_prefix] . $row[bo_table];

    // group 관련 정보를 가져온다
    $gr_info = get_group($row[gr_id], "gr_subject");
    $row[gr_subject] = $gr_info[gr_subject];

    if ($row[wr_id] == $row[wr_parent]) // 원글
    {
        $comment = "";
        $comment_link = "";
        $comment_id = "";
        $row2 = sql_fetch(" select wr_id, wr_subject, mb_id, wr_name, wr_email, wr_homepage, wr_datetime, wr_comment, wr_1, wr_5 from $tmp_write_table where wr_id = '$row[wr_id]' ");
        $list[$i] = $row2;

        $name = get_sideview($row2[mb_id], cut_str($row2[wr_name], $config[cf_cut_name]), $row2[wr_email], $row2[wr_homepage]);
        // 당일인 경우 시간으로 표시함
        $datetime = substr($row2[wr_datetime],0,10);
        $datetime2 = $row2[wr_datetime];
        if ($datetime == $g4[time_ymd])
            $datetime2 = substr($datetime2,11,5);
        else
            $datetime2 = substr($datetime2,5,5);

    }
    else // 코멘트
    {
        $comment = "[코] ";
        $comment_link = "#c_{$row[wr_id]}";
        $comment_id = $row[wr_id];
        $row2 = sql_fetch(" select wr_id, wr_subject, wr_1, wr_5 from $tmp_write_table where wr_id = '$row[wr_parent]' ");
        $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime from $tmp_write_table where wr_id = '$row[wr_id]' ");
        $list[$i] = $row2;
        $list[$i][mb_id] = $row3[mb_id];
        $list[$i][wr_name] = $row3[wr_name];
        $list[$i][wr_email] = $row3[wr_email];
        $list[$i][wr_homepage] = $row3[wr_homepage];

        $name = get_sideview($row3[mb_id], cut_str($row3[wr_name], $config[cf_cut_name]), $row3[wr_email], $row3[wr_homepage]);
        // 당일인 경우 시간으로 표시함
        $datetime = substr($row3[wr_datetime],0,10);
        $datetime2 = $row3[wr_datetime];
        if ($datetime == $g4[time_ymd])
            $datetime2 = substr($datetime2,11,5);
        else
            $datetime2 = substr($datetime2,5,5);
    }

    $list[$i][gr_id] = $row[gr_id];
    $list[$i][bo_table] = $row[bo_table];
    $list[$i][name] = $name;
    $list[$i][comment] = $comment;
    $list[$i][comment_id] = $comment_id;

    if($_GET['view_type']!='c'){
        $list[$i][href] = "./board.php?bo_table=$row[bo_table]&wr_id=$row2[wr_id]{$comment_link}&qstr=$qstr#board";
    }else{
        $list[$i][href] = "./board.php?bo_table=$row[bo_table]&wr_id=$row2[wr_id]{$comment_link}";
    }

    $list[$i][datetime] = $datetime;
    $list[$i][datetime2] = $datetime2;

    $list[$i][gr_subject] = $row[gr_subject];
    $list[$i][bo_subject] = $row[bo_subject];
    $list[$i][wr_5] = $row2[wr_5];
    if($row2[wr_1]) { $list[$i][bo_1] = $row2[wr_1]; }else{ $list[$i][bo_1] = '전체지역'; }
    $list[$i][wr_subject] = $row2[wr_subject];
}

$write_pages = get_paging($config[cf_write_pages], $page, $total_page, "?gr_id=$gr_id&view_type=$view_type&mb_id=$mb_id&qstr=$qstr&page=");

$new_skin_path = "$g4[path]/skin/new/$config[cf_new_skin]";

echo "<script type=\"text/javascript\" src=\"$g4[path]/js/sideview.js\"></script>\n";

include_once("$new_skin_path/new.skin.php");

include_once("./_tail.php");
?>
