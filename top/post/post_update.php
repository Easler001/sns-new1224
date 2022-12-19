<?php
ini_set('display_errors', "On");
require_once('master.php');
$blogs = $_POST;

$blog = new Blog();
$blog->blogValidate($blogs);
$blog->blogUpdate($blogs);

?>
  <p><a href="form.php">チェックフォームへ</a></p>
