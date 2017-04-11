<?php
        // インクルード(DB接続class読込)
        include './db/DbManager.php';
// セッション開始
session_start();
// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$SignUpMessage = "";
// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワードが未入力です。';
    }else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードが同じではありません。';
    
    }else if($_POST["password3"] != "tm227005"){
        
        header("Location: register.php");
    }
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] == $_POST["password2"]) {
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        
        $password = $_POST["password"];
        $userid = rand();
        // 2. ユーザIDとパスワードが入力されていたら認証する
        // 3. エラー処理
        try {
            $db = new DB ();
            $dbdb = $db->connect ();
            $stmt = $dbdb->prepare("INSERT INTO account(USER_NAME, USER_PASS,USER_ID) VALUES (?,?,?)");
            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT),$userid));
            $SignUpMessage = '登録が完了しました。'.$username.'の登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } 
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ユーザーの追加</title>
  
  <link rel="stylesheet" href="./css/navi.css">
  <link rel="stylesheet" href="./css/table.css">
  <link rel="stylesheet" href="./css/form.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/plus.css">

    </head>
    <body>
        <div id="size">
        <?php include('./common/menu.php'); ?>
        <h1>ユーザー情報を追加してください（管理者専用）</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
<table class="thread_style">
<div><font color="#ff0000"><?php echo $errorMessage ?></font></div>
                <div><font color="#0000ff"><?php echo $SignUpMessage ?></font></div>
  
  <tr>
    <th>ユーザー名</th>
    <td><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>"></td>
  </tr>
  <tr>
    <th>パスワード</th>
    
    <td><input type="password" id="password" name="password" value="" placeholder="パスワードを入力"></td>
  </tr>
  <tr>
    <th>パスワード（確認用）</th>
    
    <td><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力"></td>
  </tr>
  <tr>
    <th>管理者パスワード</th>
    
    <td><input type="password" id="password3" name="password3" value="" placeholder="管理者のみ知ることが出来るパスワードです。"></td>
  </tr>
  
    
    
    
     <tr><th> <input type="submit" id="signUp" name="signUp" value="新規登録">    </th>
     <td></td></tr>
  
</table>
</form>
      <form action="sign.php">
            <input type="submit" value="戻る">
        </form>
        <?php include('./common/footer.php'); ?>
        </div>
    </body>
</html>