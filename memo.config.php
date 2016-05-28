<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 쪽지 테이블
$g4['memo_config_table']          = $g4['table_prefix'] . "memo_config";          // 메모 설정테이블

$g4['memo_recv_table']            = $g4['table_prefix'] . "memo_recv";            // 메모 테이블 (수신)
$g4['memo_send_table']            = $g4['table_prefix'] . "memo_send";            // 메모 테이블 (발신)
$g4['memo_save_table']            = $g4['table_prefix'] . "memo_save";            // 메모 테이블 (저장)
$g4['memo_spam_table']            = $g4['table_prefix'] . "memo_spam";            // 메모 테이블 (스팸)
$g4['memo_notice_table']          = $g4['table_prefix'] . "memo_notice";          // 메모 테이블 (공지)
$g4['memo_trash_table']           = $g4['table_prefix'] . "memo_trash";           // 메모 테이블 (휴지통)

$g4['memo_group_table']           = $g4['table_prefix'] . "memo_group";           // 메모 테이블 (그룹)
$g4['memo_group_member_table']    = $g4['table_prefix'] . "memo_group_member";    // 메모 테이블 (그룹멤버)
$g4['friend_table']               = $g4['table_prefix'] . "friend";               // 친구 테이블 

// data_path가 설정되지 않은경우 설정, $g4[data_path]는 불당팩에서 쓰는 data 경로 입니다.
if (!$g4['data_path']) {
    $g4['data']          = "data";
    $g4['data_path']     = $g4['path'] . "/" . $g4['data'];
}

// 설정 - $config 테이블로 통합
if (function_exists('sql_fetch')) {

    // 필드별로 select 하는 것은 mysql db에 cache되게 하려구 그런 것임
    $memo_config_select = " cf_memo_page_rows, cf_memo_del_unread, cf_memo_del_trash, cf_memo_delete_datetime, cf_memo_user_dhtml, ";
    $memo_config_select .= "cf_memo_use_file, cf_memo_file_size, cf_max_memo_file_size, cf_friend_management, cf_memo_no_reply, ";
    $memo_config_select .= "cf_memo_notice_board, cf_memo_notice_memo, cf_memo_before_after, cf_memo_print, cf_memo_b4_resize, cf_memo_realtime, cf_memo_mb_name ";
    $memo_config = sql_fetch(" select $memo_config_select from $g4[memo_config_table] ", FALSE);

    if ($memo_config) {

        // array_merge가 이상하게 동작하는 웹서버가 있어서, 설정값을 한개씩 넣게 수정함
        $config['cf_memo_page_rows']        = $memo_config['cf_memo_page_rows'];        // 쪽지의 페이지별 출력갯수
        $config['cf_memo_del_unread']       = $memo_config['cf_memo_del_unread'];       // OO일이 지난 안읽은 쪽지 삭제
        $config['cf_memo_del_trash']        = $memo_config['cf_memo_del_trash'];        // OO일이 지난 휴지통 쪽지 삭제
        $config['cf_memo_delete_datetime']  = $memo_config['cf_memo_delete_datetime'];  //
        $config['cf_memo_user_dhtml']       = $memo_config['cf_memo_user_dhtml'];       // dhtml 편집기 사용여부
        $config['cf_memo_use_file']         = $memo_config['cf_memo_use_file'];         // 첨부파일 사용여부
        $config['cf_memo_file_size']        = $memo_config['cf_memo_file_size'];        // 첨부파일 허용 사이즈
        $config['cf_max_memo_file_size']    = $memo_config['cf_max_memo_file_size'];    // 최대 첨부 파일 용량
        $config['cf_friend_management']     = $memo_config['cf_friend_management'];     // 친구관리기능 사용여부
        $config['cf_memo_no_reply']         = $memo_config['cf_memo_no_reply'];         // 부재중 설정 변경일자
        $config['cf_memo_notice_memo']      = $memo_config['cf_memo_notice_memo'];      // 공지메모
        $config['cf_memo_before_after']     = $memo_config['cf_memo_before_after'];     // 이전/이후 쪽지 보기
        $config['cf_memo_print']            = $memo_config['cf_memo_print'];            // 쪽지 출력 기능 사용 여부
        $config['cf_memo_b4_resize']        = $memo_config['cf_memo_b4_resize'];        // 불당썸 사용여부
        $config['cf_memo_realtime']         = $memo_config['cf_memo_realtime'];         // 실시간 메모
        $config['cf_memo_mb_name']          = $memo_config['cf_memo_mb_name'];          // 실명 사용

    }
}

// 쪽지 첨부파일 경로
$memo_file_path = $g4['data_path'] . "/memo2/" . $member['mb_id']; 

// 쪽지 스킨 경로 지정
$memo_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";

// 쪽지 프로그램의 location을 정의, $_SERVER[PHP_SELF]를 안쓰기 위해서
$memo_url = $g4[bbs_path] . "/memo.php";

// 사용자의 환경설정은 실시간쪽지, 부재중 응답이 가능할 때만
if ($config['cf_memo_realtime'] || $config['cf_memo_no_reply'])
    $config['cf_memo_user_config'] = 1;

// 쪽지4에서의 dhtml 편집기 사용 설정
$is_dhtml_editor = $config['cf_memo_user_dhtml']; 

// 불당팩의 기본 라이브러리를 업로드
if (!$g4['b4_version']) {
    include_once("$g4[path]/lib/b4.lib.php");
    ?>
    <script src="<?=$g4[path]?>/js/b4.common.js"></script> 
    <?
}

// 변수 초기화 
if (isset($me_id)) {
    $me_id = (int) $me_id;
}

if (isset($kind)) {
    $kind = preg_match("/^[a-zA-Z0-9_]+$/", $kind) ? $kind : "";
}

// 불당팩에서 확장한 g4_member 테이블의 변수
// mb_memo_call               : 나에게 쪽지 보낸 사람들 목록 (mediumtext로 type 변경)
// mb_memo_call_datetime      : 신규 쪽지를 수신한 날짜 (여기에 날짜가 있으면, 안읽은 쪽지 갯수를 카운트)
// mb_real_memo               : 실시간 쪽지를 쓸 것인가 여부 
// mb_realmemo_sound          : 실시간 쪽지에서 소리를 나게 할 것이가 여부
// mb_memo_no_reply           : 부재중 쪽지 사용여부
// mb_memo_no_reply_text      : 부재중 쪽지의 답 메시지
// mb_memo_no_reply_datetime  : 부재중 쪽지 수신 날짜
// mb_memo_unread             : 안읽은 메시지 갯수

// 메모를 지정된 시간이 지나야 보낼 수 있게 설정 (스팸쪽지를 막기 위해서...)
$g4['memo_delay_sec'] = 1;

// 친구찾기 guess-work을 막기 위해서
$g4['memo_max_friend'] = 100;

// 친구관리를 빈번하게 수행하는 것을 막기 위해서
$g4['memo_delay_friend'] = 2;

// 친구관리 검색을 할 때 차감하는 포인트
$g4['memo_friend_point'] = -1;

// delete anyway - 다른 쪽지 때문에 삭제가 안될 때는 false 또는 0으로 바꾸면 됩니다.
$g4['memo_delete'] = 1;
?>
