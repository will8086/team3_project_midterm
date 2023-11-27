<?php
//將表單內容送出後, 新增至資料庫

require_once("../connect.php");


if(!isset($_POST["product_id"])){
    echo "請由正常管道進入";
    exit;
}

$cart_idValue = $_POST["cart_id"];
$product_idValue = $_POST["product_id"];
$quantityValue = $_POST["quantity"];
$count = count($product_idValue);

//可判斷新增多筆或單筆資料
// $addinfo = ($count>1)?"多筆":"";

//emptycheck假定大家都有填, 布林值設定false
$emptycheck = false;
for($i=0; $i<$count; $i++){
    //防止塞程式在輸入筐裡
    $quantity = htmlspecialchars($quantityValue[$i]);
 if(empty($quantity)){
    $emptycheck = true;
 }
}

if($emptycheck === true){
    echo "<script>
    alert(\"請輸入所有欄位\");
    window.history.back();
    </script>";
    exit;
}


$sql = "";
for($i=0; $i<$count; $i++){
    $product_id = $product_idValue[$i];
    $quantity = $quantityValue[$i];
    $cart_id = $cart_idValue[$i];
    $sql .= "INSERT INTO `CartProduct_detail` (`cartproduct_id`, `cart_id`, `product_id`, `quantity`) 
    VALUES 
    (NULL, $cart_id, $product_id, $quantity);";
    // var_dump($sql);
    // exit;
}

try{
    $conn->multi_query($sql);
    // echo "資料新增成功";
    //把原本echo的內容, 改用Javascript帶出
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
        window.location.href = `../utilities/navbar.php?webpage=cartPage02.php`;
   </script>";
    ?>