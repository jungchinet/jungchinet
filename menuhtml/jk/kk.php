<?
include_once("../../menuhtml/_common.php");
$g4['title'] = "";
include_once("../../menuhtml/_head.php");

include_once("../../menuhtml/jk/$g4[path]/lib/popup.lib.php");        // 팝업

// 팝업출력
//echo popup("","test");

?>

<style type="text/css">
#wrap {
	width: 1100px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
.body1 {
	
	height: 1230px;
	width: 1100px;
	padding-top: 20px;
}
H1 {color:#999;}
.main_picture {
	float: left;
	height: 624px;
	width: 700px;
}
.boss_sub {
	float: left;
	height: 50px;
	width: 380px;
	text-align: left;
	padding-top: 10px;
	font-size: 25px;
	font-family: Verdana, Geneva, sans-serif;
	color: #09F;
}
.boss_picture {
	float: left;
	height: 131px;
	width: 90px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.boss_profile {
	float: left;
	height: 131px;
	width: 290px;
}
#wrap .body1  ul li {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
}
.interval {
	float: left;
	height: 453px;
	width: 380px;
}
.edu_interval {
	float: left;
	height: 670px;
	width: 20px;
}
.edu_interval2 {
	float: left;
	height: 570px;
	width: 20px;
}
.boss2_sub {
	float: left;
	height: 33px;
	width: 200px;
	text-align: left;
	padding-top: 10px;
	font-size: 23px;
	font-family: Verdana, Geneva, sans-serif;
	color: #09F;
	font-weight: bold;
}
.boss2_msub {
	float: left;
	height: 33px;
	width: 880px;
	text-align: left;
	padding-top: 10px;
	font-size: 23px;
	font-family: Verdana, Geneva, sans-serif;
	color: #999;
	font-weight: bold;
}
.boss2_picture {
	float: left;
	height: 130px;
	width: 70px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.boss2_profile {
	float: left;
	height: 130px;
	width: 1010px;
}
.company_sub {
	margin-top: 20px;
	float: left;
	height: 31px;
	width: 1080px;
	text-align: left;
	font-size: 20px;
	font-family: Verdana, Geneva, sans-serif;
	color: #09F;
	font-weight: bold;
}
.company1_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo1_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company1_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company2_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo2_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company2_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company3_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo3_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company3_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company4_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo4_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company4_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company5_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo5_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company5_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company6_picture {
	margin-top: 11px;
	float: left;
	height: 100px;
	width: 220px;
}
.ceo6_picture {
	float: left;
	height: 70px;
	width: 50px;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
}
.company6_profile {
	float: left;
	height: 111px;
	width: 810px;
}
.company_0sub {
	margin-top: 0px;
	float: left;
	height: 0px;
	width: 1100px;
	text-align: left;
	font-size: 0px;
	font-family: Verdana, Geneva, sans-serif;
	color: #09F;
	font-weight: bold;
}
.assem1_profile {
	float: left;
	height: 100px;
	width: 310px;
}
</style>


<div id="wrap">
 <div class="body1">
 <div class="edu_interval"></div>
  <div class="main_picture">
    <img src="/menuhtml/jk/kk.gif" width="586" height="624" usemap="#Map" border="0" />
    <map name="Map" id="Map"><area shape="poly" coords="475,343,482,325,478,314,483,310,497,317,522,309,528,317,530,331,534,349,543,356,549,358,556,360,564,393,558,422,547,430,532,417,531,410,526,400,513,393,506,384,496,387,491,380,469,377,470,358" href="/bbs/board.php?bo_table=seoul_941" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="용인정" /><area shape="poly" coords="359,432,363,421,372,424,379,426,386,429,393,430,401,433,403,441,413,445,420,442,435,437,437,447,427,448,419,453,413,462,408,463,397,459,388,458,385,460,378,470,357,469,359,456,360,449,359,441" href="/bbs/board.php?bo_table=seoul_521" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="수원무" /><area shape="poly" coords="273,260,280,258,286,269,283,274,289,281,284,287,283,296,276,304,265,300,260,289,257,280,260,268" href="/bbs/board.php?bo_table=seoul_881" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="군포을" /><area shape="poly" coords="329,499,330,491,328,485,330,480,335,477,341,476,358,476,369,478,375,478,384,474,386,469,387,464,390,463,394,464,403,468,409,469,416,465,421,459,426,453,430,453,435,454,438,458,440,464,440,470,440,476,434,476,436,489,430,490,423,478,415,484,417,490,416,501,407,505,405,511,405,518,397,514,388,510,383,510,362,521,358,524,357,528,352,530,348,530,341,525,334,523,328,520,325,514" href="/bbs/board.php?bo_table=seoul_851" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="화성병" />
      <area shape="rect" coords="282,0,530,64" href="http://www.gg.go.kr" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="경기도" />
      <area shape="rect" coords="83,484,216,506" href="/bbs/board.php?bo_table=city02" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="경기전체링크" />
      
      <area shape="poly" coords="327,329,346,326,353,319,358,316,367,315,373,313,376,309,378,302,381,298,388,299,393,303,397,307,397,313,396,329,396,335,396,341,389,347,387,356,386,363,384,367,378,369,370,369,364,369,358,368,351,369,339,371,333,369,326,363,322,358,324,352,322,344,322,336" href="/bbs/board.php?bo_table=seoul_49" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="수원갑" />
      <area shape="poly" coords="288,371,296,369,306,370,311,371,319,370,324,371,332,376,323,386,325,388,325,398,328,402,337,406,342,409,348,415,353,419,358,423,356,428,357,432,356,436,355,441,354,445,355,449,356,455,354,461,352,467,344,469,335,469,328,470,324,467,318,464,313,460,310,455,307,444,305,437,303,429,303,424,299,421,291,422,287,421,283,418,281,406,284,401,288,391,289,385,289,380" href="/bbs/board.php?bo_table=seoul_50" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="수원을" />
      <area shape="poly" coords="336,379,347,376,355,375,369,374,380,374,394,373,404,375,408,378,410,405,409,419,408,423,405,425,400,426,391,424,381,422,372,420,364,416,356,410,346,406,341,403,335,397,332,395,330,390,330,384" href="/bbs/board.php?bo_table=seoul_51" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="수원병" />
      <area shape="poly" coords="389,363,394,350,398,346,403,343,407,342,411,342,416,344,420,345,423,351,424,357,426,370,428,377,432,379,437,378,442,376,447,377,451,380,451,386,446,392,438,399,434,402,435,412,438,417,446,417,450,417,453,420,453,425,450,431,448,434,447,437,445,440,439,442,439,439,438,438,438,435,434,434,430,435,425,437,419,439,412,440,406,438,405,431,413,423,413,415,414,401,414,385,412,378,409,372,405,370,392,369" href="/bbs/board.php?bo_table=seoul_52" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="수원정" />
      <area shape="poly" coords="413,176,427,175,433,173,436,166,440,161,455,154,462,143,467,137,476,133,497,132,504,130,513,119,518,114,524,112,531,111,538,113,544,113,547,114,549,117,549,123,538,139,532,152,528,158,522,162,517,165,500,171,496,174,494,177,493,181,494,185,500,197,500,201,494,216,491,218,481,214,475,214,471,215,461,225,456,226,450,226,439,219,432,218,428,219,418,215,413,214,410,210,409,200,409,191,410,181" href="/bbs/board.php?bo_table=seoul_53" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="성남수정" />
      <area shape="poly" coords="510,177,524,171,532,165,538,157,549,134,552,127,555,120,559,118,563,120,565,123,567,130,568,135,571,137,578,139,582,143,584,147,584,154,581,172,579,182,577,194,575,199,571,203,567,206,560,209,554,210,542,205,532,204,521,203,514,203,506,198,500,191,500,185,503,180" href="/bbs/board.php?bo_table=seoul_54" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="성남중원" />
      <area shape="poly" coords="414,220,421,224,424,225,437,225,442,227,449,233,458,233,463,231,471,225,476,220,481,219,486,220,493,225,497,227,502,222,505,213,508,207,522,206,532,208,553,212,556,213,558,217,559,223,557,234,556,241,553,246,551,251,546,253,542,255,540,261,535,262,528,261,519,259,509,258,497,255,489,256,478,256,468,256,462,257,458,260,453,265,448,272,444,273,438,272,432,271,427,269,419,263,413,260,409,259,401,259,397,257,397,253,405,242,406,238,406,230,407,225,409,221" href="/bbs/board.php?bo_table=seoul_55" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="성남분당갑" />
      <area shape="poly" coords="454,272,461,263,467,261,473,259,480,259,493,258,512,262,515,265,517,269,518,274,519,290,520,299,519,306,504,310,496,310,491,308,486,305,483,299,478,296,475,293,462,289,456,284,453,280,452,276" href="/bbs/board.php?bo_table=seoul_56" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="성남분당을" />
      <area shape="poly" coords="223,204,232,199,235,192,242,184,244,180,245,174,248,171,265,162,271,161,283,161,286,164,288,167,288,179,286,183,279,189,273,196,269,199,266,204,264,208,265,221,269,222,276,224,281,226,286,229,287,233,287,249,285,253,279,253,272,256,265,256,260,257,255,265,252,269,247,270,245,266,244,260,242,257,237,253,225,253,220,252,216,248,214,233,213,227,213,216" href="/bbs/board.php?bo_table=seoul_59" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안양만안" />
      <area shape="poly" coords="274,203,281,199,286,195,290,188,291,183,291,176,292,170,294,166,297,163,306,163,313,158,317,157,320,159,322,165,320,172,319,177,320,181,323,187,331,197,335,203,339,210,340,218,336,219,333,219,323,212,318,211,313,212,309,213,304,217,296,223,290,224,283,222,273,220,270,217,270,209" href="/bbs/board.php?bo_table=seoul_60" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안양동안갑" />
      <area shape="poly" coords="294,227,304,223,312,216,315,214,318,215,325,221,332,224,335,228,334,233,331,240,329,246,322,268,317,274,312,274,307,269,301,258,298,255,293,252,291,249,290,243,290,235" href="/bbs/board.php?bo_table=seoul_61" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안양동안을" />
      <area shape="poly" coords="125,62,132,62,137,61,141,59,145,58,150,57,152,60,152,65,152,69,147,74,147,78,151,84,152,87,150,90,146,90,141,90,138,89,128,95,120,99,117,101,110,101,103,95,99,93,96,91,96,88,100,86,105,85,109,85,112,86,116,84,116,81,119,79,121,80,121,71,122,67" href="/bbs/board.php?bo_table=seoul_62" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="부천원미갑" />
      <area shape="poly" coords="67,50,76,50,84,45,91,45,100,45,106,47,111,49,112,52,114,58,114,66,112,72,110,77,108,81,104,82,96,83,93,84,91,88,86,90,78,91,68,90,64,88,59,85,57,79,57,69,61,58" href="/bbs/board.php?bo_table=seoul_63" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="부천원미을" />
      <area shape="poly" coords="69,93,86,93,91,94,96,96,101,99,108,105,111,106,118,106,126,100,131,97,135,94,140,94,144,96,145,99,145,104,148,106,152,107,155,110,156,113,156,118,154,122,151,125,148,126,139,126,131,125,124,123,121,123,113,123,107,124,103,125,101,124,100,120,99,115,96,111,85,106,76,102,70,100,66,97" href="/bbs/board.php?bo_table=seoul_64" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="부천소사" />
      <area shape="poly" coords="83,7,88,4,92,3,106,3,110,4,114,6,117,8,120,12,121,16,125,16,130,13,138,12,145,14,150,16,155,18,158,22,160,28,160,33,161,39,159,44,157,49,153,52,149,54,144,55,140,55,134,55,130,57,125,58,121,58,118,56,116,52,116,48,113,45,110,42,106,40,103,41,95,42,89,41,86,40,82,37,81,33,82,26,83,18,84,13" href="/bbs/board.php?bo_table=seoul_65" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="부천오정" />
      <area shape="poly" coords="178,101,178,97,181,94,185,90,190,87,197,84,202,83,206,82,210,82,214,82,217,83,220,85,223,88,224,91,225,97,223,100,220,102,216,103,212,104,208,106,206,108,205,112,202,116,198,117,193,116,189,114,186,109,181,103" href="/bbs/board.php?bo_table=seoul_66" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="광명갑" />
      <area shape="poly" coords="169,107,176,106,180,109,186,116,193,121,198,121,203,121,206,118,209,114,210,111,215,108,219,110,223,114,226,121,226,129,229,137,234,147,242,158,243,163,243,168,242,173,236,184,229,194,225,197,219,200,215,203,213,207,211,211,207,215,201,217,194,218,183,219,180,215,180,208,181,201,180,195,178,188,170,174,170,168,171,162,171,153,169,145,163,134,161,128,159,121,160,114,163,110" href="/bbs/board.php?bo_table=seoul_67" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="광명을" />
      <area shape="poly" coords="179,350,185,347,189,346,195,345,204,344,210,344,219,342,225,341,233,342,240,343,245,344,249,341,249,336,250,333,253,332,257,334,260,338,263,346,264,351,265,355,268,357,275,358,279,359,282,364,283,369,284,377,283,386,281,398,277,403,272,404,268,403,266,400,263,391,259,386,254,383,247,380,242,380,238,383,235,391,231,396,227,400,221,404,209,410,195,416,185,417,175,416,166,414,161,407,160,401,153,393,150,387,150,383,152,380,157,377,153,373,149,368,146,366,146,361,148,357,152,354,160,353,166,354,169,355,173,355" href="/bbs/board.php?bo_table=seoul_71" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안산상록갑" />
      <area shape="poly" coords="180,277,184,277,189,281,194,284,199,285,206,284,212,281,217,276,220,270,221,263,224,260,228,257,232,257,236,260,240,264,242,269,243,274,240,281,237,288,234,294,230,298,226,304,225,310,224,318,225,323,227,327,230,328,241,327,242,332,240,336,236,338,230,338,222,337,215,336,210,336,199,339,194,341,185,341,181,335,179,328,177,318,176,310,175,302,175,293,176,283" href="/bbs/board.php?bo_table=seoul_72" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안산상록을" />
      <area shape="poly" coords="124,288,141,286,147,286,151,285,156,282,161,279,165,277,169,275,172,277,174,280,170,290,169,295,170,300,172,304,171,310,169,314,165,315,160,315,157,316,154,319,154,323,152,326,147,328,139,329,134,329,127,330,122,329,117,324,114,318,111,310,110,303,111,296,115,291" href="/bbs/board.php?bo_table=seoul_73" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안산단원갑" />
      <area shape="poly" coords="77,319,99,309,103,308,106,313,109,321,112,327,117,331,121,335,128,335,135,335,140,333,145,332,155,332,158,329,158,324,161,320,166,319,170,320,174,324,176,329,177,335,177,343,175,347,172,351,167,351,158,349,154,348,148,348,145,351,141,354,139,358,135,359,128,360,122,360,116,360,107,357,102,356,96,359,88,359,81,356,76,352,68,346,62,343,58,338,56,333,59,330,69,326,73,324" href="/bbs/board.php?bo_table=seoul_74" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="안산단원을" /> 
      <area shape="poly" coords="324,156,325,153,328,148,333,144,348,134,355,131,362,130,366,133,369,138,372,139,377,138,385,133,387,132,390,136,391,148,392,156,393,166,397,170,402,171,405,174,406,181,404,185,405,195,405,205,406,214,405,221,400,233,398,239,394,252,389,261,384,267,379,273,376,280,374,286,373,294,372,301,372,306,369,309,358,309,354,311,349,316,344,321,339,322,329,322,324,323,322,327,321,331,320,335,317,340,318,344,319,349,319,355,316,359,311,362,306,364,299,364,292,363,286,361,282,357,279,352,279,346,280,343,285,338,293,334,298,324,303,312,306,298,309,287,312,283,315,279,322,277,326,271,329,262,331,256,337,245,339,235,343,221,344,209,342,205,338,200,334,197,330,188,325,181,324,174,325,170,329,164,327,160" href="/bbs/board.php?bo_table=seoul_79" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="의왕과천" />
      <area shape="poly" coords="363,528,366,525,382,515,386,514,391,515,396,519,400,522,404,524,413,524,419,522,424,522,427,525,428,530,432,538,434,543,435,548,436,555,434,560,433,565,437,568,441,570,452,572,455,574,458,579,463,582,465,587,466,594,466,600,462,604,456,605,447,602,437,602,431,602,426,604,421,607,417,613,413,617,409,621,401,622,397,617,392,615,387,611,384,607,384,600,386,591,388,580,387,573,384,567,377,563,370,563,361,561,353,558,348,555,346,549,347,545,353,539,358,535,360,531" href="/bbs/board.php?bo_table=seoul_83" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="오산" />
      <area shape="poly" coords="439,481,447,480,449,483,455,489,462,493,469,491,476,487,483,483,488,484,494,488,501,491,509,494,521,493,527,493,531,495,533,501,537,507,538,513,537,519,537,524,541,527,543,532,544,537,542,544,535,555,530,559,524,561,518,561,511,561,506,562,506,566,505,573,504,579,500,594,497,603,493,608,488,609,484,608,478,602,475,599,472,589,468,582,465,575,463,569,458,565,447,565,442,563,439,559,438,554,441,545,442,538,434,527,431,521,426,518,420,520,412,521,407,521,406,516,407,513,413,510,419,508,421,500,420,486,424,485,427,495,432,497,442,491,438,485" href="/bbs/board.php?bo_table=seoul_85" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="화성을" />
      <area shape="poly" coords="99,133,102,131,106,130,122,130,131,131,149,131,154,132,159,136,161,141,164,147,165,154,164,163,164,170,166,177,170,184,173,193,173,201,173,211,174,219,178,224,182,226,188,225,194,223,200,222,205,224,209,230,211,248,213,259,214,267,212,274,205,279,197,280,191,273,180,270,172,268,163,272,157,277,149,280,141,280,135,275,131,261,131,257,132,251,129,243,122,239,108,232,98,228,86,224,78,219,73,214,72,207,76,201,84,191,89,184,90,177,88,171,88,163,92,154,97,148,98,143" href="/bbs/board.php?bo_table=seoul_86" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="시흥갑" />
      <area shape="poly" coords="10,281,17,273,25,268,32,261,42,249,49,239,54,230,59,224,63,221,68,220,73,222,79,227,89,232,103,237,114,243,120,247,123,253,125,260,129,272,129,280,121,281,111,285,109,290,106,296,100,300,91,304,68,316,55,323,49,325,44,326,40,324,24,315,18,313,8,310,3,307,1,302,4,293" href="/bbs/board.php?bo_table=seoul_87" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="시흥을" />
      <area shape="poly" coords="245,283,252,281,255,289,258,294,260,304,279,309,287,300,296,277,291,271,288,258,301,265,304,272,305,280,305,289,303,298,299,310,295,322,292,328,288,333,281,333,277,335,277,339,276,345,275,348,271,350,267,347,264,342,261,333,258,329,255,327,249,326,243,322,235,322,230,320,227,316,228,310,230,304,237,295" href="/bbs/board.php?bo_table=seoul_88" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="군포갑" />
      <area shape="poly" coords="439,404,443,399,451,393,456,388,458,382,463,384,470,382,477,383,487,383,491,392,506,388,508,394,509,398,523,403,519,411,528,414,530,423,537,432,536,441,535,444,535,453,533,457,530,465,530,474,529,479,527,485,524,489,518,490,510,489,500,485,492,479,487,477,481,477,474,482,468,485,463,486,457,484,450,479,446,473,443,467,441,460,439,456,439,452,445,448,451,440,455,433,457,425,457,417,454,414,444,413,440,410" href="/bbs/board.php?bo_table=seoul_95" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="용인을" />
      <area shape="poly" coords="379,282,387,276,390,273,391,267,394,264,399,263,405,263,412,263,416,266,422,269,432,275,436,276,441,277,446,279,449,283,455,290,459,292,468,296,472,299,476,302,478,307,473,314,476,332,469,338,469,349,464,356,465,367,464,374,449,372,442,373,436,373,431,370,430,364,428,353,426,345,421,340,416,337,408,338,403,337,404,332,404,325,402,314,400,306,398,297,392,294,383,294,378,291,376,288" href="/bbs/board.php?bo_table=seoul_94" area onfocus="navigator.userAgent.indexOf('Firefox') != -1 ? null : blur()" target="_top" alt="용인병" />
    </map>    

  </div>
  <div class="boss_sub"><strong>경기도 도지사</strong></div>
  <div class="boss_picture">
    <p><a href="http://namkyungpil.gg.go.kr/"><img src="/menuhtml/jk/kkboss.jpg" width="90" height="121" /></a>남경필</p>
  </div>
  <div class="boss_profile">
    <ul>
      <li>1965년 1월 20일 (서울특별시)</li>
      <li>새누리당</li>
    </ul>
<h1>      연봉1억1352만원</h1>
  </div>
  
  <div class="boss_sub">
  <br>
<a class="twitter-timeline" href="https://twitter.com/search?q=%EB%82%A8%EA%B2%BD%ED%95%84" data-widget-id="642838381240582144" width="320" height="380" data-chrome="noheader nofooter noscrollbar ">남경필에 대한 트윗</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
  
  <div class="company_0sub"></div>
  <div class="edu_interval2"></div>
  <div class="boss2_sub">경기도 교육감</div>
  <div class="boss2_msub">연봉1억1352만원</div>
  <div class="boss2_picture">
    <p><a href="http://www.ken.go.kr"><img src="/menuhtml/jk/kkboss2.jpg" width="70" height="94" /></a>이재정</p>
  </div>
  <div class="boss2_profile">
    <ul>
      <li>1944년 3월 1일</li>
      <li>진보성향</li>
    </ul>
  </div>

<div class="company_sub">경기도 공기업</div>
  <div class="company1_picture"><a href="http://www.gico.or.kr"><img src="/menuhtml/jk/kkdosi.gif" width="186" height="46" /></a></div>
  <div class="company1_profile">
    <ul>
      <li>도시개발공사</li>
      <li>경기도 수원시 권선구 권중로 46(권선동)</li>
    </ul>
  </div>
  <div class="company2_picture"><a href="http://ggtour.or.kr"><img src="/menuhtml/jk/kktour.gif" width="186" height="40" /></a></div>
  <div class="company2_profile">
    <ul>
      <li>기타공사</li>
      <li>경기도 수원시 장안구 경수대로 1150</li>
    </ul>
  </div>
  <div class="company3_picture"><a href="http://www.gppc.or.kr"><img src="/menuhtml/jk/kkharbor.gif" width="186" height="43" /></a></div>
  <div class="company3_profile">
    <ul>
      <li>기타공사</li>
      <li>경기도 평택시 포승읍 평택항만길 73. 10층(평택항마린센터) </li>
    </ul>
  </div>

 </div>

</div>

<!--중간 광고부분-->
<div style='clear:both;margin:10px 0 10px 10px'>
<?
{
	$bGroup='uBanner3';
}
?>
</div>
<!--중간 광고부분 꿑-->

<?
include_once("../../tail2.php");
?>