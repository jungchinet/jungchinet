<?
include_once("./_common.php");
include_once("$g4[path]/lib/mailer.lib.php");

// 리퍼러 체크
referer_check();

if ($w == "") 
{
    // 자동등록방지 검사
    if (!$member[mb_id] && $config[cf_use_norobot]) {
        include_once("$g4[path]/zmSpamFree/zmSpamFree.php");
        if ( !zsfCheck( $_POST['wr_key'], 'sms_admin' ) ) { alert ('스팸차단코드가 틀렸습니다.'); }    
    }

    $po = sql_fetch(" select * from $g4[poll_table] where po_id = '$po_id' ");
    if (!$po[po_id])
        alert("po_id 값이 제대로 넘어오지 않았습니다.");

    $tmp_row = sql_fetch(" select max(pc_id) as max_pc_id from $g4[poll_etc_table] ");
    $pc_id = $tmp_row[max_pc_id] + 1;

    $pc_idea = addslashes($pc_idea);

    $sql = " insert into $g4[poll_etc_table]
                    ( pc_id, po_id, mb_id, pc_name, pc_idea, pc_datetime, pc_password )
             values ( '$pc_id', '$po_id', '$member[mb_id]', '$pc_name', '$pc_idea', '$g4[time_ymdhis]', '" . sql_password($pc_password) . "' ) ";
    sql_query($sql);

    $pc_idea = stripslashes($pc_idea);

    $name = cut_str($pc_name, $config[cf_cut_name]);
    $mb_id = "";
    if ($member[mb_id])
        $mb_id = "($member[mb_id])";

    // 환경설정의 투표 기타의견 작성시 최고관리자에게 메일발송 사용에 체크되어 있을 경우
    if ($config[cf_email_po_super_admin])
    {
        $subject = $po[po_subject];
        $content = $pc_idea;

        ob_start();
        include_once ("./poll_etc_update_mail.php");
        $content = ob_get_contents();
        ob_end_clean();

        // 관리자에게 보내는 메일
        $admin = get_admin("super");
        mailer($name, "", $admin[mb_email], "설문조사 기타의견 메일", $content, 1);
    }
} 
else if ($w == "d" or $w == "p") 
{
    if ($member[mb_id] || $is_admin == 'super')
    {
        $sql = " delete from $g4[poll_etc_table] where pc_id = '$pc_id' ";
        if (!$is_admin)
            $sql .= " and mb_id = '$member[mb_id]' ";
        sql_query($sql);
    } else if (!$member[mb_id]) {
        $result = sql_fetch(" select pc_password from $g4[poll_etc_table] where pc_id = '$pc_id' and po_id = '$po_id' ");
        if (sql_password($wr_password) != $result['pc_password'])
            alert("패스워드가 틀립니다.");
            
        $sql = " delete from $g4[poll_etc_table] where pc_id = '$pc_id' and po_id = '$po_id' and pc_password = '" . sql_password($wr_password) . "'";
    }
}

goto_url("./poll_result.php?po_id=$po_id&skin_dir=$skin_dir");
?>
