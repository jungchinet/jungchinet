<?

$sub_menu = "200100"; 
include_once("./_common.php"); 

auth_check($auth[$sub_menu], "r"); 

$week_colors= array( 
0=>'#7AAD4C', 
'#A7EB5A', 
'#C6EA82', 
'#DCEAA2', 
'#EEF18D', 
'#9A9994', 
'#566D52' 
); 

$colspan= 33; 

$sql_common= " from $g4[member_table] "; 
$sql_search= " where 1 > 0 "; 
$sql_order= "";

if( empty( $this_year)) $this_year= date('Y'); 

$sqlm= "select month( mb_datetime), day( mb_datetime), weekday( mb_datetime) weeki, count(*) from $g4[member_table] 
         where year( mb_datetime)=$this_year 
         group by month( mb_datetime), day( mb_datetime) with rollup;"; 

$ress= mysql_query( $sqlm); 

// 탈퇴회원수 
$sql = " select count(*) as cnt 
        $sql_common 
        $sql_search 
            and mb_leave_date <> '' 
        $sql_order "; 
$row = sql_fetch($sql); 
$leave_count = $row[cnt]; 

// 차단회원수 
$sql = " select count(*) as cnt 
        $sql_common 
        $sql_search 
            and mb_intercept_date <> '' 
        $sql_order "; 
$row = sql_fetch($sql); 
$intercept_count = $row[cnt]; 

$listall = "<a href='$_SERVER[PHP_SELF]' class=tt>처음</a>"; 

$g4[title] = "회원 가입 통계"; 
include_once("./admin.head.php"); 

//echo $sqlm; 
?> 
<p align="center" style="font-size:150%;" ><a 
href="?this_year=<?=$this_year-1;?>" >&lt;&lt;</a> <?=$this_year?><a 
href="?this_year=<?=$this_year+1;?>" >&gt;&gt;</a> </p> 
<table class="num" border=0 width=100% cellpadding=0 cellspacing=0> 
<thead> 
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr> 
<tr class='bgcol1 bold col1 ht center'> 
<td>월</td> 
<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td> 
<td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td> 
<td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td> 
<td>31</td> 
<td>sum</td> 
</tr> 
</thead> 
<tbody> 
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr> 
<?php 

$row_month=''; 
$empty_days= array( 1=>'', '', '', '', '', '', '', '', '', '', 
'', '', '', '', '', '', '', '', '', '', 
'', '', '', '', '', '', '', '', '', '', 
'', 'sum'=>0 ); 

$empty_weeks= array( 1=>'', '', '', '', '', '', '', '', '', '', 
'', '', '', '', '', '', '', '', '', '', 
'', '', '', '', '', '', '', '', '', '', 
'', 'sum'=>0 ); 

$row_days= $empty_days; 
$row_weeks= $empty_weeks; 

$this_month=''; 

if( $ress) while( $row= mysql_fetch_row( $ress)) { 

        if( empty( $row[1])) { 
                if( empty( $row[0])) $this_month= '총계'; 
                $row_days[ 'sum']= $row[3]; 
                echo '<tr height="60"><th rowspan="3" >', $this_month, '</th>'; 
                foreach( $row_days as $key=> $cnt) { echo '<td valign="bottom" >'; 
if( $key != 'sum' && $cnt ) echo 
'<div style="font-size:', $cnt,'px;line-height:', $cnt, 'px;width:10px;margin:3px;background-color:', $week_colors[ $row_weeks[ $key]], '" >&nbsp;</div>'; 
                        echo '</td>'; 
                } 
                echo '</tr>'; 
                echo "<tr><td colspan='$colspan' class='line2'></td></tr>"; 
                echo '<tr height="20">'; 
                foreach( $row_days as $key=> $cnt) { echo '<td valign="top" >'; 
                        echo $cnt, '</td>'; } 
                echo '</tr>'; 
                $row_days= $empty_days; 
                $row_weeks= $empty_weeks; 
        } else { 
                $row_days[ $row[1]]= $row[3]; 
                $row_weeks[ $row[1]]= $row[2]; 
        } 
        $this_month= $row[0]; 

} 

echo "<tr><td colspan='$colspan' class='line2'></td></tr>"; 
echo "</tbody></table>"; 

$week_name= array( 0=>'월', '화', '수', '목', '금', '토', '일'); 

?><table><tr><?php 

foreach( $week_name as $name) 
        echo '<td>', $name, '</td>'; 
echo '</tr><tr>'; 
foreach( $week_colors as $name) 
        echo '<td style="background-color:', $name, ';">&nbsp;</td>'; 
echo '</tr></table>'; 

?> 

<?php 

include_once ("./admin.tail.php"); 
?> 
