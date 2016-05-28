<?
$sub_menu = "300100";
include_once("./_common.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], "w");

if ($member[mb_password] != sql_password($_POST['admin_password'])) {
    alert("패스워드가 다릅니다.");
}

$gr_id = $_POST[gr_id];
$bo_subject = $_POST[bo_subject];

if (!gr_id) { alert("그룹 ID는 반드시 선택하세요."); }
if (!$bo_table) { alert("게시판 TABLE명은 반드시 입력하세요."); }
if (!preg_match("/^([A-Za-z0-9_]{1,20})$/", $bo_table)) { alert("게시판 TABLE명은 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내)"); }
if (!$bo_subject) { alert("게시판 제목을 입력하세요."); }

if ($img = $_FILES[bo_image_head][name]) {
    if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
        alert("상단 이미지가 gif, jpg, png 파일이 아닙니다.");
    }
}

if ($img = $_FILES[bo_image_tail][name]) {
    if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
        alert("하단 이미지가 gif, jpg, png 파일이 아닙니다.");
    }
}

if ($file = $_POST[bo_include_head]) {
    if (!preg_match("/\.(php|htm[l]?)$/i", $file)) {
        alert("상단 파일 경로가 php, html 파일이 아닙니다.");
    }
}

if ($file = $_POST[bo_include_tail]) {
    if (!preg_match("/\.(php|htm[l]?)$/i", $file)) {
        alert("하단 파일 경로가 php, html 파일이 아닙니다.");
    }
}

check_token();

$board_path = "$g4[data_path]/file/$bo_table";

// 게시판 디렉토리 생성
@mkdir($board_path, 0707);
@chmod($board_path, 0707);

// 디렉토리에 있는 파일의 목록을 보이지 않게 한다.
$file = $board_path . "/index.php";
$f = @fopen($file, "w");
@fwrite($f, "");
@fclose($f);
@chmod($file, 0606);

// 분류에 & 나 = 는 사용이 불가하므로 2바이트로 바꾼다.
$src_char = array('&', '=');
$dst_char = array('＆', '〓'); 
$bo_category_list = str_replace($src_char, $dst_char, $bo_category_list);

