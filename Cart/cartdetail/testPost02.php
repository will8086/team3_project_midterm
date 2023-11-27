<?php

    if(!isset($_POST["product_id"])){
        echo "請由正常管道進入";
        exit;
    }




//$_POST[], 是PHP中用於訪問method="post"的方法
//$name = $_POST["name"]; 是將$_POST["name"], 放於變數$name !

$cart_idValue = $_POST["cart_id"];
$product_idValue = $_POST["product_id"];
$quantityValue = $_POST["quantity"];
$count = count($product_idValue);

$sql = "";
for($i=0; $i<$count; $i++){
    $product_id = $product_idValue[$i];
    $quantity = $quantityValue[$i];
    $cart_id = $cart_idValue[$i];
    $sql .= "INSERT INTO `CartProduct_detail` (`cartproduct_id`, `cart_id`, `product_id`, `quantity`) 
    VALUES 
    (NULL, $cart_id, $product_id, $quantity);";
}
echo $sql;







