<?
$sub_menu = "300100";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

$g4[title] = $html_title;
include_once ("../head.sub.php");

$bo_table = $_POST['bo_table'];
$tmp_write_table = $g4['write_prefix'] . $bo_table;

$sql = " select ca_name from $tmp_write_table ";
$sql_tmp = " create TEMPORARY table list_tmp as $sql ";
$sql_ord = " select distinct ca_name from list_tmp ";
@mysql_query($sql_tmp) or die("<p>$sql_tmp<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
$result = @mysql_query($sql_ord) or die("<p>$sql_ord<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
//$sql = " SELECT distinct ca_name FROM $tmp_write_table ";
//$result = sql_query($sql);
$ca_list = "";
$ca_list_num = mysql_num_rows($result);
while ($row=sql_fetch_array($result)) {
    $ca_list .= $row[ca_name] . "|";
}

if ($ca_list == "|")
    die("");
else {
    die("$ca_list");
}
?>
