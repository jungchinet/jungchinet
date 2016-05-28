if (typeof(B4_COMMON_JS) == 'undefined') { // 한번만 실행
    var B4_COMMON_JS = true;

    // 곱슬최씨님의 mw_image_window를 이름오류 안나게 이름만 변경
    function image_window2(img, w, h)
    {
    	if (!w || !h)
    	{
            var w = img.tmp_width; 
            var h = img.tmp_height; 
    	}
    
    	var winl = (screen.width-w)/2; 
    	var wint = (screen.height-h)/3; 
    
    	if (w >= screen.width) { 
    		winl = 0; 
    		h = (parseInt)(w * (h / w)); 
    	} 
    
    	if (h >= screen.height) { 
    		wint = 0; 
    		w = (parseInt)(h * (w / h)); 
    	} 
    
    	var js_url = "<script language='JavaScript1.2'> \n"; 
    		js_url += "<!-- \n"; 
    		js_url += "var ie=document.all; \n"; 
    		js_url += "var nn6=document.getElementById&&!document.all; \n"; 
    		js_url += "var isdrag=false; \n"; 
    		js_url += "var x,y; \n"; 
    		js_url += "var dobj; \n"; 
    		js_url += "function movemouse(e) \n"; 
    		js_url += "{ \n"; 
    		js_url += "  if (isdrag) \n"; 
    		js_url += "  { \n"; 
    		js_url += "    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; \n"; 
    		js_url += "    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; \n"; 
    		js_url += "    return false; \n"; 
    		js_url += "  } \n"; 
    		js_url += "} \n"; 
    		js_url += "function selectmouse(e) \n"; 
    		js_url += "{ \n"; 
    		js_url += "  var fobj      = nn6 ? e.target : event.srcElement; \n"; 
    		js_url += "  var topelement = nn6 ? 'HTML' : 'BODY'; \n"; 
    		js_url += "  while (fobj.tagName != topelement && fobj.className != 'dragme') \n"; 
    		js_url += "  { \n"; 
    		js_url += "    fobj = nn6 ? fobj.parentNode : fobj.parentElement; \n"; 
    		js_url += "  } \n"; 
    		js_url += "  if (fobj.className=='dragme') \n"; 
    		js_url += "  { \n"; 
    		js_url += "    isdrag = true; \n"; 
    		js_url += "    dobj = fobj; \n"; 
    		js_url += "    tx = parseInt(dobj.style.left+0); \n"; 
    		js_url += "    ty = parseInt(dobj.style.top+0); \n"; 
    		js_url += "    x = nn6 ? e.clientX : event.clientX; \n"; 
    		js_url += "    y = nn6 ? e.clientY : event.clientY; \n"; 
    		js_url += "    document.onmousemove=movemouse; \n"; 
    		js_url += "    return false; \n"; 
    		js_url += "  } \n"; 
    		js_url += "} \n"; 
    		js_url += "document.onmousedown=selectmouse; \n"; 
    		js_url += "document.onmouseup=new Function('isdrag=false'); \n"; 
    		js_url += "//--> \n"; 
    		js_url += "</"+"script> \n"; 
   
      // zzzz님이 알려주셨어요. 감솨 ^^
    	var j1_url = "<script language='JavaScript1.2'> \n"; 
    		j1_url += "<!-- \n"; 
    		j1_url += "function _ReSize() { ";
    		j1_url += "   $get = document.getElementById('_img').style; ";
        j1_url += "   var ratio = document.getElementById('_img').width / document.getElementById('_img').height; ";
    		j1_url += "   $get.width = document.body.clientWidth; ";
    		j1_url += "   $get.height = document.body.clientWidth / ratio; ";
    		j1_url += "   setTimeout('_ReSize()', 100); ";
    		j1_url += "} ";
    		j1_url += "//--> \n"; 
    		j1_url += "</"+"script> \n"; 

    	var j2_url = "<script language='JavaScript1.2'> \n"; 
    		j2_url += "<!-- \n"; 
    		j2_url += "_ReSize(); ";
    		j2_url += "//--> \n"; 
    		j2_url += "</"+"script> \n"; 
 
    	var settings;
    
    	if (g4_is_gecko) {
    		settings  ='width='+(w+10)+','; 
    		settings +='height='+(h+10)+','; 
    	} else {
    		settings  ='width='+w+','; 
    		settings +='height='+h+','; 
    	}
    	settings +='top='+wint+','; 
    	settings +='left='+winl+','; 
    	settings +='scrollbars=no,'; 
    	settings +='resizable=yes,'; 
    	settings +='status=no'; 
    
    	win=window.open("","image_window",settings); 
    	win.document.open(); 
    	win.document.write ("<html><head> \n<meta http-equiv='content-type' content='text/html; charset="+g4_charset+"'>\n"); 
    	var size = "이미지 사이즈 : "+w+" x "+h;
    	win.document.write ("<title>"+size+"</title> \n"); 
    	if(w >= screen.width || h >= screen.height) { 
     		win.document.write (js_url); 
    		var click = "ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n 이미지 사이즈가 화면보다 큽니다. \n 왼쪽 버튼을 클릭한 후 마우스를 움직여서 보세요. \n\n 더블 클릭하면 닫혀요. '"; 
    	} 
    	else 
    		var click = "onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n 클릭하면 닫혀요. '"; 

   		win.document.write (j1_url); 
   		
    	win.document.write ("<style>.dragme{position:relative;}</style> \n"); 
    	win.document.write ("</head> \n\n"); 
    	win.document.write ("<body oncontextmenu='return false' leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;'> \n"); 
    	win.document.write ("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img id='_img' src='"+img.src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");

      win.document.write (j2_url); 

    	win.document.write ("</body></html>"); 
    	win.document.close(); 
    
    	if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
    
    }
    
    // img_src 값으로 이미지창을 팝업 (팬+줌)
    function image_window3(img_src, w, h)
    {
    	if (!w || !h)
    	{
            var w = img.tmp_width; 
            var h = img.tmp_height; 
    	}

    	var winl = (screen.width-w)/2; 
    	var wint = (screen.height-h)/3; 
    
    	if (w >= screen.width) { 
    		winl = 0; 
    		h = (parseInt)(w * (h / w)); 
    	} 
    
    	if (h >= screen.height) { 
    		wint = 0; 
    		w = (parseInt)(h * (w / h)); 
    	} 
    
    	var js_url = "<script language='JavaScript1.2'> \n"; 
    		js_url += "<!-- \n"; 
    		js_url += "var ie=document.all; \n"; 
    		js_url += "var nn6=document.getElementById&&!document.all; \n"; 
    		js_url += "var isdrag=false; \n"; 
    		js_url += "var x,y; \n"; 
    		js_url += "var dobj; \n"; 
    		js_url += "function movemouse(e) \n"; 
    		js_url += "{ \n"; 
    		js_url += "  if (isdrag) \n"; 
    		js_url += "  { \n"; 
    		js_url += "    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; \n"; 
    		js_url += "    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; \n"; 
    		js_url += "    return false; \n"; 
    		js_url += "  } \n"; 
    		js_url += "} \n"; 
    		js_url += "function selectmouse(e) \n"; 
    		js_url += "{ \n"; 
    		js_url += "  var fobj      = nn6 ? e.target : event.srcElement; \n"; 
    		js_url += "  var topelement = nn6 ? 'HTML' : 'BODY'; \n"; 
    		js_url += "  while (fobj.tagName != topelement && fobj.className != 'dragme') \n"; 
    		js_url += "  { \n"; 
    		js_url += "    fobj = nn6 ? fobj.parentNode : fobj.parentElement; \n"; 
    		js_url += "  } \n"; 
    		js_url += "  if (fobj.className=='dragme') \n"; 
    		js_url += "  { \n"; 
    		js_url += "    isdrag = true; \n"; 
    		js_url += "    dobj = fobj; \n"; 
    		js_url += "    tx = parseInt(dobj.style.left+0); \n"; 
    		js_url += "    ty = parseInt(dobj.style.top+0); \n"; 
    		js_url += "    x = nn6 ? e.clientX : event.clientX; \n"; 
    		js_url += "    y = nn6 ? e.clientY : event.clientY; \n"; 
    		js_url += "    document.onmousemove=movemouse; \n"; 
    		js_url += "    return false; \n"; 
    		js_url += "  } \n"; 
    		js_url += "} \n"; 
    		js_url += "document.onmousedown=selectmouse; \n"; 
    		js_url += "document.onmouseup=new Function('isdrag=false'); \n";
    		js_url += "//--> \n"; 
    		js_url += "</"+"script> \n"; 

      // zzzz님이 알려주셨어요. 감솨 ^^
    	var j1_url = "<script type/text='JavaScript'> \n"; 
    		j1_url += "<!-- \n"; 
    		j1_url += "function _ReSize() { ";
    		j1_url += "   $get = document.getElementById('_img').style; ";
        j1_url += "   var ratio = document.getElementById('_img').width / document.getElementById('_img').height; ";
    		j1_url += "   $get.width = document.body.clientWidth; ";
    		j1_url += "   $get.height = document.body.clientWidth / ratio; ";
    		j1_url += "   window.setTimeout('_ReSize()', 100); ";
    		j1_url += "} ";
    		j1_url += "//--> \n"; 
    		j1_url += "</"+"script> \n"; 

    	var j2_url = "<script type/text='JavaScript'> \n"; 
    		j2_url += "<!-- \n"; 
    		j2_url += "window.onresize=_ReSize; ";
    		j2_url += "//--> \n"; 
    		j2_url += "</"+"script> \n"; 
    
    	var settings;
    
    	if (g4_is_gecko) {
    		settings  ='width='+(w+10)+','; 
    		settings +='height='+(h+10)+','; 
    	} else {
    		settings  ='width='+w+','; 
    		settings +='height='+h+','; 
    	}
    	settings +='top='+wint+','; 
    	settings +='left='+winl+','; 
    	settings +='scrollbars=no,'; 
    	settings +='resizable=yes,'; 
    	settings +='status=no'; 
    
    	win=window.open("","image_window",settings); 
    	win.document.open(); 
    	win.document.write ("<html><head> \n<meta http-equiv='content-type' content='text/html; charset="+g4_charset+"'>\n"); 
    	var size = "이미지 사이즈 : "+w+" x "+h;
    	win.document.write ("<title>"+size+"</title> \n"); 

    	if(w >= screen.width || h >= screen.height) { 
    		win.document.write (js_url);
    		var click = "ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n 이미지 사이즈가 화면보다 큽니다. \n 왼쪽 버튼을 클릭한 후 마우스를 움직여서 보세요. \n\n 더블 클릭하면 닫혀요. '"; 
    	} 
    	else
    		var click = "onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n 클릭하면 닫혀요. '"; 

   		win.document.write (j1_url); 

    	win.document.write ("<style>.dragme{position:relative;}</style> \n"); 
    	win.document.write ("</head> \n\n"); 
    	win.document.write ("<body oncontextmenu='return false' leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;overflow:hidden;'> \n"); 
    	win.document.write ("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img id='_img' src='"+img_src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");

    	win.document.write (j2_url);

    	win.document.write ("</body></html>"); 
    	win.document.close(); 
    
    	if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
    
    }

    // bit.ly api를 이용해서 단축 경로를 생성한다
    function get_bitly_g4(tid, bo_table, wr_id) {
    
      // set up default options 
      wr_url = g4_url + '/bbs/board.php?bo_table=' + bo_table + '&wr_id=' + wr_id;
      wr_url_encode = escape(wr_url);
    
      var defaults = {
        version:    '2.0.1', 
        login:      bitly_id, 
        apiKey:     bitly_key, 
        history:    '0', 
        longUrl:    wr_url_encode
      }; 
    
      // Build the URL to query 
      var daurl = "http://api.bit.ly/shorten?" 
        +"version="+defaults.version 
        +"&longUrl="+defaults.longUrl 
        +"&login="+defaults.login 
        +"&apiKey="+defaults.apiKey 
        +"&history="+defaults.history 
        +"&format=json&callback=?"; 
    
        // Utilize the bit.ly API 
        $.getJSON(daurl, {}, function(data){ 
    
            var bitly_url = data.results[wr_url].shortUrl;
    
            // Make a good use of short URL - 화면의 url 정보를 업데이트
            $(tid).html('<a href='+bitly_url+' target=new>'+bitly_url+'</a>');
    
            url = g4_path +'/' + g4_bbs +'/g4_bitly_update.php';
    
            send  = 'bo_table=' + bo_table;
            send += '&wr_id=' + wr_id;
            send += '&bitly_url=' + bitly_url;
    
            $.ajax({
            type: 'POST',
            url: url,
            data: send,
            cache: false,
            async: false,
            success: function(result) {
    
                result      = result.split(',');
                msg_num     = result[0];
    
                if (msg_num !== '000')
                    alert('잘못된 접근입니다.\n\n'+result); 
                }
    
            });
    
        });
    
    
    };
    
    // 신고해지 창
    function win_unsingo(url)
    {
        win_open(url, "unsingo", "left=20, top=20, width=608, height=350, scrollbars=0");
    }


}
