<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<script type="text/javascript">
function print_contents(print_id) 
{ 
var contents = "";
contents += "<html><head><meta http-equiv='content-type' content='text/html; charset=<?=$g4[charset]?>'>";
contents += "<title><?=$g4[title]?></title>";
contents += "<link rel='stylesheet' href='<?=$g4[path]?>/style.css' type='text/css'>";
contents += "</head>";
contents += "<body>";
contents += "<link rel='stylesheet' href='<?=$memo_skin_path?>/memo2.css' type='text/css'>";
contents += "<div>";
contents += document.getElementById(print_id).innerHTML; 
contents += "</div>";
contents += "</body>";
contents += "</html>";
var width_dim = document.getElementById(print_id).clientWidth + 20;
var width = width_dim + 'px';
var height_dim = 600;
var height = height_dim + 'px'; 
var left = (screen.availWidth - width_dim) / 2; 
var top = (screen.availHeight - height_dim) / 2; 
var options = 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',status=no,resizable=no,scrollbars=yes'; 
var win = window.open('', '', options); 
win.document.write(contents); 
if (document.all) { 
win.document.execCommand('Print'); 
} 
else { 
win.print(); 
}
}
</script> 

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align=left>&nbsp;<img src="<?=$memo_skin_path?>/img/memo_icon01.gif" width="13" height="12" align=absmiddle />
  &nbsp;<b><?=$memo_title?> - 쪽지보기</b></td>
  <td align=right>
  <? if ($config[cf_memo_print]) { ?><a href="#" onclick="javascript:print_contents('memo_contents')">프린트</a>&nbsp;&nbsp;&nbsp;<? } ?>
  <? if ($view[after_href]) { ?><a href='<?=$view[after_href]?>'>다음</a>&nbsp;&nbsp;&nbsp;<? } ?>
  <? if ($view[before_href]) { ?><a href='<?=$view[before_href]?>'>이전</a>&nbsp;&nbsp;&nbsp;<? } ?>
  <a href='<?=$memo_url?>?kind=<?=$kind?>&sfl=<?=$sfl?>&stx=<?=$stx?>&unread=<?=$unread?>&page=<?=$page?>'>목록</a>
  &nbsp;
  </td>
</tr>
</table>

