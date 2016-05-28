<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$subject_len = 60;
?>




<style type="text/css">
.trs { height:30px; background:#dddddd; text-align:center;}
.status_form_title { background:#eeeeee; width:13%; text-align:center;  }
.status_form_content { text-align:left; padding-left:5px; width:20%; background:#ffffff;  }
.n_title1 { font-family:돋움; font-size:9pt; color:#FFFFFF; }
.n_title2 { font-family:돋움; font-size:9pt; color:#5E5E5E; }
</style>
<table width="100%" height="40" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
    <td >

		

		<table bgcolor="#dddddd" width='100%' cellpadding='1' cellspacing='1' border='0'>
		<tr class="trs">
		    <td class="status_form_title">닉네임</td>
			<td class="status_form_content"><?=$member[mb_name]?></td>
			<td class="status_form_title">아이디</td>
			<td class="status_form_content"><?=$member[mb_id]?></td>
			<td class="status_form_title">정보수정</td>
			<td class="status_form_content"><a href="<?=$g4['path']?>/bbs/member_confirm.php?url=register_form.php">수정하기</a></td>
		</tr>

		<tr class="trs">
		    <td class="status_form_title">포인트</td>
			<td class="status_form_content"><a href="javascript:win_point();"><?=$member[mb_point]?> point</a></td>
			<td class="status_form_title">쪽지</td>
			<td class="status_form_content"><a href="javascript:win_memo('', '<?=$member[mb_id]?>', '<?=$_SERVER[SERVER_NAME]?>');"  onfocus="this.blur()"> (<?=$member['mb_memo_unread']?>)</a></td>
			<td class="status_form_title">스크랩</td>
			<td class="status_form_content"><a href="javascript:win_scrap();"  onfocus="this.blur()">나의 스크랩</a></td>
		</tr>

		
		</table>

		
<div style="background-color:rgb(247,247,247); border-width:5px; border-color:white; border-style:solid;"></div>

<table width='100%' >
<tr>
<td>
<? include("$myon_skin_path/tab.html"); ?>
</td>
</tr>
</table>

