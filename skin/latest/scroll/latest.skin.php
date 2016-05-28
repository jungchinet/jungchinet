<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 위로 스크롤되는 최신글

// 사용법 : 
// 스킨, 게시판아이디, 출력라인, 글자수, "몇개라인,라인높이"
// latest($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="")

// $rows(출력라인)는 $line_mod의 2의 배수 이상으로 설정하셔야 합니다.

// 유니크 값 (최신글은 한페이지에 여러개 둘 수 있으므로... 자바스크립트에서 함수, 변수 충돌을 방지)
$uni = md5(uniqid(rand(), true));

list($line_mod, $height) = explode(",", $options);

$box_height = (int)$line_mod * (int)$height;
?>

<table width=100% cellpadding=0 cellspacing=0 border=0>
<colgroup width=14>
<colgroup>
<colgroup width=37>
<colgroup width=14>
<tr>
    <td><img src='<?=$latest_skin_path?>/img/latest_t01.gif'></td>
    <td background='<?=$latest_skin_path?>/img/bg_latest.gif'>&nbsp;&nbsp;<strong><a href='<?=$g4['bbs_path']?>/board.php?bo_table=<?=$bo_table?>'><?=$board['bo_subject']?></a></strong></td>
    <td background='<?=$latest_skin_path?>/img/bg_latest.gif'><a href='<?=$g4['bbs_path']?>/board.php?bo_table=<?=$bo_table?>'><img src='<?=$latest_skin_path?>/img/more.gif' border=0></a></td>
    <td><img src='<?=$latest_skin_path?>/img/latest_t02.gif'></td>
</tr>

