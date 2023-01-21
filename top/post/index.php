<?php
session_start();
require('../head/library.php');

//追加

//nameを初期化してエラーを防ぐ！
// check.phpの67行目<div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
// で、index.php?action=rewriteに遷移した時前に書いていた情報を残したまま遷移させる!
if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])) {
  $message = $_SESSION['form'];
} else {
  $message = [
      'message' => '',

  ];
}

$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['message'] = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
  if ($form['message'] === '') {
      $error['message'] = 'blank';
}
};

//ここまで

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: login.php');
  exit();
}
$db = dbconnect();
//メッセージの投稿


//追加 エラー0個になったときに投稿できるようにする→投稿内容白紙化の防止！
if (empty($error)) {
  $_SESSION['form'] = $form;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $stmt = $db->prepare('insert into posts (message, member_id, category) values(?,?,?)');
    if(!$stmt) {
        die($db->error);
    }

    $stmt->bind_param('sii', $message, $id, $category);
    $success = $stmt->execute();
    if(!$success) {
        die($db->error);
    }

    header('Location: post.php');
    exit();
}
//追加ここまで
};

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSTFORM</title>
  <link rel="stylesheet" href="../style/stylesheet-view.css"/>
</head>
<body>
  <header>
    <h1>
       <a href="#">InColle house</a>
    </h1>
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
</header>
<!-- Header End -->

<body>
<div class="main-visual">
  <h2>POSTFORM</h2>
  <form action="" method="post">
    <p>何をお話ししますか?(500文字まで)</p>
<!--     追加    -->
    <?php if (isset($error['message']) && $error['message'] === 'blank'): ?>
            <p class="error">* 本文を入力してください</p>
        <?php endif ?>
<!--     ここまで    -->
    <textarea name="message" cols="70" rows="5" maxlength="500"></textarea>
  <div class='setting'>
    <p>カテゴリ</p>
  </div>
    <div class='set'>
    <select name="category">
      <option value="1">日常</option>
      <option value="2">スポーツ</option>
      <option value="3">音楽</option>
      <option value="4">アニメ・漫画</option>
      <option value="5">ファッション</option>
      <option value="6">旅行</option>
      <option value="7">健康・美容</option>
    </select>
    <input type="submit" value="POST">
    </div>
  </form>
      <div class="select">
          <p><a href="../public/mypage.php">マイページへ</a></p>
      <div>
</body>
</html>