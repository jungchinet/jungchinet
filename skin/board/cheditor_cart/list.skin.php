<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

/*******************************************************************************
*
* Cart 게시판 기능을 위해서 추가된 부분
*
*******************************************************************************/

if ( !$is_admin) {
  
    // 공지가져오기
    $noticeNumS = str_replace("\n",",",$board[bo_notice]);
    $bb_query2 = "select * from `{$write_table}` where 1 and find_in_set(wr_id,'{$noticeNumS}') and wr_is_comment != 1 order by  wr_num, wr_reply;";
    $result2 = sql_query($bb_query2);
    $bb_notice_count = mysql_num_rows($result2);
    $list2A = array();
    while ($row = sql_fetch_array($result2))
    {
    	$row = get_list($row, $board, $g4[path].'/skin/board/'.$board[bo_skin], $board[bo_subject_len]);
    	array_push($list2A, $row);
    }

    // 검색항목 설정하기
    if ($sca || $stx) 
    {
        $sql_search = get_sql_search($sca, $sfl, $stx, $sop);
    } else {
        $sql_search = "1 ";
    }

    // 해당 사용자가 쓴 글의 번호 + 비밀글이 아닌글의 번호 + 해당사용자에게 지정된 글번호(wr_5)
    if ($is_member)
        $bb_query1 = "select * from `{$write_table}` where $sql_search and (( mb_id = '{$member[mb_id]}' or wr_5 = '{$member[mb_id]}' ) or wr_option not like '%secret%' ) and not find_in_set(wr_id,'{$noticeNumS}') and wr_is_comment != 1 ";
//        $bb_query1 = "select * from `{$write_table}` where $sql_search and (( mb_id = '{$member[mb_id]}' or wr_5 = '{$member[mb_id]}' ) ) and not find_in_set(wr_id,'{$noticeNumS}') and wr_is_comment != 1 ";
    else
        $bb_query1 = "select * from `{$write_table}` where $sql_search and (mb_id = '{$member[mb_id]}' or wr_option not like '%secret%') and not find_in_set(wr_id,'{$noticeNumS}') and wr_is_comment != 1  ";
//        $bb_query1 = "select * from `{$write_table}` where $sql_search and not find_in_set(wr_id,'{$noticeNumS}') and wr_is_comment != 1  ";

    $result1 = sql_query($bb_query1);
    $bb_total_count = mysql_num_rows($result1);
    $list1S = "";
    while ($row = sql_fetch_array($result1))
    {
    	$list1S = $row[wr_num].",".$list1S;
    }

    $bb_total_page  = ceil($bb_total_count / $board[bo_page_rows]);  // 전체 페이지 계산
    if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $bb_from_record = ($page - 1) * $board[bo_page_rows]; // 시작 열을 구함
    $bb_url = "./board.php?bo_table={$board[bo_table]}&sca=$sca&sfl=$sfl&stx=$stx&sop=$sop&page=";
    $bb_write_pages = get_paging( 10, $page, $bb_total_page, $bb_url, $add="");

    // 공지글, 해당사용자가 쓴 글과 관련된 게시물 가져오기
    $bb_query3 = "select * from `{$write_table}` 
                           where $sql_search and find_in_set(wr_num,'{$list1S}') and wr_is_comment != 1 
                                 order by wr_num, wr_reply limit $bb_from_record, $board[bo_page_rows];";
    $result3 = sql_query($bb_query3);
    $i=$bb_total_count - $bb_from_record;
    $j=$bb_notice_count;
    while ($row = sql_fetch_array($result3))
    {
    	$row = get_list($row, $board, $g4[path].'/skin/board/'.$board[bo_skin], $board[bo_subject_len]);
    	array_push($list2A, $row);
    	$list2A[$j][num]=$i;
      $i--;
      $j++;
    }

    $total_count = $bb_total_count;
	  $list = $list2A;
    $write_pages = $bb_write_pages;
  
}
/*******************************************************************************
*
* Cart 게시판 기능을 위해서 추가된 부분 - 여기까지 
*
*******************************************************************************/

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>
?>

<? 
  // 남성/여성이 bo_sex 필드에 M/F로 등록된 경우에만 게시판을 접근을 허용 
  if($board[bo_sex]) { 
    if ($member[mb_sex]) { 
      if (($board[bo_sex] == $member[mb_sex]) || $is_admin) {} else { 
          alert("엄마/이모는 엄마방에만, 아빠/삼촌은 아빠방에만 접근할 수 있습니다"); 
          } 
    } else { ?> 
        <br> 
        <br>정보수정에서 성별을 등록한 회원만 엄마/이모, 아빠/삼촌 게시판을 이용할 수 있습니다.</b><br><br> 
        <a href='<?=$g4[bbs_path]?>/member_confirm.php?url=register_form.php'>정보수정 바로가기</a> 
        
<? exit; } 
} else { 
} ?> 

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0><tr><td>

