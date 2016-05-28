<?
$sub_menu = "300820";
include_once("./_common.php");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "썸네일 삭제";

// 몇달전꺼부터 지울지 정하는거
$days = (int) $days;
if ($days <=0)
    $days = 90;

include_once("./admin.head.php");
echo "'완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.<br><br>";
echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

// 카운터를 초기화
$cnt=0;
$dnt=0;

// 첨부파일이저장된 디렉토리, 이 디렉토리 밑의 디렉토리를 뒤져서, 그 밑의 thumb 디렉토리에서 썸을 지웁니다.
// 불당팩에 적용을 위한거라 다른 곳에 쓰려면 알아서 코드를 수정해야 할거임.
// $tdir - 중간디렉토리 - thumb - 썸파일의 구조를 가지게 됩니다.
// 불당팩에서는 file의 경우 file - 게시판이름 - yymm의 구조를 가지므로 $tdir에 file/게시판이름을 지정해줍니다.
$tdir = array();
$path0 = "$g4[data_path]/file"; 
if (!$dir=@opendir($path0)) { 
    echo "$path0 디렉토리를 열지못했습니다."; 
}
// 밑의 디렉토리 목록을 먼저 좌르륵 뽑아야 합니다.
while($file=readdir($dir)) {
    if ($file == "." || $file == "..")
        ;
    else
        $tdir[] = "file/$file";
}
closedir($dir);

// 웹편집기 디렉토리도 추가
$tdir[] = 'cheditor4';

foreach ($tdir as $tfile) {

    $path1 = "$g4[data_path]/$tfile"; 
    if (!$dir=@opendir($path1)) { 
      echo "$path1 디렉토리를 열지못했습니다."; 
    } 

    // 밑의 디렉토리 목록을 먼저 좌르륵 뽑아야 합니다.
    while($file=readdir($dir)) {
        if ($file == "." || $file == ".." || $file == "index.php")
            ;
        else {
            $sub_path = $path1 . "/" . $file;
            $sub_thumb_path = $sub_path . "/thumb";
    
            // 그 밑에 thumb 디렉토리가 있으면 열어서 작업 합니다.
            if (@filetype($sub_thumb_path) == "dir") {

                // 디렉토리면 열고, 아니면 패쓰~
                if (!$thumbdir=@opendir($sub_thumb_path)) {
                    echo "$sub_thumb_path 디렉토리를 열지못했습니다."; 
                    contine;
                }
    	          echo "<script>document.getElementById('ct').innerHTML += '{$sub_path}<br/>';</script>\n";

                while($sub_thumbdir=readdir($thumbdir)) {
                    if ($sub_thumbdir == "." || $sub_thumbdir == "..")
                        ;
                    else {

                        $fpath = $sub_thumb_path . "/" . $sub_thumbdir;
                        if (@filetype($fpath) == "dir") {
                            if (!$thumbdir2=@opendir($fpath)) {
                                echo "$fpath 디렉토리를 열지못했습니다."; 
                                contine;
                            }

                            // thumb 디렉토리 밑에는 화질과 크기별로 구분된 썸 디렉토리가 있죠. 그걸 뒤져야죠.
                            while($thumb=readdir($thumbdir2)) {
                                if ($thumb == "." || $thumb == "..")
                                    ;
                                else {
                                    $rm_file = $fpath . "/" . $thumb;
                                    
                                  	if (!$atime=@fileatime("$rm_$file")) {
                                  	    continue; 
                                    }
                                  	if (time() > $atime + (3600 * 24 * $days)) {  // 지난시간을 초로 계산해서 적어주시면 됩니다. default : 6시간전
                                        //unlink($rm_file);
                            	          echo "<script>document.getElementById('ct').innerHTML += '$rm_file<br/>';</script>\n";
                                        $cnt++;
                                    }
                                }
                            }
                            closedir($thumbdir2);
                            @rmdir($fpath);
                        }
    	              }
    	          }
    	          closedir($thumbdir);
                $dnt++;
            }
        }
    }
    closedir($dir);
}

echo "<script>document.getElementById('ct').innerHTML += '<br><br>디렉토리검색 {$dnt}건, 썸파일 {$cnt}건 삭제 완료.<br><br>프로그램의 실행을 끝마치셔도 좋습니다.';</script>\n";
?>
