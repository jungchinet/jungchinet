<?
$sub_menu = "100910";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "쪽지4 설치";
include_once ("$g4[admin_path]/admin.head.php");
?>

<form name=finstall method=post action='memo4_install_update.php' onsubmit="return finstall_check(this)" enctype="multipart/form-data" style="margin:0px;">

<p>
<table width=100% cellpadding=0 cellspacing=0>
<tr>
	<td width=50%><?=subtitle("쪽지4 설치")?></td>
	<td width=50% align=right></td>
</tr>
</table>

<table cellpadding=0 cellspacing=0 width=100%>
<colgroup width=15%></colgroup>
<colgroup width=85% bgcolor=#FFFFFF></colgroup>
<tr><td colspan=4 height=2 bgcolor=#0E87F9></td></tr>
<tr class=ht>
	<td>최고관리자 패스워드</td>
	<td colspan=3>
        <input type=password name=mb_password class=ed required itemname='최고관리자 패스워드'>
	</td>
</tr>
<tr class=ht>
	<td>&nbsp;</td>
	<td colspan=3 class=lh>
        <?
        $result = sql_fetch(" select * from $g4[memo_config_table] ", false);
        if ($result)
        {
            echo "이미 설치되어 있습니다.<br>재설치 하시려면 최고관리자 패스워드를 입력해 주십시오<br><b>재설치 하시는 경우 쪽지4와 관련된 기존의 자료가 삭제될 수 있으므로 주의하시기 바랍니다.</b>";
        }
        else
        {
            echo "설치되어 있지 않습니다.<br>설치하시려면 관리자 패스워드를 입력해 주십시오.";
        }
        ?>
	</td>
</tr>
<tr><td colspan=4 height=1 bgcolor=#CCCCCC></td></tr>
</table>

<p align=center>
	<input type=submit class=btn1 accesskey='s' value='  확  인  '>
</form>

<script>
function finstall_check(f) {
    return true;
}
</script>

<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
