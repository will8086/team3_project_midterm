<?php
//將表單內容送出後, 新增至資料庫

require_once("../connect.php");


if(!isset($_POST["cart_id"])){
    echo "請由正常管道進入";
    exit;
}

$cart_id = $_POST["cart_id"];
$user_id = $_POST["user_id"];

//可判斷新增多筆或單筆資料
// $addinfo = ($count>1)?"多筆":"";
//以下為更新留言的sql語法, 需搭配pageMsg.php

// $sql = "UPDATE `cart` SET `cart_id` = '$cart_id', 
// `user_id` = '$user_id' 
// WHERE `cart_id` = $cart_id;";


$sql = "UPDATE `cart` SET `cart_id` = '$cart_id', `user_id` = '$user_id'  WHERE `cart_id` = $cart_id;";

// var_dump($sql);
// exit;
// echo "$sql";
// exit;

try{
    $conn->multi_query($sql);
    // echo "資料新增成功";
    $msg = "資料更新成功";
    }catch(mysqli_sql_exception $exc){
    // echo "資料新增失敗" .$exc->getMessage();
    $msg = "資料新增失敗" .$exc->getMessage();
    }
    
    $conn->close();

    // echo "$sql";
    // exit;
//跳轉至列表頁
// header("location: ./pageMsgsList2.php");
//使用script的方法, 跳轉至列表頁
    echo  "<script>
        alert(`$msg`);
        window.location.href = `../utilities/navbar.php?webpage=cartPage.php`;
   </script>";
    ?>