<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($is_dhtml_editor) {
    include_once("$g4[path]/lib/cheditor4.lib.php");
    echo "<script type='text/javascript' src='$g4[cheditor4_path]/cheditor.js'></script>";
    echo cheditor1('wr_content', '100%', '250px');
}

// 스킨에서 사용하는 lib 읽어들이기
include_once("$g4[path]/lib/write.skin.lib.php");

//보드 설정에서 동네이름 가져오기
$asql="select bo_1 from g4_board where bo_table='$_GET[bo_table]'";
$rst=mysql_query($asql);
$w_area=mysql_fetch_object($rst);;
$w_area=explode(",", $w_area->bo_1);

if($wr_id){
	//이 글이 프리미엄인가아아...
	$ip_sql="select count(prem_wr_id) from prem_info where del_date='0000-00-00 00:00:00' and prem_board='$bo_table' and prem_wr_id='$wr_id' and now() between prem_date and exp_date";
	$rst=mysql_query($ip_sql);
	$ip_data=mysql_fetch_row($rst);	
}

$prSql=mysql_query("select * from prem_config");
$premConfig=mysql_fetch_array($prSql);


function get_category_option2($bo_table='', $ca_name='')
{
   global $g5, $board, $is_admin;
   $categories = explode("|", $board['bo_category_list']);
   $str = "";
   for ($i=0; $i<count($categories); $i++) {
      $category = trim($categories[$i]);
      if (!$category || $i==0) continue; //원본함수에서 변경한 부분
      $str .= "<option value=\"$categories[$i]\"";
      if ($category == $ca_name) {
         $str .= ' selected="selected"';
      }
      $str .= ">$categories[$i]</option>\n";
   }
   return $str;
}
 
if ($board['bo_use_category'])
   $category_option = get_category_option2($bo_table, $ca_name);

?>


<div style="height:14px; line-height:1px; font-size:1px;">&nbsp;</div>

