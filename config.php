<?
// 이 상수가 정의되지 않으면 각각의 개별 페이지는 별도로 실행될 수 없음
define("_GNUBOARD_", TRUE);

// php 5.1.x 이상이면서 서버와 다른 시간대 설정이 필요할 때 쓰세요.
// 지원하는 timezone 목록은 http://kr2.php.net/manual/en/timezones.php
// 5.4.x 부터는 아래 정의가 없으면 PHP Notice가 팡팡 뜹니다.
if (function_exists("date_default_timezone_set"))
    date_default_timezone_set("Asia/Seoul");

// 불당팩 버젼
$g4['b4_version']     = "1.1.x";

// 디렉토리
$g4['bbs']            = "bbs";
$g4['bbs_path']       = $g4['path'] . "/" . $g4['bbs'];
$g4['bbs_img']        = "img";
$g4['bbs_img_path']   = $g4['path'] . "/" . $g4['bbs'] . "/" . $g4['bbs_img'];

$g4['admin']          = "adm";
$g4['admin_path']     = $g4['path'] . "/" . $g4['admin'];

$g4['data']          = "data";
$g4['data_path']     = $g4['path'] . "/" . $g4['data'];

$g4['editor']         = "cheditor";
$g4['editor_path']    = $g4['path'] . "/" . $g4['editor'];

$g4['cheditor4']      = "cheditor4";
$g4['cheditor4_path'] = $g4['path'] . "/" . $g4['cheditor4'];

$g4['is_cheditor5']   = true;

$g4['geditor']        = "geditor";
$g4['geditor_path']   = $g4['path'] . "/" . $g4['geditor'];

$g4['plugin']         = "plugin";
$g4['plugin_path']    = $g4['path'] . "/" . $g4['plugin'];


// 자주 사용하는 값
// 서버의 시간과 실제 사용하는 시간이 틀린 경우 수정하세요.
// 하루는 86400 초입니다. 1시간은 3600초
// 6시간이 빠른 경우 time() + (3600 * 6);
// 6시간이 느린 경우 time() - (3600 * 6);
$g4['server_time'] = time();
$g4['time_ymd']    = date("Y-m-d", $g4['server_time']);
$g4['time_his']    = date("H:i:s", $g4['server_time']);
$g4['time_ymdhis'] = date("Y-m-d H:i:s", $g4['server_time']);

//
// 테이블 명
// (상수로 선언한것은 함수에서 global 선언을 하지 않아도 바로 사용할 수 있기 때문)
//
$g4['table_prefix']        = "g4_"; // 테이블명 접두사
$g4['write_prefix']        = $g4['table_prefix'] . "write_"; // 게시판 테이블명 접두사

$g4['auth_table']          = $g4['table_prefix'] . "auth";          // 관리권한 설정 테이블
$g4['config_table']        = $g4['table_prefix'] . "config";        // 기본환경 설정 테이블
$g4['group_table']         = $g4['table_prefix'] . "group";         // 게시판 그룹 테이블
$g4['group_member_table']  = $g4['table_prefix'] . "group_member";  // 게시판 그룹+회원 테이블
$g4['board_table']         = $g4['table_prefix'] . "board";         // 게시판 설정 테이블
$g4['board_file_table']    = $g4['table_prefix'] . "board_file";    // 게시판 첨부파일 테이블
$g4['board_good_table']    = $g4['table_prefix'] . "board_good";    // 게시물 추천,비추천 테이블
$g4['board_new_table']     = $g4['table_prefix'] . "board_new";     // 게시판 새글 테이블
$g4['login_table']         = $g4['table_prefix'] . "login";         // 로그인 테이블 (접속자수)
$g4['mail_table']          = $g4['table_prefix'] . "mail";          // 회원메일 테이블
$g4['member_table']        = $g4['table_prefix'] . "member";        // 회원 테이블
$g4['poll_table']          = $g4['table_prefix'] . "poll";          // 투표 테이블
$g4['poll_etc_table']      = $g4['table_prefix'] . "poll_etc";      // 투표 기타의견 테이블
$g4['point_table']         = $g4['table_prefix'] . "point";         // 포인트 테이블
$g4['popular_table']       = $g4['table_prefix'] . "popular";       // 인기검색어 테이블
$g4['scrap_table']         = $g4['table_prefix'] . "scrap";         // 게시글 스크랩 테이블
$g4['visit_table']         = $g4['table_prefix'] . "visit";         // 방문자 테이블
$g4['visit_sum_table']     = $g4['table_prefix'] . "visit_sum";     // 방문자 합계 테이블

