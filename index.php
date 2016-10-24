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
  <link rel="stylesheet" href="css/sign.css">

</head>
<body>
<div class ="size">
<div id="box">
<div id="box1">
<img src="image/Desktop.png">
</div>
<div id="box2">
  <h1>AGEチャンネル（Aちゃん）</h1>
  </div>
  </div>
  
  <!--<img src="image/AGEMANALL.png" width="950px">-->

  

  
  
<h2><a href="thread_new.php">スレッド作成</a></h2>
<table class="border">

<?php while($thread = mysql_fetch_array($result)):?>
	<tr><td width="400px"><a href="thread.php?id=<?php echo $thread['id'];?>"><?php echo $thread['title'];?></a></td>
  <td width="130px">作成者：<?php echo $thread['name'];?></td>
  <td width="220px"><?php echo $thread['created_at'];?></td>
  
  </tr>
<?php endwhile;?>

</table>
<div id ="top">
<form method="post" action="logout.php">
    
    <input type="submit" name="submit" value="ログアウト" />
</form></div>
<p><a href="index.php">トップページに戻る</a></p>


<footer>        
        <p>(C)2016 VIXAGE created by Fumitaka Ochiai</p>
        </footer>
</body>
</html>
