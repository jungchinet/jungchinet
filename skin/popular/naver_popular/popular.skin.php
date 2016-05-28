<style>
/* http://html.nhncorp.com/uio_factory/ui_pattern/list/3 */
.section_ol3{position:relative;border:1px solid #ddd;background:#fff;font-size:12px;font-family:Tahoma, Geneva, sans-serif;line-height:normal;*zoom:1}
.section_ol3 a{color:#666;text-decoration:none}
.section_ol3 a:hover,
.section_ol3 a:active,
.section_ol3 a:focus{text-decoration:underline}
.section_ol3 em{font-style:normal}
.section_ol3 h2{margin:0;padding:10px 0 8px 13px;border-bottom:1px solid #ddd;font-size:12px;color:#333}
.section_ol3 h2 em{color:#cf3292}
.section_ol3 ol{margin:5px;padding:0;list-style:none}
.section_ol3 li{position:relative;margin:0 0 6px 0;*zoom:1}
.section_ol3 li:after{display:block;clear:both;content:""}
.section_ol3 li .ranking{display:inline-block;width:14px;height:11px;margin:0 5px 0 0;border-top:1px solid #fff;border-bottom:1px solid #d1d1d1;background:#d1d1d1;text-align:center;vertical-align:top;font:bold 10px Tahoma;color:#fff}
.section_ol3 li.best .ranking{border-bottom:1px solid #6e87a5;background:#6e87a5}
.section_ol3 li.best a{color:#7189a7}
.section_ol3 li .num{position:absolute;top:0;right:0;font-size:11px;color:#a8a8a8;white-space:nowrap}
.section_ol3 li.best .num{font-weight:bold;color:#7189a7}
.section_ol3 .more{position:absolute;top:10px;right:13px;font:11px Dotum, 돋움;text-decoration:none !important}
.section_ol3 .more span{margin:0 2px 0 0;font-weight:bold;font-size:16px;color:#d76ea9;vertical-align:middle}
</style>

<div class="section_ol3">
	<ol style='text-align:left;'>
  <?
  $row_height = "style='margin:4px'";
  if (count($npop) == 0) {
      echo "<li><span class='bu'></span> <a href='#'>내용없슴</a></li>";
  } else {
      for ($i=0; $i<count($npop); $i++) { 
          $j = $i+1;
          $rank = $npop[$i][S] . $npop[$i][V];;
          if ($i < 3)
              $li_class = "class='best'";
          else
              $li_class = "";
          echo "<li $li_class>";
          echo "<span class='ranking'>$j</span>";
          echo "<a href='{$npop[$i][LINK]}' onfocus='this.blur()' title='{$npop[$i][K]}' target=new>";
          echo $npop[$i][K];
          echo "</a>";
          echo "<span class='num'>$rank</span>";
          echo "</li>";
      }
  }
  ?>
  </ol>
</div>