//
// 기타
//
$g4['memo_table']           = $g4['table_prefix'] . "memo_recv";          // 메모 테이블 (쪽지2/쪽지4)
$g4['member_group_table']   = $g4['table_prefix'] . "member_group";       // 멤버그룹
$g4['my_menu_table']        = $g4['table_prefix'] . "my_menu";            // 마이메뉴
$g4['auction_tender_table'] = $g4['table_prefix'] . "auction_tender";     // 포인트경매 테이블 
$g4['tag_table']            = $g4['table_prefix'] . "tag";                // 관련글 태그 테이블 
$g4['mb_nick_table']        = $g4['table_prefix'] . "mb_nick";            // 닉네임 히스토리 테이블 
$g4['singo_table']          = $g4['table_prefix'] . "singo";              // 게시물 신고 테이블 
$g4['singo_reason_table']   = $g4['table_prefix'] . "singo_reason";       // 게시물 신고 사유 테이블 
$g4['unsingo_table']        = $g4['table_prefix'] . "unsingo";            // 게시물 신고 테이블 
$g4['my_board_table']       = $g4['table_prefix'] . "my_board";           // 내가 방문한 게시판 테이블 
$g4['user_group_table']     = $g4['table_prefix'] . "user_group";         // 사용자 그룹
$g4['hidden_comment_table'] = $g4['table_prefix'] . "hidden_comment";     // 딴지걸기
$g4['login_fail_log_table'] = $g4['table_prefix'] . "login_fail_log";     // 로그인 오류 logging
$g4['config_reg_table']     = $g4['table_prefix'] . "config_reg";         // 기본환경 설정 테이블 (이용약관, 개인정보 취급방침 등 빈도가 낮은 설정정보)
$g4['member_level_table']   = $g4['table_prefix'] . "member_level";       // 회원 레벨업 관리 테이블
$g4['member_level_history_table'] = $g4['table_prefix'] . "member_level_history";       // 회원 레벨업 history 테이블
$g4['category_table']       = $g4['table_prefix'] . "category";           // 회원 레벨업 관리 테이블
$g4['member_register_table']= $g4['table_prefix'] . "member_register";    // 회원 가입 관련 정보 테이블
$g4['recycle_table']        = $g4['table_prefix'] . "recycle";            // 휴지통 관련 정보 테이블
$g4['board_file_download_table'] = $g4['board_file_table'] . "_download";     // 게시판 파일 다운로드 테이블
$g4['cache_table']          = $g4['table_prefix'] . "cache";              // db cache 테이블
$g4['board_cheditor_table'] = $g4['table_prefix'] . "board_cheditor";     // chediotr 파일 관리 테이블
$g4['notice_table']         = $g4['table_prefix'] . "notice";             // 전체공지 테이블
$g4['whatson_table']        = $g4['table_prefix'] . "whatson";            // 왔~~ 테이블
$g4['geoip_table']          = $g4['table_prefix'] . "geoip";              // GeoIP 테이블
$g4['popular_sum_table']    = $g4['table_prefix'] . "popular_sum";        // 인기검색어 합계 테이블
$g4['filter_table']         = $g4['table_prefix'] . "filter";             // 인기검색어 등에 쓰이는 필터 테이블
$g4['promotion_table']      = $g4['table_prefix'] . "promotion";          // 프로모션 테이블
$g4['promotion_sign_table'] = $g4['table_prefix'] . "promotion_sign";     // 프로모션 등록 테이블
$g4['tempsave_table']       = $g4['table_prefix'] . "tempsave";           // 임시저장 테이블
$g4['namecheck_table']      = $g4['table_prefix'] . "namecheck";          // 실명인증 History 테이블
$g4['realcheck_table']      = $g4['table_prefix'] . "realcheck";          // 본인인증 History 테이블
$g4['good_list_table']      = $g4['table_prefix'] . "good_list";          // 베스트글 테이블
$g4['seo_tag_table']        = $g4['table_prefix'] . "seo_tag";            // SEO - tag 테이블
$g4['seo_server_table']     = $g4['table_prefix'] . "seo_server";         // SEO - 서버 테이블
$g4['seo_history_table']    = $g4['table_prefix'] . "seo_history";        // SEO - History 테이블
$g4['member_suggest_table'] = $g4['table_prefix'] . "member_suggest";     // 회원추천정보 테이블
$g4['banner_group_table']   = $g4['table_prefix'] . "banner_group";       // 배너그룹 테이블
$g4['banner_table']         = $g4['table_prefix'] . "banner";             // 배너 테이블
$g4['banner_click_table']   = $g4['table_prefix'] . "banner_click";       // 배너클릭 테이블
$g4['banner_click_sum_table']   = $g4['table_prefix'] . "banner_click_sum";       // 배너클릭 통계 테이블
$g4['category_table']       = $g4['table_prefix'] . "category";           // 카테고리 테이블
$g4['admin_log_table']      = $g4['table_prefix'] . "admin_log";          // 관리자 log 테이블
$g4['menu_table']           = $g4['table_prefix'] . "menu";               // 메뉴관리 테이블

