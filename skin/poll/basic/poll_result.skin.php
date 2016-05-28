<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<link rel="stylesheet" href="<?=$poll_skin_path?>/style.css" type="text/css">

<div class="section">
  	<h2 class="hx"><?=$po_subject?></h2>
  	<? 
  	if ($po[po_summary])
	      echo "<div class='tx'>$po[po_summary]</div>";
  	?>
</div>

<table><tr height=1px><td></td></tr></table>

<table class="tbl_type" border="1" cellspacing="0"  width="100%">
<colgroup>
<col>
<col width="170">
<col width="130">
</colgroup>
<tbody>
    <tr>
    <td colspan="2"><?=$po[po_date]?>~<?=$po[po_end_date]?></td>
    <th scope="row"><?=$nf_total_po_cnt?>표</th>
    </tr>
    <? for ($i=1; $i<=count($list); $i++) { ?>
    <tr>
    <th scope="row"><?=$list[$i][num]?>.<?=$list[$i][content]?></th>
    <td><span class="i_graph"><span class="g_bar"><span style="width:<?=$list[$i][rate]?>%;" class="g_action"></span></span></span></td>
    <th scope="row"><?=$list[$i][cnt]?>표 (<?=number_format($list[$i][rate], 1)?>%)</th>
    </tr>
    <? } ?>
</table>

<table><tr height=1px><td></td></tr></table>

<? if ($is_etc) { ?>
<? if ($member[mb_level] >= $po[po_etc_level]) { ?>
<div class="section">
  	<h2 class="hx"><?=$po_etc?>
  	</h2>
    <div class='tx'>
        <form name="fpollresult" method="post" onsubmit="return fpollresult_submit(this);" autocomplete="off" style="margin:0px;">
        <input type=hidden name=po_id value="<?=$po_id?>">
        <input type=hidden name=w value="">
        <input type='text' name='pc_idea' class=input required itemname='의견' maxlength="100" size=85> &nbsp;

        <? if (!$member[mb_id] && $config[cf_use_norobot]) { ?>
        <table width=100% bgcolor=#D4D4D4 cellpadding=1 cellspacing=0>
            <tr> 
                <td>
                    이름 <input type='text' name='pc_name' size=20 class=input required itemname='이름'> &nbsp;
                    패스워드 <INPUT type=password maxLength=20 size=10 name="pc_password" itemname="패스워드" required class=ed>
                </td>
            </tr>
            <tr> 
                <td align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <script type="text/javascript" src="<?="$g4[path]/zmSpamFree/zmspamfree.js"?>"></script>
                <img id="zsfImg">
                &nbsp;&nbsp;
                <input class='ed' type=input size=10 name=wr_key id=wr_key itemname="자동등록방지" required >&nbsp;&nbsp;왼쪽의 글자를 입력하세요.
                </td>
            </tr>
        </table>
        <? } ?>
 
        <input name="image" type=image src='<?=$g4[bbs_img_path]?>/ok_btn.gif' align=absmiddle border=0></td>
        </form>
    </div>
</div>
<? } ?>

<? if (count($list2) > 0) { ?>
<table><tr height=1px><td></td></tr></table>
<table class="tbl_type" border="1" cellspacing="0"  width="100%">
<colgroup>
<col>
<col width="100px">
<col width="80px">
</colgroup>
<tbody>
<? for ($i=0; $i<count($list2); $i++) { ?>
<tr>
    <td><? if ($list2[$i][del]) { echo $list2[$i][del] . "<img src='$g4[bbs_img_path]/btn_comment_delete.gif' width=45 height=14 border=0></a>"; } ?>
    <?=$list2[$i][idea]?>
    </td>
    <td align=center><?=$list2[$i][name]?></td>
    <td><?=get_datetime($list2[$i][datetime])?></td>
</tr>
<? } ?>
</table>
<? } ?>

<? } ?>

<table><tr height=3px><td></td></tr></table>
<div class="section">
  	<h2 class="hx">다른 투표결과 보기</h2>
    <div class='tx'>
        <form name=fpolletc>
            <img src="<?=$g4[bbs_img_path]?>/icon_1.gif" width="15" height="8">
            <select name=po_id onchange="select_po_id(this)"><? for ($i=0; $i<count($list3); $i++) { ?><option value='<?=$list3[$i][po_id]?>'>[<?=$list3[$i][date]?>] <?=$list3[$i][subject]?><? } ?></select><script>document.fpolletc.po_id.value='<?=$po_id?>';</script>
        </form>
    </div>
</div>

<script language="JavaScript">
function fpollresult_submit(f)
{
    if (typeof(f.wr_key) != 'undefined') {
        if (!checkFrm()) {
            alert ("스팸방지코드(Captcha Code)가 틀렸습니다. 다시 입력해 주세요.");
            return false;
        }
    }

    f.action = "./poll_etc_update.php";
    return true;
}
</script>
        
<script language='JavaScript'>
function select_po_id(fld) 
{
    document.location.href = "./poll_result.php?po_id="+fld.options[fld.selectedIndex].value;
}
</script>
