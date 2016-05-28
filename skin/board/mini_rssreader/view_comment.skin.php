<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

/////////////////////////////////////////////////////////////////////////////////////////////////
//////// 여분필드의 용도 ////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
// 여분필드 3번 : $board[bo_3] 값이 1일 경우 코멘트 창 열어놓기 (아닐경우엔 + 로 열기)
/////////////////////////////////////////////////////////////////////////////////////////////////

$pview_cmnt = $board[bo_3];

?>

<script language="JavaScript">
// 글자수 제한
var char_min = parseInt(<?=$comment_min?>); // 최소
var char_max = parseInt(<?=$comment_max?>); // 최대
</script>

<? if($pview_cmnt != "1") { ?>
<span id=cblockl2><a href="javascript:;" onclick="cclickshow(2)">+ <?if(count($list)){?> <span class=ct>(<?=count($list)?>)</span><?}?></a></span>
<span id=cblock2 style=display:none;cursor:hand;padding-left:0 height=0> 
<?}?>

<? if ($cwin==1) { ?><table width=100% cellpadding=10 align=center><tr><td><?}?>

<!-- 코멘트 리스트 -->
<?
for ($i=0; $i<count($list); $i++) {
    $comment_id = $list[$i][wr_id];
?>
<a name="c_<?=$comment_id?>"></a>
<table width=100% cellpadding=0 cellspacing=0>
<tr>
    <td><? for ($k=0; $k<strlen($list[$i][wr_comment_reply]); $k++) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; ?></td>
    <td width='100%'>
        <table width=100% cellpadding=0 cellspacing=0>
        <tr>
            <td><strong><?=$list[$i][name]?><? if ($is_ip_view) { echo "&nbsp;({$list[$i][ip]})"; } ?></strong></td>
            <td align=right>
                <? if ($list[$i][is_reply]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'c');\"><img src='$board_skin_path/img/btn_comment_reply.gif' border=0 align=absmiddle></a> "; } ?>
                <? if ($list[$i][is_edit]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'cu');\"><img src='$board_skin_path/img/btn_comment_update.gif' border=0 align=absmiddle></a> "; } ?>
                <? if ($list[$i][is_del])  { echo "<a href=\"javascript:comment_delete('{$list[$i][del_link]}');\"><img src='$board_skin_path/img/btn_comment_delete.gif' border=0 align=absmiddle></a> "; } ?>
                &nbsp;&nbsp;<?=$list[$i][datetime]?></td>
        </tr>
        <tr><td colspan=2><img src='<?=$board_skin_path?>/img/co_point.gif'></td></tr>
        <tr>                            
            <td  colspan=2 style='line-height:150%; padding:7px; word-break:break-all;'>
                <!-- 코멘트 출력 -->
                <span class="ct lh"><?=$list[$i][content]?></span>
                <? if ($list[$i][trackback]) { echo "<p>".$list[$i][trackback]."</p>"; } ?>
                <span id='edit_<?=$comment_id?>' style='display:none;'></span><!-- 수정 -->
                <span id='reply_<?=$comment_id?>' style='display:none;'></span><!-- 답변 -->
            </td>
        </tr>
        <tr><td colspan=2 height=20></td></tr>
        </table><textarea id='save_comment_<?=$comment_id?>' style='display:none;'><?=get_text($list[$i][wr_content], 0)?></textarea></td>
</tr>
</table>
<? } ?>
<!-- 코멘트 리스트 -->


