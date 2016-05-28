<?
$g4_path = "../../..";
include_once("$g4_path/common.php");

if ($sname) {
    $sql = " select * from $g4[member_table] where mb_nick like '%$sname%' or mb_name like '%$sname%' or mb_id like '%$sname%' order by mb_id ";
    $result = sql_query($sql);
    $search_count = mysql_num_rows($result);
    if ($search_count > 0) {
        for ($i=0; $row=mysql_fetch_array($result); $i++) {
            $list[$i]->id = "$row[mb_id]";
            $list[$i]->name = $row[mb_name];
            $list[$i]->nick = $row[mb_nick];
        }
    } else {
        alert("찾으시는 ID가 없습니다.");
    }
    mysql_free_result($result);
}

$g4[title] = "사용자ID 검색";
include_once("$g4[path]/head.sub.php");
?>

<table width=100% border=0 cellspacing=0 cellpadding=0>
<form name=frmid method=get autocomplete=off>
<input type=hidden name=frm_name		value='<?=$frm_name?>'>
<input type=hidden name=ss_id	 value='<?=$ss_id?>'>
<tr>
    <td colspan=3>
        <table width=100% height=50 border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=center valign=middle bgcolor=#EBEBEB>
                <table width=98% height=40 border=0 cellspacing=0 cellpadding=0>
                <tr>
                    <td width=5% align=center bgcolor=#FFFFFF><img src=<?=$g4[bbs_img_path]?>/icon_01.gif width=5 height=5></td>
                    <td width=35% align=left bgcolor=#FFFFFF><font color=#666666><b><?=$g4[title]?></b></font></td>
                </tr>
                </table></td>
        </tr>
        </table></td>
</tr>
<tr>
    <td width=10></td><td height=30 colspan=2 valign=bottom>찾는 이름을 입력하세요. (두글자 이상)</td>
</tr>
<tr>
    <td height=20 colspan=3></td>
</tr>
<tr>
    <td></td>
    <td width=70>회원이름 : </td>
    <td><input type=text name=sname value='<?=$sname?>' required minlength=2 itemname='회원이름' size=15> <input type=image src='<?=$g4[bbs_img_path]?>/btn_post_search.gif' border=0 align=absmiddle></td>
</tr>
<tr>
    <td height=20 colspan=3></td>
</tr>
</table>

<!-- 검색결과 여기서부터 -->
<script type="text/javascript">
    document.frmid.sname.focus();
</script>

<? if ($search_count > 0) { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td height="1" colspan="2" background="<?=$g4[bbs_img_path]?>/post_dot_bg.gif"></td>
</tr>
<tr>
    <td width="10%"></td>
    <td width="90%">
        <table width=100% cellpadding=0 cellspacing=0>
        <tr>
            <td height=23 valign=top>총 <?=$search_count?>건 가나다순</td>
        </tr>
        <?
        for ($i=0; $i<count($list); $i++)
        {
            echo "<tr><td height=19>
            <a href=javascript:setid('{$list[$i]->name}','{$list[$i]->id}')>{$list[$i]->nick}({$list[$i]->name}) - {$list[$i]->id}</a></td></tr>\n";
        }
        ?>
        <tr>
            <td height=23>[끝]</td>
        </tr>
        </table>
</tr></form>
</table>

<script type="text/javascript">
    function setid(sname, sid)
    {
        var ov = top.opener.document.<?=$frm_name?>.<?=$ss_id?>.value;
        var of = top.opener.document.<?=$frm_name?>.<?=$ss_id?>;

		if(ov.length>0) {
			of.value = (sid);
		}else{
        	of.value  = sid;
		}

		top.opener.focus();
        top.close();
        return false;
    }
</script>
<? } ?>

<?
include_once("$g4[path]/tail.sub.php");
?>
