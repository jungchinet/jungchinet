<?
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "SMS 솔루션 설치";

include_once("$g4[admin_path]/admin.head.php");
?>
<style type="text/css">
<!--
.body {
	font-size: 12px;
}
.box {
	background-color: #FCFCFC;
    color:#18307B;
	font-size: 12px;
}
.nobox {
	background-color: #FCFCFC;
    border-style:none;
    font-size: 12px;
}
-->
</style>

<div align="center">
  <table width="587" border="0" cellspacing="0" cellpadding="0">
    <form name=frminstall2>
    <tr> 
                <td colspan="3"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="587" height="22">
                        <param name="movie" value="img/top.swf">
                        <param name="quality" value="high">
                        <embed src="img/top.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="587" height="22"></embed></object></td>
    </tr>
    <tr> 
      <td width="3"><img src="img/box_left.gif" width="3" height="340"></td>
      <td width="581" valign="top" bgcolor="#FCFCFC"><table width="581" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><img src="img/box_title.gif" width="581" height="56"></td>
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
            <td height=20><img src="img/box_line.gif" width="562" height="2"></td>
          </tr>
        </table>
        <table width="551" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td align="right"> 
              <input type="button" name="btn_next" disabled value="SMS 기본설정 바로가기" onclick="location.href='config.php';">
            </td>
          </tr>
        </table></td>
      <td width="3"><img src="img/box_right.gif" width="3" height="340"></td>
    </tr>
    <tr> 
      <td colspan="3"><img src="img/box_bottom.gif" width="587" height="3"></td>
    </tr>
    </form>
  </table>
</div>
<?
flush(); usleep(50000); 

// 테이블 생성 ------------------------------------
$file = implode("", file("./sms4.sql"));
eval("\$file = \"$file\";");

$f = explode(";", $file);
for ($i=0; $i<count($f); $i++) {
    if (trim($f[$i]) == "") continue;
    mysql_query($f[$i]) or die(mysql_error());
}
// 테이블 생성 ------------------------------------

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

$read_point = -1;
$write_point = 5;
$comment_point = 1;
$download_point = -20;

//-------------------------------------------------------------------------------------------------
// config 테이블 설정
$sql = " insert into $g4[sms4_book_group_table] set bg_name='미분류'";
mysql_query($sql) or die(mysql_error() . "<p>" . $sql);

echo "<script>document.frminstall2.job2.value='DB설정 완료';</script>";
flush(); usleep(50000); 
//-------------------------------------------------------------------------------------------------

echo "<script>document.frminstall2.job5.value='* SMS 기본 설정을 변경해 주십시오.';</script>";
flush(); usleep(50000); 
?>

<script>document.frminstall2.btn_next.disabled = false;</script>
<script>document.frminstall2.btn_next.focus();</script>

<?
include_once("$g4[admin_path]/admin.tail.php");
?>
