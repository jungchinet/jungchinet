<?php
//if (!defined("_RSSREADER_")) exit; // 개별 페이지 접근 불가 

$g4_path = "/home/hosting_users/jungchinet2/www";

require_once "$g4_path/common.php";
if(!$bo_table) exit;
include "rss_inc.php";


// 가져온 뉴스 중 몇개까지 보여줄건지..
define("PAGE_LIMIT", 100000);
// 날짜 형태
define("DATE_FORMAT", "Y/m/d H:i:s");
// 리프레시 시간 (분)
define("REFRESH_MINUTE", 2);

$lastmodified = get_last_modified_time();

// 리프레시 시간 내에 있으면 cache hit
if(time() - $lastmodified  >= REFRESH_MINUTE * 60 || $now_read) {
    require_once $rss_path."/RSS.php";
        // url_fopen 허용
        if (ini_get("allow_url_fopen") == 0) {
                ini_set("allow_url_fopen", 1);
        }

        $news = array();
        $channel_list = array();

        // 채널 목록을 읽어온다.

		$channel_list = explode("\n", read_addr($channelFile));
		for($i=0; $i<count($channel_list); $i++) $channel_list[$i] = trim($channel_list[$i]);

		if($md == "ns") {
			unset($channel_list);
			if($channel) $channel_list[0] = $channellist[$channel].$search;
			else {
				for($k=1; $k<count($channellist); $k++) $channel_list[$k-1] = $channellist[$k].$search;
			}
		}

        // 각 채널에서 뉴스를 읽어온다.
        foreach($channel_list as $rss_url) {

                if(PEAR::isError($r =& new XML_RSS($rss_url)))
                        continue;

                $r->parse();

                /* 
                        keys :title, link, description, dc:date (or pubdate)
                */
                $channel_info = array();

                foreach($r->getChannelInfo() as $key => $val) {
                        $channel_info["cp_" . $key] = $val;
                }

                foreach ($r->getItems() as $value) {

                        array_change_key_case($value, CASE_LOWER);

                        $tmp_arr = array_merge($value, $channel_info);

                        if($tmp_arr["dc:date"])
                                $tmp_arr[date] = $tmp_arr["dc:date"];
                        else if($tmp_arr["pubdate"])
                                $tmp_arr[date] = $tmp_arr["pubdate"];

                        // unix timestamp를 키로 한다.
                        $key = strtotime($tmp_arr[date]);

						if($key > 0) $tmp_arr[date] = date(DATE_FORMAT, $key);
						else  if(ereg("T", $tmp_arr[date], $reg)) {
							$tmp_arr[date] = str_replace('+09:00','',$tmp_arr[date]); 
							$tmp_arr[date] = str_replace('T',' ',$tmp_arr[date]); 
							$tmp_arr[date] = str_replace('-','/',$tmp_arr[date]); 
						}
					
                        // 키가 중복되지 않도록....
                        while(array_key_exists($key,$news)) {
                                $key--;
                        }

                        if($tmp_arr[description])
                                $tmp_arr[description] = parse_description($tmp_arr[description]);
                        $news[$key] = $tmp_arr;
                }
        }

		// 시간의 역순으로 정렬
        ksort($news, SORT_NUMERIC);
//		$article = $news;

        $k = 0;

        // 뉴스 아이템을 화면에 출력한다.
        foreach($news as $item) {
            $k++;
            // 제한 갯수 까지만 보여준다
            if($k > PAGE_LIMIT) break;
			$article[] = $item;
        }

		unset($news);

        set_modified();
}

// description 교정
function parse_description($body) {
        $current = array(
                        "<a href="
                        );
        $target = array(
                        "<a target='_blank' href="
                        );
        $body = str_replace($current, $target, $body);
        return $body;
}

