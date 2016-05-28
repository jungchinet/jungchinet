<? 
//
// 조병완(korone)님 , 남규아빠(eagletalon)님께서 만들어 주셨습니다.
//

$sub_menu = "100400"; 
include_once("./_common.php"); 

auth_check($auth[$sub_menu], "r");

$g4[title] = "버전확인"; 

include_once("./admin.head.php"); 
include_once("$g4[path]/lib/mailer.lib.php"); 

$handle = @fopen("$g4[path]/HISTORY", "r");
if ($handle) {
    $buffer = fgetss($handle, 4096);
    fclose($handle);
}

echo "현재버전 : <b>";
echo "$buffer";
echo "</b>";
?> 

<table width=100% border="0" align="left" cellpadding="0" cellspacing="0"> 
<tr> 
    <td> 
        <textarea name="textarea" style='width:100%; line-height:150%; padding:10px;' rows="25" class=tx readonly><?=implode("", file("$g4[path]/HISTORY"));?></textarea> 
    </td> 
</tr> 
<tr>
    <td>
    현재버전정보는 HISTORY 파일의 첫줄을 읽어서 그대로 보여주는 것 입니다.<br>
    버전업을 했슴에도 버전정보가 변경되지 않았다면 HISTORY 파일을 업글 하시기 바랍니다.
    </td>
</tr>
</table> 

<? 
include_once("./admin.tail.php"); 
?> 
