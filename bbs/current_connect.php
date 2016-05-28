<?
include_once("./_common.php");

$g4[title] = "현재접속자";
include_once("./_head.php");

$list = array();

// redis일 때, 정보를 만들어줍니다.
if ($g4['session_type'] == "redis") {
    //redis_login();

    // redis일때만 redis login 관리를 쓴다.
    $redis_login = new Redis();
    $redis_login->connect($g4["rhost"], $g4["rport"]);
    $redis_login->select($g4["rdb1"]);

    // 모든 key를 가져와서 g4_login DB에 넣어줍니다.
    $allKeys = $redis_login->keys($g4["rdomain"] . "_login_*");   // all keys will match this.
    $i = 0;
    foreach ($allKeys as $rkey) {

        $rdat = explode ( "|", $redis_login->get($rkey) );

        if ($redis_login->ttl($rkey) > 0) {
          $list[$i]['lo_ip'] = $rdat[0];
          $list[$i]['mb_id'] = trim($rdat[1]);
          if ($list[$i]['mb_id'] !== "") {
              $mb = get_member($list[$i]['mb_id']);
              $list[$i]['mb_nick'] = $mb['mb_nick'];
              $list[$i]['mb_name'] = $mb['mb_name'];
              $list[$i]['mb_email'] = $mb['mb_email'];
              $list[$i]['mb_homepage'] = $mb['mb_homepage'];
              $list[$i]['mb_open'] = $mb['mb_open'];
              $list[$i]['mb_point'] = $mb['mb_point'];
          }
          $list[$i]['lo_datetime'] = $rdat[2];
          $list[$i]['lo_location'] = $rdat[3];
          $list[$i]['lo_url'] = $rdat[4];
          $list[$i]['lo_referer'] = $rdat[5];
          $list[$i]['lo_agent'] = $rdat[6];
          $i++;
        } else  {
            // expire된 key는 삭제
            $redis_login->delete($rkey);
        }
    }

    // redis instance connection을 닫아줍니다.
    $redis_login->close();

} else {

    $sql = " select a.mb_id, b.mb_nick, b.mb_name, b.mb_email, b.mb_homepage, b.mb_open, b.mb_point, a.lo_ip, a.lo_location, a.lo_url, a.lo_agent, a.lo_referer
               from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id)
              where a.mb_id <> '$config[cf_admin]'
              order by a.lo_datetime desc ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    {
        $list[$i] = $row;
    }
}

for ($i=0; $i < count($list); $i++) 
{

    if ($list[$i][mb_id]) {
        //$list[$i][name] = get_sideview($row[mb_id], $row[mb_nick], $row[mb_email], $row[mb_homepage]);
        $list[$i][name] = get_sideview($list[$i][mb_id], cut_str($list[$i][mb_nick], $config[cf_cut_name]), $list[$i][mb_email], $list[$i][mb_homepage]);
    } else
    {
        if ($is_admin)
            $list[$i][name] = $row[lo_ip];
        else
            $list[$i][name] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", "\\1.♡.\\3.\\4", $row[lo_ip]);
    }

    $list[$i][num] = sprintf("%03d",$i+1);
}

$write_pages = get_paging($config[cf_write_pages], $page, $total_page, "?gr_id=$gr_id&page=");

$connect_skin_path = "$g4[path]/skin/connect/$config[cf_connect_skin]";

include_once("$connect_skin_path/current_connect.skin.php");

include_once("./_tail.php");
?>