<form name="fboardlist" id="fboardlist" method="post" style="margin:0px;">
<input type='hidden' name='kind'  value='<?=$kind?>'>
<input type='hidden' name='me_id'  value='<?=$me_id?>'>      
<table class="tbl_type" width="99%" border="0" cellspacing="0" cellpadding="0" id="memo_contents">
    <colgroup> 
      <col width="80">
      <col width="">
      <col width="180">
    </colgroup> 
    <thead>
    <tr>
        <th>제&nbsp;&nbsp;목</th>
        <th align=left colspan=2>&nbsp;<?=$view['me_subject']?></th>
    </tr>
    </thead>
    <tr>
        <td>보낸사람 </td>
        <td align=left colspan=2>&nbsp;<?=$view['me_send_mb_id_nick']?> (<?=$view['me_send_datetime']?>)</td>
    </tr>
    <? if ($kind == 'notice') { ?>
        <? if ($is_admin=='super' || $member['mb_id']==$view['me_send_mb_id']) { ?>
        <tr>
            <td>수신레벨</td>
            <td align=left colspan=2>&nbsp;<?=$view['me_recv_mb_id']?></td>
        </tr>
        <tr>
            <td>안읽은사람</td>
            <td align=left colspan=2>
            <?
            $sql = " select count(*) as cnt from $g4[memo_recv_table] where me_send_datetime = '$view[me_send_datetime]' and me_send_mb_id = '$member[mb_id]' and me_read_datetime = '0000-00-00 00:00:00' ";
            $result = sql_fetch($sql);
            $memo_notice_unread = $result['cnt'];
            ?>
            &nbsp;<?=number_format($memo_notice_unread)?>명
            </td>
        </tr>
        <? } ?>
    <?} else {?>
        <tr>
            <td>받는사람</td>
            <td align=left colspan=2>&nbsp;<?=$view['me_recv_mb_id_nick']?> (<?=$view['me_read_datetime']?>)</td>
        </tr>
    <? } ?>

    <? if ($view[me_file_local] && !$view[imagesize]) { ?>
    <tr>
        <td>첨부파일 </td>
        <td align=left colspan=2>
            <a href="javascript:file_download()" title="<?=$view[me_file_local]?>"><?=$view[me_file_local]?></a>
        </td>
    </tr>
    <? } ?>

    <!-- 첨부파일의 이미지를 출력 -->
    <? if ($view[me_file_local] && $view[valid_image]) { ?>
    <tr>
        <td height="20" align="center" style="padding-bottom:10px; width:<?=$content_inner_width?>px" colspan=3>
        <?
        if ($config['cf_memo_b4_resize']) {
            echo resize_content(" <img src='$g4[path]/data/memo2/$view[me_file_server]' style='cursor:pointer;' > ", $max_img_width);
            }
        else
            echo " <img src='$g4[path]/data/memo2/$view[me_file_server]' name='target_resize_image[]' onclick='image_window(this)' style='cursor:pointer;' > ";
        ?>
        </td>
    </tr>
    <? } ?>

    <tr>
        <td style="text-align:left; padding-left:15px; padding-top:30px; padding-bottom:30px; word-break:break-all;" colspan=3>
        <?
        if ($config['cf_memo_b4_resize'])
            echo resize_content($view['memo'], $max_img_width);
        else
            echo $view['memo'];

        // 서명이 있으면 서명을 출력
        if ($mb_send['mb_signature'])
            echo "<div style='border-bottom:1px solid #E7E7E7; padding:25px 0;text-align:center;'>$mb_send[mb_signature]</div>";
        ?>
        </td>
    </tr>

    <tfoot>
    <tr>
        <td>
            <? if ($kind=="recv" or ($kind=="save" and $class=="view")) { ?>
              <a href='<?=$memo_url?>?kind=write&me_recv_mb_id=<?=$view[me_send_mb_id]?>&me_id=<?=$me_id?>&me_box=<?=$kind?>'><img src="<?=$memo_skin_path?>/img/reply.gif" /></a>&nbsp;
            <? } ?>
        </td>
        <td colspan=2>
            <a href='<?=$memo_url?>?kind=<?=$kind?>&sfl=<?=$sfl?>&stx=<?=$stx?>&unread=<?=$unread?>&page=<?=$page?>'><img src="<?=$memo_skin_path?>/img/list.gif" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <? if ($kind=="spam" && $view[spam_href]) { ?>
            <a href='<?=$view[spam_href]?>'><img src="<?=$memo_skin_path?>/img/spam_cancel.gif" ></a>&nbsp;
            <? } ?>
            <? if ($kind=="spam" && $is_admin == "super") { ?>
            <a href="javascript:all_cancel_spam();"><img src="<?=$memo_skin_path?>/img/spam_cancel_all.gif" ></a>&nbsp;
            <? } ?>
            <? if ($kind=="recv" && $view[spam_href]) { ?>
            &nbsp;&nbsp;&nbsp;<a href='<?=$view[spam_href]?>'>
            <img src="<?=$memo_skin_path?>/img/bt03.gif" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <? } ?>
            <? if ($kind=="send" and $view[me_read_datetime] == "읽지 않음") { ?>
            <a href='<?=$view[cancel_href]?>'>
            <img src="<?=$memo_skin_path?>/img/icon_cancel.gif" /></a>&nbsp;
            <? } ?>
            <? if ($kind=="recv" or $kind=="send") { ?>
            <a href='<?=$view[save_href]?>'>
            <img src="<?=$memo_skin_path?>/img/save.gif" /></a>&nbsp;
            <? } ?>
            <? if ($kind=="recv" or $kind=="send" or $kind=="save" or $kind=="spam") { ?>
            <a href='javascript:del_memo();'>
            <img src="<?=$memo_skin_path?>/img/bt04.gif" /></a>
            <? } ?>
            <!-- 공지쪽지 삭제 = 공지쪽지삭제 + 발송된 것 모두 회수 -->
            <? if ($kind=="notice" and ($is_admin == 'super' || $view[me_send_mb_id]==$member[mb_id])) { ?>
            <a href='javascript:withdraw_notice_memo();'>
            <img src="<?=$memo_skin_path?>/img/bt04.gif" /></a>
            <? } ?>
            <? if ($kind=="trash" and $view[recover_href]) { ?>
            <a href='<?=$view[recover_href]?>'>
            <img src="<?=$memo_skin_path?>/img/icon_undelete.gif" /></a>
            <? } ?>
            &nbsp;
        </td>
    </tr>
    </tfoot>
</table>
</form>

<?
// 구글 광고를 include
$ad_file = $memo_skin_path . "/memo2_adsense.php";
if (file_exists($ad_file)) {
    include_once($ad_file);
}
?>

<script type="text/javascript">
function file_download() {
    var link = "<?=$g4[bbs_path]?>/download_memo_file.php?kind=<?=$kind?>&me_id=<?=$me_id?>";
    document.location.href=link;
}

// 스팸을 취소
function all_cancel_spam() {
    var f = document.fboardlist;

    str = "스팸회수";

    if (!confirm("모든 쪽지를 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./memo2_form_spam_cancel.php";
    f.submit();
}

function del_memo() 
{ 
   if (confirm("쪽지를 삭제 하시겠습니까?")) 
            location.href = "<?=$view[del_href]?>"; 
}

function withdraw_notice_memo() 
{ 
   if (confirm("공지쪽지를 삭제하면, 발송된 쪽지를 모두 회수(삭제) 합니다.\n\n공지쪽지 삭제를 진행 하시겠습니까?")) 
            location.href = "./memo2_withdraw_notice.php?kind=<?=$kind?>&me_id=<?=$me_id?>"; 
}
</script>

<script type="text/javascript"  src="<?="$g4[path]/js/board.js"?>"></script>
<script type="text/javascript">
window.onload=function() {
    resizeBoardImage(<?=(int)$max_img_width?>);
    drawFont();
}
</script>
