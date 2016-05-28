//////////////////////////////////////
// IE Embed patch
//
// @author iezn@iezn.com
// @homepage http://iezn.com

// @create date 2006.04.19
// @last modify 2006.04.25
// @version 0.41
// 배포시 위내용을 포함해 주시기 바랍니다
//////////////////////////////////////

/**
* embed 패치 적용 컨테이너
* null인경우 document 값을 기본으로 합니다
* id값을 설정한경우 설정범위 내에만 적용이 됩니다
* 
* 본문이나 일부 노드에만 적용할경우 해당 노드의 id 값을 입력하실 수 있습니다
* 예)
* var __embed_target_id = "contents";
* 로 처리한경우 body 내에 <태그 id="contents">플래쉬,동영상...</태그>
* 안에 내용에만 패치가 적용됩니다
*/
if(typeof(__embed_target_id)=='undefined'){
var __embed_target_id = null;
}

/**
* embed 패치를 적용할 태그를 설정합니다
* 기본값은 object,eembed,appelt 태그입니다
* false 값인경우 패치에서 제외됩니다
*/
if(typeof(__embed_tags)=='undefined'){
var __embed_tags = {object:true,embed:true,applet:false}
}

/**
* 플래쉬파일중 flashvars 를 사용할경우 해당 플래쉬의 오브젝트아이디:true 값으로 object를 등록해 주세요
*/
var __flash_force_objs = {};

if(document.attachEvent){
document.write('<style type="text/css">');
document.write('object,embed{display:none;}');
document.write('</style>');
document.attachEvent('onreadystatechange',
function (){

if(__embed_target_id===null){
var __target = document;
}else{
var __target = document.getElementById(__embed_target_id);
}
if (document.readyState == "complete"){
function _replace(obj){
var obj_re = document.createElement(obj.outerHTML); 
obj_re.style.display='inline';
obj.parentNode.replaceChild(obj_re,obj);
}
function _inner(obj){
obj.style.display='inline'; 
var html = obj.outerHTML;
var classid = obj.classid.toLowerCase();
if(classid=='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' && typeof(__flash_force_objs[obj.id])=='undefined'){//flash 인경우
obj.insertAdjacentHTML('beforeBegin',html);
obj.parentNode.removeChild(obj);
}else{ 
//변경하고자하는 ActiveX classid 를 추가하시기 바랍니다
if(classid=='clsid:6bf52a52-394a-11d3-b153-00c04f79faa6' || //media 7
classid=='clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95' || //6.4
classid=='clsid:6bf52a52-394a-11d3-b153-00c04f79faa6' ||
classid=='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' 
){//media player 10
embed_pos = html.indexOf('embed');
if(embed_pos!=-1){//embed 가 존재하는경우
var embed = '<'+html.substr(embed_pos);
embed = embed.substr(0,embed.length-9);
obj.insertAdjacentHTML('beforeBegin',embed);
obj.parentNode.removeChild(obj);
}else{
//object로만 되어 있는경우 동영상 부분만 패치한다
var embed = document.createElement('embed');
var total = obj.childNodes.length;
embed.setAttribute('autostart',0);
if(obj.width){
embed.setAttribute('width',obj.width);
}
if(obj.height){
embed.setAttribute('height',obj.height);
}
for(var k=0;k<total;k++){
n = obj.childNodes.item(k).getAttribute("name");
v = obj.childNodes.item(k).getAttribute("value");
if(n=='URL' || n=='url' || n=='FileName'){
n = 'src';
}
embed.setAttribute(n,v);
}
if(embed.getAttribute('src')){
embed.style.display = 'inline';
obj.parentNode.replaceChild(embed,obj);
}else{
//파일엑세스 object가 아닌경우는 유지한다 
}
}
}
}
}

if(__embed_tags.object===true){
var objs = __target.getElementsByTagName('object');
var i = objs.length;
while(i-->0){
_inner(objs[i]);
}
}
if(__embed_tags.embed===true){
var objs = __target.getElementsByTagName('embed');
var i = objs.length;
while(i-->0){
_replace(objs[i])
}
}

if(__embed_tags.applet===true){
var objs = __target.getElementsByTagName('applet');
var i = objs.length;
while(i-->0){
_replace(objs[i])
}
}
}
}
);
}
