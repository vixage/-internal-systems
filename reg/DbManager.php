<?php
  function connect() {
  $dsn = 'mysql:dbname=vixage; host=localhost; charset=utf8';
  $usr = 'vixuser';
  $passwd = 'password';

  try {
    $db = new PDO($dsn, $usr, $passwd);
  } catch (PDOException $e) {
    exit("データベースに接続できません。：{$e->getMessage()}");
  }
  return $db;
}