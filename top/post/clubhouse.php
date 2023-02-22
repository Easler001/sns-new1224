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
  <title>==InColle house==</title>
  <link rel="stylesheet" href="../style/stylesheet-club.css"/>
</head>
<body>
  <header>
  <h1>
       <a href="/index.html"><img src="/logo/incolle-white.jpg" alt="" width="250" height="55"></a>
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

<?php $stmt = $db->prepare('select p.id, p.member_id, p.message, p.category, p.created, m.name, m.picture from posts p, members m where m.id=p.member_id order by id desc');
        if (!$stmt) {
            die($db->error);
        }
        $success = $stmt->execute();
        if(!$success) {
            die($db->error);
        }

        $stmt->bind_result($id, $member_id, $message, $category, $created, $name, $picture);
        while ($stmt->fetch()):
            ?>

            <!--  予備… <div class="picture"> <p> -->
        <div class="main-visual">
            <div class="picture">
        <p><?php if ($picture): ?>
                <img src="../member_picture/<?php echo h($picture); ?>" width="180" height="135" alt=""/>

                <?php endif; ?>
        </p>
        </div>
            <p><?php
            //本文を全部表示させたら見栄え悪いから16文字以上はカット!
            $limit = 16;
 
            if(mb_strlen($message) > $limit) { 
            $main = mb_substr($message,0,$limit);
            echo $main. '･･･' ;
            } else {
            echo h($message);
            };
            ?>
            <span class="name">（posted by:<?php echo h($name); ?>）
            [カテゴリ:<?php
            $a = "日常";
            $b = "スポーツ";
            $c = "音楽";
            $d = "アニメ・漫画";
            $e = "ファッション";
            $f = "旅行";
            $g = "健康・美容";

            if ($category === 1) {
                echo $a;
            } elseif ($category === 2) {
                echo $b;
            } elseif ($category === 3) {
                echo $c;
            } elseif ($category === 4) {
                echo $d;
            } elseif ($category === 5) {
                echo $e;
            } elseif ($category === 6) {
                echo $f;
            } else {
                echo $g;
            };

            ?>]</span></p>
           
            
            <p class="day"><a href="view.php?id=<?php echo h($id); ?>" style="color: rgb(134, 140, 235);"><?php echo h($created); ?></a>
            <?php if ($_SESSION['id'] === $member_id): ?>
                [<a href="delete.php?id=<?php echo h($id); ?>" style="color: #F33;">削除</a>]
            <?php endif; ?>
            </p>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<div class="page">
<p><a href="../public/mypage.php">マイページへ</a></p>
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