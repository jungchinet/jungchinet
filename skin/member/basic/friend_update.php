<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

$mb_id      = $_POST['mb_id'];
$fr_memo    = $_POST['fr_memo'];
$chk_fr_no  = $_POST['chk_fr_no'];

if ( count($chk_fr_no) == 0) { // 입력에 의한 것이기 때문에회원 존재 여부를 check 한다
    if ($mb_id == $fr_id)
        alert("자신은 등록할 수 없습니다.");

    $mb = get_member($mb_id);
    $fr = get_member($fr_id);
    
    if (!$mb['mb_id'] or !$fr['mb_id'])
        alert("존재하는 회원아이디가 아닙니다."); 

    if ($mb['mb_id'] == $member['mb_id']) {} else alert("본인의 정보만 업데이트 할 수 있습니다");
    
    $sql = " select count(*) as cnt from $g4[friend_table] where mb_id = '$mb_id' and fr_id = '$fr_id' ";
    $result = sql_fetch($sql);
    if ($result['cnt'] > 0) alert("이미 등록된 친구 입니다");

    // 중복된 친구등록은 db에서 2차 방어 (mb_id + fr_id = unique)
    if ($fr_type == 'black_id')
        $sql = " insert $g4[friend_table] set mb_id = '$mb_id', fr_id = '$fr_id', fr_memo = '$fr_memo', fr_datetime = now(), fr_type = '$fr_type' ";
    else
        $sql = " insert $g4[friend_table] set mb_id = '$mb_id', fr_id = '$fr_id', fr_memo = '$fr_memo', fr_datetime = now() ";
    sql_query($sql, $error);
    
} else {
  
    for ($i=0; $i < count($chk_fr_no); $i++) {
        if ($fr_type == 'online') {
            $fr_id = $chk_fr_no[$i];
        } else { 
            $sql1 = " select * from $g4[friend_table] where fr_no = '$chk_fr_no[$i]' "; // fr_no를 기준으로 친구의 mb_id를 구함
            $result1 = sql_fetch($sql1);
            $fr_id = $result1['mb_id'];
        }
        
        $mb_id = $member['mb_id'];

        if ($mb_id == $fr_id)
            alert("자신은 등록할 수 없습니다.");

        $mb = get_member($mb_id);
        $fr = get_member($fr_id);

        if (!$mb['mb_id'] or !$fr['mb_id'])
            alert("존재하는 회원아이디가 아닙니다."); 

        if ($mb['mb_id'] == $member['mb_id']) {} else alert("본인의 정보만 업데이트 할 수 있습니다");

        $sql = " select count(*) as cnt from $g4[friend_table] where mb_id = '$member[mb_id]' and fr_id = '$fr_id' "; // 중복된 친구인지 확인
        $result = sql_fetch($sql);
        
        if ($fr_type == 'black_id' and $result['cnt'] > 0) { // 이미 친구인데 블랙리스트로 등록할 경우
            $sql2 = " update $g4[friend_table] set fr_type = 'black_id' where mb_id = '$member[mb_id]' and fr_id = '$result1[mb_id]'";
            sql_query($sql2);
        } else {
            if ($fr_type == 'black_id') {
                $sql = " insert $g4[friend_table] set mb_id = '$member[mb_id]', fr_id = '$fr_id', fr_memo = '', fr_datetime = now(), fr_type = 'black_id' "; 
                sql_fetch($sql);            
            } else {
                if ($result['cnt'] > 0) alert("이미 등록된 친구 입니다.");
                $sql = " insert $g4[friend_table] set mb_id = '$member[mb_id]', fr_id = '$fr_id', fr_memo = '', fr_datetime = now() "; 
                sql_fetch($sql);
           }
        }
    }
}

goto_url("$g4[bbs_path]/memo.php?kind=$kind&fr_type=$fr_type");
?>
