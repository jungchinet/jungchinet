<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
define("_RSSREADER_", TRUE);

/////////////////////////////////////////////////////////////////////////////////////////////////
//////// 여분필드의 용도 ////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
// 여분필드 1번 : 레벨이 $board[bo_1]값 이상이어야 글쓴이 및 조회수가 보임
// 여분필드 2번 : 1일 경우 리스트에서 글쓰기/검색 등의 링크 부분이 보이지 않음 (+ 버튼으로 열기)
/////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////
// 게시물에 붙는 아이콘들을 보여줄 것인가 ?? (깔끔하게 보여주지 말기 --> 1을 모두 0으로)
/////////////////////////////////////////////////////////////////////////////////////////////////
$pview_link = 1;		// 1일 경우에 icon_link 이미지 보여줌
$pview_link_count = 0;	// 1일 경우에 link count 보여줌
$pview_file = 1;		// 1일 경우에 icon_file 이미지 보여줌
$pview_file_count = 0;	// 1일 경우에 file count 보여줌
$pview_hot = 1;			// 1일 경우에 icon_hot 이미지 보여줌
$pview_secret = 1;		// 1일 경우에 icon_secret 이미지 보여줌
/////////////////////////////////////////////////////////////////////////////////////////////////

$pview_info = $board[bo_1];
$pview_wlink = $board[bo_2];

// 관심 단어
$interest = explode(",", $board[bo_4]);

// 관심단어 css
$istyle = "color:red;";

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;
if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>


