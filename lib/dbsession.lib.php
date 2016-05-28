<?
if (!defined('_GNUBOARD_')) exit;

/*******************************************************************************
    SESSION DB Class

    사용법 : 
    

*******************************************************************************/
class g4_dbsession {
    function open() {
        return true;
    }

    function close() {
        //$this->gc(get_cfg_var("session.gc_maxlifetime"));
        return true;
    }

    function read($id) {
        global $g4;
        $id = mysql_real_escape_string($id);
        $sql = " select ss_data from `{$g4['session_table']}` where ss_id = '$id' ";
        $row = sql_fetch($sql, false);
        // 세션 테이블이 없다면
        // 불당팩 - 기본으로 설치시에. 이후에는 알아서 테이블 설정.
        //if (mysql_errno() == 1146) {
        //    // 세션 테이블을 생성한다.
        //    $sql = " CREATE TABLE `$g4[session_table]` ( `ss_id` CHAR(32) NOT NULL , `ss_data` TEXT NOT NULL , `ss_datetime` DATETIME NOT NULL , PRIMARY KEY (`ss_id`) ) ENGINE = MYISAM ";
        //    sql_query($sql, true);
        //    // 세션 디렉토리와 파일을 모두 삭제한다.
        //    foreach (glob("$g4[path]/data/session/*") as $filename) {
        //        unlink($filename);
        //    }
        //    rmdir("$g4[path]/data/session");
        //}
        return $row['ss_data'];
    }

    function write($id, $data) {
        global $g4;
        $id = mysql_real_escape_string($id);
        $data = mysql_real_escape_string($data);

        //불당팩 - replace into = delete + insert 이므로 index를 만들고 깨는 작업 때문에 속도저하가 되므로 코드를 변경 합니다.
        //$sql = " replace into `{$g4['session_table']}` set ss_id = '$id', ss_data = '$data', ss_datetime = '$g4[time_ymdhis]' ";
        //return sql_query($sql, false);

        $sql = "update $g4[session_table] set ss_datetime = '$g4[time_ymdhis]', ss_data = '$data', ip_addr='$_SERVER[REMOTE_ADDR]', mb_id='$_SESSION[ss_mb_id]' where ss_id = '$id'";
        $result = sql_query($sql);
        // 처음 로그인을 할 때 중복키 오류를 피하기 위해서 - mysql_modified_rows() 함수를 common.lib.php에서 정의하였슴
        if (mysql_modified_rows() ==0) {
            $sql = " insert into $g4[session_table] set ss_id='$id', ss_datetime = '$g4[time_ymdhis]', ss_data = '$data', ip_addr='$_SERVER[REMOTE_ADDR]', mb_id='$_SESSION[ss_mb_id]' ";
            $result = sql_query($sql, false); 
        }
        return $result;
    }

    function destroy($id) {
        global $g4;
        $id = mysql_real_escape_string($id);
        $sql = " delete from `{$g4['session_table']}` where ss_id = '$id' ";
        return sql_query($sql, false);
    }

    function gc($max) {
        global $g4;
        $max = mysql_real_escape_string($max);
        $datetime = date('Y-m-d H:i:s', $g4['server_time'] - $max);
        $sql = " delete from `{$g4['session_table']}` where ss_datetime < '$datetime' ";
        return sql_query($sql, false);
    }
}
?>
