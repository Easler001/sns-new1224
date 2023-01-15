<?php
session_start();
require('../head/library.php');

//nameを初期化してエラーを防ぐ！
// check.phpの67行目<div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
// で、index.php?action=rewriteに遷移した時前に書いていた情報を残したまま遷移させる!
if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
} else {
    $form = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];
}

$error = [];



/* フォームの内容をチェック*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    if ($form['name'] === '') {
        $error['name'] = 'blank';
}


$form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
if($form['email'] === '') {
    $error['email'] = 'blank';
} else {
    //dbに接続してメアドを参照して重複がないか確認する
    $db = dbconnect();
    $stmt = $db->prepare('select count(*) from members where email=?');
    if (!$stmt) {
        die ($db->error);
    }
    $stmt->bind_param('s', $form['email']);
    $success = $stmt->execute();
    if (!$success) {
        die ($db->error);
    }

    $stmt->bind_result($cnt);
    $stmt->fetch();

    if ($cnt > 0) {
        $error['email'] = 'duplicate';
    }

}

$form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
if($form['password'] === '') {
    $error['password'] = 'blank';
} else if (strlen($form['password']) < 4) {
    $error['password'] = 'length';
}

//画像のチェック
$image = $_FILES['image'];
if ($image['name'] !== '' && $image['error'] === 0) {
    $type = mime_content_type($image['tmp_name']);
    if ($type !== 'image/png' && $type !== 'image/jpeg') {
        $error['image'] = 'type';
    }
}
//上記のエラーチェックを全てクリア($errorが全部空である)になったら情報を送信できるようにする→確認画面へ遷移させる！
//画像は必須ではないから空でもOK(blankではなくtypeになっている！！)
if (empty($error)) {
    $_SESSION['form'] = $form;

    //画像のアップロード
    if ($image['name'] !== '') {
        $filename = date('YmdHis') . '_' . $image['name'];
        if (!move_uploaded_file($image['tmp_name'], '../member_picture/' . $filename)) {
            die('ファイルのアップロードに失敗しました');
        }
        $_SESSION['form']['image'] = $filename;
        } else {
        $_SESSION['form']['image'] = '';
        }
    header('Location: check.php');
    exit();
    }
    
}


?>

<!DOCTYPE html>
<html lang="en">
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
<h2>ユーザ登録</h2>
<!-- form action=""と空になってるのはエラーチェックを同一画面上で行うため(画面遷移はしない) -->
  <form action="" method="post" enctype="multipart/form-data">
  <p>
    <label for="username">ユーザ名：</label>
<!-- php echo h($form['name']);は、入力した内容が初期値(入れた内容が消えずにそのまま残るようにしている!!)になるようにしている！ hについてはファンクションにしている！！ -->
    <input type="text" name="name" value="<?php echo h($form['name']); ?>"/>
        <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
            <p class="error">* ユーザ名を入力してください</p>
        <?php endif ?>
  </p>
  <p>
    <label for="email">メールアドレス：</label>
    <input type="text" name="email" value="<?php echo h($form['email']); ?>"/>
<!-- emailの中身がブランク(空白)だった場合は、以下のエラーメッセージを表示するようにする！ -->
          <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
           <p class="error">* メールアドレスを入力してください</p>
          <?php endif ?>
  </p>
  <p>
    <label for="password">パスワード：</label>
    <input type="password" name="password" value="<?php echo h($form['password']); ?>"/>
        <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
            <p class="error">* パスワードを入力してください</p>
        <?php endif ?>
        <?php if (isset($error['password']) && $error['password'] === 'length'): ?>
            <p class="error">* パスワードは4文字以上で入力してください</p>
        <?php endif ?>
  </p>
<!--  <p>
    <label for="password_conf">パスワード確認：</label>
    <input type="password" name="password_conf">
  </p>
  </div>
  <input type="hidden" name="csrf_token" value="  php echo h(setToken());   "> -->
  <p>
    <label for="image">プロフィール画像(任意)：</label>
    <input type="file" name="image" size="35" value=""/>
        <?php if (isset($error['image']) && $error['image'] === 'type'): ?>
         <p class="error">* 写真などは「.png」または「.jpg」の画像を指定してください</p>
        <?php endif ?>
        <p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
  </p>
  <div class="buttom">
  <p>
    <input type="submit" value="新規登録">
  </p>
</div>
<div class="select">
  </form>
  <a href="login_form.php">ログインする</a>
  <a href="/index.html">ホーム画面へ</a>
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
	</div>
</body>
</html>