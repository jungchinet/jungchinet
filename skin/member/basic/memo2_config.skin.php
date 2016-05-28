<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align=left>&nbsp;<img src="<?=$memo_skin_path?>/img/btn_c_ok.gif" align=absmiddle />
  &nbsp;<b><?=$memo_title?> - 쪽지설정</b></td>
</tr>
</table>

<form name='fmemoform' method='post' enctype='multipart/form-data' onsubmit="return fmemoconfig_submit(document.fmemoform);">

<div class="section">
    <h2 class="hx">개인설정</h2>
    <div class="tx">
    <? if ($config[cf_memo_user_config]) { ?>
  			<table width="100%" border="0" cellspacing="0" cellpadding="2">
        <colgroup> 
        <col width="150">
        <col width="">
        </colgroup> 
        <? if ($config[cf_memo_realtime]) { ?>
        <tr>
          <td>실시간 쪽지</td>
          <td><input type=checkbox name=mb_realmemo value='1' <?=($member[mb_realmemo])?'checked':'';?>>실시간쪽지 사용</td>
        </tr>
        <tr>
          <td>음성 알림</td>
          <td><input type=checkbox name=mb_realmemo_sound value='1' <?=($member[mb_realmemo_sound])?'checked':'';?>>음성알림사용(실시간쪽지 사용시에만 동작함)</td>
        </tr>
        <? } ?>

        <?
        $time_diff = ($g4[server_time] - (86400 * $config['cf_memo_no_reply'])) - strtotime($member[mb_memo_no_reply_datetime]);
        if ($config['cf_memo_no_reply'] && $time_diff > 0) {
        ?>
        <input type=hidden name=mb_memo_no_reply_org value="<?=$member[mb_memo_no_reply]?>">
        <tr>
            <td>부재중설정</td>
            <td><input type=checkbox name=mb_memo_no_reply value='1' <?=($member[mb_memo_no_reply])?'checked':'';?>>수신된 쪽지에 자동으로 부재중 응답을 보냅니다.<BR>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
            <b>부재중설정 정보를 수정하면 <font color="red"><?=$config['cf_memo_no_reply']?> 일</font> 후에 변경이 가능</b>
            </td>
        </tr>
        <tr>
            <?
            if (!$member['mb_memo_no_reply_text'])
                $member['mb_memo_no_reply_text'] = "지금은 개인적인 사정으로 부재중 입니다. 보내주신 쪽지는 접속이 가능한 시점에 확인후 답을 드리겠습니다";
            ?>
            <td>부재중알림메모</td>
            <td><textarea class=ed name='mb_memo_no_reply_text' rows=5 style='width:98%;'><?=stripslashes($member[mb_memo_no_reply_text])?></textarea>
        </tr>
        <? } ?>

        </table>
    <? } else { ?>
        설정할 항목이 없습니다.
    <? } ?>
    </div>
</div>

