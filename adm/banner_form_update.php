<?
$sub_menu = "300900";
include_once("./_common.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], "w");

$bn_id = $_POST[bn_id];
$bg_id = $_POST[bg_id];
$bn_subject = $_POST[bn_subject];

if (!bg_id) { alert("그룹 ID는 반드시 선택하세요."); }
if (!$bn_id) { alert("배너 ID는 반드시 입력하세요."); }
if (!preg_match("/^([A-Za-z0-9_]{1,20})$/", $bn_id)) { alert("배너 ID명은 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내)"); }
if (!$bn_subject) { alert("게시판 제목을 입력하세요."); }

if ($img = $_FILES[bn_image][name]) {
    if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
        alert("배너 이미지가 gif, jpg, png 파일이 아닙니다.");
    }
}

check_token();

// 베너 저장할 곳을 생성
@mkdir("$g4[data_path]/banner", 0707);
@chmod("$g4[data_path]/banner", 0707);

$banner_path = "$g4[data_path]/banner/$bg_id";
$bn_filename  = $_FILES[bn_image][name];

// 배너 디렉토리 생성 - 배너 그룹별로 구분
@mkdir($banner_path, 0707);
@chmod($banner_path, 0707);

// 디렉토리에 있는 파일의 목록을 보이지 않게 한다.
$file = $banner_path . "/index.php";
$f = @fopen($file, "w");
@fwrite($f, "");
@fclose($f);
@chmod($file, 0606);

$bn_url                 = $_POST[bn_url];
$bn_target              = $_POST[bn_target];
$bn_table              = $_POST[bn_table];
$bn_use                 = $_POST[bn_use];
$bn_order               = $_POST[bn_order];
$bn_start_datetime      = $_POST[bn_start_datetime];
$bn_end_datetime        = $_POST[bn_end_datetime];
$bn_text                = $_POST[bn_text];
// 날짜가 비어 있으면 오늘을 넣어준다
if ($bn_start_datetime == "0000-00-00 00:00:00" || $bn_end_datetime == "0000-00-00 00:00:00")
    $bn_start_datetime = $bn_end_datetime = $g4['time_ymdhis'];
// 날짜만 있으면 뒤에 시.분.초를 붙여준다
if (strlen(trim($bn_end_datetime)) == 10)
    $bn_end_datetime .= " 23:59:59";
$bn_1_subj              = $_POST[bn_1_subj];
$bn_2_subj              = $_POST[bn_2_subj];
$bn_3_subj              = $_POST[bn_3_subj];
$bn_1                   = $_POST[bn_1];
$bn_2                   = $_POST[bn_2];
$bn_3                   = $_POST[bn_3];

$sql_common = " bg_id               = '$bg_id',
                bn_subject          = '$bn_subject',
                bn_url              = '$bn_url',
                bn_target           = '$bn_target',
                bn_table            = '$bn_table',
                bn_start_datetime   = '$bn_start_datetime',
                bn_end_datetime     = '$bn_end_datetime',
                bn_use              = '$bn_use',
                bn_order            = '$bn_order',
                bn_text             = '$bn_text',
                bn_1_subj           = '$bn_1_subj',
                bn_2_subj           = '$bn_2_subj',
                bn_3_subj           = '$bn_3_subj',
                bn_1                = '$bn_1',
                bn_2                = '$bn_2',
                bn_3                = '$bn_3'
                 ";

if ($_FILES[bn_image][name]) {
    $bn_image_urlencode = $bn_id."_".time();
    $sql_common .= " , bn_image = '$bn_image_urlencode' ";
    $sql_common .= " , bn_filename = '$bn_filename' ";
}

if ($bn_image_del) {
    @unlink("$banner_path/$bn_image_del");
    $sql_common .= " , bn_image = '', bn_filename = '' ";
}

if ($w == "") {
    $row = sql_fetch(" select count(*) as cnt from $g4[banner_table] where bn_id = '$bn_id' ");
    if ($row[cnt])
        alert("{$bn_id} 은(는) 이미 존재하는 배너 ID 입니다.");

    $sql = " insert into $g4[banner_table]
                set bn_id = '$bn_id',
                    bn_datetime = '$g4[time_ymdhis]',
                    $sql_common ";
    sql_query($sql);

} else if ($w == "u") {

    // 업데이트를 하는데, 그룹이 달라지면??? 이미지 경로가 달라진다...ㅠㅠ...
    $result = sql_fetch(" select * from $g4[banner_table] where bn_id = '$bn_id' ");
    if ($bg_id !== $result['bg_id']) {
        $from_image = "$g4[data_path]/banner/$result[bg_id]/$result[bn_image]";
        $to_image = "$banner_path/$result[bn_image]";
        rename("$from_image", "$to_image");
    }

    $sql = " update $g4[banner_table]
                set 
                    bn_datetime = '$g4[time_ymdhis]',
                    $sql_common
              where bn_id = '$bn_id' ";
    $result = sql_query($sql);
}

// 같은 그룹내 게시판 동일 옵션 적용
$s = "";
if ($chk_use) $s .= " , bn_use = '$bn_use' ";
if ($chk_target) $s .= " , bn_target = '$bb_target' ";
if ($chk_start_datetime) $s .= " , bn_start_datetime = '$bn_start_datetime' ";
if ($chk_end_datetime) $s .= " , bn_end_datetime = '$bn_end_datetime' ";
for ($i=1; $i<=10; $i++) {
    if ($_POST["chk_{$i}"]) {
        $s .= " , bn_{$i}_subj = '".$_POST["bn_{$i}_subj"]."' ";
        $s .= " , bn_{$i} = '".$_POST["bn_{$i}"]."' ";
    }
}

if ($s) {
        $sql = " update $g4[banner_table]
                    set bn_id = bn_id 
                        {$s}
                  where bg_id = '$bg_id' ";
        sql_query($sql);
}


if ($_FILES[bn_image][name]) { 
    $bn_image_path = "$banner_path/$bn_image_urlencode";
    move_uploaded_file($_FILES[bn_image][tmp_name], $bn_image_path);
    chmod($bn_image_path, 0606);
}

goto_url("./banner_form.php?w=u&bn_id=$bn_id$qstr");
?>
