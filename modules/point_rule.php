<? 
$g4_path = ".."; 
include_once("$g4_path/common.php"); 
$g4[title] = "포인트정책"; 
include_once("$g4[path]/head.php"); 

//$sql_common = " from $g4[board_table] a where (1) and bo_use_search = '1' "; //게시판관리자에서 검색제외 사용시 
//$sql_common = " from $g4[group_table] a left join $g4[board_table] b on a.gr_id = b.gr_id where (1)"; // 일반적인 사용시
$sql_common = " from $g4[group_table] a left join $g4[board_table] b on a.gr_id = b.gr_id where (b.bo_use_search = 1 and a.gr_use_access = 0) "; // 일반적인 사용시

$sql = " select count(*) as cnt $sql_common"; 
$row = sql_fetch($sql); 
$total_count = $row[cnt]; 

$sql = " select * $sql_common"; 
$result = sql_query($sql); 

if (!$sst) { 
$sst= "a.gr_id, a.bo_subject"; 
$sod = "desc"; 
} 
//$sql_order = " order by gr_subject "; 원본
$sql_order = " order by a.gr_id, b.bo_table ";

$sql = " select count(*) as cnt 
$sql_common 

$sql_search 
$sql_order "; 
$row = sql_fetch($sql); 
$total_count = $row[cnt]; 

//$rows = $config[cf_page_rows]; 
$rows = 50; // 세로로 몇개의 게시판 보여줄지?

$total_page= ceil($total_count / $rows);// 전체 페이지 계산 
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지) 
$from_record = ($page - 1) * $rows; // 시작 열을 구함 

$sql = " select * 
$sql_common 
$sql_search 
$sql_order 
limit $from_record, $rows "; 
$result = sql_query($sql); 

$listall = "<a href='$_SERVER[PHP_SELF]'>처음</a>"; 

$colspan = 27; 
?> 

<style> 
.tbline1  { border-top: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7; } 
.tbline2  { border-right: 1px solid #D7D7D7; border-bottom: 1px solid #D7D7D7; } 
</style> 

<a href="<?=$g4['path']?>/sub/point_rule.php"><img src="./img/point_rule.jpg"></a>

<table width="90%" align="center" border="0" cellpadding="5" cellspacing="0"> 
<tr> 
<td> 
* 회원가입시 : <?=$config[cf_register_point]?> 점<br /> 
* 회원로긴시 : <?=$config[cf_login_point]?> 점 (하루 한번만 가능)<br /><br />
* 쪽지 보낼시 : - <?=$config[cf_memo_send_point]?> 점<br />
* 회원추천시 : <?=$config[cf_recommend_point]?> 점<br /><br /><br />

각 게시판별로 글읽기, 글쓰기, 답변/코멘트쓰기, 다운로드시 포인트가 틀리므로 아래 표를 참고하세요. 
[게시판수 : <?=number_format($total_count)?>개] 
</td> 
</tr> 
</table> 

<table width="95%" align="center" border="0" cellpadding="5" cellspacing="0" class="tbline1"> 
<tr align="center"> 
    <td class="tbline2">그룹명</td> 
<td class="tbline2">게시판명</td> 
    <td class="tbline2">글읽기</td> 
    <td class="tbline2">글쓰기</td> 
    <td class="tbline2">코멘트쓰기</td> 
    <td class="tbline2">다운로드</td> 
</tr> 


<? 
for ($i=0; $row=sql_fetch_array($result); $i++) { 


//$sql_search = " where gr_id not in ('제외그룹1', '제외그룹2') "; //sir. 관리자가 알려줌
//제외게시판 ||(or) 로 구분합니다.
//예) if($row[bo_table]==test||$row[bo_table]==aaa||$row[bo_table]==qna||$row[bo_table]==link){} 
if($row[bo_table]==link){} 
else{ ?> 

<tr onMouseOver=this.style.backgroundColor='#eeeeee' onMouseOut=this.style.backgroundColor=''> 
<td class="tbline2"> 
        <a href='<?=$g4[bbs_path]?>/group.php?gr_id=<?=$row[gr_id]?>'><b><?=$row[gr_subject]?></b></a> 
    </td> 
<td class="tbline2"> 
        <a href='<?=$g4[bbs_path]?>/board.php?bo_table=<?=$row[bo_table]?>'><b><?=$row[bo_subject]?></b></a> 
    </td> 
    <td align="right" class="tbline2"><?=$row[bo_read_point]?> 점</td> 
    <td align="right" class="tbline2"><?=$row[bo_write_point]?> 점</td> 
    <td align="right" class="tbline2"><?=$row[bo_comment_point]?> 점</td> 
    <td align="right" class="tbline2"><?=$row[bo_download_point]?> 점</td> 
</tr> 
<? } ?> 

<? }  if ($i == 0) echo "<tr><td colspan=6 align=center height=100>자료가 없습니다.</td></tr>"; ?> 
</table> 

<? 
$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?page="); 
echo "<table width='95%' height='40' cellpadding=0 cellspacing=0>"; 
echo "<tr><td width='30%' align='right'>$pagelist&nbsp;&nbsp;</td></tr></table>\n"; 
?> 

<? 
include_once("$g4[path]/tail.php"); 
?>
