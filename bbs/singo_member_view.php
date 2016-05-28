<?
include_once("./_common.php");

include_once("$g4[path]/head.sub.php");

// 회원인지 검사하여 회원이 아닌 경우에는 로그인 페이지로 이동한다.
if (!$member[mb_id]) 
    alert("회원만 신고 화면을 볼 수 있습니다.");

    
// 신고 정보 조회
if (!$is_admin)
    $sql_where = " and sg_mb_id = '$member[mb_id]' ";

$singo = sql_fetch(" select * from $g4[singo_table] where sg_id = '$sg_id' $sql_where ");

?>

<table width=100% cellpadding=5 cellspacing=0 border=0>
<colgroup width=90>
<colgroup >
<tr>
    <td colspan=2>
    회원 신고 내역 조회
    </td>
</tr>
<tr class='ht'><td colspan=2 height=10></td></tr>
<tr>
    <td>신고한 회원</td>
    <td><?=$singo['sg_mb_id']?></td>
</tr>
<tr>
    <td>신고된 회원</td>
    <td><?=$singo['mb_id']?></td>
</tr>
<tr>
    <td>신고 일시</td>
    <td class="style5" ><?=$singo['sg_datetime']?></td>
</tr>
<tr>
    <td>신고 사유</td>
    <td><?=$singo['sg_reason']?></td>
</tr>

</table>
<?
?>
