<?
$sub_menu = "200100";
include_once("./_common.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

$mb_id = mysql_real_escape_string(trim($_POST['mb_id']));

$mb_name         = $_POST[mb_name];
$mb_nick         = $_POST[mb_nick];
$mb_email        = $_POST[mb_email];
$mb_homepage     = $_POST[mb_homepage];
$mb_tel          = $_POST[mb_tel];
$mb_hp           = $_POST[mb_hp];
$mb_zip1         = $_POST[mb_zip1];
$mb_zip2         = $_POST[mb_zip2];
$mb_addr1        = $_POST[mb_addr1];
$mb_addr2        = $_POST[mb_addr2];
$mb_birth        = $_POST[mb_birth];
$mb_sex          = $_POST[mb_sex];
$mb_signature    = $_POST[mb_signature];
$mb_leave_date   = $_POST[mb_leave_date];
$mb_intercept_date=$_POST[mb_intercept_date];
$mb_memo         = htmlspecialchars($_POST[mb_memo]);   // mb_memo에 특수문자가 들어가는 경우 때문에
$mb_mailling     = $_POST[mb_mailling];
$mb_sms          = $_POST[mb_sms];
$mb_open         = $_POST[mb_open];
$mb_profile      = $_POST[mb_profile];
$mb_level        = $_POST[mb_level];
$ug_id           = $_POST[ug_id];
$mb_1            = $_POST[mb_1];
$mb_2            = $_POST[mb_2];
$mb_3            = $_POST[mb_3];
$mb_4            = $_POST[mb_4];
$mb_5            = $_POST[mb_5];
$mb_6            = $_POST[mb_6];
$mb_7            = $_POST[mb_7];
$mb_8            = $_POST[mb_8];
$mb_9            = $_POST[mb_9];
$mb_10           = $_POST[mb_10];

if($mb_5 and $mb_6){
	$ug_id='reg_2_'.$mb_6;	
}else if($mb_5 and !$mb_6){
	$ug_id='reg_1_'.$mb_5;	
}

$sql_common = " mb_name         = '$mb_name',
                mb_nick         = '$mb_nick',
                mb_email        = '$mb_email',
                mb_homepage     = '$mb_homepage',
                mb_tel          = '$mb_tel',
                mb_hp           = '$mb_hp',
                mb_zip1         = '$mb_zip1',
                mb_zip2         = '$mb_zip2',
                mb_addr1        = '$mb_addr1',
                mb_addr2        = '$mb_addr2',
                mb_birth        = '$mb_birth',
                mb_sex          = '$mb_sex',
                mb_signature    = '$mb_signature',
                mb_leave_date   = '$mb_leave_date',
                mb_intercept_date='$mb_intercept_date',
                mb_memo         = '$mb_memo',
                mb_mailling     = '$mb_mailling',
                mb_sms          = '$mb_sms',
                mb_open         = '$mb_open',
                mb_profile      = '$mb_profile',
                mb_level        = '$mb_level',
                ug_id           = '$ug_id',
                mb_1            = '$mb_1',
                mb_2            = '$mb_2',
                mb_3            = '$mb_3',
                mb_4            = '$mb_4',
                mb_5            = '$mb_5',
                mb_6            = '$mb_6',
                mb_7            = '$mb_7',
                mb_8            = '$mb_8',
                mb_9            = '$mb_9',
                mb_10           = '$mb_10' ";

// ==== 아래 부분은 bbs/register_form_update.php에서 가져온 겁니다.
// ==== 관리자도 사람이라 실수하는데, 그거는 피해야죠.

// 이름은 한글만 가능
if (!check_string($mb_name, _G4_HANGUL_  + _G4_ALPHABETIC_ )) 
    alert('이름은 공백없이 한글 또는 영문만 입력 가능합니다.');

// 별명은 한글, 영문, 숫자만 가능
if (!check_string($mb_nick, _G4_HANGUL_ + _G4_ALPHABETIC_ + _G4_NUMERIC_))
    alert('별명은 공백없이 한글, 영문, 숫자만 입력 가능합니다.');

if ($w == "")
{
    // 중복 별명이 없는지 확인 합니다.
    $sql = " select count(*) as cnt from $g4[member_table] where mb_nick = '$mb_nick' ";
    $row = sql_fetch($sql);
    if ($row[cnt])
        alert("\'$mb_nick\' 은(는) 이미 다른분이 사용중인 별명이므로 사용이 불가합니다.");
    
    // 불당팩 - 회원가입시 mb_nick_table에 중복 닉이 없는지 확인
    $sql = " select count(*) as cnt from $g4[mb_nick_table] where mb_nick = '$mb_nick' ";
    $row = sql_fetch($sql);
    if ($row[cnt])
        alert("\'$mb_nick\' 은(는) 이미 다른분이 사용중인 별명이므로 사용이 불가합니다.");
    
    $sql = " select count(*) as cnt from $g4[member_table] where mb_email = '$mb_email' ";
    $row = sql_fetch($sql);
    if ($row[cnt])
        alert("\'$mb_email\' 은(는) 이미 다른분이 사용중인 E-mail이므로 사용이 불가합니다.");
}
else if ($w == "u")
{
    // 중복 별명이 없는지 확인 합니다.
    $sql = " select count(*) as cnt from $g4[member_table] where mb_nick = '$mb_nick' and mb_id <> '$mb_id' ";
    $row = sql_fetch($sql);
    if ($row[cnt])
        alert("\'$mb_nick\' 은(는) 이미 다른분이 사용중인 별명이므로 사용이 불가합니다.1");
    
    // 불당팩 - 회원가입시 mb_nick_table에 중복 닉이 없는지 확인
    $sql = " select count(*) as cnt from $g4[mb_nick_table] where mb_nick = '$mb_nick' and mb_id <> '$mb_id' ";
    $row = sql_fetch($sql);
    if ($row[cnt])
        alert("\'$mb_nick\' 은(는) 이미 다른분이 사용중인 별명이므로 사용이 불가합니다.2");
    
    $sql = " select count(*) as cnt from $g4[member_table] where mb_email = '$mb_email' and mb_id <> '$mb_id' ";
    $row = sql_fetch($sql);
    if ($row[cnt])
        alert("\'$mb_email\' 은(는) 이미 다른분이 사용중인 E-mail이므로 사용이 불가합니다.");
}

if ($w == "")
{
    $mb = get_member($mb_id);
    if ($mb[mb_id])
        alert("이미 존재하는 회원입니다.\\n\\nＩＤ : $mb[mb_id]\\n\\n이름 : $mb[mb_name]\\n\\n별명 : $mb[mb_nick]\\n\\n메일 : $mb[mb_email]");

    // 불당팩 - mb_nick을 db에 추가
    $sql2 = " insert $g4[mb_nick_table] set  mb_id = '$mb_id', mb_nick = '$mb_nick', start_datetime = '$g4[time_ymdhis]' ";
    sql_query($sql2);

    sql_query(" insert into $g4[member_table] set mb_id = '$mb_id', mb_password = '".sql_password($mb_password)."', mb_datetime = '$g4[time_ymdhis]', mb_ip = '$remote_addr', mb_email_certify = '$g4[time_ymdhis]', $sql_common  ");
}
else if ($w == "u")
{
    $mb = get_member($mb_id);
    if (!$mb[mb_id])
        alert("존재하지 않는 회원자료입니다.");

    if ($is_admin != "super" && $mb[mb_level] >= $member[mb_level])
        alert("자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.");

    if ($_POST[mb_id] == $member[mb_id] && $_POST[mb_level] != $mb[mb_level])
        alert("$mb[mb_id] : 로그인 중인 관리자 레벨은 수정 할 수 없습니다.");

    $mb_dir = substr($mb_id,0,2);

    // 회원 아이콘 삭제
    if ($del_mb_icon)
        @unlink("$g4[data_path]/member/$mb_dir/$mb_id.gif");

    // 아이콘 업로드
    if (is_uploaded_file($_FILES[mb_icon][tmp_name])) {
        if (!preg_match("/(\.gif)$/i", $_FILES[mb_icon][name])) {
            alert($_FILES[mb_icon][name] . '은(는) gif 파일이 아닙니다.');
        }

        if (preg_match("/(\.gif)$/i", $_FILES[mb_icon][name])) {
            @mkdir("$g4[data_path]/member/$mb_dir", 0707);
            @chmod("$g4[data_path]/member/$mb_dir", 0707);

            $dest_path = "$g4[data_path]/member/$mb_dir/$mb_id.gif";

            move_uploaded_file($_FILES[mb_icon][tmp_name], $dest_path);
            chmod($dest_path, 0606);

            if (file_exists($dest_path)) {
                $size = getimagesize($dest_path);
                // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                if ($size[0] > $config[cf_member_icon_width] || $size[1] > $config[cf_member_icon_height]) {
                    @unlink($dest_path);
                }
            }
        }
    }

    if ($mb_password)
        $sql_password = " , mb_password = '".sql_password($mb_password)."' ";
    else
        $sql_password = "";

    if ($passive_certify)
        $sql_certify = " , mb_email_certify = '$g4[time_ymdhis]' ";
    else
        $sql_certify = "";

    $sql = " update $g4[member_table]
                set $sql_common
                    $sql_password
                    $sql_certify
              where mb_id = '$mb_id' ";
    sql_query($sql);
    
    // 회원레벨이 업데이트 된 경우에는 레벨업 날짜와 history를 기록 합니다.
    if ($mb[mb_level] !== $mb_level) {
        sql_query(" update $g4[member_table] set mb_level_datetime = '$g4[time_ymdhis]' where mb_id='$mb_id' ");
        sql_query(" insert into $g4[member_level_history_table] set mb_id='$mb_id', from_level='$mb[mb_level]', to_level='$mb_level', level_datetime='$g4[time_ymdhis]' ");
    }

    // 불당팩 - 닉네임이 변경되면 history에 기록 합니다.
    if ($mb[mb_nick] != $mb_nick) {
        // 내가 사용하던 닉네임이 있는지 확인
        $sql = " select count(*) as cnt from $g4[mb_nick_table] where mb_id = '$mb_id' and mb_nick = '$mb_nick' ";
        $result = sql_fetch($sql);
        if ($result['cnt']) {
            // 기존의 닉네임은 닫아버리고, 
            $sql = " update $g4[mb_nick_table] set end_datetime='$g4[time_ymdhis]' where mb_id = '$mb_id' and mb_nick = '$mb[mb_nick] ";
            // 새로운거는 열여주고.
            $sql = " update $g4[mb_nick_table] set start_datetime = '$g4[time_ymdhis]', end_datetime='0000-00-00 00:00:00' where mb_id = '$mb_id' and mb_nick = '$mb_nick' ";
        }
        else
        {
            $sql = " insert $g4[mb_nick_table] set  mb_id = '$mb_id', mb_nick = '$mb_nick', start_datetime = '$g4[time_ymdhis]' ";
            sql_query($sql);
            
            // 기존에 쓰던 nickname을 close
            $sql = " update $g4[mb_nick_table] set end_datetime = '$g4[time_ymdhis]' where mb_id = '$mb_id' and mb_nick = '$mb[mb_nick]' ";
            sql_query($sql);
        }
    }
}
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

goto_url("./member_form.php?$qstr&w=u&mb_id=$mb_id");
?>
