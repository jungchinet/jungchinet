<?
include_once("./_common.php");

//if (!$stx) alert("검색어가 없습니다."); 



$g4[title] = "검색 : " . $stx;
include_once("./_head.php");

if ($stx)
{
    //$stx = trim($stx);
    $stx = preg_replace("/\//", "\/", trim($stx));
    
    // 불당팩 - 단어필터링, 참조, write_update.php, http://sir.co.kr/bbs/board.php?bo_table=g4_tiptech&wr_id=20275
    $filters = explode(",", $config[cf_filter]);
    for ($i=0; $i<count($filters); $i++) {
        $s = trim($filters[$i]); // 필터단어의 앞뒤 공백을 없앰
        if (stristr($stx, $s)) {
            alert("검색어에 금지단어(\'{$s}\')가 포함되어 있습니다.");
            exit;
        }
    }
    
    $sop = strtolower($sop);
    if (!$sop || !($sop == "and" || $sop == "or")) $sop = "and"; // 연산자 and , or
    if (!$srows) $srows = 10; // 한페이지에 출력하는 검색 행수

    unset($g4_search[tables]);
    unset($g4_search[read_level]);
    $sql = " select gr_id, bo_table, bo_read_level from $g4[board_table] where bo_use_search = '1' and bo_list_level <= '$member[mb_level]' ";
    //            and bo_read_level <= '$member[mb_level]' ";
    if ($gr_id)
        $sql .= " and gr_id = '$gr_id' ";
    if ($onetable) // 하나의 게시판만 검색한다면
        $sql .= " and bo_table = '$onetable' ";
    $sql .= " order by bo_order_search, gr_id, bo_table ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    {
        if ($is_admin != "super") 
        {
            // 그룹접근 사용에 대한 검색 차단
            $sql2 = " select gr_use_access, gr_admin from $g4[group_table] where gr_id = '$row[gr_id]' ";
            $row2 = sql_fetch($sql2);
            // 그룹접근을 사용한다면
            if ($row2[gr_use_access])
            {
                // 그룹관리자가 있으며 현재 회원이 그룹관리자라면 통과
                if ($row2[gr_admin] && $row2[gr_admin] == $member[mb_id])
                    ;
                else 
                {
                    $sql3 = " select count(*) as cnt from $g4[group_member_table] where gr_id = '$row[gr_id]' and mb_id = '$member[mb_id]' and mb_id <> '' ";
                    $row3 = sql_fetch($sql3);
                    if (!$row3[cnt])
                        continue;
                }
            }
        }
        $g4_search[tables][] = $row[bo_table];
        $g4_search[read_level][] = $row[bo_read_level];
    }

    $search_query = "sfl=".urlencode($sfl)."&stx=".urlencode($stx)."&sop=$sop";


    $text_stx = get_text(stripslashes($stx));

    $op1 = "";

    // 검색어를 구분자로 나눈다. 여기서는 공백
    $s = explode(" ", strip_tags($stx));

    // 검색필드를 구분자로 나눈다. 여기서는 +
    $field = explode("||", trim($sfl));

    $str = "(";
    for ($i=0; $i<count($s); $i++) 
    {
        if (trim($s[$i]) == "") continue;
        //$search_str = strtolower($s[$i]);
        $search_str = $s[$i];
        $str .= $op1;
        $str .= "(";
        
        $op2 = "";
        for ($k=0; $k<count($field); $k++) // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)
        {
            $str .= $op2;
            switch ($field[$k]) 
            {
                case "mb_id" :
                case "wr_name" :
                    $str .= "$field[$k] = '$s[$i]'";
                    break;
                case "wr_subject" :
                case "wr_content" :
                    if (preg_match("/[a-zA-Z]/", $search_str))
                        $str .= "INSTR(LOWER($field[$k]), LOWER('$search_str'))";
                    else
                        $str .= "INSTR($field[$k], '$search_str')";
                    break;
                default :
                    $str .= "1=0"; // 항상 거짓
                    break;
            }
            $op2 = " or ";
        }
        $str .= ")";

        $op1 = " $sop ";

        // 인기검색어
        $sql = " insert into $g4[popular_table] set pp_word = '$search_str', pp_date = '$g4[time_ymd]', pp_ip = '$remote_addr', bo_table='$onetable', mb_id = '$member[mb_id]', sfl = '$sfl' ";
        sql_query($sql, FALSE);
        $pp_id = mysql_insert_id();


        // 인기검색어 sum - 신규로 들어갈 때만, 안들어가면? 그냥 지나가야 되는거야. ㅎㅎ
        if ($pp_id) {
            // 게시판이 있는 경우
            if ($bo_table)
                $bo_sql = " and bo_table='$bo_table' ";
            else
                $bo_sql = " and bo_table='' ";
            // 일단 sum 테이블을 업데이트 하고
            $sql = " update $g4[popular_sum_table] set pp_count=pp_count+1 where pp_date='$g4[time_ymd]' and pp_word='$search_str' $bo_sql ";
            sql_query($sql, FALSE);
            // sum 테이블이 없으면 insert를 하면 되거든.
            if ( $pp_id && mysql_affected_rows() == 0 ) {
                $sql = " insert into $g4[popular_sum_table] set pp_word = '$search_str', pp_date = '$g4[time_ymd]', bo_table='$bo_table', pp_count='1' ";
                sql_query($sql, FALSE);
            }
            // 담에는 검색결과 필터링을 위한 레벨을 넣어주는거야.
            $sql3 = " select pp_level from $g4[filter_table] where pp_word = '$search_str' ";
            $result3 = sql_fetch($sql3);
            if ($result3) {
                $sql4 = " update  $g4[popular_sum_table] set pp_level=$result3[pp_level] where pp_date='$g4[time_ymd]' and pp_word='$search_str' $bo_sql ";
                sql_query($sql4);
            }
        }
    }
    $str .= ")";

    $sql_search = $str . " and wr_option not like '%secret%' "; // 비밀글은 제외
    //$sql_search = $str;

    $str_board_list = "";
    $board_count = 0;

    $time1 = get_microtime();

    $total_count = 0;
    for ($i=0; $i<count($g4_search[tables]); $i++) 
    {
        $tmp_write_table   = $g4[write_prefix] . $g4_search[tables][$i];
        
        $sql = " select wr_id from $tmp_write_table where $sql_search ";
        $result = sql_query($sql, false);
        $row[cnt] = @mysql_num_rows($result);

        //$sql = " select count(*) as cnt from $tmp_write_table where $sql_search ";
        //$row = sql_fetch($sql);

        $total_count += $row[cnt];
        if ($row[cnt]) 
        {
            $board_count++;
            $search_table[] = $g4_search[tables][$i];
            $read_level[]   = $g4_search[read_level][$i];
            $search_table_count[] = $total_count;

            $sql2 = " select bo_subject from $g4[board_table] where bo_table = '{$g4_search[tables][$i]}' ";
            $row2 = sql_fetch($sql2);
            $str_board_list .= "<li><a href='$_SERVER[PHP_SELF]?$search_query&gr_id=$gr_id&onetable={$g4_search[tables][$i]}'>$row2[bo_subject]</a> ($row[cnt])";
        }
    }

    $rows = $srows;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    for ($i=0; $i<count($search_table); $i++) 
    {
        if ($from_record < $search_table_count[$i]) 
        {
            $table_index = $i;
            $from_record = $from_record - $search_table_count[$i-1];
            break;
        }
    }

    $bo_subject = array();
    $list = array();

    $k=0;
    for ($idx=$table_index; $idx<count($search_table); $idx++) 
    {
        $sql = " select bo_subject from $g4[board_table] where bo_table = '$search_table[$idx]' ";
        $row = sql_fetch($sql);
        $bo_subject[$idx] = $row[bo_subject];

        $tmp_write_table = $g4[write_prefix] . $search_table[$idx];

        $sql = " select wr_id, wr_subject, wr_option, wr_is_comment, wr_parent, wr_content, mb_id, wr_name, wr_email, wr_homepage from $tmp_write_table where $sql_search order by wr_id desc limit $from_record, $rows ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++) 
        {
            // 검색어까지 링크되면 게시판 부하가 일어남
            $list[$idx][$i] = $row;
            $list[$idx][$i][href] = "./board.php?bo_table=$search_table[$idx]&wr_id=$row[wr_parent]";

            if ($row[wr_is_comment]) 
            { 
                $link .= "#c{$row[wr_id]}";
                $sql2 = " select wr_subject, wr_option from $tmp_write_table where wr_id = '$row[wr_parent]' ";
                $row2 = sql_fetch($sql2);
                //$row[wr_subject] = $row2[wr_subject];
                $row[wr_subject] = get_text($row2[wr_subject]);
            }

            // 비밀글은 검색 불가
            if (strstr($row[wr_option].$row2[wr_option], "secret")) 
                $row[wr_content] = "[비밀글 입니다.]";

            $subject = get_text(stripslashes($row[wr_subject]));
            if (strstr($sfl, "wr_subject")) 
                $subject = search_font($stx, $subject);

            if ($read_level[$idx] <= $member[mb_level])
            {
                $content = cut_str(strip_tags($row[wr_content]),300,"…");
                if (strstr($sfl, "wr_content")) 
                    $content = search_font($stx, $content);
            }
            else
                $content = '';

            $list[$idx][$i][subject] = $subject;
            $list[$idx][$i][content] = $content;
            $list[$idx][$i][name] = get_sideview($row[mb_id], cut_str($row[wr_name], $config[cf_cut_name]), $row[wr_email], $row[wr_homepage]);
            
            $k++;
            if ($k >= $rows) 
                break; 
        }
        sql_free_result($result);
        
        if ($k >= $rows) 
            break; 

        $from_record = 0;
    }

    $write_pages = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$search_query&gr_id=$gr_id&srows=$srows&onetable=$onetable&page=");

    echo "<script type=\"text/javascript\" src=\"$g4[path]/js/sideview.js\"></script>";
}

$group_select = "<select id='gr_id' name='gr_id' class=select><option value=''>전체 분류";
$sql = " select gr_id, gr_subject from $g4[group_table] order by gr_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
    $group_select .= "<option value='$row[gr_id]'>$row[gr_subject]";
$group_select .= "</select>";

if (!$sfl) $sfl = "wr_subject";
if (!$sop) $sop = "or";

$search_skin_path = "$g4[path]/skin/search/$config[cf_search_skin]";

@include_once("$search_skin_path/search.head.skin.php");

include_once("$search_skin_path/search.skin.php");

@include_once("$search_skin_path/search.tail.skin.php");

include_once("./_tail.php");
?>
