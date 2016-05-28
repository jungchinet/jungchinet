<?
include_once("./_common.php");

include_once("./_head.php");

//$sql="select distinct(b.bo_subject), a.my_id, a.my_datetime from g4_my_board a, g4_board b where a.mb_id='{$member[mb_id]}' and a.bo_table=b.bo_table";
$sql="select b.bo_table, b.bo_subject, a.my_datetime from g4_my_board a left join g4_board b on a.bo_table = b.bo_table
              where a.mb_id = '$member[mb_id]' group by b.bo_table order by a.my_datetime desc limit 15";
$rst=mysql_query($sql);
?>

<style>
.hoverer:hover{background-color:#f5f5f5;}
.section_ul{position:relative;border:1px solid #ddd;background:#fff;font-size:12px;font-family:Tahoma, Geneva, sans-serif;line-height:normal;*zoom:1}
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
</style>

<form name=fsingolist method=post style="margin:0px;">
<input type=hidden name=head  value='<?=$head?>'>
<input type=hidden name=check value='<?=$check?>'>
<input type=hidden name=rows  value='<?=$rows?>'>
<div class="section_ul">
	<h2><em><a href="<?=$g4[path]?>/mr_board.php" <?=$target_link?> ><?=$skin_title?></a></em></h2>
	<ul>
  <?
  if (count($rst) == 0) {
      echo "<li><span class='bu'></span> <a href='#'>내용없슴</a></li>";
  } else {

      while ($i=mysql_fetch_array($rst)) {

          echo "<li class='hoverer'><a href='/bbs/board.php?bo_table={$i[bo_table]}'>";
          echo "<span>{$i[bo_subject]}</span></a>";          
          echo "<span class='time'>" . substr($i[my_datetime], 0,10) . "</span>";
          
          echo "</li>";
      }
  }
  ?>
	</ul>
</div>

<?
include_once("./_tail.php");
?>
