<?php
$db = new DB ();
$dbdb = $db->dbConnect ();

$articleID = $row ['ARTICLE_ID'];
$stmtWRC = $dbdb->query ( "SELECT COUNT(*) FROM ARTICLE" );
$comments = $stmtWRC->fetchColumn ();

//トップページのスレッドの最大ページ数
$countPage = 3;
$nowPage = (isset ( $_GET ['page'] )) ? $_GET ['page'] : "0";
$maxPage = ceil ( $comments / $countPage );
?>