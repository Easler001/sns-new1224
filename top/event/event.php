<?php
session_start();
require('../head/library.php');


if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
} else {
  $form = [
      'event_name' => '',
      'content' => '',

  ];
}

$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['event_name'] = filter_input(INPUT_POST, 'event_name', FILTER_SANITIZE_STRING);
  if ($form['event_name'] === '') {
      $error['event_name'] = 'blank';
}
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['content'] = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
  if ($form['content'] === '') {
      $error['content'] = 'blank';
};

//画像のチェック
$image = $_FILES['image'];
if ($image['name'] !== '' && $image['error'] === 0) {
    $type = mime_content_type($image['tmp_name']);
    if ($type !== 'image/png' && $type !== 'image/jpeg') {
        $error['image'] = 'type';
    }
}


if (empty($error)) {
  $_SESSION['form'] = $form;

  //画像のアップロード
  if ($image['name'] !== '') {
      $filename = date('YmdHis') . '_' . $image['name'];
      if (!move_uploaded_file($image['tmp_name'], '../event_picture/' . $filename)) {
          die('ファイルのアップロードに失敗しました');
      }
      $_SESSION['form']['image'] = $filename;
      } else {
      $_SESSION['form']['image'] = '';
      }
  header('Location: event_check.php');
  exit();
  }
  
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
       <a href="/index.html">InColle house</a>
    </h1>
    <nav class="nav">
			<!--<ul>
				<li><a href="/top/public/signup_form.php">Registration</a></li>
				<li><a href="/top/public/login_form.php">Login</a></li>
				<li><a href="/top/head/info.html">About</a></li>
				<li><a href="/top/head/contact.html">Contact</a></li>
				<li><a href="https://twitter.com/owner_club0022" target="_blank" rel="noopener">Twitter</a></li>-->
			<!--</ul>-->
		</nav>
</header>
<!-- Header End -->
</header>
<!-- Header End -->

<body>
<div class="main-visual">
  <h2>EVENT</h2>
  <form action="" method="post" enctype="multipart/form-data">
  <p>
    <label for="event">イベント名：</label>
    <input type="text" size="60" name="event_name" value="<?php echo h($form['event_name']); ?>" placeholder=""/>
    <?php if (isset($error['event_name']) && $error['event_name'] === 'blank'): ?>
            <p class="error">* イベント名を入力してください</p>
        <?php endif ?>
  </p>

    <p>イベントの概要をご入力ください</p>
    <textarea name="content" cols="100" rows="20" maxlength="500" id='ta' placeholder="必須事項：&#10;①イベントの概要(必要に応じて出演者も)&#10;②イベントの日時・開催場所&#10;③イベントの値段(チケットの購入上限も)&#10;④担当者名&連絡先電話番号(フルネーム　カナあり)&#10;以上を必ず記載してください&#10;※応援購入の設定も可能です！詳細は下のリンクをご覧ください=================================================&#10;(記入例)&#10;ライブハウス◯◯で合同ライブを実施します！出演：&#10;日時：2023年4月1日　16時開場　17時開始&#10;会場：ライブハウス◯◯　住所◯◯区△△　1-2-3&#10;料金：¥2,000(+1drink)&#10;問合せ：担当　TEl:000-0000-0000(14:00~20:00)&#10;☆応援購入も受け付けております！※購入制限10枚まで&#10;詳細はご予約時にお問い合わせください"></textarea>
    <script>
      document.getElementById('ta').value ="<?php echo h($form['content']); ?>"
    </script>
    <?php if (isset($error['content']) && $error['content'] === 'blank'): ?>
            <p class="error">* イベントの概要を入力してください</p>
        <?php endif ?>
    <p>
    <label for="image">画像(任意)：</label>
    <input type="file" name="image" size="35" value=""/>
        <?php if (isset($error['image']) && $error['image'] === 'type'): ?>
         <p class="error">* 写真などは「.png」または「.jpg」の画像を指定してください</p>
        <p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
        <?php endif ?>
  </p>
  <div class='setting'>

    <input type="submit" value="イベント登録" class="rounded-corner">
    </div>
  </form>
      <div class="select">
        <p><a href="exam.html">詳細な<u>記入例</u>はこちら</a></p>
        <p><a href="support.html">応援購入の<u>詳細</u>はこちら</a></p>
          <p><a href="/index.html">トップページへ</a></p>
      <div>
</body>
</html>