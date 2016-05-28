<?
if (!defined('_GNUBOARD_')) exit;

// 설문조사
function poll($skin_dir="basic", $po_id=false, $codee)
{
    global $config, $member, $g4, $is_admin;

    // 투표번호가 넘어오지 않았다면 가장 큰(최근에 등록한) 투표번호를 얻는다
    if (empty($po_id)) 
    {
        $po_id = $config['cf_max_po_id'];
        if (empty($po_id))
            return "<!-- po_id를 찾을 수 없습니다. -->";
    }
	
	$where_plus="a.po_r1='0' and a.po_r2='0' order by a.po_id desc";
	
    /*$sql_select = " a.po_subject, a.po_id, a.po_level, a.po_poll1, a.po_poll2, a.po_poll3, a.po_poll4, a.po_poll5, a.po_poll6, a.po_poll7, a.po_poll8, a.po_poll9, a.po_summary, a.po_skin, a.po_date, a.po_end_date ";*/
	$sql_select = " a.* ";
	$po = sql_fetch(" select $sql_select, b.gl_name from $g4[poll_table] a left join $g4[member_group_table] b on a.po_level = b.gl_id where $where_plus");

    // 투표가능 여부 확인
    $po_use = 0;
   
    // 투표시작일 check 
    $tm1 = explode("-", $po[po_date]);
    $start_stamp = mktime(0,0,0, $tm1[1], $tm1[2], $tm1[0]);
    // 투표마감일 check
    $tm2 = explode("-", $po[po_end_date]);
    $end_stamp = mktime(0,0,0, $tm2[1], $tm2[2], $tm2[0]);

    if ($g4['server_time'] >= $start_stamp && ($po[po_end_date] == "0000-00-00" || $end_stamp >= $g4['server_time']))
        $po_use = 1;

    //ob_start();
    $poll_skin_path = "$g4[path]/skin/poll/$po[po_skin]";
    include_once ("$poll_skin_path/poll.skin.php");
    //$content = ob_get_contents();
    //ob_end_clean();

    //return $content;
	unset($po_id);
}

function poll2($skin_dir="basic", $po_id=false)
{
    global $config, $member, $g4, $is_admin;

    // 투표번호가 넘어오지 않았다면 가장 큰(최근에 등록한) 투표번호를 얻는다
    if (empty($po_id)) 
    {
        $po_id = $config['cf_max_po_id'];
        if (empty($po_id))
            return "<!-- po_id를 찾을 수 없습니다. -->";
    }

	$where_plus="a.po_r1='$member[mb_5]' and a.po_r2='0' order by a.po_id desc";
	
    /*$sql_select = " a.po_subject, a.po_id, a.po_level, a.po_poll1, a.po_poll2, a.po_poll3, a.po_poll4, a.po_poll5, a.po_poll6, a.po_poll7, a.po_poll8, a.po_poll9, a.po_summary, a.po_skin, a.po_date, a.po_end_date ";*/
	$sql_select = " a.* ";
	$po = sql_fetch(" select $sql_select, b.gl_name from $g4[poll_table] a left join $g4[member_group_table] b on a.po_level = b.gl_id where $where_plus");

    // 투표가능 여부 확인
    $po_use = 0;
   
    // 투표시작일 check 
    $tm1 = explode("-", $po[po_date]);
    $start_stamp = mktime(0,0,0, $tm1[1], $tm1[2], $tm1[0]);
    // 투표마감일 check
    $tm2 = explode("-", $po[po_end_date]);
    $end_stamp = mktime(0,0,0, $tm2[1], $tm2[2], $tm2[0]);

    if ($g4['server_time'] >= $start_stamp && ($po[po_end_date] == "0000-00-00" || $end_stamp >= $g4['server_time']))
        $po_use = 1;

    //ob_start();
    $poll_skin_path = "$g4[path]/skin/poll/$po[po_skin]";
    include_once ("$poll_skin_path/poll2.skin.php");
    //$content = ob_get_contents();
    //ob_end_clean();

    //return $content;
	unset($po_id);
}

function poll3($skin_dir="basic", $po_id=false)
{
    global $config, $member, $g4, $is_admin;

    // 투표번호가 넘어오지 않았다면 가장 큰(최근에 등록한) 투표번호를 얻는다
    if (empty($po_id)) 
    {
        $po_id = $config['cf_max_po_id'];
        if (empty($po_id))
            return "<!-- po_id를 찾을 수 없습니다. -->";
    }

	$where_plus="a.po_r1='$member[mb_5]' and a.po_r2='$member[mb_6]' order by a.po_id desc";
	
    /*$sql_select = " a.po_subject, a.po_id, a.po_level, a.po_poll1, a.po_poll2, a.po_poll3, a.po_poll4, a.po_poll5, a.po_poll6, a.po_poll7, a.po_poll8, a.po_poll9, a.po_summary, a.po_skin, a.po_date, a.po_end_date ";*/
	$sql_select = " a.* ";
	$po = sql_fetch(" select $sql_select, b.gl_name from $g4[poll_table] a left join $g4[member_group_table] b on a.po_level = b.gl_id where $where_plus");

    // 투표가능 여부 확인
    $po_use = 0;
   
    // 투표시작일 check 
    $tm1 = explode("-", $po[po_date]);
    $start_stamp = mktime(0,0,0, $tm1[1], $tm1[2], $tm1[0]);
    // 투표마감일 check
    $tm2 = explode("-", $po[po_end_date]);
    $end_stamp = mktime(0,0,0, $tm2[1], $tm2[2], $tm2[0]);

    if ($g4['server_time'] >= $start_stamp && ($po[po_end_date] == "0000-00-00" || $end_stamp >= $g4['server_time']))
        $po_use = 1;

    //ob_start();
    $poll_skin_path = "$g4[path]/skin/poll/$po[po_skin]";
    include_once ("$poll_skin_path/poll3.skin.php");
    //$content = ob_get_contents();
    //ob_end_clean();

    //return $content;
	unset($po_id);
}
?>
