<?php
include 'common/checkLogin.php';
require_once 'common/DbManager.php';

$id2 = $_POST['id'];
$ip = $_SERVER["REMOTE_ADDR"];

$body = $_POST['body'];
if (empty($_POST['name'])) {
    $name = "とあるAGE社員";
}else{
    $name = $_POST['name'];
}



//$pass = $_POST['pass'];

$body = nl2br($body);
	
           try {
            $db = connect();
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            
			//プリペアドステートメント作成
            $stmt = $db->prepare("
            INSERT INTO responses (thread_id,body,name,created_at,ipadress)
            VALUES(:thread_id,:body,:name,now(),:ip)"
            );

            //パラメーターを割り当て

$stmt->bindParam(':thread_id',$id2,PDO::PARAM_STR);
$stmt->bindParam(':body',$body,PDO::PARAM_STR);
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->bindParam(':ip',$ip,PDO::PARAM_STR);
//$stmt->bindParam(':pass',$pass,PDO::PARAM_STR);



//クエリの実行
$stmt->execute();

header("Location:thread.php?id=$id2");
exit();
}catch(PDOException $e){
die('エラー：'.$e->getMessage());
}


