<?
include_once("_common.php");

include_once $g4['path'].'/bbs/securimage.php';

// echo "한글"로 출력하지 않는 이유는 Ajax 는 euc_kr 에서 한글을 제대로 인식하지 못하기 때문
// 여기에서 영문으로 echo 하여 Request 된 값을 Javascript 에서 한글로 메세지를 출력함

if (preg_match("/[^0-9]+/i", $reg_wr_key)) {
    echo "110"; // 유효하지 않은 글자
} else if (strlen($reg_wr_key) < 5) {
    echo "120"; // 4보다 작은 글자
} else {

  $img = new Securimage;
  if ($img->check($reg_wr_key) == false) {

        echo "130"; // 틀린 코드

    } else {

            echo "000"; // 정상
            set_session('scaptcha_code', md5($reg_wr_key.$_SESSION["ss_token"]));
    }
}
?>
