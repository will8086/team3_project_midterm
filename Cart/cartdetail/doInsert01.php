<?php
//將表單內容送出後, 新增至資料庫

require_once("../connect.php");


if(!isset($_POST["product_id"])){
    echo "請由正常管道進入";
    exit;
}


$cart_id = $_POST["cart_id"];
$product_id = $_POST["product_id"];
$quantity = $_POST["quantity"];

$sql = "INSERT INTO `CartProduct_detail` (`cartproduct_id`, `cart_id`, `product_id`, `quantity`) 
VALUES 
(NULL, $cart_id, $product_id, $quantity);";

try{
$conn->query($sql);
echo "資料新增成功";
}catch(mysqli_sql_exception $exc){
echo "資料新增失敗" .$exc->getMessage();
}

$conn->close();
?>