<?
/*************************************************/
/*           실시간 쪽지 - 그누보드              */
/*  프로그램 by 정권짱, pooka, 불당              */
/*************************************************/

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$replace_time = 50000; // 쪽지정보 새로고침 간격 (대부분의 경우 2만-5만으로 설정하면 됨)

// 불당팩을 안쓰는 사용자를 위한 설정 - 아래의 코멘트를 풀어주세요
// $member[mb_realmemo_sound] = 1; // 1: 음성알림 활성화, 0: 비활성화
?>

<? if ($is_member) { ?> <!-- 회원인 경우에만 ajax가 작동하게 합니다 -->

<!-- ajax -->
<script type="text/javascript" language="javascript">
var xmlHttp;
var memo_alarm = <?=$member[mb_realmemo_sound]?>; <!-- 1이면 음성알람 활성화, 0이면 비활성화 -->

b4_startRequest();

function b4_createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function b4_startRequest() {
    b4_createXMLHttpRequest();
    xmlHttp.onreadystatechange = b4_handleStateChange;
    xmlHttp.open("GET", "<?=$g4[bbs_path]?>/realtime_memo_connect.php", true); // connect program의 location
    xmlHttp.send(null);
}

function b4_handleStateChange() {
    if(xmlHttp.readyState && xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            var xmlDoc = xmlHttp.responseXML;
            var xml_call = xmlDoc.getElementsByTagName("call")[0];
            var tag_call = xml_call.childNodes[0].nodeValue;

            if (tag_call != 0) { // me_memo_call에 값이 있을 때 팝업창을 뛰운다
                  var xml_total = xmlDoc.getElementsByTagName("total")[0];
                  var xml_new = xmlDoc.getElementsByTagName("new")[0];
                  var xml_nick = xmlDoc.getElementsByTagName("nick")[0];
                  var tag_total = xml_total.childNodes[0].nodeValue;
                  var tag_new = xml_new.childNodes[0].nodeValue;
                  var tag_nick = xml_nick.childNodes[0].nodeValue;
                  
                  if(memo_alarm == 1) {
          	         document.getElementById("memo_alarm").innerHTML = "<embed menu=false src='<?=$g4[bbs_path]?>/img/Kim_Ae-ni_ver.swf' quality=high pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width=0 height=0>"; 
                  }
      	          document.getElementById("memo_mb_nick").innerHTML = tag_nick; //만일 불러오는 html 페이지의 값을 바꿀 때
          				do_check();
          				b4_msn_position();
            }
            setTimeout("b4_startRequest()", <?=$replace_time?>);          
        }
    }
}

function b4_startRequest_me_memo_call() {
    b4_createXMLHttpRequest();
    xmlHttp.open("GET", "<?=$g4[bbs_path]?>/realtime_memo_update.php", true); // update program의 location
    xmlHttp.send(null);
}

<!--  레이어로 쪽지창 표시 시작 --> 

 var msn_closed = true; 
 var msn_top = 0; 
 var msn_left = 0; 
 var msn_divheight = 165; // 밑에서 부터의 높이
 var msn_divwidth  = 30; // 좌측에서 부터의 거리
 
function do_check () { 
 msn_closed = false; 
} 

function b4_msn_position() { 
   if(!msn_closed) { 
      msn_top = document.body.scrollTop + document.body.clientHeight - msn_divheight; 
      msn_left = document.body.scrollLeft + msn_divwidth; 
      document.getElementById("kissme").style.top = msn_top;
      document.getElementById("kissme").style.left = msn_left;
      document.getElementById("kissme").style.display = "";
    } 
} 

 var old_ResizeHandler = window.onresize; 
  window.onresize = new Function("{if (old_ResizeHandler != null) old_ResizeHandler(); b4_msn_position();}"); 
 var old_ScrollHandler = window.onscroll; 
  window.onscroll = new Function("{if (old_ScrollHandler != null) old_ScrollHandler(); b4_msn_position();}"); 

function b4_hideLayer(layer) { 
  if(document.layers) { 
  layer = eval('document.layers.' + layer); 
  if(layer.display != 'none') layer.display = 'none'; 
    else layer.display = ''; 
    return; 
    } 
  layer = document.getElementById(layer);
  if(layer.style.display != 'none') { 
  layer.style.display='none'; 
    } 
  else { 
  layer.style.display=''; 
    } 
msn_closed = true; 
    b4_startRequest_me_memo_call()
}
</script> 

<!-- 쪽지 음성알람 -->
<span id="memo_alarm"></span>

<!-- popup layer에 대한 정의 -->
<div id="kissme" name="kissme" style="position:absolute; overflow: hidden; top:10; left:10; z-index: 999999; display: none; width:203; height:165; layer-background-color:rgb(255,204,255);"> 
<table width="193" border="0" cellspacing="0" cellpadding="0" class="message01">
  <tr>
    <td height="33"><img src="<?=$g4[bbs_path]?>/img/message_01.gif" width="193" height="33" border="0" usemap="#Map" /></td>
  </tr>
  <tr>
    <td height="114" align="center" background="<?=$g4[bbs_path]?>/img/message_02.gif">
    <table width="150" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="message01"><br>
          <strong><?=$member[mb_name]?></strong>님<br>
          <br><span id="memo_mb_nick"></span>님으로부터<br>쪽지가 도착했습니다<br>
          확인하시겠습니까?<br></td>
      </tr>
      <tr>
        <td align="center">
        <a href="javascript:win_memo();b4_hideLayer('kissme');"><img src="<?=$g4[bbs_path]?>/img/message_btn_01.gif" width="59" height="21" border="0"></a>
<!--
        <a href="#" onclick="window.open('<?=$g4[bbs_path]?>/memo.php','member_memo','width=610,height=460,status=no,toolbar=no,resizable=yes,scrollbars=yes');b4_hideLayer('kissme');"><img src="<?=$g4[bbs_path]?>/img/message_btn_01.gif" width="59" height="21" border="0"></a>
-->
        <a href="#" onclick='b4_hideLayer("kissme");'><img src="<?=$g4[bbs_path]?>/img/message_btn_closs.gif" width="59" height="21" border="0"></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="<?=$g4[bbs_path]?>/img/message_03.gif" width="193" height="15" /></td>
  </tr>
</table>
</div> 

<map name="Map"><area shape="rect" coords="168,10,183,24" href="#" onclick='b4_hideLayer("kissme")'></map>
<? } ?>
