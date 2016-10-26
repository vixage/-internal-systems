<?php
include 'includes.php';

// 1ページに表示されるコメントの数
  $num = 10;


//DB接続
$dbh=mysql_connect ("localhost", "root", "1125") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("vixage");



//スレッドIDを取得
$id = $_GET['id'];

//スレッドを取得
$sql_thread = "SELECT * FROM threads where id = " . $id;
$result_thread = mysql_query($sql_thread);
$thread = mysql_fetch_array($result_thread);

//レスを取得
$sql_res = "SELECT * FROM responses where thread_id = " . $id . " order by created_at desc";
$result_res = mysql_query($sql_res);
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $thread['title'];?></title>
<link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class ="size">

<h1>タイトル:<?php echo $thread['title'];?></h1>
<p>名前:<?php echo $thread['name'];?></p>
<p>作成日時:<?php echo $thread['created_at'];?></p>
<p><?php echo $thread['body'];?></p>
<form action="delete2.php" method="post">
      <input type="hidden" name="id" value="<?php echo $id?>">
      削除パスワード：<input type="password" name="pass">
      <input type="submit" value="削除">
    </form>
    <hr>
<div>

<h2>書き込み</h2>
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
</div>


<?php while($res = mysql_fetch_array($result_res)):?>
  <hr />
  <p>ID:<?php echo $res['id'];?></p>
  <p><?php echo $res['body'];?></p>
  <p>名前:<?php echo $res['name'];?></p>
  <p>投稿日時:<?php echo $res['created_at'];?></p>
  <form action="delete.php" method="post">
      <input type="hidden" name="id" value="<?php echo $id?>">
      削除パスワード：<input type="password" name="pass">
      <input type="submit" value="削除">
    </form>
<?php endwhile;


?>
<p><a href="index.php">トップに戻る</a></p>


<footer>        
        <p>(C)2016 VIXAGE created by Fumitaka Ochiai</p>
        </footer>
        </div>
</body>
</html>