<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// head - 좌측 메뉴
include_once("$memo_skin_path/memo2.head.skin.php");

// 메인에 출력될 내용들이 있는 곳----
if ($class == "view") {
    // 쪽지 보기
    include_once("$memo_skin_path/memo2_view.skin.php");
} else { 
    // 쪽지 보기가 아닌경우
    switch ($kind) {
      case 'write' : 
            include_once("$memo_skin_path/memo2_write.skin.php"); 
            break;
      case 'online' :
            include_once("$memo_skin_path/memo2_online.skin.php"); 
            break;        
      case 'memo_group' :
            include_once("$memo_skin_path/memo2_group_member.skin.php"); 
            break;
      case 'memo_group_admin' :
            include_once("$memo_skin_path/memo2_group_admin.skin.php"); 
            break;
      case 'memo_address_book' :
            include_once("$memo_skin_path/memo2_memo_address_book.skin.php"); 
            break;
      case 'memo_config' :
            include_once("$memo_skin_path/memo2_config.skin.php"); 
            break;
      default :
            include_once("$memo_skin_path/memo2_list.skin.php"); 
    }
} 
// 메인에 출력될 내용들의 끝----

// tail - 하단부 영역
include_once("$memo_skin_path/memo2.tail.skin.php"); 
?>
