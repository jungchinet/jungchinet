<? 
include_once("./_common.php"); 
header("Content-Type: text/html; charset=utf-8"); 

$q = iconv("utf-8", "cp949", $q); 
if ($q) { 
    $any = ""; 
    if ($like) 
        $any = "%"; 

    $javascript_object = "["; 
    
    $sql = " select pp_word, count(*) as cnt from $g4[popular_table] "; 
    $sql .= " where 1 "; 
    $sql .= " and pp_word like '".$any.$q."%' "; 
    $sql .= " group by pp_word "; 
    $sql .= " order by cnt desc "; 
    $sql .= " limit 15 "; 
    $result = sql_query($sql); 
    for($i=0;$row=sql_fetch_array($result);$i++) { 
        if ($i>0) 
            $javascript_object .= ","; 
        $s = stripslashes(strip_tags($row[pp_word])); 
        $s = str_replace("[", "", $s); 
        $s = str_replace("]", "", $s); 
        $s = str_replace("\n", "", $s); 
        $s = str_replace("\r", "", $s); 
        $str = iconv("cp949", "utf-8", $s); 
        $javascript_object .= "\"".$str."\""; 
    } 
    
    $javascript_object .= "];"; 

    echo $javascript_object; 
} 
?> 

