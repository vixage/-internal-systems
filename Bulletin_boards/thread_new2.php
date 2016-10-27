<?php
include 'includes.php';

if(empty($_POST['name'])){
	$name = "とあるAGE社員";
}
else{
	$name = $_POST['name'];
	
}


$title = $_POST['title'];
$body = $_POST['body'];

//$pass = $_POST['pass'];
$id2 = $_POST['id'];

$body = nl2br($body);



$dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
$user= 'root';
$password = '1125';

	
           try {
            $db = new PDO($dsn, $user, $password);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
			mysql_query("set names utf-8");
			//プリペアドステートメント作成
            $stmt = $db->prepare("
            INSERT INTO threads (name,title,body,created_at)
            VALUES(:name,:title,:body,now())"
            );

            //パラメーターを割り当て
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->bindParam(':title',$title,PDO::PARAM_STR);
$stmt->bindParam(':body',$body,PDO::PARAM_STR);
//$stmt->bindParam(':pass',$pass,PDO::PARAM_STR);

//クエリの実行
$stmt->execute();

header("Location:index.php");
exit();
}catch(PDOException $e){
die('エラー：'.$e->getMessage());
}

	

	//スレッド画面に遷移
	header("Location: thread_new.php");

?>