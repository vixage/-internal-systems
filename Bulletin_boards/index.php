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

//トリップ機能
function Trip($str) {
    //stripslashes（バックスラッシュ（\）を取り除く）
    $str = stripslashes($str);
    $str = mb_convert_encoding($str, "SJIS", "UTF-8,EUC-JP,JIS,ASCII"); 
    //★を☆に置換
    $str = str_replace("★", "☆", $str);
    //◆を◇に置換
    $str = str_replace("◆", "◇", $str);
    if (($trips = strpos($str, "#")) !== false) {
    
        $kotehan = mb_substr($str, 0, $trips);
        $tripkey = mb_substr($str, $trips + 1);
        $salt = mb_substr($tripkey.'H.', 1, 2);
        
        $patterns = array(':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`');
        $match = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'a', 'b',  'c', 'd', 'e', 'f');
        $salt = str_replace($patterns, $match, $salt);
        
        $pattern = '/[\x00-\x20\x7B-\xFF]/';
        $salt = preg_replace($pattern, ".", $salt);
        
        $trip = crypt($tripkey, $salt);
        
        $trip = substr($trip, -10);
        $kotehan = mb_convert_encoding($kotehan, "UTF-8", "SJIS"); 
        $trip = mb_convert_encoding($trip, "UTF-8", "SJIS"); 
        $trip = '◆'.$trip;
        
        return array($kotehan, $trip);
        
    }
    
    $str = mb_convert_encoding($str, "UTF-8", "SJIS");
    
    return array($str, "");
}

if (isset($_POST["submit"])) {
    //名前がない場合
    if(empty($_POST['name'])){
      $name = "とあるAGE社員";
    }
    else{
      $name = implode(Trip($_POST['name']));
    }

    $title = $_POST['title'];
    $body = $_POST['body'];

  //プリペアドステートメント作成
  $stmt = $db->prepare("
    INSERT INTO threads (name,title,body,created_at,ipadress)
    VALUES(:name,:title,:body,now(),:ip)"
    );

            //パラメーターを割り当て
  $stmt->bindParam(':name',$name,PDO::PARAM_STR);
  $stmt->bindParam(':title',$title,PDO::PARAM_STR);
  $stmt->bindParam(':body',$body,PDO::PARAM_STR);
  $stmt->bindParam(':ip',$ip,PDO::PARAM_STR);
  

//クエリの実行
  $stmt->execute();

  header("Location:index.php");
  exit();
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
            </p>

          </div>


          <div class="threadwaku">
           <h2>スレッド作成</h2>
           <form  action="index.php" method="post">
            <table>

              <tr>
                <th>名前</th>
                <td><input type="text" name="name" 
                value="<?php echo nl2br(htmlspecialchars($_COOKIE['name'],ENT_QUOTES,'UTF-8'),false); ?>" maxlength="10" /></td>
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
    <td><input type="hidden" name="type" value="create" /></td>
    <td><input type="hidden" name="type" value="$id" /></td>

    
    
  </tr>
  <tr>
    <td><input type="submit" name="submit" value="作成" /></td>
    <td><input type="hidden" name="token" value="
    <?php echo hash("sha256", session_id()) ?>" /></td>    
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
      <td><a href="thread.php?id=<?php echo $row['id'];?>"><?php echo nl2br(htmlspecialchars($row['title'],ENT_QUOTES,'UTF-8'),false);?></a></td>
      <td><?php echo nl2br(htmlspecialchars($row['name'],ENT_QUOTES,'UTF-8'),false);?></td>



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