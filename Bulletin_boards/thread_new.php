<?php
include 'includes.php';
//$id = $_GET['id'];
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>スレッド作成画面</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class ="size">
<h1>スレッド作成画面</h1>
<form  action="thread_new2.php" method="post">
<table>
	<tr>
		<th>名前</th>
		<td><input type="text" name="name" value="<?php echo $_COOKIE['name'] ?>" maxlength="10" /></td>
	</tr>
	<tr>
		<th>タイトル</th>
		<td><input type="text" name="title" maxlength="50" /></td>
	</tr>
	<tr>
		<th>内容</th>
		<td><textarea name="body" style="height:170px" maxlength="1000" ></textarea></td>
	</tr>
	<tr>
		<th>削除パスワート゛(数字4桁)：</th>
		<td><input type="text" name="pass" maxlength="4"></td>
	</tr>
	<tr>
		<td><input type="hidden" name="type" value="create" /></td>
		<td><input type="hidden" name="type" value="$id" /></td>
		<td><input type="submit" name="submit" value="作成" /></td>
	</tr>
</table>
</form>
<p><a href="index.php">トップに戻る</a></p>
<footer>        
        <p>(C)2016 VIXAGE created by Fumitaka Ochiai</p>
        </footer>
</div>
</body>
</html>