<?php
require_once("../connect.php");

// 通知的小視窗加上回列表
function alertAndGoToList($msg){
  echo "<script>
    alert(\"$msg\");
    window.location.href = \"./product_list.php\";
  </script>";
}
// 通知的小視窗加上回上一頁
function alertAndGoBack($msg){
  echo "<script>
    alert(\"$msg\");
    window.history.back();
  </script>";
}
// 通知的小視窗加上回上一頁
function alertAndBackToPage($msg, $page){
  echo "<script>
    alert(\"$msg\");
    window.location.href = \"$page\";
  </script>";
}
// require_once("../utilities/alertFunc.php");

if (!isset($_GET["id"])) {
  echo "請由正式方法進入頁面";
  exit;
}

$id = intval($_GET["id"]);
$sql = "SELECT * FROM product_type WHERE product_type_id = '$id'";
try {
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} catch (mysqli_sql_exception $exception) {
  $row = "ERROR";
}
if ($row == "ERROR" || $row == NULL) {
  alertAndGoToList("讀取錯誤，請洽管理人員");
  exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>管理分類</title>
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
    <h1 >管理分類</h1>
    <form action="../utilities/navbar.php?webpage=style-product_doUpdate.php" method="post" enctype="multipart/form-data">
      <!-- 隱藏欄位 分類編號 -->
      <input type="hidden" name="id" value="<?= $row["product_type_id"] ?>">
      <div class="input-group mb-1">
        <span class="input-group-text">分類名稱</span>
        <input name="name" type="text" class="form-control" placeholder="分類名稱" value="<?= $row["product_type_name"] ?>">
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
    btnSend.addEventListener("click", function(e) {
      e.preventDefault();
      let name = document.querySelector("input[name=name]").value;
      if (name == "") {
        alert("請填寫分類名稱");
        return false;
      }
      form.submit();
    })
  </script>
</body>

</html>