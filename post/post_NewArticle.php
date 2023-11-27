<?php
require_once("../connect.php");
$sql = "SELECT * FROM `post` join `user` on post.user_ID = user.user_id join updating_restaurant on post.updating_restaurant_ID = updating_restaurant.updating_restaurant_ID;";
$sql2 ="SELECT * FROM `updating_restaurant` ;";
$sql3 ="SELECT * FROM `price_range`";

try{
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $result3 = $conn ->query($sql3);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $row2s = $result2->fetch_all(MYSQLI_ASSOC);
    $row3s = $result3->fetch_all(MYSQLI_ASSOC);
    $count = count($rows);
}catch(mysqli_sql_exception $exc){
    $count = -1;
}

$conn->close();
?>

<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .img{
        width: 200px;
        height: 200px;
        object-fit: cover;
        }
        .bg1{
            background-color: #f1ece2;
        }
        .bg2{
            background-color:#777e5c;
        }

        /* .btn {
            --bs-btn-color: #fff;
            --bs-btn-bg: #777e5c;
            --bs-btn-border-color: #777e5c;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg:#777e5c;
            --bs-btn-hover-border-color: #777e5c;
            --bs-btn-focus-shadow-rgb: 60,153,110;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #777e5c;
            --bs-btn-active-border-color: #777e5c;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);          
} */
    </style>
    <title>新增文章</title>
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    </head>
    <body>
        <div class="container mt-3">
        <form action="../post/post_NewArticleInsert.php" method="post" enctype="multipart/form-data">
        <div class="input-group mt-2">
        <span class="input-group-text bg2 text-white">文章標題</span>
        <input name="name" type="text" class="form-control" placeholder="文章標題">
        </div>
        <div class="input-group mt-1">
        <span class="input-group-text bg2 text-white">文章內容</span>
        <textarea name="content" class="form-control"></textarea>
        </div>
        <div class="input-group mt-1">
        <span class="input-group-text bg2 text-white">餐廳名稱</span>
        <select name="updating_restaurant_ID" class="form-select">
        <option value selected disabled>請選擇</option>
        <?php foreach($row2s as $row2): ?>
        <option value="<?=$row2["updating_restaurant_ID"]?>"><?=$row2["updating_restaurant_name"]?></option>
        <?php endforeach; ?>
        </select>
        </div>
        <!-- <div class="input-group mt-1">
        <span class="input-group-text">新增餐廳名稱</span>
        <input name="restaurant_name" type="text" class="form-control" placeholder="請新增餐廳名稱">
        </div> -->
        <div class="input-group mt-1">
        <span class="input-group-text bg2 text-white">平均消費</span>
        <select name="price_range_ID" class="form-select">
        <option value selected disabled>請選擇</option>
        <?php foreach($row3s as $row3): ?>
        <option value="<?=$row3["price_range_ID"]?>"><?=$row3["price"]?></option>
        <?php endforeach; ?>
        </select>
        </div>
        <div class="input-group mt-1">
        <input class="form-control" type="file" name="myFile" accept=".png, .jpg, .jpeg">
        </div>
        <div class="mt-1 text-end">
        <button type="submit" class="btn btn-sm btn-send bg2 text-white">送出</button>
        </div>
            </form>
        </div>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script>
        const form = document.querySelector("form");
        const btn_send = document.querySelector(".btn-send");
        const contentArea = document.querySelector(".contentArea");
        btn_send.addEventListener("click", function (e) {
        e.preventDefault();
        let files = document.querySelectorAll("input[type=file]");
        let fileCheck = false;

        files.forEach(function(file){
        if(file.value == ""){
        fileCheck = true;
        }
        });

        if(fileCheck == true){
        alert("請加入圖檔!!!!!!!");
        }else{
        form.submit();
        }
        });
        </script>
    </body>
</html>