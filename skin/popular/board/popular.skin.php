<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<style type="text/css">
/* http://html.nhndesign.com/uio_factory/ui_pattern/list/3 */
.section_ol{position:relative;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px;border:1px solid #ddd;background:#fff;font-size:12px;font-family:Tahoma, Geneva, sans-serif;line-height:normal;*zoom:1}
.section_ol a{color:#666;text-decoration:none}
.section_ol a:hover,
.section_ol a:active,
.section_ol a:focus{text-decoration:underline}
.section_ol em{font-style:normal}
.section_ol h2{margin:0;padding:10px 0 8px 13px;border-bottom:1px solid #ddd;font-size:12px;color:#333}
.section_ol h2 em{color:#cf3292}
.section_ol ol{margin:13px;padding:0;list-style:none}
.section_ol li{position:relative;margin:0 0 5px 0;*zoom:1}
.section_ol li:after{display:block;clear:both;content:""}
.section_ol li .ranking{display:inline-block;width:14px;height:11px;margin:0 5px 0 0;border-top:1px solid #fff;border-bottom:1px solid #d1d1d1;background:#d1d1d1;text-align:center;vertical-align:top;font:bold 10px Tahoma;color:#fff}
.section_ol li.best .ranking{border-bottom:1px solid #6e87a5;background:#6e87a5}
.section_ol li.best a{color:#7189a7}
.section_ol li .num{position:absolute;top:0;right:0;font-size:11px;color:#a8a8a8;white-space:nowrap}
.section_ol li.best .num{font-weight:bold;color:#7189a7}
.section_ol .more{position:absolute;top:10px;right:13px;font:11px Dotum, 돋움;text-decoration:none !important}
.section_ol .more span{margin:0 2px 0 0;font-weight:bold;font-size:16px;color:#d76ea9;vertical-align:middle}
</style>

<div class="section_ol">
<h2>게시판 <em>랭킹</em></h2>
<ol style='text-align:left;'>
    <? 
    $zr=1;
    for ($i=0; $i<count($list); $i++) {

        //게시판이 battle01일 경우 제외
        if($list[$i][bo_table]=='battle01'){
            continue;
        }

        //$rank = $i+1;
        $rank = $zr;
        if ($i < 3)
            $best = "class='best'";
        else
            $best = "";
        echo "<li $best>";
        echo "<span class='ranking'>$rank</span><a href='$g4[bbs_path]/board.php?bo_table={$list[$i][bo_table]}'>";
        echo $list[$i][bo_subject];
        //echo "<span class='num'>[{$list[$i][bo_count_write]}]</span></a></li>";
		echo "</a></li>";

        $zr++;
    }
    ?>
</ol>
</div>
