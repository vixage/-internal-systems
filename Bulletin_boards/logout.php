<?php
session_start();
if(isset($_SESSION['USERID'])){
unset($_SESSION['USERID']);
}
setcookie("name",'', time() - 3600);

header('Location:sign.php');
?>