// 마지막 수정 시간
function get_last_modified_time() {
	global $rss_path, $cacheFile;
	$lastmodifiedtime = 0;
	if(file_exists($rss_path."/$cacheFile")) {
//		$lastmodifiedtime = trim(file($rss_path."/$cacheFile"));
		$fd = fopen ($rss_path."/$cacheFile", "r");
		$lastmodifiedtime = trim(fgets($fd, 11));
        fclose ($fd); 

	}
	return $lastmodifiedtime;
}

// 수정 내역 반영
function set_modified() {
	global $g4, $bo_table, $rss_path, $write_table, $article, $writer_name, $writer_id, $writer_passwd, $cacheFile, $now_read, $md;
	$fd = fopen ($rss_path."/$cacheFile", "w");
	fwrite($fd, time());
	fclose ($fd); 
	$flg = 0;
	for($i=0; $i < count($article); $i++) {
		
		// 게시판 DB에 추가
		$wr_num = get_next_num($write_table);

		$article[$i][title] = get_text(cut_str($article[$i][title], 255), 0);
		$stg = array( "&#038;", "&#039;", "quot;", "&lt;", "&gt;", "#39;" );
		$otg = array( "", "\'", "\"", "<", ">", "" );

		for($k=0; $k<count($stg); $k++) $article[$i][title] = str_replace($stg, $otg, $article[$i][title]);

		$article[$i][cp_title] = addslashes(strip_tags($article[$i][cp_title]));
//		$article[$i][title] = addslashes($article[$i][title]);
		$article[$i][description] = addslashes($article[$i][description]);

		// 이미 등록된 데이터는 건너뜀
		$sql = " select count(*) as cnt from $write_table where wr_link1 = '{$article[$i][link]}'";
		$row = sql_fetch($sql);
		if ($row[cnt]) continue;
		$writer_passwd = sql_password($writer_passwd);

		$sql = " insert into $write_table
					set wr_num = '$wr_num',
						wr_reply = '',
						wr_comment = 0,
						ca_name = '{$article[$i][cp_title]}',
						wr_option = 'html1',
						wr_subject = '{$article[$i][title]}',
						wr_content = '{$article[$i][description]}',
						wr_link1 = '{$article[$i][link]}',
						wr_link2 = '',
						wr_link1_hit = 0,
						wr_link2_hit = 0,
						wr_trackback = '',
						wr_hit = 0,
						wr_good = 0,
						wr_nogood = 0,
						mb_id = '$writer_id',
						wr_password = '$writer_passwd',
						wr_name = '$writer_name',
						wr_email = '',
						wr_homepage = '',
						wr_datetime = '{$article[$i][date]}',
						wr_ip = '',
						wr_1 = '',
						wr_2 = '',
						wr_3 = '',
						wr_4 = '',
						wr_5 = '',
						wr_6 = '',
						wr_7 = '',
						wr_8 = '',
						wr_9 = '',
						wr_10 = '' ";
		sql_query($sql);
		$flg++;


		$wr_id = mysql_insert_id();

		// 부모 아이디에 UPDATE
		sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

		// 새글 INSERT
//		sql_query(" insert into $g4[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime ) values ( '$bo_table', '$wr_id', '$wr_id', '$g4[time_ymdhis]' ) ");

		// 게시글 1 증가
		sql_query("update $g4[board_table] set bo_count_write = bo_count_write + 1 where bo_table = '$bo_table'");
	}

	if($md && !$flg)  echo "<script>alert('수집된 글이 없습니다.'); opener.location.href=\"$g4[bbs_path]/board.php?bo_table={$bo_table}\"; self.close();</script>";
	else if($md)   echo "<script>opener.location.href=\"$g4[bbs_path]/board.php?bo_table={$bo_table}\"; self.close();</script>";
	else if(!$flg && $now_read && !$md) echo "<script>alert('수집된 글이 없습니다.')</script>";
	else if($flg) echo "<script>parent.location.href=\"$g4[bbs_path]/board.php?bo_table={$bo_table}\"</script>";
}

?>