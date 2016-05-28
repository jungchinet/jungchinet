<?
include_once("./_common.php");

//출력할 인기게시물 수
$favNum=mysql_fetch_array(mysql_query("select row4, ord1 from rows_info"));
$favNum=$favNum['row4']; //인기게시물 수
$favOrd=$favNum['ord1']; //1:조회수 / 2:추천수

$sql="select bo_table, bo_hot from g4_board order by bo_table";
$rst=mysql_query($sql);
$num=mysql_num_rows($rst);
$f=1;

//$wowSql.=" select wr_subject, wr_id from ";
while($s=mysql_fetch_array($rst)){
	$bConf=mysql_fetch_row(mysql_query("select bo_hot from g4_board where bo_table='".$s[bo_table]."'"));

  $wowSql.="select '$s[bo_table]' bo_table, wr_hit, wr_subject, wr_id, wr_datetime from  g4_write_".$s[bo_table]." where wr_is_comment=0 and wr_hit>=$bConf[0]";
	
	if($f<$num){
		$wowSql.=" union ";
	}
	$f++;
}

if($favOrd==1){
  $wowSql.=" order by wr_hit desc limit 0,$favNum";
}else{
  $wowSql.=" order by wr_good desc limit 0,$favNum";
}

$result=mysql_query($wowSql);
$nr=mysql_num_rows($result);


?>


<div class="section_ul" style='margin-bottom:10px;'>
	<h2><em style='color:#44add0;'>최고인기글</em></h2>
	<ul>
  <?
  if (count($nr) == 0) {
      echo "<li><span class='bu'></span> <a href='#'>내용없슴</a></li>";
  } else {
	  $pp=1;
      while($g=mysql_fetch_array($result)){
		  
		  if ($pp < 4)
          	$best = "best2";
          else
            $best = "";

          echo "<li style='overflow:hidden;'><span class='bu'></span> ";
          echo "<a href='/bbs/board.php?bo_table=$g[bo_table]&wr_id=$g[wr_id]#board' onfocus='this.blur()' title='{$list_title}' {$target_link}>";
          echo "<font style='font-family:돋움; font-size:9pt; color:#6A6A6A;'><span class='ranking2 $best'>$pp</span>" . stripslashes($g['wr_subject']) . "</font>";
          echo "</a>";

          echo "</li>";
		  $fWow=0;
		  $pp++;
      }
  }
  ?>
  </ul>
</div>

<style>
.section_ul{position:relative;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px;border:1px solid #ddd;background:#fff;font-size:12px;font-family:Tahoma, Geneva, sans-serif;line-height:normal;*zoom:1}
.section_ul a{color:#666;text-decoration:none}
.section_ul a:hover,
.section_ul a:active,
.section_ul a:focus{text-decoration:underline}
.section_ul em{font-style:normal}
.section_ul h2{margin:0;padding:10px 0 8px 10px;border-bottom:1px solid #ddd;font-size:12px;color:#333}
.section_ul h2 em{color:#cf3292}
.section_ul ul{margin:10px;padding:0;list-style:none} /* 요기 margin이랑 h2의 margin이랑 맞춰야 합니다 */
.section_ul li{position:relative;margin:0 0 3px 0}    /*줄간격은 요기서 margin을 바꾸면 됩니다 */
.section_ul li:after{display:block;clear:both;content:""}
.section_ul li .bu{float:left;margin:0 3px 0 0;color:#999}
.section_ul li a{float:left}
.section_ul li .time{float:right;clear:right;font-size:11px;color:#a8a8a8;white-space:nowrap}
.section_ul .more{position:absolute;top:10px;right:13px;font:11px Dotum, 돋움;text-decoration:none !important}
.section_ul .more span{margin:0 2px 0 0;font-size:16px;font-weight:bold;color:#d76ea9;vertical-align:middle}
.ranking2{display:inline-block;width:14px;height:11px;margin:0 5px 0 0;border-top:1px solid #fff;border-bottom:1px solid #32acd9;background:#32acd9;text-align:center;vertical-align:top;font:bold 10px Tahoma;color:#fff}
.best2{border-bottom:1px solid #32acd9;background:#32acd9}
</style>