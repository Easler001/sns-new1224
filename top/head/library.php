<?php

//htmlspecialcharsを短くする！(ファンクション化)
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES);
}
/* DBへの接続 */
function dbconnect() {
  $db = new mysqli('localhost', 'root', 'root', 'sns-new');
  if (!$db) {
		die($db->error);
	}
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
  ); 

  return $db;
}
function setCategoryName($caregory) {
  if ($caregory === '1') {
    return '日常';
  } elseif ($caregory === '2') {
    return 'スポーツ';
  } elseif ($caregory === '3') {
    return '音楽';
  } elseif ($caregory === '4') {
    return 'アニメ・漫画';
  } elseif ($caregory === '5') {
    return 'ファッション';
  } elseif ($caregory === '6') {
    return '旅行';
  } else {
    return '健康・美容';
  }
}

//$db = new mysqli("us-cdbr-east-06.cleardb.net", 'b2b4481a7a8f9d', '4c3227dc', "heroku_3bf94c806b7c575");
// HOST User Pass DBnameの順番!!


//旧データ
//$db = $db = new mysqli("us-cdbr-east-06.cleardb.net", 'b3a176db61fc9a', 'fda70dab', "heroku_c9155dfc9d6ef3d");

//localの時
//$db = new mysqli('localhost', 'root', 'root', 'sns-new');

/* DBへの接続 */
//function dbconnect() {
//  $db = new mysqli("us-cdbr-east-06.cleardb.net", 'b2b4481a7a8f9d', '4c3227dc', "heroku_3bf94c806b7c575");
//  if (!$db) {
//		die($db->error);
//	}

//  $options = array(
//    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
//  ); 


?>