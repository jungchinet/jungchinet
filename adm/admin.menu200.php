<?
$menu["menu200"] = array (
    array("200000", "회원관리", ""),
    array("200100", "회원관리", "$g4[admin_path]/member_list.php"),
    array("200600", "회원그룹관리", "$g4[admin_path]/ug_list.php"),
    array("-"),
    array("200101", "탈퇴한회원보기", "$g4[admin_path]/member_list.php?&sst=mb_leave_date&sod=desc"),
    array("200102", "회원가입통계", "$g4[admin_path]/member_join_stat.php"),
    array("200103", "로그인오류보기", "$g4[admin_path]/login_fail_list.php"),
    array("200190", "닉네임변경이력", "$g4[admin_path]/nickname_list.php"),
    array("-"),
    array("200200", "포인트관리", "$g4[admin_path]/point_list.php"),
    array("200300", "회원메일발송", "$g4[admin_path]/mail_list.php"),
    array("200310", "회원메일도메인", "$g4[admin_path]/mail_domain_list.php"),
		array("200400", "회원권한명관리", "$g4[admin_path]/memberGroup_list.php"),
		array("200500", "회원레벨관리", "$g4[admin_path]/member_level_list.php"),
    array("-"),
    array("200710", "필터관리", "$g4[admin_path]/filter_list.php"),    
    array("200700", "인기검색어관리", "$g4[admin_path]/popular_list.php"),
    array("", "키워드 관리", "$g4[admin_path]/keyword.php"),
    array("-"),
    array("200800", "접속자현황", "$g4[admin_path]/visit_list.php"),
    array("200810", "게시판별접속자", "$g4[admin_path]/mw.adm/board_visit_list.php"),
    array("200850", "SEO-유입키워드", "$g4[admin_path]/seo_keyword_list.php"),
    array("-"),
    array("200900", "투표관리", "$g4[admin_path]/poll_list.php")
);

//    array("200310", "회원메일검증", "$g4[admin_path]/mail_validate.php"),
?>
