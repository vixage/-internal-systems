<?php
include 'common/signDB.php';
// セッション開始
session_start();


if(isset($_SESSION['USERID'])){
    header("Location:index.php");
}
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
                    setcookie('name',$row['name'],time() +3600*60);
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
            print('Error:'.$e->getMessage());
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
    <div id="up">
        <title id="up">ログイン</title></div>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/sign.css">

    </head>
    <body>

        <div id="wrapper">

            <!--<img src="image/AGEMANALL.png" width="950px">-->

            <h1>ログイン</h1>
            <div class="box">


                <form id="loginForm" name="loginForm" action="" method="POST">


                    <p><?php echo $errorMessage ?></p>
                    <label for="userid"></label><input type="text" id="userid" name="userid" class="text" placeholder="ユーザーID" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
                    <br>
                    <label for="password"></label><input type="password" id="password" class="text" name="password" value="" placeholder="パスワード">
                    <br>
                    <br>
                    <input type="submit" id="login" name="login" value="ログイン" class="button">

                </form>


            </div>
            <p><a href="form.php">パスワードを忘れたら</a></p>
        </div>
        

        <div class="size">
            <div id="box">

                <hr>

                <form method="post" action="reg.php">

                    <p>まだIDがない方は<a href="form.php">こちら</a></p>

                    <p>管理者の方はこちら<input type="submit" name="submit" value="新規ユーザー登録" /></p>
                </form>

            </div>
            <hr>
            <footer>        
                <p>(C)2016 VIXAGE created by Fumitaka Ochiai</p>
            </footer>


        </div>
    </body>
    
    </html>