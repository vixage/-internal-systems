<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <title></title>
</head>
<body>
    <div id="wrapper">
        <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/global_menu.php'); ?>

        <?php
        echo "あなたは管理者ではありません。";
        ?>
        
        <?php include( $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'); ?>
    </div>

    
</body>
</html>



