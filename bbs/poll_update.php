<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
header("Pragma: no-cache"); 
header("Cache-Control: no-cache,must-revalidate"); 

include_once("./_common.php");

$po = sql_fetch(" select a.*, b.gl_name from $g4[poll_table] a left join $g4[member_group_table] b on a.po_level = b.gl_id where a.po_id = '$_POST[po_id]' ");
if (!$po[po_id]) 
    alert_close("po_id 값이 제대로 넘어오지 않았습니다.");

// 투표이후 이동할 url
$poll_url = "./poll_result.php?po_id=$po_id&skin_dir=$skin_dir";

// 투표시작일 check 
$tm1 = explode("-", $po[po_date]);
$start_stamp = mktime(0,0,0, $tm1[1], $tm1[2], $tm1[0]);
if ($start_stamp > $g4['server_time'])
    alert("투표시작일은 $po[po_date] 입니다.", $poll_url);
   
// 투표마감일 check
if ($po[po_end_date] != "0000-00-00") {
    $tm2 = explode("-", $po[po_end_date]);
    $end_stamp = mktime(0,0,0, $tm2[1], $tm2[2], $tm2[0]);
    if ($end_stamp < $g4['server_time']){
        echo "<script>alert(\"이미 $po[po_date]일 종료된 투표입니다.\");</script>";
		/*echo "<script>parent.poll_result($_POST[po_id])</script>";*/
		$hello=0;
	}else{
		$hello=1;
	}
}

if($hello==1){

if ($member[mb_level] < $po[po_level]) 
    alert("$po[gl_name] 이상 회원만 투표에 참여하실 수 있습니다.");

// 쿠키에 저장된 투표번호가 없다면
if (get_cookie("ck_po_id") != $po[po_id]) 
{
    // 투표했던 ip들 중에서 찾아본다
    $search_ip = false;
    $ips = explode("\n", trim($po[po_ips]));
    for ($i=0; $i<count($ips); $i++) 
    {
        if ($_SERVER[REMOTE_ADDR] == trim($ips[$i])) 
        {
            $search_ip = true;
            break;
        }
    }

    // 투표했던 회원아이디들 중에서 찾아본다
    $search_mb_id = false;
    if ($is_member)
    {
        $ids = explode("\n", trim($po[mb_ids]));
        for ($i=0; $i<count($ids); $i++) 
        {
            if ($member[mb_id] == trim($ids[$i])) 
            {
                $search_mb_id = true;
                break;
            }
        }
    }

    // 없다면 선택한 투표항목을 1증가 시키고 ip, id를 저장
    if (!($search_ip || $search_mb_id)) 
    {
        $po_ips = $po[po_ips] . $remote_addr . "\n";
        $mb_ids = $po[mb_ids];
        if ($member[mb_id])
            $mb_ids .= $member[mb_id] . "\n";
        sql_query(" update $g4[poll_table] set po_cnt{$gb_poll} = po_cnt{$gb_poll} + 1, po_ips = '$po_ips', mb_ids = '$mb_ids' where po_id = '$po_id' ");
        $msg = "정상적으로 참여되었습니다.";
		echo "<script>parent.location.reload();</script>";
    } else 
    {
		if($_SERVER[REMOTE_ADDR]=='112.173.175.207'){
			echo "<script>parent.poll_result(".$_POST[po_id].")</script>";
		}else{
        	$msg = "이미 투표에 참여 하셨습니다.";
		}
		/*echo "<script>parent.poll_result(".$_POST[po_id].")</script>";*/
    }

    if (!$search_mb_id)
        insert_point($member[mb_id], $po[po_point], $po[po_id] . ". " . cut_str($po[po_subject],20) . " 투표 참여 ", "@poll", $po[po_id], "투표");
} else {
    if($_SERVER[REMOTE_ADDR]=='112.173.175.207'){
		echo "<script>parent.poll_result(".$_POST[po_id].")</script>";
	}else{
		$msg = "이미 투표에 참여 하셨습니다.";
	}
	/*echo "<script>parent.poll_result($_POST[po_id])</script>";*/
}

set_cookie("ck_po_id", $po[po_id], 86400 * 15); // 투표 쿠키 보름간 저장

if ($msg)
    //alert("$msg", $poll_url);
	echo "<script>alert('$msg');</script>";
//else
    //goto_url($poll_url);
	
}
?>
