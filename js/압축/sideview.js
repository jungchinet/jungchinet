if (typeof(SIDEVIEW_JS) == 'undefined')
{ if (typeof g4_is_member == 'undefined')
alert('g4_is_member 변수가 선언되지 않았습니다. js/sideview.js'); if (typeof g4_path == 'undefined')
alert('g4_path 변수가 선언되지 않았습니다. js/sideview.js'); if (typeof g4_sms4 == 'undefined')
var g4_sms4 = false; var SIDEVIEW_JS = true; function insertHead(name, text, evt)
{ var idx = this.heads.length; var row = new SideViewRow(-idx, name, text, evt); this.heads[idx] = row; return row;}
function insertTail(name, evt)
{ var idx = this.tails.length; var row = new SideViewRow(idx, name, evt); this.tails[idx] = row; return row;}
function SideViewRow(idx, name, onclickEvent)
{ this.idx = idx; this.name = name; this.onclickEvent = onclickEvent; this.renderRow = renderRow; this.isVisible = true; this.isDim = false;}
function renderRow()
{ if (!this.isVisible)
return ""; var str = "<tr height='19'><td id='sideViewRow_"+this.name+"'>&nbsp;<font color=gray>&middot;</font>&nbsp;<span style='color: #A0A0A0;  font-family: 돋움; font-size: 11px;'>"+this.onclickEvent+"</span></td></tr>"; return str;}
function showSideView(curObj, mb_id, name, email, homepage)
{ var sideView = new SideView('nameContextMenu', curObj, mb_id, name, email, homepage); sideView.showLayer(curObj, 14);}
function SideView(targetObj, curObj, mb_id, name, email, homepage, domain)
{ this.targetObj = targetObj; this.curObj = curObj; this.mb_id = mb_id; name = name.replace(/…/g,""); this.name = name; this.email = email; this.homepage = homepage; this.showLayer = showLayer; this.makeNameContextMenus = makeNameContextMenus; this.heads = new Array(); this.insertHead = insertHead; this.tails = new Array(); this.insertTail = insertTail; this.getRow = getRow; this.hideRow = hideRow; this.dimRow = dimRow; if (mb_id)
this.insertTail("memo", "<a href=\"javascript:win_memo('"+g4_path+"/" + g4_bbs + "/memo.php?kind=write&me_recv_mb_id="+mb_id+"', '" + mb_id + "', '" + domain + "');\">쪽지보내기</a>"); if (email)
this.insertTail("mail", "<a href=\"javascript:;\" onclick=\"win_formmail('"+mb_id+"','"+name+"','');\">메일보내기</a>"); if (homepage)
this.insertTail("homepage", "<a href=\"javascript:;\" onclick=\"window.open('"+homepage+"');\">홈페이지</a>"); if (mb_id)
this.insertTail("info", "<a href=\"javascript:;\" onclick=\"win_profile('"+mb_id+"');\">자기소개</a>"); if (g4_bo_table) { if (mb_id)
this.insertTail("mb_id", "<a href='"+g4_path+"/" + g4_bbs + "/board.php?bo_table="+g4_bo_table+"&sca="+g4_sca+"&sfl=mb_id,1&stx="+mb_id+"'>아이디로 검색</a>"); else
this.insertTail("name", "<a href='"+g4_path+"/" + g4_bbs + "/board.php?bo_table="+g4_bo_table+"&sca="+g4_sca+"&sfl=wr_name,1&stx="+name+"'>이름으로 검색</a>");}
if (mb_id) { this.insertTail("new", "<a href='"+g4_path+"/" + g4_bbs + "/new.php?mb_id="+mb_id+"'>전체게시물</a>");}
if (g4_sms4) { this.insertTail("hp", "<a href='"+g4_path+"/sms/?mb_id="+mb_id+"'>문자 보내기</a>");}
if (g4_is_admin == "super") { if (mb_id)
this.insertTail("modify", "<a href='"+g4_path+"/" + g4_admin + "/member_form.php?w=u&mb_id="+mb_id+"' target='_blank'>회원정보변경</a>"); if (mb_id)
this.insertTail("point", "<a href='"+g4_path+"/" + g4_admin + "/point_list.php?sfl=mb_id&stx="+mb_id+"' target='_blank'>포인트내역</a>");}
}
function showLayer(btn, diff)
{ clickAreaCheck = true; var oSideViewLayer = document.getElementById(this.targetObj); var oBody = document.body; if (oSideViewLayer == null) { oSideViewLayer = document.createElement("DIV"); oSideViewLayer.id = this.targetObj; oSideViewLayer.style.position = 'absolute'; oBody.appendChild(oSideViewLayer);}
oSideViewLayer.innerHTML = this.makeNameContextMenus(); var layerPos = getCoords(btn); if (diff && diff.left) { layerPos.left+=diff.left;}
if (diff && diff.top) { layerPos.top+=diff.top;}
oSideViewLayer.style.left = layerPos.left + "px"; oSideViewLayer.style.top = layerPos.top + layerPos.height + "px"; divDisplay(this.targetObj, 'block'); selectBoxHidden(this.targetObj);}
function getAbsoluteTop(oNode)
{ var oCurrentNode=oNode; var iTop=0; while(oCurrentNode.tagName!="BODY") { iTop+=oCurrentNode.offsetTop - oCurrentNode.scrollTop; oCurrentNode=oCurrentNode.offsetParent;}
return iTop;}
function getAbsoluteLeft(oNode)
{ var oCurrentNode=oNode; var iLeft=0; iLeft+=oCurrentNode.offsetWidth; while(oCurrentNode.tagName!="BODY") { iLeft+=oCurrentNode.offsetLeft; oCurrentNode=oCurrentNode.offsetParent;}
return iLeft;}
function getCoords(e, permissibleRange){ var scope = permissibleRange ? permissibleRange : null; if(typeof(e) == 'object'){ var element = e;} else { var element = document.getElementById(e);}
var w = element.offsetWidth; var h = element.offsetHeight; var coords = { "left" : 0, "top" : 0, "right" : 0, "bottom" : 0 , "width" : 0 , "height" : 0 }; while(element){ if(element.tagName == "HTML") break; coords.left += element.offsetLeft || 0; coords.top += element.offsetTop || 0; element = element.offsetParent; if(!scope && element){ var isPosRel = getStyle(element, "position"); if(isPosRel !== "static") break;}
if(scope && element && element.tagName != "BODY" && element.tagName != "HTML") { coords.top -= element.scrollTop;}
}
coords.width = w; coords.height = h; coords.right = coords.left + w; coords.bottom = coords.top + h; return coords;}
function getStyle(e, cssProperty, mozCssProperty){ var mozCssProperty = mozCssProperty || cssProperty; return (e.currentStyle) ? e.currentStyle[cssProperty] : document.defaultView.getComputedStyle(e, null).getPropertyValue(mozCssProperty);}
function makeNameContextMenus()
{ var str = "<table border='0' cellpadding='0' cellspacing='0' width='90' style='border:1px solid #E0E0E0;' bgcolor='#F9FBFB'>"; var i=0; for (i=this.heads.length - 1; i >= 0; i--)
str += this.heads[i].renderRow(); var j=0; for (j=0; j < this.tails.length; j++)
str += this.tails[j].renderRow(); str += "</table>"; return str;}
function getRow(name)
{ var i = 0; var row = null; for (i=0; i<this.heads.length; ++i)
{ row = this.heads[i]; if (row.name == name) return row;}
for (i=0; i<this.tails.length; ++i)
{ row = this.tails[i]; if (row.name == name) return row;}
return row;}
function hideRow(name)
{ var row = this.getRow(name); if (row != null)
row.isVisible = false;}
function dimRow(name)
{ var row = this.getRow(name); if (row != null)
row.isDim = true;}
function selectBoxHidden(layer_id)
{ var ly = document.getElementById(layer_id); var ly_left = ly.offsetLeft; var ly_top = ly.offsetTop; var ly_right = ly.offsetLeft + ly.offsetWidth; var ly_bottom = ly.offsetTop + ly.offsetHeight; var el; for (i=0; i<document.forms.length; i++) { for (k=0; k<document.forms[i].length; k++) { el = document.forms[i].elements[k]; if (el.type == "select-one") { var el_left = el_top = 0; var obj = el; if (obj.offsetParent) { while (obj.offsetParent) { el_left += obj.offsetLeft; el_top += obj.offsetTop; obj = obj.offsetParent;}
}
el_left += el.clientLeft; el_top += el.clientTop; el_right = el_left + el.clientWidth; el_bottom = el_top + el.clientHeight; if ( (el_left >= ly_left && el_top >= ly_top && el_left <= ly_right && el_top <= ly_bottom) || (el_right >= ly_left && el_right <= ly_right && el_top >= ly_top && el_top <= ly_bottom) || (el_left >= ly_left && el_bottom >= ly_top && el_right <= ly_right && el_bottom <= ly_bottom) || (el_left >= ly_left && el_left <= ly_right && el_bottom >= ly_top && el_bottom <= ly_bottom) || (el_top <= ly_bottom && el_left <= ly_left && el_right >= ly_right)
)
el.style.visibility = 'hidden';}
}
}
}
function selectBoxVisible()
{ for (i=0; i<document.forms.length; i++)
{ for (k=0; k<document.forms[i].length; k++)
{ el = document.forms[i].elements[k]; if (el.type == "select-one" && el.style.visibility == 'hidden')
el.style.visibility = 'visible';}
}
}
function getAbsoluteTop(oNode)
{ var oCurrentNode=oNode; var iTop=0; while(oCurrentNode.tagName!="BODY") { iTop+=oCurrentNode.offsetTop - oCurrentNode.scrollTop; oCurrentNode=oCurrentNode.offsetParent;}
return iTop;}
function getAbsoluteLeft(oNode)
{ var oCurrentNode=oNode; var iLeft=0; iLeft+=oCurrentNode.offsetWidth; while(oCurrentNode.tagName!="BODY") { iLeft+=oCurrentNode.offsetLeft; oCurrentNode=oCurrentNode.offsetParent;}
return iLeft;}
function divDisplay(id, act)
{ selectBoxVisible(); document.getElementById(id).style.display = act;}
function hideSideView()
{ if (document.getElementById("nameContextMenu"))
divDisplay ("nameContextMenu", 'none');}
var clickAreaCheck = false; document.onclick = function()
{ if (!clickAreaCheck)
hideSideView(); else
clickAreaCheck = false;}
}
