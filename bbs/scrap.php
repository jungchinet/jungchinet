<?
include_once("./_common.php");

if (!$member[mb_id]) 
    alert_close("회원만 조회하실 수 있습니다.");

$g4[title] = $member[mb_nick] . "님의 스크랩";

if ($head_on)
    include_once("$g4[path]/head.php");
else
    include_once("$g4[path]/head.sub.php");

$list = array();

$sql_common = " from $g4[scrap_table] where mb_id = '$member[mb_id]' ";
$sql_order = " order by ms_id desc ";

$sql_search = " ";
if ($stx) {
  if ($stx == 'all') {
    $sfl="";
    $stx="";
  } else {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "wr_subject_memo" :
            $sql_search .= " (wr_subject like '%" . $stx ."%' or ms_memo like '%$stx%') ";
            break;
        case "wr_subject" :
            $sql_search .= " ($sfl like '%" . urldecode($stx) ."%') ";
            break;
        case "ms_memo" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
        case "wr_mb_id" :
            $sql1 = " select mb_id from $g4[member_table] where mb_nick like '%$stx%' ";
            $result1 = sql_query($sql1);
            if (count($result1)) {
              for ($i=0; $row1=sql_fetch_array($result1); $i++) {
                $sql_search .= " $sfl = '$row1[mb_id]' or ";
              }
            }
            $sql_search .= " $sfl like '%$stx' ";
            break;
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
  }
}

$sql = " select count(*) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

//$rows = $config[cf_page_rows];
$rows = 12; 
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$list = array();

$sql = " select bo_table, wr_id, ms_id , ms_memo, ms_datetime, wr_subject
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $list[$i] = $row;

    // 순차적인 번호 (순번)
    $num = $total_count - ($page - 1) * $rows - $i;

    // 게시판 제목
    $sql2 = " select bo_subject from $g4[board_table] where bo_table = '$row[bo_table]' ";
    $row2 = sql_fetch($sql2);
    if (!$row2[bo_subject]) $row2[bo_subject] = "[게시판 없음]";

    // 게시물 제목
    $tmp_write_table = $g4[write_prefix] . $row[bo_table];
    $sql3 = " select wr_subject, mb_id, wr_option from $tmp_write_table where wr_id = '$row[wr_id]' ";
    $row3 = sql_fetch($sql3, FALSE);
    $subject = get_text($row3[wr_subject]);
    if (!$row3[wr_subject]) 
        $row3[wr_subject] = "[글 없음]";
    if (strstr($row3[wr_option], "secret"))
        $secret = true;
    else
        $secret = false;

    $mb = get_member($row3[mb_id], "mb_id, mb_nick, mb_email, mb_homepage");
    
    $list[$i][num] = $num;
    $list[$i][opener_href] = "./board.php?bo_table=$row[bo_table]#board";
    $list[$i][opener_href_wr_id] = "./board.php?bo_table=$row[bo_table]&wr_id=$row[wr_id]#board";
    $list[$i][bo_subject] = $row2[bo_subject];
    $list[$i][subject] = $subject;
    $list[$i][secret] = $secret;
    $list[$i][wr_secret] = $subject;
    $list[$i][del_href] = "./scrap_delete.php?ms_id=$row[ms_id]&page=$page&head_on=$head_on&mnb=$mnb&snb=$snb";
    $list[$i][mb_id] = $mb[mb_id];
    $list[$i][mb_nick] = get_sideview($mb['mb_id'], $mb[mb_nick], $mb['mb_email'], $mb['mb_homepage']);

}

$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";
include_once("$member_skin_path/scrap.skin.php");

if ($head_on)
    include_once("$g4[path]/tail.php");
else
    include_once("$g4[path]/tail.sub.php");
?>
