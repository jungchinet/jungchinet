<?
$sub_menu = "100520";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "r");

$g4[title] = "home info";
include_once("./admin.head.php");

// http://sir.co.kr/bbs/board.php?bo_table=g4_tiptech&wr_id=656
//
// db용량에 대해서 : http://appleis.tistory.com/507
// safe_mode에 대해서 : http://us2.php.net/features.safe-mode

function size($size) {
	if(!$size) return "0 Byte";
	if($size < 1024) {
		return "$size Byte";
	} elseif($size >= 1024 && $size < 1024 * 1024) {
		return sprintf("%0.1f",$size / 1024)." KB";
	} elseif($size >= 1024 * 1024 && $size < 1024 * 1024 * 1024) {
		return sprintf("%0.1f",$size / 1024 / 1024)." MB";
	} else {
		return sprintf("%0.1f",$size / 1024 / 1024 / 1024)." GB";
	}
}

// safe 모드인지 확인. safe모드에서는 수행이 안되는 명령이 있슴
// ini_get("safe_mode")의 값이 잘 안나와서...
$sm = @exec("hostname");
if ($sm)
    $safe_mode = true;
else
    $safe_mode = false;

// 현재의 계정
$user_id = get_current_user(); 

// os 정보
$os_version = php_uname('r');

if ($safe_mode) {

// 서버의 ip
$ip_addr = @gethostbyname(trim(@exec("hostname")));

// 계정의 사용량을 구함 
$account_space = exec("du -sb $g4[path]"); 
$account_space = substr($account_space,0,strlen($account_space)-3); 

// DATA 폴더의 용량을 구함 
$data_space = exec("du -sb $g4[data_path]"); 
$data_space = substr($data_space,0,strlen($data_space)-8); 

} // end of safe_mode

// Apache 웹서버 버젼
if (function_exists("apache_get_version")) {
    $apache_version = apache_get_version();

    // Apache 모듈 내역
    $apache_m = @apache_get_modules();
    $apache_modules = "";
    $i = 1;
    foreach ($apache_m as $row) {
        $apache_modules .= $row . " ";
        if ($i == 5) {
            $apache_modules .= "<br>";
            $i = 1;
        } else
            $i++;
    }
}

// PHP 버젼
$php_version = phpversion();

// Zend 버젼
$zend_version = zend_version();

// GD 버젼
$gd_support = extension_loaded('gd');
if ($gd_support) {
    $gd_info = gd_info();
    $gd_version = $gd_info['GD Version'];
} else {
    $gd_support = "GD가 설치되지 않음";
}

// 업로드 가능한 최대 파일사이즈
$max_filesize = get_cfg_var('upload_max_filesize');

// MySQL 버젼
$m_version = sql_fetch(" select version() as ver");

// MySQL Stat - http://kr2.php.net/manual/kr/function.mysql-stat.php
$mysql_stat = explode('  ', mysql_stat());

// MYSQL DB의 사용량을 구함 
$result = sql_query("SHOW TABLE STATUS"); 
$db_using = 0;
$db_count = 0;
$db_rows = 0;
while($dbData=mysql_fetch_array($result)) { 
    $db_using += $dbData[Data_length]+$dbData[Index_length];
    $db_count++;
    $db_rows += $dbData[Rows];
} 

// 전체 게시판 갯수
$count_board = sql_fetch(" select count(*) as cnt from $g4[board_table] ");

// 전체 게시글 수
$result = sql_query(" select bo_table from $g4[board_table] ");
$count_board_article = 0;
$count_board_comment = 0;
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $tmp_write_table = $g4['write_prefix'] . $row[bo_table]; // 게시판 테이블 전체이름
    $t_sum = sql_fetch(" select count(*) as cnt from $tmp_write_table ");
    $count_board_article += $t_sum[cnt];
    $t_sum = sql_fetch(" select count(*) as cnt from $tmp_write_table where wr_is_comment = 1 ");
    $count_board_comment += $t_sum[cnt];
}

// 오늘 새로 누적된 포인트와 총 누적된 포인트를 구함 
$all_point = sql_fetch(" select sum(po_point) as sum from $g4[point_table] ");
$new_point = sql_fetch(" select sum(po_point) as sum from $g4[point_table] WHERE date_format( po_datetime, '%Y-%m-%d' ) = '$g4[time_ymd]'");

// 모든 게시판에 첨부된 파일의 갯수를 구함 
$count_data = sql_fetch("select count(*) as cnt from $g4[board_file_table]"); 

// 새 회원 수와 총 회원 수를 구함 
$count_member = sql_fetch(" select count(*) as cnt from $g4[member_table] where mb_leave_date = '' "); 
$new_member = sql_fetch(" select count(*) as cnt from $g4[member_table] where mb_open_date = '$g4[time_ymd]' "); 
?>

<table cellpadding=0 cellspacing=0 width=420> 
<colgroup width=160>
<colgroup width=''>
<tr> 
    <td align=left colspan=2>
    <b>계정 정보</b>
    </td> 
</tr>
<tr height=15px><td></td></tr>
<tr> 
    <td>사용자 id</td>
    <td><?=$user_id?></td>
</tr>
<tr>
    <td>서버 운영시스템</td>
    <td><?=PHP_OS?></td>
