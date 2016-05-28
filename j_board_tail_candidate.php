<?php
//국회의원 후보자 정보 가져오기
$candidates = array();
$sql = "
    SELECT  no
            , b.city_name
            , bo_subject
            , party
            , image
            , name_ko AS name
            , info_page
    FROM    j_candidates a
    		, j_boards b
    WHERE   a.region_id = b.region_id
            AND a.drop_reason = ''
			and bo_table = '{$board['bo_table']}'
    ORDER BY no ASC;
    ";
$result_s = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result_s); $i++) {
    $candidates[] = $row;
}
?>



<style type="text/css">
    .cont_table{clear:both;width:960px;}
    #cont .cont_tableWrap{width:960px;clear:both;}
    #cont .cont_table {/*position: absolute;top: 32px;left: 0;z-index: 0;width: 970px;*/padding-top: 1px;	padding-bottom: 16px;	width: 960px;height: 100%;}
    .table01, .table03 {border-collapse: collapse; border-top: 2px solid #62888D; width: 79%;margin-top: 10px;}
    .table01 th, .table03 th {background: none repeat scroll 0 0 #DEE7E7; border-bottom: 1px solid #62888D; border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; color: #3C4E73;font-weight: normal; padding: 5px 7px;}
    .table01 td {border-left: 1px solid #DADADA;border-right: 1px solid #DADADA;}
    .table01 td, .table03 td {border-bottom: 1px solid #DADADA; color: #666666;padding: 5px 7px;}
</style>

<center>
    <h1><?= $candidates[0]['bo_subject'] ?> 국회의원 후보자 명부</h1>
    
    
<?php
$column_max = 6;    //한 칼럼에 표시할 후보수
if(count($candidates)) {
    $rows = ceil(count($candidates) / $column_max);
} else {
    $rows = 0;
    echo "<h2>$예비후보자 없음</h2>";
}

//후보자 수에 따라 한열에 최대 n명씩 표시
for($i=0; $i<$rows; $i++) {
    
    echo "<div class=\"cont_table\" id=\"candidate_list\">
		<table id=\"table01\" class=\"table01\" summary=\"후보자 명부\">
				<thead>
                    <tr>";
    
    for($j=0; $j<$column_max; $j++) {
        if( (isset($candidates[($i*$column_max)+$j]['no'])) && (isset($candidates[($i*$column_max)+$j]['name']))) {
            echo "<th width=\"70\">기호 ".$candidates[($i*$column_max)+$j]['no']."</th>";
        } else if( (!isset($candidates[($i*$column_max)+$j]['no'])) && (isset($candidates[($i*$column_max)+$j]['name']))) {
            echo "<th width=\"70\">기호 없음</th>";
        } else {
            echo "<th width=\"70\"></th>";
        }
    }
    
    echo "</tr>";
    echo "<tr>";
    
    for($j=0; $j<$column_max; $j++) {
        if(isset($candidates[($i*$column_max)+$j]['party'])) {
            echo "<td align=\"center\">".$candidates[($i*$column_max)+$j]['party']."</td>";
        } else {
            echo "<td></td>";
        }
    }
    
    echo "</tr>";
    echo "<tr>";
    
    for($j=0; $j<$column_max; $j++) {
        if(isset($candidates[($i*$column_max)+$j]['image'])) {
            echo "<td align=\"center\">";
            echo "<a href=\"".$candidates[($i*$column_max)+$j]['info_page']."\" target=\"_blank\">";
            echo "<img src=\"".$candidates[($i*$column_max)+$j]['image']."\" width=\"70\">";
            echo "</a></td>";
        } else {
            echo "<td></td>";
        }
    }

    echo "</tr>";
    echo "<tr>";
    
    for($j=0; $j<$column_max; $j++) {
        if(isset($candidates[($i*$column_max)+$j]['name'])) {
            echo "<td align=\"center\">".$candidates[($i*$column_max)+$j]['name']."</td>";
        } else {
            echo "<td></td>";
        }
    }
    
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    
}
?>
</center>