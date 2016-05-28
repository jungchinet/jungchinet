<?
$sub_menu = "100510";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "r");

$g4[title] = "php info";
include_once("./admin.head.php");


// http://php-fusion.co.uk/forum/viewthread.php?thread_id=24120

function print_status($supported)
{
  if ($supported) {
    echo "<span style=\"color: #00f\">Yes!</span>";
  } else {
    echo "<span style=\"color: #f00; font-weight: bold\">No</span>";
  }
}
?>

<li><strong>GD Support:</strong>
<?php print_status($gd_support = extension_loaded('gd')); ?></li>
<?php if ($gd_support) $gd_info = gd_info(); else $gd_info = array(); ?>
<?php if ($gd_support): ?>
<li><strong>GD Version:</strong>
<?php echo $gd_info['GD Version']; ?></li>
<?php endif; ?>
<li><strong>TTF Support (FreeType):</strong>
<?php print_status($gd_support && $gd_info['FreeType Support']); ?>
<?php if ($gd_support && $gd_info['FreeType Support'] == false): ?>
<br />No FreeType support.  Cannot use TTF fonts, but you can use GD fonts
<?php endif; ?></li> 
<li><strong>JPEG Support:</strong>
<?php print_status($gd_support && $gd_info['JPEG Support']); ?></li>
<li><strong>PNG Support:</strong>
<?php print_status($gd_support && $gd_info['PNG Support']); ?></li>
<li><strong>GIF Read Support:</strong>
<?php print_status($gd_support && $gd_info['GIF Read Support']); ?></li>
<li><strong>GIF Create Support:</strong>
<?php print_status($gd_support && $gd_info['GIF Create Support']); ?></li> 
      </ul>

<?
include_once("./admin.tail.php");
?>