<? if (count($list) == 0) { ?>
    <tr><td colspan=4 align=center height=50>게시물이 없습니다.</td></tr>
<? } else { ?>
    <tr><td colspan=4 style='padding-left:20px; padding-right:20px; padding-top:5px; padding-bottom:5px;'>

    <script language="javascript">
    var roll_height_<?=$uni?> = <?=$box_height?>;
    var total_area_<?=$uni?> = 0;
    var wait_flag_<?=$uni?> = true;

    var bMouseOver_<?=$uni?> = 1;
    var roll_speed_<?=$uni?> = 1;
    var waitingtime_<?=$uni?> = 3000;
    var s_tmp_<?=$uni?> = 0;
    var s_amount_<?=$uni?> = <?=(int)$height?>;
    var roll_text_<?=$uni?> = new Array();
    var startPanel_<?=$uni?> = 0;
    var n_panel_<?=$uni?> = 0;
    var i_<?=$uni?> = 0;

    function start_roll_<?=$uni?>()
    { 
        i_<?=$uni?> = 0;
        for (i_<?=$uni?> in roll_text_<?=$uni?>)
            n_panel_<?=$uni?>++;

        n_panel_<?=$uni?> = n_panel_<?=$uni?> -1 ;
        startPanel_<?=$uni?> = Math.round(Math.random()*n_panel_<?=$uni?>);
        if(startPanel_<?=$uni?> == 0) {
            i_<?=$uni?> = 0;
            for (i_<?=$uni?> in roll_text_<?=$uni?>) 
                insert_area_<?=$uni?>(total_area_<?=$uni?>, total_area_<?=$uni?>++);
        } else if(startPanel_<?=$uni?> == n_panel_<?=$uni?>) {
            insert_area_<?=$uni?>(startPanel_<?=$uni?>, total_area_<?=$uni?>);
            total_area_<?=$uni?>++;
            for (i_<?=$uni?>=0; i_<?=$uni?><startPanel_<?=$uni?>; i_<?=$uni?>++) {
                insert_area_<?=$uni?>(i_<?=$uni?>, total_area_<?=$uni?>);
                total_area_<?=$uni?>++;
            }
        } else if((startPanel_<?=$uni?> > 0) || (startPanel_<?=$uni?> < n_panel_<?=$uni?>)) {
            insert_area_<?=$uni?>(startPanel_<?=$uni?>, total_area_<?=$uni?>);
            total_area_<?=$uni?>++;
            for (i_<?=$uni?>=startPanel_<?=$uni?>+1; i_<?=$uni?><=n_panel_<?=$uni?>; i_<?=$uni?>++) {
                insert_area_<?=$uni?>(i_<?=$uni?>, total_area_<?=$uni?>);
                total_area_<?=$uni?>++;
            }
            for (i_<?=$uni?>=0; i_<?=$uni?><startPanel_<?=$uni?>; i_<?=$uni?>++) {
                insert_area_<?=$uni?>(i_<?=$uni?>, total_area_<?=$uni?>);
                total_area_<?=$uni?>++;
            }
        }
      
        if ( navigator.appName == "Microsoft Internet Explorer" ) {
            if ( navigator.appVersion.indexOf ( "MSIE 4" ) > -1 )
            return ;
        }
        window.setTimeout("rolling_<?=$uni?>()",waitingtime_<?=$uni?>);
    }

    function rolling_<?=$uni?>()
    { 
        if (bMouseOver_<?=$uni?> && wait_flag_<?=$uni?>) {
            for (i_<?=$uni?>=0;i_<?=$uni?><total_area_<?=$uni?>;i_<?=$uni?>++) {
                tmp_<?=$uni?> = document.getElementById('scroll_area_<?=$uni?>'+i_<?=$uni?>).style;
                tmp_<?=$uni?>.top = parseInt(tmp_<?=$uni?>.top)-roll_speed_<?=$uni?>;
                
                if (parseInt(tmp_<?=$uni?>.top) <= -roll_height_<?=$uni?>) {
                    tmp_<?=$uni?>.top = roll_height_<?=$uni?>*(total_area_<?=$uni?>-1);
                }
                
                if (s_tmp_<?=$uni?>++ > (s_amount_<?=$uni?>-1)*roll_text_<?=$uni?>.length) {
                    wait_flag_<?=$uni?>=false;
                    window.setTimeout("wait_flag_<?=$uni?>=true;s_tmp_<?=$uni?>=0;",waitingtime_<?=$uni?>);
                }
            }
        }
        window.setTimeout("rolling_<?=$uni?>()", 1);
    }

    function insert_area_<?=$uni?>(idx_<?=$uni?>, n_<?=$uni?>)
    { 
        document.write('<div style="left: 0px; width: 100%; position: absolute; top: '+(roll_height_<?=$uni?>*n_<?=$uni?>)+'px" id="scroll_area_<?=$uni?>'+n_<?=$uni?>+'">\n'+roll_text_<?=$uni?>[idx_<?=$uni?>]+'\n</div>\n');
    }

    <?
    //$roll_text = array();
    for ($i=0; $i<count($list); $i++) {
        $k = (int)($i / $line_mod);
        if (!isset($roll_text[$k])) 
            $roll_text[$k] = "";

        $roll_text[$k] .= "<div style=\"height:{$height}px; padding-top:0px;\">";
        $roll_text[$k] .= "<a href=\"{$list[$i]['href']}\">";
        $roll_text[$k] .= "<img src=\"{$latest_skin_path}/img/latest_icon.gif\" align=absmiddle border=0>&nbsp;&nbsp;";
        $roll_text[$k] .= $list[$i]['subject'];
        $roll_text[$k] .= "</a>";

        if ($list[$i]['comment_cnt']) 
            $roll_text[$k] .= " <a href=".addslashes($list[$i]['comment_href']).">{$list[$i]['comment_cnt']}</a>";

        $roll_text[$k] .= "</div>";
    }

    for ($i=0; $i<=$k; $i++) {
        echo "roll_text_{$uni}[$i] = '{$roll_text[$i]}';\n";
    }
    ?>
    </script>

    <div style="left: 0px; width: 100%; position: relative; top: 0px; height: <?=$box_height?>px; overflow:hidden;" onMouseover="bMouseOver_<?=$uni?>=0" onMouseout="bMouseOver_<?=$uni?>=1" id="latest_scroll_<?=$uni?>">
    <script language='javascript'>
    var no_script_flag_<?=$uni?> = false ;
    if ( navigator.appName == "Microsoft Internet Explorer" ) {
        if ( navigator.appVersion.indexOf ( "MSIE 4" ) > -1 ) {
            document.write ( roll_text_<?=$uni?>[0] ) ;
            no_script_flag_<?=$uni?> = true ;
        }
    }
    if ( no_script_flag_<?=$uni?> == false )
        start_roll_<?=$uni?>();
    </script>
    </div>							   

    </td></tr>
<? } ?>

<tr><td colspan=4 bgcolor=#EBEBEB height=1></td></tr>
</table>
