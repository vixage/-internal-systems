<?php
	 class DB{
		 public function  dbConnect(){
		 	try{
				$dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
				$user = 'root';
				$password = 'tm227005';
				$db = new PDO($dsn,$user,$password);
				$db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			}catch(PDOException $errorMessage) {
			'エラー:' . $errorMessage->getMessage();
			}
			return $db;
		 }
	}
?>