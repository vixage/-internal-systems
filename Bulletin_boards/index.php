<?php
include 'common/checkLogin.php';
include 'common/DbManager.php';
$num = 10;
$ip = $_SERVER["REMOTE_ADDR"];
//DB接続

  //ページ数が指定されているとき
$page = 0;
if (isset($_GET['page']) && $_GET['page'] > 0){
  $page = intval($_GET['page']) -1;
}

try{
  $db = connect();
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // プリペアドステートメントを作成
  $sql = $db->prepare(
    "SELECT * FROM threads order by created_at DESC LIMIT :page, :num"

    );
    // パラメータを割り当て
  $page = $page * $num;
  $sql->bindParam(':page', $page, PDO::PARAM_INT);
  $sql->bindParam(':num', $num, PDO::PARAM_INT);

    // クエリの実行
  $sql->execute();
} catch(PDOException $e){
  echo "エラー：" . $e->getMessage();
}



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
    <?php 
    while ($row = $sql->fetch()):?>
    <tr>
      <td><?php echo $row['created_at'];?></td>
      <td><a href="thread.php?id=<?php echo $row['id'];?>"><?php echo $row['title'];?></a></td>
      <td><?php echo $row['name'];?></td>



    </tr>
  <?php endwhile;?>
</tbody>
</table>




<?php

// ページ数の表示
try {
    // プリペアドステートメント作成
  $sql = $db->prepare("SELECT COUNT(*) FROM threads");
    // クエリの実行
  $sql->execute();
} catch (PDOException $e){
  echo "エラー：" . $e->getMessage();
}

  // コメントの件数を取得
$comments = $sql->fetchColumn();
  // ページ数を計算
$max_page = ceil($comments / $num);
echo '<p>';
for ($i = 1; $i <= $max_page; $i++){
  echo '<a href="index.php?page=' . $i . '">' . $i . '</a>&nbsp;';
}
echo '</p>';
?>



<?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'); ?>
</body>
</html>