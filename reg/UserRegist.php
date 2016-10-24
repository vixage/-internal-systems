<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8' />
<title>ユーザー登録</title>
</head>
<body>
<h2>ユーザー登録</h2>
<form method="POST" action="Register.php">
<p>
  ユーザーID(20文字以内)：<br />
  <input type="text" name="id" size="20" maxlength="20" />
</p><p>
  氏名：<br />
  <input type="text" name="name" size="20" maxlength="20" />
</p><p>
  郵便番号(ハイフン含む)：<br />
  <input type="text" name="zipcode" size="6" maxlength="8" />
</p><p>
  住所：<br />
  <input type="text" name="address" size="60" maxlength="50" />
</p><p>
  電話番号(ハイフン含む)：<br />
  <input type="text" name="tel" size="20" maxlength="20" />
</p><p>
  メールアドレス：<br />
  <input type="text" name="mail" size="20" maxlength="30" />
</p><p>
  <input type="submit" value="登録" />
</p>
</form>
</body>
</html>