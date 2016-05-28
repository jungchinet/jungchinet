<?
set_time_limit(0);

$g4['path'] = "..";
include_once ("../config.php");
include_once ("../config.2.php");
include_once("../memo.config.php");

// 파일이 존재한다면 설치할 수 없다.
if (file_exists("../dbconfig.php")) {
    echo "<meta http-equiv='content-type' content='text/html; charset=$g4[charset]'>";
    echo <<<HEREDOC
    <script language="JavaScript">
    alert("설치하실 수 없습니다.");
    location.href="../";
    </script>
HEREDOC;
    exit;
}

$gmnow = gmdate("D, d M Y H:i:s") . " GMT";
header("Expires: 0"); // rfc2616 - Section 14.21
header("Last-Modified: " . $gmnow);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0

$mysql_host  = $_POST['mysql_host'];
$mysql_user  = $_POST['mysql_user'];
$mysql_pass  = $_POST['mysql_pass'];
$mysql_db    = $_POST['mysql_db'];
$admin_id    = $_POST['admin_id'];
$admin_pass  = $_POST['admin_pass'];
$admin_name  = $_POST['admin_name'];
$admin_email = $_POST['admin_email'];

if (strtolower($g4['charset']) == 'utf-8') @mysql_query("set names utf8"); 
else if (strtolower($g4['charset']) == 'euc-kr') @mysql_query("set names euckr"); 
$dblink = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
if (!$dblink) {
    echo "<meta http-equiv='content-type' content='text/html; charset=$g4[charset]'>";
    echo "<script language='JavaScript'>alert('MySQL Host, User, Password 를 확인해 주십시오.');history.back();</script>"; 
    exit;
}

