<?php
class DB{
	public function connect() {
	try {
	$dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
	$user= 'root';
	$password = '1125';
	$db = new PDO($dsn, $user, $password);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
	} catch (PDOException $e) {
		exit("データベースに接続できません。：{$e->getMessage()}");
	}
	return $db;
}
}

?>