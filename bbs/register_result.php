<?
include_once("./_common.php");

$mb = get_member($_SESSION[ss_mb_reg]);
// 회원정보가 없다면 초기 페이지로 이동
if (!$mb[mb_id]) 
    goto_url($g4[path]);

$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";

$g4[title] = "회원가입결과";
include_once("./_head.php");

// 불당팩 - 회원님께 쪽지 발송, 회원가입시 register_form_update.php에서 mb_memo_call을 설정하지 않고 이곳에서 설정
if ($config[cf_memo_mb_member]) 
{
    $me_recv_mb_id = $mb[mb_id];
    $me_send_mb_id = $config[cf_admin];
    
    $sql = " update $g4[member_table]
                set mb_memo_call = concat(mb_memo_call, concat(' ', '$me_send_mb_id'))
              where mb_id = '$me_recv_mb_id' ";
    sql_query($sql);
}

include_once("$member_skin_path/register_result.skin.php");
include_once("./_tail.php");

?>