// 곱슬최씨 (배추팁)
$mw['table_prefix'] = $g4['table_prefix']."mw_";
$mw['board_visit_table'] = $mw['table_prefix']."board_visit";             // 게시판별 방문자 통계
$mw['board_visit_log_table'] = $mw['table_prefix']."board_visit_log";     // 게시판별 방문자 로그
$g4['session_table'] = $g4['table_prefix'] . "session";                   // db로 세션관리

// www.sir.co.kr 과 sir.co.kr 도메인은 서로 다른 도메인으로 인식합니다. 쿠키를 공유하려면 .sir.co.kr 과 같이 입력하세요.
// 이곳에 입력이 없다면 www 붙은 도메인과 그렇지 않은 도메인은 쿠키를 공유하지 않으므로 로그인이 풀릴 수 있습니다.
$g4['cookie_domain'] = "";

// DNS Round Robin, L4 Loading Balancing 등의 경우, 접속시마다 $_SERVER[SERVER_ADDR]이 바뀝니다.
// 따라서, 사이트를 나타낼 수 있는 unique한 이름(예:도메인이름,사이트명,서버ip등)을 써줘야 자동로그인이 안풀립니다.
$g4['load_balance'] = "";

// 게시판에서 링크의 기본갯수를 말합니다.
// 필드를 추가하면 이 숫자를 필드수에 맞게 늘려주십시오.
$g4['link_count'] = 2;

// 문자셋을 정의 (euc-kr/utf-8)
$g4['charset'] = "utf-8";

// config.php 가 있는곳의 웹경로. 뒤에 / 를 붙이지 마세요.
// 예) http://g4.sir.co.kr
$g4['url'] = "";
$g4['https_url'] = "";
// 입력예
//$g4['url'] = "http://www.sir.co.kr";
//$g4['https_url'] = "https://www.sir.co.kr";

// 암호화를 위한 KEY
$g4['encrypt_key'] = "opencode";

// 추천+인증으로 가입을 하기 위해서
$g4['member_suggest_join']  = 0;

// 추천+인증으로 가입할 때, 추천 코드의 유효기간 (기본 7일. 시간이 아니라 날짜다.)
$g4['member_suggest_join_days']  = 7;

// 자동 레벨업을 사용할 것인가를 설정
$g4['use_auto_levelup'] = 0;

// 사용할 session 형태를 지정 합니다. 
// db. memcache. redis. file - 4종 입니다
// memcache를 사용하기 위해서는 PECL:memcache를 설치해야지 하며, memcache 서버의 설치가 필요합니다.
// redis를 사용하기 위해서는 PECL:redis와 phpredis를 설치해야지 합니다. redis 서버의 설치가 필요합니다.
// 4종의 세션관리중 redis를 강력하게 추천 합니다.
$g4['session_type'] = "db";

// memcache 사용할때의 설정
$g4['mhost'] = "localhost";
$g4['mport'] = "11211";
$g4['mpath'] = "tcp://$g4[mhost]:$g4[mport]?persistent=1&weight=2&timeout=2&retry_interval=10";

// redis 사용할때의 설정
$g4['rhost']    = "localhost";
$g4['rport']    = "6379";
$g4['rauth']    = "";             // redis-server password. default는 값이 없다. redis.conf에서 정의
$g4['rdomain']  = "opencode";     // redis domain. 다른 redis instance와 충돌하지 않게 unique하게 잡아줍니다
$g4['rdb']      = "0";            // redis DB space (0) - 세션관리에 사용
$g4['rdb1']     = "1";            // redis DB space (1) - login 관리에 사용. 다른 것들과 안헷갈리게

// redis 세션 path
$g4['rpath']    = "tcp://$g4[rhost]:$g4[rport]?weight=1&auth=$g4[rauth]&database=$g4[rdb]";    

// redis 기본키 구성 - 참조자료
// g4_login     : $g4[rdomain] . "_login_" . $remote_addr

// cdn 경로를 설정 합니다. (예: http://cdnid.imagetong.com)
$g4['cdn_path']          = "";

