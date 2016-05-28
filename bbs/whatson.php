<?
include_once("./_common.php");

$g4[title] = "$config[cf_title] - Whats on";

$head = (int) $head;

if ($head)
    include_once("../head.sub.php");
else
    include_once("./_head.php");

include_once("../lib/whatson.lib.php");

if (isset($skin)) { 
    $skin = preg_match("/^[a-zA-Z0-9_]+$/", $skin) ? $skin : "";
} else {
    $skin = "basic";
}

if (isset($options)) { 
    $options = preg_match("/^[a-zA-Z0-9_]+$/", $options) ? $options : "";
}

$rows = (int) $rows;
if ($rows <= 0 ) $rows = 10;

$subject_len = (int) $subject_len;
if ($subject_len <= 0 ) $subject_len = 40;

$page = (int) $page;
if ($page <= 0 ) $page = 1;

$check = (int) $check;

$target = strip_tags($target);

echo whatson($skin, $rows, $subject_len, $page, $options, $target, $check, $head);

if ($head)
    include_once("../tail.sub.php");
else
    include_once("./_tail.php");
?>
