<?php
session_start();
require('../head/library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
} else {
    header('Location: login.php');
    exit();
}

$db = dbconnect();



?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../style/stylesheet4.css">
  <title>ログインしました</title>
  </head>
<body>
<header>
    <h1>
       <a href="#">InColle house</a>
    </h1>
		<nav class="nav">
		<nav class="nav">
			<ul>
				<li><a href="/top/public/signup_form.php">Registration</a></li>
				<li><a href="/top/public/login_form.php">Login</a></li>
				<li><a href="/top/head/info.html">About</a></li>
				<li><a href="/top/head/contact.html">Contact</a></li>
				<!--<li><a href="https://twitter.com/owner_club0022" target="_blank" rel="noopener">Twitter</a></li>-->
			</ul>
		</nav>
</header>
<!-- Header End -->
<div class="main-visual">
  <h2>Success!</h2>
<p>ようこそ <?php echo h($name); ?>さん</p>
</div>
<div class="select">
<a href="mypage.php">マイページへ</a>
</div>
<footer id="fh5co-footer" role="contentinfo">
		<div class="container">
			<div class="row copyright">
				<div class="col-md-12 text-center">
				<div class="logo">
					<a>
						<small class="block">&copy; Easler. All Rights Reserved.</small> 
						
					</a>
					</div>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>