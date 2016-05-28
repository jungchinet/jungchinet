<?
if (!defined('_GNUBOARD_')) exit;

// 최신글 추출
function latest_gblog($skin_dir="", $mb_id="", $rows=10, $subject_len=40, $gallery_view=0, $options="")
{
    global $g4;

    include_once("$g4[path]/blog/gblog.config.php");

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();

    if ($mb_id) {
        $sql = " select id from $gb4[blog_table] where mb_id = '$mb_id' ";
        $result1 = sql_fetch($sql);
        $where_sql = " where id = $result1[id] ";
    } else {
        $where_sql = " ";
    }
    
    $sql = " select * from $gb4[post_table] $where_sql order by id desc limit $rows ";
    $result = sql_query($sql);

    for ($i=0; $row = sql_fetch_array($result); $i++) {
          $list[$i] = $row;
          
          if ($mb_id) {
              $list[$i][bo_name] = $result1[blog_name];
              $blog_id = $mb_id;
          } else {
              $result2 = sql_fetch(" select * from $gb4[blog_table] where id = '$row[blog_id]' ");
              $list[$i][bo_name] = $result2[blog_name];
              $blog_id = $result2[mb_id];
          }

          $list[$i][subject] = conv_subject($row[title], $subject_len, "…");
          $list[$i][datetime] = substr($row[post_date],0,10);
          if ($row[comment_count] > 0)
              $list[$i][comment_cnt] = "($row[comment_count])";

          // 비밀글
          if ($row[secret]==0)
               $list[$i][icon_secret] = "<img src='$skin_path/img/icon_secret.gif' align='absmiddle'>";

          $list[$i][href] = "$gb4[path]/?mb_id=$blog_id&id=$row[id]";
    }
    
    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

?>
