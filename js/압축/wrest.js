if (typeof(WREST_JS) == 'undefined')
{ if (typeof g4_path == 'undefined')
alert('g4_path 변수가 선언되지 않았습니다. js/wrest.js'); var WREST_JS = true; var wrestMsg = ''; var wrestFld = null; var wrestFldDefaultColor = ''; var wrestFldBackColor = '#FFE4E1'; var arrAttr = new Array ('required', 'trim', 'minlength', 'email', 'hangul', 'hangul2', 'memberid', 'nospace', 'numeric', 'alpha', 'alphanumeric', 'jumin', 'saupja', 'alphanumericunderline', 'telnumber', 'hangulalphanumeric', 'images'); function wrestItemname(fld)
{ var itemname = fld.getAttribute("itemname"); if (itemname != null && itemname != "")
return itemname; else
return fld.name;}
function wrestTrim(fld)
{ var pattern = /(^\s*)|(\s*$)/g; fld.value = fld.value.replace(pattern, ""); return fld.value;}
function wrestRequired(fld)
{ if (wrestTrim(fld) == "")
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 필수 "+(fld.type=="select-one"?"선택":"입력")+"입니다.\n"; wrestFld = fld;}
}
}
function wrestImages(fld)
{ if (!wrestTrim(fld)) return; var fn = fld.value; var dotIndex = fn.lastIndexOf("."); var ext = fn.substring(dotIndex+1).toLowerCase(); if(ext != "jpg" && ext != "jpeg" && ext != "gif" && ext != "png")
{ fld.value = ''; wrestMsg = wrestItemname(fld) + " : 이미지 형식이 아닙니다. \n\n(이미지 jpg, jpeg, gif, png 만 가능합니다) \n"; wrestFld = fld;}
}
function wrestMinlength(fld)
{ var len = fld.getAttribute("minlength"); if (fld.value.length < len)
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " :  최소 " + len + "자 이상 입력하세요.\n"; wrestFld = fld;}
}
}
function wrestTelnumber(fld){ if (!wrestTrim(fld)) return; var pattern = /^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$/; if(!pattern.test(fld.value)){ if(wrestFld == null){ wrestMsg = wrestItemname(fld)+" : 전화번호 형식이 올바르지 않습니다.\n\n하이픈(-)을 포함하여 입력해 주십시오.\n"; wrestFld = fld; fld.select();}
}
}
function wrestEmail(fld)
{ if (!wrestTrim(fld)) return; var pattern = /([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)/; if (!pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 이메일주소 형식이 아닙니다.\n"; wrestFld = fld;}
}
}
function wrestMemberId(fld)
{ if (!wrestTrim(fld)) return; var pattern = /(^([a-z0-9]+)([a-z0-9_]+$))/; if (!pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 회원아이디 형식이 아닙니다.\n\n영소문자, 숫자, _ 만 가능.\n\n첫글자는 영소문자, 숫자만 가능\n"; wrestFld = fld;}
}
}
function wrestHangul(fld)
{ if (!wrestTrim(fld)) return; var pattern = /([^가-힣\x20])/i; if (pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + ' : 한글이 아닙니다. (자음, 모음만 있는 한글은 처리하지 않습니다.)\n'; wrestFld = fld;}
}
}
function wrestHangul2(fld)
{ if (!wrestTrim(fld)) return; var pattern = /([^가-힣ㄱ-ㅎㅏ-ㅣ\x20])/i; if (pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + ' : 한글이 아닙니다.\n'; wrestFld = fld;}
}
}
function wrestHangulAlphaNumeric(fld)
{ if (!wrestTrim(fld)) return; var pattern = /([^가-힣\x20^a-z^A-Z^0-9])/i; if (pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + ' : 한글, 영문, 숫자가 아닙니다.\n'; wrestFld = fld;}
}
}
function wrestNumeric(fld)
{ if (fld.value.length > 0)
{ for (i = 0; i < fld.value.length; i++)
{ if (fld.value.charAt(i) < '0' || fld.value.charAt(i) > '9')
{ wrestMsg = wrestItemname(fld) + " : 숫자가 아닙니다.\n"; wrestFld = fld;}
}
}
}
function wrestAlpha(fld)
{ if (!wrestTrim(fld)) return; var pattern = /(^[a-zA-Z]+$)/; if (!pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 영문이 아닙니다.\n"; wrestFld = fld;}
}
}
function wrestAlphaNumeric(fld)
{ if (!wrestTrim(fld)) return; var pattern = /(^[a-zA-Z0-9]+$)/; if (!pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 영문 또는 숫자가 아닙니다.\n"; wrestFld = fld;}
}
}
function wrestAlphaNumericUnderLine(fld)
{ if (!wrestTrim(fld))
return; var pattern = /(^[a-zA-Z0-9\_]+$)/; if (!pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 영문, 숫자, _ 가 아닙니다.\n"; wrestFld = fld;}
}
}
function wrestJumin(fld)
{ if (!wrestTrim(fld)) return; var pattern = /(^[0-9]{13}$)/; if (!pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 주민등록번호를 13자리 숫자로 입력하십시오.\n"; wrestFld = fld;}
}
else
{ var sum_1 = 0; var sum_2 = 0; var at=0; var juminno= fld.value; sum_1 = (juminno.charAt(0)*2)+ (juminno.charAt(1)*3)+ (juminno.charAt(2)*4)+ (juminno.charAt(3)*5)+ (juminno.charAt(4)*6)+ (juminno.charAt(5)*7)+ (juminno.charAt(6)*8)+ (juminno.charAt(7)*9)+ (juminno.charAt(8)*2)+ (juminno.charAt(9)*3)+ (juminno.charAt(10)*4)+ (juminno.charAt(11)*5); sum_2=sum_1 % 11; if (sum_2 == 0)
at = 10; else
{ if (sum_2 == 1)
at = 11; else
at = sum_2;}
att = 11 - at; if (juminno.charAt(12) != att || juminno.substr(2,2) < '01' || juminno.substr(2,2) > '12' || juminno.substr(4,2) < '01' || juminno.substr(4,2) > '31' || juminno.charAt(6) > 4)
{ wrestMsg = wrestItemname(fld) + " : 올바른 주민등록번호가 아닙니다.\n"; wrestFld = fld;}
}
}
function wrestSaupja(fld)
{ if (!wrestTrim(fld)) return; var pattern = /(^[0-9]{10}$)/; if (!pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 사업자등록번호를 10자리 숫자로 입력하십시오.\n"; wrestFld = fld;}
}
else
{ var sum = 0; var at = 0; var att = 0; var saupjano= fld.value; sum = (saupjano.charAt(0)*1)+ (saupjano.charAt(1)*3)+ (saupjano.charAt(2)*7)+ (saupjano.charAt(3)*1)+ (saupjano.charAt(4)*3)+ (saupjano.charAt(5)*7)+ (saupjano.charAt(6)*1)+ (saupjano.charAt(7)*3)+ (saupjano.charAt(8)*5); sum += parseInt((saupjano.charAt(8)*5)/10); at = sum % 10; if (at != 0)
att = 10 - at; if (saupjano.charAt(9) != att)
{ wrestMsg = wrestItemname(fld) + " : 올바른 사업자등록번호가 아닙니다.\n"; wrestFld = fld;}
}
}
function wrestNospace(fld)
{ var pattern = /(\s)/g; if (pattern.test(fld.value))
{ if (wrestFld == null)
{ wrestMsg = wrestItemname(fld) + " : 공백이 없어야 합니다.\n"; wrestFld = fld;}
}
}
function wrestSubmit()
{ wrestMsg = ""; wrestFld = null; var attr = null; for (var i = 0; i < this.elements.length; i++)
{ if (this.elements[i].type == "text" || this.elements[i].type == "file" || this.elements[i].type == "password" || this.elements[i].type == "select-one" || this.elements[i].type == "textarea")
{ for (var j = 0; j < arrAttr.length; j++)
{ if (this.elements[i].getAttribute(arrAttr[j]) != null)
{ switch (arrAttr[j])
{ case "required" : wrestRequired(this.elements[i]); break; case "trim" : wrestTrim(this.elements[i]); break; case "minlength" : wrestMinlength(this.elements[i]); break; case "email" : wrestEmail(this.elements[i]); break; case "hangul" : wrestHangul(this.elements[i]); break; case "hangul2" : wrestHangul2(this.elements[i]); break; case "hangulalphanumeric"
: wrestHangulAlphaNumeric(this.elements[i]); break; case "memberid" : wrestMemberId(this.elements[i]); break; case "nospace" : wrestNospace(this.elements[i]); break; case "numeric" : wrestNumeric(this.elements[i]); break; case "alpha" : wrestAlpha(this.elements[i]); break; case "alphanumeric" : wrestAlphaNumeric(this.elements[i]); break; case "alphanumericunderline" :
wrestAlphaNumericUnderLine(this.elements[i]); break; case "jumin" : wrestJumin(this.elements[i]); break; case "saupja" : wrestSaupja(this.elements[i]); break; case "telnumber" : wrestTelnumber(this.elements[i]); break; case "images" : wrestImages(this.elements[i]); break; default : break;}
}
}
}
}
if (wrestFld != null)
{ alert(wrestMsg); if (wrestFld.style.display != 'none')
{ wrestFld.style.backgroundColor = wrestFldBackColor; wrestFld.focus();}
return false;}
if (this.oldsubmit && this.oldsubmit() == false)
return false; return true;}
function wrestInitialized()
{ for (var i = 0; i < document.forms.length; i++)
{ if (document.forms[i].onsubmit) document.forms[i].oldsubmit = document.forms[i].onsubmit; document.forms[i].onsubmit = wrestSubmit; for (var j = 0; j < document.forms[i].elements.length; j++)
{ if (document.forms[i].elements[j].getAttribute("required") != null)
{ document.forms[i].elements[j].style.backgroundImage = "url("+g4_path+"/js/wrest.gif)"; document.forms[i].elements[j].style.backgroundPosition = "top right"; document.forms[i].elements[j].style.backgroundRepeat = "no-repeat";}
}
}
}
wrestInitialized();}
