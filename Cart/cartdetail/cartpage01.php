<?php

require_once("../connect.php");


if(!isset($_GET["cart_id"])){
    exit;
}else{
    //有網址變數的話, 才讓網址變數變成id
    $cart_id = $_GET["cart_id"];
}

//針對某個東西做修改
$sql = "SELECT * FROM `CartProduct_detail` WHERE cart_id = $cart_id ORDER BY `quantity` ASC;";

// var_dump($sql);
// exit;
try{
  $result = $conn -> query($sql);
  $row = $result -> fetch_assoc();
}catch(mysqli_sql_exception $exc){
    die("讀取失敗:" .$exc->getMessage());
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <title>修改留言</title>
</head>

<body>
    <div class="container mt-3">
        <form action="../utilities/navbar.php?webpage=cartUpdate.php" method="post">
            <!-- 讓網址列有?id -->
            <input name="cart_id" type="hidden" value="<?=$cart_id?>">
            
            <div class="input-group">
                <span class="input-group-text bg2 text-white">產品編號</span>
                <input name="product_id" type="text" class="form-control" value="<?=$row["product_id"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text bg2 text-white">數量</span>
                <input name="quantity" class="form-control" value="<?=$row["quantity"]?>"></input>
            </div>
            <div class="mt-1 text-end">
                <button type="submit" class="btn bg2 text-white">送出</button>
            </div>
        </form>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>
