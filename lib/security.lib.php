<?
// proxy 서버인지 확인하기
function check_proxy($ip_addr) 
{
    global $g4;

    // ip 주소가 없으면 return
    $ip_addr = trim($ip_addr);
    if (!$ip_addr)
        return true;
    
    // ip 주소 형식이 바르지 않으면 retnrn
    if (!ip2long($ip_addr))
        return true;

    $sql = " select count(*) as cnt from $g4[proxy_table] where proxy_ip = '$ip_addr' ";
    $result = sql_fetch($sql);
    
    if ($result[cnt] > 0)
        return true;    // proxy 서버
    else
        return false;   // proxy 서버가 아님
} 
?>
