if (typeof(WREST_JS) == 'undefined') // �ѹ��� ����
{
    if (typeof g4_path == 'undefined')
        alert('g4_path ������ ������� �ʾҽ��ϴ�. js/wrest.js');

    var WREST_JS = true;

    var wrestMsg = '';
    var wrestFld = null;
    //var wrestFldDefaultColor = '#FFFFFF'; 
    var wrestFldDefaultColor = ''; 
    var wrestFldBackColor = '#FFE4E1'; 
    var arrAttr  = new Array ('required', 'trim', 'minlength', 'email', 'hangul', 'hangul2', 
                              'memberid', 'nospace', 'numeric', 'alpha', 'alphanumeric', 
                              'jumin', 'saupja', 'alphanumericunderline', 'telnumber', 'hangulalphanumeric');

    // subject �Ӽ����� ��� return, ������ tag�� name�� �ѱ�
    function wrestItemname(fld)
    {
        var itemname = fld.getAttribute("itemname");
        if (itemname != null && itemname != "")
            return itemname;
        else
            return fld.name;
    }

    // ���� ���� ���ֱ�
    function wrestTrim(fld) 
    {
        var pattern = /(^\s*)|(\s*$)/g; // \s ���� ����
        fld.value = fld.value.replace(pattern, "");
        return fld.value;
    }

    // �ʼ� �Է� �˻�
    function wrestRequired(fld)
    {
        if (wrestTrim(fld) == "") 
        {
            if (wrestFld == null) 
            {
                // 3.30
                // ����Ʈ�ڽ��� ��쿡�� �ʼ� ���� �˻��մϴ�.
                wrestMsg = wrestItemname(fld) + " : �ʼ� "+(fld.type=="select-one"?"����":"�Է�")+"�Դϴ�.\n";
                wrestFld = fld;
            }
        }
    }

    // �ּ� ���� �˻�
    function wrestMinlength(fld)
    {
        var len = fld.getAttribute("minlength");
        if (fld.value.length < len) 
        {
            if (wrestFld == null) 
            {
                wrestMsg = wrestItemname(fld) + " :  �ּ� " + len + "�� �̻� �Է��ϼ���.\n";
                wrestFld = fld;
            }
        }
    }

    // �輱�� 2006.3 - ��ȭ��ȣ(�޴���) ���� �˻� : 123-123(4)-5678
	function wrestTelnumber(fld){

		if (!wrestTrim(fld)) return;

		var pattern = /^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$/;
		if(!pattern.test(fld.value)){ 
            if(wrestFld == null){
				wrestMsg = wrestItemname(fld)+" : ��ȭ��ȣ ������ �ùٸ��� �ʽ��ϴ�.\n\n������(-)�� �����Ͽ� �Է��� �ֽʽÿ�.\n";
                wrestFld = fld;
				fld.select();
            }
		}
	}

    // �̸����ּ� ���� �˻�
    function wrestEmail(fld) 
    {
        if (!wrestTrim(fld)) return;

        //var pattern = /(\S+)@(\S+)\.(\S+)/; �̸����ּҿ� �ѱ� ����
        var pattern = /([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)/;
        if (!pattern.test(fld.value)) 
        {
            if (wrestFld == null) 
            {
                wrestMsg = wrestItemname(fld) + " : �̸����ּ� ������ �ƴմϴ�.\n";
                wrestFld = fld;
            }
        }
    }

    // ȸ�����̵� �˻�
    function wrestMemberId(fld) 
    {
        if (!wrestTrim(fld)) return;

        var pattern = /(^([a-z0-9]+)([a-z0-9_]+$))/;
        if (!pattern.test(fld.value)) 
        {
            if (wrestFld == null) 
            {
                wrestMsg = wrestItemname(fld) + " : ȸ�����̵� ������ �ƴմϴ�.\n\n���ҹ���, ����, _ �� ����.\n\nù���ڴ� ���ҹ���, ���ڸ� ����\n";
                wrestFld = fld;
            }
        }
    }

    // �ѱ����� �˻� (����, ������ �ִ� �ѱ��� �Ұ�)
    function wrestHangul(fld) 
    { 
        if (!wrestTrim(fld)) return;

        var pattern = /([^��-�R\x20])/i; 

        if (pattern.test(fld.value)) 
        {
            if (wrestFld == null) 
            { 
                wrestMsg = wrestItemname(fld) + ' : �ѱ��� �ƴմϴ�. (����, ������ �ִ� �ѱ��� ó������ �ʽ��ϴ�.)\n'; 
                wrestFld = fld; 
            } 
        } 
    }

    // �ѱ����� �˻�2 (����, ������ �ִ� �ѱ۵� ����)
    function wrestHangul2(fld) 
    { 
        if (!wrestTrim(fld)) return;

        var pattern = /([^��-�R��-����-��\x20])/i; 

        if (pattern.test(fld.value)) 
        {
            if (wrestFld == null) 
            { 
                wrestMsg = wrestItemname(fld) + ' : �ѱ��� �ƴմϴ�.\n'; 
                wrestFld = fld; 
            } 
        } 
    }

    // �ѱ�,����,�������� �˻�3
    function wrestHangulAlphaNumeric(fld) 
    { 
        if (!wrestTrim(fld)) return;

        var pattern = /([^��-�R\x20^a-z^A-Z^0-9])/i; 

        if (pattern.test(fld.value)) 
        {
            if (wrestFld == null) 
            { 
                wrestMsg = wrestItemname(fld) + ' : �ѱ�, ����, ���ڰ� �ƴմϴ�.\n'; 
                wrestFld = fld; 
            } 
        } 
    }

    // ���������˻� 
    // ��θ��ܲ��̴� �߰� (http://dasir.com) 2003-06-24
    function wrestNumeric(fld) 
    { 
        if (fld.value.length > 0) 
        { 
            for (i = 0; i < fld.value.length; i++) 
            { 
                if (fld.value.charAt(i) < '0' || fld.value.charAt(i) > '9') 
                { 
                    wrestMsg = wrestItemname(fld) + " : ���ڰ� �ƴմϴ�.\n"; 
                    wrestFld = fld; 
                }
            }
        }
    }

    // ������ �˻� 
    // ��θ��ܲ��̴� �߰� (http://dasir.com) 2003-06-24
    function wrestAlpha(fld) 
    { 
        if (!wrestTrim(fld)) return; 

        var pattern = /(^[a-zA-Z]+$)/; 
        if (!pattern.test(fld.value)) 
        { 
            if (wrestFld == null) 
            { 
                wrestMsg = wrestItemname(fld) + " : ������ �ƴմϴ�.\n"; 
                wrestFld = fld; 
            } 
        } 
    } 

    // �����ڿ� ���� �˻� 
    // ��θ��ܲ��̴� �߰� (http://dasir.com) 2003-07-07
    function wrestAlphaNumeric(fld) 
    { 
       if (!wrestTrim(fld)) return; 
       var pattern = /(^[a-zA-Z0-9]+$)/; 
       if (!pattern.test(fld.value)) 
       { 
           if (wrestFld == null) 
           { 
               wrestMsg = wrestItemname(fld) + " : ���� �Ǵ� ���ڰ� �ƴմϴ�.\n"; 
               wrestFld = fld; 
           } 
       } 
    } 

    // �����ڿ� ���� �׸��� _ �˻� 
    function wrestAlphaNumericUnderLine(fld) 
    { 
       if (!wrestTrim(fld)) 
           return; 

       var pattern = /(^[a-zA-Z0-9\_]+$)/; 
       if (!pattern.test(fld.value)) 
       { 
           if (wrestFld == null) 
           { 
               wrestMsg = wrestItemname(fld) + " : ����, ����, _ �� �ƴմϴ�.\n"; 
               wrestFld = fld; 
           } 
       } 
    } 

    // �ֹε�Ϲ�ȣ �˻�
    function wrestJumin(fld) 
    { 
       if (!wrestTrim(fld)) return; 
       var pattern = /(^[0-9]{13}$)/; 
       if (!pattern.test(fld.value)) 
       { 
           if (wrestFld == null) 
           { 
               wrestMsg = wrestItemname(fld) + " : �ֹε�Ϲ�ȣ�� 13�ڸ� ���ڷ� �Է��Ͻʽÿ�.\n"; 
               wrestFld = fld; 
           } 
       } 
       else 
       {
            var sum_1 = 0;
            var sum_2 = 0;
            var at=0;
            var juminno= fld.value;
            sum_1 = (juminno.charAt(0)*2)+
                    (juminno.charAt(1)*3)+
                    (juminno.charAt(2)*4)+
                    (juminno.charAt(3)*5)+
                    (juminno.charAt(4)*6)+
                    (juminno.charAt(5)*7)+
                    (juminno.charAt(6)*8)+
                    (juminno.charAt(7)*9)+
                    (juminno.charAt(8)*2)+
                    (juminno.charAt(9)*3)+
                    (juminno.charAt(10)*4)+
                    (juminno.charAt(11)*5);
            sum_2=sum_1 % 11;

            if (sum_2 == 0) 
                at = 10;
            else 
            {
                if (sum_2 == 1) 
                    at = 11;
                else 
                    at = sum_2;
            }
            att = 11 - at;
            // 1800 ��뿡 �¾�� �е��� ����, ������ ������ 9, 0 �̶�� 
            // ��⸦ �������� �ִµ� �׷��ٸ� �Ʒ��� ������ �����̴�.
            // ������... 100����� �е��� �ֹε�Ϲ�ȣ�� ���� �Է��غ���?
            if (juminno.charAt(12) != att || 
                juminno.substr(2,2) < '01' ||
                juminno.substr(2,2) > '12' ||
                juminno.substr(4,2) < '01' ||
                juminno.substr(4,2) > '31' ||
                juminno.charAt(6) > 4) 
            {
               wrestMsg = wrestItemname(fld) + " : �ùٸ� �ֹε�Ϲ�ȣ�� �ƴմϴ�.\n"; 
               wrestFld = fld; 
            }

        }
    } 

    // ����ڵ�Ϲ�ȣ �˻�
    function wrestSaupja(fld) 
    { 
       if (!wrestTrim(fld)) return; 
       var pattern = /(^[0-9]{10}$)/; 
       if (!pattern.test(fld.value)) 
       { 
           if (wrestFld == null) 
           { 
               wrestMsg = wrestItemname(fld) + " : ����ڵ�Ϲ�ȣ�� 10�ڸ� ���ڷ� �Է��Ͻʽÿ�.\n"; 
               wrestFld = fld; 
           } 
       } 
       else 
       {
            var sum = 0;
            var at = 0;
            var att = 0;
            var saupjano= fld.value;
            sum = (saupjano.charAt(0)*1)+
                  (saupjano.charAt(1)*3)+
                  (saupjano.charAt(2)*7)+
                  (saupjano.charAt(3)*1)+
                  (saupjano.charAt(4)*3)+
                  (saupjano.charAt(5)*7)+
                  (saupjano.charAt(6)*1)+
                  (saupjano.charAt(7)*3)+
                  (saupjano.charAt(8)*5);
            sum += parseInt((saupjano.charAt(8)*5)/10);
            at = sum % 10;
            if (at != 0) 
                att = 10 - at;  

            if (saupjano.charAt(9) != att) 
            {
               wrestMsg = wrestItemname(fld) + " : �ùٸ� ����ڵ�Ϲ�ȣ�� �ƴմϴ�.\n"; 
               wrestFld = fld; 
            }

        }
    } 

    // ���� �˻��� ������ "" �� ��ȯ
    function wrestNospace(fld)
    {
        var pattern = /(\s)/g; // \s ���� ����
        if (pattern.test(fld.value)) 
        {
            if (wrestFld == null) 
            {
                wrestMsg = wrestItemname(fld) + " : ������ ����� �մϴ�.\n";
                wrestFld = fld;
            }
        }
    }

    // submit �� �� �Ӽ��� �˻��Ѵ�.
    function wrestSubmit()
    {
        wrestMsg = "";
        wrestFld = null;

        var attr = null;

        // �ش����� ���� ����� ������ŭ ������
        for (var i = 0; i < this.elements.length; i++) 
        {
            // Input tag �� type �� text, file, password �϶���
            // 3.30
            // ����Ʈ �ڽ��϶��� �ʼ� ���� �˻��մϴ�. select-one
            if (this.elements[i].type == "text" || 
                this.elements[i].type == "file" || 
                this.elements[i].type == "password" ||
                this.elements[i].type == "select-one" ||
                this.elements[i].type == "textarea") 
            {
                // �迭�� ���̸�ŭ ������
                for (var j = 0; j < arrAttr.length; j++) 
                {
                    // �迭�� ������ �Ӽ��� ���ؼ� �Ӽ��� �ְų� ���� �ִٸ�
                    if (this.elements[i].getAttribute(arrAttr[j]) != null) 
                    {
                        /*
                        // �⺻ �������� ��������
                        if (this.elements[i].getAttribute("required") != null) {
                            this.elements[i].style.backgroundColor = wrestFldDefaultColor;
                        }
                        */
                        switch (arrAttr[j]) 
                        {
                            case "required"     : wrestRequired(this.elements[i]); break;
                            case "trim"         : wrestTrim(this.elements[i]); break;
                            case "minlength"    : wrestMinlength(this.elements[i]); break;
                            case "email"        : wrestEmail(this.elements[i]); break;
                            case "hangul"       : wrestHangul(this.elements[i]); break;
                            case "hangul2"      : wrestHangul2(this.elements[i]); break;
                            case "hangulalphanumeric"      
                                                : wrestHangulAlphaNumeric(this.elements[i]); break;
                            case "memberid"     : wrestMemberId(this.elements[i]); break;
                            case "nospace"      : wrestNospace(this.elements[i]); break;
                            case "numeric"      : wrestNumeric(this.elements[i]); break; 
                            case "alpha"        : wrestAlpha(this.elements[i]); break; 
                            case "alphanumeric" : wrestAlphaNumeric(this.elements[i]); break; 
                            case "alphanumericunderline" : 
                                                  wrestAlphaNumericUnderLine(this.elements[i]); break; 
                            case "jumin"        : wrestJumin(this.elements[i]); break; 
                            case "saupja"       : wrestSaupja(this.elements[i]); break; 
							
							// �輱�� 2006.3 - ��ȭ��ȣ ���� �˻�
							case "telnumber"	: wrestTelnumber(this.elements[i]); break;
                            default : break;
                        }
                    }
                }
            }
        }

        // �ʵ尡 null �� �ƴ϶�� �����޼��� ����� ��Ŀ���� �ش� ���� �ʵ�� �ű�
        // ���� �ʵ�� �������� �ٲ۴�.
        if (wrestFld != null) 
        {
            alert(wrestMsg);
            wrestFld.style.backgroundColor = wrestFldBackColor;
            wrestFld.focus();
            return false;
        }

        if (this.oldsubmit && this.oldsubmit() == false)
            return false;

        return true;
    }

    // �ʱ⿡ onsubmit�� ����ä���� �Ѵ�.
    function wrestInitialized()
    {
        for (var i = 0; i < document.forms.length; i++) 
        {
            // onsubmit �̺�Ʈ�� �ִٸ� ������ ���´�.
            if (document.forms[i].onsubmit) document.forms[i].oldsubmit = document.forms[i].onsubmit;
            document.forms[i].onsubmit = wrestSubmit;
            for (var j = 0; j < document.forms[i].elements.length; j++) 
            {
                // �ʼ� �Է��� ���� * ����̹����� �ش�.
                if (document.forms[i].elements[j].getAttribute("required") != null) 
                {
                    //document.forms[i].elements[j].style.backgroundColor = wrestFldDefaultColor;
                    //document.forms[i].elements[j].className = "wrest_required";
                    document.forms[i].elements[j].style.backgroundImage = "url("+g4_path+"/js/wrest.gif)";
                    document.forms[i].elements[j].style.backgroundPosition = "top right";
                    document.forms[i].elements[j].style.backgroundRepeat = "no-repeat";
                }
            }
        }
    }

    wrestInitialized();
}
