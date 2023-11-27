<?php

    if(!isset($_POST["product_id"])){
        echo "請由正常管道進入";
        exit;
    }




//$_POST[], 是PHP中用於訪問method="post"的方法
//$name = $_POST["name"]; 是將$_POST["name"], 放於變數$name !
$product_id = $_POST["product_id"];
$quantity = $_POST["quantity"];

echo $product_id ."<br>";
echo $quantity ."<br>";





