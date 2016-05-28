<?
$sub_menu = "200310";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$g4[title] = "이메일주소 유효성 확인";
include_once ("./admin.head.php");

echo "'완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.<br><br>";
echo "naver.com, daum.net, hanmail.net은 이 프로그램으로 유효성 확인을 할 수 없습니다<br><br>";
echo "<span id='ct'></span>";

include_once("./admin.tail.php");
?>

<?
$sql = " select mb_id, mb_nick, mb_name, mb_email, mb_email_certify from $g4[member_table] where mb_email != '' and mb_email_certify = '0000-00-00 00:00:00' ";
$result = sql_query($sql);
$sql_count = mysql_num_rows($result);
echo "<script>document.getElementById('ct').innerHTML += '<br><br>{$sql_count}개의 이메일의 유효성이 확인되지 않았습니다.';</script>\n";

// 유효한 email 갯수
$valid_count = 0;

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $mb_id = $row[mb_id];
    $mb_email = $row[mb_email];
    $mb_name = $row[mb_name];
    $mb_nick = $row[mb_nick];

    if (validate_email($mb_email)) {
        $sql = "update $g4[member_table] set mb_email_certify='$g4[time_ymdhis]' where mb_id = '$mb_id' ";
        sql_query($sql);
        echo "<script>document.getElementById('ct').innerHTML += '<br><br>{$mb_id}-{$mb_name} ({$mb_nick})님의 이메일 {$mb_email} 이 유효합니다.';</script>\n";
        $valid_count++;
    }
}

echo "<script>document.getElementById('ct').innerHTML += '<br><br>유효한 이메일 {$valid_count}건 인증 완료.<br><br>프로그램의 실행을 끝마치셔도 좋습니다.';</script>\n";

// http://kr2.php.net/manual/kr/function.getmxrr.php
//1. it validates the syntax of the address.
//2. get MX records by hostname
//3. connect mail server and verify mailbox(using smtp command RCTP TO:<email>)
//When the function "validate_email([email])" fails connecting the mail server with the highest priority in the MX record it will continue with the second mail server and so on..
//The function "validate_email([email])" returns 0 when it failes one the 3 steps above, it will return 1 otherwise
// 정상적인 메일계정 : 1
// 비정상인 메일계정 : 0
function validate_email($email){
   $mailparts=explode("@",$email);
   $hostname = $mailparts[1];

   // validate email address syntax
   $exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
   $b_valid_syntax=preg_match("/$exp/i", $email);

   // get mx addresses by getmxrr
   $b_mx_avail=getmxrr( $hostname, $mx_records, $mx_weight );
   $b_server_found=0;

   if($b_valid_syntax && $b_mx_avail){
     // copy mx records and weight into array $mxs
     $mxs=array();

     for($i=0;$i<count($mx_records);$i++){
       $mxs[$mx_weight[$i]]=$mx_records[$i];
     }

     // sort array mxs to get servers with highest prio
     ksort ($mxs, SORT_NUMERIC );
     reset ($mxs);

     while (list ($mx_weight, $mx_host) = each ($mxs) ) {
       if($b_server_found == 0){

         //try connection on port 25
         $fp = @fsockopen($mx_host,25, $errno, $errstr, 2);
         if($fp){
           $ms_resp="";
           // say HELO to mailserver
           $ms_resp.=send_command($fp, "HELO microsoft.com");

           // initialize sending mail 
           $ms_resp.=send_command($fp, "MAIL FROM:<support@microsoft.com>");

           // try receipent address, will return 250 when ok..
           $rcpt_text=send_command($fp, "RCPT TO:<".$email.">");
           $ms_resp.=$rcpt_text;
           
           if(substr( $rcpt_text, 0, 3) == "250")
             $b_server_found=1;

           // quit mail server connection
           $ms_resp.=send_command($fp, "QUIT");

         fclose($fp);

         }

       }
    }
  }
  return $b_server_found;
}

function send_command($fp, $out){

  fwrite($fp, $out . "\r\n");
  return get_data($fp);
}

function get_data($fp){
  $s="";
  stream_set_timeout($fp, 2);

  for($i=0;$i<2;$i++)
    $s.=fgets($fp, 1024);

  return $s;
}

// support windows platforms
if (!function_exists('getmxrr')) 
    { 
    /* 
        This function is a replacement for the missing Windows function getmxrr. 
        
        The parameters are the same as those for the normal getmxrr function. 
        
        The steps this function takes are : 
        
        1 - Use NSLOOKUP.EXE to get the MX records for the supplied Host. 
        2 - Use regular expressions to extract the mail servers and the preference. 
        3 - Sort the results by preference. 
        4 - Set the return arrays. 
        5 - Return true or false. 
    */ 
    function getmxrr($s_HostName, array &$a_MXHosts = NULL, array &$a_Weights = NULL) 
        { 
        // Simulate all the required network activity by executing windows' NSLOOKUP. 
        $s_NSLookup = shell_exec("nslookup -q=mx {$s_HostName} 2>nul"); 
        preg_match_all("'^.*MX preference = (\d{1,10}), mail exchanger = (.*)$'simU", $s_NSLookup, $a_MXMatches); 

        // If there is something to return ... 
        if (count($a_MXMatches[2]) > 0) 
            { 
            // Produce output arrays if they have been requested. 
            $i_ArgCount = func_num_args(); 
            if ($i_ArgCount > 1) 
                { 
                array_multisort($a_MXMatches[1], $a_MXMatches[2]); 
                switch ($i_ArgCount) 
                    { 
                    case 3 : 
                        $a_Weights = $a_MXMatches[1]; 
                    case 2 : 
                        $a_MXHosts = $a_MXMatches[2]; 
                    } 
                } 
            return True; 
            } 
        else 
            { 
            return False; 
            } 
        } 
    } 
?>
