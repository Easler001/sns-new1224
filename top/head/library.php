<?php

require_once('env.php');


//htmlspecialcharsを短くする！(ファンクション化)
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES);
}
/* DBへの接続 */
function dbConnect() {
  $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
  $host   = DB_HOST;
  $dbname = DB_NAME;
  $user   = DB_USER;
  $pass   = DB_PASS;
  $dsn    = "mysql:host=$host;dbname=$dbname;charset=utf8";
  $driver_options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone='+09:00'"];
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
  );

  
  try {
      $dbh = new PDO($dsn,$user,$pass,[
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
  } catch(PDOException $e){
      echo '接続失敗' . $e->getMessage();
      exit();
  };
  return $dbh;
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

//function dbconnect() {
//  $db = new mysqli("us-cdbr-east-06.cleardb.net", 'b2b4481a7a8f9d', '4c3227dc', "heroku_3bf94c806b7c575");
//  if (!$db) {
//		die($db->error);
	}


?>