$bo_use_premium         = $_POST[bo_use_premium];
$bo_use_thumb         = $_POST[bo_use_thumb];
$bo_thumb_percent         = $_POST[bo_thumb_percent];
$bo_thumb_width         = $_POST[bo_thumb_width];
$bo_admin               = $_POST[bo_admin];
$bo_list_level          = $_POST[bo_list_level];
$bo_read_level          = $_POST[bo_read_level];
$bo_search_level        = $_POST[bo_search_level];
$bo_write_level         = $_POST[bo_write_level];
$bo_reply_level         = $_POST[bo_reply_level];
$bo_comment_level       = $_POST[bo_comment_level];
$bo_comment_read_level  = $_POST[bo_comment_read_level];
$bo_html_level          = $_POST[bo_html_level];
$bo_html_level_comment  = $_POST[bo_html_level_comment];
$bo_dhtml_editor_level  = $_POST[bo_dhtml_editor_level];
$bo_dhtml_editor_level_comment  = $_POST[bo_dhtml_editor_level_comment];
$bo_link_level          = $_POST[bo_link_level];
$bo_count_modify        = $_POST[bo_count_modify];
$bo_count_delete        = $_POST[bo_count_delete];
$bo_upload_level        = $_POST[bo_upload_level];
$bo_download_level      = $_POST[bo_download_level];
$bo_read_point          = $_POST[bo_read_point];
$bo_write_point         = $_POST[bo_write_point];
$bo_comment_point       = $_POST[bo_comment_point];
$bo_download_point      = $_POST[bo_download_point];
$bo_use_category        = $_POST[bo_use_category];
$bo_category_list       = $_POST[bo_category_list];
$bo_disable_tags        = $_POST[bo_disable_tags];
$bo_use_sideview        = $_POST[bo_use_sideview];
$bo_use_file_content    = $_POST[bo_use_file_content];
$bo_use_secret          = $_POST[bo_use_secret];
$bo_use_dhtml_editor    = $_POST[bo_use_dhtml_editor];
$bo_use_rss_view        = $_POST[bo_use_rss_view];
$bo_use_comment         = $_POST[bo_use_comment];
$bo_use_good            = $_POST[bo_use_good];
$bo_use_nogood          = $_POST[bo_use_nogood];
$bo_use_name            = $_POST[bo_use_name];
$bo_use_signature       = $_POST[bo_use_signature];
$bo_use_ip_view         = $_POST[bo_use_ip_view];
$bo_use_list_view       = $_POST[bo_use_list_view];
$bo_use_list_content    = $_POST[bo_use_list_content];
$bo_use_email           = $_POST[bo_use_email];
$bo_table_width         = $_POST[bo_table_width];
$bo_subject_len         = $_POST[bo_subject_len];
$bo_page_rows           = $_POST[bo_page_rows];
$bo_new                 = $_POST[bo_new];
$bo_hot                 = $_POST[bo_hot];
$bo_image_width         = $_POST[bo_image_width];
$bo_skin                = $_POST[bo_skin];
$bo_include_head        = $_POST[bo_include_head];
$bo_include_tail        = $_POST[bo_include_tail];
$bo_content_head        = $_POST[bo_content_head];
$bo_content_tail        = $_POST[bo_content_tail];
$bo_insert_content      = $_POST[bo_insert_content];
$bo_gallery_cols        = $_POST[bo_gallery_cols];
$bo_upload_count        = $_POST[bo_upload_count];
$bo_upload_size         = $_POST[bo_upload_size];
$bo_reply_order         = $_POST[bo_reply_order];
$bo_use_search          = $_POST[bo_use_search];
$bo_use_recycle         = $_POST[bo_use_recycle];
$bo_order_search        = $_POST[bo_order_search];
$bo_write_min           = $_POST[bo_write_min];
$bo_write_max           = $_POST[bo_write_max];
$bo_comment_min         = $_POST[bo_comment_min];
$bo_comment_max         = $_POST[bo_comment_max];
$bo_sort_field          = $_POST[bo_sort_field];
$bo_ccl                 = $_POST[bo_ccl];
$bo_source              = $_POST[bo_source];
$bo_notice_comment_allow =$_POST[bo_notice_comment_allow];
$bo_comment_notice      = $_POST[bo_comment_notice];
$bo_related             = $_POST[bo_related];
$bo_popular             = $_POST[bo_popular];
$bo_popular_days        = $_POST[bo_popular_days];
$bo_hidden_comment      = $_POST[bo_hidden_comment];
$bo_singo               = $_POST[bo_singo];
$bo_singo_action        = $_POST[bo_singo_action];
$bo_singo_nowrite       = $_POST[bo_singo_nowrite];
$bo_move_bo_table       = $_POST[bo_move_bo_table];
$bo_print_level         = $_POST[bo_print_level];
$bo_hhp                 = $_POST[bo_hhp];
$bo_hot_list            = $_POST[bo_hot_list];
$bo_hot_list_basis      = $_POST[bo_hot_list_basis];
$bo_sex                 = $_POST[bo_sex];
$bo_day_nowrite         = $_POST[bo_day_nowrite];
$bo_comment_nowrite     = $_POST[bo_comment_nowrite];
$bo_gallery             = $_POST[bo_gallery];
$bo_use_dhtml_comment   = $_POST[bo_use_dhtml_comment];
$bo_image_info          = $_POST[bo_image_info];
$bo_image_max_size      = $_POST[bo_image_max_size];
$bo_naver_notice        = $_POST[bo_naver_notice];
$bo_chimage             = $_POST[bo_chimage];
$bo_list_view           = $_POST[bo_list_view];
$bo_list_comment        = $_POST[bo_list_comment];
$bo_list_good           = $_POST[bo_list_good];
$bo_list_nogood         = $_POST[bo_list_nogood];

$bo_1_subj              = $_POST[bo_1_subj];
$bo_2_subj              = $_POST[bo_2_subj];
$bo_3_subj              = $_POST[bo_3_subj];
$bo_4_subj              = $_POST[bo_4_subj];
$bo_5_subj              = $_POST[bo_5_subj];
$bo_6_subj              = $_POST[bo_6_subj];
$bo_7_subj              = $_POST[bo_7_subj];
$bo_8_subj              = $_POST[bo_8_subj];
$bo_9_subj              = $_POST[bo_9_subj];
$bo_10_subj             = $_POST[bo_10_subj];
$bo_1                   = $_POST[bo_1];
$bo_2                   = $_POST[bo_2];
$bo_3                   = $_POST[bo_3];
$bo_4                   = $_POST[bo_4];
$bo_5                   = $_POST[bo_5];
$bo_6                   = $_POST[bo_6];
$bo_7                   = $_POST[bo_7];
$bo_8                   = $_POST[bo_8];
$bo_9                   = $_POST[bo_9];
$bo_10                  = $_POST[bo_10];
$bo_rtlink				= $_POST[bo_rtlink];

