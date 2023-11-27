<?php
//將表單內容送出後, 新增至資料庫

require_once("../connect.php");


if(!isset($_POST["cart_id"])){
    echo "請由正常管道進入";
    exit;
}

$cart_idValue = $_POST["cart_id"];
$user_idValue = $_POST["user_id"];
$count = count($cart_idValue);

//可判斷新增多筆或單筆資料
// $addinfo = ($count>1)?"多筆":"";

$sql = "";
for($i=0; $i<$count; $i++){
    $cart_id = $cart_idValue[$i];
    $user_id = $user_idValue[$i];
    $sql .= "INSERT INTO `cart` (`cart_id`, `user_id`) 
    VALUES 
    ('$cart_id', '$user_id');";
}

// echo "$sql";
// exit;

try{
    $conn->multi_query($sql);
    // echo "資料新增成功";
    $msg = "資料新增成功 ! ";
    }catch(mysqli_sql_exception $exc){
    // echo "資料新增失敗" .$exc->getMessage();
    $msg = "資料新增失敗" .$exc->getMessage();
    }
    
    $conn->close();
//跳轉至列表頁
// header("location: ./pageMsgsList2.php");
//使用script的方法, 跳轉至列表頁
    echo  "<script>
        alert(`$msg`);
        window.location.href = \"./navbar.php?webpage=cartPage.php\";
   </script>";
    ?>