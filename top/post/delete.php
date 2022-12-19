<?php
session_start();
require('../head/library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
} else {
    header('Location: ../public/login_form.php');
    exit();
}

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$post_id) {
  header('Location: delete_post.php');
  exit();
}

$db = dbconnect();
//limit 1で複数件(全件)削除にならないようにする保険代わりにしている
//また、member_id=?も指定することで、他人の投稿を削除出来ないようにしている
$stmt = $db->prepare('delete from posts where id=? and member_id=? limit 1');
if (!$stmt) {
  die($db->error);
}
$stmt->bind_param('ii', $post_id, $id);
$success = $stmt->execute();
if (!$success) {
  die($db->error);
}
header('Location: delete_post.php'); exit();
?>
