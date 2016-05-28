<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 스크랩 메모별로 정렬하기
$sql = " select distinct ms_memo from $g4[scrap_table] where mb_id = '$member[mb_id]' and ms_memo != '' ";
$result = sql_query($sql);
$memo_str = "<select name='ms_memo' onchange=\"javascript:document.getElementById('wr_content').value=this.value;\">";
$memo_str .= "<option value=''>내가 사용하는 참고메모 선택하기</option>";
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $memo_str .= "<option value='$row[ms_memo]'";
        $memo_str .= ">" . cut_str($row[ms_memo],60,'') . "</option>";
    }
    $memo_str .= "</select>";
?>

<table width="95%" height="50" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="center" valign="middle" bgcolor="#EBEBEB">
        <table width="98%" height="40" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td width="25" align="center" bgcolor="#FFFFFF" ><img src="<?=$member_skin_path?>/img/icon_01.gif" width="5" height="5"></td>
            <td width="75" align="left" bgcolor="#FFFFFF" ><font color="#666666"><b>스크랩하기</b></font></td>
            <td width="490" bgcolor="#FFFFFF" ></td>
        </tr>
        </table></td>
</tr>
</table>

<table width="95%" border="0" cellspacing="0" cellpadding="0">
<form name=f_scrap_popin method=post action="./scrap_popin_update.php">
<input type="hidden" name="bo_table" value="<?=$bo_table?>">
<input type="hidden" name="wr_id"    value="<?=$wr_id?>">
<input type="hidden" name="wr_mb_id" value="<?=$write[mb_id]?>">
<input type="hidden" name="wr_subject" value="<?=$write[wr_subject]?>">
<tr> 
    <td height="180" align="center" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
                <td height="20"></td>
            </tr>
            <tr> 
                <td height="2" bgcolor="#808080"></td>
            </tr>
            <tr> 
                <td height="2" align="center" valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                            <td width="80" height="27" align="center"><b>제목</b></td>
                            <td width="10" valign="bottom"><img src="<?=$member_skin_path?>/img/l.gif" width="1" height="8"></td>
                            <td width="450" style='word-break:break-all;'><?=get_text(cut_str($write[wr_subject], 255))?></td>
                        </tr>
                        <tr> 
                            <td height="1" colspan="3" bgcolor="#E9E9E9"></td>
                        </tr>
                        <tr> 
                            <td width="80" height="150" align="center"><b>참고메모</b></td>
                            <td width="10" valign="bottom"><img src="<?=$member_skin_path?>/img/l.gif" width="1" height="8"></td>
                            <td>
                            <?=$memo_str?>
                            <textarea name="wr_content" id="wr_content" rows="3" style="width:90%;"></textarea>
                            <br>* 참고메모는 스크랩을 분류 및 검색할 때 쓰는 키워드 입니다 (예: 스크랩).
                            <br>* 새로운 참고메모는 직접 입력해야 합니다.
                            <br>* 참고메모를 입력하지 않아도 되지만, 편한 사용을 위해서 입력하는게 좋습니다.
                            </td>
                        </tr>
                    </table></td>
            </tr>
        </table></td>
</tr>
<tr> 
    <td height="2" align="center" valign="top" bgcolor="#D5D5D5"></td>
</tr>
<tr>
    <td height="2" align="center" valign="top" bgcolor="#E6E6E6"></td>
</tr>
<tr>
    <td height="40" align="center" valign="bottom"><INPUT type=image width="40" height="20" src="<?=$member_skin_path?>/img/ok_btn.gif" border=0></td>
</tr>
</form>
</table>