<? if ($is_comment_write) { ?>
<!-- 코멘트 입력 -->
<table width=100% cellpadding=3 cellspacing=0><tr><td align=right><a href="javascript:comment_box('', 'c');"><img src='<?=$board_skin_path?>/img/btn_comment_insert.gif' border=0 align=absmiddle></a></td></tr></table>

<span id=comment_write style='display:none;'>
<form name="fviewcomment" method="post" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" autocomplete="off" style="margin:0px;">
<input type=hidden name=w           id=w value='c'>
<input type=hidden name=bo_table    value='<?=$bo_table?>'>
<input type=hidden name=wr_id       value='<?=$wr_id?>'>
<input type=hidden name=comment_id  id='comment_id' value=''>
<input type=hidden name=sfl         value='<?=$sfl?>' >
<input type=hidden name=stx         value='<?=$stx?>'>
<input type=hidden name=spt         value='<?=$spt?>'>
<input type=hidden name=page        value='<?=$page?>'>
<input type=hidden name=cwin        value='<?=$cwin?>'>
<table width=100% cellpadding=3 cellspacing=0>
<tr><td colspan=2>

    <? if ($is_guest) { ?>
        이름 <INPUT type=text maxLength=20 size=15 name="wr_name" itemname="이름" required class=ed>
        패스워드 <INPUT type=password maxLength=20 size=15 name="wr_password" itemname="패스워드" required class=ed>
            <? if ($is_norobot) { ?>
                <?=$norobot_str?>
                <INPUT title="왼쪽의 글자중 빨간글자만 순서대로 입력하세요." type="input" name="wr_key" itemname="자동등록방지" required class=ed>
            <?}?>
    <?}?>

    <span style="cursor: pointer;" onclick="textarea_decrease('wr_content', 10);"><img src="<?=$board_skin_path?>/img/up.gif"></span>
    <span style="cursor: pointer;" onclick="textarea_original('wr_content', 10);"><img src="<?=$board_skin_path?>/img/start.gif"></span>
    <span style="cursor: pointer;" onclick="textarea_increase('wr_content', 10);"><img src="<?=$board_skin_path?>/img/down.gif"></span>

    <? if ($comment_min || $comment_max) { ?><span id=char_count></span>글자<?}?></td></tr>
<tr>
    <td width="95%">
        <textarea id="wr_content" name="wr_content" rows="5" itemname="내용" required 
            <? if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?> style='width:100%; word-break:break-all;' class=tx></textarea>
            <? if ($comment_min || $comment_max) { ?><script language="javascript"> check_byte('wr_content', 'char_count'); </script><?}?></td>
    <td width=80 align=center><input type="image" src="<?=$board_skin_path?>/img/ok_btn.gif" border=0 accesskey='s'></td></tr>
</table>
</form>
</span>

<script language='JavaScript'>
var save_before = '';
var save_html = document.getElementById('comment_write').innerHTML;
function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    var s;
    if (s = word_filter_check(document.getElementById('wr_content').value))
    {
        alert("내용에 금지단어('"+s+"')가 포함되어있습니다");
        document.getElementById('wr_content').focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("코멘트는 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("코멘트는 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("코멘트를 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('패스워드가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    if (typeof(f.wr_key) != 'undefined')
    {
        if (hex_md5(f.wr_key.value) != md5_norobot_key)
        {
            alert('자동등록방지용 빨간글자가 순서대로 입력되지 않았습니다.');
            f.wr_key.focus();
            return false;
        }
    }

    return true;
}

function comment_box(comment_id, work)
{
    var el_id;
    // 코멘트 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'comment_write';

    if (save_before != el_id)
    {
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
            document.getElementById(save_before).innerHTML = '';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).innerHTML = save_html;
        // 코멘트 수정
        if (work == 'cu')
        {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        save_before = el_id;
    }
}

function comment_delete(url)
{
    if (confirm("이 코멘트를 삭제하시겠습니까?")) location.href = url;
}

comment_box('', 'c'); // 코멘트 입력폼이 보이도록 처리하기위해서 추가 (root님)
</script>
<? } ?>

<? if($cwin==1) { ?></td><tr></table><p align=center><a href="javascript:window.close();"><img src="<?=$board_skin_path?>/img/btn_close.gif" border="0"></a><br><br><?}?>

<? if($pview_cmnt != "1") { ?>
</span>
<?}?>