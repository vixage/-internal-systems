<?php
include 'includes.php';

$id = $_GET['id'];
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>レス投稿画面</title>
<link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class ="size">
<form method="post" action="res_new2.php">
<table>
	
	<tr>
		<th>名前</th>
		<td><input type="text" name="name" value="<?php echo $_COOKIE['name'] ?>" maxlength="20"/></td>
	</tr>
	<tr>
		<th>内容</th>
		
		<td><textarea name="body" maxlength="1000" ></textarea></td>
	</tr>
	<tr>
		<td>
			<input type="hidden" name="id" value="<?php echo $id;?>" />
			<input type="hidden" name="type" value="create" />
		</td>
		<tr>
		<th>削除<br>パスワート゛<br>(数字4桁)</th>
		<td><input type="text" name="pass" maxlength="4" ></td>
	</tr>
		
		<td>
			<input type="submit" name="submit" value="投稿" /></td>
		
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