<?
$sub_menu = "100100";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if ($member[mb_password] != sql_password($_POST['admin_password'])) {
    alert("패스워드가 다릅니다.");
}

$mb = get_member($cf_admin);
if (!$mb[mb_id])
    alert("최고관리자 회원아이디가 존재하지 않습니다.");

check_token();


$cf_title                = $_POST[cf_title];
$cf_admin                = $_POST[cf_admin];
$cf_use_point            = $_POST[cf_use_point];
$cf_use_norobot          = $_POST[cf_use_norobot];
$cf_use_copy_log         = $_POST[cf_use_copy_log];
$cf_use_email_certify    = $_POST[cf_use_email_certify];
$cf_login_point          = $_POST[cf_login_point];
$cf_cut_name             = $_POST[cf_cut_name];
$cf_nick_modify          = $_POST[cf_nick_modify];
$cf_new_skin             = $_POST[cf_new_skin];
$cf_new_rows             = $_POST[cf_new_rows];
$cf_search_skin          = $_POST[cf_search_skin];
$cf_connect_skin         = $_POST[cf_connect_skin];
$cf_read_point           = $_POST[cf_read_point];
$cf_write_point          = $_POST[cf_write_point];
$cf_comment_point        = $_POST[cf_comment_point];
$cf_download_point       = $_POST[cf_download_point];
$cf_search_bgcolor       = $_POST[cf_search_bgcolor];
$cf_search_color         = $_POST[cf_search_color];
$cf_write_pages          = $_POST[cf_write_pages];
$cf_link_target          = $_POST[cf_link_target];
$cf_delay_sec            = $_POST[cf_delay_sec];
$cf_delay_level          = $_POST[cf_delay_level];
$cf_delay_point          = $_POST[cf_delay_point];
$cf_filter               = $_POST[cf_filter];
$cf_possible_ip          = trim($_POST[cf_possible_ip]);
$cf_intercept_ip         = trim($_POST[cf_intercept_ip]);
$cf_member_skin          = $_POST[cf_member_skin];
$cf_use_homepage         = $_POST[cf_use_homepage];
$cf_req_homepage         = $_POST[cf_req_homepage];
$cf_use_tel              = $_POST[cf_use_tel];
$cf_req_tel              = $_POST[cf_req_tel];
$cf_use_hp               = $_POST[cf_use_hp];
$cf_req_hp               = $_POST[cf_req_hp];
$cf_use_region           = $_POST[cf_use_region];
$cf_region_change_term   = $_POST[cf_region_change_term];
$cf_region_change_term_last   = $_POST[cf_region_change_term_last];
$cf_use_addr             = $_POST[cf_use_addr];
$cf_req_addr             = $_POST[cf_req_addr];
$cf_use_signature        = $_POST[cf_use_signature];
$cf_req_signature        = $_POST[cf_req_signature];
$cf_use_profile          = $_POST[cf_use_profile];
$cf_req_profile          = $_POST[cf_req_profile];
$cf_use_sex              = $_POST[cf_use_sex];
$cf_use_birthdate        = $_POST[cf_use_birthdate];
$cf_register_level       = $_POST[cf_register_level];
$cf_register_point       = $_POST[cf_register_point];
$cf_icon_level           = $_POST[cf_icon_level];
$cf_use_recommend        = $_POST[cf_use_recommend];
$cf_req_recommend        = $_POST[cf_req_recommend];
$cf_recommend_point      = $_POST[cf_recommend_point];
$cf_leave_day            = $_POST[cf_leave_day];
$cf_search_part          = $_POST[cf_search_part];
$cf_email_use            = $_POST[cf_email_use];
$cf_email_wr_super_admin = $_POST[cf_email_wr_super_admin];
$cf_email_wr_group_admin = $_POST[cf_email_wr_group_admin];
$cf_email_wr_board_admin = $_POST[cf_email_wr_board_admin];
$cf_email_wr_write       = $_POST[cf_email_wr_write];
$cf_email_wr_comment_all = $_POST[cf_email_wr_comment_all];
$cf_email_mb_super_admin = $_POST[cf_email_mb_super_admin];
$cf_email_mb_member      = $_POST[cf_email_mb_member];
$cf_email_po_super_admin = $_POST[cf_email_po_super_admin];
$cf_prohibit_id          = $_POST[cf_prohibit_id];
$cf_prohibit_email       = $_POST[cf_prohibit_email];
$cf_new_del              = $_POST[cf_new_del];
$cf_memo_del             = $_POST[cf_memo_del];
$cf_visit_del            = $_POST[cf_visit_del];
$cf_popular_del          = $_POST[cf_popular_del];
$cf_use_member_icon      = $_POST[cf_use_member_icon];
$cf_member_icon_size     = $_POST[cf_member_icon_size];
$cf_member_icon_width    = $_POST[cf_member_icon_width];
$cf_member_icon_height   = $_POST[cf_member_icon_height];
$cf_login_minutes        = $_POST[cf_login_minutes];
$cf_image_extension      = $_POST[cf_image_extension];
$cf_flash_extension      = $_POST[cf_flash_extension];
$cf_movie_extension      = $_POST[cf_movie_extension];
$cf_formmail_is_member   = $_POST[cf_formmail_is_member];
$cf_page_rows            = $_POST[cf_page_rows];
$cf_open_modify          = $_POST[cf_open_modify];
$cf_memo_send_point      = $_POST[cf_memo_send_point];
$cf_password_change_dates= $_POST[cf_password_change_dates];
$cf_singo_intercept_count= $_POST[cf_singo_intercept_count];
$cf_singo_today_count    = $_POST[cf_singo_today_count];
$cf_singo_point          = $_POST[cf_singo_point];
$cf_singo_point_send     = $_POST[cf_singo_point_send];
$cf_singo_point_recv     = $_POST[cf_singo_point_recv];
$cf_hp_certify           = $_POST[cf_hp_certify];
$cf_hp_certify_message   = $_POST[cf_hp_certify_message];
$cf_hp_certify_return    = $_POST[cf_hp_certify_return];
$cf_no_comment_point_days= $_POST[cf_no_comment_point_days];
$cf_retry_time_interval  = $_POST[cf_retry_time_interval];
$cf_retry_count          = $_POST[cf_retry_count];
$cf_double_login         = $_POST[cf_double_login];
$cf_meta_author          = $_POST[cf_meta_author];
$cf_meta_keywords        = $_POST[cf_meta_keywords];
$cf_meta_description     = $_POST[cf_meta_description];
$cf_memo_mb_member       = $_POST[cf_memo_mb_member];

