<?
include_once("./_common.php");

if (!$member[mb_id]) 
    alert_close("회원만 이용하실 수 있습니다.");

if (!$member[mb_open] && $is_admin != "super" && $member[mb_id] != $mb_id) 
    alert_close("자신의 정보를 공개하지 않으면 다른분의 정보를 조회할 수 없습니다.\\n\\n정보공개 설정은 회원정보수정에서 하실 수 있습니다.");

//$mb = get_member($mb_id);
$mb = get_member($mb_id, "mb_id, mb_level, mb_point, mb_homepage, mb_open, mb_nick, mb_datetime, mb_today_login, mb_profile, mb_memo");

if (!$mb['mb_id'])
    alert_close("회원정보가 존재하지 않습니다.\\n\\n탈퇴하였을 수 있습니다.");

// 비공개 회원의 정보는 보여주기 않기
if (!$mb['mb_open'] && $is_admin != "super" && $member['mb_id'] != $mb_id) {
    //$mb['mb_level'] = "";
    //$mb['mb_point'] = "";
    $mb['mb_profile'] = "";
    $mb['mb_homepage'] = "";
    $mb['mb_datetime'] = "";
    $mb['mb_today_login'] = "";
}

// 추천 정보를 보여주기 (항상...)
$mb['mb_good'] = 0;
$sql = " select count(*) as cnt from $g4[board_good_table] where wr_mb_id = '$mb_id' and bg_flag = 'good' ";
$result = sql_fetch($sql);
if ($result['cnt'] > 0)
    $mb['mb_good'] = $result['cnt'];

// 비추천 정보를 보여주기 (본인과 관리자만...)
$mb['mb_nogood'] = 0;
if ($is_member && ( $member['mb_id'] == '$mb_id' || $is_admin == 'super')) {
    $sql = " select count(*) as cnt from $g4[board_good_table] where wr_mb_id = '$mb_id' and bg_flag = 'nogood' ";
    $result = sql_fetch($sql);
    if ($result['cnt'] > 0)
        $mb['mb_nogood'] = $result['cnt'];
}

$g4[title] = $mb[mb_nick] . "님의 자기소개";
include_once("$g4[path]/head.sub.php");

$mb_nick = get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage], $mb[mb_open]);

// 회원가입후 몇일째인지? + 1 은 당일을 포함한다는 뜻
$sql = " select (TO_DAYS('$g4[time_ymdhis]') - TO_DAYS('$mb[mb_datetime]') + 1) as days ";
$row = sql_fetch($sql);
$mb_reg_after = $row[days];

$mb_homepage = set_http($mb[mb_homepage]);
$mb_profile = $mb[mb_profile] ? conv_content($mb[mb_profile],0) : "소개 내용이 없습니다.";

echo "<script type='text/javascript' src='$g4[path]/js/sideview.js'></script>";

$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";
include_once("$member_skin_path/profile.skin.php");

include_once("$g4[path]/tail.sub.php");
?>
