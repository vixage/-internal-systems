<?php

$id = intval($_POST['id']);
$pass = $_POST['pass'];

if($id == ''|| $pass == ''){
	echo "パスワード入力してください。";
header('Location:index.php');
exit();
}

$dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
$user = 'root';
$password = '1125';

try{
$db = new PDO($dsn,$user,$password);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$stmt = $db->prepare(
"DELETE FROM responses WHERE thread_id=:id AND pass=:pass"
);



$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
$stmt->execute();
}catch(PDOException $e){
echo "エラー:".$e->getMessage();
}



header("Location:index.php");
exit();

?>