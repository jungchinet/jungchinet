
// 셀렉트 박스에 디자인을 입히기 위한 대체 스크립트
// http://www.psyonline.kr/1268996171

// 옵션설정
fakeselect.initialize=function(){
	fakeselect({
		targetclassname : '',
		ignoreclassname : '',
		usemultiple : true,
		title : {
			classname : 'selectbox_title',
			activeclassname : 'selectbox_title_active',
			focusclassname : 'selectbox_title_focus',
			disabledclassname : 'selectbox_title_disabled',
			innerhtml : '<strong></strong>'
		},
		option : {
			classname : 'selectbox_option',
			innerhtml : '<div class="scroll"></div>',
			position : -1,
			upperposition : 1,
			zindex : 10,
			maxitems : 5,
			onclassname : 'on'
		},
		multiple : {
			defaultsize : 5,
			classname : 'selectbox_multiple',
			focusclassname : 'selectbox_multiple_focus',
			disabledclassname : 'selectbox_multiple_disabled',
			innerhtml : '<div class="scroll"></div>',
			onclassname : 'on'
		}
	});
}

function fakeselect(v){

	var isie=(/msie/i).test(navigator.userAgent);
	var isie8=(/msie 8/i).test(navigator.userAgent);
	var isie9=(/msie 9/i).test(navigator.userAgent);
	var isfirefox=(/firefox/i).test(navigator.userAgent);
	var isapple=(/applewebkit/i).test(navigator.userAgent);
	var isopera=(/opera/i).test(navigator.userAgent);
	var ismobile=(/(iphone|ipod|android)/i).test(navigator.userAgent);
	if((/msie 9/i).test(navigator.userAgent)) isie=false;

	if(!v.title.defaultwidth) v.title.defaultwidth=75;
	if(!v.option.position) v.option.position=-1;
	if(!v.option.upperposition) v.option.upperposition=1;
	if(!v.option.zindex) v.option.zindex=1;

	var sels=document.getElementsByTagName('select');
	for(var i=0,max=sels.length; i<max; i++){
		if(v.ignoreclassname && (new RegExp('\\b'+v.ignoreclassname+'\\b')).test(sels[i].className)) continue;
		if(!v.targetclassname || (new RegExp('\\b'+v.targetclassname+'\\b')).test(sels[i].className)){
			if(sels[i].multiple && !v.usemultiple) continue;
			if(!sels[i].ac){
				sels[i].ac=create(sels[i]);
				sels[i].change=function(){
					this.ac.ckdisable();
					if(this.ac.opt) this.ac.tg.innerHTML=(this.options.length)? this.options[this.selectedIndex].text : '';
					else this.ac.setselected();
				}
				sels[i].sf_change=sels[i].onchange;
				sels[i].sf_mouseover=sels[i].onmouseover;
				sels[i].sf_mouseout=sels[i].onmouseout;
				sels[i].sf_click=sels[i].onclick;
				sels[i].onchange=function(){
					this.change();
					if(this.sf_change) this.sf_change();
				}
			}else sels[i].reset();
		}
	}

	function rc(sel,v,f){
		sel.noww=getwidth(sel);
		if(v.widthminus==undefined){
			v.widthminus=0;
			var t=document.createElement((f=='option')? 'div' : 'span');
			t.className=v.classname;
			with(t.style){
				position='absolute';
				left='-100000px';
				top=0;
			}
			document.body.appendChild(t);
			var cklist=['paddingLeft','paddingRight','borderLeftWidth','borderRightWidth'];
			for(var i=0; i<4; i++) v.widthminus+=parseInt(getstyle(t,cklist[i]));
			document.body.removeChild(t);
		}
		var tagname,style,width=sel.noww-v.widthminus;
		if(f=='option'){
			tagname='div';
			if(sel.className){
				var ck=sel.className.match(/\b(selectbox-option-width\:([0-9]+)(px)?)\b/i);
				if(ck){
					width=sel.optionwidth=ck[2]-v.widthminus;
					sel.className=sel.className.replace(/\bselectbox-option-width\:[0-9]+(px)?\b/i,'');
				}
			}
			style='position:absolute;width:'+width+'px;display:none;z-index:'+v.zindex;
		}else{
			sel.style.position='absolute';
			sel.style.left='-100000px';
			tagname='span';
			style='width:'+width+'px;vertical-align:middle;display:';
			if(((sel.style.display)? sel.style.display : getstyle(sel,'display'))=='none'){
				style+='none;';
				sel.style.display='none';
			}else style+='inline-block;';
			style+=(f=='multiple')? 'cursor:default;' : 'cursor:pointer;';
		}
		var rv, occk=true;
		if(isie){
			try{
				occk=false;
				rv=document.createElement('<'+tagname+' class="'+((v.classname)? (sel.className)? v.classname+' '+sel.className : v.classname : '')+'" style="'+style+'">');
			}catch(e){
				occk=true;
			}
		}
		if(occk){
			rv=document.createElement(tagname);
			if(v.classname) rv.setAttribute('class',(sel.className)? v.classname+' '+sel.className : v.classname);
			rv.setAttribute('style',style);
		}
		if(v.innerhtml){
			rv.innerHTML=v.innerhtml;
			rv.tg=rv.childNodes[0];
			for(var i=0; i<1; i++){
				if((f=='option' || f=='multiple') && rv.tg.className=='scroll') rv.scrobj=rv.tg;
				if(rv.tg.childNodes[0]){
					rv.tg=rv.tg.childNodes[0];
					i--;
				}
			}
		}else rv.tg=rv;
		rv.onselectstart=function(){
			return false;
		}
		return rv;
	}

	function create(sel){

		var ac;

		if(!sel.multiple){//normal

			ac=rc(sel,v.title);
			if(sel.length) ac.tg.innerHTML=sel.options[sel.selectedIndex].text;
			ac.onclick=function(){
				if(sel.disabled) return false;
				if(ismobile){
					sel.focus();
					return false;
				}
				if(this.opt.style.display=='block'){
					optclose();
					sel.focus();
					return false;
				}
				this.className+=' '+v.title.activeclassname;
				setoptions();
				var opts=(this.opt.tg)? ac.opt.tg.getElementsByTagName('a') : this.opt.getElementsByTagName('a');
				for(var i=0,max=opts.length; i<max; i++) opts[i].className=(i==sel.selectedIndex)? v.option.onclassname : '';
				this.opt.style.left=this.opt.style.top='-100000px';
				this.opt.style.display='block';
				if(this.opt.scrobj){
					if(sel.scroll){
						var sto=this.opt.getElementsByTagName('li')[0];
						this.opt.scrobj.style.height=sto.offsetHeight*v.option.maxitems+'px';
						this.opt.scrobj.scrollTop=sto.offsetHeight*sel.selectedIndex;
						this.opt.scrobj.style.overflow='auto';
						this.opt.scrobj.style.overflowX='hidden';
					}else{
						this.opt.scrobj.style.height='auto';
						this.opt.scrobj.style.overflow='hidden';
					}
				}
				var scl=(isapple)? document.body.scrollLeft : document.documentElement.scrollLeft;
				var sct=(isapple)? document.body.scrollTop : document.documentElement.scrollTop;
				var bcr=this.getBoundingClientRect();
				var left=bcr.left+scl-document.documentElement.clientLeft;
				var top=bcr.top+sct-document.documentElement.clientTop;
				var isupper=((top+this.offsetHeight+this.opt.offsetHeight)>(document.documentElement.clientHeight+sct));
				if(sel.optionwidth && (left+this.opt.offsetWidth)>(document.documentElement.clientWidth+scl)){
					left=left-(this.opt.offsetWidth-sel.noww);
				}
				this.opt.style.left=left+'px';
				this.opt.style.top=(isupper)? (top-this.opt.offsetHeight+v.option.upperposition)+'px' : (top+this.offsetHeight+v.option.position)+'px';
				if(sel.sf_click) sel.sf_click();
				return false;
			}

			function setoptions(){
				var max=sel.options.length;
				sel.scroll=(v.option.maxitems && (max>v.option.maxitems));
				var inhtml='<ul>';
				for(var i=0; i<max; i++) inhtml+='<li><a href="#">'+sel.options[i].text+'</a></li>';
				inhtml+='</ul>';
				if(ac.opt.tg){
					ac.opt.tg.innerHTML=inhtml;
					var opts=ac.opt.tg.getElementsByTagName('a');
				}else{
					ac.opt.innerHTML=inhtml;
					var opts=ac.opt.getElementsByTagName('a');
				}
				for(var i=0,max=opts.length; i<max; i++){
					opts[i].i=i;
					opts[i].onclick=function(){
						optclose();
						ac.tg.innerHTML=sel.options[this.i].text;
						sel.options[this.i].selected='selected';
						sel.onchange();
						sel.focus();
						return false;
					}
				}
			}

			function setselected(f){
				var changed=false;
				if(f=='up' && sel.selectedIndex>0){
					sel.options[sel.selectedIndex-1].selected='selected';
					changed=true;
				}else if(f=='down' && sel.selectedIndex<(sel.options.length-1)){
					sel.options[sel.selectedIndex+1].selected='selected';
					changed=true;
				}
				if(changed && ac.opt.scrobj && sel.scroll){
					var sto=ac.opt.getElementsByTagName('li')[0];
					ac.opt.scrobj.scrollTop=sto.offsetHeight*sel.selectedIndex;
				}
				sel.onchange();
			}

			if(!isie && !isopera){
				sel.onkeydown=function(e){
					var kc=e.keyCode;
					if(kc==38){
						setselected('up');
						return false;
					}else if(kc==40){
						setselected('down');
						return false;
					}
				}
			}

			function wheelaction(e){
				if(isie) e=window.event;
				if(sel.options.length>1){
					var wv=(e.wheelDelta)? e.wheelDelta : e.detail;
					wv=(isfirefox)? (wv<0)? 'up' : 'down' : (wv>0)? 'up' : 'down';
					setselected(wv);
				}
				if(e.preventDefault) e.preventDefault();
				return false;
			}

			ac.opt=rc(sel,v.option,'option');

			function optwheelaction(e){
				if(!sel.scroll) return false;
				if(isie) e=window.event;
				var wv=(e.wheelDelta)? e.wheelDelta : e.detail;
				wv=(isfirefox)? (wv<0)? 'up' : 'down' : (wv>0)? 'up' : 'down';
				var mv=this.getElementsByTagName('li')[0].offsetHeight*((v.option.maxitems>2)? 2 : 1);
				this.scrobj.scrollTop+=(wv=='up')? -mv : mv;
				if(e.preventDefault) e.preventDefault();
				return false;
			}

			if(isie) ac.opt.onmousewheel=optwheelaction;
			else ac.opt.addEventListener(((isfirefox)? 'DOMMouseScroll' : 'mousewheel'),optwheelaction,false);

			if(ac.opt.scrobj){
				ac.opt.scrobj.onscroll=function(){
					var stoh=this.getElementsByTagName('li')[0].offsetHeight;
					this.scrollTop=Math.round(this.scrollTop/stoh)*stoh;
				}
			}

			var optclosetimer=null;
			ac.opt.onmouseover=function(){
				clearTimeout(optclosetimer);
			}
			ac.opt.onmouseout=function(){
				optclosetimer=setTimeout(optclose,100);
			}
			function optclose(){
				if(ac.opt.style.display=='block'){
					ac.opt.style.display='none';
					ac.className=ac.className.replace(' '+v.title.activeclassname, '');
					sel.focus();
				}
			}

		}else{//multiple

			ac=rc(sel,v.multiple,'multiple');

			ac.setoptions=function(){
				ac.tg.innerHTML='';
				var inhtml='<ul>';
				for(var i=0,max=sel.options.length; i<max; i++) inhtml+='<li>'+sel.options[i].text+'</li>';
				inhtml+='</ul>';
				ac.tg.innerHTML=inhtml;
				sel.parentNode.insertBefore(ac,sel);
				sel.size=(sel.size)? sel.size : v.multiple.defaultsize;
				sel.scroll=max>sel.size;
				ac.opts=ac.tg.getElementsByTagName('li');
				if(!ac.opts[0]) ac.tg.innerHTML='<ul><li>&nbsp;</li></ul>';
				ac.scrobj.style.height=(sel.size*ac.opts[0].offsetHeight)+'px';
				var last;
				for(var i=0,max=sel.options.length; i<max; i++){
					ac.opts[i].i=i;
					if(sel.options[i].selected) last=i;
					ac.opts[i].className=(sel.options[i].selected)? v.multiple.onclassname : '';
					ac.opts[i].onmousedown=mousedown;
				}
				ac.clickindex=sel.options.selectedIndex;
				var tnb=gettnbindex();
				if(last>tnb[1]) ac.scrobj.scrollTop=ac.scrobj.scrollTop+((last-tnb[1])*ac.opts[0].offsetHeight);
			}

			ac.setselected=function(){
				for(var i=0,max=sel.options.length; i<max; i++){
					ac.opts[i].className=(sel.options[i].selected)? v.multiple.onclassname : '';
				}
			}

			function mousedown(e){
				if(sel.disabled) return false;
				clearTimeout(ac.bluringtimer);
				if(!e) e=window.event;
				if(e.shiftKey && ac.clickindex>-1) multiselect(ac.clickindex,this.i);
				else{
					if(e.ctrlKey) this.className=(this.className=='on')? '' : v.multiple.onclassname;
					else{
						for(var i=0,max=ac.opts.length; i<max; i++){
							ac.opts[i].className=(i==this.i)? v.multiple.onclassname : '';
						}
					}
					ac.clickindex=this.i;
				}
				ac.clicky=e.clientY-((e.layerY)? e.layerY : e.offsetY);
				ac.fmy=ac.clicky;
				ac.mode=true;
				if(sel.scroll){
					ac.scrolly=ac.scrobj.scrollTop;
					var tnb=gettnbindex();
					ac.gap=[tnb[0]-ac.clickindex,tnb[1]-ac.clickindex];
				}
				addevent(document.documentElement,'mousemove',mousemove);
				addevent(document.documentElement,'mouseup',mouseup);
				sel.focus();
				return false;
			}

			function mousemove(e){
				if(isie8){
					ac.onselectstart=function(){
						return false;
					}
				}
				clearTimeout(ac.bluringtimer);
				if(!ac.mode) return false;
				if(!e) e.window.event;
				var y=e.clientY;
				var nindex=ac.clickindex+(Math.ceil((y-ac.fmy)/ac.opts[0].offsetHeight)-1);
				if(0>nindex) nindex=0;
				if(nindex>ac.opts.length-1) nindex=ac.opts.length-1;
				multiselect(ac.clickindex,nindex);
				if(sel.scroll){
					if(nindex>-1 || ac.opts.length-1>nindex){
						var tnb=gettnbindex();
						if(tnb[0]>nindex || nindex>tnb[1]){
							var cv=(nindex-ac.clickindex-((tnb[0]>nindex)? ac.gap[0] : ac.gap[1]))*ac.opts[0].offsetHeight;
							ac.scrobj.scrollTop=ac.scrolly+cv;
							ac.fmy=ac.clicky-cv;
						}
					}
				}
			}

			function gettnbindex(){
				var top=Math.ceil(ac.scrobj.scrollTop/ac.opts[0].offsetHeight);
				return [top,top+sel.size-1];
			}

			function multiselect(v1,v2){
				var imin=Math.min(v1,v2);
				var imax=Math.max(v1,v2);
				for(var i=0,max=ac.opts.length; i<max; i++){
					ac.opts[i].className=(imin<=i && imax>=i)? v.multiple.onclassname : '';
				}
			}

			function mouseup(e){
				if(!ac.mode) return false;
				for(var i=0,max=ac.opts.length; i<max; i++){
					sel.options[i].selected=(ac.opts[i].className)? 'selected' : false;
				}
				ac.mode=false;
				removeevent(document.documentElement,'mousemove',mousemove);
				removeevent(document.documentElement,'mouseup',mouseup);
				sel.focus();
			}

			function mwheelaction(e){
				if(sel.disabled || !sel.scroll) return false;
				clearTimeout(ac.bluringtimer);
				if(isie) e=window.event;
				var wv=(e.wheelDelta)? e.wheelDelta : e.detail;
				wv=(isfirefox)? (wv<0)? 'up' : 'down' : (wv>0)? 'up' : 'down';
				var mv=ac.opts[0].offsetHeight*((v.option.maxitems>2 && sel.size>1)? 2 : 1);
				this.scrollTop+=(wv=='up')? -mv : mv;
				if(e.preventDefault) e.preventDefault();
				return false;
			}

			if(isie) ac.scrobj.onmousewheel=mwheelaction;
			else ac.scrobj.addEventListener(((isfirefox)? 'DOMMouseScroll' : 'mousewheel'),mwheelaction,false);

			ac.scrobj.onscroll=function(){
				clearTimeout(ac.bluringtimer);
				var stoh=ac.opts[0].offsetHeight;
				this.scrollTop=Math.round(this.scrollTop/stoh)*stoh;
			}

			sel.onkeydown=function(e){
				if(!this.scroll) return;
				clearTimeout(ac.bluringtimer);
				if(!e) e=window.event;
				var f;
				if(!ac.clickindex) ac.clickindex=this.options.selectedIndex;
				if(e.keyCode==40 || e.keyCode==38){
					if(e.keyCode==40){
						f=='down';
						ac.clickindex=(ac.clickindex==ac.opts.length-1)? ac.opts.length-1 : (this.options.selectedIndex==-1)? (isie)? 1 : 0 : ac.clickindex+1;
					}else if(e.keyCode==38){
						f=='up';
						ac.clickindex=(ac.clickindex==0)? 0 : ac.clickindex-1;
					}
					var tnb=gettnbindex();
					var sv=(tnb[0]>ac.clickindex)? ac.clickindex-tnb[0] : (ac.clickindex>tnb[1])? ac.clickindex-tnb[1] : 0;
					this.ac.scrobj.scrollTop=this.ac.scrobj.scrollTop+(sv*this.ac.opts[0].offsetHeight);
				}
			}

			ac.setoptions();

		}

		ac.ckdisable=function(){
			if(sel.disabled){
				if(!sel.multiple && v.title.disabledclassname) this.className+=' '+v.title.disabledclassname;
				else if(sel.multiple && v.multiple.disabledclassname) this.className+=' '+v.multiple.disabledclassname;
				else setopacity(this,50);
			}else{
				if(!sel.multiple && v.title.disabledclassname) this.className=this.className.replace(new RegExp('\\b'+v.title.disabledclassname+'\\b','g'),'');
				else if(sel.multiple && v.multiple.disabledclassname) this.className=this.className.replace(new RegExp('\\b'+v.multiple.disabledclassname+'\\b','g'),'');
				else setopacity(this,100);
			}
			if(sel.multiple){
				this.scrobj.style.overflow=(sel.disabled)? 'hidden' : 'auto';
				this.scrobj.style.overflowX='hidden';
			}
		}
		ac.ckdisable();

		ac.bluringtimer=null;
		ac.focusing=function(){
			if(sel.disabled) return false;
			if(this.opt){
				this.className+=' '+v.title.focusclassname;
				if(isie) this.onmousewheel=wheelaction;
				else this.addEventListener(((isfirefox)? 'DOMMouseScroll' : 'mousewheel'),wheelaction,false);
			}else{
				clearTimeout(ac.bluringtimer);
				this.className+=' '+v.multiple.focusclassname;
			}
		}
		ac.bluring=function(){
			if(sel.disabled) return false;
			if(this.opt){
				this.className=this.className.replace(new RegExp(' '+v.title.focusclassname,'g'),'');
				if(isie) this.onmousewheel=null;
				else this.removeEventListener(((isfirefox)? 'DOMMouseScroll' : 'mousewheel'),wheelaction,false);
			}else{
				ac.bluringtimer=setTimeout(function(){
					ac.className=ac.className.replace(new RegExp(' '+v.multiple.focusclassname,'g'),'')
				},200);
			}
		}
		sel.onfocus=function(){
			ac.focusing();
		}
		sel.onblur=function(){
			ac.bluring();
		}

		sel.reset=function(){
			if(!sel.ac.opt) sel.ac.setoptions();
			this.change();
			this.style.height='auto'; //ie bug
			var noww=getwidth(this);
			if(noww!=this.noww){
				if(sel.ac.opt){
					sel.ac.style.width=(noww-v.title.widthminus)+'px';
					sel.ac.opt.style.width=(v.option.widthminus)? (noww-v.option.widthminus)+'px' : noww+'px';
				}else{
					sel.ac.style.width=(noww-v.multiple.widthminus)+'px';
				}
				sel.noww=noww;
			}
		}
		sel.show=function(){
			this.style.display='inline';
			this.ac.style.display='inline-block';
			this.reset();
		}
		sel.hide=function(){
			this.style.display='none';
			this.ac.style.display='none';
		}

		ac.onmouseover=function(e){
			if(this.opt) clearTimeout(optclosetimer);
			if(sel.sf_mouseover){
				if(!e) e=window.event;
				if(checkevents(e,this)) sel.sf_mouseover();
			}
		}
		ac.onmouseout=function(e){
			if(this.opt) optclosetimer=setTimeout(optclose,100);
			if(sel.sf_mouseout){
				if(!e) e=window.event;
				if(checkevents(e,this)) sel.sf_mouseout();
			}
		}

		if(ac.opt){
			sel.parentNode.insertBefore(ac,sel);
			document.body.appendChild(ac.opt);
		}

		return ac;

	}

	function getwidth(sel){
		var rv=(sel.style.width)? parseInt(sel.style.width) : sel.offsetWidth;
		if(!rv) rv=parseInt(getstyle(sel,'width'));
		if(!rv) rv=v.title.defaultwidth;
		return rv;
	}

	function getstyle(tg,p){
		return (tg.currentStyle)? tg.currentStyle[p] : window.getComputedStyle(tg,null)[p];
	}

	function setopacity(tg,v){
		if(isie) tg.style.filter='alpha(opacity='+v+')';
		else tg.style.opacity=v/100;
	}

	function addevent(tg,w,func){
		if(window.attachEvent) tg.attachEvent('on'+w,func);
		else tg.addEventListener(w,func,false);
	}

	function removeevent(tg,w,func){
		if(window.detachEvent) tg.detachEvent('on'+w,func);
		else tg.removeEventListener(w,func,false);
	}

	function checkevents(e,tg){
		var etg=(e.target)? e.target : e.srcElement;
		if(etg!=tg) return false;
		var ereltg=(e.relatedTarget)? e.relatedTarget : (e.type=='mouseover')? e.fromElement : e.toElement;
		if(ereltg){
			while(ereltg!=tg && !(/(body|html)/i).test(ereltg.tagName)) ereltg=ereltg.parentNode;
			if(ereltg==tg) return false;
		}
		return true;
	}

}

//reference : http://blog.outofhanwell.com/2006/06/08/the-windowonload-problem-revisited/
if(window.addEventListener){
	window.addEventListener('DOMContentLoaded',fakeselect.initialize,false);
	window.addEventListener('load',fakeselect.initialize,false);
}else if(window.attachEvent){
	document.write('<script id="deferscript" defer="defer" src="//[]"></script>');
	var deferscript=document.getElementById('deferscript');
	deferscript.onreadystatechange=function(){
		if(this.readyState==='complete'){
			deferscript=null;
			fakeselect.initialize();
		}
	}
	window.attachEvent('onload',fakeselect.initialize);
}