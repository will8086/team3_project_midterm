<?php

require_once("../connect.php");

$sql= "CREATE TABLE cart (
    Cart_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    user_id INT NOT NULL , 
    Groupbuy_id INT NOT NULL
  );";

//使用query的方法去取得$sql並連線
  if($conn->query($sql) === true){
    echo "資料表 cart 建立完成";
  }else{
    echo "建立資料表錯誤" .$conn->error;
  }

  $conn->close();





?>