<?php
require_once("../connect.php");

$cart_id = "81";
$product_id = "33";
$quantity = "5";

$sql = "INSERT INTO `CartProduct_detail` (`cartproduct_id`, `cart_id`, `product_id`, `quantity`) 
VALUES 
(NULL, $cart_id, $product_id, $quantity);";

try{
$conn->query($sql);
echo "資料新增成功";
}catch(mysqli_sql_exception $exc){
echo "資料新增失敗" .$exc->getMessage();
}

?>