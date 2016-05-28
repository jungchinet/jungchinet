<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$member[mb_id])
    alert("회원만 이용하실 수 있습니다.");

switch ($kind) {
  case 'recv' : // spam 신고
                $sql = " select * from $g4[memo_recv_table] where me_id = '$me_id' ";
                $result = sql_fetch($sql);
                if ($result[me_recv_mb_id] == $member[mb_id]) {} else alert("바르지 못한 사용입니다");

                $sql = " insert into $g4[memo_spam_table] select * from $g4[memo_recv_table] where me_id = '$me_id' and me_recv_mb_id = '$member[mb_id]' ";
                sql_query($sql);

                $sql = " delete from $g4[memo_recv_table] where me_id = '$me_id' ";
                sql_query($sql);
                
                // 신고테이블에 등록하기
                if ($g4['singo_table']) {
                    $bo_table = "@memo";
                    $wr_id = $wr_parent = $me_id;             // 메모 id
                    $write[mb_id] = $result[me_send_mb_id];   // 글쓴이 = 메모 발신자
                    $sg_reason = "스팸쪽지 발송";
                    
                    include("./singo_popin_update.php");
                }
                
                alert("쪽지를 spam 신고 하였습니다.", "./memo.php?kind=spam");
                break;
  case 'spam' : // spam 취소
                $sql = " select * from $g4[memo_spam_table] where me_id = '$me_id' ";
                $result = sql_fetch($sql);
                // 관리자 또는 스팸을 신고한 사람만 취소가 가능
                if ($is_admin || $result[me_recv_mb_id] == $member[mb_id]) {} else alert("바르지 못한 사용입니다");
                
                $sql = " insert into $g4[memo_recv_table] select * from $g4[memo_spam_table] where me_id = '$me_id' and me_recv_mb_id = '$member[mb_id]' ";
                sql_query($sql);

                $sql = " delete from $g4[memo_spam_table] where me_id = '$me_id' ";
                sql_query($sql);

                // 신고테이블에서 삭제하기
                if ($g4['singo_table']) {
                    $result = sql_fetch(" select sg_id from $g4[singo_table] where bo_table = '@memo' and wr_id = '$me_id' ");
                    $sql = " delete from $g4[singo_table] where sg_id = '$result[sg_id]' ";
                    sql_query($sql);
                }

                alert("쪽지를 spam 취소 하였습니다.", "./memo.php?kind=recv");
                break;                
  default : 
    alert("수신함의 쪽지만 spam 신고를 할 수 있습니다.");
}
?>
