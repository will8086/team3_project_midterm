<?php
//將表單內容送出後, 新增至資料庫 (一次增加多筆資料) 使用by testForm04

require_once("../connect.php");


if(!isset($_POST["order_id"])){
    echo "請由正常管道進入";
    exit;
}

$order_idValue = $_POST["order_id"];
$payment_statusValue = $_POST["payment_status"];
$user_idValue = $_POST["user_id"];
$payment_methodValue = $_POST["payment_method"];
$delivery_methodValue = $_POST["delivery_method"];
//取得縣市 區域 地址, 將其合併
$city =$_POST["city"][0];
//需加[0]的原因, 如果使用者在select元素中選擇了台北市和新北市，$_POST["city"]將會是一個包含兩個元素的陣列：["台北市", "新北市"], 但我們要獲得單一字串值, 而不是陣列, 因此可以使用$_POST["city"][0],來獲得陣列中的第一個元素, 也就是使用者選擇的縣市值。這樣您就可以得到單一的字串值，而不是陣列。

$district =$_POST["district"][0];
$address =$_POST["address"][0];
$delivery_address = $city . $district . $address;
// var_dump($delivery_address);
// exit;
$delivery_statusValue = $_POST["delivery_status"];

$count = count($order_idValue);


$sql = "";
for($i=0; $i<$count; $i++){
    $order_id = $order_idValue[$i];
    $payment_status = $payment_statusValue[$i];
    $user_id = $user_idValue[$i];
    $payment_method = $payment_methodValue[$i];
    $delivery_method = $delivery_methodValue[$i];
    $delivery_address = $delivery_address;
    $delivery_status = $delivery_statusValue[$i];

    $sql .="INSERT INTO `Order_general` (`order_id`, `payment_status`, `user_id`, `payment_method`, `delivery_method`, `delivery_address`, `delivery_status`, `order_date`) 
    VALUES 
    ($order_id, '$payment_status', '$user_id', '$payment_method', '$delivery_method', '$delivery_address', '$delivery_status', CURRENT_TIMESTAMP())";
    
}


try{
    $conn->multi_query($sql);
    $msg = "資料新增成功 ! ";
    }catch(mysqli_sql_exception $exc){
    echo "資料新增失敗" .$exc->getMessage();
    $msg = $exc->getMessage();
    }
    
    $conn->close();

//跳轉至列表頁
// header("location: ./pageMsgsList2.php");
//使用script的方法, 跳轉至列表頁
    echo  "<script>
        alert(`$msg`);
        window.location.href = \"../utilities/navbar.php?webpage=orderPagee.php\";
   </script>";
    ?>