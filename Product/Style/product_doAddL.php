<?php
// session_start();
require_once("../connect.php"); // 引用連線
// require_once("../utilities/alertFunc.php"); // 引用常用函數


if(!isset($_POST["name"])){
  echo "請由正式方法進入頁面";
  exit;
}

// 檢查是否有使用過 name
$name = $_POST["name"];
$sql = "SELECT * FROM `product_type_list` WHERE `product_type_list_name` = '$name'";
try {
  $result = $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $result = "error";
}

if($result == "error"){
  alertAndGoBack("發生錯誤，請洽管理人員");
  exit;
}else if($result->num_rows > 0){
  alertAndGoBack("該分類名稱已經使用過");
  exit;
}


// 整理表單變數
$name = htmlspecialchars($_POST["name"]);
$type = ($_POST["type"]);
// $uid = $_SESSION["user"]["id"];

// 整理 SQL
$sql = "INSERT INTO `product_type_list` 
  (`product_type_list_id`, `product_type_id`, `product_type_list_name`, `isValid`) VALUES 
  (NULL, '$type', '$name', '1');";

// 寫入資料庫
try {
  $conn->query($sql);
  alertAndGoToList("新增分類成功");
} catch (mysqli_sql_exception $exception) {
  alertAndGoToList("分類新增錯誤：" .$conn->error);
}
$conn->close();

// 通知的小視窗加上回列表
function alertAndGoToList($msg){
  echo "<script>
    alert(\"$msg\");
    window.location.href = \"../utilities/navbar.php?webpage=style-product_list.php\";
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