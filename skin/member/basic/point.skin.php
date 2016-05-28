<table width="600" height="50" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="center" valign="middle" bgcolor="#EBEBEB"><table width="590" height="40" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td width="25" align="center" bgcolor="#FFFFFF" ><img src="<?=$g4[bbs_img_path]?>/icon_01.gif" width="5" height="5"></td>
            <td width="" align="left" bgcolor="#FFFFFF" ><font color="#666666"><b><?=$g4[title]?></b></font></td>
            <td bgcolor="#FFFFFF" ><?=$bo_str?>&nbsp;</td>
        </tr>
        </table></td>
</tr>
</table>

<table width="600" border="0" cellspacing="0" cellpadding="0">
<tr> 
    <td height="200" align="center" valign="top"><table width="540" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td height="20"></td>
        </tr>
        <tr> 
            <td height="2" bgcolor="#808080"></td>
        </tr>
        <tr> 
            <td width="540" bgcolor="#FFFFFF">
                <table width=100% cellpadding=1 cellspacing=1 border=0>
                <tr bgcolor=#E1E1E1 align=center> 
                    <td width="130" height="24"><b>일시</b></td>
                    <td width=""><b>내용</b></td>
                    <td width="70"><b>지급포인트</b></td>
                    <td width="70"><b>사용포인트</b></td>
                </tr>

                <?
                $sum_point1 = $sum_point2 = 0;

                $point_count = count($point_list);
                for ($i=0; $i < $point_count; $i++) {
                    $point1 = $point2 = 0;
                    if ($point_list[$i][po_point] > 0) {
                        $point1 = "+" . number_format($point_list[$i][po_point]);
                        $sum_point1 += $point_list[$i][po_point];
                    } else {
                        $point2 = number_format($point_list[$i][po_point]);
                        $sum_point2 += $point_list[$i][po_point];
                    }
                ?>
                    <tr height=25 bgcolor="#F6F6F6" align="center"> 
                        <td height="24"><?=$point_list[$i][po_datetime]?></td>
                        <td align="left" title='<?=$point_list[$i][po_content]?>'>
                        <nobr style='display:block; overflow:hidden; width:250px;'>&nbsp;
                        <?
                        if ($point_list[$i][po_url])
                            echo "<a href='{$point_list[$i][po_url]}' target=_new>" . $point_list[$i][po_content] . "</a>";
                        else
                           echo $point_list[$i][po_content];
                        ?>
                        </td>
                        <td align=right><?=$point1?>&nbsp;</td>
                        <td align=right><?=$point2?>&nbsp;</td>
                    </tr>
                <?
                }

                if ($i == 0)
                    echo "<tr><td colspan=5 align=center height=100>자료가 없습니다.</td></tr>";
                else {
                    if ($sum_point1 > 0)
                        $sum_point1 = "+" . number_format($sum_point1);
                    $sum_point2 = number_format($sum_point2);
                    echo <<<HEREDOC
                    <tr height=25 bgcolor="#E1E1E1" align="center"> 
                        <td height="24" colspan=2 align=center>소계</td>
                        <td align=right>{$sum_point1}&nbsp;</td>
                        <td align=right>{$sum_point2}&nbsp;</td>
                    </tr>
HEREDOC;
                }
                ?>
                </table></td>
        </tr>
        </table></td>
</tr>
<tr> 
    <td height="30" align="center"><?=get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");?></td>
</tr>
<tr>
    <td height="30" align="center" bgcolor="#F6F6F6">
        <img src='<?=$g4[bbs_img_path]?>/icon_02.gif'> 보유 포인트 : <B><?=number_format($member[mb_point])?> 점</B></td>
</tr>
<tr> 
    <td height="2" align="center" valign="top" bgcolor="#D5D5D5"></td>
</tr>
<tr>
    <td height="2" align="center" valign="top" bgcolor="#E6E6E6"></td>
</tr>
<tr>
    <td height="40" align="center" valign="bottom"><a href="javascript:window.close();"><img src="<?=$g4[bbs_img_path]?>/close.gif" width="66" height="20" border="0"></a></td>
</tr>
</table>
<br>
