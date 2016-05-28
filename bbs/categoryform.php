<?
include_once("./_common.php");
include_once ("$g4[path]/lib/cheditor4.lib.php");

$sql_common = " from $g4[category_table] ";

if ($w == "") 
{
    if ($is_admin != 'super' && !$ca_id)
        alert("최고관리자만 1단계 분류를 추가할 수 있습니다.");

    $len = strlen($ca_id);
    if ($len == 10) 
        alert("분류를 더 이상 추가할 수 없습니다.\\n\\n5단계 분류까지만 가능합니다.");

    $len2 = $len + 1;

    $sql = " select MAX(SUBSTRING(ca_id,$len2,2)) as max_subid from $g4[category_table]
              where SUBSTRING(ca_id,1,$len) = '$ca_id' ";
    $row = sql_fetch($sql);

    $subid = base_convert($row[max_subid], 36, 10);
    $subid += 36;
    if ($subid >= 36 * 36) 
    {
        //alert("분류를 더 이상 추가할 수 없습니다.");
        // 빈상태로
        $subid = "  ";
    }
    $subid = base_convert($subid, 10, 36);
    $subid = substr("00" . $subid, -2);
    $subid = $ca_id . $subid;

    $sublen = strlen($subid);

    if ($ca_id) // 2단계이상 분류
    { 
        $sql = " select * from $g4[category_table] where ca_id = '$ca_id' ";
        $ca = sql_fetch($sql);
        $html_title = $ca[ca_name] . " 하위분류추가";
        $ca[ca_name] = "";
    } 
    else // 1단계 분류
    {
        $html_title = "1단계분류추가";
        $ca[ca_use] = 1;
        $ca[ca_explan_html] = 1;
        $ca[ca_list_mod] = 4;
        $ca[ca_list_row] = 5;
    }
} 
else if ($w == "u") 
{
    $sql = " select * from $g4[category_table] where ca_id = '$ca_id' ";
    $ca = sql_fetch($sql);
    if (!$ca[ca_id]) 
        alert("자료가 없습니다.");

    $html_title = $ca[ca_name] . " 수정";
    $ca[ca_name] = get_text($ca[ca_name]);
}

$qstr = "page=$page&sort1=$sort1&sort2=$sort2";

$g4[title] = $html_title;
include_once ("./_head.php");
?>

<link rel="stylesheet" href="<?=$g4['admin_path']?>/admin.style.css" type="text/css">

<?=subtitle("기본 입력")?>

<script type="text/javascript" src="<?=$g4[cheditor4_path]?>/cheditor.js"></script>
<?=cheditor1('ca_head_html', '100%', '150');?>
<?=cheditor1('ca_tail_html', '100%', '150');?>

<form name=fcategoryform method=post action="./categoryformupdate.php" enctype="multipart/form-data" onsubmit='return fcategoryformcheck(this);' style="margin:0px;">

