<?
include_once("./_common.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$g4[title] = "회원 가입추천하기";
include_once("$g4[path]/_head.php");

// 비회원 접속의 경우 EXIT
if (!$is_member) {
    echo "회원만 사용가능한 메뉴 입니다";
    exit;
}

// 불법접근을 막도록 토큰생성
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

// 전체 추천횟수
$sql = " select count(*) as cnt from $g4[member_suggest_table] where mb_id = '$member[mb_id]' ";
$mb_tot_recommend = sql_fetch($sql);
        
// 내가 추천하여 가입한 회원수, 숫자의 mismatch가 생길 수 있다...과거 프로그램의 오류 때문에...ㅠ.ㅠ...
$sql = " select count(*) as cnt from $g4[member_table] where mb_recommend = '$member[mb_id]' ";
$mb_recommend = sql_fetch($sql);

// 범위내의 추천 회원수
$wtime = date("Y-m-d H:i:s", $g4[server_time] - ($g4[member_suggest_days] * 86400)); 
$sql = " select count(*) as cnt from $g4[member_suggest_table] where mb_id = '$member[mb_id]' and suggest_datetime > '$wtime' ";
$mb_suggest = sql_fetch($sql);

// 추천 가능한 회원수
$mb_suggest_cnt = $g4['member_suggest_count'] - $mb_suggest['cnt'];

// 신고횟수
$singo_count = 0;
if ($g4[singo_table] && $g4['member_suggest_singo']) {
    $sql = " select count(*) as cnt 
               from $g4[singo_table] 
              where mb_id = '$member[mb_id]' and sg_reason <> '게시판목적과 무관한 게시글' ";
    $row1 = sql_fetch($sql);
    $singo_count = $row1['cnt'];
    if ($singo_count)
        $mb_suggest_cnt = 0;
    }

// 어쩌다 추천 건수가 마이너스가 나면 0으로 setting
if ($mb_suggest_cnt < 0)
    $mb_suggest_cnt = 0;
?>
<link rel="stylesheet" href="<?=$g4['path']?>/plugin/recommend/style.css" type="text/css">
<div class="section1">
    <h2 class="hx">회원 추천 가이드</h2>
    <div class="tx">
    <? echo $g4['member_suggest_intro'] ?>
    <ul>
    <li>전체 추천건수 : <?=number_format($mb_tot_recommend[cnt])?></li>
    <li>추천을 받고 가입한 회원수 : <?=number_format($mb_recommend[cnt])?></li>
    <li>추천을 받고 미가입 회원수 : <?=number_format($mb_tot_recommend[cnt] - $mb_recommend[cnt])?></li>
    <li>추천 가능 회원수 : <?=number_format($mb_suggest_cnt)?></li>
    </ul>
    <?
    if ($singo_count) {
        echo "<b>신고건수가 $singo_count 건 있어서, 추천을 할 수 없습니다. 운영게시판에 문의 바랍니다.</b>";
    } else if ($member['mb_email_certify'] == '0000-00-00 00:00:00' && $member['mb_hp_certify_datetime'] == '0000-00-00 00:00:00') {
        echo "<b>이메일인증 또는 SMS 인증을 받은 회원만 가입추천을 할 수 있습니다. <a href='$g4[bbs_path]/member_confirm.php?url=register_form.php'>SMS,이메일 인증하러 가기</a></b>";
    } else if ($mb_suggest_cnt == 0) {
        // 다음 추천일을 계산
        $sql = " select * from $g4[member_suggest_table] where mb_id = '$member[mb_id]' order by join_no desc limit 1 ";
        $result = sql_fetch($sql);
        $sql = " select DATE_ADD('$result[suggest_datetime]', INTERVAL ($g4[member_suggest_days]+1) DAY) as datetime ";
        $result = sql_fetch($sql);
        echo "<b>다음 추천가능일은 " . substr($result[datetime], 0, 10) . "일 입니다.</b>";
    }
    ?>
    </div>
</div>

<? if ($mb_suggest_cnt > 0) { ?>
<br>
<form name=fregisterform method=post action="" enctype="multipart/form-data" autocomplete="off">
<input type=hidden name=token value="<?=$token?>">
<table class="tbl_type1" border="1" cellspacing="0" summary="회원 가입 추천">
<caption>회원가입추천</caption>
<colgroup>
<col width="10%">
<col width="30%">
<col width="">
</colgroup>
<tbody>
<? if ($g4['member_suggest_phone']) { ?>
<tr>
  <td class="ranking" scope="row">SMS 추천</td>
  <td><input class=m_text type=text name='mb_hp' size=35 maxlength=20 required itemname='핸드폰번호' value=''></td>
  <td align=left>
  &nbsp;&nbsp;
  <span class="btn_pack1 small icon">
  <input type=button value='추 천  ' class='medium' onclick="hp_certify(this.form);">
  </span>
  &nbsp;&nbsp;
  추천할 분의 핸드폰 번호를 입력하고 추천 버튼을 눌러주세요
  </td>
</tr>
<? } ?>
<? if ($g4['member_suggest_email']) { ?>
<tr>
  <td class="ranking" scope="row">이메일 추천</td>
  <td><input class=m_text type=text name='mb_email' size=35 maxlength=35 required style="ime-mode:disabled" itemname='이메일주소' value=''></td>
  <td align=left>
  &nbsp;&nbsp;
  <span class="btn_pack1 small icon">
  <input type=button value='추 천  ' class='medium' onclick="email_certify(this.form);">
  </span>
  &nbsp;&nbsp;
  추천할 분의 이메일 주소를 입력하고 추천 버튼을 눌러주세요
  </td>
</tr>
<? } ?>
</tbody>
</table>
</form>
<? } ?>

<script type='text/javascript'>
function hp_certify(f) { 
    var pattern = /^(0(?:10|11|16|17|18|19|70))[-]{0,1}[0-9]{3,4}[-]{0,1}[0-9]{4}$/; 
    if(!pattern.test(f.mb_hp.value)){  
        alert("핸드폰 번호가 입력되지 않았거나 번호가 틀립니다.\n\n핸드폰 번호를 010-123-4567 또는 01012345678 과 같이 입력해 주십시오."); 
        f.mb_hp.select(); 
        f.mb_hp.focus(); 
        return; 
    }

    f.target = "hiddenframe";
		f.action = "./hp_certify_suggest.php?hp="+f.mb_hp.value+"&token=<?=$token?>";
		f.submit();            
}

function email_certify(f) { 
    var pattern = /([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)/;
    if(!pattern.test(f.mb_email.value)){  
        alert("이메일 주소가 입력되지 않았거나 번호가 틀립니다.\n\n이메일 주소를 형식에 맞게 입력해 주십시오."); 
        f.mb_email.select(); 
        f.mb_email.focus(); 
        return; 
    }
    
    //f.target = "hiddenframe";
		f.action = "./email_certify_suggest.php?email="+f.mb_email.value+"&token=<?=$token?>";
		f.submit();            
} 
</script> 

<?
$sql = " select * from $g4[member_suggest_table] where mb_id = '$member[mb_id]' order by join_no desc ";
$result = sql_query($sql);
$list = array();
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $list[$i][no] = $i+1;
    $list[$i][suggest_datetime] = cut_str($row[suggest_datetime], 10, '');
    $list[$i][join_hp] = $row[join_hp];
    $list[$i][join_email] = $row[join_email];
    if ($row[join_mb_id]) 
        $list[$i][join_code] = '-';
    else
        $list[$i][join_code] = $row[join_code];
    if ($row[join_datetime] == '0000-00-00 00:00:00') 
        $list[$i][join_datetime] = '미가입';
    else
        $list[$i][join_datetime] = cut_str($row[join_datetime], 10, '');
    // 미가입인 경우는 취소 또는 재확인의 기회를 준다
    if ($row[join_mb_id] || $row[join_datetime] !== '0000-00-00 00:00:00')
        $list[$i][join_mb_id] = $row[join_mb_id];
    else {
        // 미가입이면 취소의 버튼을 넣어준다.
        $list[$i][join_cancel] = "<a href='./join_suggest_re.php?w=d&join_no=$row[join_no]'>추천취소</a>&nbsp;&nbsp;
                                  <a href='./join_suggest_re.php?w=r&join_no=$row[join_no]'>추천일갱신</a>";
    }
}
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<br>
<table class="tbl_type1" border="1" cellspacing="0" summary="회원 가입 추천 내역">
<caption>회원가입추천 내역</caption>
<colgroup>
<col width="10%">
<col width="15%">
<col>
<col width="15%">
<col width="15%">
<col width="20%">
</colgroup>
<thead>
<tr>
<th abbr="No." scope="col">No.</th>
<th scope="col">추천일자</th>
<th scope="col">추천전화번호/이메일</th>
<th scope="col">가입인증번호</th>
<th scope="col">가입일자</th>
<th scope="col">가입회원</th>
</tr>
</thead>
<tbody>
<?
foreach ($list as $row) {
?>
<tr>
  <td class="ranking" scope="row"><?=$row[no]?></td>
  <td><?=$row[suggest_datetime]?></td>
  <td><?=$row[join_hp]?></td>
  <td><?=$row[join_code]?></td>
  <td><?=$row[join_datetime]?></td>
  <td>
  <?
  if ($row[join_mb_id]) {
      $mb = get_member($row[join_mb_id], "mb_id, mb_nick, mb_email, mb_homepage");
      $mb_nick = get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]);
      echo $mb_nick;
  } else {
      echo $row[join_cancel];
  }
  ?>
  </td>
</tr>
<? } ?>
</tbody>
</table>
<br><br>
<?
include_once("$g4[path]/_tail.php"); 
?>
