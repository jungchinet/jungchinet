<?
if (!defined('_GNUBOARD_')) exit;

// 그누보드 왔숑~ 추출
function whatson($skin_dir="", $rows=5, $subject_len=25, $page=1, $options="", $target="", $check="", $head="")
{
    global $g4, $member, $config;

    if ($skin_dir)
        $whatson_skin_path = "$g4[path]/skin/whatson/$skin_dir";
    else
        $whatson_skin_path = "$g4[path]/skin/whatson/basic";

   if ($target)
      $target_link = "target=" . $target;

    $list = array();

    // 비회원의 경우에는 왔숑~할 것이 없습니다.
    if (!$member[mb_id])
        return;

    // 왔숑~의 전체 갯수를 구합니다.
    $sql = " select count(*) as cnt from $g4[whatson_table] where mb_id='$member[mb_id]' ";
    $result = sql_fetch($sql);

    $total_count = $result[cnt];

    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산

    $from_record = ($page - 1) * $rows; // 시작 열을 구함
    $limit_sql = " limit $from_record, $rows ";

    $write_pages = get_paging($config[cf_write_pages], $page, $total_page, "$g4[bbs_path]/whatson.php?head=1&page=");

    $sql = " select * from $g4[whatson_table] where mb_id='$member[mb_id]' order by wo_datetime desc $limit_sql ";
    $result = sql_query($sql);

    // 결과값을 $list에 넣습니다. 스킨 코드가 심플하게 되게
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $list[$i] = $row;
        
        if ($check == 1)
            $list[$i][subject] = $row[wr_subject];
        else
            $list[$i][subject] = cut_str($row[wr_subject], $subject_len);
        if ($row[bo_table] && $row[wr_id])
            $list[$i][url] = "$g4[bbs_path]/board.php?bo_table=$row[bo_table]&wr_id=$row[wr_id]";
        if ($row[comment_id])
            $list[$i][url] .= "#c_" . $row[comment_id];
        $list[$i][datetime] = get_datetime($row[wo_datetime]);
    }

    ob_start();
    include "$whatson_skin_path/whatson.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
