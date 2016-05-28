<?
include_once("./_common.php");

$g4['title'] = "이메일주소무단수집거부";
include_once("./_head.php");
?>

<div class="section" style="margin-bottom:20px">
    <h2 class="hx"><?=$g4['title']?></h2>
      	<div class="tx">
      	    <?=nl2br(implode("", file("./rejection.html")));?>
        </div>
  	<a class="section_more" href="#">
</div>

<?
include_once("./_tail.php");
?>
