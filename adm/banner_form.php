<?
$sub_menu = "300900";
include_once("./_common.php");
include_once ("$g4[path]/lib/cheditor4.lib.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

$sql = " select count(*) as cnt from $g4[banner_group_table] ";
$row = sql_fetch($sql);
if (!$row[cnt])
    alert("배너그룹이 한개 이상 생성되어야 합니다.", "./banner_group_form.php");

$html_title = "배너";
if ($w == "") {
    $html_title .= " 생성";

    $bn['bg_id'] = $bg_id;

} else if ($w == "u") {
    $html_title .= " 수정";

    $sql = " select * from $g4[banner_table] where bn_id = '$bn_id' ";
    $bn = sql_fetch($sql);
    if (!$bn[bn_id])
        alert("존재하지 않는 배너 입니다.");

    $bn_table_attr = "readonly style='background-color:#dddddd'";
}

// 그룹관리 권한 체크
$sql = " select * from $g4[banner_group_table] where bg_id = '$bg_id' ";
$bg = sql_fetch($sql);

if ($is_admin !== "super") {
    if ($member[mb_id] !== $bg[bg_admin]) 
        alert("그룹이 틀립니다.");
    else
        $is_admin = "group";
}

$g4[title] = $html_title;
include_once ("./admin.head.php");

include_once ("$g4[path]/lib/banner.lib.php");
?>

<form name=fbannerform method=post onsubmit="return fbannerform_submit(this)" enctype="multipart/form-data">
<input type=hidden name="w"     value="<?=$w?>">
<input type=hidden name="sfl"   value="<?=$sfl?>">
<input type=hidden name="stx"   value="<?=$stx?>">
<input type=hidden name="sst"   value="<?=$sst?>">
<input type=hidden name="sod"   value="<?=$sod?>">
<input type=hidden name="page"  value="<?=$page?>">
<input type=hidden name="token" value="<?=$token?>">

<table width=100% cellpadding=0 cellspacing=0 border=0>
<colgroup width=5% class='left'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=75% class='col2 pad2'>
<tr>
    <td colspan=3 class=title align=left><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> <?=$html_title?></td>
</tr>
<tr><td colspan=3 class='line1'></td></tr>
<tr class='ht'>
    <td></td>
    <td>배너ID</td>
    <td><input type=text class=ed name=bn_id size=30 maxlength=20 <?=$bn_table_attr?> required itemname='배너ID' value='<?=$bn[bn_id] ?>'>
        <? 
        if ($w == "") 
            echo "영문자, 숫자, _ 만 가능 (공백없이 20자 이내)";
        ?>
    </td>
</tr>
<tr class='ht'>
    <td></td>
    <td>그룹</td>
    <td>
        <?=get_banner_group_select('bg_id', $bn[bg_id], "required itemname='그룹'");?>
        <? if ($w=='u') { ?><a href="javascript:location.href='./banner_list.php?sfl=a.bg_id&stx='+document.fbannerform.bg_id.value;">동일그룹배너목록</a><?}?></td>
</tr>
<tr class='ht'>
    <td></td>
    <td>배너 제목</td>
    <td>
        <input type=text class=ed name=bn_subject size=60 maxlength=120 required itemname='배너 제목' value='<?=get_text($bn[bn_subject])?>'> (alt 또는 title)
    </td>
</tr>
<tr class='ht'>
    <td></td>
    <td>Table</td>
    <td>
        <input type=text class=ed name=bn_table size=60 maxlength=120 required itemname='Table' value='<?=get_text($bn[bn_table])?>'> 출력 대상 Table
    </td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td></td>
    <td>배너 이미지</td>
    <td style='padding-top:7px; padding-bottom:7px;'>
        <b>배너 이미지는 높이 : <?=$bg[bg_width]?>px, 넓이 : <?=$bg[bg_height]?>px 크기로 넣어주세요.</b><br>
        <input type=file name=bn_image class=ed size=60>
        <?
        if ($bn[bn_image]) {
            $bn_image = "$g4[data_path]/banner/{$bn['bg_id']}/$bn[bn_image]";
            echo "<br><a href='$bn_image' target='_blank'>$bn[bn_image] ( $bn[bn_filename] )</a> <input type=checkbox name='bn_image_del' value='$bn[bn_image]'> 삭제";
            // 사이즈를 굳이 db에 넣어둘 필요는 없슴.
            $im = getimagesize($bn_image);
            echo "<br>$im[3]";
            echo "<br><a href='$bn_image' target=_blank><img src='" . resize_dica($bn_image, 500) . "'></a>";
        }
        ?>
    </td>
</tr>
</tr>
<tr class='ht'>
    <td></td>
    <td>배너 TEXT</td>
    <td style='padding-top:7px; padding-bottom:7px;'>
        <script type="text/javascript" src="<?=$g4[cheditor4_path]?>/cheditor.js"></script>
        <?=cheditor1('bn_text', '100%', '200');?>
        <?=cheditor2('bn_text', $bn[bn_text]);?>
    </td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use value=1></td>
    <td>배너사용</td>
    <td><input type=checkbox name=bn_use value='1' <?=$bn[bn_use]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_target value=1></td>
    <td>배너타겟</td>
    <td><input type=checkbox name=bn_target value='1' <?=$bn[bn_target]?'checked':'';?>>새창 (체크하면 새창으로)</td>
</tr>
<tr class='ht'>
    <td></td>
    <td>타겟URL</td>
    <td><input type=text class=ed name=bn_url size=60 required itemname='타겟 URL' value='<?=$bn[bn_url]?>'></td>
</tr>

<tr class='ht'>
    <td><input type=checkbox name=chk_start_datetime value=1></td>
    <td>시작일</td>
    <td><input type=text class=ed name='bn_start_datetime' id='bn_start_datetime' size=24 maxlength=19 required value='<?=$bn[bn_start_datetime]?>'>
    <a href="javascript:win_calendar('bn_start_datetime', document.getElementById('bn_start_datetime').value, '-');"><img src='<?=$g4[admin_path]?>/img/calendar.gif' border=0 align=absmiddle title='달력 - 날짜를 선택하세요'></a>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_end_datetime value=1></td>
    <td>종료일</td>
    <td><input type=text class=ed name='bn_end_datetime' id='bn_end_datetime' size=24 maxlength=19 required value='<?=$bn[bn_end_datetime]?>'>
    <a href="javascript:win_calendar('bn_end_datetime', document.getElementById('bn_end_datetime').value, '-');"><img src='<?=$g4[admin_path]?>/img/calendar.gif' border=0 align=absmiddle title='달력 - 날짜를 선택하세요'></a>
    +30<input type=button name=end_date_chk1 value="<? echo date("Y-m-d", $g4[server_time]+(60*60*24*30)); ?>" onclick="this.form.bn_end_datetime.value=this.value+' 23:59:59'" title='오늘+30일'>
    +90<input type=button name=end_date_chk2 value="<? echo date("Y-m-d", $g4[server_time]+(60*60*24*90)); ?>" onclick="this.form.bn_end_datetime.value=this.value+' 23:59:59'" title='오늘+90일'>
    +180<input type=button name=end_date_chk3 value="<? echo date("Y-m-d", $g4[server_time]+(60*60*24*180)); ?>" onclick="this.form.bn_end_datetime.value=this.value+' 23:59:59'" title='오늘+180일'>
    </td>
</tr>
<tr class='ht'>
    <td></td>
    <td>배너 순서</td>
    <td><input type=text class=ed name=bn_order size=5 value='<?=$bn[bn_order]?>'> 숫자가 낮은 배너 부터 검색</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>

<? for ($i=1; $i<=3; $i++) { ?>
<tr class='ht'>
    <td><input type=checkbox name=chk_<?=$i?> value=1></td>
    <td><input type=text class=ed name='bn_<?=$i?>_subj' value='<?=get_text($bn["bn_{$i}_subj"])?>' title='여분필드 <?=$i?> 제목' style='text-align:right;font-weight:bold;'></td>
    <td><input type=text class=ed style='width:80%;' name='bn_<?=$i?>' value='<?=get_text($bn["bn_$i"])?>' title='여분필드 <?=$i?> 설정값'></td>
</tr>
<? } ?>

<tr class='ht'>
    <td></td>
    <td>배너 수정일</td>
    <td><?=$bn['bn_datetime']?></td>
</tr>

</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>&nbsp;
    <input type=button class=btn1 value='  목  록  ' onclick="document.location.href='./banner_list.php?<?=$qstr?>';">&nbsp;
</form>

<script type="text/javascript">
function fbannerform_submit(f) {
    var tmp_title;
    var tmp_image;

    tmp_title = "배너";
    tmp_image = f.bn_image;
    if (tmp_image.value) {
        if (!tmp_image.value.toLowerCase().match(/.(gif|jpg|png)$/i)) {
            alert(tmp_title + "이미지가 gif, jpg, png 파일이 아닙니다.");
            return false;
        }
    }

    <?=cheditor3('bn_text')."\n";?>

    f.action = "./banner_form_update.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php");
?>
