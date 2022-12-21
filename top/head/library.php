<?php

//htmlspecialcharsを短くする！(ファンクション化)
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES);
}
/* DBへの接続 */
function dbconnect() {
  $db = new mysqli("us-cdbr-east-06.cleardb.net", "b1766f4eecccd6", "9096fe03", "heroku_decbaef3fe591db");
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
?>