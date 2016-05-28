<?php
include_once("./_common.php");

// 비회원 접속불가
if ($member['mb_id'] == "")
    die;

$g4[title] = "KCB(코리아크레딧뷰로) - okname 본인인증";

include_once("./_head.php");
include_once("./nc.config.php");

// form에서 넘어 온 변수들
$name = strip_tags($_POST["name"]);   // *** 성명
$birthday = $_POST["birthday"];       // *** 생년월일 (연월일의 8개숫자)
$gender = $_POST["gender"];           // *** 성별 여:0, 남:1
$qryKndCd = $_POST["nation"];         // 요청구분  내국인,주민등록번호 : 1, 외국인,외국인등록번호 : 2 

// 실명인증 테스트  회원사코드 (실명인증만 테스트 코드가 있다...why???)
if ($kcb_test)
    $memid = "P00000000003";

// 모듈호출명령어
$cmd="{$exe} \"{$name}\" \"{$birthday}\" \"{$gender}\" $memid "
     ." $qryKndCd $qryRsnCd $qryIP $qryDomain $qryEndPointURL {$qryLogpath} $qryOption";

if ($kcb_test)
    echo "$cmd<br>";
    
exec($cmd, $out, $ret);

if ($kcb_test) {
    foreach($out as $a => $b) {
        echo "$b";
    }
    echo "ret=$ret<br>";
}
    
if($ret <=200)
    $result=sprintf("B%03d", $ret);
else
    $result=sprintf("S%03d", $ret);

if ($kcb_test)
    echo $result.'<br>';


/***********************************************************************
* 안내화면 표시 : START                                                *
*----------------------------------------------------------------------*
* 이 아래의 오류관련 처리는 사이트에 그대로 적용하셔야합니다.          *
* 주민번호와 실명이 존재하나, 생년월일정보가 확인되지않는 경우에       *
* KCB에서 제공하는 안내화면을 표시합니다.                              *
***********************************************************************/
// 로그는 남겨야지.
$sql = " insert into $g4[namecheck_table] set mb_id = '$member[mb_id]', mb_name = '$name', cb_ip = '$_SERVER[REMOTE_ADDR]', cb_datetime = '$g4[time_ymdhis]', cb_returncode = '$result' ";
sql_query($sql);

switch ($result) {
    case 'B000' :
        // 정상적으로 확인이 완료된 경우의 처리
        $sql = " update $g4[member_table] set mb_name = '$name', mb_namecheck = '$g4[time_ymdhis]' where mb_id = '$member[mb_id]' ";
        sql_query($sql);

        // 사용자 확장파일
        @include("./namecheck.skin.php");

        // 다시 원점으로
        alert("생년월일 확인이 성공적으로 이루어졌습니다", "./index.php");

        break;
    case 'B001' :
    case 'B002' :
    case 'B016' :
        // 1. 개인정보가 존재하지 않는 경우. ok-name.co.kr 에서 실명등록을 할 수 있게함.
        //    개인정보가 없어 생년월일확인이 되지 않은 것으로 실패로 처리해야 합니다.
        ?>
        생년월일확인실패
        <script>
    		window.open("http://www.ok-name.co.kr/oknm/okname.jsp?restCode=<?=$result?>",
				"KCB_GuideView",
				"toolbar=no,directories=no,scrollbars=no,resizable=no,status=no, menubar=no, width=560, height=416, top=0,left=20");
        </script>
        <?php  
        break;
    case 'B010' :
        alert("$result-제휴가맹점 키오류-확인실패", "./index.php");
        break;
    default :
        alert("$result-기타오류-입력값을 다시 한번 확인해 주세요", "./index.php");
        break;
}
include_once("./_tail.php"); 
?>