<? if ($is_admin == 'super') { ?>
<? include_once("$g4[admin_path]/admin.lib.php")?>
<div class="section" style="margin-top:5px">
    <h2 class="hx">시스템설정</h2>
    <div class="tx">
  			<table width="100%" border="0" cellspacing="0" cellpadding="2">
        <colgroup> 
        <col width="150">
        <col width="">
        </colgroup> 
        <tr>
            <td>페이지당 목록수</td>
            <td><input type=text required class=ed name='cf_memo_page_rows' size='5' required itemname='페이지당 목록' value='<?=$config[cf_memo_page_rows]?>'>
            </td>
        </tr>
        <tr>
            <td>쪽지보낼시 차감 포인트</td>
            <td><input type=text required class=ed name='cf_memo_send_point' size='5' required itemname='쪽지전송시 차감 포인트' value='<?=$config[cf_memo_send_point]?>'> 점
            <!-- <BR>(양수로 입력하십시오. 0으로 입력하시면 쪽지보낼시 포인트를 차감하지 않습니다.) -->
            </td>
        </tr>
        <tr>
            <td>쪽지 삭제</td>
            <td><input type=text class=ed name='cf_memo_del' value='<?=$config[cf_memo_del]?>' size=5 required > 일 (설정일이 지난 쪽지 자동 삭제)
            </td>
        </tr>
        <tr>
            <td>안읽은 쪽지 삭제</td>
            <td><input type=text class=ed name='cf_memo_del_unread' value='<?=$config[cf_memo_del_unread]?>' size=5 required > 일 (쪽지 삭제일보다 크거나 같게)
            </td>
        </tr>
        <tr>
            <td>휴지통 보관일수</td>
            <td><input type=text class=ed name='cf_memo_del_trash' value='<?=$config[cf_memo_del_trash]?>' size=5 required > 일 (설정일이 지난 쪽지는 휴지통에서 삭제)
            </td>
        </tr>
        <tr>
            <td>dhtml 에디터</td>
            <td><input type=checkbox name=cf_memo_user_dhtml value='1' <?=($config[cf_memo_user_dhtml])?'checked':'';?>>dhtml 에디터 사용
            </td>
        </tr>
        <tr>
            <td width="150">쪽지프린트</td>
            <td><input type=checkbox name=cf_memo_print value='1' <?=($config[cf_memo_print])?'checked':'';?>> 사용
            </td>
        </tr>
        <tr>
            <td>이전/이후 쪽지보기</td>
            <td><input type=checkbox name=cf_memo_before_after value='1' <?=($config[cf_memo_before_after])?'checked':'';?>> 사용
            </td>
        </tr>
        <tr>
            <td>첨부파일</td>
            <td><input type=checkbox name=cf_memo_use_file value='1' <?=($config[cf_memo_use_file])?'checked':'';?>>첨부파일 기능사용
            </td>
        </tr>
        <tr>
            <td>최대첨부파일용량</td>
            <td><input type=text class=ed name='cf_memo_file_size' value='<?=$config[cf_memo_file_size]?>' size=5 required > M(메가) (계정최대용량 : <?=ini_get("upload_max_filesize")?>, 입력예: 2, 4, 8)
            </td>
        </tr>
        <tr>
            <td>개인별첨부파일 최대한도</td>
            <td><input type=text class=ed name='cf_max_memo_file_size' value='<?=$config[cf_max_memo_file_size]?>' size=5 required > M(메가) (입력예, 0:제한없슴, 50, 100 )
            </td>
        </tr>
        <!--
        <tr>
            <td>쪽지삭제시 첨부파일삭제</td>
            <td><input type=checkbox name=cf_memo_del_file value='1' <?=($config[cf_memo_del_file])?'checked':'';?>>첨부파일을 서버에서 삭제하는 기능사용
            </td>
        </tr>
        -->
  			<tr>
            <td>실시간쪽지</td>
            <td>
            <input type=checkbox name=cf_memo_realtime value='1' <?=($config[cf_memo_realtime])?'checked':'';?>> 실시간쪽지 기능을 사용
            </td>
        </tr>
        <tr>
            <td>친구관리</td>
            <td><input type=checkbox name=cf_friend_management value='1' <?=($config[cf_friend_management])?'checked':'';?>>친구관리 기능사용
            </td>
        </tr>
        <tr>
            <td>부재중설정 변경일자</td>
            <td><?=get_member_level_select(cf_memo_no_reply, 0, 7, $config[cf_memo_no_reply])?> 일 (0 으로 설정하면 부재중설정을 사용하지 않음)
            </td>
        </tr>
        <tr>
            <td>공지메모</td>
            <td><textarea class=ed name='cf_memo_notice_memo' rows=3 style='width:98%;'><?=$config[cf_memo_notice_memo]?></textarea>
            </td>
        </tr>
  			<tr>
            <td>불당resize/불당썸</td>
            <td>
            <input type=checkbox name=cf_memo_b4_resize value='1' <?=($config[cf_memo_b4_resize])?'checked':'';?>> 불당resize/불당썸 기능을 사용
            </td>
        </tr>
   			<tr>
            <td>이름을 기본으로 사용</td>
            <td>
            <input type=checkbox name=cf_memo_mb_name value='1' <?=($config[cf_memo_mb_name])?'checked':'';?>> 목록등에서 이름을 기본으로 사용
            </td>
        </tr>
  			<tr>
            <td>DB에 없는 첨부파일 삭제</td>
            <td>
	          <a href="#" onclick="tmpFileChk();">삭제하기</a>
            </td>
        </tr>
    </div>
</div>
<? } ?>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="center">
    <input id=btn_submit type=image src="<?=$memo_skin_path?>/img/send2.gif" border=0 alt="보내기" align='absmiddle'>
    </td>
</tr>
</table>

</form>
      
<script type="text/javascript">
function fmemoconfig_submit(f) {
    f.action = "./memo2_config_update.php";
    return true;
}

function tmpFileChk(){
	if(confirm('쪽지 DB에 없는 첨부파일을 삭제합니까?')){
		location.href="./memo2_chkunlinkfile.php";
	}
}
</script>