<style type="text/css">
.write_head { height:30px; text-align:center; color:#8492A0; }
.field { border:1px solid #ccc; }
</style>

<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?=$write_min?>); // 최소
var char_max = parseInt(<?=$write_max?>); // 최대
</script>

<form name="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin:0px;">
<input type=hidden name=null> 
<input type=hidden name=w id=w       value="<?=$w?>">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=wr_id    value="<?=$wr_id?>">
<input type=hidden name=sca      value="<?=$sca?>">
<input type=hidden name=sfl      value="<?=$sfl?>">
<input type=hidden name=stx      value="<?=$stx?>">
<input type=hidden name=spt      value="<?=$spt?>">
<input type=hidden name=sst      value="<?=$sst?>">
<input type=hidden name=sod      value="<?=$sod?>">
<input type=hidden name=page     value="<?=$page?>">
<input type=hidden name=mnb      value="<?=$mnb?>">
<input type=hidden name=snb      value="<?=$snb?>">

<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0><tr><td>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<colgroup width=100>
<colgroup width=''>
<tr><td colspan=2 height=2 style="background:#d5d5d5;"></td></tr>
<tr><td style='padding-left:20px' colspan=2 height=38 bgcolor="#FBFBFB"><strong><?=$title_msg?></strong></td></tr>
<tr><td colspan="2" style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x; height:3px;"></td></tr>
<? if ($is_name) { ?>
<tr>
    <td style='padding-left:20px; height:30px;'>· 이름</td>
    <td><input class='field_pub_01' maxlength=20 size=15 name=wr_name itemname="이름" required value="<?=$name?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <? } ?>
  
  <? if ($is_password) { ?>
  <tr>
    <td style='padding-left:20px; height:30px;'>· 패스워드</td>
    <td><input class='field_pub_01' type=password maxlength=20 size=15 name=wr_password itemname="패스워드" <?=$password_required?>></td></tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
  

  
  <? 
$option = "";
$option_hidden = "";
if ($is_notice || $is_html || $is_secret || $is_mail) { 
    $option = "";
    if ($is_notice) { 
        $option .= "<input type=checkbox name=notice value='1' $notice_checked>카테고리공지&nbsp;";
    }

    

    if ($is_html) {
        if ($is_dhtml_editor) {
            $option_hidden .= "<input type=hidden value='html1' name='html'>";
        } else {
            $option .= "<input onclick='html_auto_br(this);' type=checkbox value='$html_value' name='html' $html_checked><span class=w_title>html</span>&nbsp;";
        }
    }

    if ($is_secret) {
        if ($is_admin || $is_secret==1) {
            $option .= "<input type=checkbox value='secret' name='secret' $secret_checked><span class=w_title>비밀글</span>&nbsp;";
        } else {
            $option_hidden .= "<input type=hidden value='secret' name='secret'>";
        }
    }
    
    if ($is_mail) {
        $option .= "<input type=checkbox value='mail' name='mail' $recv_email_checked>답변메일받기&nbsp;";
    }
}

echo $option_hidden;
if ($option) {
?>
  <tr>
    <td class=write_head>옵 션</td>
    <td style='padding-left:20px; height:30px;'><?=$option?></td></tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr> 
  <? } ?>
  
  <? if ($is_category) { ?>
  
  <?
  	$bInfo=mysql_fetch_array(mysql_query("select gr_id from g4_board where bo_table='$_GET[bo_table]' limit 1"));
  ?>
<script>
function myCate(cate){
}

function subCate(depth, kwd)
{
	
	var postData;
	
	if(depth==8){
		postData="depth=8&cate3=<?=$write[wr_5]?>&bo_table=<?=$bo_table?>&hcate="+kwd;
	}
	
    $.ajax({
        url:"<?=$g4[path]?>/subCate.php", // 요청할 url
        data:postData, // 전달할 데이터
        type:"post", // 데이터를 전달할 방식
        async:false, // 비동기 방식으로 할 것인가. true면 당연히 비동기, false면 동기
        success:function(retData){ // 요청에 성공했을 때 실행 될 함수부분
            if(retData && depth=='8'){
				if(retData==0){
					$("#cate9").html('');
					$("#cate9").val('');
				}else{
            		$("#cate9").html(retData);
				}
            }
        }
    });
}


$(window).load(function(){
  var haha=$("#ca_name").val();
  subCate(8, haha);  
});
</script>
<style>
.cates {
	float:left;
	margin-left:10px;	
}
</style>
  <tr>
    <td style='padding-left:20px; height:30px;'>· 구분</td>
    <td><div class='cates' style='margin-left:0;'><select name=ca_name itemname="분류" id='ca_name' onchange="subCate(8, this.value);"><option value="">선택하세요</option><?=$category_option?></select></div><div id='cate9' class='cates' style='margin-left:0;display:none;'><select id='cate3s' name='wr_5' onchange='myCate(this.value)'><option value='0'>선택하세요</option></select></div></td></tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
  
  <? if (count($w_area)>1) { ?>
  <tr>
    <td style='padding-left:20px; height:30px;'>· 대상</td>
    <td><select name="wr_1">
	<option value=''>전체</option>
	<?
    for($c=0;$c<count($w_area);$c++){
		$myArea=trim($w_area[$c]);
		if($myArea==$area){ $selected='selected'; }else{ $selected=''; }
		echo "<option value='$myArea' $selected>$myArea</option>";
	}
	?>
</select></td></tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
  
  <tr>
    <td style='padding-left:20px; height:30px;'>· 제목</td>
    <td><input class="field_pub_01" style="width:100%;" name=wr_subject id="wr_subject" itemname="제목" required value="<?=$subject?>"></td></tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <tr>
    <td style='padding-left:20px;'>· 내용</td>
    <td style='padding:5 0 5 0;'>
      <? if ($is_dhtml_editor) { ?>
      <?=cheditor2('wr_content', $content);?>
      <? } else { ?>
      <table width=100% cellpadding=0 cellspacing=0>
        <tr>
          <td width=50% align=left valign=bottom>
            <span style="cursor: pointer;" onclick="textarea_decrease('wr_content', 10);"><img src="<?=$board_skin_path?>/img/up.gif"></span>
            <span style="cursor: pointer;" onclick="textarea_original('wr_content', 10);"><img src="<?=$board_skin_path?>/img/start.gif"></span>
            <span style="cursor: pointer;" onclick="textarea_increase('wr_content', 10);"><img src="<?=$board_skin_path?>/img/down.gif"></span></td>
          <td width=50% align=right><? if ($write_min || $write_max) { ?><span id=char_count></span>글자<?}?></td>
          </tr>
        </table>
      <textarea id="wr_content" name="wr_content" class=tx style='width:100%; word-break:break-all;' rows=10 itemname="내용" required 
        <? if ($write_min || $write_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?>><?=$content?></textarea>
      <? if ($write_min || $write_max) { ?><script language="javascript"> check_byte('wr_content', 'char_count'); </script><?}?>
      <? } ?>
      </td>
  </tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  
  <? if ($board[bo_ccl]) {
// CCL 정보
$view[wr_ccl] = $write[wr_ccl] = mw_get_ccl_info($write[wr_ccl]);
?>
  <tr>
    <td style='padding-left:20px;'>· CCL</td>
    <td style='padding:5 0 5 0;'>
      <select name="wr_ccl_by"><option value="by">사용</option><option value="">사용안함</option></select>
      영리목적 : <select name="wr_ccl_nc"><option value="nc">사용불가</option><option value="">사용가능</option></select>
      변경 : <select name="wr_ccl_nd"><option value="nd">변경불가</option><option value="sa">동일조건변경가능</option><option value="">변경가능</option></select>
      <a href="http://www.creativecommons.or.kr/info/about" target=_blank>CCL이란?</a>
      <? if ($w == "u") {?>
      <script type="text/javascript">
        document.fwrite.wr_ccl_by.value = "<?=$write[wr_ccl][by]?>";
        document.fwrite.wr_ccl_nc.value = "<?=$write[wr_ccl][nc]?>";
        document.fwrite.wr_ccl_nd.value = "<?=$write[wr_ccl][nd]?>";
        </script>
      <? } ?>
      </td>
  </tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
  
  <? if ($board[bo_related]) { ?>
  <tr>
    <td>· 관련글 키워드</td>
    <td height=50>
      <input type="text" size=50 name="wr_related" itemname="관련글 키워드" value="<?=$write[wr_related]?>"> (예 : 키워드1, 키워드2, 키워드3)
      </td>
  </tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
  
  <? if ($is_link) { ?>
  <? for ($i=1; $i<=$g4[link_count]; $i++) { ?>
  <tr>
    <td style='padding-left:20px; height:30px;'>· 링크 #<?=$i?></td>
    <td><input type='text' class='field_pub_01' size=50 name='wr_link<?=$i?>' itemname='링크 #<?=$i?>' value='<?=$write["wr_link{$i}"]?>'></td>
  </tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
  <? } ?>
  
  <? if ($is_file) { ?>
  <tr>
    <td style='padding-left:20px; height:30px;' valign=top><table cellpadding=0 cellspacing=0><tr><td style=" padding-top: 10px;">· 파일 <span onclick="add_file();" style='cursor:pointer; font-family:tahoma; font-size:12pt;'>+</span> <span onclick="del_file();" style='cursor:pointer; font-family:tahoma; font-size:12pt;'>-</span></td></tr></table></td>
    <td style='padding:5 0 5 0;'><table id="variableFiles" cellpadding=0 cellspacing=0></table><?// print_r2($file); ?>
      <script language="JavaScript">
        var flen = 0;
        function add_file(delete_code)
        {
            var upload_count = <? if($is_admin=='super'){ echo 0; }else if($is_admin=='board'){ echo $premConfig[picNum2]; }else if($ip_data[0]==1 and $member[mb_id]==$write[mb_id]){ echo $premConfig[picNum]; }else{ echo (int)$board[bo_upload_count]; }?>;
            if (upload_count && flen >= upload_count)
            {
                alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
                return;
            }

            var objTbl;
            var objRow;
            var objCell;
            if (document.getElementById)
                objTbl = document.getElementById("variableFiles");
            else
                objTbl = document.all["variableFiles"];

            objRow = objTbl.insertRow(objTbl.rows.length);
            objCell = objRow.insertCell(0);

            objCell.innerHTML = "<input type='file' class='field_pub_01' name='bf_file[]' title='파일 용량 <? if($is_admin=='super'){ echo 0; }else if($is_admin=='board'){ echo $premConfig[picQuota2]; }else if($ip_data[0]>=1 and $member[mb_id]==$write[mb_id]){ echo $premConfig[picQuota]; }else{ echo $upload_max_filesize; } ?> 이하만 업로드 가능'>";
            if (delete_code)
                objCell.innerHTML += delete_code;
            else
            {
                <? if ($is_file_content) { ?>
                objCell.innerHTML += "<br><input type='text' class='field_pub_01' size=50 name='bf_content[]' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'> 파일의 내용을 입력하세요.";
                <? } ?>
                ;
            }

            flen++;
        }

        <?=$file_script; //수정시에 필요한 스크립트?>

        function del_file()
        {
            // file_length 이하로는 필드가 삭제되지 않아야 합니다.
            var file_length = <?=(int)$file_length?>;
            var objTbl = document.getElementById("variableFiles");
            if (objTbl.rows.length - 1 > file_length)
            {
                objTbl.deleteRow(objTbl.rows.length - 1);
                flen--;
            }
        }
        </script></td>
  </tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
  
   <? if ($is_guest) { ?>
  <tr>
 <td style='padding-left:20px; height:30px;'>· 공지사항</td>
       <td>    <p>전화번호,이메일,주소 등 개인정보를 기재하신 경우 주의를 당부 드립니다. </p>
       <p>본 사이트는 이후 발생될 수 있는 어떠한 개인정보 노출 관련 사항에 대해서도 책임을 지지 않음을 알려 드립니다.</p></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
  
  <? if ($is_guest) { ?>
  <tr>
    <td  class=write_head>
      <script type="text/javascript" src="<?="$g4[path]/zmSpamFree/zmspamfree.js"?>"></script>
      <img id="zsfImg">
      </td>
    <td><input class='ed' type=input size=10 name=wr_key id=wr_key itemname="자동등록방지" required >&nbsp;&nbsp;왼쪽의 글자를 입력하세요.</td>
  </tr>
  <tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
  <? } ?>
 


  
  
  <tr><td colspan=2 height=2 style="background:#d5d5d5;"></td></tr>
</table>


 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="100%" align="center" valign="top" style="padding-top:30px;">
        <input type=image id="btn_submit" src="<?=$board_skin_path?>/img/btn_write.gif" border=0 accesskey='s'>&nbsp;
        <a href="<?=$list_href?>#board"><img id="btn_list" src="<?=$board_skin_path?>/img/btn_list.gif" border=0></a></td>
</tr>
</table>

</td></tr></table>
</form>

<script type="text/javascript">


with (document.fwrite) {
    if (typeof(wr_name) != "undefined")
        wr_name.focus();
    else if (typeof(wr_subject) != "undefined")
        wr_subject.focus();
    else if (typeof(wr_content) != "undefined")
        wr_content.focus();

    if (typeof(ca_name) != "undefined") {
        if (w.value == "u")
            ca_name.value = "<?=$write[ca_name]?>";
        if (w.value == "r")
            ca_name.value = "<?=$write[ca_name]?>"; 
    }
}

function html_auto_br(obj) 
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f) 
{
    /*
    var s = "";
    if (s = word_filter_check(f.wr_subject.value)) {
        alert("제목에 금지단어('"+s+"')가 포함되어있습니다");
        return false;
    }

    if (s = word_filter_check(f.wr_content.value)) {
        alert("내용에 금지단어('"+s+"')가 포함되어있습니다");
        return false;
    }
    */

    if (document.getElementById('char_count')) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(document.getElementById('char_count').innerHTML);
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            } 
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?
    if ($is_dhtml_editor) echo cheditor3('wr_content'); 
    if ($is_dhtml_editor) echo cheditor4('wr_content'); 
    ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: "<?=$g4[bbs_path]?>/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined") 
            ed_wr_content.returnFalse();
        else 
            f.wr_content.focus();
        return false;
    }

    if (typeof(f.wr_key) != 'undefined') {
        if (!checkFrm()) {
            alert ("스팸방지코드(Captcha Code)가 틀렸습니다. 다시 입력해 주세요.");
            return false;
        }
    }
	
	//3단카테 미선택 시 return false;
	var s=$("#ca_name");
	var ss=$("#ca_name option").index($("#ca_name option:selected"));
	var t=$("#cate3s");
	var tt=$("#cate3s option").index($("#cate3s option:selected"));
	
	if(ss==0){
		
		alert('첫번째 분류를 선택하세요.');
		s.focus();
		return false;
		
	}else if(tt==0){
		
		alert('두번째 분류를 선택하세요.');
		t.focus();
		return false;
		
	}
	
	document.getElementById('btn_submit').disabled = true;
    document.getElementById('btn_list').disabled = true;

    <?
    if ($g4[https_url])
        echo "f.action = '$g4[https_url]/$g4[bbs]/write_update.php';";
    else
        echo "f.action = './write_update.php';";
    ?>
    
    return true;
}
</script>

<script type="text/javascript">
// 업로드한 이미지 정보를 리턴 받는 예제입니다.
function showImageInfo() {
    var data = ed_wr_content.getImages();
    if (data == null) {
        return 0;
    }

    var img_sum = 0;
    for (var i=0; i<data.length; i++) {
        img_sum += parseInt(data[i].fileSize);
    }
}
</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script type="text/javascript"> window.onload=function() { drawFont(); } </script>
