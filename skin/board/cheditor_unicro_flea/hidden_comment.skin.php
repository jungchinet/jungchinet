<tr>
    <td style='word-break:break-all;padding:10px;'>
    <table width='100%'>
        <colgroup width=65>
        <colgroup width=''>
        <tr>
            <td style='text-align:right;'><b>딴지걸기?</b></td>
            <td style='text-align:left;'>이곳에 올리는 내용에 글쓴이가 안보여도 글에 대한 책임은 글쓴이에게 있습니다. 
            <? if ($member['mb_id'] && $member['mb_id'] >= $board[bo_comment_level]) {
                  // 하나의 게시글에 대해서 1번만 딴지를 걸 수 있습니다
                  $sql = " select count(*) as cnt from $g4[hidden_comment_table] where bo_table = '$bo_table' and wr_id = '$wr_id' and mb_id = '$member[mb_id]' ";
                  $hidden_cnt = sql_fetch($sql);
                  if ($hidden_cnt[cnt] == 0) {
            ?>
            <a href="javascript:hidden_comment()"><b>딴지하기</b></a>
            <?}?>
            <?}?>
            
            </td>
        </tr>
    </table>

    <div id="hidden_comment" style="display:none">
    <form method="post" name="hidden_comment" id="hidden_comment">
    <input type="hidden" class="ed" name="bo_table" value="<?=$bo_table?>" />
    <input type="hidden" class="ed" name="wr_id" value="<?=$wr_id?>" />
    
    <table width='100%'>
        <colgroup width=65>
        <colgroup width=''>
        <colgroup width=65>
        <tr>
            <td style='text-align:right;'>. 내용
            </td>
            <td>
                <input type='text' class='field_pub_01' size='90' maxlength=255 name='wr_hidden_comment' id='wr_hidden_comment' itemname='딴지걸기 내용' required >
            </td>
            <td rowspan=2>
                <a href='javascript:hidden_comment_update(<?=$wr_id?>)'><img src="<?=$board_skin_path?>/img/ok_button.gif" align=absmiddle></a>
            </td>
        </tr>
        <tr>
            <td style='text-align:right;'>. 링크
            </td>
            <td>
            <input type='text' class='field_pub_01' size='90' name='wr_hidden_comment_link' id='wr_hidden_comment_link' itemname='딴지걸기 링크' required >
            </td>
        </tr>
    </table>
    </form>
    </div>

    <script type="text/javascript" src="<?=$g4['path']?>/js/common.js"></script>
    <script language="JavaScript">
          // 딴지걸기 박스 toggle
          function hidden_comment() {
            if (document.getElementById('hidden_comment').style.display == 'block')
            {
                document.getElementById('hidden_comment').style.display = 'none';
            } else {
                document.getElementById('hidden_comment').style.display = 'block';
            }
          }
          // 선택한 메모를 업데이트
          function hidden_comment_update(wr_id) {
              var f = document.hidden_comment;
              if (trim(document.getElementById('wr_hidden_comment_link').value) == '' || trim(document.getElementById('wr_hidden_comment').value)=='') {
                  alert('값을 입력해주세요.');
                  return;
              }
              f.action = "<?=$g4[bbs_path]?>/hidden_comment_update.php";
              f.submit();
          }
          function hidden_comment_delete(url)
          {
            if (confirm("이 딴지글을 삭제하시겠습니까?")) location.href = url;
          }
      </script>


    <? // 딴지글을 가지고 옵니다. 
    $sql = " select co_id, mb_id, co_content, co_link, wr_singo from $g4[hidden_comment_table] where bo_table = '$bo_table' and wr_id = '$wr_id' order by co_id desc ";
    $result = sql_query($sql);
    $num_rows = mysql_num_rows($result);
    if ($num_rows) {
    ?>
    <table width='100%'>
        <colgroup width=65>
        <colgroup width=''>
        <?
        for ($i=0; $i < $num_rows; $i++) {
          $row = sql_fetch_array($result);
          $co_content = conv_content(stripslashes($row['co_content']), 0);
        ?>
        <tr>
            <td><a name="h_<?=$row['co_id']?>"></a></td>
            <td><? if ($row[wr_singo]) $co_content = "<font color=#B8B8B8>$co_content</font>"; echo$co_content?> <a href="<?=set_http(get_text($row[co_link]))?>" target=_new>바로가기</a>
            <?
            if ($row['mb_id']==$member['mb_id'] or $is_admin) { // 삭제버튼을 출력
                $hidden_comment_delete_link = "$g4[bbs_path]/hidden_comment_update.php?w=del&bo_table=$bo_table&wr_id=$wr_id&co_id=$row[co_id]";
            ?>
            <a href="javascript:hidden_comment_delete('<?=$hidden_comment_delete_link?>');">
            <img src='<?=$board_skin_path?>/img/co_btn_delete.gif' border=0 align=absmiddle alt='삭제'>
            </a>
            <? } ?>
                <?if ($singo_href) { // 딴지걸기를 신고 - 게시글 신고자격이 있는 사람에게만
                    $singo_href = "./singo_popin.php?bo_table=@hidden_comment&wr_id=$row[co_id]&wr_parent=$row[co_id]";
                ?>
                <a href="javascript:win_singo('<?=$singo_href?>');"><img src='<?=$board_skin_path?>/img/icon_singo.gif'></a>
                <?}?>
            </td>
        </tr>
        <? } ?>
    </table>
    <? } ?>

    </td>
</tr>
