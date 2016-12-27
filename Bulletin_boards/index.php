<?php
session_start();
include './db/DbManager.php';
include 'common/trip.php';
$num = 10;
$ip = $_SERVER["REMOTE_ADDR"];

//ページ数が指定されているとき
$page = 0;
if (isset($_GET['page']) && $_GET['page'] > 0){
  $page = intval($_GET['page']) -1;
}

try{

  $db = new DB ();
  $dbdb = $db->connect ();
    // プリペアドステートメントを作成
  $sql = $dbdb->prepare(
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

//新規スレッド作成ボタンが押された場合の処理
if (isset($_POST ['threadnew'])) {
  // CSRF対策
  if ($_POST ['token'] == hash ( "sha256", session_id () )) {
    // エラー変数に空欄を格納
    $errorMessage = NULL;
    // タイトル欄の文字数が51文字以上
    if (mb_strlen ( $_POST ['title'] ) >= 51) {

      $errorMessage .= "「タイトル欄は50文字以内で入力してください。」<br>";
    }

    if (empty ( $_POST ['body'] )) {

      $errorMessage .= "「本文を入力してください。」<br>";
    }
    
    if(empty($_POST['name'])){
      $name = "とあるAGE社員";
    }else{
      $name = implode(Trip($_POST['name']));
    }

    if (empty ( $errorMessage )) {
      // セッション["name"]["mail"]["title"]["body"]["color"]にフォームからの入力値を格納
      $_SESSION ['name'] = $_POST ['name'];
      $_SESSION ['title'] = $_POST ['title'];
      $_SESSION ['body'] = $_POST ['body'];
      header ( 'Location:confirm.php' );
      exit ();
    }
  }
}




?>



<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>ヴィックスグループ専用掲示板</title>
  
  
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style1.css">
  

</head>
<body>
  <div id ="wrapper">
    <!-- ナビゲーション 読み込み-->

    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/global_menu.php'); ?>
    <h2>この掲示板について</h2>

    <p>この掲示板はVixAgeの社員専用掲示板です。<br>
      会社に関することはもちろん,、趣味や遊びのことなど使用用途は各自にお任せいたします！<br></p>
      <div class="container">
          <table  class="table table-bordered" width="950px">
            <tbody>
              <tr>
                <th>作成日時</th>
                <th>スレッド名</th>
                <th>作成者</th>
                <th>編集</th>
                <th>削除</th>

              </tr>
              <?php 
              while ($row = $sql->fetch () ) {?>
              <tr>
                <td><?php echo htmlspecialchars($row['created_at'],ENT_QUOTES,'UTF-8'),false;?></td>
                <td><a href="thread.php?id=<?php echo htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8'),false;?>"><?php echo htmlspecialchars($row['title'],ENT_QUOTES,'UTF-8'),false;?></a></td>
                <td><?php echo htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'),false;?></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        

      </div>

      <?php

// ページ数の表示
      try {
    // プリペアドステートメント作成
        $sql = $dbdb->prepare("SELECT COUNT(*) FROM threads");
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



      <div class="threadwaku" style="text-align: left;">
        <font color="red"><?php if(isset($errorMessage)){echo $errorMessage;};?></font>
        <h2>スレッド作成</h2>
        <form method="post">
         <div class="form-group">
          <label>名　前　：</label>
          <input type="text" name="name" value="" maxlength="10" class=”form-control”/></td>
        </div>
        <div class="form-group">
          <label>タイトル：</label>
          <input type="text" name="title" maxlength="50" /></td>
        </div>

        <div class="form-group">
          <label>内　容　：</label>
          <textarea name="body" style="height:170px" maxlength="1000" class=”form-control” ></textarea>
        </div>

        <input type="hidden" name="type" value="create" />
        <input type="hidden" name="type" value="$id" />
        <input type="hidden" name="token" value="<?php echo hash("sha256",session_id()); ?>" />

        <input type="submit" name="threadnew" value="作成" class="btn btn-default" style="margin-left:240px ">
        <div class="box3"></div>

      </form>

      <div class="box3"></div>

    </div>





    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'); ?>
  </body>
  </html>