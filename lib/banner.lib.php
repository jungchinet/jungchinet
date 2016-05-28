<?
if (!defined('_GNUBOARD_')) exit;

// 배너를 가져온다
// bg_id : 배너그룹 id
// bn_id : 배너 id (bn_id가 지정되면 딱 1개만 출력 됩니다. 배너지정 출력의 목적)
// rows : 출력할 배너의 수 
// sst : 정렬방법, 0: 랜덤, 1 : 기본정렬(순서, 배너 id 내림차순)
//       통상적인 경우에는 랜덤으로, 메인에 의미 있게 출력할 때는 순서대로 하는 것이 좋습니다.
function get_banner($bg_id, $skin="basic", $bn_id="", $rows=0, $sst=0, $opt="")
{
    global $g4;

    if ($sst == 1)
        $sst_sql = " bn_order, bn_id desc ";
    else
        $sst_sql = " rand() ";

    // 날짜를 지정해 줍니다.
    $sql_datetime = " and '$g4[time_ymdhis]' > bn_start_datetime and bn_end_datetime > '$g4[time_ymdhis]' ";

    //특정 테이블 값이 있으면 해당 테이블만 뽑아옴
    if($_GET['bo_table']){
        $table_sq=" and bn_table='".$_GET['bo_table']."' ";
    }else{
        $table_sq="";
    }

    // bc_id가 지정되면 bc_id만 가져 옵니다. 아니면 n개를 가져 옵니다. 가져오는 방식은 rand 입니다.
    if ($bn_id) {
        $sql = " select * from $g4[banner_table] where bg_id='$bg_id' and bn_id='$bn_id' and bn_use = '1' $sql_datetime ";
    } else {

        $hsql="select count(*) cnt from $g4[banner_table] where bg_id='$bg_id' and bn_table='{$_GET['bo_table']}'";
        $hrst=sql_fetch($hsql);

//        echo '<br>이 게시판 전용배너 갯수 : '.$hrst['cnt'];
        
        if($hrst['cnt']>0){ //타겟 테이블이 있을 경우 (전체 대상과 같이 출력되어야함으로 내부에서 또 랜덤..)

            //타겟배너 있는지 쳌쿠
            $isql="select count(*) cnt from $g4[banner_table] where bg_id='$bg_id' and bn_table='{$_GET['bo_table']}'";
            $irst=sql_fetch($isql);
            $irst=$irst['cnt'];
		//echo 'target banner : '.$irst;

            //전체배너 있는지 쳌쿠..
            $jsql="select count(*) cnt from $g4[banner_table] where bg_id='$bg_id' and bn_all='1'";
            $jrst=sql_fetch($jsql);
            $jrst=$jrst['cnt'];

		//echo 'all banner : '.$jrst;

            if($irst>0 and $jrst>0){

                if(rand(1,2)==1){
                    $sql = " select * from $g4[banner_table] where bg_id='$bg_id' $table_sq and bn_use = '1' $sql_datetime order by $sst_sql ";
                    if ($rows)
                        $sql .= "  limit 0, $rows ";

//                    echo '<br>전체,타겟 둘다 있을 때 타겟출력임';
                }else{
                    $sql = " select * from $g4[banner_table] where bg_id='$bg_id' and bn_all=1 and bn_use = '1' $sql_datetime order by $sst_sql ";
                    if ($rows)
                        $sql .= "  limit 0, $rows ";
//                    echo '<br>전체,타겟 둘다 있을 때 전체출력임';
                }

            }else{

                if($irst>0){

                    $sql = " select * from $g4[banner_table] where bg_id='$bg_id' $table_sq and bn_use = '1' $sql_datetime order by $sst_sql ";
                    if ($rows)
                        $sql .= "  limit 0, $rows ";
//                    echo '<br>타겟만 있을 때 타겟 출력임';

                }

                if($jrst>0){

                    $sql = " select * from $g4[banner_table] where bg_id='$bg_id' and bn_all=1 and bn_use = '1' $sql_datetime order by $sst_sql ";
                    if ($rows)
                        $sql .= "  limit 0, $rows ";
//                    echo '<br>전체만 있을 때 전체출력임';

                }

            }


        }else{ //타겟 테이블이 없을 경우 전체 대상인 배너만 출력
            $sql = " select * from $g4[banner_table] where bg_id='$bg_id' and bn_all=1 and bn_use = '1' $sql_datetime order by $sst_sql ";
            if ($rows)
                $sql .= "  limit 0, $rows ";
//            echo '<br>타겟없는랜덤출력임';
        }
    }
    $result = sql_query($sql);

    // 배너그룹 정보도 가져 옵니다.
    $sql = " select * from $g4[banner_group_table] where bg_id = '$bg_id' ";
    $bg = sql_fetch($sql);

    $list = array();
    for ($i=0; $row = sql_fetch_array($result); $i++) {

        if($row[bn_all]){ //전체 출력이면 기냥 통과~
            /*$list[$i][bg_id] = $bg_id;
            $list[$i][bn_id] = $row[bn_id];
            $list[$i][bn_target] = $row[bn_target];
            $list[$i][bn_table] = $row[bn_table];
            $list[$i][bn_all] = $row[bn_all];
            $list[$i][bn_url] = $row[bn_url];
            $list[$i][bn_subject] = $row[bn_subject];
            $list[$i][bn_image] = $row[bn_image];
            $list[$i][bn_text] = $row[bn_text];
            $list[$i][bg_width] = $row[bg_width];
            $list[$i][bg_height] = $row[bg_height];*/
            $list[$i][bg_id] = $bg_id;
            $list[$i][bn_id] = $row[bn_id];
            $list[$i][bn_target] = $row[bn_target];
            $list[$i][bn_table] = $row[bn_table];
            $list[$i][bn_all] = $row[bn_all];
            $list[$i][bn_url] = $row[bn_url];
            $list[$i][bn_subject] = $row[bn_subject];
            $list[$i][bn_image] = $row[bn_image];
            $list[$i][bn_text] = $row[bn_text];
            $list[$i][bg_width] = $row[bg_width];
            $list[$i][bg_height] = $row[bg_height];
            break;
        }else if($row[bn_table]){
            if($row[bn_table]==$_GET['bo_table']){
                $list[$i][bg_id] = $bg_id;
                $list[$i][bn_id] = $row[bn_id];
                $list[$i][bn_target] = $row[bn_target];
                $list[$i][bn_table] = $row[bn_table];
                $list[$i][bn_all] = $row[bn_all];
                $list[$i][bn_url] = $row[bn_url];
                $list[$i][bn_subject] = $row[bn_subject];
                $list[$i][bn_image] = $row[bn_image];
                $list[$i][bn_text] = $row[bn_text];
                $list[$i][bg_width] = $row[bg_width];
                $list[$i][bg_height] = $row[bg_height];
                break;
            }else{
                continue;
            }
        }

    }

    $banner_skin_path = "$g4[path]/skin/banner/$skin";

    ob_start();
    include "$banner_skin_path/banner.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 배너 그룹을 SELECT 형식으로 얻음
function get_banner_group_select($name, $selected='', $event='')
{
    global $g4, $is_admin, $member;

    $sql = " select bg_id, bg_subject from $g4[banner_group_table] a ";
    if ($is_admin == "group") {
        $sql .= " left join $g4[member_table] b on (b.mb_id = a.bg_admin)
                  where b.mb_id = '$member[mb_id]' ";
    }
    $sql .= " order by a.bg_id ";

    $result = sql_query($sql);
    $str = "<select name='$name' $event>";
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $str .= "<option value='$row[bg_id]'";
        if ($row[bg_id] == $selected) $str .= " selected";
        $str .= ">$row[bg_subject] ($row[bg_id])</option>";
    }
    $str .= "</select>";
    return $str;
}

// 배너를 SELECT 형식으로 얻음
function get_banner_select($name, $selected='', $event='')
{
    global $g4, $is_admin, $member;

    $sql = " select bn_id, bn_subject from $g4[banner_table] a ";
    $sql .= " order by a.bg_id ";

    $result = sql_query($sql);
    $str = "<select name='$name' $event>";
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $str .= "<option value='$row[bg_id]'";
        if ($row[bn_id] == $selected) $str .= " selected";
        $str .= ">$row[bn_subject] ($row[bn_id])</option>";
    }
    if ($selected == '')
        $str .= "<option value ='' selected>전체</option>";
    else
        $str .= "<option value =''>전체</option>";
    $str .= "</select>";
    return $str;
}
?>
