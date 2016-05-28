<?
$sub_menu = "100200";
include_once("./_common.php");

check_token();

$mb_id = trim($_POST[mb_id]);
$au_menu = $_POST[au_menu];
$r = $_POST[r];
$w = $_POST[w];
$d = $_POST[d];

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$mb = get_member($mb_id);
if (!$mb[mb_id])
    alert("존재하는 회원아이디가 아닙니다."); 

if ($mb[mb_id] == $config[cf_admin])
    alert("최고관리자의 권한은 제한할 수 없습니다."); 

$sql = " insert into $g4[auth_table] 
            set mb_id   = '$mb_id',
                au_menu = '$au_menu',
                au_auth = '$r,$w,$d' ";
$result = sql_query($sql, FALSE);
if (!$result) {
    $sql = " update $g4[auth_table] 
                set au_auth = '$r,$w,$d'
              where mb_id   = '$mb_id'
                and au_menu = '$au_menu' ";
    sql_query($sql);
}

//sql_query(" OPTIMIZE TABLE `$g4[auth_table]` ");

//불당 mb_auth_count를 업데이트
$sql = " select count(*) as cnt from $g4[auth_table] where mb_id = '$mb_id' ";
$result = sql_fetch($sql);
$sql = " update $g4[member_table] set mb_auth_count = '$result[cnt]' where mb_id = '$mb_id' ";
sql_query($sql);

goto_url("./auth_list.php?$qstr");
?>
