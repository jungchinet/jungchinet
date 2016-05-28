<?
$sub_menu = "900900";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "핸드폰번호 파일";

$no_group = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no = 1");

$group = array();
$qry = sql_query("select * from $g4[sms4_book_group_table] where bg_no > 1 order by bg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

include_once("$g4[admin_path]/admin.head.php");
?>

<?=subtitle("핸드폰번호 엑셀파일(CSV) 가져오기")?>

<div style="background-color:#f8f8f8; padding:10px; margin-bottom:20px; line-height:25px;">

    <div style="height:30px;">
        엑셀에 저장된 핸드폰번호 목록을 데이터베이스에 저장할 수 있습니다.
    </div>

    <div style="height:22px;">
        엑셀에는 이름과 핸드폰번호 두개만 저장해주세요. 첫번째 라인부터 저장됩니다.
        <?=help("※ 핸드폰번호에 하이픈(―)은 포함되어도 되고 포함되지 않아도 됩니다.")?>
    </div>

    <div style="height:18px;">
        엑셀파일은 "파일 > 다른 이름으로 저장 > 파일형식 : CSV (쉼표로 분리) (*.CSV)" 로 저장한 후 업로드 해주세요.
        <?=help("<img src='img/exfile02.gif'><img src='img/exfile03.gif'>", -370)?>
    </div>

    <div style="height:40px; color:#990000;">
        이 작업을 실행하기 전에 회원정보업데이트를 먼저 실행해주세요.
    </div>

    <form name=upload_form method=post enctype=multipart/form-data target=hiddenframe style="margin:0; padding:0;">

    <div id="file_upload" style="margin-bottom:10px;">
        그룹선택 : 
        <select name="upload_bg_no" id="upload_bg_no" style="width:135px; font-size:11px;" class=btn1>
        <option value=""> </option>
        <option value="1"> <?=$no_group[bg_name]?> (<?=number_format($no_group[bg_count])?>) </option>
        <? for ($i=0; $i<count($group); $i++) { ?>
        <option value="<?=$group[$i][bg_no]?>"> <?=$group[$i][bg_name]?> (<?=number_format($group[$i][bg_count])?>) </option>
        <?}?>
        </select>
    </div>

    <div style="margin-bottom:10px;">
        파일선택 : <input type=file size=30 name=csv class=btn1 onchange="document.getElementById('upload_info').style.display='none';">
        <span id='upload_button'>
            <input type=button class=btn1 accesskey='s' tabindex=6 value=' 파일전송  ' onclick="upload();">
        </span>
        <span id='uploading' style="display:none;">
            파일을 업로드 중입니다. 잠시만 기다려주세요.
        </span>
    </div>

    <div id=upload_info style="display:none; margin-top:5px; border:1px solid #ccc; padding:10px; line-height:20px;"></div>
    <div id='register' style="display:none;">
        핸드폰번호를 DB에 저장중 입니다. 잠시만 기다려주세요.
    </div>

    </form>

</div>


<?=subtitle("핸드폰번호 엑셀파일(xls) 내보내기")?>

<div style="background-color:#f8f8f8; padding:10px; line-height:25px;">

    <div style="margin-bottom:10px;">
        저장된 핸드폰번호 목록을 엑셀(xls) 파일로 다운로드 할 수 있습니다.<br/>
        다운로드 할 핸드폰번호 그룹을 선택해주세요.
    </div>

    <div style="margin-bottom:10px;">
        <input type=checkbox id=no_hp value=1> 핸드폰 번호 없는 회원 포함 <br>
        <input type=checkbox id=hyphen value=1> 하이픈 '―' 포함
    </div>

    <div style="margin-bottom:10px;">
        그룹선택 : 
        <select name="download_bg_no" id="download_bg_no" style="width:135px; font-size:11px;" class=btn1>
        <option value=""> </option>
        <option value="all"> 전체 </option>
        <option value="1"> <?=$no_group[bg_name]?> (<?=number_format($no_group[bg_count])?>) </option>
        <? for ($i=0; $i<count($group); $i++) { ?>
        <option value="<?=$group[$i][bg_no]?>"> <?=$group[$i][bg_name]?> (<?=number_format($group[$i][bg_count])?>) </option>
        <?}?>
        </select>
        <input type=button class=btn1 accesskey='s' tabindex=6 value='  다운로드  ' onclick=download()>
    </div>

</div>

<script language=javascript>

function upload(w)
{
    f = document.upload_form;

    if (typeof w == 'undefined') {
        document.getElementById('upload_button').style.display = 'none';
        document.getElementById('uploading').style.display = 'inline';
        document.getElementById('upload_info').style.display = 'none';
        f.action = 'num_book_file_upload.php?confirm=1';
    } else {
        document.getElementById('upload_button').style.display = 'none';
        document.getElementById('upload_info').style.display = 'none';
        document.getElementById('register').style.display = 'block';
        f.action = 'num_book_file_upload.php';
    }

    f.submit();
}

function download() 
{
    var bg_no = document.getElementById('download_bg_no');
    var no_hp = document.getElementById('no_hp');
    var hyphen = document.getElementById('hyphen');
    var par = '';

    if (!bg_no.value.length) {
        alert('다운로드 할 핸드폰번호 그룹을 선택해주세요.');
        return;
    }

    if (no_hp.checked) no_hp = 1; else no_hp = 0;
    if (hyphen.checked) hyphen = 1; else hyphen = 0;

    par += '?bg_no=' + bg_no.value;
    par += '&no_hp=' + no_hp;
    par += '&hyphen=' + hyphen;

    hiddenframe.location.href = 'num_book_file_download.php' + par;
}
</script>

<div style="height:30px;"></div>

<?
include_once("$g4[admin_path]/admin.tail.php");
?>
