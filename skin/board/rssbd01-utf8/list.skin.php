<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;
	
	ini_set("allow_url_fopen", 1);

	include "rss_reader_lib.php";


	// -------------------------------------------------------------------
	// 설정 URL을 지정합니다.
	$rssurl = $board["bo_1"];
	// -------------------------------------------------------------------
	// rss설정
	$rss = new lastRSS;
	$rss->cache_dir = './cache/';   //케쉬를만들 폴더설정
	$rss->cache_time = 0;     //케쉬생성주기
	$rss->cp = 'UTF-8';      //인코딩
	$rss->date_format = 'y-m-d';   //날짜형식 년월일
	$rss->items_limit = $board["bo_page_rows"];  // 게시물 최대 
?>

<style>
.board_top { clear:both; }

.board_list { clear:both; width:100%; table-layout:fixed; margin:5px 0 0 0; }
.board_list th { font-weight:bold; font-size:12px; } 
.board_list th { background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x; } 
.board_list th { white-space:nowrap; height:34px; overflow:hidden; text-align:center; } 
.board_list th { border-top:1px solid #ddd; border-bottom:1px solid #ddd; } 

.board_list tr.bg0 { background-color:#fafafa; } 
.board_list tr.bg1 { background-color:#ffffff; } 

.board_list td { padding:.5em; }
.board_list td { border-bottom:1px solid #ddd; } 
.board_list td.num { color:#999999; text-align:center; }
.board_list td.checkbox { text-align:center; }
.board_list td.subject { overflow:hidden; }
.board_list td.name { padding:0 0 0 10px; }
.board_list td.datetime { font:normal 11px tahoma; color:#BABABA; text-align:center; }
.board_list td.hit { font:normal 11px tahoma; color:#BABABA; text-align:center; }
.board_list td.good { font:normal 11px tahoma; color:#BABABA; text-align:center; }
.board_list td.nogood { font:normal 11px tahoma; color:#BABABA; text-align:center; }

.board_list .notice { font-weight:normal; }
.board_list .current { font:bold 11px tahoma; color:#E15916; }
.board_list .comment { font-family:Tahoma; font-size:10px; color:#EE5A00; }

.board_button { clear:both; margin:10px 0 0 0; }

.board_page { clear:both; text-align:center; margin:3px 0 0 0; }
.board_page a:link { color:#777; }

.board_search { text-align:center; margin:10px 0 0 0; }
.board_search .stx { height:21px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; }
</style>

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td>

    <!-- 제목 -->
    <form name="fboardlist" method="post">
    <input type='hidden' name='bo_table' value='<?=$bo_table?>'>
    <input type='hidden' name='sfl'  value='<?=$sfl?>'>
    <input type='hidden' name='stx'  value='<?=$stx?>'>
    <input type='hidden' name='spt'  value='<?=$spt?>'>
    <input type='hidden' name='page' value='<?=$page?>'>
    <input type='hidden' name='sw'   value=''>

    <table cellspacing="0" cellpadding="0" class="board_list">
    <col width="110" />
	<col width="auto" />
    <col width="100" />
    <col width="80" />
    <tr>
        <th>구분</th>
        <th>제&nbsp;&nbsp;&nbsp;목</th>
        <th>글쓴이</th>
        <th>날짜</a></th>
    </tr>

    <? 
	if ($rs = $rss->get($rssurl)) {
		$i = 0; $z = 0;
		foreach($rs['items'] as $item) {
			
			$bg = $z%2 ? 0 : 1;

			// -------------------------------------------------------------------
			$item["link"]=str_replace("<![CDATA[", "",$item[link]);
			$item["link"]=str_replace("]]>", "",$item[link]);
			//$item["link"]=iconv('UTF-8', 'EUC-KR', $item[link]);
			$item["title"]=str_replace("<![CDATA[", "",$item[title]);	// 제목
			$item["title"]=str_replace("]]>", "",$item[title]);
			//$item["title"]=iconv('UTF-8', 'EUC-KR', $item[title]);
			$item["description"]=str_replace("<![CDATA[", "",$item[description]);	// 내용
			$item["description"]=str_replace("]]>", "",$item[description]);
			//$item["description"]=iconv('UTF-8', 'EUC-KR', $item[description]);
			//$item["author"]=iconv('UTF-8', 'EUC-KR', $item[author]);	// 작성자
			$item["category"]=str_replace("<![CDATA[", "",$item[category]);
			$item["category"]=str_replace("]]>", "",$item[category]);
			//$item["category"]=iconv('UTF-8', 'EUC-KR', $item[category]);
			// -------------------------------------------------------------------
			?>

				<tr class="bg<?=$bg?>"> 
					<td class="num"><?=$item["category"]?></td>
					<td class="subject"><a href="<?=$item["link"]?>" target="_blank" title="<?=$item["description"]?>"><?=$item["title"]?></a></td>
					<td class="name"><?=$item["author"]?></td>
					<td class="datetime"><?=$item["pubDate"]?></td>
				</tr>

				<? 

			$z++;
		} 
	}
	?>

    <? if (count($z) == 0) { echo "<tr><td colspan='4' height=100 align=center>게시물이 없습니다.</td></tr>"; } ?>

    </table>


</td></tr></table>


<!-- 게시판 목록 끝 -->
