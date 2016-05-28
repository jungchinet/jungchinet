function resizeBoardImage(imageWidth, borderColor) { var target = document.getElementsByName('target_resize_image[]'); var imageHeight = 0; if (target) { for(i=0; i<target.length; i++) { target[i].tmp_width = target[i].width; target[i].tmp_height = target[i].height; if(target[i].width >= imageWidth) { imageHeight = parseFloat(target[i].width / target[i].height)
target[i].width = imageWidth; target[i].height = parseInt(imageWidth / imageHeight); target[i].style.cursor = 'pointer'; target[i].style.width = ''; target[i].style.height = '';}
if (borderColor) { target[i].style.borderWidth = '1px'; target[i].style.borderStyle = 'solid'; target[i].style.borderColor = borderColor;}
}
}
}
function getFontSize() { var fontSize = parseInt(get_cookie("ck_fontsize")); if (isNaN(fontSize)) { fontSize = 12;}
return fontSize;}
function scaleFont(val) { var fontSize = getFontSize(); var fontSizeSave = fontSize; if (val > 0) { if (fontSize <= 18) { fontSize = fontSize + val;}
} else { if (fontSize > 12) { fontSize = fontSize + val;}
}
if (fontSize != fontSizeSave) { drawFont(fontSize);}
set_cookie("ck_fontsize", fontSize, 30, g4_cookie_domain);}
function drawFont(fontSize) { if (!fontSize) { fontSize = getFontSize();}
var subject=document.getElementById("writeSubject"); var content=document.getElementById("writeContents"); var comment=document.getElementById("commentContents"); var wr_subject=document.getElementById("wr_subject"); var wr_content=document.getElementById("wr_content"); if (comment) { var commentDiv = comment.getElementsByTagName("div"); var lineHeight = fontSize+Math.round(1.1*fontSize);}
fontSize = fontSize + "px"; if (subject)
subject.style.fontSize=fontSize; if (content)
content.style.fontSize=fontSize; if (wr_subject)
wr_subject.style.fontSize=fontSize; if (wr_content)
wr_content.style.fontSize=fontSize; if (commentDiv) { for (i=0;i<commentDiv.length;i++) { commentDiv[i].style.fontSize=fontSize;}
}
}
jQuery.resimg = function(element, options){ var setting = { imageWidth:false, minusSize:30, borderColor:false, imageWindow:false }
$.extend(setting, options); var imageWidth = setting.imageWidth; var borderColor = setting.borderColor; var minusSize = setting.minusSize; var imageWindow = setting.imageWindow; if(!imageWidth){ $(element).css("position", "absolute"); var pw = $(element).parent().innerWidth(); var plp = parseInt($(element).parent().css("padding-left").replace("px", "")); var prp = parseInt($(element).parent().css("padding-right").replace("px", "")); var tp = plp + prp; if(minusSize <= tp) minusSize = tp; imageWidth = pw - minusSize; $(element).css("position", "");}
var element = element + " img"; $(element).each(function(){ var img_width = $(this).outerWidth(); var img_height = $(this).outerHeight(); var i = $(element).index($(this)); $(element)[i].tmp_width = img_width; $(element)[i].tmp_height = img_height; if(img_width > imageWidth) { imageHeight = parseFloat(img_width/ img_height); $(this).width(imageWidth).height(parseInt(imageWidth / imageHeight)).css("cursor", "pointer");}
if (borderColor) $(this).css({ "border" : "1px solid "+ borderColor }); if (!imageWindow) { $(this).bind("contextmenu",function(e){ alert("그림에는 오른쪽마우스버튼을 사용할 수 없습니다."); return false;})
.bind("selectstart",function(e){ return false;});}
}).click(function(){ if (imageWindow) { if (!$(this).parents("a").attr("href"))
image_window(this);}
});}
function OnclickCheck(Contents, Target)
{ var A_tags = Contents.getElementsByTagName("A"); var A_tag = null; var MAP_tags = document.getElementsByTagName("MAP"); var MAP_tag = null; var AREA_tags = null; var IMG_tag = null; var IMG_MapName = ""; for (var i=0; i<A_tags.length; i++)
{ MAP_tag = null; IMG_tag = null; AREA_tags = null; A_tag = A_tags[i]; if (!A_tag.getAttribute("HREF"))
continue; if (A_tag.getAttribute("HREF").toLowerCase().indexOf("javascript") >= 0)
continue; A_tag.target = Target ? Target : "_blank"; if(typeof(A_tag.getElementsByTagName("IMG")[0]) != "undefined")
{ IMG_tag = A_tag.getElementsByTagName("IMG")[0]; if (IMG_tag.getAttribute("USEMAP"))
{ IMG_MapName = IMG_tag.getAttribute("USEMAP").replace(/#/, ""); for (var k=0; k<MAP_tags.length; k++)
{ if (MAP_tags[i].getAttribute("NAME") == IMG_MapName)
{ AREA_tags = MAP_tags[i].getElementsByTagName("AREA"); A_tag.removeAttribute("href"); A_tag.removeAttribute("HREF");}
}
}
if (IMG_tag.getAttribute("onCLICK") != null)
{ IMG_tag.onclick = null;}
}
}
return;}
