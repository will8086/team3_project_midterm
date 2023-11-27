<?php
//將表單內容送出後, 新增至資料庫

require_once("../connect.php");


if(!isset($_POST["order_id"])){
    echo "請由正常管道進入";
    exit;
}



$payment_status = $_POST["payment_status"];
$user_id = $_POST["user_id"];
$payment_method = $_POST["payment_method"];
$delivery_method = $_POST["delivery_method"];
$delivery_address = $_POST["delivery_address"];
$delivery_status = $_POST["delivery_status"];
$order_id = $_POST["order_id"];


// $sql = "UPDATE `Order_general` SET  
// `payment_status` = '$payment_status', 
// `user_id` = '$user_id', 
// `payment_method` = '$payment_method', 
// `delivery_method` = '$delivery_method', 
// `delivery_status` = '$delivery_status',
// `delivery_address` = '$delivery_address' 
// WHERE `order_id` = $order_id";

$sql ="UPDATE `Order_general` SET 
`payment_status` = '$payment_status', 
`user_id` = '$user_id', 
`payment_method` = '$payment_method', 
`delivery_method` = '$delivery_method', 
`delivery_address` = '$delivery_address', 
`delivery_status` = '$delivery_status' 
WHERE `order_id` = $order_id";
// echo "$sql";
// exit;

try{
    $conn->multi_query($sql);
    // echo "資料新增成功";
    $msg = "修改成功";
    }catch(mysqli_sql_exception $exc){
    $msg = "修改資料錯誤" .$exc->getMessage();
    //法一
    // echo "修改資料錯誤" .$exc->getMessage();
    // exit;
    //錯誤還是會繼續執行下面的程式
    //若希望錯誤, 到此停止 使用exit 或 die
    //法二
    // die("修改資料錯誤" .$exc->getMessage());
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