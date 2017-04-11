<?php
include './common/checkLogin.php';
include './db/connectDB.php';


// 確認ボタン押下時
if (isset($_POST ['confirm'])) {
	// CSRF対策
  if ($_POST ['token'] == hash ( "sha256", session_id () )) {
   $db = new DB();
   $dbdb =$db -> dbConnect();
			//プリペアドステートメント作成
   $stmt = $dbdb->prepare("
    INSERT INTO ARTICLE(NAME,TITLE,TEXT,CREATE_DATE)
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
?>


<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>ヴィックスグループ専用掲示板</title>
  
  <link rel="stylesheet" href="./css/navi.css">
  <link rel="stylesheet" href="./css/table.css">
  <link rel="stylesheet" href="./css/form.css">
  <link rel="stylesheet" href="./css/style.css">

</head>
<body>
  <div id ="size">
  	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/menu.php'); ?>
    <h2>投稿内容は以下の内容でよろしいでしょうか？</h2>

    <div id="form">
      <form method="post">
        <table class="type03">
          <tr>
           <th>名前</th>
           <td><?php echo $_SESSION['name'];?></td>
         </tr>

         <tr>
           <th>タイトル</th>
           <td><?php echo $_SESSION['title'];?></td>
         </tr>
         <tr>
           <th>本文</th>
           <td><?php echo $_SESSION['text'];?></td>
         </tr>
       </table>
       <input type="hidden" name="token" value="<?php echo hash("sha256",session_id()); ?>" />
       <p><input type="submit" name="confirm"></p>
     </form>
   </div>

 </div>
 <div class="clear"></div>
 <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'); ?>
</body>
</html>