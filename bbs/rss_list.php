<?
include_once("./_common.php");

include_once("./_head.php");

// RSS View를 제공하는 목록을 가져 옵니다.
$sql = " select bo_table, bo_subject from $g4[board_table] where bo_use_rss_view = 1 order by bo_order_search ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $rss_list[] = $row;
}
?>

<div>
<ul>
    <lh>
    <h3><?=$config[cf_title]?> - RSS Service List</h3>
    </lh>
    <?
    for ($i=0; $i < count($rss_list); $i++) {
        $rss = $rss_list[$i];
        echo "<li >$rss[bo_subject] - <a href='$g4[url]/bbs/rss.php?bo_table=$rss[bo_table]'>$g4[url]/bbs/rss.php?bo_table=$rss[bo_table]</a></li>";
    }
    ?>
  </ul>
</div>

<?
// 관리자의 경우 RSS 가능한 게시판 목록을 보여줍니다.
if ($is_admin == "super") { 
    $sql = "select A.bo_table, A.bo_subject, A.bo_use_rss_view, B.gr_id, B.gr_subject
              from $g4[board_table] A left join $g4[group_table] B on A.gr_id=B.gr_id 
             where bo_read_level = 1 and bo_use_search = 1 and gr_use_search = 1 and gr_use_access <> 1
                   order by B.gr_order_search, B.gr_id ";
    $result = sql_query($sql);

    $gr_no = -1;
    $gr_id = "";
    while ($row = sql_fetch_array($result)) {
        if ($gr_id !== $row[gr_id]) {
            $gr_no++;
            $gr_id = $row[gr_id];
        }
        $rss_adm[$gr_no][] = $row;
    }
}
?>

<form name=rssform method=post action="" enctype="multipart/form-data" autocomplete="off">
<input type=hidden name=bo_table value="">
<input type=hidden name=w value="">
<div>
<?=$config[cf_title]?> - RSS Service Admin
<ul>
    <?
    for ($i=0; $i < count($rss_adm); $i++) {
        $rss_gr = $rss_adm[$i];
        echo "<li>{$rss_gr[0][gr_subject]} - {$rss_gr[0][gr_id]}</li>";
        echo "<ul>";
        for ($j=0; $j < count($rss_gr); $j++) {
            $rss = $rss_gr[$j];
            echo "<li>";
            if ($rss[bo_use_rss_view]) {
                echo "<img src=./img/btn_rss.gif>";
                echo "<input type=button value='RSS Off' class='small' onclick=\"rss(this.form, 'off', '$rss[bo_table]');\">";
            } else
                echo "<input type=button value='RSS On' class='small' onclick=\"rss(this.form, 'on', '$rss[bo_table]');\">";
            echo " {$rss[bo_subject]} - $rss[bo_table]";
            echo "</li>";
        }
        echo "</ul>";
    }
    ?>
  </ul>
</div>
</form>

<script> 
function rss(f, w, bo_table) { 
    f.bo_table.value=bo_table;
    f.w.value=w;
		f.action = "<?=$g4[bbs_path]?>/rss_ajax.php";
		f.submit();            
} 
</script> 

<?
include_once("./_tail.php");
?>
