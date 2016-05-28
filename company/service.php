<?
include_once("./_common.php");

$g4['title'] = "이용약관";
include_once("./_head.php");

// 등록에 관련된 설정을 추가로 읽어 들입니다.
$config = get_config("reg");
?>

<div class="section" style="margin-bottom:20px">
    <h2 class="hx"><?=$g4['title']?></h2>
      	<div class="tx">
      	    <?=nl2br(stripslashes($config[cf_stipulation]))?>
        </div>
  	<a class="section_more" href="#">
</div>

<?
include_once("./_tail.php");
?>
