<?
include_once("./_common.php");

if (!$member[mb_id]) 
    alert_close("회원만 조회하실 수 있습니다.");

$g4[title] = $member[mb_nick] . "님의 $txt 게시글";

if ($head_on)
    include_once("$g4[path]/head.php");
else
    include_once("$g4[path]/head.sub.php");

$sql_search = " where mb_id = '$member[mb_id]' ";
if ($w == "nogood") {
    $txt = "비추천";
    $sql_search .= " and bg_flag = 'nogood' ";
} else {
    $txt = "추천";
    $sql_search .= " and bg_flag = 'good' ";
}

if ($sfl)
    if ($stx !== "all")
        $sql_search .= " and $sfl = '$stx' ";

$sql_common = " from $g4[board_good_table] ";
$sql_order = " order by bg_id desc ";

/*
검색부분...
*/

$sql = " select count(*) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

if ($rows)
    $rows = (int) $rows;
else
    $rows = $config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$list = array();
$sql = " select bg_id, bo_table, bg_id, wr_id , bg_datetime
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $list[$i] = $row;

    $bo_table = $row[bo_table];

    // 순차적인 번호 (순번)
    $list[$i]['num'] = $total_count - ($page - 1) * $rows - $i;

    // 게시판 제목
    extract(get_board($bo_table, "bo_subject"));
    $bo_subject = cut_str($bo_subject, 20);

    // 게시물 제목
    $write = get_write2($bo_table, $row[wr_id], "wr_subject, mb_id, wr_option ");
    $wr_subject = get_text($write['wr_subject']);
    if ($wr_subject == "") 
        $wr_subject = "[글 없음]";
    if (strstr($row[wr_option], "secret"))
        $wr_secret = true;
    else
        $wr_secret = false;

    $list[$i][bo_subject] = $bo_subject;
    $list[$i][wr_subject] = $wr_subject;
    $list[$i][wr_secret] = $wr_secret;

    $list[$i][opener_href] = "$PHP_SELF?sfl=bo_table&stx=$row[bo_table]&$mstr";
    $list[$i][opener_href_wr_id] = "./board.php?bo_table=$row[bo_table]&wr_id=$row[wr_id]";
    $list[$i][del_href] = "./my_good_update.php?w=d&bg_id=$row[bg_id]&page=$page&head_on=$head_on&mnb=$mnb&snb=$snb&bg_good=$bg_good";

    $mb = get_member($write[mb_id], "mb_id, mb_nick, mb_email, mb_homepage");
    $list[$i][mb_id] = $mb[mb_id];
    $list[$i][mb_nick] = get_sideview($mb['mb_id'], $mb[mb_nick], $mb['mb_email'], $mb['mb_homepage']);
}

// 게시판 목록별로 정렬하기
$sql = " select distinct a.bo_table, b.bo_subject from $g4[board_good_table] a left join $g4[board_table] b on a.bo_table=b.bo_table where a.mb_id = '$member[mb_id]' ";
$result = sql_query($sql);
$bo_list = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bo_list[$i] = $row;
}

$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";
include_once("$member_skin_path/good.skin.php");

if ($head_on)
    include_once("$g4[path]/tail.php");
else
    include_once("$g4[path]/tail.sub.php");
?>
