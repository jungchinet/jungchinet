<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

switch ($kind) {
  case 'send' : 
                memo4_cancel($me_id);
                break;
  default : 
    alert("발신함의 쪽지만 발신취소를 할 수 있습니다.");
}

alert("쪽지를 발신취소 하였습니다.", "./memo.php?kind=$kind");
?>
