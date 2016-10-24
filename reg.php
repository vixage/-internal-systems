<?php

// セッション開始
session_start();


$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "1125";  // ユーザー名のパスワード
$db['dbname'] = "vixage";  // データベース名

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
    }else if($_POST["password3"] != "tm227005"){
        
        header("Location: ban.php");

    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] == $_POST["password2"]) {
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        setcookie($username,$namae,time() -60*60*24*30);
        $password = $_POST["password"];
        $userid = uniqid();

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO users(name, password,userid) VALUES (?,?,?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT),$userid));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            //$uniqueid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $SignUpMessage = '登録が完了しました。'.$username.'の登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            echo $e->getMessage();
            // $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
            // echo $e->getMessage();
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ユーザーの追加</title>
            <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        <div class="size">
        <h1>ユーザー情報を追加してください</h1>
        <!-- $_SERVER['PHP_SELF']はXSSの危険性があるので、actionは空にしておく -->
        <!-- <form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST"> -->
        <form id="loginForm" name="loginForm" action="" method="POST">
            <div class="border2">
                <legend>新規登録フォーム</legend>
                <div><font color="#ff0000"><?php echo $errorMessage ?></font></div>
                <div><font color="#0000ff"><?php echo $SignUpMessage ?></font></div>
                <label for="username">ユーザー名</label><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                
                <br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
                <br>
                <label for="password3">管理者用パスワード</label><input type="password" id="password3" name="password3" value="" placeholder="管理者のみ知ることが出来るパスワードです。">
                <br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </div>
        </form>
        <p>管理者パスワードをお持ちでない方は、下記よりID申請をお願いいたします。</p>
        <a href="mailto:f.ochiai@vixage.co.jp">ID申請はこちら</a></p>
        <br>
        <form action="sign.php">
            <input type="submit" value="戻る">
        </form>
        <footer>        
        <p>(C)2016 VIXAGE created by Fumitaka Ochiai</p>
        </footer>
        </div>
    </body>
</html>