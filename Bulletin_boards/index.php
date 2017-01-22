<?php
session_start();
<<<<<<< HEAD
include './db/connectDB.php';
$num = 6;
//エラーメッセージ初期化
$errorMessage = NULL;
=======
include './db/DbManager.php';
include 'common/trip.php';
$num = 10;
$ip = $_SERVER["REMOTE_ADDR"];
>>>>>>> origin/master

//ページ数が指定されているとき
$page = 0;
if (isset($_GET['page']) && $_GET['page'] > 0){
  $page = intval($_GET['page']) -1;
}

<<<<<<< HEAD
//DB接続
$db = new DB();
$dbdb =$db -> dbConnect();
$stmt = $dbdb -> prepare("select ARTICLE_ID,CREATE_DATE,NAME,EMAIL,TITLE,TEXT,PASSWORD_FLAG,PLACE,LAT,LNG,POSTER from article order by CREATE_DATE DESC LIMIT :page, :num");
$page = $page * $num;
$stmt->bindParam(':page', $page, PDO::PARAM_INT);
$stmt->bindParam(':num', $num, PDO::PARAM_INT);
$stmt->execute();

//スレッド作成ボタン押下時
if(isset($_POST['threadNew'])){
	//CSRF対策
	if($_POST['token'] == hash("sha256",session_id())){
		//エラーメッセージ初期化
		$errorMessage = NULL;
		//タイトル欄の文字数が51文字以上
		if(mb_strlen($_POST['title']) >= 51){
		//エラー変数に｢タイトル欄は50文字以内で入力してください。｣を格納
			$errorMessage .="「タイトル欄は50文字以内で入力してください。」<br>";
		}
		//本文入力がある
		if(empty($_POST['text'])){
			//エラーメッセージに｢本文を入力してください。｣を格納(input_確認押下時)
			$errorMessage .="「本文を入力してください。」<br>";
		}
    //エラーメッセージがない場合
		if(empty($errorMessage)){
      $_SESSION['name'] = $_POST['name'];
      $_SESSION['mail'] = $_POST['mail'];
      $_SESSION['title'] = $_POST['title'];
      $_SESSION['text'] = $_POST['text'];

      header('Location:confirm.php');
      exit();
    }
  }
}
=======
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




>>>>>>> origin/master
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<<<<<<< HEAD
  <title>掲示板</title>
=======
  <title>ヴィックスグループ専用掲示板</title>
  
  
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style1.css">
>>>>>>> origin/master
  
  <link rel="stylesheet" href="./css/navi.css">
  <link rel="stylesheet" href="./css/table.css">
  <link rel="stylesheet" href="./css/form.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/plus.css">
</head>
<body>
<<<<<<< HEAD
<div id="size">
  <?php include('./common/menu.php'); ?>

  <!-- 出勤ボタン-->
    <div id="attend">
    <input type="button" style="width:200px;height:80px;margin-top: 25px; margin-bottom: 40px"; value="出勤">
    <input type="button" style="width:200px;height:80px; margin-bottom: 40px"; value="退勤">
    <input type="button" style="width:200px;height:80px; margin-bottom: 40px"; value="勤怠修正">
    </div>
  
    <!-- スレッド作成画面　-->
    <div id="form" class="left">
      <form method="post" id="demo">
        <h2>新規スレッドの作成</h2>
        <!-- エラーメッセージの出力-->
        <font color="red"><?php echo $errorMessage;?></font>
        <label for="name">名前</label><span><input type="text" name="name"></span>
        <label for="title">タイトル</label><span><input type="text" name="title"></span>
        <label for="text">本文</label><span><textarea name="text" style="width:450px;height:7em;"></textarea></span>
        <input type="hidden" name="token" value="<?php echo hash("sha256",session_id());?>">
        <p><input type="submit" name="threadNew" value="確認" class="input" ></p>
      </form>
    </div>


    
    
    <div class="clear"></div>
    <!-- スレッド一覧画面　-->
    <div id="threads">
      <h2>スレッド一覧</h2>

      <table  class="type03">
        <tr>
         <th>スレッド番号</th>
         <th>タイトル</th>
         <th>本文</th>
         <th>投稿者</th>
         <th>作成・更新日</th>
         <th>編集</th>
         <th>削除</th>
       </tr>
       <!-- DBから情報出力-->
       <?php
       while($row = $stmt -> fetch()){
        ?>
        <tr>
          <th><?php echo htmlspecialchars($row['ARTICLE_ID'],ENT_QUOTES,'UTF-8'),false;?></th>
          <th><a href="thread.php?id=<?php echo htmlspecialchars($row['ARTICLE_ID'],ENT_QUOTES,'UTF-8'),false;?>">
            <?php echo htmlspecialchars($row['TITLE'],ENT_QUOTES,'UTF-8'),false;?></a></th>
            <th><?php echo htmlspecialchars($row['TEXT'],ENT_QUOTES,'UTF-8'),false;?></th>
            <th><?php echo htmlspecialchars($row['NAME'],ENT_QUOTES,'UTF-8'),false;?></th>
            <th><?php echo htmlspecialchars($row['CREATE_DATE'],ENT_QUOTES,'UTF-8'),false;?></th>
            <th><a href="#">編集</a></th>
            <th><a href="#">削除</a></th>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
    <div style="text-align: center">
      <?php

// ページ数の表示
      try {
    // プリペアドステートメント作成
        $sql = $dbdb -> prepare("SELECT COUNT(*) FROM article");
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
      ?></div>
      <!-- Twitter-->
      <div style="float:right;">
        <a class="twitter-timeline" data-lang="ja" data-width="450" data-height="750" data-link-color="#2B7BB9" href="https://twitter.com/vixage2013">Tweets by vixage2013</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script></div>
        <!-- FBページ　-->
        <div id="facebook">
          <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fvixage%2F%3Ffref%3Dts&tabs=timeline&width=450&height=750&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="450" height="750" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
        </div>
        <div class="clear"></div>
      
      <div class="clear"></div>
      <!-- フッター-->
      <?php include('./common/footer.php'); ?></div>
    </body>
    </html>
=======
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
>>>>>>> origin/master
