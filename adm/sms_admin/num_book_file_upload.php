<?
$sub_menu = "900900";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if (!$upload_bg_no)
    alert_after('그룹을 선택해주세요.');

$bg_no = $upload_bg_no;

if (!$_FILES[csv][size]) 
    alert_after('파일을 선택해주세요.');

$file = file($_FILES[csv][tmp_name]);

$csv = array();

foreach ($file as $item) 
{
    $item = explode(',', $item);

    $item[1] = get_hp($item[1]);

    array_push($csv, $item);

    if (count($item) != 2) 
        alert_after('올바른 파일이 아닙니다.');
}

$counter = 0;
$success = 0;
$failure = 0;
$overlap = 0;
//$overlap_file = 0;

$arr = array();
$arr_hp = array();

foreach ($csv as $item)
{
    $name = $item[0];
    $hp   = $item[1];

    $counter++;

    if (!(strlen($name)&&$hp))
        $failure++;

    else if (!in_array($hp, $arr_hp)) 
    {
        $cnt = -1;
        foreach($csv as $item) {
            if ($item[1] == $hp) {
                if (++$cnt > 0) {
                    array_push($arr, $item);
                    if (!in_array($hp, $arr_hp))
                        array_push($arr_hp, $hp);
                }
            }
        }
        if ($cnt > 0) $overlap += $cnt;

        $res = sql_fetch("select * from $g4[sms4_book_table] where bk_hp='$hp'");
        if ($res) 
        {
            if ($cnt < 0)
                $overlap++;
        } 
        else if (!$confirm && $hp) 
        {
            sql_query("insert into $g4[sms4_book_table] set bg_no='$bg_no', bk_name='$name', bk_hp='$hp', bk_receipt=1, bk_datetime='$g4[time_ymdhis]'");
            sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count + 1, bg_nomember = bg_nomember + 1, bg_receipt = bg_receipt + 1 where bg_no='$bg_no'");
            $success++;
        }
    }
}

unlink($_FILES[csv][tmp_name]);

if ($success) 
    sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count + $success where bg_no='$bg_no'");

$result = $counter - $failure - $overlap;

echo "<script language=javascript>
var info = parent.document.getElementById('upload_info');
var html = '';

html += \"총 건수 : ".number_format($counter)." 건<br/>\";
html += \"올바르지 않은 핸드폰번호 : ".number_format($failure)." 건<br/>\";
//html += \"파일안의 중복 핸드폰번호 : ".number_format($overlap_file)." 건<br/>\";
html += \"중복되는 핸드폰번호 : ".number_format($overlap)." 건 <img src='../../adm/img/icon_help.gif' border=0 width=15 height=15 align=absmiddle onclick=\\\"help('help03', 70, 0);\\\" style='cursor:hand;'><div id='help03' style='position:absolute; display:none;'><div id='csshelp1'><div id='csshelp2'><div id='csshelp3'><span id=overlap></span></div></div></div></div>		 <br/>\";
html += \"등록가능한 핸드폰번호 : ".number_format($result)." 건<br/>\";";

if ($result) 
{
    if ($confirm) 
        echo "html += \"<input type=button value=등록하기 class=btn1 onclick=\\\"upload(1)\\\">\";";
    else
        echo "html += \"<font color=blue>총 ".number_format($success)." 건의 핸드폰번호 등록을 완료하였습니다.</font>\";";
} 
else
    echo "html += \"<font color=red>등록할 수 없습니다.</font>\";";
 
echo "
parent.document.getElementById('upload_button').style.display = 'inline';
parent.document.getElementById('uploading').style.display = 'none';
parent.document.getElementById('register').style.display = 'none';

info.style.display = 'block';
info.innerHTML = html;

parent.document.getElementById('overlap').innerHTML = '중복되는 핸드폰 번호 목록<br/>';";


for ($i=0; $i<count($arr_hp); $i++) 
echo "parent.document.getElementById('overlap').innerHTML += '".$arr_hp[$i]."<br/>';\n";

echo "</script>";


function alert_after($str) {
    echo "<script language=javascript>
    parent.document.getElementById('upload_button').style.display = 'inline';
    parent.document.getElementById('uploading').style.display = 'none';
    parent.document.getElementById('register').style.display = 'none';
    parent.document.getElementById('upload_info').style.display = 'none';
    </script>";
    alert_just($str);
}
?>
