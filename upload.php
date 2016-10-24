<?php
$msg = null;


$dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
$user= 'root';
$password = '1125';

	

try {
            $db = new PDO($dsn, $user, $password);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
			//プリペアドステートメント作成
            $stmt = $db->prepare("
            INSERT INTO threads (img)
            VALUES(:img)");

            $stmt->bindParam(':img',$_FILES['image'],PDO::PARAM_STR);

            $stmt->execute();
            exit();
            
        }catch(PDOException $e){
		$msg = 'アップロード失敗';
	}
	
?>






<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title></title>
            <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        <div class="size">
        <h1>画像アップロード</h1>
        <?php
        if($msg){
        	echo '<p>'.$msg.'</p>';
        }
        ?>
        <form enctype="multipart/form-data" action="upload.php" method="POST">
            <div class="border2">
                <input type="file" name="image">
                <input type="submit" value="アップロード">

                            </div>
        </form>
        <footer>        
        <p>(C)2016 VIXAGE created by Fumitaka Ochiai</p>
        </footer>
        </div>
    </body>
</html>