<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr height="25">
    <td align="left">
    <span id="my_menu_add"><? include("$g4[bbs_path]/my_menu_add_script.php");?></span>
    <span id="board_subject">게시판 : <b><?=$board[bo_subject]?></b></span>
    <b><a href='<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>&sfl=mb_id%2C1&stx=<?=$member[mb_id]?>'>나의 장바구니</a></b>
    <a href='<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>'>전체 장바구니</a>
    </td>
    <? if ($is_category) { ?>
    <form name="fcategory" method="get"><td width="50%">
    <select name=sca onchange="location='<?=$category_location?>'+<?=strtolower($g4[charset])=='utf-8' ? "encodeURIComponent(this.value)" : "this.value"?>;">
    <option value=''>전체</option><?=$category_option?></select>
    </td></form>
    <? } ?>
    <td align="right" style="font:normal 11px tahoma; color:#BABABA;">
        Total <?=number_format($total_count)?> 
        <? if ($rss_href) { ?><a href='<?=$rss_href?>'><img src='<?=$board_skin_path?>/img/btn_rss.gif' border=0 align=absmiddle></a><?}?>
        <? if ($admin_href) { ?><a href="<?=$admin_href?>"><img src="<?=$board_skin_path?>/img/btn_admin.gif" title="관리자" width="63" height="22" border="0" align="absmiddle"></a><?}?></td>
</tr>
<tr><td height=5></td></tr>
</table>

<!-- 제목 -->
<form name="fboardlist" method="post" style="margin:0px;">
<input type='hidden' name='bo_table' value='<?=$bo_table?>'>
<input type='hidden' name='sfl'  value='<?=$sfl?>'>
<input type='hidden' name='stx'  value='<?=$stx?>'>
<input type='hidden' name='spt'  value='<?=$spt?>'>
<input type='hidden' name='page' value='<?=$page?>'>
<input type='hidden' name='sw'   value=''>

<table width=100% border="0" cellpadding=0 cellspacing="2">
<tr>
    <td height=2 bgcolor="#0A7299"></td>
    <? if ($is_checkbox) { ?><td bgcolor="#0A7299"></td><?}?>
    <td bgcolor="#0A7299"></td>
    <td bgcolor="#A4B510"></td>
    <td bgcolor="#A4B510"></td>
    <td bgcolor="#A4B510"></td>
    <? if ($is_good) { ?><td bgcolor="#A4B510"></td><?}?>
    <? if ($is_good) { ?><td bgcolor="#A4B510"></td><?}?>
</tr>
<tr height=28 align=center>
    <td width=50>번호</td>
    <?/* if ($is_category) { ?><td width=70>분류</td><?}*/?>
    <? if ($is_checkbox) { ?><td width=40><INPUT onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox></td><?}?>
    <td>제목</td>
    <td width=110>글쓴이</td>
    <td width=40><?=subject_sort_link('wr_datetime', $qstr2, 1)?>날짜</a></td>
    <td width=50><?=subject_sort_link('wr_hit', $qstr2, 1)?>조회</a></td>
    <?/*?><td width=40 title='마지막 코멘트 쓴 시간'><?=subject_sort_link('wr_last', $qstr2, 1)?>최근</a></td><?*/?>
    <? if ($is_good) { ?><td width=40><?=subject_sort_link('wr_good', $qstr2, 1)?>추천</a></td><?}?>
    <? if ($is_nogood) { ?><td width=40><?=subject_sort_link('wr_nogood', $qstr2, 1)?>비추천</a></td><?}?>
</tr>
<tr><td colspan=<?=$colspan?> height=3 style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x;"></td></tr>

<!-- 목록 -->
<? for ($i=0; $i<count($list); $i++) { ?>
<tr height=28 align=center> 
    <td>
        <? 
        if ($list[$i][is_notice]) // 공지사항 
            echo "<img src=\"$board_skin_path/img/icon_notice.gif\">";
        else if ($wr_id == $list[$i][wr_id]) // 현재위치
            echo "<span style='font:bold 11px tahoma; color:#E15916;'>{$list[$i][num]}</span>";
        else
            echo "<span style='font:normal 11px tahoma; color:#BABABA;'>{$list[$i][num]}</span>";
        ?></td>
    <?/* if ($is_category) { ?><td><a href="<?=$list[$i][ca_name_href]?>"><span class=small style='color:#BABABA;'><?=$list[$i][ca_name]?></span></a></td><? } */?>
    <? if ($is_checkbox) { ?><td><input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"></td><? } ?>
    <td align=left style='word-break:break-all;'>
        <? 
        echo $nobr_begin;
        echo $list[$i][reply];
        echo $list[$i][icon_reply];
        if ($is_category && $list[$i][ca_name]) { 
            echo "<span class=small><font color=gray>[<a href='{$list[$i][ca_name_href]}'>{$list[$i][ca_name]}</a>]</font></span> ";
        }
        $style = "";
        if ($list[$i][is_notice]) $style .= " style='font-weight:bold;'";
        if ($list[$i][wr_singo]) $style .= " style='color:#B8B8B8;'";
        
        echo "<a href='{$list[$i][href]}' $style>";
        echo $list[$i][subject];
        echo "</a>";

        if ($list[$i][comment_cnt]) 
            echo " <a href=\"{$list[$i][comment_href]}\"><span style='font-family:Tahoma;font-size:10px;color:#EE5A00;'>{$list[$i][comment_cnt]}</span></a>";

        // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
        // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

        //echo " " . $list[$i][icon_new];
        echo " " . $list[$i][icon_file];
        echo " " . $list[$i][icon_link];
        echo " " . $list[$i][icon_hot];
        echo " " . $list[$i][icon_secret];
        if ($list[$i][$ss_id]) {$ss_name = $list[$i][$ss_id]; echo "<font color=red> ($ss_name)님 지정비밀글</font>"; }

        echo $nobr_end;
        ?></td>
    <td><nobr style='display:block; overflow:hidden; width:105px;'><?=$list[$i][name]?></nobr></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][datetime2]?></span></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_hit]?></span></td>
    <?/*?><td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][last2]?></span></td><?*/?>
    <? if ($is_good) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_good]?></span></td><? } ?>
    <? if ($is_nogood) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_nogood]?></span></td><? } ?>
