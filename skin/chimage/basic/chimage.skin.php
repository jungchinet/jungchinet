<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/lib/thumb.lib.php");
?>

<ul style="list-style:none;">
<? for ($i=0; $i<count($list); $i++) { ?>

    <?
    $img_path = $list[$i][image_path];
    $img_width = $list[$i][bc_width];
    $img_height = $list[$i][bc_height];

    $thumb_img = thumbnail("$img_path",100,50);
    ?>
    <li style="float:left;cursor:pointer"><img src="<?=$thumb_img?>" onclick="image_window3('<?=$img_path?>',<?=$img_width?>,<?=$img_height?>)" align=absmiddle>&nbsp;</li>
<? } ?>
</ul>
