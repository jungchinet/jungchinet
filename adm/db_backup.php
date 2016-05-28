<?
$sub_menu = "300100";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g4[title] = "db 백업";

// 백업받을 파일 이름, 날짜로 해줍니다.
$filename = $_SERVER['HTTP_HOST']."_".$g4[table_prefix]."_".date("Ymd").".sql";

// === 프로그램 소스, http://davidwalsh.name/backup-mysql-database-php
function backup_tables($table_prefix) {

    global $g4;

    $sql = "SHOW TABLES like '$table_prefix%'";
    $result = sql_query($sql);

    $tables = array();
    while($row = sql_fetch_array($result)) {
        // 테이블 컬럼의 이름이 임의로 바뀌어서, 배열을 implode해야 값이 나온다. 
        // 배열의 컬럼이 1개일 때는 implode, 2개 이상은 array_values를 쓰는게 좋다.
        $tables[] = implode($row);
    }

    //cycle through
    foreach($tables as $table) {

        // 테이블의 정의를 출력
        // 혹시 실수할 수 있기 때문에, DROP TABLE 명령을 코멘트로 막아둡니다.
        // 있는데, 테이블 부수고 옛날꺼 올리는 경우 가끔 있거든요.
        //$return.= 'DROP TABLE IF EXISTS '.$table.';';
        $sql = " SHOW CREATE TABLE $table ";
        $row2 = sql_fetch($sql);
        $row2 = array_values($row2);
        echo "\n\n".$row2[1].";\n\n";

        // 테이블의 필드를 출력.
        $result = sql_query('SELECT * FROM '.$table);
        $num_fields = mysql_num_fields($result);

        for ($i = 0; $i < $num_fields; $i++) {
            while($row = sql_fetch_array($result)) {
                $row = array_values($row);
                $return = 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++) 
                {
                  $row[$j] = addslashes($row[$j]);
                  $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
                  if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                  if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";

                // 한번에 echo를 하면 버퍼 문제가 있어서, 찔끔찔끔 해줘야 합니다.
                echo $return;
            }
        }
        echo "\n\n\n";
    }
}

// 제로보드 admin_setup.php에서 가져와서 변형한 코드
function zbDB_Header($filename) {
		global $HTTP_USER_AGENT;
		//if(eregi("msie",$HTTP_USER_AGENT)) $browser="1"; else $browser="0";
		if(preg_match("/msie/i",$HTTP_USER_AGENT)) $browser="1"; else $browser="0";
		header("Content-Type: application/octet-stream");
		if ($browser) {
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Expires: 0");
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
		} else {
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Expires: 0");
			header("Pragma: public");
		}
}

zbDB_Header($filename);
//backup_tables("$g4[table_prefix]");
backup_tables("");
?>
