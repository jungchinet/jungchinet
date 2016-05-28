<?
include_once("./_common.php");

$g4['title'] = "책임한계와법적고지";
include_once("./_head.php");
?>

<div class="section" style="margin-bottom:20px">
    <h2 class="hx"><?=$g4['title']?></h2>
      	<div class="tx">
      	    <?=nl2br(implode("", file("./disclaimer.html")));?>
        </div>
  	<a class="section_more" href="#">
</div>

<?
include_once("./_tail.php");
?>
