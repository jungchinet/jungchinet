<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

$mb_id = $member['mb_id'];

$tmp_array = array();
if ($me_id) { // 건별 삭제
    $tmp_array[0] = $me_id;
} else { // 전체삭제
    $tmp_array = $_POST['chk_me_id'];
}

if ($g4['memo_delete']) {
    $memo_delete = " and memo_owner='$member[mb_id]' ";
}

for ($i=count($tmp_array)-1; $i>=0; $i--) // 높은거에서 낮은거로. 왜? sir 원본이 그렇게 되어 있으니까 ㅠ..ㅠ
{
  switch ($kind) {
  case 'recv' : $sql = " select * from $g4[memo_recv_table] where me_id = '$tmp_array[$i]' ";
                $result = sql_fetch($sql);
                if ($result['me_recv_mb_id'] == $member['mb_id']) {} else alert("바르지 못한 사용입니다");

                // trash에 쪽지를 넣어두기
                $me = sql_fetch("select * from $g4[memo_send_table] where me_id = '$tmp_array[$i]' and me_recv_mb_id='$member[mb_id]' $memo_delete ");
                $sql = " insert into $g4[memo_trash_table]
                            set 
                                me_id = '$me[me_id]',
                                me_recv_mb_id = '$me[me_recv_mb_id]',
                                me_send_mb_id = '$me[me_send_mb_id]',
                                me_send_datetime = '$me[me_send_datetime]',
                                me_read_datetime = '$me[me_read_datetime]',
                                me_memo = '$me[me_memo]',
                                me_file_local = '$me[me_file_local]',
                                me_file_server = '$me[me_file_server]',
                                me_subject = '$me[me_subject]',
                                memo_type = '$me[memo_type]',
                                memo_owner = '$member[mb_id]',
                                me_option = '$me[me_option]',
                                me_from_kind = 'recv' ";
                sql_query($sql, FALSE);

                $sql = " delete from $g4[memo_recv_table] where me_id = '$tmp_array[$i]' and me_recv_mb_id='$member[mb_id]' $memo_delete ";
                sql_query($sql);
                break;
  case 'send' : 
                memo4_cancel($tmp_array[$i]);
                break;
  case 'save' : $sql = " select memo_owner, memo_type from $g4[memo_save_table] where me_id = '$tmp_array[$i]' and memo_owner='$mb_id' limit 1";
                $result = sql_fetch($sql);
                if ($result['memo_owner'] == $member['mb_id']) {} else alert("바르지 못한 사용입니다");

                // trash에 쪽지를 넣어두기
                $me = sql_fetch("select * from $g4[memo_save_table] where me_id = '$tmp_array[$i]' and memo_type = '$result[memo_type]' $memo_delete ");
                $sql = " insert into $g4[memo_trash_table]
                            set 
                                me_id = '$me[me_id]',
                                me_recv_mb_id = '$me[me_recv_mb_id]',
                                me_send_mb_id = '$me[me_send_mb_id]',
                                me_send_datetime = '$me[me_send_datetime]',
                                me_read_datetime = '$me[me_read_datetime]',
                                me_memo = '$me[me_memo]',
                                me_file_local = '$me[me_file_local]',
                                me_file_server = '$me[me_file_server]',
                                me_subject = '$me[me_subject]',
                                memo_type = '$me[memo_type]',
                                memo_owner = '$member[mb_id]',
                                me_option = '$me[me_option]',
                                me_from_kind = 'save' ";
                sql_query($sql, FALSE);

                $sql = " delete from $g4[memo_save_table] where me_id = '$tmp_array[$i]' and memo_type = '$result[memo_type]' $memo_delete  ";
                sql_query($sql);
                break;
  case 'spam' : $sql = " select * from $g4[memo_spam_table] where me_id = '$tmp_array[$i]' ";
                $result = sql_fetch($sql);
                
                // 스팸의 경우에는 trash를 거치지 않고 바로 삭제
                if ($result['memo_owner'] == $member['mb_id'])
                    $sql = " delete from $g4[memo_spam_table] where me_id = '$tmp_array[$i]' and me_recv_mb_id='$member[mb_id]' ";
                else if ($is_admin)
                    $sql = " delete from $g4[memo_spam_table] where me_id = '$tmp_array[$i]' and me_recv_mb_id='$result[memo_owner]' ";
                else 
                    alert("바르지 못한 사용입니다");
                sql_query($sql);
                break;
  case 'trash' :$sql = " select * from $g4[memo_trash_table] where me_id = '$tmp_array[$i]' ";
                $result = sql_fetch($sql);
                
                // 휴지통의 경우에는 바로 삭제
                if ($result['memo_owner'] == $member['mb_id'])
                    $sql = " delete from $g4[memo_trash_table] where me_id = '$tmp_array[$i]' and memo_owner='$member[mb_id]' ";
                else if ($is_admin)
                    $sql = " delete from $g4[memo_trash_table] where me_id = '$tmp_array[$i]' ";
                else 
                    alert("바르지 못한 사용입니다");
                sql_query($sql);

                // 첨부파일이 있는 경우에만 파일 삭제를 진행
        				// 첨부파일 검출 및 삭제(by Lusia) - 아랫부분은 bbs/memo2_form_delete.php, memo2_form_delete_all_trash.php, memo2_chkunlinkfile.php에 공통입니다
                $file_name = $result['me_file_server'];
                if ($file_name) {

                    $sql = "  select count(*) as cnt from $g4[memo_recv_table] where me_file_server='$file_name'
                              union all 
                              select count(*) as cnt from $g4[memo_save_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_send_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_spam_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_temp_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_trash_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_notice_table] where me_file_server='$file_name'
                            ";
                    $result_set = sql_query($sql);
                    $cnt_sum = 0;
                    while($row = sql_fetch_array($result_set))
                        $cnt_sum += $row['cnt'];

                  	//DB에 해당 첨부파일 정보 없을경우 삭제 (첨부파일은 보낸 사람의 디렉토리에만 저장됩니다)
                	  if ($cnt_sum) {
            	         	$filepath="$g4[data_path]/memo2/$file_name";
                    		$file_deleted_dir = "$g4[data_path]/memo2_deleted/" . $member['mb_id'] . "/";
                    		$file_deleted_path = "$g4[data_path]/memo2_deleted/$file_name";
                        // 회원별로 디렉토리를 생성
                  			if(!is_dir($file_deleted_dir)){
                    				@mkdir($file_deleted_dir, 0707);
            		        		@chmod($file_deleted_dir, 0707);
                    		}
                		    @copy($filepath, $file_deleted_path);  //임시폴더로 복사
                    	  @unlink($filepath);
                    }
                }
                break;
  case 'notice': $sql = " select * from $g4[memo_notice_table] where me_id = '$tmp_array[$i]' ";
                $result = sql_fetch($sql);
                if ($result['memo_owner'] == $member['mb_id'] or $is_admin) {} else alert("바르지 못한 사용입니다");

                // 공지의 경우 관리자의 작업이므로 trash를 거치지 않고 바로 삭제
                $sql = " delete from $g4[memo_notice_table] where me_id = '$tmp_array[$i]' ";
                sql_query($sql);
                break;
  default : 
    alert("쪽지를 삭제할 수 없습니다. 관리자에게 문의하시기 바랍니다.");
    
  } // end of switch
} // end of for loop

if ($kind == "recv") {

    // 안읽은 쪽지 갯수를 업데이트
    $sql1 = " select count(*) as cnt from $g4[memo_recv_table] 
               where me_recv_mb_id = '$member[mb_id]' and me_read_datetime = '0000-00-00 00:00:00' ";
    $row1 = sql_fetch($sql1);
    sql_query(" update $g4[member_table] set mb_memo_unread = '$row1[cnt]' where mb_id = '$member[mb_id]' ");
}

alert("쪽지를 삭제하였습니다.", "./memo.php?kind=$kind");
?>
