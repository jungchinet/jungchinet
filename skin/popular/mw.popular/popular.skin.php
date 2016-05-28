<?
/**
 * Popular Skin for Gnuboard4
 *
 * Copyright (c) 2008 Choi Jae-Young <www.miwit.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if (!defined("_GNUBOARD_")) exit; // ∞≥∫∞ ∆‰¿Ã¡ˆ ¡¢±Ÿ ∫“∞° 

$date_gap_old = date("Y-m-d", strtotime($date_gap) - ($date_cnt * 86400));

$old = array();
$sql2 = " select pp_word, count(*) as cnt from $g4[popular_table]
	  where pp_date between '$date_gap_old' and '$date_gap'
	  group by pp_word
	  order by cnt desc, pp_word
	  limit 0, 100 ";
$qry2 = sql_query($sql2);
$count = mysql_num_rows($qry2);
for ($j=0; $row2=sql_fetch_array($qry2); $j++) {
    $old[$j] = $row2;
}

for ($i=0; $i<$pop_cnt; $i++) 
{
    for ($j=0; $j<$count; $j++) {
	if ($old[$j][pp_word] == $list[$i][pp_word]) {
	    break;
	}
    }

    $list[$i][pp_word] = urldecode($list[$i][pp_word]);
    $list[$i][pp_rank] = $i + 1;
    if ($count == $j) {
	$list[$i][old_pp_rank] = 0;
	$list[$i][rank_gap] = 0;
    } else {
	$list[$i][old_pp_rank] = $j + 1;
	$list[$i][rank_gap] = $list[$i][old_pp_rank] - $list[$i][pp_rank];
    }
    if ($list[$i][rank_gap] > 0)
	$list[$i][icon] = "up";
    else if ($list[$i][rank_gap] < 0)
	$list[$i][icon] = "down";
    else if ($list[$i][old_pp_rank] == 0)
	$list[$i][icon] = "new";
    else if ($list[$i][rank_gap] == 0)
	$list[$i][icon] = "nogap";
}

?>
<style type="text/css">

.mw-popular {padding:10px; border-top-left-radius:10px; border-top-right-radius:10px;border-bottom-left-radius:10px; border-bottom-right-radius:10px; border:1px solid #e1e1e1; }
.mw-popular td { font-size:12px; line-height:16px; }
.mw-popular a:link { color:#444; text-decoration:none; }
.mw-popular a:active { color:#444; text-decoration:none;  }
.mw-popular a:visited { color:#444; text-decoration:none;  }
.mw-popular a:hover { color:#444; text-decoration:underline; }
.mw-popular .subject { background: height:24px; margin:0 0 7px 0; border-bottom:1px solid #d1d1d1; }
.mw-popular .subject { font-size:12px; color:#555; font-weight:bold; letter-spacing:-1px; text-decoration:none; text-align:left; }
.mw-popular .subject div { margin:5px 0 0 10px;}
.mw-popular table { margin:0 0 0 5px;}
.mw-popular .word { width:90px; height:16px; overflow:hidden; margin:2px 0 0 5px; }
.mw-popular .gap { letter-spacing:-1px; font-size:11px; }
</style>

<div class="mw-popular">
<div style="border:1px solid #fff;">
<div class="subject"><div><h2>트윗검색어</h2></div></div>
<table border=0 cellpadding=0 cellspacing=0>
<? for ($i=0; $i<$pop_cnt; $i++) { ?>
<? if (!is_array($list[$i])) continue; ?>
<tr>
<td width="20" height="20"><img src="<?=$popular_skin_path?>/img/<?=sprintf("%02d", $i+1)?>.gif"></td>
<td width="95">
    <div class="word"><a href="<?=$g4[bbs_path]?>/search.php?sfl=wr_subject&sop=and&stx=<?=urlencode($list[$i][pp_word])?>"><?=$list[$i][pp_word]?></a></div>
</td>
<td width="35">
    <img src="<?=$popular_skin_path?>/img/<?=$list[$i][icon]?>.gif" align=absmiddle>
    <span class="gap"><? if ($list[$i][icon] != "new" && $list[$i][icon] != "nogap") { echo abs($list[$i][rank_gap]); }?></span>
</td>
</tr>
<? } ?>
</table>
</div>
</div>

