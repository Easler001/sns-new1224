<?php
session_start();
require('top/head/library.php');
//もし直接この画面が呼び出されてしまったら、event.phpへ移動させるようにする！
if (isset($_SESSION['form'])) {
		$form = $_SESSION['form'];
} else {
	header('Location: event.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = dbconnect();
  $stmt = $db->prepare('insert into event (event_name, content, event_picture) VALUES (?, ?, ?)');
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bind_param('sss', $form['event_name'], $form['content'], $form['image']);
  $success = $stmt->execute();
  if (!$success) {
      die($db->error);
  }

  unset($_SESSION['form']);
  header('Location: event_register.php');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="top/style/stylesheet3.css">
  <title>ユーザ登録画面</title>
  </head>
<body>
  <header>
    <h1>
       <a href="#">InColle house</a>
    </h1>
    <nav class="nav">
			<ul>
				<!--<li><a href="/top/public/signup_form.php">Registration</a></li>
				<li><a href="/top/public/login_form.php">Login</a></li>
				<li><a href="/top/head/info.html">About</a></li>
				<li><a href="/top/head/contact.html">Contact</a></li>
				<li><a href="https://twitter.com/owner_club0022" target="_blank" rel="noopener">Twitter</a></li>-->
			</ul>
		</nav>
</header>
<!-- Header End -->
<div class="main-visual">
<h2>登録確認</h2>
<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
    <form action="" method="post">
    <dl>
      <dt>イベント名：<?php echo h($form['event_name']); ?></dt>
      <br>
      <dt>イベントの概要:<?php echo h($form['content']); ?></dt>
					<dt>写真など</dt>
					<dd>
							<img src="event_picture/<?php echo h($form['image']); ?>" width="100" alt="" />
					</dd>
       </dl>
       <div class="select"><a href="event.php?action=rewrite">&laquo;&nbsp;書き直す</a>  <input type="submit" value="登録する" /></div>
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