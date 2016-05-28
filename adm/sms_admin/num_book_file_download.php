<?
$sub_menu = "900900";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($bg_no != 'all' && $bg_no < 1)
    alert_just('다운로드 할 핸드폰번호 그룹을 선택해주세요.');

if ($bg_no == 'all')  $sql_bg = ""; else $sql_bg = "and bg_no='$bg_no'";

if ($no_hp) $sql_hp = ""; else  $sql_hp = "and bk_hp<>''";

$qry = sql_query("select * from $g4[sms4_book_table] where 1 $sql_bg $sql_hp order by bk_name");

if (!mysql_num_rows($qry)) alert_just('데이터가 없습니다.');

$xls = "<table border=1>\n";

while ($res = sql_fetch_array($qry))
{
    $hp = get_hp($res[bk_hp], $hyphen);

    if ($no_hp && $res[bk_hp] != '' && !$hp) continue;

    $xls .= "<tr>";
    $xls .= "<td style=\"mso-number-format:'\\@';mso-style-parent:style0;\"> $res[bk_name] </td>";
    $xls .= "<td style=\"mso-number-format:'\\@';mso-style-parent:style0;\"> $hp </td>";
    $xls .= "</tr>\n";
}

$xls .= "</table>\n";

header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=핸드폰번호목록-".date('ymd').".xls" ); 

echo $xls;
?>
