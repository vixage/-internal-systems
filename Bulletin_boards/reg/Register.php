<?php
require_once 'DbManager.php';
try {
  $db = connect();
  $sql = 'INSERT INTO users VALUES(
            :id, :name, :zipcode, :address, :tel, :mail)';

  $stt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stt->execute(array(':id' => $_POST['id'],
                      ':name' => $_POST['name'],
                      ':zipcode' => $_POST['zipcode'],
                      ':address' => $_POST['address'],
                      ':tel' => $_POST['tel'],
                      ':mail' => $_POST['mail']
                      ));
  $db = NULL;
} catch (PDOException $e) {
  exit("エラーが発生しました。{$e->getMessage()}");
}
header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/UserRegist.php');