$sql_common = " gr_id               = '$gr_id',
                bo_subject          = '$bo_subject',
                bo_use_premium      = '$bo_use_premium',
                bo_use_thumb        = '$bo_use_thumb',
                bo_thumb_percent    = '$bo_thumb_percent',
                bo_thumb_width    = '$bo_thumb_width',
                bo_admin            = '$bo_admin',
                bo_list_level       = '$bo_list_level',
                bo_read_level       = '$bo_read_level',
                bo_search_level     = '$bo_search_level',
                bo_write_level      = '$bo_write_level',
                bo_reply_level      = '$bo_reply_level',
                bo_comment_level    = '$bo_comment_level',
                bo_comment_read_level = '$bo_comment_read_level',
                bo_html_level       = '$bo_html_level',
                bo_html_level_comment = '$bo_html_level_comment',
                bo_dhtml_editor_level = '$bo_dhtml_editor_level',
                bo_dhtml_editor_level_comment = '$bo_dhtml_editor_level_comment',
                bo_link_level       = '$bo_link_level',
                bo_count_modify     = '$bo_count_modify',
                bo_count_delete     = '$bo_count_delete',
                bo_upload_level     = '$bo_upload_level',
                bo_download_level   = '$bo_download_level',
                bo_read_point       = '$bo_read_point',
                bo_write_point      = '$bo_write_point',
                bo_comment_point    = '$bo_comment_point',
                bo_download_point   = '$bo_download_point',
                bo_use_category     = '$bo_use_category',
                bo_category_list    = '$bo_category_list',
                bo_disable_tags     = '$bo_disable_tags',
                bo_use_sideview     = '$bo_use_sideview',
                bo_use_file_content = '$bo_use_file_content',
                bo_use_secret       = '$bo_use_secret',
                bo_use_dhtml_editor = '$bo_use_dhtml_editor',
                bo_use_rss_view     = '$bo_use_rss_view',
                bo_use_comment      = '$bo_use_comment',
                bo_use_good         = '$bo_use_good',
                bo_use_nogood       = '$bo_use_nogood',
                bo_use_name         = '$bo_use_name',
                bo_use_signature    = '$bo_use_signature',
                bo_use_ip_view      = '$bo_use_ip_view',
                bo_use_list_view    = '$bo_use_list_view',
                bo_use_list_content = '$bo_use_list_content',
                bo_use_email        = '$bo_use_email',
                bo_table_width      = '$bo_table_width',
                bo_subject_len      = '$bo_subject_len',
                bo_page_rows        = '$bo_page_rows',
                bo_new              = '$bo_new',
                bo_hot              = '$bo_hot',
                bo_image_width      = '$bo_image_width',
                bo_skin             = '$bo_skin',
                bo_include_head     = '$bo_include_head',
                bo_include_tail     = '$bo_include_tail',
                bo_content_head     = '$bo_content_head',
                bo_content_tail     = '$bo_content_tail',
                bo_insert_content   = '$bo_insert_content',
                bo_gallery_cols     = '$bo_gallery_cols',
                bo_upload_count     = '$bo_upload_count',
                bo_upload_size      = '$bo_upload_size',
                bo_reply_order      = '$bo_reply_order',
                bo_use_search       = '$bo_use_search',
        		bo_use_recycle      = '$bo_use_recycle',
                bo_order_search     = '$bo_order_search',
                bo_write_min        = '$bo_write_min',
                bo_write_max        = '$bo_write_max',
                bo_comment_min      = '$bo_comment_min',
                bo_comment_max      = '$bo_comment_max',
                bo_sort_field       = '$bo_sort_field',
                bo_ccl              = '$bo_ccl',
                bo_source           = '$bo_source',
                bo_notice_comment_allow           = '$bo_notice_comment_allow',
                bo_comment_notice   = '$bo_comment_notice',
                bo_related          = '$bo_related',
                bo_popular          = '$bo_popular',
                bo_popular_days     = '$bo_popular_days',
                bo_hidden_comment   = '$bo_hidden_comment',
                bo_singo            = '$bo_singo',
                bo_singo_action     = '$bo_singo_action',
                bo_singo_nowrite    = '$bo_singo_nowrite',
                bo_move_bo_table    = '$bo_move_bo_table',
                bo_print_level      = '$bo_print_level',
                bo_hhp              = '$bo_hhp',
                bo_hot_list         = '$bo_hot_list',
                bo_hot_list_basis   = '$bo_hot_list_basis',
                bo_sex              = '$bo_sex',
                bo_day_nowrite      = '$bo_day_nowrite',
                bo_comment_nowrite  = '$bo_comment_nowrite',
                bo_gallery          = '$bo_gallery',
                bo_use_dhtml_comment= '$bo_use_dhtml_comment',
                bo_image_info       = '$bo_image_info',
                bo_image_max_size   = '$bo_image_max_size',
                bo_naver_notice     = '$bo_naver_notice',
                bo_chimage          = '$bo_chimage',
                bo_realcheck        = '$bo_realcheck',
                bo_list_view        = '$bo_list_view',
                bo_list_comment     = '$bo_list_comment',
                bo_list_good        = '$bo_list_good',
                bo_list_nogood      = '$bo_list_nogood',
                bo_read_point_lock  = '$bo_read_point_lock',
                bo_notice_joongbok  = '$bo_notice_joongbok',
                bo_1_subj           = '$bo_1_subj',
                bo_2_subj           = '$bo_2_subj',
                bo_3_subj           = '$bo_3_subj',
                bo_4_subj           = '$bo_4_subj',
                bo_5_subj           = '$bo_5_subj',
                bo_6_subj           = '$bo_6_subj',
                bo_7_subj           = '$bo_7_subj',
                bo_8_subj           = '$bo_8_subj',
                bo_9_subj           = '$bo_9_subj',
                bo_10_subj          = '$bo_10_subj',
                bo_1                = '$bo_1',
                bo_2                = '$bo_2',
                bo_3                = '$bo_3',
                bo_4                = '$bo_4',
                bo_5                = '$bo_5',
                bo_6                = '$bo_6',
                bo_7                = '$bo_7',
                bo_8                = '$bo_8',
                bo_9                = '$bo_9',
                bo_10               = '$bo_10',
				bo_rtlink			= '$bo_rtlink' ";

