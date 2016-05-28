if (typeof(COMMON_JS) == 'undefined') { // �ѹ��� ����
    var COMMON_JS = true;

    // ���� ����
    var errmsg = "";
    var errfld;

    // �ʵ� �˻�
    function check_field(fld, msg) 
    {
        if ((fld.value = trim(fld.value)) == "") 			   
            error_field(fld, msg);
        else
            clear_field(fld);
        return;
    }

    // �ʵ� ���� ǥ��
    function error_field(fld, msg) 
    {
        if (msg != "")
            errmsg += msg + "\n";
        if (!errfld) errfld = fld;
        fld.style.background = "#BDDEF7";
    }

    // �ʵ带 �����ϰ�
    function clear_field(fld) 
    {
        fld.style.background = "#FFFFFF";
    }

    function trim(s)
    {
        var t = "";
        var from_pos = to_pos = 0;

        for (i=0; i<s.length; i++)
        {
            if (s.charAt(i) == ' ')
                continue;
            else 
            {
                from_pos = i;
                break;
            }
        }

        for (i=s.length; i>=0; i--)
        {
            if (s.charAt(i-1) == ' ')
                continue;
            else 
            {
                to_pos = i;
                break;
            }
        }	

        t = s.substring(from_pos, to_pos);
        //				alert(from_pos + ',' + to_pos + ',' + t+'.');
        return t;
    }

    // �ڹٽ�ũ��Ʈ�� PHP�� number_format �䳻�� ��
    // ���ڿ� , �� ���
    function number_format(data) 
    {
        
        var tmp = '';
        var number = '';
        var cutlen = 3;
        var comma = ',';
        var i;
       
        len = data.length;
        mod = (len % cutlen);
        k = cutlen - mod;
        for (i=0; i<data.length; i++) 
        {
            number = number + data.charAt(i);
            
            if (i < data.length - 1) 
            {
                k++;
                if ((k % cutlen) == 0) 
                {
                    number = number + comma;
                    k = 0;
                }
            }
        }

        return number;
    }

    // �� â
    function popup_window(url, winname, opt)
    {
        window.open(url, winname, opt);
    }


    // ������ â
    function popup_formmail(url)
    {
        opt = 'scrollbars=yes,width=417,height=385,top=10,left=20';
        popup_window(url, "wformmail", opt);
    }

    // , �� ���ش�.
    function no_comma(data)
    {
        var tmp = '';
        var comma = ',';
        var i;

        for (i=0; i<data.length; i++)
        {
            if (data.charAt(i) != comma)
                tmp += data.charAt(i);
        }
        return tmp;
    }

    // ���� �˻� Ȯ��
    function del(href) 
    {
        if(confirm("�ѹ� ������ �ڷ�� ������ ����� �����ϴ�.\n\n���� �����Ͻðڽ��ϱ�?")) 
            document.location.href = href;
    }

    // ��Ű �Է�
    function set_cookie(name, value, expirehours, domain) 
    {
        var today = new Date();
        today.setTime(today.getTime() + (60*60*1000*expirehours));
        document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
        if (domain) {
            document.cookie += "domain=" + domain + ";";
        }
    }

    // ��Ű ����
    function get_cookie(name) 
    {
        var find_sw = false;
        var start, end;
        var i = 0;

        for (i=0; i<= document.cookie.length; i++)
        {
            start = i;
            end = start + name.length;

            if(document.cookie.substring(start, end) == name) 
            {
                find_sw = true
                break
            }
        }

        if (find_sw == true) 
        {
            start = end + 1;
            end = document.cookie.indexOf(";", start);

            if(end < start)
                end = document.cookie.length;

            return document.cookie.substring(start, end);
        }
        return "";
    }

    // ��Ű ����
    function delete_cookie(name) 
    {
        var today = new Date();

        today.setTime(today.getTime() - 1);
        var value = get_cookie(name);
        if(value != "")
            document.cookie = name + "=" + value + "; path=/; expires=" + today.toGMTString();
    }

    // �̹����� ũ�⿡ ���� ��â�� ũ�Ⱑ ����˴ϴ�.
    // zzzz�Բ��� �˷��ּ̽��ϴ�. 2005/04/12
    function image_window(img)
    {
        var w = img.tmp_width; 
        var h = img.tmp_height; 
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
        win.document.write ("<html><head> \n<meta http-equiv='imagetoolbar' CONTENT='no'> \n<meta http-equiv='content-type' content='text/html; charset="+g4_charset+"'>\n"); 
        var size = "�̹��� ������ : "+w+" x "+h;
        win.document.write ("<title>"+size+"</title> \n"); 
        if(w >= screen.width || h >= screen.height) { 
            win.document.write (js_url); 
            var click = "ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n �̹��� ����� ȭ�麸�� Ů�ϴ�. \n ���� ��ư�� Ŭ���� �� ���콺�� �������� ������. \n\n ���� Ŭ���ϸ� ������. '"; 
        } 
        else 
            var click = "onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n Ŭ���ϸ� ������. '"; 
        win.document.write ("<style>.dragme{position:relative;}</style> \n"); 
        win.document.write ("</head> \n\n"); 
        win.document.write ("<body leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;'> \n"); 
        win.document.write ("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img src='"+img.src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");
        win.document.write ("</body></html>"); 
        win.document.close(); 

        if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
    }

    // a �±׿��� onclick �̺�Ʈ�� ������� �ʱ� ����
    function win_open(url, name, option)
    {
        var popup = window.open(url, name, option);
        popup.focus();
    }

    // �����ȣ â
    function win_zip(frm_name, frm_zip1, frm_zip2, frm_addr1, frm_addr2)
    {
        url = g4_path + "/" + g4_bbs + "/zip.php?frm_name="+frm_name+"&frm_zip1="+frm_zip1+"&frm_zip2="+frm_zip2+"&frm_addr1="+frm_addr1+"&frm_addr2="+frm_addr2;
        win_open(url, "winZip", "left=50,top=50,width=616,height=460,scrollbars=1");
    }

    // ���� â
    function win_memo(url)
    {
        if (!url)
            url = g4_path + "/" + g4_bbs + "/memo.php";
        win_open(url, "winMemo", "left=50,top=50,width=616,height=460,scrollbars=1");
    }

    // ����Ʈ â
    function win_point(url)
    {
        win_open(g4_path + "/" + g4_bbs + "/point.php", "winPoint", "left=20, top=20, width=616, height=635, scrollbars=1");
    }

    // ��ũ�� â
    function win_scrap(url)
    {
        if (!url)
            url = g4_path + "/" + g4_bbs + "/scrap.php";
        win_open(url, "scrap", "left=20, top=20, width=616, height=500, scrollbars=1");
    }

    // �Ű� â
    function win_singo(url)
    {
        win_open(url, "singo", "left=20, top=20, width=608, height=280, scrollbars=0");
    }

    // �н����� �н� â
    function win_password_forget()
    {
        win_open(g4_path + "/" + g4_bbs + "/password_forget.php", 'winPasswordForget', 'left=50, top=50, width=616, height=500, scrollbars=1');
    }

    // �ڸ�Ʈ â
    function win_comment(url)
    {
        win_open(url, "winComment", "left=50, top=50, width=800, height=600, scrollbars=1");
    }

    // ������ â
    function win_formmail(mb_id, name, email)
    {
        win_open(g4_path+"/" + g4_bbs + "/formmail.php?mb_id="+mb_id+"&name="+name+"&email="+email, "winFormmail", "left=50, top=50, width=600, height=480, scrollbars=0");
    }

    // �޷� â
    function win_calendar(fld, cur_date, delimiter, opt)
    {
        if (!opt)
            opt = "left=50, top=50, width=240, height=230, scrollbars=0,status=0,resizable=0";
        win_open(g4_path+"/" + g4_bbs + "/calendar.php?fld="+fld+"&cur_date="+cur_date+"&delimiter="+delimiter, "winCalendar", opt);
    }

    // �������� â
    function win_poll(url)
    {
        if (!url)
            url = "";
        win_open(url, "winPoll", "left=50, top=50, width=616, height=500, scrollbars=1");
    }

    // �ڱ�Ұ� â
    function win_profile(mb_id)
    {
        win_open(g4_path+"/" + g4_bbs + "/profile.php?mb_id="+mb_id, 'winProfile', 'left=50,top=50,width=616,height=500,scrollbars=1');
    }

    var last_id = null;
    function menu(id)
    {
        if (id != last_id)
        {
            if (last_id != null)
                document.getElementById(last_id).style.display = "none";
            document.getElementById(id).style.display = "block";
            last_id = id;
        }
        else
        {
            document.getElementById(id).style.display = "none";
            last_id = null;
        }
    }

    function textarea_decrease(id, row)
    {
        if (document.getElementById(id).rows - row > 0)
            document.getElementById(id).rows -= row;
    }

    function textarea_original(id, row)
    {
        document.getElementById(id).rows = row;
    }

    function textarea_increase(id, row)
    {
        document.getElementById(id).rows += row;
    }

    // �ۼ��� �˻�
    function check_byte(content, target)
    {
        var i = 0;
        var cnt = 0;
        var ch = '';
        var cont = document.getElementById(content).value;

        for (i=0; i<cont.length; i++) {
            ch = cont.charAt(i);
            if (escape(ch).length > 4) {
                cnt += 2;
            } else {
                cnt += 1;
            }
        }
        // ���ڸ� ���
        document.getElementById(target).innerHTML = cnt;

        return cnt;
    }

    // ���������� ������Ʈ�� ���� ��ǥ
    function get_left_pos(obj)
    {
        var parentObj = null;
        var clientObj = obj;
        //var left = obj.offsetLeft + document.body.clientLeft;
        var left = obj.offsetLeft;

        while((parentObj=clientObj.offsetParent) != null)
        {
            left = left + parentObj.offsetLeft;
            clientObj = parentObj;
        }

        return left;
    }

    // ���������� ������Ʈ�� ��� ��ǥ
    function get_top_pos(obj)
    {
        var parentObj = null;
        var clientObj = obj;
        //var top = obj.offsetTop + document.body.clientTop;
        var top = obj.offsetTop;

        while((parentObj=clientObj.offsetParent) != null)
        {
            top = top + parentObj.offsetTop;
            clientObj = parentObj;
        }

        return top;
    }

    function flash_movie(src, ids, width, height, wmode)
    {
        var wh = "";
        if (parseInt(width) && parseInt(height)) 
            wh = " width='"+width+"' height='"+height+"' ";
        return "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' "+wh+" id="+ids+"><param name=wmode value="+wmode+"><param name=movie value="+src+"><param name=quality value=high><embed src="+src+" quality=high wmode="+wmode+" type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash' "+wh+"></embed></object>";
    }

    function obj_movie(src, ids, width, height, autostart)
    {
        var wh = "";
        if (parseInt(width) && parseInt(height)) 
            wh = " width='"+width+"' height='"+height+"' ";
        if (!autostart) autostart = false;
        return "<embed src='"+src+"' "+wh+" autostart='"+autostart+"'></embed>";
    }

    function doc_write(cont)
    {
        document.write(cont);
    }
}