<table cellpadding=0 cellspacing=0 width=100%>
<input type=hidden name=codedup  value="<?=$default[de_code_dup_use]?>">
<input type=hidden name=w        value="<?=$w?>">
<input type=hidden name=page     value="<?=$page?>">
<input type=hidden name=sort1    value="<?=$sort1?>">
<input type=hidden name=sort2    value="<?=$sort2?>">
<colgroup width=15%>
<colgroup width=35% bgcolor=#FFFFFF>
<colgroup width=15%>
<colgroup width=35% bgcolor=#FFFFFF>
<tr><td colspan=4 height=2 bgcolor=#0E87F9></td></tr>
<tr class=ht>
    <td height=28>분류코드</td>
    <td colspan=3>

    <? if ($w == "") { ?>
        <input type=text class=ed id=ca_id name=ca_id itemname='분류코드' size='<?=$sublen?>' maxlength='<?=$sublen?>' minlength='<?=$sublen?>' nospace alphanumeric value='<?=$subid?>'>
        <? if ($default[de_code_dup_use]) { ?><a href='javascript:;' onclick="codedupcheck(document.getElementById('ca_id').value)"><img src='./img/btn_code.gif' border=0 align=absmiddle></a><? } ?>
        <?=help("자동으로 보여지는 분류코드를 사용하시길 권해드리지만 직접 입력한 값으로도 사용할 수 있습니다.\n분류코드는 나중에 수정이 되지 않으므로 신중하게 결정하여 사용하십시오.\n\n분류코드는 2자리씩 10자리를 사용하여 5단계를 표현할 수 있습니다.\n0~z까지 입력이 가능하며 한 분류당 최대 1296가지를 표현할 수 있습니다.\n그러므로 총 3656158440062976가지의 분류를 사용할 수 있습니다.");?>
    <? } else { ?>
        <input type=hidden name=ca_id value='<?=$ca[ca_id]?>'><?=$ca[ca_id]?>
        <? echo icon("미리보기", "{$g4[shop_path]}/list.php?ca_id=$ca_id"); ?>
        <? echo "<a href='./categoryform.php?ca_id=$ca_id&$qstr' title='하위분류 추가'><img src='$g4[admin_path]/img/icon_insert.gif' border=0 align=absmiddle></a>"; ?>
        <a href='./itemlist.php?sca=<?=$ca[ca_id]?>'>상품리스트</a>
    <? } ?>

    </td>
</tr>
<tr class=ht>
    <td>분류명<font color="#ff6600"> <b>*</b></font></td>
    <td colspan=3><input type=text name=ca_name value='<? echo $ca[ca_name] ?>' size=38 required itemname="분류명" class=ed></td>
</tr>
<tr class=ht>
    <td>판매가능</td>
    <td colspan=3>
        <input type=checkbox name='ca_use' <? echo ($ca[ca_use]) ? "checked" : ""; ?> value='1'>예
        <?=help("잠시 판매를 중단하거나 재고가 없을 경우에 체크하면 이 분류명과 이 분류에 속한 상품은 출력하지 않으며 주문도 할 수 없습니다.");?>
    </td>
</tr>
<tr><td colspan=4 height=1 bgcolor=#CCCCCC></td></tr>
</table>


<p>
<?=subtitle("선택 입력")?>
<table cellpadding=0 cellspacing=0 width=100%>
<colgroup width=15%>
<colgroup width=85% bgcolor=#FFFFFF>
<tr><td colspan=4 height=2 bgcolor=#0E87F9></td></tr>
<tr class=ht>
    <td>상단 파일 경로</td>
    <td colspan=3><input type=text class=ed name=ca_include_head size=60 value="<?=$ca[ca_include_head]?>"> <?=help("분류별로 상단+좌측의 내용이 다를 경우 상단+좌측 디자인 파일의 경로를 입력합니다.<p>입력이 없으면 기본 상단 파일을 사용합니다.<p>상단 내용과 달리 PHP 코드를 사용할 수 있습니다.");?></td>
</tr>
<tr class=ht>
    <td>하단 파일 경로</td>
    <td colspan=3><input type=text class=ed name=ca_include_tail size=60 value="<?=$ca[ca_include_tail]?>"> <?=help("분류별로 하단+우측의 내용이 다를 경우 하단+우측 디자인 파일의 경로를 입력합니다.<p>입력이 없으면 기본 하단 파일을 사용합니다.<p>하단 내용과 달리 PHP 코드를 사용할 수 있습니다.");?></td>
</tr>
<tr class=ht>
    <td>상단이미지</td>
    <td colspan=3>
        <input type=file class=ed name=ca_himg size=40>
        <?
        $himg_str = "";
        $himg = "{$category_path}/{$ca[ca_id]}_h";
        if (file_exists($himg)) 
        {
            echo "<input type=checkbox name=ca_himg_del value='1'>삭제";
            $himg_str = "<img src='$himg' border=0>";
            //$size = getimagesize($himg);
            //echo "<img src='$g4[admin_path]/img/icon_viewer.gif' border=0 align=absmiddle onclick=\"imageview('himg', $size[0], $size[1]);\">";
            //echo "<div id='himg' style='left:0; top:0; z-index:+1; display:none; position:absolute;'><img src='$himg' border=1></div>";
        }
        ?>
        <?=help("상품리스트 페이지 상단에 출력하는 이미지입니다.");?>
    </td>
