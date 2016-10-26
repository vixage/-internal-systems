<?php
include 'includes.php';


//DB接続
$dbh=mysql_connect ("localhost", "root", "1125") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("vixage");


//スレッドを取得
$sql = "SELECT * FROM threads order by created_at desc";
$result = mysql_query($sql);
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>ヴィックスグループ専用掲示板</title>
  <link rel="stylesheet" href="css/style.css">
  

</head>
<body>


<div class ="size">
  <h1>AGEチャンネル（Aちゃん）</h1>
  <div id="logout">
  <form method="post" action="logout.php">
    
    <input type="submit" name="submit" value="ログアウト" />
</form>
</div>
  <div class="nav">

<ul class="nl clearFix">
<li><a href="#">メニュー項目1</a></li>
<li><a href="#">メニュー項目2</a></li>
<li><a href="#">メニュー項目3</a></li>
<li><a href="#">メニュー項目4</a></li>
<li><a href="#">メニュー項目5</a></li>
</ul>

</div>
<h2>この掲示板について</h2>
  <p>この掲示板はVixAgeの社員専用の掲示板です。
  仕事についてや会社についてわからないことなどはもちろん、
  趣味や遊びのことなど用途は各自にお任せいたします。
  </p>
  <p>頑張って作ったので良ければ皆さん使ってくださいー！</p>

  

<table class="border"  width="950px">

<?php while($thread = mysql_fetch_array($result)):?>
	<tr><td><a href="thread.php?id=<?php echo $thread['id'];?>"><?php echo $thread['title'];?></a></td>
  <td>作成者：<?php echo $thread['name'];?></td>
  <td><?php echo $thread['created_at'];?></td>
  
  </tr>
<?php endwhile;?>

</table>
<div id ="top">
<h2>スレッド作成</h2>


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
</div>


<p><a href="index.php">トップページに戻る</a></p>


<footer>        
        <p>(C)2016 VIXAGE created by Fumitaka Ochiai</p>
        </footer>
</body>
</html>
