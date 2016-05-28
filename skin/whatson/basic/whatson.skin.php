<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// naver layout이 아니면, style을 include
if ($g4[layout_skin] !== "naver")
    echo "<link rel='stylesheet' href='<?=$g4[path]?>/style.latest.css' type='text/css'>";
?>

<script type="text/javascript" src="<?=$g4[admin_path]?>/admin.js"></script>
<script language="JavaScript">
var list_delete_php = "whatson_delete_all.php";
</script>

<? if($_SERVER[PHP_SELF]=='/bbs/whatson.php'){ ?>
<style>
.hoverer:hover{background-color:#f5f5f5;}
</style>
<? } ?>

<form name=fsingolist method=post style="margin:0px;">
<input type=hidden name=head  value='<?=$head?>'>
<input type=hidden name=check value='<?=$check?>'>
<input type=hidden name=rows  value='<?=$rows?>'>
<div class="section_ul" style='margin-bottom:10px;'>
	<h2><em><a href="<?=$g4[bbs_path]?>/whatson.php?check=1&rows=30" <?=$target_link?> ><?=$skin_title?>내글에 달린 댓글</a></em></h2>
	<ul>
  <?
  if (count($list) == 0) {
      echo "<li><span class='bu'></span> <a href='#'>내용없슴</a></li>";
  } else {

      for ($i=0; $i<count($list); $i++) {

          echo "<li class='hoverer'><span class='bu'>";
          if ($check == 1) {
              echo $row[wo_id];
              echo "<input type=hidden name=wo_id[$i] value='{$list[$i][wo_id]}'>";
              echo "<input type=checkbox name=chk[] value='$i'>";
          }
          echo "</span> ";

          // 이미 읽은 글은 바로 새창, 아니면, ajax로 읽은거 mark 한 후에 새창
          if ($list[$i]['wo_status'])
		      echo '<a href="'.$list[$i]['url'].($list[$i]['wo_type']=='write_reply'?'#board':'').$target_link.'">';
          else
              echo "<a href='javascript: void(0)' onclick='javascript:whatson_read(\"" . $list[$i][url] . "\", " . $list[$i][wo_id] . ");return false;' >";

          echo "(" . $list[$i][wo_count] . ")";
       //   if ($list[$i][comment_id]) echo "<img src='" . $whatson_skin_path . "/img/icon_comment.gif'>";
    
          // 이미 읽은 글은 회색으로 표시
          if ($list[$i][wo_status])
              echo "<font color='gray'>";
          
          echo " " . $list[$i][subject];

          if ($list[$i][wo_status])
              echo "</font>";
    
          echo "</a>";
          $delete_href = "javascript:del('" . $g4[bbs_path] . "/ajax_whatson.php?w=d&page=$page&rows=$rows&check=$check&wo_id=".$list[$i][wo_id]."');";
          echo " " . "<a href=\"$delete_href\" >" . "x" . "</a> ";
          
          echo "<span class='time'>" . $list[$i][datetime] . "</span>";
          
          echo "</li>";
      }
  }
  ?>
	</ul>
	<? if ($total_count > 0) { ?>
	<!--a href="<?=$g4[bbs_path]?>/whatson.php?check=1&rows=30" <?=$target_link?> onfocus='this.blur()' class="more"><span></span>더보기</a-->
	<? } ?>
</div>

<? if ($check == 1 && $i>0) { ?>
<input type=checkbox name=chkall id=chkall value='1' onclick='check_all(this.form)'>&nbsp;<label for=chkall>전체선택</label>&nbsp;&nbsp;
<input type=button class='btn1' value='선택삭제' onclick="btn_check(this.form, 'delete')">
<? } ?>
</form>

<script type="text/javascript">
function whatson_read(url, wo_id) {

	var post_url = "<?=$g4[bbs_path]?>/ajax_whatson.php?w=r&wo_id="+wo_id;
  var data = "";

	$.ajax({
		type:"POST",
		url:post_url,
		data:data,
		async:false,
		error:function() {
			alert('fail');
		},
		success: function(){
		    <? if ($target) { ?>
        parent.<?=$target?>.location.href = url ;
		    <? } else { ?>
        location.href = url;
        <? } ?>
		}
	});
	
	return false;
}
</script>
