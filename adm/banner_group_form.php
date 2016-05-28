<?
$sub_menu = "300910";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

if ($is_admin != "super" && $w == "") alert("최고관리자만 접근 가능합니다.");

$html_title = "배너그룹";
if ($w == "") 
{
    $bg_id_attr = "required";
    $bg[bg_use] = 1;
    $html_title .= " 생성";
} 
else if ($w == "u") 
{
    $bg_id_attr = "readonly style='background-color:#dddddd'";
    $bg = sql_fetch(" select * from $g4[banner_group_table] where bg_id = '$bg_id' ");
    $html_title .= " 수정";
} 
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

$g4[title] = $html_title;
include_once("./admin.head.php");
?>

<form name=fbannergroup method=post onsubmit="return fbannergroup_check(this);" autocomplete="off">
<input type=hidden name=w     value='<?=$w?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>
<table width=100% cellpadding=0 cellspacing=0>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<tr class='ht'>
    <td colspan=4 class=title align=left><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> <?=$html_title?></td>
</tr>
<tr><td colspan=4 class='line1'></td></tr>
<tr class='ht'>
    <td>그룹 ID</td>
    <td colspan=3><input type='text' class=ed name=bg_id size=21 maxlength=20 <?=$bg_id_attr?> alphanumericunderline itemname='그룹 아이디' value='<?=$bg[bg_id]?>'> 영문자, 숫자, _ 만 가능 (공백없이)</td>
</tr>
<tr class='ht'>
    <td>그룹제목</td>
    <td colspan=3>
        <input type='text' class=ed name=bg_subject size=40 required itemname='그룹 제목' value='<?=get_text($bg[bg_subject])?>'>
        <? 
        if ($w == 'u')
            echo "<input type=button class='btn1' value='배너 생성' onclick=\"location.href='./banner_form.php?bg_id=$bg_id';\">";
        ?>
    </td>
</tr>
<tr class='ht'>
    <td>그룹 관리자</td>
    <td colspan=3>
        <?
        if ($is_admin == "super")
            echo "<input type='text' class=ed name='bg_admin' value='$bg[bg_admin]' maxlength=20>";
        else
            echo "<input type=hidden name='bg_admin' value='$bg[bg_admin]' size=40>$bg[bg_admin]";
        ?></td>
</tr>
<tr class='ht'>
    <td>그룹메모</td>
    <td colspan=3>
        <textarea class=ed name=bg_desc rows=5 style='width:80%;'><?=get_text($bg[bg_desc]) ?></textarea></td>
    </td
</tr>
<tr class='ht'>
    <td>배너그룹 사용</td>
    <td colspan=3>
        <input type=checkbox name=bg_use value='1' <?=$bg[bg_use]?'checked':'';?>>사용
    </td>
</tr>
<tr class='ht'>
    <td>배너 크기(px)</td>
    <td colspan=3>
        <input type='text' class=ed name=bg_width size=8 numeric itemname='배너넓이' value='<?=$bg[bg_width]?>'> 넓이, px <BR>
        <input type='text' class=ed name=bg_height size=8 numeric itemname='배너높이' value='<?=$bg[bg_height]?>'> 높이, px
    </td>
</tr>

<? for ($i=1; $i<=3; $i++) { ?>
<tr class='ht'>
    <td><input type=text class=ed name='bg_<?=$i?>_subj' value='<?=get_text($bg["bg_{$i}_subj"])?>' title='여분필드 <?=$i?> 제목' style='text-align:right;font-weight:bold;' size=15></td>
    <td><input type='text' class=ed style='width:99%;' name=bg_<?=$i?> value='<?=get_text($bg["bg_$i"])?>' title='여분필드 <?=$i?> 설정값'></td>
    <td></td>
    <td></td>
</tr>
<? } ?>
<tr><td colspan=4 class='line2'></td></tr>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>&nbsp;
    <input type=button class=btn1 value='  목  록  ' onclick="document.location.href='./banner_group_list.php?<?=$qstr?>';">
</form>

<script type="text/javascript">
if (document.fbannergroup.w.value == '')
    document.fbannergroup.bg_id.focus();
else
    document.fbannergroup.bg_subject.focus();

function fbannergroup_check(f)
{
    f.action = "./banner_group_form_update.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php");
?>
