<?php

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSTFORM</title>
  <link rel="stylesheet" href="top/style//stylesheet-view.css"/>
</head>
<body>
  <header>
    <h1>
       <a href="#">InColle house</a>
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
  <h2>POSTFORM</h2>
  <form action="" method="post">
  <p>
    <label for="event">イベント名：</label>
    <input type="text" name="name" placeholder=""/>
  </p>

    <p>イベントの概要をご入力ください</p>
    <textarea name="message" cols="100" rows="20" maxlength="500" placeholder="必須事項：&#10;①イベントの概要(必要に応じて出演者も)&#10;②イベントの日時・開催場所&#10;③イベントの値段(チケットの購入上限も)&#10;④担当者名&連絡先電話番号(フルネーム　カナあり)&#10;以上を必ず記載してください&#10;※応援購入の設定も可能です！詳細は下のリンクをご覧ください=================================================&#10;(記入例)&#10;ライブハウス◯◯で合同ライブを実施します！出演：&#10;日時：2023年4月1日　16時開場　17時開始&#10;会場：ライブハウス◯◯　住所◯◯区△△　1-2-3&#10;料金：¥2,000(+1drink)&#10;問合せ：担当　TEl:000-0000-0000(14:00~20:00)&#10;☆応援購入も受け付けております！※購入制限10枚まで&#10;詳細はご予約時にお問い合わせください"></textarea>
  <div class='setting'>

    <input type="submit" value="イベントを登録">
    </div>
  </form>
      <div class="select">
        <p><a href="exam.html">詳細な記入例はこちら</a></p>
        <p><a href="support.html">応援購入の詳細はこちら</a></p>
          <p><a href="index.html">トップページへ</a></p>
      <div>
</body>
</html>