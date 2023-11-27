<?php
//建立資料庫
require_once("../connect.php");

$sql= "CREATE TABLE CartProduct_detail (
    cartproduct_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    cart_id INT NOT NULL ,
    product_id INT NOT NULL , 
    quantity INT NOT NULL
  );";

//使用query的方法去取得$sql並連線
  if($conn->query($sql) === true){
    echo "資料表 CartProduct_detail 建立完成";
  }else{
    echo "建立資料表錯誤" .$conn->error;
  }

  $conn->close();





?>