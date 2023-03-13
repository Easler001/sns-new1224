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
  <link rel="stylesheet" href="../style/stylesheet5.css">
  <title>マイページ</title>
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
<h2>ユーザー用マイページ</h2>
<!--  登録している場合は写真を入れる  -->
<!--  ただデータの呼び込みを上のPHPでしてないのでここで呼び出す。  -->
<!--  sqlについてはmembersのテーブルからpictureを呼び込む。　-->
<!--  この時idはここの6行目で$id = $_SESSION['id'];とされているので、id = $idとして呼び出す! -->
<?php $stmt = $db->prepare("select picture, email from members where id = $id");
        if (!$stmt) {
            die($db->error);
        }
        $success = $stmt->execute();
        if(!$success) {
            die($db->error);
        }

        $stmt->bind_result($picture,$email);
        while ($stmt->fetch()):
            ?>

<?php if ($picture): ?>
  <img src="../member_picture/<?php echo h($picture); ?>" width="250" height="130" alt=""/>
<?php endif; ?>
<?php endwhile; ?>



  <div class="name">
      <p><?php echo h($name); ?> さま</p>
      <p>Email：<?php echo h($email); ?></p>
  </div>

	<div class="status">
<h3>現在の購入状況</h3>

<p>Easlerさんがチケットを購入しました(¥4,400)</p>

<p>購入者　1名　　　　　　　合計金額　¥4,400</p>

</div>

<!--<div class="select">
<a href="../post/index.php">投稿フォームへ</a>
<a href="../post/clubhouse.php">InColle houseへ</a>
</div>-->
<div class="buttom">
<form action="out.php" method="POST">
<input type="submit" name="logout" value="ログアウト">
</form>
</div>

	<footer id="fh5co-footer" role="contentinfo">

		<div class="incolle-logo">
			<img src="/logo/incolle-black.jpg" alt="" width="250" height="55">
			<p>最新情報はSNSにて更新中!</p>
			<a href="https://twitter.com/owner_club0022" target="_blank" rel="noopener"><img src="/logo/twitter-w.png" alt="" width="30" height="30"></a>
		</div>
			<div class="info">
				<a href="/top/head/info.html">About</a></li>
				<a href="/top/head/contact.html">Contact</a></li>
			</div>

<div class="announce">
	<p>本サイトは、パートナーとともにEaslerが企画運営・編集しているメディアです。</p>
</div>

		<div class="container">

					<div class="logo">
					<a>
						<small class="block">&copy; Easler. All Rights Reserved.</small> 						
					</a>
					</div>
		</div>
	</footer>
	</div>
	</footer>
</body>
</html>