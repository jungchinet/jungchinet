<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if (!$skin_title) {
    if ($board[bo_subject]) {
        $skin_title = $board[bo_subject];
        $skin_title_link = "$g4[bbs_path]/board.php?bo_table=$bo_table";
    } else {
        $skin_title = "최신글";
    }
}

// naver layout이 아니면, style을 include
if ($g4[layout_skin] !== "naver")
    echo "<link rel='stylesheet' href='<?=$g4[path]?>/style.latest.css' type='text/css'>";
?>

<div class="section_ul" style='margin-bottom:10px;'>
	<h2><em><a href='<?=$skin_title_link?>' onfocus='this.blur()'><?=$skin_title?></a></em></h2>
	<ul>
  <?
  if (count($list) == 0) {
      echo "<li><span class='bu'></span> <a href='#'>내용없슴</a></li>";
  } else {
      for ($i=0; $i<count($list); $i++) {
		  
		  if($list[$i][wr_1]){
		  	//$areac='['.$list[$i][wr_1].'] ';
			$areac='';
		  }else{
		    //$areac='[전체] ';
			$areac='';
		  }

          echo "<li style='overflow:hidden;'><span class='bu'></span> ";

          if ($list[$i][icon_secret])
              echo "<span style='float:left'>" . "<img src='/skin/latest/naver/img/icon_secret.gif' alt='secret' align=absmiddle> " . "</span>";

          if ($list[$i][bo_name])
              $list_title = $list[$i][bo_name] . " : " . $list[$i][subject] . " (". $list[$i][datetime] . ")" ;
          else
              $list_title = $list[$i][subject]  . " (". $list[$i][datetime] . ")" ;

          if ($list[$i][icon_reply])
              //echo "<span style='float:left'>" . $list[$i][icon_reply] . "</span>";
			  echo " " . "<span style='float:left'><img src='/skin/latest/naver/img/icon_reply.gif' alt='secret' align=absmiddle></span>";

          echo "<a href='{$list[$i][href]}#board' onfocus='this.blur()' title='{$list_title}' {$target_link}>";
          if ($list[$i][is_notice])
              echo "-<font style='font-family:돋움; font-size:9pt; color:#2C88B9;'><strong>$areac" . $list[$i][subject] . "</strong></font>";
          else
              echo "-<font style='font-family:돋움; font-size:9pt; color:#6A6A6A;'>$areac" . $list[$i][subject] . "</font>";
          echo "</a>";

		//	if ($list[$i][comment_cnt]) 
		//				  echo " <a href=\"{$list[$i][comment_href]}\" onfocus=\"this.blur()\"><span style='font-family:돋움; font-size:8pt; color:#9A9A9A;'>{$list[$i][comment_cnt]}</span></a> ";

        //  if ($list[$i][icon_new])
            //  echo " " . "<span style='float:left'>" . $list[$i][icon_new] . "</span>";
		//	  echo " " . "<span style='float:left'><img src='/skin/latest/naver/img/icon_new.gif' alt='secret' align=absmiddle></span>";

          echo "</li>";
      }
  }
  // fill이 true이고, 덜 채워지면 꽉 채워준다.
  if (is_array($options) && $options['fill'] && $i < $rows) {
        for ($j=$i; $j<$rows;$j++) {
            echo "<li><span class='bu'></span> ";
            echo "<a href='#'><font style='font-family:돋움; font-size:9pt; color:#6A6A6A;'>&nbsp;</font></a></li>";
        }
  }
  ?>
  </ul>
  <? if($options!='nb'){ ?>
	<!--a href='<?=$skin_title_link?>' onfocus='this.blur()' class="more"><span></span>더보기</a-->
  <? }else{ ?>
	<!--a href='/modules/my_read_board.php' onfocus='this.blur()' class="more"><span></span>더보기</a-->
  <? } ?>
</div>
