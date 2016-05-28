<?
$sub_menu = "200190";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

for ($i=0; $i<count($chk); $i++)
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];
    $nick_no = $_POST[nick_no][$k];

    $sql = " select count(*) as cnt from $g4[mb_nick_table] where nick_no = '$nick_no' and end_datetime ='0000-00-00 00:00:00' ";
    $result = sql_fetch($sql);

    // 닉네임이 사용중인 경우에는 지울 수 없습니다
    if ($result[cnt]) {
      alert("nick_no : $nick_no : 닉네임이 사용중이므로 삭제할 수 없습니다", "./nickname_list.php?$qstr");
    }
    
    $sql = " delete from $g4[mb_nick_table] where nick_no = '$nick_no' ";
    sql_query($sql);
}

goto_url("./nickname_list.php?$qstr");
?>
