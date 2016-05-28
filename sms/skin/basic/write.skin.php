<table border=0 width=100% cellpadding=0 cellspacing=0>
<tr>
    <td width=160 valign=top>
        <div <? if ($err) { echo " onclick=\"sms_error(this, '$err');\""; } ?> >
        <table width=160 align=center border=0 cellpadding=0 cellspacing=0>
        <form action="./write_update.php" onsubmit="return smssend_submit(this)" name="smsform" method="post" autocomplete="off">
        <input type=hidden name=token value='<?=$token?>'>
        <input type=hidden name=mh_hp value=''>
        <colgroup width=50>
        <colgroup width=''>
        <tr>
            <td title='단축키 alt+m' align=center>
                <div style="background-image:url('<?=$g4[path]?>/sms/img/smsbg.gif'); width:160px; height:150px; text-align:center; font-size:11px;">
                <textarea name='mh_message' id='mh_message' class=ed 
                    style="font-family:굴림체; color:#000; line-height:15px; margin:auto; margin-top:30px; margin-bottom:10px; overflow:hidden; width:100px; height:88px; background-color:#88C8F8; text-align:left; word-break:break-all; font-size:9pt; border:0;" cols="16" onkeyup="byte_check('mh_message', 'sms_bytes');" 
                    accesskey="m" itemname='문자메세지'
                    <? if ($err) { echo " disabled "; } ?> ></textarea>
                <div>
                <span id='sms_bytes' align='center'>0</span> / 80 <span style="letter-spacing:-1px;">바이트</span>
                </div>
                </div>
            </td>
        </tr>
        <tr>
            <td title='받는 번호'>
                <div style="letter-spacing:-1px; margin:5px 0 5px 0; color:#777;">받는 번호</div>
                <div style="height:96px; border:1px solid #ccc; overflow:auto;">
                    <table border=0 cellspacing=0 cellpadding=0 width=100%>
                    <colgroup align=center width=20>
                    <colgroup align=center>
                    <? for ($i=1; $i<=50; $i++) { ?>
                    <tr>
                        <td style="font-size:11px; border-right:1px solid #ccc; border-bottom:1px solid #ccc; background-color:#efefef; text-align:center; height:18px;"> 
                            <?=sprintf("%02d", $i)?> 
                        </td>
                        <td style="border-bottom:1px solid #ccc;"> 
                            <input type=text name=numbers style="width:100%; border:0; font-size:11px; font-weight:bold;"<? if ($err) { echo " disabled "; } ?>> 
                        </td>
                    </tr>
                    <? } ?>
                    </table>
                </div> 
            </td>
        </tr>
        <tr>
            <td title='보내는 번호'>
                <div style="letter-spacing:-1px; margin:5px 0 5px 0; color:#777;">보내는 번호</div>
                <input name="mh_reply" type="text" class=ed style="width:100%; font-weight:bold; font-size:11px;" title='회원정보의 휴대폰번호' value='<?=$member[mb_hp]?>' <?if ($is_admin != 'super') {?> readonly onclick="alert('회원정보의 휴대폰번호입니다.\n\n휴대폰번호 변경은 회원 정보수정 메뉴를 이용해주세요.')" <? } ?>>
            </td>
        </tr>
        <tr>
            <td title='예약'>
                <div style="letter-spacing:-1px; margin:5px 0 5px 0; color:#777;">
                    <label for='booking_flag'>예약</label>
                    <input type="checkbox" name="booking_flag" id="booking_flag" value="true" onclick="booking_show()"<? if ($err) { echo " disabled "; } ?>>
                </div>

                <div id='reserved' style='margin-top:5px; margin-bottom:10px; text-align:right;'>
                <select name="mh_by" id="mh_by" style="font-size:7pt; width:37px;" disabled><? for ($i=date("Y"); $i<=date("Y")+1; $i++) { echo "<option value='$i'>".substr($i,-2)."</option>"; } ?></select>년
                <select name="mh_bm" id="mh_bm" style="font-size:7pt; width:37px;" disabled><? for ($i=1; $i<=12; $i++) { if ($i==date('m')) $sel='selected'; else $sel=''; echo "<option value='".sprintf("%02d", $i)."' $sel>".sprintf("%02d", $i)."</option>"; } ?></select>월
                <select name="mh_bd" id="mh_bd" style="font-size:7pt; width:37px;" disabled><? for ($i=1; $i<=31; $i++) { if ($i==date('d')) $sel='selected'; else $sel=''; echo "<option value='".sprintf("%02d", $i)."' $sel>".sprintf("%02d", $i)."</option>"; } ?></select>일<br/>

                <select name="mh_bh" id="mh_bh" style="font-size:7pt; width:37px;" disabled><? for ($i=0; $i<=23; $i++) { if ($i==date('H')) $sel='selected'; else $sel=''; echo "<option value='".sprintf("%02d", $i)."' $sel>".sprintf("%02d", $i)."</option>"; } ?></select>시
                <select name="mh_bi" id="mh_bi" style="font-size:7pt; width:37px;" disabled><? for ($i=0; $i<=59; $i++) { if ($i==date('i')) $sel='selected'; else $sel=''; echo "<option value='".sprintf("%02d", $i)."' $sel>".sprintf("%02d", $i)."</option>"; } ?></select>분
                </div>
            </td>
        </tr>
        <? if (!$err) { ?>
        <tr>
            <td align=center><input type="submit" value="보내기"></td>
        </tr>
        <? } ?>
        </form>
        </table>
        </div>
    </td>
    <td style="padding-left:20px;" valign=top>
        <iframe id=form_list name=form_list src="write_form.php" border=0 frameborder=0 width=100%></iframe>
    </td>
</tr>
</table>
