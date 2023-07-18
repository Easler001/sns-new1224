<?php
session_start();
require('../head/library.php');
//もし直接この画面が呼び出されてしまったら、index.phpへ移動させるようにする！
if (isset($_SESSION['form'])) {
		$form = $_SESSION['form'];
} else {
	header('Location: signup_form.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = dbconnect();
  $stmt = $db->prepare('insert into members (name, email, password, password2, picture) VALUES (?, ?, ?, ?, ?)');
  if (!$stmt) {
    die($db->error);
  }
  $password = password_hash($form['password'], PASSWORD_DEFAULT);
  $password2 = password_hash($form['password2'], PASSWORD_DEFAULT);
  $stmt->bind_param('sssss', $form['name'], $form['email'], $password, $password2, $form['image']);
  $success = $stmt->execute();
  if (!$success) {
      die($db->error);
  }

  unset($_SESSION['form']);
  header('Location: register.php');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../style/stylesheet3.css">
  <title>ユーザ登録画面</title>
  </head>
<body>
  <header>
    <h1>
       <a href="#"><img src="/logo/incolle-white.jpg" alt="" width="250" height="55"></a>
    </h1>
    <!--<nav class="nav">
			<ul>
				<li><a href="/top/public/signup_form.php">Registration</a></li>
				<li><a href="/top/public/login_form.php">Login</a></li>
				<li><a href="/top/head/info.html">About</a></li>
				<li><a href="/top/head/contact.html">Contact</a></li>
				<li><a href="https://twitter.com/owner_club0022" target="_blank" rel="noopener">Twitter</a></li>
			</ul>
		</nav>-->
</header>
<!-- Header End -->
<div class="main-visual">
<h2>登録確認</h2>
<p>記入した内容にお間違えがなければ、「登録する」ボタンをクリックしてください</p>
    <form action="" method="post">
    <dl>
      <dt>ユーザ名：<?php echo h($form['name']); ?></dt>
      <br>
      <dt>メールアドレス:<?php echo h($form['email']); ?></dt>
      <br>
					<dt>パスワード:【セキュリティ対策のため表示されません】</dt>
      <br>
					<dt>写真など</dt>
					<dd>
							<img src="../member_picture/<?php echo h($form['image']); ?>" width="100" alt="" />
					</dd>
       </dl>
       <div class="select"><a href="signup_form.php?action=rewrite">&laquo;&nbsp;書き直す</a>  <input type="submit" value="登録する" /></div>
</div>
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
	</div>
</body>
</html>