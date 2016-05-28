<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 지정된 날짜 이전의 글은 볼 수 없게 하기
check_bo_from_date();

// 남성/여성이 bo_sex 필드에 M/F로 등록된 경우에만 게시판을 접근을 허용
check_bo_sex();
?>

<!-- 자동출처 -->
<? if ($board[bo_source]) { ?>
<? $copy_url = set_http("{$g4[url]}/{$g4[bbs]}/board.php?bo_table={$bo_table}&wr_id={$wr_id}"); ?>
<script type="text/javascript" src="<?=$g4['path']?>/js/autosourcing.open.compact.js"></script>
<style type="text/css">
DIV.autosourcing-stub { display:none }
DIV.autosourcing-stub-extra { position:absolute; opacity:0 }
</style>
<script type="text/javascript">
AutoSourcing.setTemplate("<p style='margin:11px 0 7px 0;padding:0'> <a href='{link}' target='_blank'> [출처] {title} - {link}</a> </p>");
AutoSourcing.setString(<?=$wr_id?> ,"<?=$config[cf_title];//$view[wr_subject]?>", "<?=$view[wr_name]?>", "<?=$copy_url?>");
AutoSourcing.init( 'view_%id%' , true);
</script>
<? } ?>

<script language="JavaScript">
function file_download(link, file) {
    <? if ($board[bo_download_point] < 0) { ?>if (confirm("'"+file+"' 파일을 다운로드 하시면 포인트가 차감(<?=number_format($board[bo_download_point])?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?"))<?}?>
    document.location.href=link;
}
</script>

<!-- n일후 코멘트 쓰지 못하게 막기, 쓰기금지 날짜지정+관리자 아니고+글쓴이도 아니고, 그러면 쓰기 레벨을 관리자만큼 높여 버린다. 누가 쓸래? ㅋㅋ -->
<?
if ($board[bo_comment_nowrite] && !$is_admin && $member[mb_id] != $write[mb_id])
    if (days_diff($write[wr_datetime]) > $board[bo_comment_nowrite])
        $board[bo_comment_level] = 10;
?>
