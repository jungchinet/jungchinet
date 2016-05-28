<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" id="memo_contents">
<tr>
    <td align=left>
    &nbsp;<img src="<?=$memo_skin_path?>/img/memo_icon02.gif" align=absmiddle /> <b>쪽지보내기 <?=$write_header_msg?></b>
    </td>
</tr>
</table>

<form name=fmemoform method=post enctype='multipart/form-data' onsubmit="return fmemoform_submit(this);" style="margin:0px;">
<input type=hidden name=me_send_mb_id value="<?=$member[mb_id]?>">
<table class="tbl_type" width="99%" border="0" cellspacing="0" cellpadding="0">
    <colgroup> 
      <col width="80">
      <col width="">
    </colgroup> 
    <thead>
    <tr>
        <th>받는 사람</th>
        <th align=left>
            <? $ss_id = 'me_recv_mb_id' ?>
            <? if ($option == 'notice') { // 공지쪽지인 경우 ?>
                <? include_once("$g4[admin_path]/admin.lib.php")?>
                <input type="hidden" name="<?=$ss_id?>" id="<?=$ss_id?>" required="required" itemname="받는 회원아이디" value="<?=$me_recv_mb_id?>" style="width:200px;" />
                &nbsp;회원레벨
                <?=get_member_level_select('notice_level_1', 2, 10, 2) ?> - <?=get_member_level_select('notice_level_2', 2, 10, 10) ?>
            <? } else { ?>
                &nbsp;<input type="text" name="<?=$ss_id?>" id="<?=$ss_id?>" required="required" itemname="받는 회원아이디" value="<?=$me_recv_mb_id?>" style="width:180px;" />
                <? if (count($my_friend) > 0) { ?>
                <select class=quick_move onchange="friend_add(this.value)" >
                <option value="">나의 친구들</option>
                <option value="">-------------------------</option>
                <? for ($i=0; $i<count($my_friend); $i++) {?>
                    <option value="<?=$my_friend[$i][fr_id]?>"><?=$my_friend[$i][fr_id]?>-<?=cut_str($my_friend[$i][mb_nick],10)?></option>
                <? } ?>
                </select>
                <? } ?>
                <a href="javascript:popup_id('fmemoform','<?=$ss_id?>',200,500);">회원검색</a>
            <? } ?>
        </th>
    </tr>
    </thead>
    <tr>
        <td>제&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;목</td>
        <td align=left>
        &nbsp;<input type="text" name="me_subject" id="me_subject" required="required" style="width:90%; text-align:left;" / value='<?=$subject?>' >
        </td>
    </tr>
    <tr>
        <td>내&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;용</td>
        <td align=left valign=top>
            <? if ($is_dhtml_editor) { ?>
                <input type=hidden value="html1" name="html">
                <?
                // cheditor를 쓰기 위한 설정
                include_once("$g4[path]/lib/cheditor4.lib.php");
                echo "<script type='text/javascript' src='$g4[cheditor4_path]/cheditor.js'></script>";
                echo cheditor1('me_memo', '100%', '300px');
                // cheditor 편집기 메뉴의 일부를 disable
                ?>
                <script type='text/javascript'>
                ed_me_memo.config.usePreview = false;
                ed_me_memo.config.NewDocument = false;
                ed_me_memo.config.usePasteFromWord = false;
                ed_me_memo.config.useOrderedList = false;
                ed_me_memo.config.useUnOrderedList = false;
                ed_me_memo.config.useOrderedList = false;
                ed_me_memo.config.useUnOrderedList = false;
                ed_me_memo.config.useOutdent = false;
                ed_me_memo.config.useIndent = false;
                ed_me_memo.config.useJustifyRight = false;
                ed_me_memo.config.useJustifyFull = false;

                ed_me_memo.config.useLink = false;
                ed_me_memo.config.useUnLink = false;
                ed_me_memo.config.useFlash = false;
                ed_me_memo.config.useMedia = false;
                ed_me_memo.config.useImageUrl = false;
                </script>
                <?
                echo cheditor2('me_memo', $content);
            } else { ?>
                <textarea name='me_memo' id='me_memo' rows=15 style='width:100%;' required itemname='내용' tabindex=1><?=$content?></textarea>
            <? } ?>
        </td>
    </tr>

    <!-- 파일첨부하기-->
    <? if ($config['cf_memo_use_file']) { ?>
    <tr>
        <td>파일첨부</td>
        <td align=left>&nbsp;
            <? if ($memo_dir_msg) {
                echo $memo_dir_msg;
            } else { ?>
                <style> 
                #file_box { 
                    position:relative ; 
                    display:inline-block ; 
                    width:73px ; height:22px 
                } 
                #file_box2 { 
                    position:absolute ; 
                    bottom:0 ; right:0 ; 
                    display:inline-block ; 
                    width:73px ; height:22px ; 
                    overflow:hidden 
                } 
                #file { 
                    position:absolute ; 
                    bottom:0 ; right:0 ; 
                    height:53px ; 
                    //font-size:224px ; 
                    opacity:0 ; filter:alpha(opacity=0) 
                } 
                </style> 
                <script type="text/javascript"> 
                function file_change(file) { 
                    document.getElementById("file_name").value = file; 
                }
                </script> 

                <input type="text" id="file_name" name="memo_file_show" style="width:280;direction:rtl;" /> 
                <span id="file_box"> 
                    <img align="absmiddle" src="<?=$memo_skin_path?>/img/file.gif" alt="Browse..." border="0" style="margin-bottom:3;" /> 
                    <span id="file_box2"> 
                        <input type="file" id="file" name='memo_file' onchange="file_change(this.value)" size="50" /> 
                    </span> 
                </span> 
            <? } ?>
        </td>
    </tr>
    <? } ?>

    <tfoot>
    <tr>
        <td colspan=2>
            <input id=btn_submit type=image src="<?=$memo_skin_path?>/img/send.gif" border=0 alt="보내기" align='absmiddle' >
            <a href='<?=$memo_url?>?kind=recv'><img align="absmiddle" src="<?=$memo_skin_path?>/img/list.gif" /></a>
        </td>
    </tr>
    </tfoot>
</table>
</form>

<script type="text/javascript">

<? if ($option != 'notice') { ?>

with (document.fmemoform) {
    if (me_recv_mb_id.value == "")
        me_recv_mb_id.focus();
    else
        me_subject.focus();
}       
<? } ?>

function fmemoform_submit(f) {
    var s = "";

    <?
    if ($is_dhtml_editor) {
        echo cheditor3('me_memo');
        echo "if (!document.getElementById('tx_me_memo').value) { alert('내용을 입력하십시오.'); return; } ";
    }
    ?>

    document.getElementById('btn_submit').disabled = true;
    
    <? if ($option == 'notice') {?>
        f.action = "./memo2_form_notice_update.php";
    <? } else { ?>
        f.action = "./memo2_form_update.php";
    <? } ?>

    return true;
}

function friend_add(fr_id)
{
  if (fr_id == "") // fr_id 값이 없으면 return
    return;
    
  if (document.fmemoform.<?=$ss_id?>.value.length > 0) {
    document.fmemoform.<?=$ss_id?>.value = document.fmemoform.<?=$ss_id?>.value + "," + fr_id;
  } else {
    document.fmemoform.<?=$ss_id?>.value = fr_id;
  }
}
</script>
