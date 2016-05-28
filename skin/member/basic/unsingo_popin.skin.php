<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<table width="600" height="50" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="center" valign="middle" bgcolor="#EBEBEB">
        <table width="590" height="40" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td width="25" align="center" bgcolor="#FFFFFF" ><img src="<?=$member_skin_path?>/img/icon_01.gif" width="5" height="5"></td>
            <td width="75" align="left" bgcolor="#FFFFFF" ><font color="#666666"><b>신고해제하기</b></font></td>
            <td width="490" bgcolor="#FFFFFF" ></td>
        </tr>
        </table></td>
</tr>
</table>

<form name="fsingo" method="post" action="unsingo_popin_update.php" style="margin:0px;">
<input type="hidden" name="bo_table"    value="<?=$bo_table?>">
<input type="hidden" name="wr_id"       value="<?=$wr_id?>">
<input type="hidden" name="wr_parent"   value="<?=$wr_parent?>">
<table width="600" border="0" cellspacing="0" cellpadding="0">
<tr> 
    <td height="120" align="center" valign="top">
        <table width="540" border="0" cellspacing="0" cellpadding="0">
            <tr> 
                <td height="20"></td>
            </tr>
            <tr> 
                <td height="2" bgcolor="#808080"></td>
            </tr>
            <tr> 
                <td width="540" height="2" align="center" valign="top" bgcolor="#FFFFFF"><table width="540" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                            <td width="80" height="27" align="center"><b>제목</b></td>
                            <td width="10" valign="bottom"><img src="<?=$member_skin_path?>/img/l.gif" width="1" height="8"></td>
                            <td width="450" style='word-break:break-all;'><?=get_text(cut_str($wr_subject, 255))?></td>
                        </tr>
                        <tr> 
                            <td height="1" colspan="3" bgcolor="#E9E9E9"></td>
                        </tr>
                        <tr>
                            <td height="27" align="center" rowspan=3><b>신고해제이유</b></td>
                            <td valign="bottom">&nbsp;</td>
                            <td ></td>
                        </tr>
                        <tr> 
                            <td valign="bottom">&nbsp;</td>
                            <td style="padding:5px 0 5px 0;">
                                <input type=text name="unsg_reason" style="width:95%;" required itemname='신고해제이유'>
                            </td>
                        </tr>
                        <tr> 
                            <td valign="bottom">&nbsp;</td>
                            <td style="padding:5px 0 5px 0;">
                                <span class='stress'>
                                신고가 사유가 부당하다고 판단되는 경우 신고해제를 할 수 있습니다.<br>
                                신고를 해제하게 된 이유를 자세히 써주시면 운영자의 관련 결정에 도움이 됩니다.<br>
                                <? if ($config[cf_singo_point_send]) { ?>
                                <BR>신고해제를 신청하는 회원은 <?=$config[cf_singo_point_send]?> 포인트가 차감됩니다.
                                <? } ?>
                                </span>
                            </td>
                        </tr>
                        <tr> 
                            <td height="1" colspan="3" bgcolor="#E9E9E9"></td>
                        </tr>
                    </table></td>
            </tr>
        </table></td>
</tr>
<tr>
    <td height="30" align="center" valign="bottom"><INPUT type=image width="40" height="20" src="<?=$member_skin_path?>/img/ok_btn.gif" border=0></td>
</tr>
</table>
</form>


<script>
// 입력폼에 맞게 창 크기를 조절
top.window.resizeTo(608, 400);
document.fsingo.unsg_reason.focus();
</script>
