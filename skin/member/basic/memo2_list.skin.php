<form name=fsearch method=get style="margin:0px;">
<input type='hidden' name='kind' value='<?=$kind?>'>
<table width="100%" height="30" border="0" cellspacing="0">
    <tr>
    <td>
        <b><?=$memo_title?> 
        ( <? if ($kind == "recv") echo "<a href='$memo_url?kind=recv&unread=only' title='안읽은쪽지'><font color=red>$total_count_recv_unread</font></a> / "?><a href='<?=$memo_url?>?kind=$kind'><?=number_format($total_count)?></a></span> )</b>
        &nbsp<a href="<?=$memo_url?>?kind=<?=$kind?>&sfl=me_file&stx=me_file"><img src="<?=$memo_skin_path?>/img/icon_file.gif" align=absmiddle></a>
    </td>
    <!-- 검색하기 -->
    <td align="right">
        <select name='sfl' id='sfl'>
            <option value="me_subject_memo">제목+내용</option>
            <option value="me_subject">제목</option>
            <option value="me_memo">내용</option>
        <? if ($kind == "recv" or $kind == "spam" or $kind == "notice") { ?>
            <option value="me_send_mb_nick">보낸<? if ($config['cf_memo_mb_name']) echo "(이름)"; else echo "(별명)"; ?></option>
            <option value="me_send_mb_id">보낸(아이디)</option>
        <? } else if ($kind == "send") { ?>
            <option value="me_recv_mb_nick">받은<? if ($config['cf_memo_mb_name']) echo "(이름)"; else echo "(별명)"; ?></option>
            <option value="me_recv_mb_id">받은(아이디)</option>
        <? } else if ($kind == "save" or $kind == "trash") { ?>
            <option value="me_send_mb_nick">받은<? if ($config['cf_memo_mb_name']) echo "(이름)"; else echo "(별명)"; ?></option>
            <option value="me_recv_mb_id">받은(아이디)</option>
            <option value="me_send_mb_nick">보낸<? if ($config['cf_memo_mb_name']) echo "(이름)"; else echo "(별명)"; ?></option>
            <option value="me_send_mb_id">보낸(아이디)</option>
        <? } ?>
        </select>
        <input name="stx" type="text" class="ed" style=" height:17px;" value='<?=$stx?>' maxlength=15 size="15" itemname="검색어" required />
        <input type=image src="<?=$memo_skin_path?>/img/search.gif" border=0 align=absmiddle>
    </td>
    </tr>
</table>
</form>

<form name="fboardlist" method="post" style="margin:0px;">
<input type=hidden name=kind value="<?=$kind?>">

