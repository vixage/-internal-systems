<?php
//include 'common/checkLogin.php';
include 'db/DbManager.php';
// 1ページに表示されるコメントの数
$num = 10;
//スレッドIDを取得
$id = $_GET['id'];
/*ページング機能
$page2 = 0;
  if (isset($_GET['page2']) && $_GET['page2'] > 0){
    $page2 = intval($_GET['page2']) -1;
  }*/

//スレッドを取得

  try{
    $db = new DB ();
    $dbdb = $db->connect();
    // プリペアドステートメントを作成
    $thread = $dbdb->prepare(
      "SELECT * FROM threads where id = " . $id
      );

    $result_res = $dbdb->prepare(
      "SELECT * FROM responses where thread_id = $id 
      
      ");
    /*

    $page2 = $page2 * $num;
    $result_res->bindParam(':page2',$page2,PDO::PARAM_INT);
    $result_res->bindParam(':num',$num,PDO::PARAM_INT);
    */
    // クエリの実行
    $thread->execute();
    // クエリの実行
    $result_res->execute();
    
  } catch(PDOException $e){
    echo "エラー：" . $e->getMessage();
  }

  


  ?>

  <html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>スレッド掲示板</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">

  </head>
  <body>
    <div id ="wrapper">
      <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/global_menu.php'); ?>


      <div class="boxsize">
        <?php 
        while ($row = $thread->fetch()):?>
        <h3 class="block5">タイトル:<?php echo $row['title'];?></h3>
        <p>名前:<?php echo $row['name'];?>作成日時:<?php echo $row['created_at'];?>IPアドレス:<?php echo $row['ipadress'];?></p>
        <p><?php echo $row['body'];?></p>




        







        
        <p><?php echo $row['image'];?></p>
<!--<form action="delete2.php" method="post">
      <input type="hidden" name="id" value="<?php echo $id?>">
      削除パスワード：<input type="password" name="pass">
      <input type="submit" value="削除">
    </form>-->

  <?php endwhile;?>
</div>

<div class="threadwaku">

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
          <input type="hidden" name="ip" value="<?php echo $ip
          ;?>" />

        </td>
    <!--<tr>
    <th>削除<br>パスワート゛<br>(数字4桁)</th>
    <td><input type="text" name="pass" maxlength="4" ></td>
  </tr>-->
  
  <td>
    <input type="submit" name="submit" value="投稿" /></td>
    
  </tr>
</table>
</form>
</div>
<div class="box3"></div>


<div class="boxsize">
  <?php 
  while ($row2 = $result_res->fetch()):?>
  
  <p class="block3">
    <!--ID:<?php echo $res['id'];?>-->
    名前:<?php echo $row2['name'];?>投稿日時:<?php echo $row2['created_at'];?>
    IPアドレス:<?php echo $row2['ipadress'];?>
  </p>
  <p><?php echo $row2['body'];?></p>
  <?php 
    endwhile;?>
  
  <!--
  <form action="delete.php" method="post">
      <input type="hidden" name="id" value="<?php echo $id?>">
      削除パスワード：<input type="password" name="pass">
      <input type="submit" value="削除">
    </form>-->
    
  </div>

  <div class="box3"></div>

  <?php
/*
// ページ数の表示
  try {
    // プリペアドステートメント作成
    $result_res = $db->prepare("SELECT COUNT(*) FROM responses ");
    // クエリの実行
    $result_res->execute();
  } catch (PDOException $e){
    echo "エラー：" . $e->getMessage();
  }

  // コメントの件数を取得
  $comments = $result_res->fetchColumn();
  // ページ数を計算
  $max_page = ceil($comments / $num);
  echo '<p>';
  for ($i = 1; $i <= $max_page; $i++){
    echo '<a href="thread.php?id='.$id.'&?page2=' . $i . '">' . $i . '</a>&nbsp;';
  }
  echo '</p>';
  */
  ?>



  <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'); ?>
</div>
</body>
</html>