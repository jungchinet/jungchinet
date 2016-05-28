<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$member[mb_id])
    alert("회원만 이용하실 수 있습니다.");

$mb_id = $member['mb_id'];

switch ($kind) {
  case 'recv' : $sql = " select me_recv_mb_id from $g4[memo_recv_table] where me_id='$me_id' and memo_owner='$mb_id' ";
                $result = sql_fetch($sql);
                if ($result[me_recv_mb_id] == $mb_id) {} else alert("바르지 못한 사용입니다");

                // 수신자/발신자가 모두 save를 하려고 하면 me_id 중복으로 save가 되지 않습니다.
                // me_id+memo_owner를 primary key로 지정 
                // ALTER TABLE `g4_memo_save` DROP PRIMARY KEY , ADD PRIMARY KEY ( `me_id` , `memo_type` ) 
                $sql = " select count(*) as cnt from $g4[memo_save_table] where me_id = '$me_id' and memo_type = 'recv' and memo_owner='$mb_id' ";
                $result = sql_fetch($sql);
                if ($result[cnt] > 0) alert("이미 저장된 쪽지 입니다. 운영자에게 문의하시기 바랍니다.");
                
                $sql = " insert into $g4[memo_save_table] select * from $g4[memo_recv_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                sql_query($sql);

                $sql = " delete from $g4[memo_recv_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                sql_query($sql);
                break;
  case 'send' : $sql = " select me_send_mb_id from $g4[memo_send_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                $result = sql_fetch($sql);
                if ($result[me_send_mb_id] == $mb_id) {} else alert("바르지 못한 사용입니다");

                $sql = " select count(*) as cnt from $g4[memo_save_table] where me_id = '$me_id' and memo_type = 'recv' and memo_owner='$mb_id' ";
                $result = sql_fetch($sql);
                if ($result[cnt] > 0) alert("이미 저장된 쪽지 입니다. 운영자에게 문의하시기 바랍니다.");
                
                $sql = " insert into $g4[memo_save_table] select * from $g4[memo_send_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                sql_query($sql);

                $sql = " delete from $g4[memo_send_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                sql_query($sql);
                break;
  default : 
    alert("수신/발신함의 쪽지만 저장이 가능 합니다.");
}

alert("쪽지를 저장하였습니다.", "./memo.php?kind=save");
?>