<table class="tbl_type" width="100%" border="1" cellspacing="0">
    <colgroup> 
      <col width="35">
      <col width="20">
      <col width="110">
      <col width="">
      <col width="60">
      <col width="60">
    </colgroup> 
    <thead>
    <tr>
        <th>
        <!-- 공지쪽지함은 삭제 선택이 없게... -->
        <input name="chk_me_id_all" type="checkbox" onclick="if (this.checked) all_checked(true); else all_checked(false);" />
        </th>
        <th></th>
        <th><?=$list_title ?></th>
        <th>제 목</th>
        <th>보낸시간</th>
        <th>
        <? if ($kind == 'notice') {
            if ($is_admin=='super' || $member['mb_id']==$view['me_send_mb_id']) { ?>  
                수신레벨
            <? } ?>
        <? } else { ?>
            받은시간
        <? } ?>
        </th>
    </tr>
    </thead>

    <? for ($i=0; $i<count($list); $i++) { // 목록을 출력 합니다. ?>
    <tr>
        <td>
            <!-- 공지쪽지함은 삭제 선택이 없게... -->
            <? if ($kind != 'notice') { ?>
            <input name="chk_me_id[]" type="checkbox" value="<?=$list[$i][me_id]?>" />
            <? } ?>
        </td>
        <?
          if ($list[$i]['read_datetime'] == '읽지 않음' or $list[$i]['read_datetime'] == '수신 않음') {
              $style = "style='font-weight:bold;'";
        ?>
        <td><img src="<?=$memo_skin_path?>/img/check.gif" width="13" height="12" /></td>
        <?
        } else {
            $style = "";
        ?>
        <td><img src="<?=$memo_skin_path?>/img/nocheck.gif" width="12" height="10" /></td>
        <? } ?>
        <td><?=$list[$i]['name']?></td>
        <td align="left" <?=$style?> >&nbsp;<? if ($list[$i]['me_file']) { ?><img src="<?=$memo_skin_path?>/img/icon_file.gif" align=absmiddle>&nbsp;<? } ?><a href='<?=$list[$i]['view_href']?>&page=<?=$page?>&sfl=<?=$sfl?>&stx=<?=$stx?>&unread=<?=$unread?>' title='<?=$list[$i]['subject']?>'><?=cut_str($list[$i]['subject'],27)?></a></td>
        <td <?=$style?> ><?=$list[$i]['send_datetime']?></td>
        <?
        // 공지쪽지의 읽은 날짜는???
        if ($kind == 'notice') { 
            if ($is_admin=='super' || $member[mb_id]==$view[me_send_mb_id])
                $list[$i]['read_datetime'] = $list[$i]['me_recv_mb_id'];
            else 
                $list[$i]['read_datetime'] = "";
        }
        ?>
        <td <?=$style?> ><?=$list[$i]['read_datetime']?></td>
    </tr>
    <? } ?>
    <? if ($i==0) { ?>
    <tr>
        <td align=center height=100 colspan=6>자료가 없습니다.</td>
    </tr>
    <? } ?>
    <tfoot>
    <tr>
        <td colspan=6 align=left style="padding:2px 0 2px;">
          &nbsp;&nbsp;
          <? if ($i > 0 and $kind !='notice') { ?>
          <a href="javascript:select_delete();"><img src="<?=$memo_skin_path?>/img/bt02.gif" /></a>
          <? } ?>
          <? if ($i > 0 and $kind == "trash") { ?>
          <a href="javascript:all_delete_trash();"><img src="<?=$memo_skin_path?>/img/all_del.gif" align=absmiddle/></a>
          <? } ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <? 
        $page = get_paging($config['cf_write_pages'], $page, $total_page, "?&kind=$kind&sfl=$sfl&stx=$stx&unread=$unread&page="); 
        echo "$page";
        ?>
        </td>
    </tr>
    <?
    // 하단부에 내보내는 기본 정보사항
    $msg = "";
    if ($kind == "write") { // 쓰기 일때만 메시지를 출력 합니다.
        $msg .= "<li>여러명에게 쪽지 발송시 컴마(,)로 구분 합니다.";
        if ($config['cf_memo_use_file'] && $config['cf_memo_file_size']) {
            $msg .= "<li>첨부가능한 파일의 최대 용량은 " .$config['cf_memo_file_size'] . "M(메가) 입니다.";
        }
        if ($config['cf_memo_send_point']) 
            $msg .= "<li>쪽지 보낼때 회원당 ".number_format($config['cf_memo_send_point'])."점의 포인트를 차감합니다.";
    }
    if ($kind == "send") { // 보낸쪽지함 일때만 메시지를 출력 합니다.
        $msg .= "<li>읽지 않은 쪽지를 삭제하면, 발신이 취소(수신자 쪽지함에서 삭제) 됩니다.";
    }
    if ($kind == "send" || $kind == "recv") { // 보낸쪽지함 일때만 메시지를 출력 합니다.
        $msg .= "<li>보관안된 쪽지는 " . $config['cf_memo_del'] . "일 후 삭제되므로 중요한 쪽지는 보관하시기 바랍니다.";
    }
    if ($msg !== "")
        echo "<tr><td colspan=6 align=left><ul>$msg</ul></td></tr>";
    ?>
    </tfoot>
</table>
</form>

<?
// 구글 광고를 include
$ad_file = "$memo_skin_path/memo2_adsense.php";
if (file_exists($ad_file)) {
    include_once($ad_file);
}
?>

<script type="text/javascript">
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
}
</script>
