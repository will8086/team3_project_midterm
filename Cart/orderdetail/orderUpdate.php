<?php
//將表單內容送出後, 新增至資料庫

require_once("../connect.php");


if(!isset($_POST["product_id"])){
    echo "請由正常管道進入";
    exit;
}

$product_id = $_POST["product_id"];
$order_id = $_POST["order_id"];
$num = $_POST["num"];

//doUpdate01欄位檢查 ～ 檢查變數是否為空值 法一 ～
// if(empty($quantity)){
//     echo "請輸入數量";
//     //若在這整一個, 回到上一頁的按鈕, 會是用網址連結的方式, 而回到全新的一頁, 此時網址後面的id, 就會不見
//     echo "<button onclick='goBack()'>回到上一頁</button>";
//     echo "<script>
//     function goBack(){
//         window.history.back();
//     }
//     </script>";
//     exit;
// }


//檢查變數是否為空值 法二
if($num === ""){
    echo "<script>
    alert('請輸入數量');
    window.history.back();
    </script>";
    exit;
}


//可判斷新增多筆或單筆資料
// $addinfo = ($count>1)?"多筆":"";
//以下為更新留言的sql語法, 需搭配pageMsg.php

//錯誤？？
// $sql = "UPDATE `CartProduct_detail` SET 
// `cart_id` = '$cart_id', 
// `product_id` = '$product_id', 
// `quantity` = '$quantity' 
// WHERE `CartProduct_detail`.`cartproduct_id` = $cartproduct_id;";

$sql = "UPDATE `Oder_detail` SET 
`product_id` = '$product_id', 
`num` = '$num' 
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
        window.location.href = \"../utilities/navbar.php?webpage=orderPage.php\";
   </script>";
    ?>