<?

if(!$bo_table) echo "<script>alert('no botable');</script>";

$configFile1 = "_rss_".$bo_table."_addr.php";	
$configFile2 = "_rss_".$bo_table."_freq.php";
$cacheFile = "_rss_".$bo_table."_lastmodified.txt";
$rss_path = $board_skin_path."/_rss";	// setup_rss.php 에선 사용할 수 없어...
$channelFile = $rss_path."/".$configFile1;

$writer_id = "";
$writer_name = "RSS";
$writer_passwd = "rss123";

// 뉴스 검색 사이트
// 처음 빈 필드는 전체 검색용
// 두번째 부터 사용 ... : $channellist + 검색어 형태로 사용됨
$channellist = array(
	"",
	"http://newssearch.naver.com/search.naver?where=rss&query=", // 네이버 뉴스 검색
	"http://search.empas.com/search/news_rss.html?q="	// 엠파스 뉴스 검색
);

$channellist_name = array(
	"전체 검색",
	"네이버 뉴스",
	"엠파스 뉴스"
);

// 주기 저장
function save_freq($cf1) {
	global $configFile2;
	$data = "<?".trim($cf1)."?>";
	$fp = @fopen($configFile2, "w");
	fwrite($fp, $data);
	fclose($fp);
}

// 주소록 저장
function save_addr($cf0) {
	global $configFile1;
	$data = "<?\n".trim($cf0)."\n?>";
	$fp = @fopen($configFile1, "w");
	fwrite($fp, $data);
	fclose($fp);
}

// 주소록 읽어오기
function read_addr($file) {
	$fp = @fopen($file, "r");
	$data = @fread($fp, filesize($file));
	return trim(str_replace("?>", "", str_replace("<?", "", $data)));
}

function read_freq() {
	global $configFile2;
	// 주기 읽어오기
	$data = @file($configFile2);
	$data[0] = str_replace("?>", "", str_replace("<?", "", $data[0]));
	return trim($data[0]);
}

?>