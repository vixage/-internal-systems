<?php
include 'common/checkLogin.php';
$number = 20;

$ip = $_SERVER["REMOTE_ADDR"];
//DB接続
$dbh=mysql_connect ("localhost", "root", "1125") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("vixage");
$page = 0;
if(isset($_GET['page']) && $_GET['page'] > 0){
  $page = intval($_GET['page']) -1;
}
//スレッドを取得
$sql = "SELECT * FROM threads order by created_at desc";
$result = mysql_query($sql);
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>ヴィックスグループ専用掲示板</title>
  
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/menu.css">
<link rel="stylesheet" href="css/threads.css">
  

</head>
<body>



<div id ="wrapper">

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/global_menu.php'); ?>


<div class="boxsize">
<h2 class="block1">この掲示板について</h2>

  <p>この掲示板はVixAgeの社員専用掲示板です。<br>
  会社に関することはもちろん,、趣味や遊びのことなど使用用途は各自にお任せいたします！<br>
<h2 class="block2">注意事項</h3>
<p>投稿内容が管理されず内容が荒れるスレッドは管理人が削除します。<br>
内容が管理されないスレッドとは、
<br>この<a href="rule.php">ガイドライン</a>に反する内容を含むものです。<br>
  頑張って作ったので良ければ皆さん使ってくださいー！ヾ(。゜▽゜)ﾉ:;:.,*;”</p>

  </div>

  
  <div class="threadwaku">
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
<th>画像</th>
<td><input type="file" name="image"></td>
</tr>
  
  
 <!--<tr>
    <th>削除パスワート゛(数字4桁)：</th>
    <td><input type="text" name="pass" maxlength="4"></td>
  </tr>-->
  <tr>
    <td><input type="hidden" name="type" value="create" /></td>
    <td><input type="hidden" name="type" value="$id" /></td>

    
    
  </tr>
  <tr>
  <td><input type="submit" name="submit" value="作成" /></td>
  </tr>
</table>
</form>
</div>
  
  <div class="box3"></div>
<table class="thread_style" width="950px">
<tbody>
<tr>
<th>作成日時</th>
<th>スレッド名</th>
<th>作成者</th>

</tr>
<?php while($thread = mysql_fetch_array($result)):?>
  <tr>
  <td><?php echo $thread['created_at'];?></td>
  <td><a href="thread.php?id=<?php echo $thread['id'];?>"><?php echo $thread['title'];?></a></td>
  <td><?php echo $thread['name'];?></td>
  
  
  
  </tr>
<?php endwhile;?>

</tbody>
</table>


<hr>
<?php
function paging($limit,$page,$disp=5){
    //$dispはページ番号の表示数
    $page = empty($_GET["page"])? 1:$_GET["page"];
     
    $next = $page+1;//前のページ番号
    $prev = $page-1;//次のページ番号
     
    if($page != 1 ) {//最初のページ以外で「前へ」を表示
         print '<a href="?page='.$prev.'">&laquo; 前へ</a>';
    }
    if($page < $limit){//最後のページ以外で「次へ」を表示
        print '<a href="?page='.$next.'">次へ &raquo;</a>';
    }
     
    /*確認用
    print "current:".$page."<br>";
    print "next:".$next."<br>";
    print "prev:".$prev."<br>";*/
 
}
 
$limit = 10;//最大ページ数
$page = empty($_GET["page"])? 1:$_GET["page"];//ページ番号
 
paging($limit, $page);
?>

<?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'); ?>
</body>
</html>