</tr>
<? if ($himg_str) { echo "<tr><td colspan=4>$himg_str</td></tr>"; } ?>

<tr class=ht>
    <td>하단이미지</td>
    <td colspan=3>
        <input type=file class=ed name=ca_timg size=40>
        <?
        $timg_str = "";
        $timg = "{$category_path}/{$ca[ca_id]}_t";
        if (file_exists($timg)) {
            echo "<input type=checkbox name=ca_timg_del value='1'>삭제";
            $timg_str = "<img src='$timg' border=0>";
            //$size = getimagesize($timg);
            //echo "<img src='$g4[admin_path]/img/icon_viewer.gif' border=0 align=absmiddle onclick=\"imageview('timg', $size[0], $size[1]);\"><input type=checkbox name=ca_timg_del value='1'>삭제";
            //echo "<div id='timg' style='left:0; top:0; z-index:+1; display:none; position:absolute;'><img src='$timg' border=1></div>";
        }
        ?>
        <?=help("상품리스트 페이지 하단에 출력하는 이미지입니다.");?>
    </td>
</tr>
<? if ($timg_str) { echo "<tr><td colspan=4>$timg_str</td></tr>"; } ?>

<tr class=ht>
    <td>상단 내용 <?=help("상품리스트 페이지 상단에 출력하는 HTML 내용입니다.", -150);?> </td>
    <td colspan=3 align=right><br /><?=cheditor2('ca_head_html', $ca[ca_head_html]);?></td>
</tr>
<tr class=ht>
    <td>하단 내용 <?=help("상품리스트 페이지 하단에 출력하는 HTML 내용입니다.", -150);?></td>
    <td colspan=3 align=right><br /><?=cheditor2('ca_tail_html', $ca[ca_tail_html]);?></td>
</tr>
<tr><td colspan=4 height=1 bgcolor=#CCCCCC></td></tr>
</table>


<? if ($w == "u") { ?>
<p>
<?=subtitle("기타")?>
<table cellpadding=0 cellspacing=0 width=100%>
<colgroup width=15%>
<colgroup width=85% bgcolor=#FFFFFF>
<tr><td colspan=4 height=2 bgcolor=#0E87F9></td></tr>
<tr class=ht>
    <td>하위분류</td>
    <td colspan=3>
        <input type=checkbox name=sub_category value='1' onclick="if (this.checked) if (confirm('이 분류에 속한 하위 분류의 속성을 똑같이 변경합니다.\n\n이 작업은 되돌릴 방법이 없습니다.\n\n그래도 변경하시겠습니까?')) return ; this.checked = false;"> 이 분류의 설정과 같은 설정으로 반영
        <?=help("이 분류의 코드가 10 이라면 10 으로 시작하는 하위분류의 설정값을 이 분류와 동일하게 설정합니다.", 0, -100);?>
    </td>
</tr>
<tr><td colspan=4 height=1 bgcolor=#CCCCCC></td></tr>
</table>
<? } ?>


<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>&nbsp;
    <input type=button class=btn1 accesskey='l' value='  목  록  ' onclick="document.location.href='./categorylist.php?<?=$qstr?>';">
</form>

<script language='javascript'>
function fcategoryformcheck(f)
{
    <?=cheditor3('ca_head_html');?>
    <?=cheditor3('ca_tail_html');?>

    if (f.w.value == "") {
        if (f.codedup.value == '1') {
            alert("코드 중복검사를 하셔야 합니다.");
            return false;
        }
    }

    return true;
}

function codedupcheck(id) 
{
    if (!id) {
        alert('분류코드를 입력하십시오.');
        f.ca_id.focus();
        return;
    }

    window.open("./codedupcheck.php?ca_id="+id+'&frmname=fcategoryform', "hiddenframe");
}

document.fcategoryform.ca_name.focus();
</script>

<iframe name='hiddenFrame' width=0 height=0></iframe>

<?
include_once ("./_tail.php");
?>
