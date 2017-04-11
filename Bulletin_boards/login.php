<!DOCTYPE html>
<html>
<title>掲示板</title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="./css/login.css">
<link rel="stylesheet" href="./css/bootstrap.css">
<script src="./js/bootstrap.js">
		</script>
		<?php
		// インクルード(DB接続class読込)
		include './db/DbManager.php';
		
		session_start();
		if(isset($_SESSION['USERID'])){
		header('Location:index.php');
		exit();
		}
		// ログイン押下時
		if (isset($_POST['Login'])) {

			$errorMessage = NULL;
			if (empty ( $_POST ['userID'] )) {
				// エラー変数に"「ID」"を追加
				$errorMessage .= "「ID」";
			}
			// パスワード欄が空
			if (empty ( $_POST ['password'] )) {
				// エラー変数に"「パスワード」"を追加
				$errorMessage .= "「パスワード」";
			}
			// エラー変数が空である
			if (empty ( $errorMessage )) {
				$db = new DB ();
				$dbdb = $db->connect ();
				$stmt = $dbdb->prepare ("select * from account where USER_ID =:USER_ID AND USER_PASS =:USER_PASS");
				$stmt->bindParam(':USER_ID', $_POST['userID'],PDO::PARAM_STR );
				$stmt->bindParam ( ':USER_PASS', $_POST['password'],PDO::PARAM_STR );
				$stmt->execute ();

				// ID・パスワードが一致した場合の処理
				//条件判断未実装
				if(1==1){
				while($row = $stmt->fetch()){
				// DBからユーザ情報を取得USER_ID,USER_NAME,EMAILをセッションに格納
				$_SESSION['USERID'] =$row['USER_ID'];
			  }
			  header ('Location:index.php');
				exit ();
				}else {
					$errorMessage .= "「ID」「パスワード」が存在しません";
				}
			} else {
				$errorMessage .= "が入力されていません";
			}}?>
		 
	</head>
<body>
	<div>
		<fieldset class="scheduler-border">
			<div style="background-color: #CCDDFF; border-radius: 10px;">
				<br>

				<h1 style="color: green;">掲示板</h1>
				<font style="color: green;"> あなたのIDとパスワードを入力してログインしてください。</font><br>
				<br> </font> <font color="red">
				<!-- エラーメッセージの表示-->
				<?php
				if(isset($errorMessage)){echo $errorMessage;};
				?>


			<form method="post">
						<table border="0" style="background-color: #CCDDFF;">
							<tr>
								<td><br></td>
							</tr>
							<tr>
								<td>
									<div class="input-group input-group-lg">
										<span class="input-group-addon" id="basic-addon1"
											style="width: 150px;"><font style="color: black;">ID</font></span>
										<input type="text" class="form-control" placeholder="アカウント"
											aria-describedby="basic-addon1" name="userID"
											style="width: 250px;">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="input-group input-group-lg">
										<span class="input-group-addon" id="basic-addon1"
											style="width: 150px;"><font style="color: black;">パスワード</font></span>
										<input type="password" class="form-control"
											placeholder="パスワード" aria-describedby="basic-addon1"
											name="password" style="width: 250px;">
									</div>
								</td>
							</tr>
							<tr>
								<td><br></td>
							</tr>
						</table>
						<div>
							<input class="btn btn-success btn-lg btn-block" type="submit"
								name="Login" value="ログイン">
						</div>
					</form>
					<p>ログインがまだの方は<a href="register.php">こちら</a></p>

			</div>

	</div>
	</fieldset>
</body>
</html>