</tr>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#E7E7E7></td></tr>
<?}?>

<? if (count($list) == 0) { echo "<tr><td colspan='$colspan' height=100 align=center>게시물이 없습니다.</td></tr>"; } ?>
<tr><td colspan=<?=$colspan?> bgcolor="#0A7299" height="2"></td></tr>
</table>
</form>

<!-- 페이지 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr> 
    <td width="100%" align="center" height=30 valign=bottom>
        <? if ($prev_part_href) { echo "<a href='$prev_part_href'><img src='$board_skin_path/img/btn_search_prev.gif' border=0 align=absmiddle title='이전검색'></a>"; } ?>
        <?
        // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
        //echo $write_pages;
        $write_pages = str_replace("처음", "<img src='$board_skin_path/img/begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
        $write_pages = str_replace("이전", "<img src='$board_skin_path/img/prev.gif' border='0' align='absmiddle' title='이전'>", $write_pages);
        $write_pages = str_replace("다음", "<img src='$board_skin_path/img/next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
        $write_pages = str_replace("맨끝", "<img src='$board_skin_path/img/end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
        $write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "<b><font style=\"font-family:tahoma; font-size:11px; color:#000000\">$1</font></b>", $write_pages);
        $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><font style=\"font-family:tahoma; font-size:11px; color:#E15916;\">$1</font></b>", $write_pages);
        ?>
        <?=$write_pages?>
        <? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/btn_search_next.gif' border=0 align=absmiddle title='다음검색'></a>"; } ?>
    </td>
</tr>
</table>

<!-- 링크 버튼, 검색 -->
<form name=fsearch method=get style="margin:0px;">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=sca      value="<?=$sca?>">
<table width=100% cellpadding=0 cellspacing=0>
<tr> 
    <td width="50%" height="40">
        <? if ($list_href) { ?><a href="<?=$list_href?>"><img src="<?=$board_skin_path?>/img/btn_list.gif" border="0"></a><? } ?>
        <? if ($write_href) { ?><a href="<?=$write_href?>"><img src="<?=$board_skin_path?>/img/btn_write.gif" border="0"></a><? } ?>
        <? if ($is_checkbox) { ?>
            <a href="javascript:select_delete();"><img src="<?=$board_skin_path?>/img/btn_select_delete.gif" border="0"></a>
            <a href="javascript:select_copy('copy');"><img src="<?=$board_skin_path?>/img/btn_select_copy.gif" border="0"></a>
            <a href="javascript:select_copy('move');"><img src="<?=$board_skin_path?>/img/btn_select_move.gif" border="0"></a>
        <? } ?>
    </td>
    <td width="50%" align="right">
        <select name=sfl>
            <option value='wr_subject||wr_content'>제목+내용</option>
            <option value='wr_subject'>제목</option>
            <option value='wr_content'>내용</option>
            <option value='mb_id,1'>회원아이디</option>
            <option value='mb_id,0'>회원아이디(코)</option>
            <option value='wr_name,1'>이름</option>
            <option value='wr_name,0'>이름(코)</option>
        </select><input name=stx maxlength=15 size=10 itemname="검색어" required value='<?=stripslashes($stx)?>'><select name=sop>
            <option value=and>and</option>
            <option value=or>or</option>
        </select>
        <input type=image src="<?=$board_skin_path?>/img/search_btn.gif" border=0 align=absmiddle></td>
</tr>
</table>
</form>

</td></tr></table>

<script language="JavaScript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
    document.fsearch.sop.value = '<?=$sop?>';
}
</script>

<? if ($is_checkbox) { ?>
<script language="JavaScript">
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";
                       
    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<? } ?>
<!-- 게시판 목록 끝 -->
