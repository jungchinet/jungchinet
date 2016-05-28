<?
if (!defined('_GNUBOARD_')) exit;

if ($g4['is_cheditor5']) 
{
    $g4['cheditor4']      = "cheditor5";
    $g4['cheditor4_path'] = $g4['path'] . "/" . $g4['cheditor4'];

    function cheditor1($id, $width='100%', $height='250px')
    {
        global $g4;

        return "
        <script type='text/javascript'>
        var ed_{$id} = new cheditor('ed_{$id}');
        ed_{$id}.config.editorHeight = '{$height}';
        ed_{$id}.config.editorWidth = '{$width}';
        ed_{$id}.config.imgReSize = false;
        ed_{$id}.config.fullHTMLSource = false;
        ed_{$id}.inputForm = 'tx_{$id}';
        </script>";
    }
}
else 
{
    function cheditor1($id, $width='100%', $height='250')
    {
        global $g4;

        return "
        <script type='text/javascript'>
        var ed_{$id} = new cheditor('ed_{$id}');
        ed_{$id}.config.editorHeight = '{$height}';
        ed_{$id}.config.editorWidth = '{$width}';
        ed_{$id}.config.imgReSize = false;
        ed_{$id}.config.fullHTMLSource = false;
        ed_{$id}.config.editorPath = '{$g4[cheditor4_path]}';
        ed_{$id}.inputForm = 'tx_{$id}';
        </script>";
    }
}

function cheditor2($id, $content='')
{
    global $g4, $board;

    return "
    <textarea name='{$id}' id='tx_{$id}' style='display:none;'>{$content}</textarea>
    <script type='text/javascript'>
    ed_{$id}.config.boTable = '$board[bo_table]';
    ed_{$id}.config.allowedMaxImgSize = '{$g4[cheditor_uploadsize]}';
    ed_{$id}.run();
    </script>";
}
 
function cheditor3($id)
{
    return "document.getElementById('tx_{$id}').value = ed_{$id}.outputBodyHTML();";
}

function cheditor4($id)
{
    return "
    if (document.getElementById('tx_{$id}')) {
        var content_length = ed_{$id}.inputLength();
        var img_length = ed_{$id}.getImages();
        if (content_length < 1 &&  img_length < 1) { 
            alert('내용을 입력하십시오.'); 
            ed_{$id}.returnFalse();
            return false;
        }
    }    
    ";
}
?>