if (strtolower($g4[charset]) == 'utf-8') @mysql_query("set names utf8"); 
else if (strtolower($g4[charset]) == 'euc-kr') @mysql_query("set names euckr"); 
$select_db = @mysql_select_db($mysql_db, $dblink);
if (!$select_db) {
    echo "<meta http-equiv='content-type' content='text/html; charset=$g4[charset]'>";
    echo "<script language='JavaScript'>alert('MySQL DB 를 확인해 주십시오.');history.back();</script>"; 
    exit;
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?=$g4[charset]?>">
<title>그누보드4 설치 (3/3) - DB</title>
<style type="text/css">
.body {
    font-family: 굴림;
	font-size: 12px;
}
.box {
	background-color: #FCFCFC;
    color:#B19265;
    font-family:굴림;
	font-size: 12px;
}
.nobox {
	background-color: #FCFCFC;
    border-style:none;
    font-family:굴림;
    font-size: 12px;
}
</style>
</head>

<body background="img/all_bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div align="center">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="587" border="0" cellspacing="0" cellpadding="0">
    <form name=frminstall2>
    <tr> 
                <td colspan="3"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="587" height="22">
                        <param name="movie" value="../install/img/top.swf">
                        <param name="quality" value="high">
                        <embed src="../install/img/top.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="587" height="22"></embed></object></td>
    </tr>
    <tr> 
      <td width="3"><img src="../install/img/box_left.gif" width="3" height="340"></td>
      <td width="581" valign="top" bgcolor="#FCFCFC"><table width="581" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><img src="../install/img/box_title.gif" width="581" height="56"></td>
          </tr>
        </table>
        <br>
        <table width="541" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
          <tr> 
            <td>설치를 시작합니다. <font color="#CC0000">설치중 작업을 중단하지 마십시오. </font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><div align="left">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="status_bar" type="text" class="box" size="76" readonly></div></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><table width="350" border="0" align="center" cellpadding="5" cellspacing="0" class="body">
                <tr> 
                  <td width="50"> </td>
                  <td width="300"><input type=text name=job1 class=nobox size=80 readonly></td>
                </tr>
                <tr> 
                  <td width="50"> </td>
                  <td width="300"><input type=text name=job2 class=nobox size=80 readonly></td>
                </tr>
                <tr> 
                  <td width="50"> </td>
                  <td width="300"><input type=text name=job3 class=nobox size=80 readonly></td>
                </tr>
                <tr> 
                  <td width="50"> 
                    <div align="center"></div></td>
                  <td width="300"><input type=text name=job4 class=nobox size=80 readonly></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input type=text name=job5 class=nobox size=90 readonly></td>
          </tr>
        </table>
        <table width="562" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height=20><img src="../install/img/box_line.gif" width="562" height="2"></td>
          </tr>
        </table>
        <table width="551" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td align="right"> 
              <input type="button" name="btn_next" disabled value="메인화면" onclick="location.href='../';">
            </td>
          </tr>
        </table></td>
      <td width="3"><img src="../install/img/box_right.gif" width="3" height="340"></td>
    </tr>
    <tr> 
      <td colspan="3"><img src="../install/img/box_bottom.gif" width="587" height="3"></td>
    </tr>
    </form>
  </table>
</div>
<?
flush(); usleep(50000); 

// 테이블 생성 ------------------------------------
$file = implode("", file("./sql_gnuboard4.sql"));
eval("\$file = \"$file\";");

$f = explode(";", $file);
for ($i=0; $i<count($f); $i++) {
    if (trim($f[$i]) == "") continue;
    mysql_query($f[$i]) or die(mysql_error());
}
// 테이블 생성 ------------------------------------


// 테이블 생성 (불당팩) ----------------------------
$file = implode("", file("./sql_opencode.sql"));
eval("\$file = \"$file\";");

$f = explode(";", $file);
for ($i=0; $i<count($f); $i++) {
    if (trim($f[$i]) == "") continue;
    mysql_query($f[$i]) or die(mysql_error());
}
// 테이블 생성 (불당팩) -----------------------------

// 테이블 생성 (sms4) ----------------------------
$file = implode("", file("../adm/sms_admin/sms4.sql"));
eval("\$file = \"$file\";");

$f = explode(";", $file);
for ($i=0; $i<count($f); $i++) {
    if (trim($f[$i]) == "") continue;
    mysql_query($f[$i]) or die(mysql_error());
}
// 테이블 생성 (sms4) -----------------------------

//-------------------------------------------------------------------------------------------------
// sms4 config 테이블 설정
$read_point = -1;
$write_point = 5;
$comment_point = 1;
$download_point = -20;

$sql = " insert into $g4[sms4_book_group_table] set bg_name='미분류'";
mysql_query($sql) or die(mysql_error() . "<p>" . $sql);
//-------------------------------------------------------------------------------------------------

echo "<script>document.frminstall2.job1.value='전체 테이블 생성중';</script>";
flush(); usleep(50000); 

for ($i=0; $i<45; $i++)
{
    echo "<script language='JavaScript'>document.frminstall2.status_bar.value += '■';</script>\n";
    flush();
    usleep(500); 
}

echo "<script>document.frminstall2.job1.value='전체 테이블 생성 완료';</script>";
flush(); usleep(50000); 

$read_point = 10;
$write_point = 10;
$comment_point = 10;
$download_point = -10;

//-------------------------------------------------------------------------------------------------
// config 테이블 설정
$sql = " insert into $g4[config_table]
            set cf_title = '그누보드4 - 불당팩',
                cf_admin = '$admin_id',
                cf_use_point = '1',
                cf_use_norobot = '1',
                cf_use_copy_log = '1',
                cf_login_point = '100',
                cf_memo_send_point = '1',
                cf_cut_name = '10',
                cf_nick_modify = '60',
                cf_new_skin = 'basic',
                cf_new_rows = '15',
                cf_search_skin = 'basic',
                cf_connect_skin = 'basic',
                cf_read_point = '$read_point',
                cf_write_point = '$write_point',
                cf_comment_point = '$comment_point',
                cf_download_point = '$download_point',
                cf_search_bgcolor = 'YELLOW',
                cf_search_color = 'RED',
                cf_write_pages = '10',
                cf_link_target = '_blank',
                cf_delay_sec = '30',
                cf_delay_level = '9',
                cf_delay_point = '5000',
                cf_filter = '18아,18놈,18새끼,18년,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ',
                cf_possible_ip = '',
                cf_intercept_ip = '',
                cf_member_skin = 'basic',
                cf_register_level = '2',
                cf_register_point = '1000',
                cf_icon_level = '2',
                cf_leave_day = '30',
                cf_search_part = '10000',
                cf_email_use = '1',
                cf_prohibit_id = 'admin,administrator,관리자,운영자,어드민,주인장,webmaster,웹마스터,sysop,시삽,시샵,manager,매니저,메니저,root,루트,su,guest,방문객',
                cf_prohibit_email = '',
                cf_new_del = '30',
                cf_memo_del = '180',
                cf_visit_del = '180',
                cf_popular_del = '180',
                cf_use_member_icon = '2',
                cf_member_icon_size = '5000',
                cf_member_icon_width = '22',
                cf_member_icon_height = '22',
                cf_login_minutes = '10',
                cf_image_extension = 'gif|jpg|jpeg|png',
                cf_flash_extension = 'swf',
                cf_movie_extension = 'asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3',
                cf_formmail_is_member = '1',
                cf_page_rows = '15',
                cf_singo_intercept_count = '5', 
                cf_singo_today_count = '3', 
                cf_singo_point = '6000'
                ";
mysql_query($sql) or die(mysql_error() . "<p>" . $sql);

//                cf_stipulation = '해당 홈페이지에 맞는 회원가입약관을 입력합니다.',
//                cf_privacy = '해당 홈페이지에 맞는 개인정보취급방침을 입력합니다.'

//-------------------------------------------------------------------------------------------------
// 약관, 개인정보 파일에서 읽어오기
$service=addslashes(implode("", file("../company/service.html")));
$priv=addslashes(implode("", file("../company/privacy.html")));

$priv1=addslashes(implode("", file("../company/priv1.txt")));
$priv2=addslashes(implode("", file("../company/priv2.txt")));
$priv3=addslashes(implode("", file("../company/priv3.txt")));
$priv4=addslashes(implode("", file("../company/priv4.txt")));

$sql = " insert into $g4[config_reg_table]
            set 
                cf_stipulation  = '$service',
                cf_privacy      = '$priv',
                cf_privacy_1    = '$priv1',
                cf_privacy_2    = '$priv2',
                cf_privacy_3    = '$priv3',
                cf_privacy_4    = '$priv4'
                ";
mysql_query($sql) or die(mysql_error() . "<p>" . $sql);

// 운영자 회원가입
$sql = " insert into $g4[member_table]
            set mb_id = '$admin_id',
                mb_password = PASSWORD('$admin_pass'),
                mb_name = '$admin_name',
                mb_nick = '$admin_name',
                mb_email = '$admin_email',
                mb_level = '10',
                mb_mailling = '1',
                mb_open = '1',
                mb_email_certify = '$g4[time_ymdhis]',
                mb_datetime = '$g4[time_ymdhis]',
                mb_open_date = '$g4[time_ymd]',
                mb_ip = '$_SERVER[REMOTE_ADDR]' 
                ";
@mysql_query($sql);

// 몇가지 추가적인 설정 ----------------
$sql = " UPDATE `$g4[config_table]` SET `cf_open_modify` = '7' ";
@mysql_query($sql);

// 항상 마지막에 - 버젼을 업데이트
$sql = " UPDATE `$g4[config_table]` SET `cf_db_version` = '1107' ";
@mysql_query($sql);


echo "<script>document.frminstall2.job2.value='DB설정 완료';</script>";
flush(); usleep(50000); 
//-------------------------------------------------------------------------------------------------

// DB 설정 파일 생성
$file = "../dbconfig.php";
$f = @fopen($file, "w");

fwrite($f, "<?\n");
//fwrite($f, "if (!preg_match('/^'.str_replace('/', '\/', dirname(__FILE__)).'/', \$_SERVER['SCRIPT_FILENAME'])) die('정상적인 접근이 아님.');\n");
//fwrite($f, "if (\$dbconfig_file != str_replace(\$dirname, '', __FILE__)) die('정상적인 접근이 아님');\n");
fwrite($f, "\$mysql_host = '$mysql_host';\n");
fwrite($f, "\$mysql_user = '$mysql_user';\n");
fwrite($f, "\$mysql_password = '$mysql_pass';\n");
fwrite($f, "\$mysql_db = '$mysql_db';\n");
fwrite($f, "?>");

fclose($f);
@chmod($file, 0606);
echo "<script>document.frminstall2.job3.value='DB설정 파일 생성 완료';</script>";

/*
$str = implode("", file("../common.php"));
$str = str_replace("__MYSQL_HOST__", $mysql_host, $str);
$str = str_replace("__MYSQL_USER__", $mysql_user, $str);
$str = str_replace("__MYSQL_PASS__", $mysql_pass, $str);
$str = str_replace("__MYSQL_DB__",   $mysql_db,   $str);
$f = fopen("../common.php", "w");
fputs($f, $str);
fclose($f);
echo "<script>document.frminstall2.job3.value='DB설정값 변환 완료';</script>";
*/

flush(); usleep(50000); 


// 1.00.09 - data/log 삽입
// 디렉토리 생성
$dir_arr = array ("../$g4[data]",
                  "../$g4[data]/file",
                  "../$g4[data]/log",
                  "../$g4[data]/log/zmSpamFree",
                  "../$g4[data]/member",
                  "../$g4[data]/memo2",
                  "../$g4[data]/memo2_deleted",
                  "../$g4[data]/session",
                  "../$g4[data]/$g4[cheditor4]",
                  "../$g4[data]/$g4[editor]");
for ($i=0; $i<count($dir_arr); $i++) 
{
    @mkdir($dir_arr[$i], 0707);
    @chmod($dir_arr[$i], 0707);

    // 디렉토리에 있는 파일의 목록을 보이지 않게 한다.
    $file = $dir_arr[$i] . "/index.php";
    $f = @fopen($file, "w");
    @fwrite($f, "");
    @fclose($f);
    @chmod($file, 0604);
}

// data 디렉토리 및 하위 디렉토리에서는 .htaccess .htpasswd .php .phtml .html .htm .inc .cgi .pl 파일을 실행할수 없게함.
$f = fopen("../data/.htaccess", "w");
$str = <<<EOD
<FilesMatch "\.(htaccess|htpasswd|[Pp][Hh][Pp]|[Pp]?[Hh][Tt][Mm][Ll]?|[Ii][Nn][Cc]|[Cc][Gg][Ii]|[Pp][Ll])">
Order allow,deny 
Deny from all
</FilesMatch>
EOD;
fwrite($f, $str);
fclose($f);

// session 디렉토리는 웹에서 일절 접근하지 못하도록 함 
$f = fopen("../data/session/.htaccess", "w");
$str = "Deny from all";
fwrite($f, $str);
fclose($f);

@rename("../install", "../install.bak");
//-------------------------------------------------------------------------------------------------

echo "<script language='JavaScript'>document.frminstall2.status_bar.value += '■';</script>\n";
flush();
sleep(1);

echo "<script>document.frminstall2.job4.value='필요한 Table, File, 디렉토리 생성을 모두 완료 하였습니다.';</script>";
echo "<script>document.frminstall2.job5.value='* 메인화면에서 운영자 로그인을 한 후 운영자 화면으로 이동하여 환경설정을 변경해 주십시오.';</script>";
flush(); usleep(50000); 
?>

<script>document.frminstall2.btn_next.disabled = false;</script>
<script>document.frminstall2.btn_next.focus();</script>

</body>
</html>
