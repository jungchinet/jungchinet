<?
include_once("./_common.php");

$po_id = (int) $_POST[po_id];
$mb_id = $member[mb_id];

if ($w == "add") 
{
    if (!$mb_id)
        alert("회원만 참여가능 합니다. 로그인 하시기 바랍니다");

    // 이벤트에는 한번만 참여 가능
    $sql = " select count(*) as cnt from $g4[promotion_sign_table] where po_id = '$po_id' and mb_id = '$mb_id' ";
    $my = sql_fetch($sql);
    if ($my[cnt] > 1)
        alert("이벤트 참여 횟수를 초과 했습니다. 이벤트 참여 결과를 확인해 주세요.", "./promotion.php");

    // 비밀번호 생성
    $po_password = rand(1000, 9999); 

    // url를 생성
    $po_url = time() . "_" . sql_password($po_password);

    // promotion 신청 정보를 insert
    $sql = " insert $g4[promotion_sign_table] set 
                    po_id = '$po_id',
                    mb_id = '$mb_id',
                    po_datetime = '$g4[time_ymdhis]',
                    po_password = '$po_password',
                    po_url = '$po_url'
            ";
    sql_query($sql);

    goto_url("./promotion.php?");
} if ($w == "check") {
  
    $sql = " select * from $g4[promotion_sign_table] where po_url = '$po_url' and po_password = '$po_password' ";
    $my = sql_fetch($sql);

    if ($my[po_id]) {
        $mb = get_member($my[mb_id] , "mb_nick");
        $po = sql_fetch(" select * from $g4[promotion_table] where po_id = '$my[po_id]'");
        echo "$mb[mb_nick] 님은 $po[po_name] 에 참여 했습니다.";
    } else {
        alert("유효하지 않은 프로모션 정보 입니다");
    }
}
?>
