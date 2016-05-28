<?
include_once("./_common.php");

// 비회원은 접근할 수 없게 함
if (!$is_member) 
    alert("부적절한 접근 입니다. 관리자에게 문의하시기 바랍니다.");
include_once("$g4[path]/head.php");
?>

<table width=90% align=center>
<tr><td align=center>
<b>개인정보 수정 요청</b>
</td></tr>

<tr><td height=10></td></tr>

<tr><td align=left>
<b>주기적인 개인정보(비밀번호) 수정은 개인정보를 지키는 기본 사항 입니다.</b>
<br><br>
<li>비밀번호는 연속되는 숫자, 문자 및 개인신상정보 (아이디, 생년월일 등)로 하는 것을 피해야 합니다.
<br>
<li>사용하는 사이트마다 비밀번호를 다르게 하는 것이 바람직 합니다.
<br>
<li>PC방등의 공공장소에서는 반드시 로그아웃 해야 합니다.
<br>
<li>비밀번호는 절대 타인과 공유를 하면 안됩니다.
</td></tr>

<tr><td height=10></td></tr>

<tr><td align=center>
<b>
<a href="<?=$g4[bbs_path]?>/member_confirm.php?url=register_form.php" onfocus="this.blur()">
개인정보(비밀번호) 수정하러 가기
</a>
</b>
</td></tr>
</table>

<?
include_once("$g4[path]/tail.php");
?>
