<?php
$servername = "localhost";
$username = "root";
$password = "";
// $dbname = "test";
$dbname = "team3project";
$port = 3306;

//PHP7
// $conn = new mysqli($servername, $username, $password, $dbname, $port);
// // $conn = new mysqli($servername, $username, $password);
// if($conn->connect_error){
//   die("連線失敗：" .$conn->connect_error);
// }

//PHP8
try{
  $conn = new mysqli($servername, $username, $password, $dbname, $port);
}catch(mysqli_sql_exception $exc){
  die("連線失敗:" .$exc->getmessage());
};