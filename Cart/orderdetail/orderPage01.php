<?php

require_once("../connect.php");


if(!isset($_GET["order_id"])){
    exit;
}else{
    //有網址變數的話, 才讓網址變數變成id
    $order_id = $_GET["order_id"];
}

//針對某個東西做修改
$sql = "SELECT * FROM `Oder_detail` WHERE order_id = $order_id;";


try{
  $result = $conn -> query($sql);
  //把$result變陣列, 一筆一筆讀取
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
    <!-- <link rel="stylesheet" href="../../css/bootstrap.min.css"> -->
    <title>修改留言</title>
</head>

<body>
    <div class="container mt-3">
        <form action="../utilities/navbar.php?webpage=orderUpdate.php" method="post">
            <!-- 讓網址列有?id -->
            <input name="order_id" type="hidden" value="<?=$order_id?>">
            
            <div class="input-group">
                <span class="input-group-text text-white bg2">產品編號</span>
                <input name="product_id" type="text" class="form-control" value="<?=$row["product_id"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text text-white bg2">數量</span>
                <input name="num" type="text" class="form-control" value="<?=$row["num"]?>">
            </div>
            <div class="mt-1 text-end">
                <button type="submit" class="btn text-white bg2">送出</button>
            </div>
        </form>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>
