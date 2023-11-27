<?php
require_once("../connect.php");

$sql="SELECT * FROM `product_type` WHERE `isValid` = 1";


try{
    $result = $conn->query($sql);
    //將結果取出為關聯式陣列
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $count = count($rows);

  }catch(mysqli_sql_exception $exc){
  }
  $conn->close();
  ?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>增加次分類</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
        <style>
        .gr{
          background-color: #777e5c;
        }
        .grF{
          color: #777e5c;
        }
        .wt{
          background-color: #f1ece2; 
        }
        .wtF{
          color: #f1ece2;
        }

        </style>
  </head>
  <body>

    <div class="container my-3">
      <h1>增加次分類</h1>
      <form action="../utilities/navbar.php?webpage=style-product_doAddL.php" method="post" enctype="multipart/form-data">
            <div class="input-group mt-1">
                <!-- 隸屬大分類 -->
                <span class="input-group-text">分類</span>
                <select  class="type1" name="type" class="form-select">
                    <option value selected disabled>請選擇</option>
                    <?php foreach($rows as $row): ?>
                        <option value="<?=$row["product_type_id"]?>"><?=$row["product_type_name"]?></option>
                    <?php endforeach; ?>        
                </select>
            </div>
            <!-- 輸入次分類 -->
            <div class="input-group mb-1">
          <span class="input-group-text">次分類名稱</span>
          <input name="name" type="text" class="form-control" placeholder="輸入次分類名稱">
        </div>
        <div class="mt-1 text-end">
          <button type="submit" class="btn gr wtF btn-send">送出</button>
          <a class="btn gr wtF" href="../utilities/navbar.php?webpage=style-product_list.php">取消</a>
        </div>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
      const form = document.querySelector("form");
      const btnSend = document.querySelector(".btn-send");
      btnSend.addEventListener("click", function(e){
        e.preventDefault();
        let name = document.querySelector("input[name=name]").value;
        if(name == ""){
          alert("請填寫分類名稱");
          return false;
        }
        form.submit();
      })
    </script>
  </body>
</html>