<?php

function Trip($str) {
 
    //stripslashes（バックスラッシュ（\）を取り除く）
    $str = stripslashes($str);
    
    $str = mb_convert_encoding($str, "SJIS", "UTF-8,EUC-JP,JIS,ASCII"); 
    
    //★を☆に置換
    $str = str_replace("★", "☆", $str);
    //◆を◇に置換
    $str = str_replace("◆", "◇", $str); 
    
    // したらばとか？
    //$str = str_replace(array('"', '<', '>'), array("&quot;", "&lt;", "&gt;"), $str);
 
    if (($trips = strpos($str, "#")) !== false) {
    
        $kotehan = mb_substr($str, 0, $trips);
        $tripkey = mb_substr($str, $trips + 1);
        $salt = mb_substr($tripkey.'H.', 1, 2);
        
        $patterns = array(':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`');
        $match = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'a', 'b',  'c', 'd', 'e', 'f');
        $salt = str_replace($patterns, $match, $salt);
        
        $pattern = '/[\x00-\x20\x7B-\xFF]/';
        $salt = preg_replace($pattern, ".", $salt);
        
        $trip = crypt($tripkey, $salt);
        
        $trip = substr($trip, -10);
        $kotehan = mb_convert_encoding($kotehan, "UTF-8", "SJIS"); 
        $trip = mb_convert_encoding($trip, "UTF-8", "SJIS"); 
        $trip = '◆'.$trip;
        
        return array($kotehan, $trip);
        
    }
    
    $str = mb_convert_encoding($str, "UTF-8", "SJIS");
    
    return array($str, "");
}

?>


<?php
include 'common/checkLogin.php';
require_once 'common/DbManager.php';

$id2 = $_POST['id'];
$ip = $_SERVER["REMOTE_ADDR"];

$body = $_POST['body'];
if (empty($_POST['name'])) {
    $name = "とあるAGE社員";
}else{
    $name = implode(Trip($_POST['name']));
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


