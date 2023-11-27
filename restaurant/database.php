<?php
$host = "localhost";
$dbname = "team3project";
$username = "root";
$password = "";

try {
    $mysqli = new mysqli($host, $username, $password, $dbname);
  } catch (mysqli_sql_exception $exception) {
    die("連線失敗：" . $exception->getMessage());
  }
//   try catch回传的错误的可读性较高

return $mysqli;

?>