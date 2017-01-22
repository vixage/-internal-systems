<?php
include './db/connectDB.php';
//スレッドIDを取得

$id = $_GET['id'];

//スレッドを取得
$db = new DB();
$dbdb =$db -> dbConnect();
$stmt = $dbdb -> prepare(
  "SELECT * FROM article where ARTICLE_ID = $id"
  );

$result_res = $dbdb->prepare(
  "SELECT * FROM response where ARTICLE_ID = $id
  ");
    // クエリの実行
$stmt->execute();
    // クエリの実行
$result_res->execute();

//コメント作成ボタン押下時
if(isset($_POST['resNew'])){
  //CSRF対策
  if($_POST['token'] == hash("sha256",session_id())){
    //エラーメッセージ初期化
    $errorMessage = NULL;
    //タイトル欄の文字数が51文字以上
    if(mb_strlen($_POST['title']) >= 51){
    //エラー変数に｢タイトル欄は50文字以内で入力してください。｣を格納
      $errorMessage .="「タイトル欄は50文字以内で入力してください。」<br>";
    }
    //本文入力がある
    if(empty($_POST['text'])){
      //エラーメッセージに｢本文を入力してください。｣を格納(input_確認押下時)
      $errorMessage .="「本文を入力してください。」<br>";
    }
    //エラーメッセージがない場合
    if(empty($errorMessage)){
      
      $db = new DB();
      $dbdb =$db -> dbConnect();
      //プリペアドステートメント作成
      $stmt = $dbdb->prepare("
        INSERT INTO response(NAME,TITLE,TEXT,CREATE_DATE)
       VALUES(:name,:title,:text,now())"
       );

            //パラメーターを割り当て
      $stmt->bindParam(':name',$_SESSION['name'],PDO::PARAM_STR);
      $stmt->bindParam(':title',$_SESSION['title'],PDO::PARAM_STR);
      $stmt->bindParam(':text',$_SESSION['text'],PDO::PARAM_STR);

//クエリの実行
      $stmt->execute();

      header("Location:index.php");
      exit();
    }
  }
}

?>

<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>スレッド掲示板</title>
  <link rel="stylesheet" href="./css/navi.css">
  <link rel="stylesheet" href="./css/table.css">
  <link rel="stylesheet" href="./css/form.css">
  <link rel="stylesheet" href="./css/style.css">

</head>
<body>
  <div id ="size">
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/menu.php'); ?>
    <?php 
    while ($row = $stmt->fetch()){
      ?>
      <p>タイトル:<?php echo $row['TITLE'];?></p>
      <p>名前:<?php echo $row['NAME'];?>作成日時:<?php echo $row['CREATE_DATE'];?></p>
      <p><?php echo $row['TEXT'];?></p>
      <?php 
    }
    ?>
    <hr>
    <h1>書き込み</h1>
    <form method="post">
      <table>
        <tr>
          <th>名前</th>
          <td><input type="text" name="name" value="" maxlength="20"/></td>
        </tr>
        <tr>
          <th>タイトル</th>
          <td><input type="text" name="title" value="" maxlength="20"/></td>
        </tr>
        <tr>
          <th>内容</th>
          <td><textarea name="text" maxlength="1000" ></textarea></td>
        </tr>
        <tr>
          <td>
            
            <input type="hidden" name="token" value="<?php echo hash("sha256",session_id());?>">
          </td>
          <td>
            <input type="submit" name="resNew" value="投稿" /></td>

          </tr>
        </table>
      </form>
    <div class="clear"></div>
    <hr>

    <?php 
    while ($res = $result_res->fetch()){?>

    <p>
      名前:<?php echo $res['NAME'];?>投稿日時:<?php echo $res['CREATE_DATE'];?>
    </p>
    <p><?php echo $res['TEXT'];?></p>
    <?php 
  }
  ?>

  <div class="clear"></div>
  <?php include('./common/footer.php'); ?>

</body>
</html>