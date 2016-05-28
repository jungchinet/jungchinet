<?php
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if($is_admin == 'super'){
  	$dir="$g4[path]/data/memo2/";
	  $dp=@opendir($dir);
  	$i=0;
  	while($subdir=readdir($dp))	//서브폴더 검색
	  {
		    if($subdir!="." and $subdir!="..")
    		{
		      	if(is_dir($dir.$subdir))
        				$type="folder";
      			else
        				$type="document";

      			if($type=="folder")//폴더일경우에 내부 파일들 검색
      			{
        				$sdp=@opendir($dir.$subdir.'/');
        				while($file=readdir($sdp))	//실제 파일 검색
        				{
          					if($file!="." and $file!="..")
          					{
            						if(is_dir($dir.$subdir.'/'.$file))
              							$stype="folder";
            						else
              							$stype="document";

        						    if($stype!=="folder")//파일일경우 DB 검사후 결과 없을때 삭제
    				        		{
              							if(chkDel($subdir.'/'.$file))
				    	        			$i++;
        		    				}
					          }
				        }
			      }
		    }
	  }
	  closedir($dp);
	  alert($i.' 건의 데이터를 삭제하였습니다.',"./memo.php?kind=memo_config");
}
else
	  alert('잘못된 접근 또는 권한이 없습니다.',"./memo.php?kind=memo_config");

// 첨부파일 검출 및 삭제(by Lusia) - 아랫부분은 bbs/memo2_form_delete.php, memo2_form_delete_all_trash.php, memo2_chkunlinkfile.php에 공통입니다
function chkDel($chkFile){
  	global $g4;

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
	     	$filepath="$g4[path]/data/memo2/" . $member[mb_id] . "/" . $chkFile;
    		$file_deleted_dir = "$g4[path]/data/memo2_deleted/" . $member[mb_id] . "/";
    		$file_deleted_path = $file_deleted_dir . $chkFile;
        // 회원별로 디렉토리를 생성
  			if(!is_dir($file_deleted_dir)){
    				@mkdir($file_deleted_dir, 0707);
		    		@chmod($file_deleted_dir, 0707);
    		}
		    @copy($filepath, $file_deleted_path);  //임시폴더로 복사
    	  @unlink($filepath);
    		return true;
    }
	  else
		    return false;
}
?>
