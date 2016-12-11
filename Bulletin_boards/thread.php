<?php
include 'common/checkLogin.php';
include 'common/DbManager.php';
// 1ページに表示されるコメントの数
$num = 10;
//スレッドIDを取得
$id = $_GET['id'];

//スレッドを取得

  try{
    $db = connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // プリペアドステートメントを作成
    $thread = $db->prepare(
      "SELECT * FROM threads where id = " . $id
      );

    $result_res = $db->prepare(
      "SELECT * FROM responses where thread_id = $id 
      
      ");
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
    
  
  <td>
    <input type="submit" name="submit" value="投稿" /></td>
    <input type="hidden" name="token" value="echo hash("sha256", session_id()) ?>">
  </tr>
</table>
</form>
</div>
<div class="box3"></div>


<div class="boxsize">
  <?php 
  while ($row2 = $result_res->fetch()):?>
  
  <p class="block3">
    名前:<?php echo $row2['name'];?>投稿日時:<?php echo $row2['created_at'];?>
    IPアドレス:<?php echo $row2['ipadress'];?>
  </p>
  <p><?php echo $row2['body'];?></p>
  <?php 
    endwhile;?>
  

    
  </div>

  <div class="box3"></div>




  <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'); ?>
</div>
</body>
</html>