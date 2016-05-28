<?
include_once("./_common.php");

$g4[title] = "회원신고";
include_once("./_head.php");

if (!$is_member)
    alert("회원만 사용가능한 기능 입니다.");
?>

<script type="text/javascript"> 
<!-- // 회원ID 찾기  
function popup_id(frm_name, ss_id, top, left) 
{ 
    url = './write_id.php?frm_name='+frm_name+'&ss_id='+ss_id; 
    opt = 'scrollbars=yes,width=320,height=470,top='+top+',left='+left; 
    window.open(url, "write_id", opt); 
} 
//--> 
</script> 

<?
    include_once("$g4[path]/lib/cheditor4.lib.php");
    echo "<script type='text/javascript' src='$g4[cheditor4_path]/cheditor.js'></script>";
    echo cheditor1('sg_reason', '100%', '250');
?>

<form name=fsingo method=post onsubmit="return fsingo_submit(this);" enctype="multipart/form-data" autocomplete="off">
<input type=hidden value="@user" name="bo_table">

<table width=98% cellpadding=0 cellspacing=0>
<colgroup width=90>
<colgroup >
    <tr>
        <td colspan=2 style='padding-left:20px; height:30px;'>
        회원신고
        </td>
    </tr>
    <tr class='ht'><td colspan=2 height=10></td></tr>
    <tr class='ht' height=30px>
        <td style='padding-left:20px; height:30px;'>
        신고할 회원
        </td>
        <td>
        <input type='text' name='singo_mb_id' style="width:200px;" class=input required maxlength="20" itemname='이름' readonly>
        <a href="javascript:popup_id('fsingo','singo_mb_id',200,500);">회원검색</a>
        </td>
    </tr>
    <tr class='ht'>
        <td style='padding-left:20px; height:30px;'>
        신고사유
        </td>
        <td>
            <?=cheditor2('sg_reason', '신고할 내용을 자세히 적어주세요.');?>
        </td>
    </tr>
    <tr class='ht'><td colspan=2 height=10></td></tr>
    <tr class='ht'>
        <td>
        </td>
        <td >
        * 회원신고 기능은 사이트 활동에 있어서 문제되는 활동을 하는 회원을 신고하기 위함 입니다. <br>
        * 충분한 근거가 없이 타인을 신고하는 경우 신고자에게 불이익이 돌아갈 수도 있습니다.<br>
        * 신고된 회원은 운영자의 검토와 소명의 절차를 거친 후 회원규약에 따라 조치할 것 입니다.<br>
        * 나의 행동이 타인으로 하여금 문제되는 행동을 유발하지 않았는지 숙고해 보시기 바랍니다.
        </td>
    </tr>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>&nbsp;
    <input type=button class=btn1 value='  취  소  ' onclick="document.location.href='./singo_member.php?<?=$qstr?>';">

</form>

<script language='Javascript'>
    function fsingo_submit(f)
    {
        <?
        echo cheditor3('sg_reason');
        echo "if (!document.getElementById('sg_reason').value) { alert('내용을 입력하십시오.'); return; } ";
        ?>
            
        f.action = './singo_member_update.php';
        return true;
    }
</script>

<?
include_once("./_tail.php");
?>
