<?
// $mnb의 이름을 얻습니다
function mnb_name($menu, $mnb) {
    foreach ($menu as $item) {
        if ($item[id] == $mnb)
            return $item[name];
    }
}

// $mnb를 출력 합니다.
function print_mnb($menu) {
    global $g4, $mnb;

    echo "<ul style='display:block;'>";
    foreach ($menu as $item) {
        if ($item['hidden'])
            continue;
        $class = "";
        // 새창 띄우기의 경우, $item[new] = 1
        if ($mnb == $item[id])
            $class = " class='active' ";
        else
            $class = "";
        if ($item['new'] == 1)
            $target = "target=new";
        else
            $target = "";

        if ($item['href'])
            echo "<li $class><a href='$item[href]' $target><span>$item[name]</span></a></li>";
        else
            echo "<li $class><a href='$g4[url]?mnb=$item[id]' $target><span>$item[name]</span></a></li>";
    }
    echo "</ul>";
}

// $snb를 출력 합니다.
function print_snb($menu, $title) {
    global $g4, $snb, $mnb, $snb_indent;

    // $snb가 비었으면, 그냥 return
    if ($menu == "" || count($menu) == 0)
        return;

    // 제목은 indent style만 적용해 줍니다.
    $ul_style = "style='$snb_indent'";

    echo "<ul><li class='active'>";
    echo "<a href='#'><span $ul_style>$title</span><span class='i'></span></a>";
    echo "<ul style='display:block;'>";
    foreach ($menu as $item) {

        // style 값이 있으면 $snb_style에 지정
        $snb_style = " style='" . $snb_indent . $item[style] . "' ";

        // 새창 띄우기의 경우, $item[new] = 1
        $class = "";
        if ($snb == $item[id] && $item['new'] !== 1)
            $class = " class='active' ";

        // bar인경우에는 줄 찍~ 그어주고 다음으로
        if ($item['type'] == "bar") {
            if ($item['style'])
                $hstyle = " style='" . $item['style'] . "' ";

            echo "<li $class><hr $hstyle></li>";
            continue;
        }
        
        //  추가로 $item[name]이 없으면 게시판 정보를 읽어서 채워준다.
        if ($item[name] == "") {
            $bo = get_board($item[id], "bo_subject");
            $item['name'] = strip_tags($bo[bo_subject]);
        }

        // item['img']에 속성이 있으면... 이름대신 이미지를 출력
        if ($item['img']) {
            $itname = "<img src='$item[img]' style='vertical-align:middle;' alt=''>";
        } else {
            $itname = $item['name'];
        }
        
        if ($item['new'] == '1')
            echo "<li><a href='$item[href]' alt='$item[name]' target=new><span $snb_style $indent>$itname</span></a></li>";
        else {
            // href가 없으면 기본으로 게시판 테이블을 같은 이름으로 연결해 준다.
            if (trim($item['href']) == "") {
                $item[href] = $g4['bbs_path'] . "/board.php?bo_table=" . $item[id];
            }
            // ?가 href에 없으면, 그냥 프로그램이니까 뒤에 ?를 붙여준다.
            if (substr_count($item[href], "?") > 0)
                echo "<li $class><a href='$item[href]&snb=$item[id]&mnb=$mnb' alt='$item[name]'><span $snb_style $indent>$itname</span></a></li>";
            else
                echo "<li $class><a href='$item[href]?snb=$item[id]&mnb=$mnb' alt='$item[name]'><span $snb_style $indent>$itname</span></a></li>";
        }
    }
    echo "</ul>";
    echo "</li></ul>";
}

