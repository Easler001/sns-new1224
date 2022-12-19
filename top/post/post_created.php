<?php
ini_set('display_errors', "On");
require_once('master.php');
$blogs = $_POST;

$blog = new Blog();
$blog->blogValidate($blogs);
$blog->blogCreate($blogs);

?>
  <p><a href="form.php">チェックフォームへ</a></p>
  <p><a href="index.html">投稿フォームへ</a></p>
