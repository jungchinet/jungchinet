<?
if (!defined('_GNUBOARD_')) exit;

// 사이트맵 
function sitemap($skin_dir="", $subject_len=20, $new_days=7, $options="")
{
    global $g4, $is_admin, $member, $mnb_arr, $snb_arr;

    if ($skin_dir)
        $sitemap_skin_path = "$g4[path]/skin/sitemap/$skin_dir";
    else
        $sitemap_skin_path = "$g4[path]/skin/sitemap/basic";

    ob_start();
    include "$sitemap_skin_path/sitemap.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