$cf_1_subj               = $_POST[cf_1_subj];
$cf_2_subj               = $_POST[cf_2_subj];
$cf_3_subj               = $_POST[cf_3_subj];
$cf_4_subj               = $_POST[cf_4_subj];
$cf_5_subj               = $_POST[cf_5_subj];
$cf_6_subj               = $_POST[cf_6_subj];
$cf_7_subj               = $_POST[cf_7_subj];
$cf_8_subj               = $_POST[cf_8_subj];
$cf_9_subj               = $_POST[cf_9_subj];
$cf_10_subj              = $_POST[cf_10_subj];
$cf_1                    = $_POST[cf_1];
$cf_2                    = $_POST[cf_2];
$cf_3                    = $_POST[cf_3];
$cf_4                    = $_POST[cf_4];
$cf_5                    = $_POST[cf_5];
$cf_6                    = $_POST[cf_6];
$cf_7                    = $_POST[cf_7];
$cf_8                    = $_POST[cf_8];
$cf_9                    = $_POST[cf_9];
$cf_10                   = $_POST[cf_10];

$cf_stipulation          = $_POST[cf_stipulation];
$cf_privacy              = $_POST[cf_privacy];
$cf_privacy_1            = $_POST[cf_privacy_1];
$cf_privacy_2            = $_POST[cf_privacy_2];
$cf_privacy_3            = $_POST[cf_privacy_3];
$cf_privacy_4            = $_POST[cf_privacy_4];
$cf_privacy_5            = $_POST[cf_privacy_5];

$cf_use_recycle          = $_POST[cf_use_recycle];
$cf_recycle_table        = $_POST[cf_recycle_table];
$cf_recycle_days         = $_POST[cf_recycle_days];

