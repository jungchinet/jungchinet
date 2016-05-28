<?php
$region_data = array();
$sql = "
    SELECT  b.city_name
            , b.bo_subject AS name
            , b.image AS region_image
            , b.image_width AS region_image_width
            , b.image_height AS region_image_height
            , a.party AS lawmaker_party
            , a.image AS lawmaker_image
            , a.name_ko AS lawmaker_name_ko
            , a.birth AS lawmaker_birth
            , a.win_no AS lawmaker_win_no
            , a.info_page AS lawmaker_info_page
            , a.twitter AS lawmaker_twitter
    FROM    j_politicians a
            , j_boards b
    WHERE   a.region_id = b.region_id
            AND bo_table = '{$board['bo_table']}'";
$result_s = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result_s); $i++) {
    $region_data = $row;
    $region_data['lawmaker_birth'] = date("Y년 m월 d일", strtotime($region_data['lawmaker_birth']));  //지역구 국회의원 생일
    switch($region_data['lawmaker_win_no']) {
        case '0' :
        case '1' : $region_data['lawmaker_win_no'] = '초선'; break;
        case '2' : $region_data['lawmaker_win_no'] = '재선'; break;
        case '3' : $region_data['lawmaker_win_no'] = '3선'; break;
        case '4' : $region_data['lawmaker_win_no'] = '4선'; break;
        case '5' : $region_data['lawmaker_win_no'] = '5선'; break;
        case '6' : $region_data['lawmaker_win_no'] = '6선'; break;
        case '7' : $region_data['lawmaker_win_no'] = '7선'; break;
        case '8' : $region_data['lawmaker_win_no'] = '8선'; break;
    }
}

?>


  <div class="boss_sub"><strong><?= $region_data['name'] ?> 국회의원</strong></div>
  <div class="boss_picture">
      <p><a href="<?= $region_data['lawmaker_homepage'] ?>"><img src="<?= $region_data['lawmaker_image'] ?>" width="90" height="121" /></a><?= $region_data['lawmaker_name_ko'] ?></p>
  </div>
  <div class="boss_profile">
    <ul>
      <li><?= $region_data['lawmaker_birth'] ?></li>
      <!--<li><?= $region_data['lawmaker_win_no'] ?></li>-->
      <li><?= $region_data['lawmaker_party'] ?></li>
    </ul>
<!--<h1>    <a href="<?= $region_data['lawmaker_info_page'] ?>">약력,법안발의</a></h1>-->
  </div>
