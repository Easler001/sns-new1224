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

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
    header('Location: index.php');
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
  <title>==Clubhouse==</title>
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
<div id="wrap">
    <div id="head">
    </div>
    <div id="content">
        <?php $stmt = $db->prepare('select p.id, p.member_id, p.message, p.category, p.created, m.name, m.picture from posts p, members m where p.id=? and m.id=p.member_id order by id desc');
        if (!$stmt) {
            die($db->error);
        }
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        if(!$success) {
            die($db->error);
        }

        $stmt->bind_result($id, $member_id, $message, $category, $created, $name, $picture);
        if ($stmt->fetch()):
            ?>
        <div class="main-visual">
        <h2>POSTED(投稿詳細)</h2>
            <?php if ($picture): ?>
                <img src="../member_picture/<?php echo h($picture); ?>" width="400" height=240" alt=""/>
            <?php endif; ?>
        <div class="contents">
            <p><?php
            //長文への対策として、特定の行で改行させる!
            $limit = 120;
            $words = wordwrap($message, 120, '<br/>', true);

            if(mb_strlen($message) > $limit) { 
            $main = mb_substr($message,0,$limit);
            echo $words ;
            } else {
            echo h($message);
            };

            ?></p>
        </div>
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

            ?>]</span>
            <p class="day"><a style="color: rgb(134, 140, 235);"><?php echo h($created); ?></a>
            <?php if ($_SESSION['id'] === $member_id): ?>
                [<a href="delete.php?id=<?php echo h($id); ?>" style="color: #F33;">削除する</a>]
            <?php endif; ?>
        </p>
        </div>
        <?php else: ?>
        <p>その投稿は削除されたか、URLが間違えています</p>
        <?php endif; ?>
    </div>
</div>
    <div class="select">
        <p>&laquo;<a href="../public/mypage.php">マイページへ</a></p>
        <p>&laquo;<a href="../post/clubhouse.php">InColle houseへ</a></p>

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