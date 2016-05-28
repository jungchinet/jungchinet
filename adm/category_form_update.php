<?
$sub_menu = "400250";
include_once("./_common.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], "w");

$ca_id = $_POST[ca_id];
$ca_subject = $_POST[ca_subject];

if (!$ca_id) { alert("카테고리 ID는 반드시 입력하세요."); }
if ($w == "d")
    ;
else {
    if (!preg_match("/^([A-Za-z0-9]{1,20})$/", $ca_id)) { alert("카테고리 ID명은 공백없이 영문자, 숫자 만 사용 가능합니다. (20자 이내)"); }
    if (!$ca_subject) { alert("카테고리 제목을 입력하세요."); }
}

check_token();

$cn_use                 = $_POST[ca_use];
$ca_order               = $_POST[ca_order];

$bn_1_subj              = $_POST[bn_1_subj];
$bn_2_subj              = $_POST[bn_2_subj];
$bn_3_subj              = $_POST[bn_3_subj];
$bn_1                   = $_POST[bn_1];
$bn_2                   = $_POST[bn_2];
$bn_3                   = $_POST[bn_3];

$sql_common = " 
                ca_subject          = '$ca_subject',
                ca_use              = '$ca_use',
                ca_order            = '$ca_order',
                ca_1_subj           = '$ca_1_subj',
                ca_2_subj           = '$ca_2_subj',
                ca_3_subj           = '$ca_3_subj',
                ca_1                = '$ca_1',
                ca_2                = '$ca_2',
                ca_3                = '$ca_3'
                 ";

if ($w == "") {

    // 소문자로 변환
    $ca_id = strtolower($ca_id);

    $row = sql_fetch(" select count(*) as cnt from $g4[category_table] where ca_id = '$ca_id' ");
    if ($row[cnt])
        alert("{$ca_id} 은(는) 이미 존재하는 카테고리 ID 입니다.");

    $sql = " insert into $g4[category_table]
                set ca_id = '$ca_id',
                    ca_datetime = '$g4[time_ymdhis]',
                    $sql_common ";
    sql_query($sql);

} else if ($w == "u") {

    $sql = " update $g4[category_table]
                set 
                    ca_datetime = '$g4[time_ymdhis]',
                    $sql_common
              where ca_id = '$ca_id' ";
    $result = sql_query($sql);
} else if ($w == "d") {

    // 분류의 길이
    $len = strlen($ca_id);

    $sql = " select COUNT(*) as cnt from $g4[category_table]
              where SUBSTRING(ca_id,1,$len) = '$ca_id'
                and ca_id <> '$ca_id' ";
    $row = sql_fetch($sql);
    if ($row[cnt] > 0) 
        alert("하위 카테고리가 있으므로 삭제 할 수 없습니다.\\n\\n하위 카테고리를 먼저 삭제하여 주십시오.");

    $sql = " delete from $g4[category_table]
              where ca_id = '$ca_id' ";
    $result = sql_query($sql);

    goto_url("./category_list.php?$qstr");
}

goto_url("./category_form.php?w=u&ca_id=$ca_id$qstr");
?>
