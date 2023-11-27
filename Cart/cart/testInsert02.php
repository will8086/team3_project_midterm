<?php
require_once("../connect.php");




$sql = "INSERT INTO `cart` (`Cart_id`, `user_id`, `Groupbuy_id`)
VALUES 
(NULL, '45', '40');";

try{
$conn->query($sql);
echo "資料新增成功";
}catch(mysqli_sql_exception $exc){
echo "資料新增失敗" .$exc->getMessage();
}

?>