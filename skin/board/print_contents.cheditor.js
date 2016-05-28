function print_contents(print_id, title) 
{ 
var contents = "";
contents += "<html><head><meta http-equiv='content-type' content='text/html; charset=<?=$g4[charset]?>'>";
contents += "<title>" + title + "</title>";
contents += "<link rel='stylesheet' href='" + g4_path + "/style.css' type='text/css'>";
contents += "</head>";
contents += "<body oncontextmenu='win.print(); return false' ondragstart='return false' onselectstart='return false' >";
contents += "<table align=center cellpadding=0 cellspacing=0><tr><td>";
contents += document.getElementById(print_id).innerHTML;
contents += "</td></tr></table>";
contents += "</body>";
contents += "</html>";
var width_dim = document.getElementById(print_id).clientWidth + 20;
var width = width_dim + 'px';
var height_dim = 600;
var height = height_dim + 'px'; 
var left = (screen.availWidth - width_dim) / 2; 
var top = (screen.availHeight - height_dim) / 2; 
var options = 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',status=no,resizable=no,scrollbars=yes'; 
var win = window.open('', '', options); 
win.document.write(contents);
if (document.all) { 
    win.document.execCommand('Print'); 
} 
else { 
    win.print(); 
}
}

function print_contents2(print_id, print_id2, title) 
{ 
var contents = "";
contents += "<html><head><meta http-equiv='content-type' content='text/html; charset=<?=$g4[charset]?>'>";
contents += "<title>" + title + "</title>";
contents += "<link rel='stylesheet' href='" + g4_path + "/style.css' type='text/css'>";
contents += "</head>";
contents += "<body oncontextmenu='win.print(); return false' ondragstart='return false' onselectstart='return false' >";
contents += "<script src='editor4_path" + "/comment.js'></script>";
contents += "<table align=center cellpadding=0 cellspacing=0><tr><td>";
contents += document.getElementById(print_id).innerHTML;
contents += "</td></tr>";
contents += "<tr><td>";
contents += document.getElementById(print_id2).innerHTML;
contents += "</td><tr>";
contents += "</table>";
contents += "</body>";
contents += "</html>";
var width_dim = document.getElementById(print_id).clientWidth + 20;
var width = width_dim + 'px';
var height_dim = 600;
var height = height_dim + 'px'; 
var left = (screen.availWidth - width_dim) / 2; 
var top = (screen.availHeight - height_dim) / 2; 
var options = 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',status=no,resizable=no,scrollbars=yes'; 
var win = window.open('', '', options); 
win.document.write(contents);
if (document.all) { 
    win.document.execCommand('Print'); 
} 
else { 
    win.print(); 
}
}
