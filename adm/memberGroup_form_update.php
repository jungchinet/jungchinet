<?
$sub_menu = "200100";
include_once("./_common.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], "w");

while(list($key,$value) = each($HTTP_POST_VARS)){
        echo("변수명은 :".$key." - 변수의 값은 :".$value."<br>");
}	

if ($w == "")
{
    alert("잘못된 인자값입니다. w : 매개변수 확인"); 
}

else if ($w == "u") 
{
    if ($is_admin != "super")
        alert("관리자만이 수정하실수 있습니다..");

    $sql = " select count(*) as cnt from $g4[member_group_table] where gl_id = '$gl_id' ";	
    $gd = sql_fetch($sql);
    if ($gd[cnt] != 1)
        alert("존재하지 않거나 중복이 있는는 회원레벨입니다."); 

    $sql = " update $g4[member_group_table]
                set gl_name = '$gl_name'
              where gl_id = '$gl_id' ";	
    sql_query($sql);
} 
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

goto_url("./memberGroup_list.php");
?>