//지역 수정 가능일 수 변경 시 DB 회원정보 전체에 즉시 반영
if($cf_region_change_term){
	
	$pterm=$cf_region_change_term-$cf_region_change_term_last;
	if($pterm<0){
		$sym='-';
		$pterm=abs($pterm);
	}else{
		$sym='+';
		$pterm=abs($pterm);	
	}
	mysql_query("update g4_member set mb_7=(mb_7 ".$sym." interval ".$pterm." day)");	
}


$cf_region_change_term   = $cf_region_change_term_last   = $_POST[cf_region_change_term];



// 휴지통 지정된 게시판이 존재하는지 확인
if ($cf_recycle_table) {
    $board = get_board("$cf_recycle_table");
    if (!$board)
        alert("휴지통으로지정된 게시판이 존재하지 않습니다. $cf_recycle_table 게시판을 생성하지기 바랍니다.");
}

$sql = " update $g4[config_table]
            set cf_title                = '$cf_title',
                cf_admin                = '$cf_admin',
                cf_use_point            = '$cf_use_point',
                cf_use_norobot          = '$cf_use_norobot',
                cf_use_copy_log         = '$cf_use_copy_log',
                cf_use_email_certify    = '$cf_use_email_certify',
                cf_login_point          = '$cf_login_point',
                cf_cut_name             = '$cf_cut_name',
                cf_nick_modify          = '$cf_nick_modify',
                cf_new_skin             = '$cf_new_skin',
                cf_new_rows             = '$cf_new_rows',
                cf_search_skin          = '$cf_search_skin',
                cf_connect_skin         = '$cf_connect_skin',
                cf_read_point           = '$cf_read_point',
                cf_write_point          = '$cf_write_point',
                cf_comment_point        = '$cf_comment_point',
                cf_download_point       = '$cf_download_point',
                cf_search_bgcolor       = '$cf_search_bgcolor',
                cf_search_color         = '$cf_search_color',
                cf_write_pages          = '$cf_write_pages',
                cf_link_target          = '$cf_link_target',
                cf_delay_sec            = '$cf_delay_sec',
                cf_delay_level          = '$cf_delay_level',
                cf_delay_point          = '$cf_delay_point',
                cf_possible_ip          = '".$cf_possible_ip."',
                cf_intercept_ip         = '".$cf_intercept_ip."',
                cf_member_skin          = '$cf_member_skin',
                cf_use_homepage         = '$cf_use_homepage',
                cf_req_homepage         = '$cf_req_homepage',
                cf_use_tel              = '$cf_use_tel',
                cf_req_tel              = '$cf_req_tel',
                cf_use_hp               = '$cf_use_hp',
                cf_req_hp               = '$cf_req_hp',
                cf_use_region           = '$cf_use_region',
                cf_region_change_term   = '$cf_region_change_term',
                cf_region_change_term_last   = '$cf_region_change_term_last',
                cf_use_addr             = '$cf_use_addr',
                cf_req_addr             = '$cf_req_addr',
                cf_use_signature        = '$cf_use_signature',
                cf_req_signature        = '$cf_req_signature',
                cf_use_profile          = '$cf_use_profile',
                cf_req_profile          = '$cf_req_profile',
                cf_use_sex              = '$cf_use_sex',
                cf_use_birthdate        = '$cf_use_birthdate',
                cf_register_level       = '$cf_register_level',
                cf_register_point       = '$cf_register_point',
                cf_icon_level           = '$cf_icon_level',
                cf_use_recommend        = '$cf_use_recommend',
                cf_req_recommend        = '$cf_req_recommend',
                cf_recommend_point      = '$cf_recommend_point',
                cf_leave_day            = '$cf_leave_day',
                cf_search_part          = '$cf_search_part',
                cf_email_use            = '$cf_email_use',
                cf_email_wr_super_admin = '$cf_email_wr_super_admin',
                cf_email_wr_group_admin = '$cf_email_wr_group_admin',
                cf_email_wr_board_admin = '$cf_email_wr_board_admin',
                cf_email_wr_write       = '$cf_email_wr_write',
                cf_email_wr_comment_all = '$cf_email_wr_comment_all',
                cf_email_mb_super_admin = '$cf_email_mb_super_admin',
                cf_email_mb_member      = '$cf_email_mb_member',
                cf_email_po_super_admin = '$cf_email_po_super_admin',
                cf_prohibit_id          = '$cf_prohibit_id',
                cf_prohibit_email       = '$cf_prohibit_email',
                cf_new_del              = '$cf_new_del',
                cf_memo_del             = '$cf_memo_del',
                cf_visit_del            = '$cf_visit_del',
                cf_popular_del          = '$cf_popular_del',
                cf_member_icon_size     = '$cf_member_icon_size',
                cf_member_icon_width    = '$cf_member_icon_width',
                cf_member_icon_height   = '$cf_member_icon_height',
                cf_login_minutes        = '$cf_login_minutes',
                cf_image_extension      = '$cf_image_extension',
                cf_flash_extension      = '$cf_flash_extension',
                cf_movie_extension      = '$cf_movie_extension',
                cf_formmail_is_member   = '$cf_formmail_is_member',
                cf_page_rows            = '$cf_page_rows',
                cf_open_modify          = '$cf_open_modify',
                cf_memo_send_point      = '$cf_memo_send_point',
                cf_password_change_dates= '$cf_password_change_dates',
                cf_singo_intercept_count = '$cf_singo_intercept_count',
                cf_singo_today_count    = '$cf_singo_today_count',
                cf_singo_point          = '$cf_singo_point',
                cf_singo_point_send     = '$cf_singo_point_send',
                cf_singo_point_recv     = '$cf_singo_point_recv',
                cf_hp_certify           = '$cf_hp_certify',
                cf_hp_certify_message   = '$cf_hp_certify_message',
                cf_hp_certify_return    = '$cf_hp_certify_return',
                cf_no_comment_point_days= '$cf_no_comment_point_days',
                cf_retry_time_interval  = '$cf_retry_time_interval',
                cf_retry_count          = '$cf_retry_count',
                cf_double_login         = '$cf_double_login',
                cf_meta_author          = '$cf_meta_author',
                cf_meta_keywords        = '$cf_meta_keywords',
                cf_meta_description     = '$cf_meta_description',
                cf_memo_mb_member       = '$cf_memo_mb_member',
				cf_use_recycle          = '$cf_use_recycle',
				cf_recycle_table        = '$cf_recycle_table',
				cf_recycle_days         = '$cf_recycle_days',
                cf_filter               = '$cf_filter',
                cf_1_subj               = '$cf_1_subj',
                cf_2_subj               = '$cf_2_subj',
                cf_3_subj               = '$cf_3_subj',
                cf_4_subj               = '$cf_4_subj',
                cf_5_subj               = '$cf_5_subj',
                cf_6_subj               = '$cf_6_subj',
                cf_7_subj               = '$cf_7_subj',
                cf_8_subj               = '$cf_8_subj',
                cf_9_subj               = '$cf_9_subj',
                cf_10_subj              = '$cf_10_subj',
                cf_1                    = '$cf_1',
                cf_2                    = '$cf_2',
                cf_3                    = '$cf_3',
                cf_4                    = '$cf_4',
                cf_5                    = '$cf_5',
                cf_6                    = '$cf_6',
                cf_7                    = '$cf_7',
                cf_8                    = '$cf_8',
                cf_9                    = '$cf_9',
                cf_10                   = '$cf_10'
                ";
sql_query($sql);

// 불당팩 - 회원가입기본 정보 (약관 등)
$sql = " update $g4[config_reg_table]
            set cf_stipulation          = '$cf_stipulation',
                cf_privacy              = '$cf_privacy',
                cf_privacy_1            = '$cf_privacy_1',
                cf_privacy_2            = '$cf_privacy_2',
                cf_privacy_3            = '$cf_privacy_3',
                cf_privacy_4            = '$cf_privacy_4',
                cf_privacy_5            = '$cf_privacy_5'
                ";
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g4[config_table]` ");

goto_url("./config_form.php", false);
?>
