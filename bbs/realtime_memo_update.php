<?
include ("./_common.php");

if ($member[mb_id])
    sql_query(" update {$g4[member_table]} set mb_memo_call = '' where mb_id = '$member[mb_id]' ", FALSE);
?>