if ($bo_image_head_del) {
    @unlink("$board_path/$bo_image_head_del");
    $sql_common .= " , bo_image_head = '' ";
}

if ($bo_image_tail_del) {
    @unlink("$board_path/$bo_image_tail_del");
    $sql_common .= " , bo_image_tail = '' ";
}

if ($_FILES[bo_image_head][name]) {
    //$bo_image_head_urlencode = urlencode($_FILES[bo_image_head][name]);
    $bo_image_head_urlencode = $bo_table."_head_".time();
    $sql_common .= " , bo_image_head = '$bo_image_head_urlencode' ";
}

if ($_FILES[bo_image_tail][name]) {
    //$bo_image_tail_urlencode = urlencode($_FILES[bo_image_tail][name]);
    $bo_image_tail_urlencode = $bo_table."_tail_".time();
    $sql_common .= " , bo_image_tail = '$bo_image_tail_urlencode' ";
}

if ($w == "") {
    $row = sql_fetch(" select count(*) as cnt from $g4[board_table] where bo_table = '$bo_table' ");
    if ($row[cnt])
        alert("{$bo_table} 은(는) 이미 존재하는 TABLE 입니다.");

    $sql = " insert into $g4[board_table]
                set bo_table = '$bo_table',
                    bo_count_write = '0',
                    bo_count_comment = '0',
                    $sql_common ";
    sql_query($sql);
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//그룹생성
/*
$gr_sql_common = " gr_subject      = '$bo_subject',
                gr_admin        = '$gr_admin',  
                gr_use_access   = '1',
                gr_use_search   = '1',
                gr_order_search = '$gr_order_search',
                gr_1_subj       = '$gr_1_subj',
                gr_2_subj       = '$gr_2_subj',
                gr_3_subj       = '$gr_3_subj',
                gr_4_subj       = '$gr_4_subj',
                gr_5_subj       = '$gr_5_subj',
                gr_6_subj       = '$gr_6_subj',
                gr_7_subj       = '$gr_7_subj',
                gr_8_subj       = '$gr_8_subj',
                gr_9_subj       = '$gr_9_subj',
                gr_10_subj      = '$gr_10_subj',
                gr_1            = '$gr_1',
                gr_2            = '$gr_2',
                gr_3            = '$gr_3',
                gr_4            = '$gr_4',
                gr_5            = '$gr_5',
                gr_6            = '$gr_6',
                gr_7            = '$gr_7',
                gr_8            = '$gr_8',
                gr_9            = '$gr_9',
                gr_10           = '$gr_10'
                ";

    $gr_sql = " insert into $g4[group_table]
                set gr_id = '$bo_table',
                    $gr_sql_common ";
    sql_query($gr_sql);
*/

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // 게시판 테이블 생성
    $file = file("./sql_write.sql");
    $sql = implode($file, "\n");

    $create_table = $g4[write_prefix] . $bo_table;

    // sql_board.sql 파일의 테이블명을 변환
    $source = array("/__TABLE_NAME__/", "/;/");
    $target = array($create_table, "");
    $sql = preg_replace($source, $target, $sql);
    sql_query($sql, FALSE);
} else if ($w == "u") {
    // 게시판의 글 수
    $sql = " select count(*) as cnt from $g4[write_prefix]$bo_table where wr_is_comment = 0 ";
    $row = sql_fetch($sql);
    $bo_count_write = $row[cnt];

    // 게시판의 코멘트 수
    $sql = " select count(*) as cnt from $g4[write_prefix]$bo_table where wr_is_comment = 1 ";
    $row = sql_fetch($sql);
    $bo_count_comment = $row[cnt];

    // 글수 조정
    if ($proc_count) {
        // 원글을 얻습니다.
        $sql = " select wr_id from $g4[write_prefix]$bo_table where wr_is_comment = 0 ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            // 코멘트수를 얻습니다.
            $sql2 = " select count(*) as cnt from $g4[write_prefix]$bo_table where wr_parent = '$row[wr_id]' and wr_is_comment = 1 ";
            $row2 = sql_fetch($sql2);

            sql_query(" update $g4[write_prefix]$bo_table set wr_comment = '$row2[cnt]' where wr_id = '$row[wr_id]' ");
        }
    }

    // 공지사항에는 등록되어 있지만 실제 존재하지 않는 글 아이디는 삭제합니다.
    $bo_notice = "";
    $lf = "";
    if ($board[bo_notice]) {
        $tmp_array = explode("\n", $board[bo_notice]);
        for ($i=0; $i<count($tmp_array); $i++) {
            $tmp_wr_id = trim($tmp_array[$i]);
            $row = sql_fetch(" select count(*) as cnt from $g4[write_prefix]$bo_table where wr_id = '$tmp_wr_id' ");
            if ($row[cnt]) 
            {
                $bo_notice .= $lf . $tmp_wr_id;
                $lf = "\n";
            }
        }
    }

    $sql = " update $g4[board_table]
                set bo_notice = '$bo_notice',
                    bo_count_write = '$bo_count_write',
                    bo_count_comment = '$bo_count_comment',
                    $sql_common
              where bo_table = '$bo_table' ";
    $result = sql_query($sql);
    
    // 오류가 생기면 추가 필드를 업데이트
    if (!$result) {
        // 1.0.73 - 코멘트 dhtml 편집기 사용
        sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_use_dhtml_comment` TINYINT( 4 ) NOT NULL ", FALSE);

        sql_query($sql);
    }


    //RSS 주소정보 입력
    if($rss_addr){
    
        //rss 정보 초기화
        mysql_query("delete from rss_info where bo_table='$bo_table' and idx<900");

        $rssCnt=count($rss_addr);

        for($d=0;$d<$rssCnt;$d++){

            if($rss_addr[$d]){

                if($rss_opt1[$d]=='0'){
                    $rss_opt1[$d]='';
                }

                if($rss_opt2[$d]=='0'){
                    $rss_opt2[$d]='';
                }

                $rss_ao=$_POST['rss_ao'];

                if(!$rss_ao[$d] or $rss_ao[$d]==0){
                    $rss_ao[$d]=1;
                }

                $rssSql="insert into rss_info set bo_table='$bo_table', rss_addr='{$rss_addr[$d]}', rss_opt1='{$rss_opt1[$d]}', rss_opt2='{$rss_opt2[$d]}', rss_opt3='{$rss_opt3[$d]}', rss_opt4='{$rss_opt4[$d]}', rss_num='{$rss_num[$d]}', rss_ao='{$rss_ao[$d]}', idx='$d'";
                $rssRst=mysql_query($rssSql);

                //echo 'AO'.$d.': '.$rss_ao[$d].'<br>';

            }

        }

    }

    //RSS 원글 링크 체크
    if($rss_olink==1){
        $rssRst2=mysql_query("select count(*) from rss_info where bo_table='$bo_table' and idx=999");
        $rssNum=mysql_fetch_row($rssRst2);
        $rssNum=$rssNum[0];

        if($rssNum==0){
            $rssSql2="insert into rss_info set bo_table='$bo_table', rss_addr='$rss_olink', idx=999";
            mysql_query($rssSql2);
        }else{
            $rssSql2="update rss_info set rss_addr='$rss_olink' where idx=999";
            mysql_query($rssSql2);
        }
    }else{
        $rssRst2=mysql_query("select count(*) from rss_info where bo_table='$bo_table' and idx=999");
        $rssNum=mysql_fetch_row($rssRst2);
        $rssNum=$rssNum[0];

        if($rssNum==0){
            $rssSql2="insert into rss_info set bo_table='$bo_table', rss_addr='0', idx=999";
            mysql_query($rssSql2);
        }else{
            $rssSql2="update rss_info set rss_addr='0' where idx=999";
            mysql_query($rssSql2);
        }
    }

    //제목 클릭 시 새창/현재창 / 1 : 새창, 2 : 현재창
    if($rss_target==1){
        $rssRst2=mysql_query("select count(*) from rss_info where bo_table='$bo_table' and idx=997");
        $rssNum=mysql_fetch_row($rssRst2);
        $rssNum=$rssNum[0];

        if($rssNum==0){
            $rssSql2="insert into rss_info set bo_table='$bo_table', rss_addr='$rss_target', idx=997";
            mysql_query($rssSql2);
        }else{
            $rssSql2="update rss_info set rss_addr='$rss_target' where idx=997";
            mysql_query($rssSql2);
        }
    }else{
        $rssRst2=mysql_query("select count(*) from rss_info where bo_table='$bo_table' and idx=997");
        $rssNum=mysql_fetch_row($rssRst2);
        $rssNum=$rssNum[0];

        if($rssNum==0){
            $rssSql2="insert into rss_info set bo_table='$bo_table', rss_addr='0', idx=997";
            mysql_query($rssSql2);
        }else{
            $rssSql2="update rss_info set rss_addr='0' where idx=997";
            mysql_query($rssSql2);
        }
    }

    //RSS 다시 읽는 주기
    if($rss_term){
        $rssRst2=mysql_query("select count(*) from rss_info where bo_table='$bo_table' and idx=998");
        $rssNum=mysql_fetch_row($rssRst2);
        $rssNum=$rssNum[0];

        if($rssNum==0){
            $rssSql2="insert into rss_info set bo_table='$bo_table', rss_addr='$rss_term', idx=998";
            mysql_query($rssSql2);
        }else{
            $rssSql2="update rss_info set rss_addr='$rss_term' where idx=998";
            mysql_query($rssSql2);
        }
    }else{
        $rssRst2=mysql_query("select count(*) from rss_info where bo_table='$bo_table' and idx=998");
        $rssNum=mysql_fetch_row($rssRst2);
        $rssNum=$rssNum[0];

        if($rssNum==0){
            $rssSql2="insert into rss_info set bo_table='$bo_table', rss_addr='0', idx=998";
            mysql_query($rssSql2);
        }else{

            $rssSql2="update rss_info set rss_addr='0' where idx=998";
            mysql_query($rssSql2);
        }
    }


}


// 같은 그룹내 게시판 동일 옵션 적용
$s = "";
if ($chk_use_premium) $s .= " , bo_use_premium = '$bo_use_premium' ";
if ($chk_use_thumb) $s .= " , bo_use_thumb = '$bo_use_thumb' ";
if ($chk_thumb_percent) $s .= " , bo_thumb_percent = '$bo_thumb_percent' ";
if ($chk_thumb_width) $s .= " , bo_thumb_width = '$bo_thumb_width' ";
if ($chk_admin) $s .= " , bo_admin = '$bo_admin' ";
if ($chk_list_level) $s .= " , bo_list_level = '$bo_list_level' ";
if ($chk_read_level) $s .= " , bo_read_level = '$bo_read_level' ";
if ($chk_search_level) $s .= " , bo_search_level = '$bo_search_level' ";
if ($chk_write_level) $s .= " , bo_write_level = '$bo_write_level' ";
if ($chk_reply_level) $s .= " , bo_reply_level = '$bo_reply_level' ";
if ($chk_comment_level) $s .= " , bo_comment_level = '$bo_comment_level' ";
if ($chk_link_level) $s .= " , bo_link_level = '$bo_link_level' ";
if ($chk_upload_level) $s .= " , bo_upload_level = '$bo_upload_level' ";
if ($chk_download_level) $s .= " , bo_download_level = '$bo_download_level' ";
if ($chk_html_level) $s .= " , bo_html_level = '$bo_html_level' ";
if ($chk_html_level_comment) $s .= " , bo_html_level = '$bo_html_level_comment' ";
if ($chk_dhtml_editor_level) $s .= " , bo_dhtml_editor_level = '$bo_dhtml_editor_level' ";
if ($chk_dhtml_editor_level_comment) $s .= " , bo_dhtml_editor_level_comment = '$bo_dhtml_editor_level_comment' ";
if ($chk_count_modify) $s .= " , bo_count_modify = '$bo_count_modify' ";
if ($chk_count_delete) $s .= " , bo_count_delete = '$bo_count_delete' ";
if ($chk_read_point) $s .= " , bo_read_point = '$bo_read_point' ";
if ($chk_write_point) $s .= " , bo_write_point = '$bo_write_point' ";
if ($chk_comment_point) $s .= " , bo_comment_point = '$bo_comment_point' ";
if ($chk_download_point) $s .= " , bo_download_point = '$bo_download_point' ";
if ($chk_category_list) {
    $s .= " , bo_category_list = '$bo_category_list' ";
    $s .= " , bo_use_category = '$bo_use_category' ";
}
if ($chk_use_sideview) $s .= " , bo_use_sideview = '$bo_use_sideview' ";
if ($chk_use_file_content) $s .= " , bo_use_file_content = '$bo_use_file_content' ";
if ($chk_use_comment) $s .= " , bo_use_comment = '$bo_use_comment' ";
if ($chk_use_secret) $s .= " , bo_use_secret = '$bo_use_secret' ";
if ($chk_use_dhtml_editor) $s .= " , bo_use_dhtml_editor = '$bo_use_dhtml_editor' ";
if ($chk_use_rss_view) $s .= " , bo_use_rss_view = '$bo_use_rss_view' ";
if ($chk_use_good) $s .= " , bo_use_good = '$bo_use_good' ";
if ($chk_use_nogood) $s .= " , bo_use_nogood = '$bo_use_nogood' ";
if ($chk_use_name) $s .= " , bo_use_name = '$bo_use_name' ";
if ($chk_use_signature) $s .= " , bo_use_signature = '$bo_use_signature' ";
if ($chk_use_ip_view) $s .= " , bo_use_ip_view = '$bo_use_ip_view' ";
if ($chk_use_list_view) $s .= " , bo_use_list_view = '$bo_use_list_view' ";
if ($chk_use_list_content) $s .= " , bo_use_list_content = '$bo_use_list_content' ";
if ($chk_use_email) $s .= " , bo_use_email = '$bo_use_email' ";
if ($chk_skin) $s .= " , bo_skin = '$bo_skin' ";
if ($chk_gallery_cols) $s .= " , bo_gallery_cols = '$bo_gallery_cols' ";
if ($chk_table_width) $s .= " , bo_table_width = '$bo_table_width' ";
if ($chk_page_rows) $s .= " , bo_page_rows = '$bo_page_rows' ";
if ($chk_subject_len) $s .= " , bo_subject_len = '$bo_subject_len' ";
if ($chk_new) $s .= " , bo_new = '$bo_new' ";
if ($chk_hot) $s .= " , bo_hot = '$bo_hot' ";
if ($chk_image_width) $s .= " , bo_image_width = '$bo_image_width' ";
if ($chk_reply_order) $s .= " , bo_reply_order = '$bo_reply_order' ";
if ($chk_disable_tags) $s .= " , bo_disable_tags = '$bo_disable_tags' ";
if ($chk_sort_field) $s .= " , bo_sort_field = '$bo_sort_field' ";
if ($chk_write_min) $s .= " , bo_write_min = '$bo_write_min' ";
if ($chk_write_max) $s .= " , bo_write_max = '$bo_write_max' ";
if ($chk_comment_min) $s .= " , bo_comment_min = '$bo_comment_min' ";
if ($chk_comment_max) $s .= " , bo_comment_max = '$bo_comment_max' ";
if ($chk_upload_count) $s .= " , bo_upload_count = '$bo_upload_count' ";
if ($chk_upload_size) $s .= " , bo_upload_size = '$bo_upload_size' ";
if ($chk_include_head) $s .= " , bo_include_head = '$bo_include_head' ";
if ($chk_include_tail) $s .= " , bo_include_tail = '$bo_include_tail' ";
if ($chk_content_head) $s .= " , bo_content_head = '$bo_content_head' ";
if ($chk_content_tail) $s .= " , bo_content_tail = '$bo_content_tail' ";
if ($chk_insert_content) $s .= " , bo_insert_content = '$bo_insert_content' ";

if ($chk_ccl) $s .= " , bo_ccl = '$bo_ccl' ";
if ($chk_source) $s .= " , bo_source = '$bo_source' ";
if ($chk_notice_comment_allow) $s .= " , bo_notice_comment_allow = '$bo_notice_comment_allow' ";
if ($chk_bo_comment_notice) $s .= " , bo_comment_notice = '$bo_comment_notice' ";
if ($chk_related) $s .= " , bo_related = '$bo_related' ";
if ($chk_popular) $s .= " , bo_popular = '$bo_popular' ";
if ($chk_popular_days) $s .= " , bo_popular_days = '$bo_popular_days' ";
if ($chk_hidden_comment) $s .= " , bo_hidden_comment = '$bo_hidden_comment' ";
if ($chk_singo) $s .= " , bo_singo = '$bo_singo' ";
if ($chk_singo_action) $s .= " , bo_singo_action = '$bo_singo_action' ";
if ($chk_singo_nowrite) $s .= " , bo_singo_nowrite = '$bo_singo_nowrite' ";
if ($chk_bo_move_bo_table) $s .= " , bo_move_bo_table = '$bo_move_bo_table' ";
if ($chk_bo_print_level) $s .= " , bo_print_level = '$bo_print_level' ";
if ($chk_hhp) $s .= " , bo_hhp = '$bo_hhp' ";
if ($chk_hot_list){
    $s .= " , bo_hot_list = '$bo_hot_list' ";
    $s .= " , bo_hot_list_basis = '$bo_hot_list_basis' ";
}
if ($chk_bo_sex) $s .= " , bo_sex = '$bo_sex' ";
if ($chk_bo_day_nowrite) $s .= " , bo_day_nowrite = '$bo_day_nowrite' ";
if ($chk_bo_comment_nowrite) $s .= " , bo_comment_nowrite = '$bo_comment_nowrite' ";
if ($chk_bo_gallery) $s .= " , bo_gallery = '$bo_gallery' ";
if ($chk_bo_use_dhtml_comment) $s .= " , bo_use_dhtml_comment = '$bo_use_dhtml_comment' ";
if ($chk_comment_read_level) $s .= " , bo_comment_read_level = '$bo_comment_read_level' ";
if ($chk_use_search) $s .= " , bo_use_search = '$bo_use_search' ";
if ($chk_bo_use_recycle) $s .= " , bo_use_recycle = '$bo_use_recycle' ";
if ($chk_bo_image_info) $s .= " , bo_image_info = '$bo_image_info' ";
if ($chk_bo_image_max_size) $s .= " , bo_image_max_size = '$bo_image_max_size' ";
if ($chk_naver_notice) $s .= " , bo_naver_notice = '$bo_naver_notice' ";
if ($chk_chimage) $s .= " , bo_chimage = '$bo_chimage' ";
if ($chk_realcheck) $s .= " , bo_realcheck = '$bo_realcheck' ";
if ($chk_list_view) $s .= " , bo_list_view = '$bo_list_view' ";
if ($chk_list_comment) $s .= " , bo_list_comment = '$bo_list_comment' ";
if ($chk_list_good) $s .= " , bo_list_good = '$bo_list_good' ";
if ($chk_list_nogood) $s .= " , bo_list_nogood = '$bo_list_nogood' ";
if ($chk_read_point_lock) $s .= " , bo_read_point_lock = '$bo_read_point_lock' ";
if ($chk_notice_joongbok) $s .= " , bo_notice_joongbok = '$bo_notice_joongbok' ";

if ($chk_order_search) $s .= " , bo_order_search = '$bo_order_search' ";
for ($i=1; $i<=10; $i++) {
    if ($_POST["chk_{$i}"]) {
        $s .= " , bo_{$i}_subj = '".$_POST["bo_{$i}_subj"]."' ";
        $s .= " , bo_{$i} = '".$_POST["bo_{$i}"]."' ";
    }
}

if ($s) {
        $sql = " update $g4[board_table]
                    set bo_table = bo_table
                        {$s}
                  where gr_id = '$gr_id' ";
        sql_query($sql);
}


if ($_FILES[bo_image_head][name]) { 
    $bo_image_head_path = "$board_path/$bo_image_head_urlencode";
    move_uploaded_file($_FILES[bo_image_head][tmp_name], $bo_image_head_path);
    chmod($bo_image_head_path, 0606);
}

if ($_FILES[bo_image_tail][name]) { 
    $bo_image_tail_path = "$board_path/$bo_image_tail_urlencode";
    move_uploaded_file($_FILES[bo_image_tail][tmp_name], $bo_image_tail_path);
    chmod($bo_image_tail_path, 0606);
}

// 불당팩 - 그룹아이디가 변경되었을 때 (board_form.php에 gr_id_2를 hidden으로 추가했슴)
if ($w == 'u' && $gr_id != $_POST[gr_id_2]) { 
    // 최근글 게시판의 gr_id를 변경
    $sql = " update $g4[board_new_table] set gr_id = '$gr_id' where bo_table = '$bo_table' "; 
    sql_query($sql); 
    // 게시판별 방문자 테이블의 gr_id를 변경
    //$sql = " update $mw[board_visit_table] set gr_id = '$gr_id' where bo_table = '$bo_table' "; 
    //sql_query($sql);
    // 다운로드 내역 테이블의 gr_id를 변경
    $sql = " update " . $g4[board_file_table] . "_download set gr_id = '$gr_id' where bo_table = '$bo_table' "; 
    sql_query($sql);
    // 베스트글 테이블의 gr_id를 변경
    $sql = " update $g4[good_list_table] set gr_id = '$gr_id' where bo_table = '$bo_table' "; 
    sql_query($sql);
}

// 불당팩 - 공지사항 정렬하기
$notice_list = $_POST[notice_list];
$notice_count = count($notice_list);
$bo_notice = "";

for($i=0; $i < $notice_count; $i++) {
    if ($i != $notice_count-1)
        $bo_notice .= $notice_list[$i] . '\n';
    else
        $bo_notice .= $notice_list[$i];
}

$sql = " update $g4[board_table] set bo_notice = '$bo_notice' where bo_table = '$bo_table' ";
sql_query("$sql");

goto_url("./board_form.php?w=u&bo_table=$bo_table&$qstr");
?>
