<?php
//刪除資料庫內容

require_once("../connect.php");

//因無表單, 因此使用GET變數
//為什麼不能用$cartproduct_id進入
// if(!isset($_GET["cart_id"])){
//     echo "請由正常管道進入";
//     exit;
// }


$cart_id = $_GET["cart_id"];

// echo "Received cart_id: " . $cart_id;

// var_dump($cart_id);

// $sql = "DELETE FROM CartProduct_detail 
// WHERE `cart_id` = $cart_id;";

$sql = "DELETE FROM `CartProduct_detail` 
WHERE `cart_id` = $cart_id;";
// var_dump($sql);
// exit;


try{
    $conn->query($sql);
    // echo "資料刪除成功";
    $msg = "刪除成功";
    }catch(mysqli_sql_exception $exc){
    $msg = "刪除資料錯誤" .$exc->getMessage();
    //法一
    // echo "刪除資料錯誤" .$exc->getMessage();
    // exit;
    //錯誤還是會繼續執行下面的程式
    //若希望錯誤, 到此停止 使用exit 或 die
    //法二
    // die("刪除資料錯誤" .$exc->getMessage());
    }
    
    $conn->close();
//跳轉至列表頁
// header("location: ./pageMsgsList2.php");
//使用script的方法, 跳轉至列表頁
    echo  "<script>
        alert(`$msg`);
        window.location.href = \"./navbar.php?webpage=cartPage02.php\";
   </script>";
    ?>