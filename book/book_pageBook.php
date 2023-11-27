<?php
require_once("../connect.php");

if(!isset($_GET["book_id"])){
    exit;
}else{
    $book_id = $_GET["book_id"];
}

$sql = "SELECT * FROM `book` WHERE `book_id` = $book_id;";

try{
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();
}catch(mysqli_sql_exception $exc){
    die("讀取失敗：" .$exc->getMessage());
}
  
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <style>
        .pcolor{
        background-color: #777e5c;
        color: white;
        }
        .btn-light{
        --bs-btn-color: azure;
        --bs-btn-bg: #777e5c;
        }
        .container{
            background-color: #F1Ece2;
        }
    </style>
    <title>修改內容</title>
</head>

<body>
    <div class="container mt-3">
        <form action="./navbar.php?webpage=book_update.php" method="post">
            <input name="book_id" type="hidden" value="<?=$book_id?>">
            <div class="input-group">
                <span class="pcolor input-group-text">會員編號</span>
                <input name="user_id" type="text" class="form-control" placeholder="訂位人"
                value="<?=$row["user_id"]?>">
            </div>

            <div class="input-group mt-2">
                <span class="pcolor input-group-text">餐廳編號</span>
                <input name="restaurant_id" type="text" class="form-control" placeholder="預定餐廳" value="<?=$row["restaurant_id"]?>">
            </div>

            <div class="input-group mt-2">
                <span class="pcolor input-group-text">日期</span>
                <input name="available_date" type="date" class="form-control" value="<?=$row["available_date"]?>">
            </div>

            <div class="input-group mt-2">
                <span class="pcolor input-group-text">時間</span>
                <input name="available_time" type="time" class="form-control" value="<?=$row["available_time"]?>">
            </div>

            <div class="input-group mt-2">
                    <span class="pcolor input-group-text">人數</span>
                    <select name="customer_nums" class="form-control">
                        <option class="text-secondary"><?=$row["customer_nums"]?></option>
                        <script>
                            for(i=1;i<11;i++){
                                document.write(`<option value="${i}">${i}</option>`);
                            }
                        </script>
                    </select>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-light">送出</button>
            </div>
        </form>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>