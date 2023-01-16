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
//メッセージの投稿
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

</header>
<!-- Header End -->

<body>
<div class="main-visual">
  <h2>POSTFORM</h2>
  <form action="" method="post">
    <p>何をお話ししますか?(500文字まで)</p>
    <textarea name="message" cols="50" rows="5" maxlength="500"></textarea>
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