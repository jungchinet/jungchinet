function check_all(f)
{
    var chk = document.getElementsByName("chk[]");

    for (i=0; i<chk.length; i++)
        chk[i].checked = f.chkall.checked;
}

function btn_check(f, act)
{
    if (act == "update") // 선택수정
    { 
        f.action = list_update_php;
        str = "수정";
    } 
    else if (act == "delete") // 선택삭제
    { 
        f.action = list_delete_php;
        str = "삭제";
    } 
    else
        return;

    var chk = document.getElementsByName("chk[]");
    var bchk = false;

    for (i=0; i<chk.length; i++)
    {
        if (chk[i].checked)
            bchk = true;
    }

    if (!bchk) 
    {
        alert(str + "할 자료를 하나 이상 선택하세요.");
        return;
    }

    if (act == "delete")
    {
        if (!confirm("선택한 자료를 정말 삭제 하시겠습니까?"))
            return;
    }

    f.submit();
}

function member_group_update(str, uid, type) 
{ 
var f = document.fmemberG_list; 

var orign_group = f.elements["groupName_["+type+"]"].value; 

if (orign_group != str) 
{ 
if (!confirm('\n이미 회원이 가입된 그룹의 명칭을 임의로 변경할 경우\n\n해당그룹의 회원들에게 혼란을 줄 수 있습니다.\n\n그래도 그룹명칭을 변경하시겠습니까?              \n')) 
{ 
return false; 
} 
} 
else { 
if (!confirm('정말로 변경 변경하시겠습니까? \n')) 
{ 
return false; 
} 
} 

location.href = "./memberGroup_form_update.php?w=u&gl_id=" + uid + "&gl_name=" + orign_group; 

} 
