<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$member[mb_id])
    alert("회원만 이용하실 수 있습니다.");

if ($config['cf_memo_del_file']) {
    // 첨부파일 검출 및 삭제(by Lusia)
    $sql = " select distinct me_file_server from $g4[memo_trash_table] where memo_owner = '$member[mb_id]' ";
    $filelist=sql_query($sql);
}

// 휴지통 삭제
$sql = " delete from $g4[memo_trash_table] where memo_owner = '$member[mb_id]' ";
sql_query($sql);

// 첨부파일 검출 및 삭제(by Lusia) - 아랫부분은 bbs/memo2_form_delete.php, memo2_form_delete_all_trash.php, memo2_chkunlinkfile.php에 공통입니다
if ($filelist) {
while($result=mysql_fetch_assoc($filelist)){
    $file_name = $result[me_file_server];
    
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
                        $cnt_sum += $row[cnt];

   	//DB에 해당 첨부파일 정보 없을경우 삭제 (첨부파일은 보낸 사람의 디렉토리에만 저장됩니다)
 	  if ($cnt_sum) {
       	$filepath="$g4[path]/data/memo2/$file_name";
     		$file_deleted_dir = "$g4[path]/data/memo2_deleted/" . $member[mb_id] . "/";
     		$file_deleted_path = "$g4[path]/data/memo2_deleted/$file_name";
        // 회원별로 디렉토리를 생성
   			if(!is_dir($file_deleted_dir)){
     				@mkdir($file_deleted_dir, 0707);
 		    		@chmod($file_deleted_dir, 0707);
     		}
 		    @copy($filepath, $file_deleted_path);  //임시폴더로 복사
     	  @unlink($filepath);
    }
}
}

alert("쪽지를 삭제하였습니다.", "./memo.php?kind=trash");
?>
