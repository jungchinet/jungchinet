<?
// 보더형 태이블 4
// http://html.nhndesign.com/uio_factory/ui_pattern/table/4
?>
<link rel='stylesheet' href='<?=$sitemap_skin_path?>/style.latest.css' type='text/css'>

<table class="tbl_type" border="1" cellspacing="0" summary="사이트맵-sitemap" width="100%" style="margin-top:5px;border-right: 1px solid #dddee2;">
<colgroup>
<col width="100">
<col>
</colgroup>
<tbody>
<?
for ($i=0; $i<count($mnb_arr); $i++) { 

    echo "<tr>";
    echo "<th scopt='row'>";
    // href가 있으면 쓰고, 없으면 만들고
    if ($mnb_arr[$i][href])
        $mnb_href = $mnb_arr[$i][href];
    else
        $mnb_href = "$g4[path]/?mnb=" . $mnb_arr[$i][id];
    // new = 1이면 새창을 띄워준다.
    if ($mnb_arr[$i]['new'])
        $mnb_new = " target=new ";
    else
        $mnb_new = "";
    echo "<a href='$mnb_href' onfocus='this.blur()' $mnb_new>";
    echo $mnb_arr[$i][name];
    echo "</a></th>";
    echo "<td style='word-break:keep-all;WORD-WRAP: break-word'>";
    $mid = $mnb_arr[$i][id];

    for ($j=0; $j < count($snb_arr[$mid]); $j++) {
        $sid = $snb_arr[$mid][$j][id];
        if ($snb_arr[$mid][$j][href])
            $snb_href = $snb_arr[$mid][$j][href];
        else
            $snb_href = "$g4[bbs_path]/board.php?bo_table=" . $snb_arr[$mid][$j][id] . "&" . $mid . "&snb=" . $sid;
        if ($snb_arr[$i]['new'])
            $snb_new = " target=new ";
        else
            $snb_new = "";
        echo "<a href='$snb_href' onfocus='this.blur()' $snb_new>";
        echo $snb_arr[$mid][$j][name];
        echo "</a>&nbsp;&nbsp;";
    }
    echo "</td>";
    echo "</tr>";
}
?>
</tbody>
</table>
