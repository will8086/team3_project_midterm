<?php

require_once("../connect.php");
$sql = "SELECT * FROM `CartProduct_detail`;";

try{
    //使用result來承接內容
     $result = $conn->query($sql);
     $msgNum = $result -> num_rows;
    }catch(mysqli_sql_exception $exc){
    //  die("讀取失敗:" .$exc->getMessage());
     //將錯誤訊息存到$errorMsg變數
     $errorMsg = $exc->getMessage();
     $msgNum = -1;
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
    <title>留言列表</title>
    <style>
    .msg{
        display: flex;
    }
    .id{
        width: 30px;
    }
    .name{
        width: 100px;
    }
    .content{
        width: calc(100% - 30px - 100px - 180px)
    }
    .time{
        width: 180px;
    }
    </style>
</head>

<body>
<div class="container">
  <h1>購物車</h1>
        <?php if($msgNum > 0): ?>
            <div class="my-2">
                目前共 <?=$msgNum?> 筆資料
            </div>
            <div class="msg text-bg-dark ps-1">
                <div class="id">id</div>
                <div class="name">Product_id</div>
                <div class="content">Quantity</div>
                <div class="time">time</div>
            </div>
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="msg">
                <div class="id"><?=$row["cart_id"]?></div>
                <div class="name"><?=$row["product_id"]?></div>
                <div class="content"><?=$row["quantity"]?></div>
                <div class="time">time</div>
            </div>
            <?php endwhile; ?>
            <?php elseif($msgNum == 0): ?>
                目前沒有資料
            <?php else: ?>
                發生錯誤：<?php $errorMsg ?>
        <?php endif;  ?>
</div>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>