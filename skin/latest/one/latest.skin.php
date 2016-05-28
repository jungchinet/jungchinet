<?
// naver layout이 아니면, style을 include
if ($g4[layout_skin] !== "naver")
    echo "<link rel='stylesheet' href='<?=$g4[path]?>/style.latest.css' type='text/css'>";
?>

<div class="section_ul">
	<h2><em><a href='<?=$skin_title_link?>' onfocus='this.blur()'><?=$view[subject]?></a></em></h2>
	<ul>
  <?
  echo $view[content];
  ?>
	<a href='<?=$skin_title_link?>' onfocus='this.blur()' class="more"><span></span>더보기</a>
</div>
