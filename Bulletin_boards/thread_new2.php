<?php
include 'common/checkLogin.php';
require_once 'common/DbManager.php';

if(empty($_POST['name'])){
	$name = "とあるAGE社員";
}
else{
	$name = $_POST['name'];
	
}


$title = $_POST['title'];
$body = $_POST['body'];
$img = $_POST['image'];
//$ip = $_POST['ip'];

//$pass = $_POST['pass'];
//$id2 = $_POST['id'];

$body = nl2br($body);
	
           try {
            $db = connect();
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
			$ip = $_SERVER["REMOTE_ADDR"];
			
			//プリペアドステートメント作成
            $stmt = $db->prepare("
            INSERT INTO threads (name,title,body,created_at,ipadress,image)
            VALUES(:name,:title,:body,now(),:ip,:img)"
            );

            //パラメーターを割り当て
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->bindParam(':title',$title,PDO::PARAM_STR);
$stmt->bindParam(':body',$body,PDO::PARAM_STR);
$stmt->bindParam(':ip',$ip,PDO::PARAM_STR);
$stmt->bindParam(':img',$img,PDO::PARAM_STR);
//$stmt->bindParam(':pass',$pass,PDO::PARAM_STR);

//クエリの実行
$stmt->execute();

header("Location:index.php");
exit();
}catch(PDOException $e){
die('エラー：'.$e->getMessage());
}

	

	

?>