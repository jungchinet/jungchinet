<?
if (!defined('_GNUBOARD_')) exit;

// 현재 접속자수 출력
function connect($skin_dir="")
{
    global $config, $g4;

    // 회원, 방문객 카운트
    //$sql = " select sum(IF(mb_id<>'',1,0)) as mb_cnt, count(*) as total_cnt from $g4[login_table]  where mb_id <> '$config[cf_admin]' ";
    //$row = sql_fetch($sql);

    $sql = " select count(*) as total_cnt from $g4[login_table]";
    $row1 = sql_fetch($sql);
    $total_cnt = $row1[total_cnt];

    $sql = " select count(*) as mb_cnt from $g4[login_table] where mb_id <> '' ";
    $row1 = sql_fetch($sql);
    $mb_cnt = $row1[mb_cnt];

    $sql = " select count(*) as admin_cnt from $g4[login_table] where mb_id = '$config[cf_admin]' ";
    $row1 = sql_fetch($sql);
    $admin_cnt = $row1[admin_cnt];
	
	function tot_mem(){
		$wow=mysql_query('select count(mb_id) from g4_member');
		$how=mysql_fetch_row($wow);
		echo $how[0];	
	}
	
    if ($admin_cnt) {
        $mb_cnt--;
        $total_cnt--;
    }

    $row['mb_cnt'] = $mb_cnt;
    $row['total_cnt'] = $total_cnt;

    if ($skin_dir)
        $connect_skin_path = "$g4[path]/skin/connect/$skin_dir";
    else
        $connect_skin_path = "$g4[path]/skin/connect/$config[cf_connect_skin]";

    ob_start();
    include_once ("$connect_skin_path/connect.skin.php");
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
