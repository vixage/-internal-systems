<!DOCTYPE html>
<html>
<title>掲示板</title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="./css/register.css">
<link rel="stylesheet" href="./css/bootstrap.css">
<script src="./js/bootstrap.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://www.google.com/recaptcha/api.js?hl=jp"></script>
<?php
// セッションスタート
session_start ();
// DB接続class読込
include './db/connectDB.php';
// recaptcha読込
require_once '../api/recaptcha/autoload.php';
// ログイン判断
if (isset ( $_SESSION ['USER_ID'] )) {
	header ( 'Location: index.php' );
	exit ();
}
$secret = "6Ld86w4UAAAAAPjsT6CfD1pDbaym2EsJFYxDu2YN";

// 登録ボタン押下時
if ($_POST ["register"]) {
	// CSRF対策
	if ($_POST ['token'] == hash ( "sha256", session_id () )) {
		if (isset ( $_POST ['g-recaptcha-response'] )) {
			$recaptcha = new \ReCaptcha\ReCaptcha ( $secret );
			// 確認驗證碼與 IP
			$resp = $recaptcha->verify ( $_POST ['g-recaptcha-response'], $_SERVER ['REMOTE_ADDR'] );
			// 確認正確
			if ($resp->isSuccess ()) {
				$errorMessage = NULL;
			} else {
				$errorMessage = "reCAPTCHAコード確認失敗<br>";
			}
		}
		$errorMessage .= (empty ( $_POST ['ruleCheck'] )) ? "同意してください<br>" : "";
		$errorMessage .= (empty ( $_POST ['userID'] )) ? "アカウントが入力されていません<br>" : "";
		$errorMessage .= (! preg_match ( "/^[a-zA-Z0-9]*$/", $_POST ['userID'] )) ? "アカウントを再一度入力してください<br>" : "";
		$errorMessage .= (mb_strlen ( $_POST ['userID'] ) > 10) ? "アカウントは10文字以内で入力してください。<br>" : "";
		$_SESSION ['userID'] = $_POST ['userID'];

		$errorMessage .= (empty ( $_POST ['userPW'] )) ? "パスワードが入力されていません<br>" : "";

		$errorMessage .= (! preg_match ( "/^[a-zA-Z0-9]*$/", $_POST ['userPW'] )) ? "パスワードを再一度入力してください<br>" : "";

		$errorMessage .= (mb_strlen ( $_POST ['userPW'] ) > 8) ? "パスワードは8文字以内で入力してください。<br>" : "";
		$errorMessage .= ($_POST ['userPW'] != $_POST ['userPWC']) ? "パスワードとパスワードチェックは一致ではない。<br>" : "";
		$_SESSION ['userPW'] = $_POST ['userPW'];

		$errorMessage .= (empty ( $_POST ['userEmail'] )) ? "Eメールアドレスが入力されていません<br>" : "";
		$errorMessage .= (! preg_match ( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST ['userEmail'] ) && ! empty ( $_POST ['userEmail'] )) ? "Eメールアドレスを再一度入力してください<br>" : "";
		$errorMessage .= (mb_strlen ( $_POST ['userEmail'] ) > 30) ? "Eメールアドレスは30文字以内で入力してください。<br>" : "";
		$_SESSION ['userEmail'] = $_POST ['userEmail'];

		$errorMessage .= (empty ( $_POST ['firstName'] )) ? "苗字が入力されていません<br>" : "";
		$errorMessage .= (mb_strlen ( $_POST ['firstName'] ) > 10) ? "苗字は10文字以内で入力してください。<br>" : "";
		$_SESSION ['firstName'] = $_POST ['firstName'];

		$errorMessage .= (empty ( $_POST ['lastName'] )) ? "名前が入力されていません<br>" : "";
		$errorMessage .= (mb_strlen ( $_POST ['lastName'] ) > 20) ? "名前は20文字以内で入力してください。<br>" : "";
		$_SESSION ['lastName'] = $_POST ['lastName'];

		$name = $_POST ['firstName'] . " " . $_POST ['lastName'];
		$_SESSION ['sex'] = $_POST ['sex'];
		$db = new DB ();
		$dbdb = $db->dbConnect ();

		$stmt = $dbdb->prepare ( "select USER_ID from ACCOUNT where USER_ID =:USER_ID" );
		$stmt->bindParam ( ':USER_ID', $_POST ['userID'], PDO::PARAM_STR );
		$stmt->execute ();

		// もしデータベースに同じアカウントがあった場合
		if ($row = $stmt->fetch ()) {
			$errorMessage .= "このアカウントすでに登録済みです";
		}

		// エラーメッセージがある場合
		if (! empty ( $errorMessage )) {
			session_destroy;
		} else {
			include_once "./sendMail.php";
			if (! $mail->Send ()) {
				$errorMessage .= "このメールアドレスは無效なメールアドレスです";
			} else {
				$db = new DB ();
				$dbdb = $db->dbConnect ();
				$stmt = $dbdb->prepare ( "INSERT INTO ACCOUNT(USER_ID,USER_PASS,USER_NAME,EMAIL,SEX)
							VALUES(:ID,:PASSWORD,:NAME,:EMAIL,:SEX)" );
				$stmt->bindParam ( ':ID', $_SESSION ['userID'], PDO::PARAM_STR );
				$stmt->bindParam ( ':PASSWORD', $_SESSION ['userPW'], PDO::PARAM_STR );
				$stmt->bindParam ( ':NAME', $name, PDO::PARAM_STR );
				$stmt->bindParam ( ':EMAIL', $_SESSION ['userEmail'], PDO::PARAM_STR );
				$stmt->bindParam ( ':SEX', $_SESSION ['sex'], PDO::PARAM_STR );
				$stmt->execute ();
				header ( 'Location: index.php' );
				exit ();
			}
		}
	} 	// フォームのトークンとサーバーのトークンが一致しなかった場合
	else {
		session_destroy;
		header ( 'Location: index.php' );
		exit ();
	}
}
?>
	</head>
<body>
	<div>
		<fieldset class="scheduler-border">
			<div style="background-color: #f1f1f1; border-radius: 10px;">
				<br>

				<h1 style="color: green;">掲示板</h1>
				<font style="color: green;"> もしくはユーザー情報を登録。</font><br> <br> <font
					color="red"> <!-- エラーメッセージの表示 -->
				<?php
				echo isset ( $errorMessage ) ? $errorMessage : "";
				?>
			</font><br> <font style="color: brown;"><b> 登録説明</b></font>
				<form method="post">
					<table border="0">
						<tr>
							<td colspan="2">
								<div>
									<input name="ruleCheck" type="checkbox" value="checked"
										required><font color="red">*以下の内容を同意する</font>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div>
									<p>
										<textarea name="text" id="introduction" cols="45" rows="8"
											placeholder="本文內容を書いてください(文字数100文字以下)" class="form-control"
											readonly><?php require './registRule.php';?></textarea>
									</p>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="input-group input-group-lg">
									<input type="text" class="form-control"
										placeholder="<?php echo htmlspecialchars("アカウント(半角英数字、文字数10字以下)");?>"
										aria-describedby="basic-addon1" name="userID"
										style="width: 350px;"
										value="<?php echo htmlspecialchars($_SESSION['userID']);?>"
										required>
								</div>
							</td>
							<td>
								<div class="input-group input-group-lg">
									<input type="password" class="form-control"
										placeholder="<?php echo htmlspecialchars("パスワード(半角英数字、文字数8文字以下)");?>"
										aria-describedby="basic-addon1" name="userPW"
										style="width: 350px;" required>
								</div>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<div class="input-group input-group-lg">
									<input type="password" class="form-control"
										placeholder="<?php echo htmlspecialchars("パスワード再入力");?>"
										aria-describedby="basic-addon1" name="userPWC"
										style="width: 350px;" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="input-group input-group-lg">
									<input type="text" class="form-control"
										placeholder="<?php echo htmlspecialchars("苗字(文字数10文字以下)");?>"
										aria-describedby="basic-addon1" name="firstName"
										style="width: 350px;"
										value="<?php echo htmlspecialchars($_SESSION['firstName']);?>"
										required>
								</div>
							</td>
							<td>
								<div class="input-group input-group-lg">
									<input type="text" class="form-control"
										placeholder="<?php echo htmlspecialchars("名前(文字数20文字以下)");?>"
										aria-describedby="basic-addon1" name="lastName"
										style="width: 350px;"
										value="<?php echo htmlspecialchars($_SESSION['lastName']);?>"
										required>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2";>
								<div class="input-group input-group-lg">
									<input type="email" class="form-control"
										placeholder="<?php echo htmlspecialchars("Eメールアドレス(文字数30文字以下)");?>"
										aria-describedby="basic-addon1" name="userEmail"
										style="width: 710px"
										value="<?php echo htmlspecialchars($_SESSION['userEmail']);?>"
										required>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div>
									<br> <input type="radio" name="sex" id="sexMale"
										autocomplete="off" value="1" checked><label for="sexMale"><span
										style="font-size: x-large;">男</span></label> <input
										type="radio" name="sex" id="sexFemale" autocomplete="off"
										value="0"><label for="sexFemale"><span
										style="font-size: x-large;">女</span></label>
								</div>
							</td>
							<td>&nbsp;&nbsp;
								<div class="g-recaptcha" style="algin: center;"
									data-sitekey="6Ld86w4UAAAAAIj4oFXfbUD7_Up6Mlz6nY73Xm8P"></div>
							</td>
						</tr>
						<tr>
							<td><input class="btn btn-primary btn-lg btn-block" type="submit"
								name="register" value="登録"> <input type="hidden" name="token"
								value="<?php echo hash("sha256",session_id());?>"></td>
							<td></td>
						</tr>
					</table>
				</form>
			</div>

	</div>
	</fieldset>
</body>
</html>