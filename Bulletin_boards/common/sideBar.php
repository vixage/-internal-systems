<!--サイドバー 開始 -->
<div id="sidebar_left" style="float:left; height: 900px">
	<!--登録 -->
	<p><?php echo (!isset($_SESSION['USER_ID']))?"<a class='button' href='register.php'>登録はこちら</a>":"ようこそ！".$_SESSION['name']."さん";?>

     <!--ログイン -->
      <?php echo (isset($_SESSION['USER_ID']))?"<!--":"";?>
      <a class="button" href="login.php">ログイン</a><br>
      <?php echo (isset($_SESSION['USER_ID']))?"-->":"";?>
      <!-- ログアウト -->
      <?php echo (!isset($_SESSION['USER_ID']))?"<!--":"";?>
      <a class="button" href="logout.php">ログアウト</a><br>
      <?php echo (!isset($_SESSION['USER_ID']))?"-->":"";?>








	<p>
		<!--Googleカレンダー 追加 -->
		<iframe
			src="https://calendar.google.com/calendar/embed?title=%E6%8E%B2%E7%A4%BA%E6%9D%BF&amp;height=300&amp;wkst=1&amp;hl=ja&amp;bgcolor=%23FFFFFF&amp;src=neogreenlife2012%40gmail.com&amp;color=%2329527A&amp;src=zh-tw.taiwan%23holiday%40group.v.calendar.google.com&amp;color=%23125A12&amp;ctz=Asia%2FTokyo"
			style="border-width: 0" width="200" height="300" frameborder="0"
			scrolling="no"></iframe>
	</p>
	<p>

	<!--FBいいねボタン、シェアボタン 追加 -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.8";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-like" data-href="<?php echo $_SERVER['SERVER_NAME'];?>"
		data-width="200px" data-layout="button_count" data-action="like"
		data-size="large" data-show-faces="true" data-share="true"></div>
	</p>



</div>