<?php
include 'common/checkLogin.php';
// 1ページに表示されるコメントの数
  $num = 10;
  /*
  
  */
  //仮IPアドレス$ip = "1234";
//DB接続
$dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
  $user = 'root';
  $password = '1125';
//スレッドIDを取得
$id = 1;
//スレッドを取得
try{
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // プリペアドステートメントを作成
    $thread = $db->prepare(
      "SELECT * FROM threads where id = " . $id
      );

    $res = $db->prepare(
      "SELECT * FROM responses where thread_id = " . $id . " order by created_at desc"
      );
    
    
    // クエリの実行
    $thread->execute();
    $res->execute();
  } catch(PDOException $e){
    echo "エラー：" . $e->getMessage();
  }

?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $thread['title'];?></title>
<link rel="stylesheet" href="css/style.css">
 <link rel="stylesheet" href="css/menu.css">

</head>
<body>

</body>
</html>