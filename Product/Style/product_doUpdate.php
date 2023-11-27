<?php
require_once("../connect.php");
// require_once("../utilities/alertFunc.php");
function alertAndGoToList2($msg){
  echo "<script>
    alert(\"$msg\");
    window.location.href = \"../utilities/navbar.php?webpage=style-product_list.php\";
  </script>";
}
// 通知的小視窗加上回上一頁
function alertAndGoBack2($msg){
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



if(!isset($_POST["id"])){
  echo "請由正式方法進入頁面";
  exit;
}

// 檢查是否有使用過 name
$name = $_POST["name"];
$sql = "SELECT * FROM `product_type` WHERE `product_type_name` = '$name'";
try {
  $result = $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $result = "error";
}

if($result == "error"){
  alertAndGoBack2("發生錯誤，請洽管理人員");
  exit;
}else if($result->num_rows > 0){
  alertAndGoBack2("該分類名稱已經使用過");
  exit;
}

// 收集表單變數
$id = intval($_POST["id"]);
$name = htmlspecialchars($_POST["name"]); // 移除 html 標籤
$sql = "UPDATE product_type SET `product_type_name` = '$name' WHERE product_type_id = $id;";

// 寫入資料庫，將結果存在變數 error
$error = "";
try {
  $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $error = $exception->getMessage();
}

$conn->close();

// 由變數 error 來判斷要轉跳回列表，或失敗了回上一頁
if($error === ""){
  alertAndGoToList2("資料修改成功");
  exit;
}else{
  alertAndGoBack2("資料修改錯誤：" .$error);
  exit;
}