// 팀장닷컴과 같이 create temporary table이 안먹히는 경우에는 설정값을 1로 하세요.
$g4['old_stype_search'] = 0;

// gblog로 게시글 보내기를 위한 설정
$g4['use_gblog']   = 0;   // gblog로 글보내기를 원치 않을때는, 0으로 설정을 변경하면 됩니다.

// 제목에서 특수문자 모두 없애기
$g4['remove_special_chars'] = 1;    // 1은 없애는거, 0은 안 없애는거
$g4['special_chars_change'] = "☆★◇◆□■△▲▽▼○◎※◁◀▷▶♤♠♧♣◈▣♡♥";  // 없애고 싶은 문자는 요기에 추가/삭제

// phpmyadmin의 경로를 지정
$g4['phpmyadmin_dir'] = $g4['admin_path'] . "/phpMyAdmin/";

// use geo_ip
$g4['use_geo_ip'] = false;

// iframe을 쓰는 경우, 현재의 iframe이 지정된 경우 goto_url을 상위 frame에서 실행하게 한다.
// 특정 프로그램에서만 상위 프로그램에서 실행되게 하는 것도 지정 가능하다.
$g4['goto_url_parent'] = "";
$g4['goto_url_pgm'] = "";

// 이미지 위의 마우스 우클릭 금지를 풀어주기
$is_test = 0;

// cheditor 이미지 업로드 디렉토리
$g4['cheditor_save_dir'] = $g4['data_path'] . "/" . $g4['cheditor4'];

// cheditor의 이미지 업로드 사이즈는 바이트로 줘야 합니다. 
// 예) 5 * 1000 * 1000; // 크기 단위 바이트, 기본값 0 (제한 없음)
$g4['cheditor_uploadsize'] = 0;

// cheditor 이미지 url - 명확하게 URL을 지정해 주는 것이 때로는 더 편하다
$g4['cheditor_image_url'] = $g4['data_path'] . "/" . $g4['cheditor4'];

// 광고를 위해서 변수를 생성한다. 애드센스(1), 애드플러스(2), 리얼클릭(1) - 3종이라 3가지로 기본 생성.
$g4['ad_type'] = rand(1, 3);

// 베스트글 설정은 여기에서
$g4['good_list_rows'] = 30;
$g4['good_list_head'] = "../head.php";
$g4['good_list_tail'] = "../tail.php";
$g4['good_list_skin'] = "basic";
$g4['goodlist_use_list_view'] = false;

// 공지글 설정은 여기에서
$g4['notice_list_rows'] = 30;
$g4['notice_list_head'] = "../head.php";
$g4['notice_list_tail'] = "../tail.php";
$g4['notice_list_skin'] = "basic";
$g4['notice_use_list_view'] = true;

// 새글 설정은 여기에서
$g4['new_use_list_view'] = true;

// 내가 추천한 글/추천 받은 글 설정
$g4['my_good_skin'] = "basic";

// 휴지통 설정
$g4['recycle_skin'] = "basic";
$g4['recycle_page_rows'] = 24;

// 신고 설정
$g4['singo_skin'] = "basic";
$g4['singo_page_rows'] = 24;

// IE의 UA를 정의 - 5, 7, 8, Edge, EmulateIE7 - http://opencode.co.kr/bbs/board.php?bo_table=qna&wr_id=3611
$g4['ie_ua'] = "";

// 검색레벨
$g4['search_level'] = 2;

// 이메일인증시 지급할 포인트
$g4['email_certify_point'] = 100;

// 추천, 비추천 포인트 부여하기
$g4['good_point'] = 20;
$g4['nogood_point'] = -10;

// 키워드 SEO 출력 지원여부
$g4['keyword_seo'] = 1;

// true이면, SQL 오류를 출력, fasle로 바꾸면 모든 SQL 오류가 출력 안됨
$g4['debug'] = true;

// 별명으로만 가입을 허용하기
$g4['nick_reg_only'] = 1;

// 임시글 저장시간 (분단위 입니다. 기본은 5분.)
// 실제로는 1분 이내만 인정하는게 맞는데, 웹 브라우저가 죽기도 하니 5분을 줍니다.
$g4['tempsave_time'] = 5;

// 유니크로 - 유니크로 게시판을 쓰는 경우에만 아래의 주석을 풀어주세요.
//$g4['unicro_item_table']    = $g4['table_prefix'] . "unicro_item"; // 유니크로 아이템 테이블 
//$g4['unicro_url']           = "unicro" . $g4['cookie_domain'];
//$g4['unicro_path']          = $g4['path'] . "/" . "unicro";
?>