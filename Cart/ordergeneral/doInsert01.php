<?php
//將表單內容送出後, 新增至資料庫 （一次增加單筆資料）

require_once("../connect.php");


if(!isset($_POST["order_id"])){
    echo "請由正常管道進入";
    exit;
}


$order_id = $_POST["order_id"];
$payment_status = $_POST["payment_status"];
$user_id = $_POST["user_id"];
$payment_method = $_POST["payment_method"];
$delivery_method = $_POST["delivery_method"];
$delivery_status = $_POST["delivery_status"];

$sql = "INSERT INTO `Order_general` (`order_id`, `payment_status`, `user_id`, `payment_method`, `delivery_method`, `delivery_status`, `order_date`) 
VALUES 
($order_id, '$payment_status', $user_id, '$payment_method', '$delivery_method', '$delivery_status', CURRENT_TIMESTAMP())";

try{
$conn->query($sql);
echo "資料新增成功";
}catch(mysqli_sql_exception $exc){
echo "資料新增失敗" .$exc->getMessage();
}

$conn->close();
?>