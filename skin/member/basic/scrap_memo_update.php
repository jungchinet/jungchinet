<?
include_once("./_common.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!$member[mb_id]) 
  alert("회원만 사용할 수 있습니다");

if (!$ms_id)
  alert("스크랩 아이디가 지정되지 않았습니다.");

//if (!$memo_edit)
//  alert("수정할 메모가 입력되지 않았습니다.");
  
$memo_edit = addslashes($memo_edit);

$sql = " update $g4[scrap_table] set ms_memo = '$memo_edit' where ms_id = '$ms_id' and mb_id = '$member[mb_id]' ";
sql_query($sql, FALSE);

goto_url("$g4[bbs_path]/scrap.php?head_on=$head_on&mnb=$mnb&snb=$snb");
?>
