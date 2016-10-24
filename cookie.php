<?php

$dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
$user = 'root';
$password = '1125';

try {
	$db = new PDO($dsn,$user,$password);
	$db = setAttribute(PDO::ATTER_EMULATE_PREPARES,false);

	//プリペアドステートメント作成
	$stmt = $db->prepare(
		"SELECT name FROM users");


	
} catch (PODException $e) {
	
}

setcookie()
?>