// 등록된 ca_name을 바탕으로 카테고리 가져오기 //////////////////////////////////////////////////////////////////
$sql = " select ca_name from $write_table group by ca_name ";
$result = sql_query($sql);
$cat_cnt = 0;
for ($i=0; $row=sql_fetch_array($result); $i++, $cat_cnt++) {
	$category_option .= "<option value='".urlencode($row[ca_name])."'>".cut_str($row[ca_name], 20)."</option>\n";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<script>    
function clickshow(num){
	menu=eval("document.all.block"+num+".style");
	menu2=eval("document.all.blockl"+num+".style");
	if (menu.display=="block"){
		menu.display="none"; //닫고
	} else{
		menu.display="block";//하위메뉴를 펼친다.
	}
	menu2.display="none";
}
</script>

<style type=text/css>
body, td, p, input, button, textarea, select, .c1 { font-family:Tahoma,굴림; font-size:11px; color:#565656; }
A:link    {color:#000000;text-decoration:none;}
A:visited {color:#000000;text-decoration:none;}
A:active  {color:#000000;text-decoration:none;}
A:hover  {color:#3333FF;text-decoration:none}
img { border:0 }
</style>

<iframe src='<?=$board_skin_path?>/_rss/RSS_reader.php?bo_table=<?=$bo_table?>&board_skin_path=<?=$board_skin_path?>&now_read=<?=$now_read?>' width=0 height=0></iframe>

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0 border=0><tr><td>

<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
<table width="100%" cellspacing="0" cellpadding="0" border=0 style='padding-top:10'>
<tr height="20">
	<?


	/////////////////////////////////////////////////////////////////////////////////////////////
	// 카테고리 기능이 켜있고, 수집된 글이 있을 경우에 자동으로 생성된 카테고리 보여줌 //////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	
    if ($is_category && $cat_cnt) { ?>
		<form name="fcategory" method="get"><td><select name=sca onchange="location='<?=$category_location?>'+this.value;"><option value=''>전체</option><?=$category_option?></select></td></form>

	
	<? } ?>
	<td align="right">
        <?=number_format($total_count)?> Posts
        <? if ($rss_href) { ?> / <a href='<?=$rss_href?>' target=_blank>xml</a><?}?>
		<? if(!$member[mb_id]) {?> / <a href='<?=$g4[bbs_path]?>/login.php?url=<?=$urlencode?>'>login</a> <?} else {?>
		/ <a href='<?=$g4[bbs_path]?>/logout.php?url=<?=$urlencode?>'>logout</a> <?}?>
		<? if($member[mb_id]) { ?> / <a href='javascript:;' onclick=win_scrap();>scrap</a> <?}?>
		<? if($member[mb_id]) { ?> / <a href='javascript:;' onclick=win_memo();>memo</a> <?}?>
		<? if($member[mb_id]) { ?> / <a href='<?=$g4[bbs_path]?>/member_confirm.php?url=register_form.php'>info</a> <?}?>

		<? 

		/////////////////////////////////////////////////////////////////////////////////////////////
		// 최고 관리자 일 경우에 보이는 메뉴
		// now : 캐쉬를 무시하고 지금 글 수집하기
		// rss setup : RSS 주소, 글 수집 주기 등록
		/////////////////////////////////////////////////////////////////////////////////////////////

		if($is_admin == "super") echo " / <a href={$g4[bbs_path]}/board.php?bo_table=$bo_table&now_read=1>now</a>";
		if($is_admin == "super") echo " / <a href=\"javascript:Win_open('$board_skin_path/_rss/setup_rss.php?bo_table=$bo_table', 500, 400);\" >rss setup</a>";    
		if($is_admin == "super") echo " / <a href=\"javascript:Win_open('$board_skin_path/_rss/search_query.php?bo_table=$bo_table', 450, 40);\" >search</a>";    		
		?>
		<? if($admin_href) { ?> / <a href="<?=$admin_href?>" target=_blank>admin</a><?}?>

	</td>
</tr>
</table>

<!-- 제목 -->
<form name="fboardlist" method="post" style="margin:0px;">
<input type="hidden" name="bo_table" value="<?=$bo_table?>">
<input type="hidden" name="sfl"  value="<?=$sfl?>">
<input type="hidden" name="stx"  value="<?=$stx?>">
<input type="hidden" name="spt"  value="<?=$spt?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="sw"   value="">
<table width=100% cellpadding=0 cellspacing=0>

<!-- 목록 -->
<tr><td colspan=<?=$colspan?> bgcolor=#5C86AD height=1>
<? for ($i=0; $i<count($list); $i++) { ?>
<tr height=20 align=center style='line-height:160%'> 
    <td width=30>
        <? 
        if ($list[$i][is_notice]) // 공지사항 
            echo "<b>공지</b>";
        else if ($wr_id == $list[$i][wr_id]) // 현재위치
            echo "<font color='#2C8CB9'><strong>{$list[$i][num]}</strong>";
        else
            echo "{$list[$i][num]}";
        ?></td>
    <? if ($is_checkbox) { ?><td width=40><input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"></td><? } ?>
    <td align=left style='word-break:break-all;'>
        <? 
        echo $nobr_begin;
        echo $list[$i][reply];
        echo $list[$i][icon_reply];

		if ($is_category) { ?><a href="<?=$list[$i][ca_name_href]?>"><span class=small style='color:#333399'>{<?=cut_str($list[$i][ca_name], 20)?>}</span></font></a>&nbsp;  <? }
		if($member[mb_level] >= $board[bo_read_level]) echo "<a href='{$list[$i][href]}'>";		
		if ($list[$i][is_notice]) echo "<font color='#AF6BE3'><strong>{$list[$i][subject]}</strong></font>";
        else
        {
            $style1 = $style2 = "";
			///////////////////////////////////
			// 관심 단어 처리 /////////////////
			///////////////////////////////////
			for($k=0; $k<count($interest); $k++) {
				$list[$i][subject] = str_replace(trim($interest[$k]), "<span style='$istyle'>".trim($interest[$k])."</span>", $list[$i][subject]);
			}
/*
			if ($list[$i][icon_new]) // 최신글은 검정
                $style1 = "color:#112222;";
            if (!$list[$i][comment_cnt]) // 코멘트 없는것만 굵게
                $style2 = "font-weight:;";
*/           
			echo "<span style='$style1 $style2'>{$list[$i][subject]}</span>";
        }
        echo "</a>";

        if ($list[$i][comment_cnt]) 
            echo " <a href=\"{$list[$i][comment_href]}\"><span style='font-size:7pt;'>{$list[$i][comment_cnt]}</span></a>";

        if ($list[$i]['link']['count'] && $pview_link_count == 1) { echo "[{$list[$i]['link']['count']}]"; }
        if ($list[$i]['file']['count'] && $pview_file_count == 1) { echo "<{$list[$i]['file']['count']}>"; }

        echo " " . $list[$i][icon_new];
		
		/////////////////////////////////
		// 설정에 따라 아이콘을 보여줌 //
		/////////////////////////////////
        if($pview_file == 1) echo " " . $list[$i][icon_file];
        if($pview_link == 1) echo " <a href={$list[$i][wr_link1]} target=_blank>" . $list[$i][icon_link] . "</a>";
        if($pview_hot == 1)echo " " . $list[$i][icon_hot];
        if($pview_secret == 1)echo " " . $list[$i][icon_secret];
        echo $nobr_end;
        ?></td>
	<? if($member[mb_level] > $pview_info) { ?>
	<td width=50><?=$list[$i][name]?></td>
	<? } else { ?>
	<td></td>
	<?}?>

	<td width=50><?=$list[$i][datetime2]?></td>
	<? if($member[mb_level] > $pview_info) { ?>
		<td width=30><?=$list[$i][wr_hit]?></td>
	<? } else { ?>
		<td></td>
	<?}?>
    
	<? if ($is_good) { ?><td align="center"><?=$list[$i][wr_good]?></td><? } ?>
    <? if ($is_nogood) { ?><td align="center"><?=$list[$i][wr_nogood]?></td><? } ?>
</tr>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#E7E7E7></td></tr>
<?}?>

<? if (count($list) == 0) { echo "<tr><td colspan='$colspan' height=100 align=center>게시물이 없습니다.</td></tr>"; } ?>

</table>
</form>

<!-- 페이지 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td height=8></td></tr>
<tr> 
    <td width="100%" align="center" valign=bottom>
        <? if ($prev_part_href) { echo "<a href='$prev_part_href'>이전검색</a>&nbsp;"; } ?>
        <?
        // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
        //echo $write_pages;
        $write_pages = str_replace("처음", "<img src='$board_skin_path/img/begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
        $write_pages = str_replace("이전", "<img src='$board_skin_path/img/prev.gif' border='0' align='absmiddle' title='이전'>", $write_pages);
        $write_pages = str_replace("다음", "<img src='$board_skin_path/img/next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
        $write_pages = str_replace("맨끝", "<img src='$board_skin_path/img/end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
        $write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "<b><font style=\"font-family:돋움; font-size:9pt; color:#797979\">$1</font></b>", $write_pages);
        $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><font style=\"font-family:돋움; font-size:9pt; color:orange;\">$1</font></b>", $write_pages);
        ?>
        <?=$write_pages?>
        <? if ($next_part_href) { echo "<a href='$next_part_href'>다음검색</a>&nbsp;"; } ?>
    </td>
</tr>
</table>

<? 
	////////////////////////////////////
	// 설정에 따라 버튼 링크를 보여줌 //
	////////////////////////////////////
	if($pview_wlink == "1") { 
?>
<span id=block2 style=display:none;cursor:hand;padding-left:0 height=0> 
<? } ?>
<!-- 버튼 링크 -->

<form name=fsearch method=get style="margin:0px;">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=sca      value="<?=$sca?>">
<table width=100% cellpadding=0 cellspacing=0>
<tr> 
    <td width="50%" height="40">
        <? if ($list_href) { ?><a href="<?=$list_href?>">목록으로</a>&nbsp;<? } ?>
        <? if ($write_href_) { ?><a href="<?=$write_href?>">글쓰기</a>&nbsp;<? } ?>
        <? if ($is_checkbox) { ?>
			<INPUT onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox>
            <a href="javascript:select_delete();">삭제</a>&nbsp;

			<a href="javascript:del_all();">글정리</a>
            <a href="javascript:select_copy('copy');">복사</a>&nbsp;
            <a href="javascript:select_copy('move');">이동</a>
        <? } ?>
    </td>
    <td width="50%" align="right">
        <select name=sfl>
            <option value='wr_subject||wr_content'>제목+내용</option>
            <option value='wr_subject'>제목</option>
            <option value='wr_content'>내용</option>
            <option value='mb_id'>회원아이디</option>
            <option value='wr_name'>이름</option>
        </select><input name=stx maxlength=15 size=10 itemname="검색어" required value="<?=$stx?>"><select name=sop>
            <option value=and>and</option>
            <option value=or>or</option>
        </select>
        <input type=submit value='검색' style='background-color:white;border:0'></td>
</tr>
</table>
</form>
</span>

<? if($pview_wlink == "1") { ?>
<span id=blockl2>
<a href="javascript:;" onclick="clickshow(2)">+</a>
</span>
<?}?>
</td></tr></table>


<script language="JavaScript">
if ("<?=$sca_?>") document.fcategory.sca.value = "<?=$sca?>";
if ("<?=$stx?>") {
    document.fsearch.sfl.value = "<?=$sfl?>";
    document.fsearch.sop.value = "<?=$sop?>";
}
</script>

<? if ($is_checkbox) { ?>
<script language="JavaScript">
function all_checked(sw)
{
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str)
{
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

function del_all() {
   if (!confirm("글을 정리하시겠습니까? 모든 게시물이 삭제됩니다."))
        return;
	
	location.href='<?=$board_skin_path?>/_rss/del_all.php?bo_table=<?=$bo_table?>&w=cl';
}

// 선택한 게시물 삭제
function select_delete()
{
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
function select_copy(sw)
{
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";
                       
    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=396, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<? } ?>
<!-- 게시판 목록 끝 -->

<?
//////////////////////////////////////////////
// rss setup 창을 띄우기 위한 스크립트      //
//////////////////////////////////////////////
?>
<script>
	function Win_open(url, w, h) {
		var win = null;
		win = window.open('','_popup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width='+w+',height='+h);
		if (win == null) return;
		win.location.href = url;
	}
</script>

<?
//////////////////////////////////////////////
// 단축키 스크립트
//////////////////////////////////////////////

?>

<script type="text/javascript">
	function shortcut_onkeydown(evt) {
		evt = window.event;
		if ((set_key = evt.keyCode) && !(evt.altKey || evt.ctrlKey)) {
			if (set_key == '83') document.location.href='<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>&sca=<?=$sca?>&page=<?=(($page+1)>$total_page ? $total_page : ($page+1))?>';
			else if (set_key == '65') document.location.href='<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>&sca=<?=$sca?>&page=<?=($page-1)?>';
		}
	}

	document.onkeydown = shortcut_onkeydown;

</script>