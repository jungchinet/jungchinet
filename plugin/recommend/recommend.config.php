<?
// 회원가입 추천 테이블
$g4['member_suggest_table'] = $g4['table_prefix'] . "member_suggest";

$g4['member_suggest_join_days']  = 30;      // 추천+인증으로 가입할 때, 추천 코드의 유효기간 (기본 30일. 시간이 아니라 날짜다.)

$g4['member_suggest_days']   = 120;         // 회원가입 추천 사이클 (며칠 단위로 추천 가능)
$g4['member_suggest_count']  = 2;           // 회원가입 추천건수
$g4['member_suggest_level']  = 3;           // 추천 가능 레벨

$g4['member_suggest_phone']  = 1;           // 핸드폰 추천가입기능 여부
$g4['member_suggest_email']  = 1;           // 이메일 추천가입기능 여부

$g4['member_suggest_singo']  = 1;           // 신고가 있는 경우 가입제한

$g4['member_suggest_msg1']  = "";
if ($g4['member_suggest_phone'])
    $g4['member_suggest_msg1'] = "SMS";
if ($g4['member_suggest_email'])
    if ($g4['member_suggest_msg1'])
        $g4['member_suggest_msg1'] .= ",이메일";
    else
        $g4['member_suggest_msg1'] .= "이메일";


// 가입초기 화면에 출력 되는 내용
$g4['member_suggest_intro'] = "
      $g4[member_suggest_msg1] 인증을 받은 Level $g4[member_suggest_level] 회원의 가입추천을 통해서만 회원 가입이 가능 합니다.<br>
      $g4[member_suggest_msg1] 인증을 받은 Level $g4[member_suggest_level] 회원은 추천일부터 $g4[member_suggest_days]일 이내에 $g4[member_suggest_count]명의 회원을 가입추천할 수 있습니다.<br>
      추천시 30 포인트를 차감 합니다.<br>
      추천코드는 추천일부터 $g4[member_suggest_join_days]일간 유효하며, 기간내 가입을 하지 못한 경우 <b>추천일갱신</b> 버튼을 눌러서 추천일을 현재로 할 수 있습니다.
      <ul>
      <li>Level $g4[member_suggest_level] 회원이 가입추천 $g4[member_suggest_msg1]를 발송 (1번의 발송 = 1번의 추천)</li>
      <li>수신한 $g4[member_suggest_level]의 추천인 id, 인증코드를 회원가입 화면에서 입력 합니다.</li>
      <li>회원가입 화면에서 회원가입절차를 진행 합니다.</li>
      </ul>
      ";

// 인증번호 생성
$certify_number = rand(100000, 999999); 

// sms인증 (icord)
$default['de_icode_server_ip'] = "211.172.232.124"; 
$default['de_icode_id'] = ""; 
$default['de_icode_pw'] = ""; 
$default['de_icode_server_port'] = "7295"; 
$default['de_sms_hp'] = "$member[mb_hp]";

$sms_contents = "$config[cf_title]\n\n"; 
$sms_contents .= "추천인아이디.\n"; 
$sms_contents .= $member[mb_id]; 
$sms_contents .= "\n가입인증번호.\n"; 
$sms_contents .= $certify_number; 

// 이메일 인증
$g4['member_suggest_email_subject'] = "회원가입을 위한 인증코드 확인메일입니다.";
?>
<link rel="stylesheet" href="<?=$g4['path']?>/plugin/recommend/style.css" type="text/css">
