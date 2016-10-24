<?php

// セッション開始
session_start();


if(isset($_SESSION['USERID'])){
header("Location:index.php");
}

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "1125";  // ユーザー名のパスワード
$db['dbname'] = "vixage";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $userid = $_POST["userid"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM users WHERE userid = ?');
            $stmt->execute(array($userid));

            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $sql = "SELECT * FROM users WHERE userid = $userid";  //入力した$useridのユーザー名を取得
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['name'];  // ユーザー名
                    }
                    $_SESSION["USERID"] = $row['name'];
                    //セッションID再作成
                    session_regenerate_id(true);
                    header("Location: index.php");  // メイン画面へ遷移
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
            // echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/sign.css">

    </head>
    <body>
    <div class ="color">
    <div class ="size">
        
        <div id="box1">
        <img src="image/Desktop.png">
        </div>
        <div id="box2">
        <h1>AGEチャンネル（Aちゃん）</h1>
        </div>
        <!--<img src="image/AGEMANALL.png" width="950px">-->

        <br><h2>ログイン画面</h2>
        <p>会社に関する質問や改善点などいろいろ語っていきましょう！！</p>
        <!-- $_SERVER['PHP_SELF']はXSSの危険性があるので、actionは空にしておく -->
        <!-- <form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST"> -->
        <form id="loginForm" name="loginForm" action="" method="POST">
            <div class="border2">
                <legend>ログインフォーム</legend>
                <div><font color="#ff0000"><?php echo $errorMessage ?></font></div>
                <label for="userid">ユーザーID:</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
                <br>
                <label for="password">パスワード:</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
            </div>
        </form>
        <p class="big">まだIDがない方は<a href="form.html">こちら</a></p>
        </div>
        </div>

        <div class="size">
        <br>
        <div class="border2">
       
        <form method="post" action="reg.php">
    
    <legend>管理者の方はこちら</legend><input type="submit" name="submit" value="新規ユーザー登録" />
</form>
        </div>
        <footer>        
        <p>(C)2016 VIXAGE created by Fumitaka Ochiai</p>
        </footer>
        

        </div>
    </body>
    
</html>