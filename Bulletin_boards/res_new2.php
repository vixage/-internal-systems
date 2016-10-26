<?php
include 'includes.php';

$id2 = $_POST['id'];


$body = $_POST['body'];
if (empty($_POST['name'])) {
    $name = "とあるAGE社員";
}else{
    $name = $_POST['name'];
}

$pass = $_POST['pass'];

$body = nl2br($body);


$dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
$user= 'root';
$password = '1125';

	
           try {
            $db = new PDO($dsn, $user, $password);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
			//プリペアドステートメント作成
            $stmt = $db->prepare("
            INSERT INTO responses (thread_id,body,name,created_at,pass)
            VALUES(:thread_id,:body,:name,now(),:pass)"
            );

            //パラメーターを割り当て

$stmt->bindParam(':thread_id',$id2,PDO::PARAM_STR);
$stmt->bindParam(':body',$body,PDO::PARAM_STR);
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->bindParam(':pass',$pass,PDO::PARAM_STR);



//クエリの実行
$stmt->execute();

header("Location:thread.php?id=$id2");
exit();
}catch(PDOException $e){
die('エラー：'.$e->getMessage());
}


