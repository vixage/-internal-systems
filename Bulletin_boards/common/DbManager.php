<?php
  function connect() {
  $dsn = 'mysql:host=localhost;dbname=vixage;charset=utf8';
$user= 'root';
$password = '1125';

  try {
    $db = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
    exit("データベースに接続できません。：{$e->getMessage()}");
  }
  return $db;
}