// 아무것도 지정 안될 때, $bo_table이나 프로그램 이름으로, $mnb, $snb를 찾아준다 - 최신글이나 인기글 같은거 때문입니다.
// 그래도 나는 메뉴고 뭐고 다 무시하고 했으면 좋겠다 싶으면 아래 코드를 지우면 됩니다.
// 설마, 그런일은 생기지 않으리라고 봅니다.
if ($mnb == "" || $snb == "") {
    foreach ($mnb_arr as $item) {
        // 새창 뜨는거는 제외 시켜야 한다.
        if ($item['new'] !== '1' && $snb_arr[$item[id]]) {
            foreach ($snb_arr[$item[id]] as $sub_item) {
                // 새창 뜨는거는 제외 시켜야 한다.
                if ($sub_item['new'] !== '1') {
                    // parse_url을 해서, query를 먼저 찾습니다.
                    $u_item = parse_url($sub_item['href']);
                    // 담에는 &로 explode 해줍니다. 인자별로 잘라야 제대로 비교를 하죠.
                    if (trim($u_item['query']) == "") {
                        $u_array = array();
                        contine;
                    } else {
                        $u_array = explode("&", $u_item['query']);
                    }

                    if ($bo_table == "") {
                        // $bo_table에 값도 없어. 그럼 어케할까? 혹시 특별한 프로그램 이름이 아닐까?
                        if ($sub_item['href'] && strstr($sub_item['href'], "$_SERVER[SCRIPT_NAME]")) {
                            $mnb = $item['id'];
                            $snb = $sub_item['id'];
                        }
                    } else {
                        // href에 값이 없으면, href를 만들어준거니까, 그거는 무조건 게시판이다.
                        // 어? 그런데 href에 값이 있다구?
                        // 그러면, 배열에 있는지 찾아본다~ 유레카. 더 쉬운 방법도 있겠지만... 생각이 안난다.
                        if (($sub_item['href'] == "" && $bo_table == $sub_item['id']) || $u_array && in_array("bo_table=$bo_table" , $u_array)) {
                            $mnb = $item['id'];
                            $snb = $sub_item['id'];
                        }
                    }
                }
            }
        }
    }
    
    // $mnb, $snb를 $qtr에 넣어줘야징... ㅋㅋ
    $qstr .= '&mnb=' . urlencode($mnb);
    $qstr .= '&snb=' . urlencode($snb);
}

// $mnb를 가지고, 게시판 목록을 추려 냅니다. 최신글 만들때 쓰려구요.
function get_snb_list($menu) {
    global $g4, $mnb, $snb;

    $snb_list = array();
    
    if (!$menu)
        return;
    foreach ($menu as $item) {
        if ($item['new'] == '1' || $item['hidden'] == '1' || $item['type'] == 'bar')
            // 새창으로 뜨는거는 표시할 이유 없슴
            continue;
        else {
            if (trim($item['href']) == "")
                // href가 없으면 기본으로 게시판 테이블을 같은 이름으로 연결해 주니까, 게시판이란거지.
                $snb_list[] = $item[id];
            else {
                // url에서 board.php?bo_table=가 들어가야지만 게시판으로 인정
                // parse_url을 해서, query를 먼저 찾습니다.
                $u_item = parse_url($item['href']);
                if (trim($u_item['query']) == "") {
                    // 어라? query가 없네? 그럼 패스
                    contine;
                } else {
                    // 이제 &를 가지고 잘라. 안그러면 속을 수 있거든.
                    $u_array = explode("&", $u_item['query']);
                    // 배열에 있는지 찾아본다~ 그런데, id랑 bo_table이 다를 수 있다는거...
                    // loop를 돌려서 bo_table=가 있는거 찾고, 담에 $bo_table을 추려야 한다.
                    foreach ($u_array as $t_array) {
                        $ex = explode("bo_table=", $t_array);
                        // explode 했는데, 오른쪽에 값이 있으면, 그게 $bo_table
                        if ($ex[1]) {
                            $snb_list[] = $ex[1];
                        }
                    }
                }
            }
        }
    }

    return $snb_list;
}
?>
<!-- 필요한 css를 모두 포함시켜 줍니다 -->
<link rel="stylesheet" href="<?=$g4[layout_skin_path]?>/layout.css" type="text/css" />
<link rel="stylesheet" href="<?=$g4[layout_skin_path]?>/top_menu.css" type="text/css" />
<link rel="stylesheet" href="<?=$g4[layout_skin_path]?>/side_menu.css" type="text/css" />
<link rel="stylesheet" href="<?=$g4[layout_skin_path]?>/ui.css" type="text/css" />
<link rel="stylesheet" href="<?=$g4[layout_skin_path]?>/footer.css" type="text/css" />
