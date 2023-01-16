<?php
session_start();
require('../head/library.php');

$error = [];
$email = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ($email === '' || $password === '') {
        $error['login'] = 'blank';
    } else {
    //ログインチェック limit 1は何らかの理由でセキュリティを突破された時に取得できるメールデータは1件のみで抑えられる
    $db = dbconnect();
    $stmt = $db->prepare('select id, name, password from members where email=? limit 1');
    if (!$stmt) {
        die($db->error);
    }
//emailとパスを分割しているのは、ここでのパスとDB内のパスは別物だから(DB内のパスはハッシュ化しているため)
//なのでメールの照合→パスの照合と2段階の手順をとる
    $stmt->bind_param('s', $email);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
    }

    $stmt->bind_result($id, $name, $hash);
    $stmt->fetch();

    if (password_verify($password, $hash)){
    //ログイン成功
    session_regenerate_id();
    $_SESSION['id'] = $id;
    $_SESSION['name'] = $name;
    header('location: login.php');
    exit();
    } else {
        $error['login'] = 'failed';
    }
}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../style/stylesheet2.css">
  <title>ログイン画面</title>
</head>
<body>
<header>
    <h1>
       <a href="/index.html">InColle house</a>
    </h1>
		<nav class="nav">
			<ul>
				<li><a href="../head/info.html">About</a></li>
				<li><a href="../head/contact.html">Contact</a></li>
				<!--<li><a href="https://twitter.com/owner_club0022" target="_blank" rel="noopener">Twitter</a></li>-->
			</ul>
		</nav>
</header>
<!-- Header End -->
<div class="main-visual">
<h2>ログインフォーム</h2>
    <?php if (isset($err['msg'])) : ?>
        <p><?php echo $err['msg']; ?></p>
    <?php endif; ?>
    <form action="" method="post">
  <p>
    <label for="email">メールアドレス：</label>
    <input type="text" name="email" value="<?php echo h($email); ?>"/>
                    <?php if(isset($error['login']) && $error['login'] === 'blank'): ?>
                        <p class="error">* メールアドレスとパスワードをご記入ください</p>
                    <?php endif; ?>
                    <?php if(isset($error['login']) && $error['login'] === 'failed'): ?>
                        <p class="error">* ログインに失敗しました。正しくご記入ください。</p>
                    <?php endif; ?>
  </p>
  <p>
    <label for="password">パスワード：</label>
    <input type="password" name="password" value="<?php echo h($password); ?>"/>
  </p>
  <p>
    <div class="buttom">
    <input type="submit" value="ログイン">
  </p>
  </div>
  <div class="select">
  </form>
  <a href="signup_form.php">新規登録はこちら</a>
  <a href="/index.html">ホームへ</a>
  </div>
    </div>
  <footer id="fh5co-footer" role="contentinfo">
		<div class="container">
			<div class="row copyright">
				<div class="col-md-12 text-center">
					<a>
						<small class="block">&copy; Easler. All Rights Reserved.</small>
					</a>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>