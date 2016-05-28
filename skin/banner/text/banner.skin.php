<?
if (!defined('_GNUBOARD_')) exit;

if (count($list)) { 

    $bg_id = $list[0][bg_id];
    $bn_id = $list[0][bn_id];
    $bn_text = $list[0][bn_text];
    $bg_width = $list[0][bg_width];
    $bg_height = $list[0][bg_height];
?>
    <table width=<?=$bg_width?> height=<?=bg_height?> >
    <tr align=left><td>
    <?=$bn_text?>
    </td></tr>
    </table>

<? } ?>
