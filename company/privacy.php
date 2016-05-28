<?
include_once("./_common.php");

header("P3P:CP='간략방침기호'");

$g4['title'] = "개인정보취급방침";
include_once("./_head.php");

// 등록에 관련된 설정을 추가로 읽어 들입니다.
$config = get_config("reg");
?>

<div class="section" style="margin-bottom:20px">
    <h2 class="hx"><?=$g4['title']?></h2>
      	<div class="tx">
      	    <?=nl2br(stripslashes($config[cf_privacy]))?>
        </div>
  	<a class="section_more" href="#">
</div>

<?
include_once("./_tail.php");
?>
