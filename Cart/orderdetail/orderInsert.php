<?php
//將表單內容送出後, 新增至資料庫

require_once("../connect.php");


if(!isset($_POST["product_id"])){
    echo "請由正常管道進入";
    exit;
}

$product_idValue = $_POST["product_id"];
// var_dump($product_idValue);
// exit;
$order_idValue = $_POST["order_id"];
// var_dump($order_idValue);
// exit;
$numValue = $_POST["num"];
// var_dump($numValue);
// exit;
$count = count($product_idValue);
// var_dump($count);
// exit;
//可判斷新增多筆或單筆資料
// $addinfo = ($count>1)?"多筆":"";

$sql = "";
for($i=0; $i<$count; $i++){
    $product_id = $product_idValue[$i];
     $order_id = $order_idValue[$i];
    $num = $numValue[$i];
    $sql .= "INSERT INTO `Oder_detail` (`orderproduct_id`, `order_id`, `product_id`, `num`, `cartproduct_id`) 
    VALUES 
    (NULL, $order_id, $product_id, $num, NULL);";
}

// var_dump($sql);
// exit;

try{
    $conn->multi_query($sql);
    echo "資料新增成功";
    }catch(mysqli_sql_exception $exc){
    echo "資料新增失敗" .$exc->getMessage();
    }
    
    $conn->close();
//跳轉至列表頁
// header("location: ./pageMsgsList2.php");
//使用script的方法, 跳轉至列表頁
    echo  "<script>
        alert(`資料新增成功`);
        window.location.href = \"../utilities/navbar.php?webpage=orderPage.php\";
   </script>";
    ?>