<?
$sub_menu = "200500";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

if ($is_admin != "super")
    alert("회원 레벨정보 관리는 최고관리자만 가능합니다.");

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
		$k = $_POST[chk][$i];

		$member_level   = (int)$_POST[member_level][$k];
		$use_levelup    = (int)$_POST[use_levelup][$k];
		$use_leveldown  = (int)$_POST[use_leveldown][$k];
    $up_days        = (int)$_POST[up_days][$k];
    $up_point       = (int)$_POST[up_point][$k];
		$up_post        = (int)$_POST[up_post][$k];
		$up_post_all    = (int)$_POST[up_post_all][$k];
		$up_audit_days  = (int)$_POST[up_audit_days][$k];
    $down_point     = (int)$_POST[down_point][$k];
		$down_post      = (int)$_POST[down_post][$k];
		$down_post_all  = (int)$_POST[down_post_all][$k];
		$down_audit_days= (int)$_POST[down_audit_days][$k];
 		$good           = (int)$_POST[good][$k];
		$nogood         = (int)$_POST[nogood][$k];
		$singo          = (int)$_POST[singo][$k];

    $sql = " update $g4[member_level_table]
                set 
                    use_levelup     = '$use_levelup',
                    use_leveldown   = '$use_leveldown',
                    up_days         = '$up_days',
                    up_point        = '$up_point',
                    up_post         = '$up_post',
                    up_post_all     = '$up_post_all',
                    up_audit_days   = '$up_audit_days',
                    down_point      = '$down_point',
                    down_post       = '$down_post',
                    down_post_all   = '$down_post_all',
                    down_audit_days = '$down_audit_days',
                    good            = '$good',
                    nogood          = '$nogood',
                    singo           = '$singo'
              where member_level = '$member_level' ";
    sql_query($sql);
}

goto_url("./member_level_list.php");
?>
