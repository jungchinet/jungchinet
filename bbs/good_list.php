<?
include_once("./_common.php");

$g4[title] = "베스트 게시물";

// 게시글 목록을 위한 회원 레벨 범위 지정
$search_sql = " '$member[mb_level]' >= b.bo_list_level ";

// 검색이 가능한 게시판만 목록을 생성
$search_sql = $search_sql . " and b.bo_use_search = '1' ";

// 게시판이 지정되어 있는 경우
if ($bo_table_search)
    $search_sql .= " and a.bo_table = '$bo_table_search' ";

// 그룹이 지정되어 있는 경우
if ($gr_i)
    $search_sql .= " and a.gr_id = '$gr_id' ";

// 베스트글 조건을 지정
$search_sql .= " and ( a.hit >= b.bo_list_good or (a.good - a.nogood) >= b.bo_list_good or a.comment >= b.bo_list_comment ) ";

//초기화
$gl_flag=0;
if ($is_admin && $_GET['gl_flag']==1)
    $gl_flag=1;

// gl_flag = 1인 필드는 기본적으로 베스트글에서 제외
if ($gl_flag > 0)
    $search_sql .= " and a.gl_flag = 1 ";
else
    $search_sql .= " and a.gl_flag = 0 ";

$sql_common = " from $g4[good_list_table] a left join $g4[board_table] b on (a.bo_table = b.bo_table)
               where $search_sql ";

if ($sst)
    $sql_order = " order by $sst $sod ";
else
    $sql_order = " order by a.wr_datetime desc ";

// 정렬에 사용하는 QUERY_STRING
$qstr2 = "bo_table_search=$bo_table&sop=$sop";

$sql = " select count(*) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = $g4['good_list_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$list = array();
$sql = " select a.gl_id, a.gr_id, a.bo_table, a.wr_id, a.gl_datetime, b.bo_subject
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $tmp_write_table = $g4[write_prefix] . $row[bo_table];

    // group 관련 정보를 가져온다
    $gr_info = get_group($row[gr_id], "gr_subject");

    // 게시글 정보를 가져온다
    $row2 = sql_fetch(" select wr_id, wr_subject, mb_id, wr_name, wr_email, wr_homepage, wr_datetime, wr_hit, wr_good, wr_nogood, wr_comment from $tmp_write_table where wr_id = '$row[wr_id]' ");
    $list[$i] = $row2;
    
    // 없는게 있으면 목록에서 지워준다.
    if (!$row2)
        sql_query(" delete from $g4[good_list_table] where gl_id = '$row[gl_id]' ");

    $name = get_sideview($row2[mb_id], cut_str($row2[wr_name], $config[cf_cut_name]), $row2[wr_email], $row2[wr_homepage]);
    $list[$i][name] = $name;
    $list[$i][href] = "./good_view.php?bo_table=$row[bo_table]&wr_id=$row2[wr_id]&page=$page&bo_table_search=$bo_table_search&qstr=$qstr";
    $list[$i][wr_datetime2] = get_datetime($row2[wr_datetime]);

    $list[$i][gr_id] = $row[gr_id];
    $list[$i][gr_subject] = $gr_info[gr_subject];

    $list[$i][bo_table] = $row[bo_table];
    $list[$i][bo_subject] = $row[bo_subject];

    $list[$i][gl_id] = $row[gl_id];
    $list[$i][gl_datetime] = $row[gl_datetime];
}

$write_pages = get_paging($config[cf_write_pages], $page, $total_page, "./good_list.php?gr_id=$gr_id&bo_table=$bo_table&qstr=$qstr&page=");

if (!$wr_id)
    include_once($g4[good_list_head]);

$good_list_skin_path = "$g4[path]/skin/good_list/$g4[good_list_skin]";
include_once("$good_list_skin_path/good_list.skin.php");

if (!$wr_id)
    include_once($g4['good_list_tail']);
?>
