<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 게시판 목록별로 정렬하기
$str = "<select name='bo_table' onchange=\"location='$PHP_SELF?head_on=$head_on&mnb=$mnb&snb=$snb&sfl=bo_table&stx='+this.value;\">";
$str .= "<option value='all'>전체목록보기</option>";
for ($i=0; $i<count($bo_list); $i++) {
    $str .= "<option value='{$bo_list[$i][bo_table]}'";
    if ($sfl=='bo_table' and $bo_list[$i][bo_table] == $stx) $str .= " selected";
    $str .= ">{$bo_list[$i][bo_subject]}</option>";
}
$str .= "</select>";
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>


<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<form name=fsearch method=get>
<input type=hidden name=head_on value=<?=$head_on?>>
<input type=hidden name=mnb value=<?=$mnb?>>
<input type=hidden name=snb value=<?=$snb?>>

<tr> 
    <td height="40" width="400" align="left">
    <a href="<?=$PHP_SELF?>?<?=$mstr?>">처음</a>&nbsp;&nbsp;<?=$str?>&nbsp;&nbsp;<?=$memo_str_list?>
    </td>
</tr>
</form>
</table>

<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr> 
    <td height="200" align="center" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td height="2" bgcolor="#808080"></td>
        </tr>
        <tr> 
            <td width="98%" bgcolor="#FFFFFF">
                <table width=100% cellpadding=1 cellspacing=1 border=0>
                <colgroup width=60>
                <colgroup width=120>
                <colgroup width=''>
                <colgroup width=80>
                <colgroup width=80>
                <colgroup width=50>
                <tr bgcolor=#E1E1E1 align=center> 
                    <td height="24" align=center><b>번호</b></td>
                    <td><b>게시판</b></td>
                    <td><b>제목</b></td>
                    <td><b>글쓴이</b></td>
                    <td><b>추천일시</b></td>
                    <td><b>삭제</b></td>
                </tr>

                <? for ($i=0; $i<count($list); $i++) { ?>
                    <tr height=25 bgcolor="#F6F6F6" align="center"> 
                        <td height="24"><?=$list[$i][num]?></td>
                        <td>
                        <? if ($head_on) { ?>
                            <a href="<?=$list[$i][opener_href]?>">
                        <? } else { ?>
                            <a href="javascript:;" onclick="opener.document.location.href='<?=$list[$i][opener_href]?>';">
                        <? } ?>
                        <?=$list[$i][bo_subject]?></a>
                        </td>
                        <? // 비밀글인 스크랩의 경우 비밀글 아이콘을 앞에 표시
                        if ($list[$i][secret]) 
                            $secret_icon = "<img src='$member_skin_path/img/icon_secret.gif'>";
                        else
                            $secret_icon = "";
                        ?>
                        <td align="left" style='word-break:break-all;'><?=$secret_icon?>&nbsp;
                        <? if ($head_on) { ?>
                            <a href="<?=$list[$i][opener_href_wr_id]?>" title="<?=$list[$i][subject]?>">
                        <? } else { ?>
                            <a href="javascript:;" onclick="opener.document.location.href='<?=$list[$i][opener_href_wr_id]?>';" title="<?=$list[$i][subject]?>">
                        <? } ?>
                        <?=cut_str($list[$i][wr_subject],65)?></a></td>
                        <td><?=$list[$i][mb_nick]?></td>
                        <td><?=cut_str($list[$i][bg_datetime],10, '')?></td>
                        <td>
                        <? if ($list[$i][del_href]) { ?>
                        <a href="javascript:del('<?=$list[$i][del_href]?>');"><img src="<?=$member_skin_path?>/img/btn_comment_delete.gif" width="45" height="14" border="0"></a>
                        <? } ?>
                        </td>
                    </tr>
                <? } ?>

                <? if ($i == 0) echo "<tr><td colspan=5 align=center height=100>자료가 없습니다.</td></tr>"; ?>
                </table></td>
        </tr>
        </table></td>
</tr>
<tr> 
    <td height="30" align="center"><?=get_paging($config[cf_write_pages], $page, $total_page, "?$qstr&page=");?></td>
</tr>
<tr> 
    <td height="2" align="center" valign="top" bgcolor="#D5D5D5"></td>
</tr>
<tr>
    <td height="2" align="center" valign="top" bgcolor="#E6E6E6"></td>
</tr>
<? if (!$head_on) { ?>
<tr>
    <td height="30" align="center" valign="bottom"><a href="javascript:window.close();"><img src="<?=$member_skin_path?>/img/btn_close.gif" width="48" height="20" border="0"></a></td>
</tr>
<? } ?>
</table>
