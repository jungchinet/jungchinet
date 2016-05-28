<?
$g4_path = "../../..";
include_once("$g4_path/common.php");

if (!$bo_table && !$wr_id)
    die("bo_table 혹은 wr_id 가 없습니다.");

include_once("$board_skin_path/auction.lib.php");
include_once("$g4[path]/head.sub.php");

if (!$write)
    alert_only("bo_table 과 wr_id 를 확인하십시오.");

if (!$point)
    alert_only("point 를 입력해주세요.");

tender_send($wr_id, $point);

?>
<script language=javascript>
alert("<?=number_format($point)?> 포인트로 입찰하였습니다.", "<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>");
</script>
<?
include_once("$g4[path]/tail.sub.php");
?>
