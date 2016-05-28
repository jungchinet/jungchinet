<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<!-- 로그인 후 외부로그인 시작 -->
<table width="100%" border="0" cellpadding="0" cellspacing="1" style='border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px;border:solid 1px #ddd;'>
<tr>
<td width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr> 
    <td>
        <table width="100%" height="27" border="0" cellpadding="0" cellspacing="0">
        <tr> 
            <td width="10" height="27">&nbsp;</td>
            <td width="" height="27"><a href='#board' onclick="win_profile('<?=$member[mb_id]?>');"><span class='member'><strong><?=$nick?></strong></span></a>&nbsp;<img src="<?=$outlogin_skin_path?>/img/<?=$member[mb_level]?>.gif"></td>
            <td height="27">
            <? if ($g4['member_suggest_join']) { ?>
            <span class="btn_pack small"><a href="<?=$g4['g4_path']?>/plugin/recommend/index.php">추천</a></span>
            <? } ?>
            <? if($is_admin){ ?>
            <? if ($config[cf_use_recycle]) { ?>
            <span class="btn_pack small"><a href="/bbs/board.php?bo_table=delete01">휴지통</a></span>
            <span class="btn_pack small"><a href="<?=$g4['bbs_path']?>/recycle_list.php">휴지통2</a></span>
            <? } ?>
            <? } ?>
            </td>
        </tr>
      </table></td>
</tr>
<? if ($config[cf_use_point]) { ?>
<tr> 
    <td width="100%" height="20" align="left">&nbsp;&nbsp;<a href="javascript:win_memo('', '<?=$member[mb_id]?>', '<?=$_SERVER[SERVER_NAME]?>');" onfocus="this.blur()">쪽지(<?=$memo_not_read?>)</a>&nbsp;<a href="javascript:win_point();" onfocus="this.blur()"><font color="#737373"><?=$point?>점</font></a>
        <? if ($is_admin == "super" || $is_auth) { ?><span class="btn_pack small"><a href="<?=$g4[admin_path]?>/" onfocus="this.blur()">Admin</a></span><? } ?>
    </td>
</tr>
<? } ?>
<tr> 
    <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td width="100%" align="center">
                <table width="100%" height="25" border="0" cellpadding="1" cellspacing="0" align="center">
                <tr> 
                    <td width="58" align="center"><a href="javascript:win_scrap();" onfocus="this.blur()"><img src="<?=$outlogin_skin_path?>/img/scrap_button.gif" width="51" height="20" border="0"></a></td>
                    <td width="58" align="center"><a href="<?=$g4[bbs_path]?>/member_confirm.php?url=register_form.php" onfocus="this.blur()"><img src="<?=$outlogin_skin_path?>/img/login_modify.gif" width="51" height="20" border="0"></a></td>
                    <td width="58" align="center"><a href="<?=$g4[bbs_path]?>/logout.php?url=<?=$urlencode?>" onfocus="this.blur()"><img src="<?=$outlogin_skin_path?>/img/logout_button.gif" width="51" height="20" border="0"></a></td>
			   </tr>
               </table>
			</td>
        </tr>
        </table></td>
</tr>

<?
$my_menu = array();
$sql = "select m.bo_table, b.bo_subject from $g4[my_menu_table] as m left join $g4[board_table] as b on m.bo_table = b.bo_table where mb_id = '$member[mb_id]' order by m.id desc limit 0,2";
$qry = sql_query($sql);
while ($row = sql_fetch_array($qry))
{
    $my_menu[] = $row;
}

if (count($my_menu) > 0) { 
?>

<tr><td>
<div style='width:100%;'>
<div style='width:47%;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px;border:solid 2px #CCC;text-align:center;float:left;'><a href='<?=$g4[path]?>/bbs/board.php?bo_table=<?=$my_menu[0][bo_table]?>'><?=$my_menu[0][bo_subject]?></a></div>
<? if($my_menu[1][bo_subject]){ ?>
<div style='width:47%;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px;border:solid 2px #CCC;text-align:center;float:right;'><a href='<?=$g4[path]?>/bbs/board.php?bo_table=<?=$my_menu[1][bo_table]?>'><?=$my_menu[1][bo_subject]?></a></div>
<? } ?>
</div>
<!--select class=quick_move onchange="quick_move(this.value)">
<option value="">게시판 바로가기</option>
<option value="">-------------------------</option>
<? for ($i=0; $i<count($my_menu); $i++) {?>
<option value="<?=$my_menu[$i][bo_table]?>"><?=$my_menu[$i][bo_subject]?></option>
<? } ?>
<option value="">-------------------------</option>
<option value="menu-edit">바로가기 편집</option>
</select-->
</td></tr>

<script language="JavaScript">
function quick_move(bo_table)
{
    if (!bo_table) return;
    if (bo_table == 'menu-edit') {
        popup_window("<?=$g4[bbs_path]?>/my_menu_edit.php", "my_menu_edit", "width=350, height=400, scrollbars=1");
        return;
    }
    if (bo_table == 'mypage') {
        location.href = "<?=$g4[path]?>/customer/mypage.php";
        return;
    }
    location.href = "<?=$g4[bbs_path]?>/board.php?bo_table=" + bo_table;
}
</script>

<? } ?>

</table>
</td>
</tr>
</table>
<script language="JavaScript">
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave() 
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?")) 
            location.href = "<?=$g4[bbs_path]?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- 로그인 후 외부로그인 끝 -->
