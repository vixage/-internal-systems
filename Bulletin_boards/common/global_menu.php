<?php
if (isset($_POST['Logout'])) {

	if(isset($_SESSION['USERID'])){
		unset($_SESSION['USERID']);
	}
	setcookie("name",'', time() - 3600*60);

	header('Location:login.php');
}

?>

<div id="header">
  <h1 class="box1"><a href="index.php"><img src="/image/Desktop.png"></a></h1>
  <div id="logout" class="box4">
  <form method="post">
    <input type="submit" name="Logout" value="ログアウト" class="btn-primary"/>
</form>
</div>
<div class="box3"></div>
  <div class="nav">

<ul class="nl clearFix">
<li><a href="index.php">TOP PAGE</a></li>
<li><a href="rule.php">GUIDLINES</a></li>
<li><a href="#">DEVELOPMENT</a></li>
<li><a href="https://github.com/vixage/-internal-systems">GITHUB SOURCE</a></li>
<li><a href="mailto:f.ochiai@vixage.co.jp">CONTACT</a></li>
</ul>

</div>

  </div>