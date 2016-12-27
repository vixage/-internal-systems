<?php
session_start();
//include './common/checkLogin.php';
include './db/DbManager.php';

// 確認ボタン押下時
if (isset($_POST ['confirm'])) {
	// CSRF対策
  if ($_POST ['token'] == hash ( "sha256", session_id () )) {
	$db = new DB();
	$dbdb = $db->connect();
	$ip = $_SERVER["REMOTE_ADDR"];
	
			//プリペアドステートメント作成
	$stmt = $dbdb->prepare("
		INSERT INTO threads (name,title,body,created_at,ipadress)
		VALUES(:name,:title,:body,now(),:ip)"
		);

            //パラメーターを割り当て
	$stmt->bindParam(':name',$_SESSION['name'],PDO::PARAM_STR);
	$stmt->bindParam(':title',$_SESSION['title'],PDO::PARAM_STR);
	$stmt->bindParam(':body',$_SESSION['body'],PDO::PARAM_STR);
	$stmt->bindParam(':ip',$ip,PDO::PARAM_STR);

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
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style1.css">

</head>
<body>
  <div id ="wrapper">
  	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/global_menu.php'); ?>
    <h2>投稿内容は以下の内容でよろしいでしょうか？</h2>


		<form method="post">
          <table width="950px" style="text-align: center;">
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
					<td><?php echo $_SESSION['body'];?></td>
				</tr>
			</table>
			</div>
			<input type="hidden" name="token" value="<?php echo hash("sha256",session_id()); ?>" />
			<input type="submit" name="confirm" class="btn btn-default">
			
		</form>



<?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'); ?>
</body>
</html>