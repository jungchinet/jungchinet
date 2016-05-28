<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style='border-width:1; border-color:#DDDDDD; border-style:solid;'><tr><td>
<tr>
    <td colspan=3 height="5"></td>
</tr>
<? if (count($list) == 0) { ?>
    <tr><td colspan=3 align=center height=30>내용 없음</td></tr>
<? } else { ?>
<? for ($i=0; $i<count($list); $i++) { 
    if ($list[$i][ca_name] !== $member[mb_id])
        ;
    {
?>

<tr> 
    <td nowrap width="15" height="18" align="center" valign="middle" background="<?=$latest_skin_path?>/img/bg_line.gif"></td>
    <td nowrap background="<?=$latest_skin_path?>/img/bg_line.gif" style='word-break:break-all;'>  
        <?

        if ($list[$i][bo_name])
            $list_title = $list[$i][bo_name] . " : " . $list[$i][subject] . " (". $list[$i][datetime] . ")" ;
        else
            $list_title = $list[$i][subject]  . " (". $list[$i][datetime] . ")" ;
        
        echo $list[$i][icon_reply] . " ";
        echo "<a href='{$list[$i][href]}' onfocus='this.blur()' title='{$list_title}' {$target_link}>";
        if ($list[$i][is_notice])
            echo "<font style='font-family:돋움; font-size:9pt; color:#2C88B9;'><strong>" . $list[$i][subject] . "</strong></font>";
        else
            echo "<font style='font-family:돋움; font-size:9pt; color:#6A6A6A;'>" . $list[$i][subject] . "</font>";
        echo "</a>";

        if ($list[$i][comment_cnt]) 
            echo " <a href=\"{$list[$i][comment_href]}\" onfocus=\"this.blur()\"><span style='font-family:돋움; font-size:8pt; color:#9A9A9A;'>{$list[$i][comment_cnt]}</span></a> ";

        ?>
    </td>
</tr>
<? } ?>
<? } ?>
<? } ?>
</table>
