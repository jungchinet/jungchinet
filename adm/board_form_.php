<?
$sub_menu = "300100";
include_once("./_common.php");
include_once ("$g4[path]/lib/cheditor4.lib.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

function b_draw($pos, $color='red') {
    return "border-{$pos}-width:1px; border-{$pos}-color:{$color}; border-{$pos}-style:solid; ";
}

$sql = " select count(*) as cnt from $g4[group_table] ";
$row = sql_fetch($sql);
if (!$row[cnt])
    alert("게시판그룹이 한개 이상 생성되어야 합니다.", "./boardgroup_form.php");

$html_title = "게시판";
if ($w == "") {
    $html_title .= " 생성";

    $bo_table_attr = "required alphanumericunderline";

    $board[bo_count_delete] = '1';
    $board[bo_count_modify] = '1';
    $board[bo_read_point] = $config[cf_read_point];
    $board[bo_write_point] = $config[cf_write_point];
    $board[bo_comment_point] = $config[cf_comment_point];
    $board[bo_download_point] = $config[cf_download_point];

    $board[bo_gallery_cols] = '4';
    $board[bo_table_width] = '97';
    $board[bo_page_rows] = $config[cf_page_rows];
    $board[bo_subject_len] = '60';
    $board[bo_new] = '24';
    $board[bo_hot] = '100';
    $board[bo_image_width] = '600';
    $board[bo_upload_count] = '2';
    $board[bo_upload_size] = '1048576';
    $board[bo_reply_order] = '1';
    $board[bo_use_search] = '1';
    $board[bo_skin] = 'cheditor';
    $board[gr_id] = $gr_id;
    $board[bo_disable_tags] = "script|iframe";
    $board[bo_use_secret] = 0;
    
    // 불당팩
    $board[bo_use_dhtml_editor] = '1';
    $board[bo_use_dhtml_comment] = '0';

    $board[bo_use_sideview] = '1';
    $board[bo_use_comment] = '1';
    $board[bo_use_list_view] = '1';
    
    $board[bo_write_level] = '2';
    $board[bo_reply_level] = '2';
    $board[bo_comment_level] = '2';
    $board[bo_html_level] = '2';
    $board[bo_html_level_comment] = '11';
    $board[bo_dhtml_editor_level] = '2';
    $board[bo_dhtml_editor_level_comment] = '11';
    $board[bo_link_level] = '2';
    $board[bo_upload_level] = '2';    
    $board[bo_download_level] = '2';    
    
    $board[bo_singo_action] = '1';
    $board[bo_popular_days] = '0';
    
    $board[bo_include_head] = './_head.php';    
    $board[bo_include_tail] = './_tail.php';    

} else if ($w == "u") {
    $html_title .= " 수정";

    if (!$board[bo_table])
        alert("존재하지 않은 게시판 입니다.");

    if ($is_admin == "group") {
        if ($member[mb_id] != $group[gr_admin]) 
            alert("그룹이 틀립니다.");
    }

    $bo_table_attr = "readonly style='background-color:#dddddd'";
}

if ($is_admin != "super") {
    $group = get_group($board[gr_id]);
    $is_admin = is_admin($member[mb_id]);
}


//rss_opt OPTION CREATE
if($board[bo_category_list]){
    $rssTmp1=explode('|', $board[bo_category_list]);
    $rssCnt1=count($rssTmp1);

    $rssOpt1="<option value='0'>선택하세요</option>";
    for($z=0;$z<$rssCnt1;$z++){
        $rssOpt1.="<option value='{$rssTmp1[$z]}'>{$rssTmp1[$z]}</option>";
    }
}

if($board[bo_1]){
    $rssTmp2=explode(',', $board[bo_1]);
    $rssCnt2=count($rssTmp2);

    $rssOpt2="<option value='0'>선택하세요</option>";
    for($z=0;$z<$rssCnt2;$z++){
        $rssOpt2.="<option value='{$rssTmp2[$z]}'>{$rssTmp2[$z]}</option>";
    }
}






$tmp_write_table = $g4[write_prefix] . $bo_table;

$g4[title] = $html_title;
include_once ("./admin.head.php");
?>

<script type="text/javascript" src="<?=$g4[cheditor4_path]?>/cheditor.js"></script>
<?=cheditor1('bo_content_head', '100%', '200');?>
<?=cheditor1('bo_content_tail', '100%', '200');?>
<?=cheditor1('bo_insert_content', '100%', '250');?>

<form name=fboardform method=post onsubmit="return fboardform_submit(this)" enctype="multipart/form-data">
<input type=hidden name="w"     value="<?=$w?>">
<input type=hidden name="sfl"   value="<?=$sfl?>">
<input type=hidden name="stx"   value="<?=$stx?>">
<input type=hidden name="sst"   value="<?=$sst?>">
<input type=hidden name="sod"   value="<?=$sod?>">
<input type=hidden name="page"  value="<?=$page?>">
<input type=hidden name="token" value="<?=$token?>">
<input type=hidden name="gr_id_2" value="<?=$board[gr_id]?>">

<table width=100% cellpadding=0 cellspacing=0 border=0>
<colgroup width=5% class='left'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=75% class='col2 pad2'>
<tr>
    <td colspan=3 class=title align=left><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> <?=$html_title?></td>
</tr>
<tr><td colspan=3 class='line1'></td></tr>
<tr class='ht'>
    <td></td>
    <td>TABLE</td>
    <td><input type=text class=ed name=bo_table size=30 maxlength=20 <?=$bo_table_attr?> itemname='TABLE' value='<?=$board[bo_table] ?>'>
        <? 
        if ($w == "") 
            echo "영문자, 숫자, _ 만 가능 (공백없이 20자 이내)";
        else 
            echo "<a href='$g4[bbs_path]/board.php?bo_table=$board[bo_table]'><img src='$g4[admin_path]/img/icon_view.gif' border=0 align=absmiddle></a>";
        ?>
    </td>
</tr>
<tr class='ht'>
    <td></td>
    <td>그룹</td>
    <td>
        <?=get_group_select('gr_id', $board[gr_id], "required itemname='그룹'");?>
        <? if ($w=='u') { ?><a href="javascript:location.href='./board_list.php?sfl=a.gr_id&stx='+document.fboardform.gr_id.value;">동일그룹게시판목록</a><?}?></td>
</tr>
<tr class='ht'>
    <td></td>
    <td>게시판 제목</td>
    <td>
        <input type=text class=ed name=bo_subject size=60 maxlength=120 required itemname='게시판 제목' value='<?=get_text($board[bo_subject])?>'>
    </td>
</tr>
<tr class='ht'>
    <td></td>
    <td>상단우측 링크</td>
    <td>
        <input type=text class=ed name=bo_rtlink size=300 maxlength=120 itemname='상단우측 링크' value='<?=get_text($board[bo_rtlink])?>' style='width:80%;'>
    </td>
</tr>
<tr class='ht'>
    <td></td>
    <td>상단 이미지</td>
    <td>
        <input type=file name=bo_image_head class=ed size=60>
        <?
        if ($board[bo_image_head])
            echo "<br><a href='$g4[data_path]/file/{$board['bo_table']}/$board[bo_image_head]' target='_blank'>$board[bo_image_head]</a> <input type=checkbox name='bo_image_head_del' value='$board[bo_image_head]'> 삭제";
        ?>
    </td>
</tr>
<tr class='ht'>
    <td></td>
    <td>하단 이미지</td>
    <td>
        <input type=file name=bo_image_tail class=ed size=60>
        <? 
        if ($board[bo_image_tail]) 
            echo "<br><a href='$g4[data_path]/file/{$board['bo_table']}/$board[bo_image_tail]' target='_blank'>$board[bo_image_tail]</a> <input type=checkbox name='bo_image_tail_del' value='$board[bo_image_tail]'> 삭제";
        ?>
    </td>
</tr>

<? if ($w == "u") { ?>
<tr class='ht'>
    <td></td>
    <td>카운트 조정</td>
    <td>
        <input type=checkbox name=proc_count value=1> 카운트를 조정합니다.
        (현재 원글수 : <?=number_format($board[bo_count_write])?> , 현재 코멘트수 : <?=number_format($board[bo_count_comment])?>)
        <?=help("게시판 목록에서 글의 번호가 맞지 않을 경우에 체크하십시오.")?>
    </td>
</tr>
<? } ?>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td>
        <input type=checkbox name=chk_use_premium value=1>
    </td>
    <td>프리미엄리스트 사용여부</td>
    <td><input type=checkbox name=bo_use_premium value='1' <? if($board[bo_use_premium]){ echo 'checked'; } ?>> 사용하실 경우 체크하세요.</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td>
        <input type=checkbox name=chk_use_thumb value=1>
    </td>
    <td>강제 썸네일 출력</td>
    <td><input type=checkbox name=bo_use_thumb value='1' <? if($board[bo_use_thumb]){ echo 'checked'; } ?>> 사용하실 경우 체크하세요.</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td>
        <input type=checkbox name=chk_thumb_percent value=1>
    </td>
    <td>썸네일 품질</td>
    <td><input type=text class=ed name=bo_thumb_percent maxlength=20 value='<?=$board[bo_thumb_percent]?>'> 강제 썸네일 사용시 반영 (0~100)</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td>
        <input type=checkbox name=chk_thumb_width value=1>
    </td>
    <td>썸네일 가로사이즈</td>
    <td><input type=text class=ed name=bo_thumb_width maxlength=20 value='<?=$board[bo_thumb_width]?>'> 강제 썸네일 사용시 반영</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>

<tr class='ht'>
    <td>
        <input type=checkbox name=chk_admin value=1>
        <?=help("같은 그룹에 속한 게시판의 설정을 동일하게 변경할 경우에 체크합니다.");?>
    </td>
    <td>게시판 관리자</td>
    <td><input type=text class=ed name=bo_admin maxlength=20 value='<?=$board[bo_admin]?>'></td>
</tr>

<?

//RSS 주소과 옵션
$rssSql="select * from rss_info where bo_table='$bo_table' and idx<900 order by idx asc";
$rssRst=mysql_query($rssSql);
$rssNum=mysql_num_rows($rssRst);

//RSS 클릭 시 원글 링크여부
$rssSql2="select rss_addr from rss_info where bo_table='$bo_table' and idx=999 limit 1";
$rssRst2=mysql_query($rssSql2);
$rssRst2=mysql_fetch_row($rssRst2);
$rss_olink=$rssRst2[0];

if($rss_olink==1){
    $olink_chk="checked='checked'";
}

//RSS 다시 읽는 주기
$rssSql3="select rss_addr from rss_info where bo_table='$bo_table' and idx=998 limit 1";
$rssRst3=mysql_query($rssSql3);
$rssRst3=mysql_fetch_row($rssRst3);
$rss_term=$rssRst3[0];

//제목 클릭 시 새창/현재창 / 1 : 새창, 2 : 현재창
$rssSql4="select rss_addr from rss_info where bo_table='$bo_table' and idx=997 limit 1";
$rssRst4=mysql_query($rssSql4);
$rssRst4=mysql_fetch_row($rssRst4);
$rss_target=$rssRst4[0];

if($rss_target==1){
    $target_chk="checked='checked'";
}


?>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><!--input type=checkbox name=chk_list_level value=1--></td>
    <td colspan='2'>
        <table id='hiddenrssTable' style='display:none;'>
            <tr class='ht'>
                <td style='width:80px;'>RSS 주소</td>
                <td>
                    <input type='text' class='ed' name='rss_addr[]' value='' style='width:230px;' />&nbsp;&nbsp;· 구분 <select name='rss_opt1[]'><?=$rssOpt1?></select>&nbsp;&nbsp;· 대상 <select name='rss_opt2[]'><?=$rssOpt2?></select>&nbsp;&nbsp;· 관심단어 <input type=text class=ed style='width:90px;' name=rss_opt3[] itemname='게시판 제목' value='<?=$r['rss_opt3']?>'>
                </td>
            </tr>
        </table>
        <table id='rssTable'>
        <? if($rssNum==0){ ?>
            <tr class='ht'>
                <td style='width:80px;'>RSS 주소 <span id='addBtn' style='cursor:pointer;'>+</span> <span id='delBtn' style='cursor:pointer;'>-</span></td>
                <td>
                    <input type='text' class='ed' name='rss_addr[]' value='' style='width:230px;' />&nbsp;&nbsp;· 구분 <select name='rss_opt1[]'><?=$rssOpt1?></select>&nbsp;&nbsp;· 대상 <select name='rss_opt2[]'><?=$rssOpt2?></select>&nbsp;&nbsp;· 관심단어 <input type=text class=ed style='width:90px;' name=rss_opt3[] itemname='게시판 제목' value='<?=$r['rss_opt3']?>'>
                </td>
            </tr>
        <? }else{

            $r=mysql_fetch_array($rssRst);

            if($board[bo_category_list]){
                $rssTmp1=explode('|', $board[bo_category_list]);
                $rssCnt1=count($rssTmp1);

                $rssOptRead1="<option value='0'>선택하세요</option>";
                for($z=0;$z<$rssCnt1;$z++){
                    $selected='';
                    if($rssTmp1[$z]==$r['rss_opt1']){ $selected="selected='selected'"; }
                    $rssOptRead1.="<option value='{$rssTmp1[$z]}' {$selected}>{$rssTmp1[$z]}</option>";
                }
            }

            if($board[bo_1]){
                $rssTmp2=explode(',', $board[bo_1]);
                $rssCnt2=count($rssTmp2);

                $rssOptRead2="<option value='0'>선택하세요</option>";
                for($z=0;$z<$rssCnt2;$z++){
                    $selected='';
                    if($rssTmp2[$z]==$r['rss_opt2']){ $selected="selected='selected'"; }
                    $rssOptRead2.="<option value='{$rssTmp2[$z]}' {$selected}>{$rssTmp2[$z]}</option>";
                }
            }



        ?>
            <tr class='ht'>
                <td style='width:80px;'>RSS 주소 <span id='addBtn' style='cursor:pointer;'>+</span> <span id='delBtn' style='cursor:pointer;'>-</span></td>
                <td>
                    <input type='text' class='ed' name='rss_addr[]' value='<?=$r['rss_addr']?>' style='width:230px;' />&nbsp;&nbsp;· 구분 <select name='rss_opt1[]'><?=$rssOptRead1?></select>&nbsp;&nbsp;· 대상 <select name='rss_opt2[]'><?=$rssOptRead2?></select>&nbsp;&nbsp;· 관심단어 <input type=text class=ed style='width:90px;' name=rss_opt3[] itemname='게시판 제목' value='<?=$r['rss_opt3']?>'>
                </td>
            </tr>
            <? while($r=mysql_fetch_array($rssRst)){ 

                if($board[bo_category_list]){
                    $rssTmp1=explode('|', $board[bo_category_list]);
                    $rssCnt1=count($rssTmp1);

                    $rssOptRead1="<option value='0'>선택하세요</option>";
                    for($z=0;$z<$rssCnt1;$z++){
                        $selected='';
                        if($rssTmp1[$z]==$r['rss_opt1']){ $selected="selected='selected'"; }
                        $rssOptRead1.="<option value='{$rssTmp1[$z]}' {$selected}>{$rssTmp1[$z]}</option>";
                    }
                }

                if($board[bo_1]){
                    $rssTmp2=explode(',', $board[bo_1]);
                    $rssCnt2=count($rssTmp2);

                    $rssOptRead2="<option value='0'>선택하세요</option>";
                    for($z=0;$z<$rssCnt2;$z++){
                        $selected='';
                        if($rssTmp2[$z]==$r['rss_opt2']){ $selected="selected='selected'"; }
                        $rssOptRead2.="<option value='{$rssTmp2[$z]}' {$selected}>{$rssTmp2[$z]}</option>";
                    }
                }

            ?>
                <tr class='ht'>
                    <td style='width:80px;'>RSS 주소</td>
                    <td>
                        <input type='text' class='ed' name='rss_addr[]' value='<?=$r['rss_addr']?>' style='width:230px;' />&nbsp;&nbsp;· 구분 <select name='rss_opt1[]'><?=$rssOptRead1?></select>&nbsp;&nbsp;· 대상 <select name='rss_opt2[]'><?=$rssOptRead2?></select>&nbsp;&nbsp;· 관심단어 <input type=text class=ed style='width:90px;' name=rss_opt3[] itemname='게시판 제목' value='<?=$r['rss_opt3']?>'>
                    </td>
                </tr>
            <? } ?>
        <? } ?>
        </table>
    </td>
</tr>

<script>
$(document).ready(function(){

    // 옵션추가 버튼 클릭시
    $("#addBtn").click(function(){

        // item 의 최대번호 구하기
        //var lastItemNo = $("#rssTable tr:last").attr("class").replace("item", "");

        var newitem = $("#hiddenrssTable tr:eq(0)").clone();
        //newitem.removeClass();
        //newitem.find("td:eq(0)").attr("rowspan", "1");
        //newitem.addClass("item"+(parseInt(lastItemNo)+1));

        $("#rssTable").append(newitem);
        //$("#rssTable tr:last").css('display','block');
    });

    // 삭제버튼 클릭시
    $("#delBtn").live("click", function(){

        if($("#rssTable tr").size()=='1'){
        
            alert('더 이상 삭제할 수 없습니다.');

        }else{

            $("#rssTable tr:last").remove();

        }

    });

})
</script>

<tr><td colspan=3 class='line2'></td></tr>

<tr class='ht'>
    <td></td>
    <td>제목 클릭 시 원글로 링크</td>
    <td>
        <input type=checkbox name=rss_olink value=1 <?=$olink_chk?>>
    </td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>

<tr class='ht'>
    <td></td>
    <td>제목 클릭 시 새창으로 띄우기</td>
    <td>
        <input type=checkbox name=rss_target value=1 <?=$target_chk?>>
    </td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>

<tr class='ht'>
    <td></td>
    <td>다시 읽는 주기</td>
    <td>
        <input type=text class=ed name=rss_term size=60 maxlength=120 itemname='다시 읽는 주기' value='<?=$rss_term?>'>분
    </td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_list_level value=1></td>
    <td>목록보기 권한</td>
    <td>
        <?=get_member_level_select('bo_list_level', 1, 10, $board[bo_list_level]) ?>
        <?=help("권한 1은 비회원, 2 이상 회원입니다.\n권한은 10 이 가장 높습니다.", 50)?>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_read_level value=1></td>
    <td>글읽기 권한</td>
    <td><?=get_member_level_select('bo_read_level', 1, 10, $board[bo_read_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_search_level value=1></td>
    <td>글검색 권한</td>
    <td><?=get_member_level_select('bo_search_level', 1, 10, $board[bo_search_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_write_level value=1></td>
    <td>글쓰기 권한</td>
    <td><?=get_member_level_select('bo_write_level', 1, 10, $board[bo_write_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_reply_level value=1></td>
    <td>글답변 권한</td>
    <td><?=get_member_level_select('bo_reply_level', 1, 10, $board[bo_reply_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_comment_level value=1></td>
    <td>코멘트쓰기 권한</td>
    <td><?=get_member_level_select('bo_comment_level', 1, 10, $board[bo_comment_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_comment_read_level value=1></td>
    <td>코멘트읽기 권한</td>
    <td><?=get_member_level_select('bo_comment_read_level', 0, 10, $board[bo_comment_read_level]) ?> (값을 0으로 설정하면 글읽기 권한과 동일한 권한으로 적용됩니다)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_link_level value=1></td>
    <td>링크 권한</td>
    <td><?=get_member_level_select('bo_link_level', 1, 10, $board[bo_link_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_upload_level value=1></td>
    <td>업로드 권한</td>
    <td><?=get_member_level_select('bo_upload_level', 1, 10, $board[bo_upload_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_download_level value=1></td>
    <td>다운로드 권한</td>
    <td><?=get_member_level_select('bo_download_level', 1, 10, $board[bo_download_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_html_level value=1></td>
    <td>HTML 쓰기 권한</td>
    <td><?=get_member_level_select('bo_html_level', 1, 10, $board[bo_html_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_html_level_comment value=1></td>
    <td>코멘트 HTML 쓰기 권한</td>
    <td><?=get_member_level_select('bo_html_level_comment', 2, 11, $board[bo_html_level_comment]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_dhtml_editor_level value=1></td>
    <td>HTML 에디터 쓰기 권한</td>
    <td><?=get_member_level_select('bo_dhtml_editor_level', 1, 10, $board[bo_dhtml_editor_level]) ?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_dhtml_editor_level_comment value=1></td>
    <td>코멘트 HTML 에디터 쓰기 권한</td>
    <td><?=get_member_level_select('bo_dhtml_editor_level_comment', 2, 11, $board[bo_dhtml_editor_level_comment]) ?></td>
</tr>
<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_count_modify value=1></td>
    <td>원글 수정 불가</td>
    <td>코멘트 <input type=text class=ed name=bo_count_modify size=3 required numeric itemname='원글 수정 불가 코멘트수' value='<?=$board[bo_count_modify]?>'>개 이상 달리면 수정불가</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_count_delete value=1></td>
    <td>원글 삭제 불가</td>
    <td>코멘트 <input type=text class=ed name=bo_count_delete size=3 required numeric itemname='원글 삭제 불가 코멘트수' value='<?=$board[bo_count_delete]?>'>개 이상 달리면 삭제불가</td>
</tr>
<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td></td>
    <td>포인트 설정</td>
    <td><input type=checkbox name="chk_point" onclick="set_point(this.form)"> 환경설정에 입력된 포인트로 설정</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_read_point value=1></td>
    <td>글읽기 포인트</td>
    <td><input type=text class=ed name=bo_read_point size=10 required itemname='글읽기 포인트' value='<?=$board[bo_read_point]?>'></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_write_point value=1></td>
    <td>글쓰기 포인트</td>
    <td><input type=text class=ed name=bo_write_point size=10 required itemname='글쓰기 포인트' value='<?=$board[bo_write_point]?>'></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_comment_point value=1></td>
    <td>코멘트쓰기 포인트</td>
    <td><input type=text class=ed name=bo_comment_point size=10 required itemname='답변, 코멘트쓰기 포인트' value='<?=$board[bo_comment_point]?>'></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_download_point value=1></td>
    <td>다운로드 포인트</td>
    <td><input type=text class=ed name=bo_download_point size=10 required itemname='다운로드 포인트' value='<?=$board[bo_download_point]?>'></td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_category_list value=1></td>
    <td>분류 </td>
    <td><input type=text class=ed name=bo_category_list style='width:80%;' value='<?=get_text($board[bo_category_list])?>'>
        <input type=checkbox name=bo_use_category value='1' <?=$board[bo_use_category]?'checked':'';?>><b>사용</b>
        <?=help("분류와 분류 사이는 | 로 구분하세요. (예: 질문|답변) 첫자로 #은 입력하지 마세요. (예: #질문|#답변 [X])", -120)?>
        <br><a href='javascript:;' onclick='board_form_category();'>카테고리힌트생성</a> <span id="bo_category_hint"></span>
        <script type="text/javascript">
        function board_form_category() {
            $.ajax({
                type: 'POST',
                url: 'board_form_category.php',
                data: {
                    'bo_table': '<?=$bo_table?>'
                },
                cache: false,
                async: false,
                success: function(result) {
                    var msg = $('#bo_category_hint');
                    msg.html( result );
                }
            });
        }
        </script>
    </td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_sideview value=1></td>
    <td>글쓴이 사이드뷰</td>
    <td><input type=checkbox name=bo_use_sideview value='1' <?=$board[bo_use_sideview]?'checked':'';?>>사용 (글쓴이 클릭시 나오는 레이어 메뉴)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_file_content value=1></td>
    <td>파일 설명 사용</td>
    <td><input type=checkbox name=bo_use_file_content value='1' <?=$board[bo_use_file_content]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_comment value=1></td>
    <td>코멘트 새창 사용</td>
    <td><input type=checkbox name=bo_use_comment value='1' <?=$board[bo_use_comment]?'checked':'';?>>사용 (코멘트수 클릭시 새창으로 보임)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_secret value=1></td>
    <td>비밀글 사용</td>
    <td>
        <select name=bo_use_secret id='bo_use_secret'>
        <option value='0'>사용하지 않음
        <option value='1'>체크박스
        <option value='2'>무조건
        </select>
        &nbsp;<?=help("'체크박스'는 글작성시 비밀글 체크가 가능합니다.\n\n'무조건'은 작성되는 모든글을 비밀글로 작성합니다. (관리자는 체크박스로 출력합니다.)\n\n스킨에 따라 적용되지 않을 수 있습니다.")?>
        <script type='text/javascript'>document.getElementById('bo_use_secret').value='<?=$board[bo_use_secret]?>';</script>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_dhtml_editor value=1></td>
    <td>DHTML 에디터 사용</td>
    <td>
        <input type=checkbox name=bo_use_dhtml_editor value='1' <?=$board[bo_use_dhtml_editor]?'checked':'';?>>사용
        &nbsp;<?=help("글작성시 내용을 DHTML 에디터 기능으로 사용할 것인지 설정합니다.\n\n스킨에 따라 적용되지 않을 수 있습니다.")?>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_use_dhtml_comment value=1></td>
    <td>코멘트 DHTML 에디터 사용</td>
    <td>
        <input type=checkbox name=bo_use_dhtml_comment value='1' <?=$board[bo_use_dhtml_comment]?'checked':'';?>>사용
        &nbsp;<?=help("코멘트 작성시 내용을 DHTML 에디터 기능으로 사용할 것인지 설정합니다.\n\n스킨에 따라 적용되지 않을 수 있습니다.")?>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_rss_view value=1></td>
    <td>RSS 보이기 사용</td>
    <td>
        <input type=checkbox name=bo_use_rss_view value='1' <?=$board[bo_use_rss_view]?'checked':'';?>>사용
        &nbsp;<?=help("비회원 글읽기가 가능하고 RSS 보이기 사용에 체크가 되어야만 RSS 지원을 합니다.")?>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_good value=1></td>
    <td>추천 사용</td>
    <td><input type=checkbox name=bo_use_good value='1' <?=$board[bo_use_good]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_nogood value=1></td>
    <td>비추천 사용</td>
    <td><input type=checkbox name=bo_use_nogood value='1' <?=$board[bo_use_nogood]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_name value=1></td>
    <td>이름(실명) 사용</td>
    <td><input type=checkbox name=bo_use_name value='1' <?=$board[bo_use_name]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_signature value=1></td>
    <td>서명보이기 사용</td>
    <td><input type=checkbox name=bo_use_signature value='1' <?=$board[bo_use_signature]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_ip_view value=1></td>
    <td>IP 보이기 사용</td>
    <td><input type=checkbox name=bo_use_ip_view value='1' <?=$board[bo_use_ip_view]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_list_content value=1></td>
    <td>목록에서 내용 사용</td>
    <td><input type=checkbox name=bo_use_list_content value='1' <?=$board[bo_use_list_content]?'checked':'';?>>사용 (사용시 속도 느려짐)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_list_view value=1></td>
    <td>전체목록보이기 사용</td>
    <td><input type=checkbox name=bo_use_list_view value='1' <?=$board[bo_use_list_view]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_email value=1></td>
    <td>메일발송 사용</td>
    <td><input type=checkbox name=bo_use_email value='1' <?=$board[bo_use_email]?'checked':'';?>>사용</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_skin value=1></td>
    <td>스킨 디렉토리</td>
    <td><select name=bo_skin required itemname="스킨 디렉토리">
        <?
        $arr = get_skin_dir("board");
        for ($i=0; $i<count($arr); $i++) {
            echo "<option value='$arr[$i]'>$arr[$i]</option>\n";
        }
        ?></select>
        <script type="text/javascript">document.fboardform.bo_skin.value="<?=$board[bo_skin]?>";</script>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_gallery_cols value=1></td>
    <td>가로 이미지수</td>
    <td><input type=text class=ed name=bo_gallery_cols size=10 required itemname='가로 이미지수' value='<?=$board[bo_gallery_cols]?>'>
        <?=help("갤러리 형식의 게시판 목록에서 이미지를 한줄에 몇장씩 보여줄것인지를 설정하는 값")?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_table_width value=1></td>
    <td>게시판 테이블 폭</td>
    <td><input type=text class=ed name=bo_table_width size=10 required itemname='게시판 테이블 폭' value='<?=$board[bo_table_width]?>'> 100 이하는 %</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_page_rows value=1></td>
    <td>페이지당 목록 수</td>
    <td><input type=text class=ed name=bo_page_rows size=10 required itemname='페이지당 목록 수' value='<?=$board[bo_page_rows]?>'></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_subject_len value=1></td>
    <td>제목 길이</td>
    <td><input type=text class=ed name=bo_subject_len size=10 required itemname='제목 길이' value='<?=$board[bo_subject_len]?>'> 목록에서의 제목 글자수. 잘리는 글은 … 로 표시</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_new value=1></td>
    <td>new 이미지</td>
    <td><input type=text class=ed name=bo_new size=10 required itemname='new 이미지' value='<?=$board[bo_new]?>'> 글 입력후 new 이미지를 출력하는 시간</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_hot value=1></td>
    <td>hot 이미지</td>
    <td><input type=text class=ed name=bo_hot size=10 required itemname='hot 이미지' value='<?=$board[bo_hot]?>'> 조회수가 설정값 이상이면 hot 이미지 출력</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_image_width value=1></td>
    <td>이미지 폭 크기</td>
    <td><input type=text class=ed name=bo_image_width size=10 required itemname='이미지 폭 크기' value='<?=$board[bo_image_width]?>'> 픽셀 (게시판에서 출력되는 이미지의 폭 크기)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_reply_order value=1></td>
    <td>답변 달기</td>
    <td>
        <select name=bo_reply_order>
        <option value='1'>나중에 쓴 답변 아래로 달기 (기본)
        <option value='0'>나중에 쓴 답변 위로 달기
        </select>
        <script type='text/javascript'> document.fboardform.bo_reply_order.value = '<?=$board[bo_reply_order]?>'; </script>
    </td>
</tr>

<?/*?>
<tr class='ht'>
    <td><input type=checkbox name=chk_disable_tags value=1></td>
    <td>사용금지 태그</td>
    <td><input type=text class=ed name=bo_disable_tags style='width:80%;' value='<?=get_text($board[bo_disable_tags])?>'>
        <?=help("태그와 태그 사이는 | 로 구분하세요. (예: <b>script</b>|<b>iframe</b>)\n\nHTML 사용시 금지할 태그를 입력하는곳 입니다.", -50)?></td>
</tr>
<?*/?>

<tr class='ht'>
    <td><input type=checkbox name=chk_sort_field value=1></td>
    <td>리스트 정렬 필드</td>
    <td>
        <select name=bo_sort_field>
        <option value=''>wr_num, wr_reply : 기본
        <option value='wr_datetime asc'>wr_datetime asc : 날짜 이전것 부터
        <option value='wr_datetime desc'>wr_datetime desc : 날짜 최근것 부터
        <option value='wr_hit asc, wr_num, wr_reply'>wr_hit asc : 조회수 낮은것 부터
        <option value='wr_hit desc, wr_num, wr_reply'>wr_hit desc : 조회수 높은것 부터
        <option value='wr_last asc'>wr_last asc : 최근글 이전것 부터
        <option value='wr_last desc'>wr_last desc : 최근글 최근것 부터
        <option value='wr_comment asc, wr_num, wr_reply'>wr_comment asc : 코멘트수 낮은것 부터
        <option value='wr_comment desc, wr_num, wr_reply'>wr_comment asc : 코멘트수 높은것 부터
        <option value='wr_good asc, wr_num, wr_reply'>wr_good asc : 추천수 낮은것 부터
        <option value='wr_good desc, wr_num, wr_reply'>wr_good asc : 추천수 높은것 부터
        <option value='wr_nogood asc, wr_num, wr_reply'>wr_nogood asc : 비추천수 낮은것 부터
        <option value='wr_nogood desc, wr_num, wr_reply'>wr_nogood asc : 비추천수 높은것 부터
        <option value='wr_subject asc, wr_num, wr_reply'>wr_subject : 제목 내림차순
        <option value='wr_subject desc, wr_num, wr_reply'>wr_subject : 제목 오름차순
        <option value='wr_name asc, wr_num, wr_reply'>wr_name : 글쓴이 내림차순
        <option value='wr_name desc, wr_num, wr_reply'>wr_name : 글쓴이 오름차순
        <option value='ca_name asc, wr_num, wr_reply'>ca_name : 분류명 내림차순
        <option value='ca_name desc, wr_num, wr_reply'>ca_name : 분류명 오름차순
        <option value='rand()'>rand() : 랜덤으로 표시
        </select>
        <script type='text/javascript'> document.fboardform.bo_sort_field.value = '<?=$board[bo_sort_field]?>'; </script>
        <?=help("리스트에서 기본으로 정렬에 사용할 필드를 선택합니다.\n\n'기본'으로 사용하지 않으시는 경우 속도가 느려질 수 있습니다.", -50)?>
    </td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_write_min value=1></td>
    <td>최소 글수 제한</td>
    <td><input type=text class=ed name=bo_write_min size=5 numeric value='<?=$board[bo_write_min]?>'>
        (글 입력시 최소 글자수를 설정. 0을 입력하면 검사하지 않음)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_write_max value=1></td>
    <td>최대 글수 제한</td>
    <td><input type=text class=ed name=bo_write_max size=5 numeric value='<?=$board[bo_write_max]?>'>
        (글 입력시 최대 글자수를 설정. 0을 입력하면 검사하지 않음)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_comment_min value=1></td>
    <td>최소 코멘트수 제한</td>
    <td><input type=text class=ed name=bo_comment_min size=5 numeric value='<?=$board[bo_comment_min]?>'>
        (코멘트 입력시 최소 글자수, 최대 글자수를 설정. 0을 입력하면 검사하지 않음)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_comment_max value=1></td>
    <td>최대 코멘트수 제한</td>
    <td><input type=text class=ed name=bo_comment_max size=5 numeric value='<?=$board[bo_comment_max]?>'>
        (코멘트 입력시 최소 글자수, 최대 글자수를 설정. 0을 입력하면 검사하지 않음)</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_upload_count value=1></td>
    <td>파일 업로드 갯수</td>
    <td><input type=text class=ed name=bo_upload_count size=10 required itemname='파일 업로드 갯수' value='<?=$board[bo_upload_count]?>'> 게시물 한건당 업로드 할 수 있는 파일의 최대 개수 (0 이면 제한 없음)</td>
</tr>
<?
$upload_max_filesize = ini_get("upload_max_filesize");
if (!preg_match("/([m|M])$/", $upload_max_filesize)) {
    $upload_max_filesize = (int)($upload_max_filesize / 1048576);
}
?>
<tr class='ht'>
    <td><input type=checkbox name=chk_upload_size value=1></td>
    <td>파일 업로드 용량</td>
    <td>업로드 파일 한개당 <input type=text class=ed name=bo_upload_size size=10 required itemname='파일 업로드 용량' value='<?=$board[bo_upload_size]?>'> bytes 이하 (최대 <?=ini_get("upload_max_filesize")?> 이하) <?=help("1 MB = 1,048,576 bytes")?></td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_include_head value=1></td>
    <td>상단 파일 경로</td>
    <td><input type=text class=ed name=bo_include_head style='width:80%;' value='<?=$board[bo_include_head]?>'></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_include_tail value=1></td>
    <td>하단 파일 경로</td>
    <td><input type=text class=ed name=bo_include_tail style='width:80%;' value='<?=$board[bo_include_tail]?>'></td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_content_head value=1></td>
    <td>상단 내용</td>
    <td><textarea class=ed name=bo_content_head rows=5 style='width:80%;'><?=$board[bo_content_head] ?></textarea></td>
    <!--<td style='padding-top:7px; padding-bottom:7px;'><?=cheditor2('bo_content_head', $board[bo_content_head]);?></td>-->
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_content_tail value=1></td>
    <td>하단 내용</td>
    <td><textarea class=ed name=bo_content_tail rows=5 style='width:80%;'><?=$board[bo_content_tail] ?></textarea></td>
    <!--<td style='padding-top:7px; padding-bottom:7px;'><?=cheditor2('bo_content_tail', $board[bo_content_tail]);?></td>-->
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_insert_content value=1></td>
    <td>글쓰기 기본 내용</td>
    <td style='padding-top:7px; padding-bottom:7px;'><?=cheditor2('bo_insert_content', $board[bo_insert_content]);?></td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_use_search value=1></td>
    <td>전체 검색 사용</td>
    <td>
    <? if ($group[gr_use_search] ==0) { ?>
    그룹 설정에서 전체검색 사용하지 않음을 선택했습니다
    <input type=hidden name=bo_use_search value='0'>
    <? } else { ?>
    <input type=checkbox name=bo_use_search value='1' <?=$board[bo_use_search]?'checked':'';?>>사용
    <? } ?>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_order_search value=1></td>
    <td>전체 검색 순서</td>
    <td><input type=text class=ed name=bo_order_search size=5 value='<?=$board[bo_order_search]?>'> 숫자가 낮은 게시판 부터 검색</td>
</tr>

<tr class='ht'>
    <td><input type=checkbox name=chk_list_view value=1></td>
    <td>베스트글(조횟수)</td>
    <td><input type=text class=ed name=bo_list_view size=5 value='<?=$board[bo_list_view]?>'> 베스트글 게시판에 등록</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_list_comment value=1></td>
    <td>베스트글(코멘트수)</td>
    <td><input type=text class=ed name=bo_list_comment size=5 value='<?=$board[bo_list_comment]?>'> 베스트글 게시판에 등록</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_list_good value=1></td>
    <td>베스트글(추천수)</td>
    <td><input type=text class=ed name=bo_list_good size=5 value='<?=$board[bo_list_good]?>'> 베스트글 게시판에 등록</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_list_nogood value=1></td>
    <td>베스트글(비추천수)</td>
    <td><input type=text class=ed name=bo_list_nogood size=5 value='<?=$board[bo_list_nogood]?>'> 베스트글 게시판에 등록</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_use_recycle value=1></td>
    <td>휴지통 사용</td>
    <td><input type=checkbox name=bo_use_recycle value='1' <?=$board[bo_use_recycle]?'checked':'';?>>사용</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_gallery value=1></td>
    <td>갤러리 view</td>
    <td><input type=checkbox name=bo_gallery value='1' <?=$board[bo_gallery]?'checked':'';?>>사용 (갤러리 view가 check 되어야 목록에서 이미지 정보를 가지고 옵니다. 갤러리 게시판은 필첵~!)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_image_info value=1></td>
    <td>이미지 정보가져오기</td>
    <td><input type=checkbox name=bo_image_info value='1' <?=$board[bo_image_info]?'checked':'';?>>사용 (resize 함수에서 웹편집기의 이미지 정보를 가지고 오게 합니다.~!)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_image_max_size value=1></td>
    <td>최대 이미지용량</td>
    <td><input type=text class=ed name=bo_image_max_size size=10 itemname='최대 이미지용량' value='<?=$board[bo_image_max_size]?>'> (kb, 웹편집기 이미지 용량이 한도를 넘으면 출력하지 않음)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_chimage value=1></td>
    <td>chimage 출력</td>
    <td><input type=checkbox name=bo_chimage value='1' <?=$board[bo_chimage]?'checked':'';?>>사용 (게시글 하단에 cheditor 업로드 이미지의 썸을 출력 합니다)</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_ccl value=1></td>
    <td>CCL 사용</td>
    <td><input type=checkbox name=bo_ccl value='1' <?=$board[bo_ccl]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_source value=1></td>
    <td>출처 자동복사</td>
    <td><input type=checkbox name=bo_source value='1' <?=$board[bo_source]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_related value=1></td>
    <td>관련글 출력갯수</td>
    <td><?=get_member_level_select('bo_related', 0, 10, $board[bo_related]) ?> (0개의 관련글 = 관련글 사용하지 않음)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_popular value=1></td>
    <td>인기검색어 출력갯수</td>
    <td><?=get_member_level_select('bo_popular', 0, 10, $board[bo_popular]) ?> (0개의 인기검색어 = 사용하지 않음)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_popular_days value=1></td>
    <td>인기검색어 출력일수</td>
    <td><input type=text class=ed name=bo_popular_days size=10 itemname='인기검색어 출력일수' value='<?=$board[bo_popular_days]?>'> 지정된 일수동안의 해당 인기검색어를 출력</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_hot_list value=1></td>
    <td>인기 게시물</td>
    <td>
        <select name=bo_hot_list>
        <option value="0"> 사용안함 </option>
        <option value="1"> 실시간 </option>
        <option value="2"> 주간 </option>
        <option value="3"> 월간 </option>
        <option value="4"> 일간 </option>
        </select>
        <select name=bo_hot_list_basis>
        <option value="hit"> 조회수 </option>
        <option value="good"> 추천수 </option>
        </select>
        (목록상단에 인기게시물을 출력합니다.)
        <script type="text/javascript">
        document.fboardform.bo_hot_list.value = "<?=$board[bo_hot_list]?>";
        document.fboardform.bo_hot_list_basis.value = "<?=$board[bo_hot_list_basis]?>";
        </script>
    </td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_hidden_comment_notice value=1></td>
    <td>딴지걸기</td>
    <td><input type=checkbox name=bo_hidden_comment value='1' <?=$board[bo_hidden_comment]?'checked':'';?>>사용 (딴지걸기는 유니크로와 장터게시판 스킨에서만 가능)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_singo value=1></td>
    <td>게시판 신고기능</td>
    <td><input type=checkbox name=bo_singo value='1' <?=$board[bo_singo]?'checked':'';?>>사용</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_singo_action value=1></td>
    <td>신고 처리 횟수</td>
    <td><?=get_member_level_select('bo_singo_action', 0, 10, $board[bo_singo_action]) ?> (신고된 글의 목록 및 내용에 action을 하는 횟수.0 회는 신고처리를 하지 않습니다)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_singo_nowrite value=1></td>
    <td>신고 글쓰기제한</td>
    <td><input type=text class=ed name=bo_singo_nowrite size=20 itemname='신고 글쓰기제한' value='<?=$board[bo_singo_nowrite]?>'> (a일동안 b회 신고되면 게시판의 글쓰기를 금지합니다. a,b|c,d 와 같이 입력해주세요)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_move_bo_table value=1></td>
    <td>게시글 대피 게시판</td>
    <td><input type=text class=ed name=bo_move_bo_table size=20 itemname='게시글 대피 게시판' value='<?=$board[bo_move_bo_table]?>'> 지정된 게시판으로 사용자가 게시글을 대피할 수 있게 함</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_hhp value=1></td>
    <td>핸폰인증회원만 글쓰기</td>
    <td><input type=checkbox name=bo_hhp value='1' <?=$board[bo_hhp]?'checked':'';?>>사용 (핸드폰 인증을 받은 회원만 글쓰기가 가능하게 제한합니다.)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_realcheck value=1></td>
    <td>본인인증회원만 글쓰기</td>
    <td><input type=checkbox name=bo_realcheck value='1' <?=$board[bo_realcheck]?'checked':'';?>>사용 (본인 인증을 받은 회원만 글쓰기가 가능하게 제한합니다.)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_read_point_lock value=1></td>
    <td>마이너스포인트 글쓰기제한</td>
    <td><input type=checkbox name=bo_read_point_lock value='1' <?=$board[bo_read_point_lock]?'checked':'';?>>사용 (포인트가 마이너스인 회원의 글쓰기를 제한합니다.)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_day_nowrite value=1></td>
    <td>일별 글쓰기제한</td>
    <td><input type=text class=ed name=bo_day_nowrite size=20 itemname='일별 글쓰기제한' value='<?=$board[bo_day_nowrite]?>'> (a일동안 b회 이상 글쓰기를 금지합니다. a,b|c,d 와 같이 입력해주세요)</td>
</tr>

<tr class='ht'>
    <td><input type=checkbox name=chk_bo_comment_nowrite value=1></td>
    <td>n일후 코멘트쓰기제한</td>
    <td><input type=text class=ed name=bo_comment_nowrite size=20 itemname='n일후 코멘트쓰기제한' value='<?=$board[bo_comment_nowrite]?>'> (0: 코멘트 가능, n: n일 이후 코멘트 달 수 없슴, -n: 글쓴이만 코멘트 쓰기를 제한 가능)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_sex value=1></td>
    <td>성별 게시판</td>
    <td>
        <select name=bo_sex>
        <option value=""> 사용안함 </option>
        <option value="M"> 남성만 접근가능 </option>
        <option value="F"> 여성만 접근가능 </option>
        </select>
        <script type="text/javascript">
        document.fboardform.bo_sex.value = "<?=$board[bo_sex]?>";
        </script>
    </td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_print_level value=1></td>
    <td>게시글프린트</td>
    <td><?=get_member_level_select('bo_print_level', 0, 10, $board[bo_print_level]) ?> (0레벨은 출력을 모두에게 허용하지 않음)</td>
</tr>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_naver_notice value=1></td>
    <td>전체 공지 사용하기</td>
    <td><input type=checkbox name=bo_naver_notice value='1' <?=$board[bo_naver_notice]?'checked':'';?>>사용 (전체 공지를 출력해 줍니다.)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_notice_comment_allow value=1></td>
    <td>공지글에 코멘트 금지</td>
    <td><input type=text class=ed name=bo_notice_comment_allow style='width:80%;' value='<?=get_text($board[bo_notice_comment_allow])?>'>
        <?=help("공지글에 코멘트 쓰기를 금지할 사용자 아이디를 입력해 주세요\n\n사용자 아이디는 콤마로 구분하시면 됩니다(예: admin,test1).", -50)?></td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_notice_joongbok value=1></td>
    <td>공지글 중복 금지</td>
    <td><input type=checkbox name=bo_notice_joongbok value='1' <?=$board[bo_notice_joongbok]?'checked':'';?>>사용 (공지글이 게시글 목록에는 나오지 않게 합니다)</td>
</tr>
<tr class='ht'>
    <td><input type=checkbox name=chk_bo_comment_notice value=1></td>
    <td>코멘트 공지사항</td>
    <td><textarea class=ed name=bo_comment_notice rows=5 style='width:80%;'><?=$board[bo_comment_notice] ?></textarea></td>
</tr>

<?
$notice_wr_id = preg_split("/\n/", trim($board[bo_notice]));
$notice_count = count($notice_wr_id);

if ($notice_wr_id[0] != '' && $notice_count) {
?>
<script type="text/javascript" src="<?=$g4[path]?>/js/javascripttoolbox.js"></script> 
<tr class='ht'>
    <td></td>
    <td>공지사항정렬</td>
    <td>
    <select name="notice_list[]" size="<?=$notice_count?>" id="notice_list" multiple>
        <?
        for ($i = 0; $i < $notice_count; $i++) {
            $sql = " select wr_id, wr_subject, wr_name from $tmp_write_table where wr_id = '$notice_wr_id[$i]' ";
            $row = sql_fetch($sql);
            echo "<option value='$row[wr_id]'>" . cut_str($row['wr_subject'], 60) . " ($row[wr_name])";
        }
        ?>
    </select>
    <input type="button" value="&nbsp;Up&nbsp;" onClick="Selectbox.moveOptionUp(this.form.elements['notice_list[]'])">    
    <input type="button" value="Down" onClick="Selectbox.moveOptionDown(this.form.elements['notice_list[]'])">
    <input type="button" value="Remove" onClick="Selectbox.removeSelectedOptions(this.form.elements['notice_list[]'])">
    </td>
</tr>
<? } ?>

<tr><td colspan=3 class='line2'></td></tr>

<? for ($i=1; $i<=10; $i++) { ?>
<tr class='ht'>
    <td><input type=checkbox name=chk_<?=$i?> value=1></td>
    <td><input type=text class=ed name='bo_<?=$i?>_subj' value='<?=get_text($board["bo_{$i}_subj"])?>' title='여분필드 <?=$i?> 제목' style='text-align:right;font-weight:bold;'></td>
    <td><input type=text class=ed style='width:80%;' name='bo_<?=$i?>' value='<?=get_text($board["bo_$i"])?>' title='여분필드 <?=$i?> 설정값'></td>
</tr>
<? } ?>

<tr><td colspan=3 class='line2'></td></tr>
<tr class='ht'>
    <td colspan=3 align=left>
        <?=subtitle("XSS / CSRF 방지")?>
    </td>
</tr>
<tr><td colspan=3 class='line1'></td></tr>
<tr class='ht'>
    <td colspan='2'>
        관리자 패스워드
    </td>
    <td>
        <input class='ed' type='password' name='admin_password' itemname="관리자 패스워드" required>
        <?=help("관리자 권한을 빼앗길 것에 대비하여 로그인한 관리자의 패스워드를 한번 더 묻는것 입니다.");?>
    </td>
</tr>
<tr><td colspan=3 class='line1'></td></tr>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>&nbsp;
    <input type=button class=btn1 value='  목  록  ' onclick="document.location.href='./board_list.php?<?=$qstr?>';">&nbsp;
    <? if ($w == 'u') { ?><input type=button class=btn1 value='  복  사  ' onclick="board_copy('<?=$bo_table?>');"><?}?>
</form>

<script type="text/javascript">
function board_copy(bo_table) {
    window.open("./board_copy.php?bo_table="+bo_table, "BoardCopy", "left=10,top=10,width=500,height=200");
}

function set_point(f) {
    if (f.chk_point.checked) {
        f.bo_read_point.value     = "<?=$config[cf_read_point]?>";
        f.bo_write_point.value    = "<?=$config[cf_write_point]?>";
        f.bo_comment_point.value  = "<?=$config[cf_comment_point]?>";
        f.bo_download_point.value = "<?=$config[cf_download_point]?>";
    } else {
        f.bo_read_point.value     = f.bo_read_point.defaultValue;
        f.bo_write_point.value    = f.bo_write_point.defaultValue;
        f.bo_comment_point.value  = f.bo_comment_point.defaultValue;
        f.bo_download_point.value = f.bo_download_point.defaultValue;
    }
}

function fboardform_submit(f) {
    var tmp_title;
    var tmp_image;

    tmp_title = "상단";
    tmp_image = f.bo_image_head;
    if (tmp_image.value) {
        if (!tmp_image.value.toLowerCase().match(/.(gif|jpg|png)$/i)) {
            alert(tmp_title + "이미지가 gif, jpg, png 파일이 아닙니다.");
            return false;
        }
    }

    tmp_title = "하단";
    tmp_image = f.bo_image_tail;
    if (tmp_image.value) {
        if (!tmp_image.value.toLowerCase().match(/.(gif|jpg|png)$/i)) {
            alert(tmp_title + "이미지가 gif, jpg, png 파일이 아닙니다.");
            return false;
        }
    }

    if (parseInt(f.bo_count_modify.value) < 1) {
        alert("원글 수정 불가 코멘트수는 1 이상 입력하셔야 합니다.");
        f.bo_count_modify.focus();
        return false;
    }

    if (parseInt(f.bo_count_delete.value) < 1) {
        alert("원글 삭제 불가 코멘트수는 1 이상 입력하셔야 합니다.");
        f.bo_count_delete.focus();
        return false;
    }

   
    <?=cheditor3('bo_insert_content')."\n";?>
    
    // 공지사항 정렬을 위해서
    <?
    if ($notice_wr_id[0] != '' && $notice_count) {
    ?>
    var notice_len = f.elements['notice_list[]'].length;
    for (i=0; i < notice_len; i++)
        f.elements['notice_list[]'].options[i].selected = true;
    <? } ?>
    
    f.action = "./board_form_update.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php");
?>