</tr>
<tr>
    <td>서버 운영시스템 버젼</td>
    <td><?=$os_version?></td>
</tr>

<tr> 
    <td>서버 시간</td>
    <td><?=$g4['time_ymdhis']?></td>
</tr>
<? if (function_exists("date_default_timezone_get")) { ?>
<tr>
    <td>Default Time Zone</td>
    <td><?=date_default_timezone_get()?></td>
</tr>
<? } ?>

<? if ($safe_mode) { ?>
<tr> 
    <td>hostname</td>
    <td><?=$sm;?></td>
</tr>
<tr> 
    <td>ip 주소</td>
    <td><?=$ip_addr?></td>
</tr>

<tr height=15px><td></td></tr>
<tr> 
    <td>계정 DISK 사용량(A)</td>
    <td><?=size($account_space)?></td>
</tr>
<tr>
    <td>데이터 디렉토리 사용량(D)</td>
    <td><?=size($data_space)?></td>
</tr>
<tr>
    <td>프로그램 사용량(A-D)</td>
    <td><?=size($account_space - $data_space)?></td>
</tr>
<? } ?>

<? if ($apache_version) { ?>
<tr height=15px><td></td></tr>
<tr>
    <td>Apache 버젼</td>
    <td><?=$apache_version;?></td>
</tr>
<tr height=15px><td></td></tr>
<tr>
    <td>Apache 모듈</td>
    <td><?=$apache_modules;?></td>
</tr>
<? } ?>

<tr height=15px><td></td></tr>
<tr>
    <td>PHP 버젼</td>
    <td><?=$php_version;?></td>
</tr>
<tr>
    <td>Zend 버젼</td>
    <td><?=$zend_version;?></td>
</tr>
<tr>
    <td>GD 버젼</td>
    <td><?=$gd_version;?></td>
</tr>
<tr>
    <td>최대 Upload 파일사이즈</td>
    <td><?=$max_filesize;?></td>
</tr>
<tr>
    <td>php에 할당된 메모리 사이즈</td>
    <td><?=size(memory_get_usage());?></td>
</tr>
<tr height=15px><td></td></tr>
<tr>
    <td>MYSQL 버젼</td>
    <td><?=$m_version[ver]?>
    </td> 
</tr>
<tr>
    <td>MYSQL DB Name</td>
    <td><?=$mysql_db ?>
    </td> 
</tr>
<tr>
    <td>MYSQL DB info</td>
    <td><? $a = explode(":", $mysql_stat[0]); echo $a[0] . ": ";?>
        <?
        $days = floor($a[1]/86400);
        if ($days) echo $days . "일 ";
        $hours = (floor($a[1]/3600)%24);
        if ($hours) echo $hours . "시간 ";
        $min = (floor($a[1]/60)%60);
        if ($min) echo $min . "분";
        ?>
        <BR>
        <?=$mysql_stat[1]?><BR>
        <? $t=explode(":", $mysql_stat[2]); echo $t[0] . ": "; echo number_format($t[1])?><BR>
        <?=$t=explode(":", $mysql_stat[3]); echo $t[0] . ": "; echo number_format($t[1])?><BR>
        <?=$t=explode(":", $mysql_stat[4]); echo $t[0] . ": "; echo number_format($t[1])?><BR>
        <?=$mysql_stat[5]?><BR>
        <?=$mysql_stat[6]?><BR>
        <?=$mysql_stat[7]?><BR>
    </td> 
</tr>
<tr>
    <td>DB 사용량</td>
    <td><?=size($db_using)?>
    </td> 
</tr> 
<tr>
    <td>전체 DB 테이블 갯수</td>
    <td><?=number_format($db_count)?>
    </td> 
</tr> 
<tr>
    <td>전체 DB ROW 갯수</td>
    <td><?=number_format($db_rows)?>
    </td> 
</tr> 
<tr height=15px><td></td></tr>

<tr> 
    <td align=left colspan=2>
    <b>그누보드4 정보</b>
    </td> 
</tr>
<tr height=15px><td></td></tr>
<tr>
    <td>전체 게시판 갯수</td>
    <td><?=number_format($count_board[cnt])?>
    </td> 
</tr>
<tr>
    <td>전체 글 갯수(게시글+코멘트)</td>
    <td><?=number_format($count_board_article)?>
    </td> 
</tr>
<tr>
    <td>전체 게시글 갯수</td>
    <td><?=number_format($count_board_article - $count_board_comment)?>
    </td> 
</tr>
<tr>
    <td>전체 코멘트 갯수</td>
    <td><?=number_format($count_board_comment)?>
    </td> 
</tr>
<tr>
    <td>전체 게시판의 첨부파일수</td>
    <td><?=number_format($count_data[cnt])?>
    </td> 
</tr> 
<tr>
    <td>전체 포인트 합계</td>
    <td><?=number_format($all_point[sum])?>
    </td> 
</tr>
<tr>
    <td>오늘 발생한 포인트</td>
    <td><?=number_format($new_point[sum])?>
    </td> 
</tr>
<tr>
    <td>전체 회원수</td>
    <td><?=number_format($count_member[cnt])?>
    </td> 
</tr> 
<tr>
    <td>오늘 가입한 회원수</td>
    <td><?=number_format($new_member[cnt])?>
    </td> 
</tr> 

</table> 


<?
include_once("./admin.tail.php");
?>
