// request ��ü ����
var req = null;
function create_request() {
    var request = null;
    try {
        request = new XMLHttpRequest();
    } catch (trymicrosoft) {
        try {
            request = new ActiveXObject("Msxml12.XMLHTTP");
        } catch (othermicrosoft) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                request = null;
            }
        }
    }
    if (request == null)
        alert("Error creating request object!");
    else
        return request;
}

// Ʈ������ ����Ѵٸ� ��ū�� �ǽð����� ����
var trackback_url = "";
function trackback_send_server(url) {
    req = create_request();
    trackback_url = url;
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if (req.status == 200) {
                var token = req.responseText;
                prompt("�Ʒ� �ּҸ� �����ϼ���. �� �ּҴ� ������ ���� ���Ͽ� �ѹ��� ��� �����մϴ�.", trackback_url+"/"+token);
                trackback_url = "";
            }
        }
    }
    req.open("POST", g4_path+'/'+g4_bbs+'/'+'tb_token.php', true);
    //req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    req.send(null);
}
