<?
if (!defined('_GNUBOARD_')) exit;

// 배너가 없으면 출력하지 않는다
if (count($list)) {
    $bn_target = $list[0][bn_target];
    $bg_id = $list[0][bg_id];
    $bn_id = $list[0][bn_id];
    $subject = $list[0][bn_subject];
    $url = $g4[bbs_path] . "/banner_link.php?bg_id=$bg_id&bn_id=$bn_id";
    $img = $g4[data_path] . "/banner/" . $list[0][bg_id] . "/" . $list[0][bn_image];

    if ($bn_target)
        $target = " target=_blank ";
    else
        $target = "";
?>
    <a href='<?=$url?>' <?=$target?> alt='<?=$subject?>'><img src='<?=$img?>' align=absmiddle alt='배너클릭이미지'></a>
<? } ?>
