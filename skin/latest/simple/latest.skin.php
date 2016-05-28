<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if (!$skin_title) {
    $skin_title = $board[bo_subject];
    $skin_title_link = "$g4[bbs_path]/board.php?bo_table=$bo_table";
}
?>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style='border:solid 1px #ddd;'><tr><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr bgcolor="#F9F9F9"> 
    <td height="20" width=10px></td>
    <td bgcolor="#F9F9F9">&nbsp;<a href='<?=$skin_title_link?>' onfocus='this.blur()'><font style='font-family:돋움; font-size:9pt; color:#696969;'><strong><?=$skin_title?></strong></font></a>&nbsp;</td>
    <td align="right" bgcolor="#F9F9F9" width=37px><a href='<?=$skin_title_link?>' onfocus='this.blur()'><img src="<?=$latest_skin_path?>/img/more.gif" width="37" height="15" border="0" alt='more'></a></td>
    <td bgcolor="#F9F9F9" width=10px></td>
</tr>
<tr bgcolor="#DDDDDD"><td colspan=4 height="1"></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan=2 height="5"></td>
</tr>
<? if (count($list) == 0) { ?>
    <tr><td colspan=2 align=center height=30>내용 없음</td></tr>
<? } else { ?>
<? for ($i=0; $i<count($list); $i++) { 
    if ($list[$i][ca_name] !== $member[mb_id])
        ;
    {
?>

<tr> 
    <td width="15" height="18" align="center" valign="middle" background="<?=$latest_skin_path?>/img/bg_line.gif"></td>
    <td align="left" background="<?=$latest_skin_path?>/img/bg_line.gif" style='word-break:break-all;'><nowarp><nobr style="display:block; overflow:hidden;">
        <?
        if ($list[$i][icon_secret])
            echo "<img src='$latest_skin_path/img/icon_secret.gif' alt='secret' align=absmiddle> ";

        if ($list[$i][bo_name])
            $list_title = $list[$i][bo_name] . " : " . $list[$i][subject] . " (". $list[$i][datetime] . ")" ;
        else
            $list_title = $list[$i][subject]  . " (". $list[$i][datetime] . ")" ;
        
        if ($list[$i][comment_cnt]) 
            echo " <a href=\"{$list[$i][comment_href]}\" onfocus=\"this.blur()\"><span style='font-family:돋움; font-size:8pt; color:#9A9A9A;'>{$list[$i][comment_cnt]}</span></a> ";

        echo $list[$i][icon_reply] . " ";
        echo "<a href='{$list[$i][href]}' onfocus='this.blur()' title='{$list_title}' {$target_link}>";
        if ($list[$i][is_notice])
            echo "<font style='font-family:돋움; font-size:9pt; color:#2C88B9;'><strong>" . $list[$i][subject] . "</strong></font>";
        else
            echo "<font style='font-family:돋움; font-size:9pt; color:#6A6A6A;'>" . $list[$i][subject] . "</font>";
        echo "</a>";

        echo " " . $list[$i][icon_new];
        ?>
    </nobr></nowrap>
    </td>
</tr>
<? } ?>
<? } ?>
<? } ?>
</table>
</td></tr></table>
