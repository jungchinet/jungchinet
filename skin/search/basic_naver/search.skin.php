<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<script type="text/javascript" src="<?="$g4[path]/js/suggest.js"?>"></script>

<!-- <table width="95%"  border="0" cellspacing="0" cellpadding="0" align="center"> -->
<table width="95%"  border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="24"><img src="<?=$search_skin_path?>/img/searchbg_01.gif"></td>
<!--    <td background="<?=$search_skin_path?>/img/searchbg_02.gif"><table align=center width=95% cellpadding=2 cellspacing=0 height="50"> -->
    <td background="<?=$search_skin_path?>/img/searchbg_02.gif"><table width=95% cellpadding=2 cellspacing=0 height="50">
      <form name=fsearch method=get action="javascript:fsearch_submit(document.fsearch);"  autocomplete="off">
        <input type="hidden" name="srows" value="<?=$srows?>">
        <tr>
<!--          <td align=center  height="25"> -->
          <td height="25">
		  
		  <?=$group_select?>
                <script language="JavaScript">document.getElementById("gr_id").value = "<?=$gr_id?>";</script>
                <select name=sfl class=select>
                  <option value="wr_subject||wr_content">제목+내용</option>
                  <option value="wr_subject">제목</option>
                  <option value="wr_content">내용</option>
                  <option value="mb_id">회원아이디</option>
                  <option value="wr_name">이름</option>
                </select>
                <input type=text name=stx maxlength=20 required itemname="검색어" value='<?=$text_stx?>'>
                <input name="image" type=image src="<?=$search_skin_path?>/img/search_btn.gif"  align="absmiddle" width="60" height="25" border=0>
                
				<script language="javascript">
        document.fsearch.sfl.value = "<?=$sfl?>";
       
        function fsearch_submit(f)
        {
            /*
            // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
            var cnt = 0;
            for (var i=0; i<f.stx.value.length; i++)
            {
                if (f.stx.value.charAt(i) == ' ')
                    cnt++;
            }

            if (cnt > 1)
            {
                alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                f.stx.select();
                f.stx.focus();
                return;
            }
            */
            
            f.action = "";
            f.submit();
        }
        </script>
          </td>
        </tr>
        <tr>
<!--      <td align=center> 연산자 &nbsp; -->
          <td > 연산자 &nbsp;
                <input type="radio" name="sop" value="or" <?=($sop == "or") ? "checked" : "";?>>
            OR &nbsp;
                <input type="radio" name="sop" value="and" <?=($sop == "and") ? "checked" : "";?>>
            AND </td>
        </tr>
      </form>
    </table></td>
    <td width="23"><img src="<?=$search_skin_path?>/img/searchbg_03.gif"></td>
  </tr>
</table>

<!------------검색폼부분끝-------------->
<p>


<!-- <table align=center width=95% cellpadding=2 cellspacing=0> -->
<table width=95% cellpadding=2 cellspacing=0>
<tr>
    <td style='word-break:break-all;' class=search>

        <? 
        if ($stx) 
        { 
            echo "<b>검색된 리스트</b> (<b>{$board_count}</b>개의 리스트, <b>".number_format($total_count)."</b>개의 게시글, <b>".number_format($page)."/".number_format($total_page)."</b> 페이지)";
            if ($board_count)
            {
                echo "<ul><ul style='line-height:130%;'>";
                if ($onetable)
                    echo "<img src='$search_skin_path/img/icon_folder2.gif' border='0' align='absmiddle'>&nbsp;<a href='?$search_query&gr_id=$gr_id'>전체게시판 검색</a>";
                //echo "<img src='$search_skin_path/img/icon_folder2.gif' border='0' align='absmiddle'>&nbsp;";
				echo $str_board_list;
                echo "</ul></ul>";
            }
            else
            {
                echo "<ul style='line-height:130%;'><li><b>검색된 자료가 하나도 없습니다.</b></ul>";
            }
        }
        ?>

        <? 
        $k=0;
        for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) 
        { 
            echo "<img src='$search_skin_path/img/icon_folder2.gif' border='0' align='absmiddle'>&nbsp;<b><a href='./board.php?bo_table={$search_table[$idx]}&{$search_query}'><u>{$bo_subject[$idx]}</u></a>에서의 검색결과</b>";
            $comment_href = "";
            for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) 
            {   
        				$content = cut_str(trim(strip_tags($list[$idx][$i][wr_content])),300,"…");
                $content = search_font($stx, $content);
                echo "<ul><ul style='line-height:130%;'> <img src='$search_skin_path/img/icon_list.gif' border='0' align='absmiddle'>";
                if ($list[$idx][$i][wr_is_comment]) 
                {
                    echo "<font color=999999>[코멘트]</font> ";
                    $comment_href = "#c_".$list[$idx][$i][wr_id];
                }
                echo "<a href='{$list[$idx][$i][href]}{$comment_href}'><u>";
                echo $list[$idx][$i][subject];
                echo "</u></a> [<a href='{$list[$idx][$i][href]}{$comment_href}' target=_blank>새창</a>]<br>";
				echo $content;
                echo "<br><font color=#999999>{$list[$idx][$i][wr_datetime]}</font>&nbsp;&nbsp;&nbsp;";
                echo $list[$idx][$i][name];
                echo "</ul></ul>";
            }
        }
        ?>

<!--        <p align=center><?=$write_pages?> -->
        <p ><?=$write_pages?>

</td></tr></table>

<script language="JavaScript"> 
    document.fsearch.stx.obj = sug_set_properties(document.fsearch.stx, '<?=$search_skin_path?>/suggest_search.php', true, false, true); 
</script> 
