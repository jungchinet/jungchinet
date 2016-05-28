<?
include_once("./_common.php");

// http://ip-to-country.webhosting.info/node/view/5

// Query for getting visitor countrycode
$sql  = "SELECT country_code,country_full FROM $g4[geoip_table] WHERE ip32_start <= inet_aton('$_SERVER[REMOTE_ADDR]') AND ip32_end >= inet_aton('$_SERVER[REMOTE_ADDR]') ";
$result = sql_fetch($sql);

if ($result[country_code])
    echo "$result[country_code] - $result[country_full]";
else
    echo "not in geoip";
?>
