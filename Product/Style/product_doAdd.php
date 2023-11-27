<?php
// session_start();
require_once("../connect.php"); // 引用連線


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
// require_once("../utilities/alertFunc.php"); // 引用常用函數



if(!isset($_POST["name"])){
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
  alertAndGoBack("發生錯誤，請洽管理人員");
  exit;
}else if($result->num_rows > 0){
  alertAndGoBack("該分類名稱已經使用過");
  exit;
}


// 整理表單變數
$name = htmlspecialchars($_POST["name"]);
// $uid = $_SESSION["user"]["id"];

// 整理 SQL
$sql2 = "INSERT INTO `product_type` 
  (`product_type_id`, `product_type_name`) VALUES 
  (NULL, '$name');";
// 寫入資料庫
try {
  $conn->query($sql2);
  alertAndGoToList("新增分類成功");
} catch (mysqli_sql_exception $exception) {
  alertAndGoToList("分類新增錯誤：" .$conn->error);
}

echo($sql);
echo($sql2);
exit;
$conn->close();
