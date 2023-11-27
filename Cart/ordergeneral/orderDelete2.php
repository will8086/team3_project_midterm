<?php
//刪除資料

require_once("../connect.php");

// if(!isset($_POST["order_id"])){
//     echo "請由正常管道進入";
//     exit;
// }

// $payment_status = $_POST["payment_status"];
// $user_id = $_POST["user_id"];
// $payment_method = $_POST["payment_method"];
// $delivery_method = $_POST["delivery_method"];
// $delivery_status = $_POST["delivery_status"];
$order_id = $_GET["order_id"];
// var_dump($order_id);
// exit;

$sql = "DELETE FROM `Order_general` WHERE `order_id` = $order_id;";
// var_dump($sql);
// exit;

// var_dump($sql);
// exit;

try{
    $conn->query($sql);
    // echo "資料新增成功";
    $msg = "資料刪除成功";
    }catch(mysqli_sql_exception $exc){
    $msg = "刪除資料錯誤" .$exc->getMessage();
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