<?php
require_once("../connect.php");

// 通知的小視窗加上回列表
function alertAndGoToList1($msg){
  echo "<script>
    alert(\"$msg\");
    window.location.href = \"../utilities/navbar.php?webpage=style-product_list.php\";
  </script>";
}
// 通知的小視窗加上回上一頁
function alertAndGoBack1($msg){
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

if(!isset($_GET["idL"])){
  echo "請由正式方法進入頁面";
  exit;
}

$id = intval($_GET["idL"]);
$sql = "UPDATE product_type_list SET `isValid` = 0 WHERE product_type_list_id = $id;";

// 寫入資料庫，將結果存在變數 error
$error = "";
try {
  $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $error = "ERROR";
}
$conn->close();

// 由變數 error 來判斷要轉跳回列表，或失敗了回上一頁
if($error === ""){
  alertAndGoToList1("分類刪除成功");
  exit;
}else{
  alertAndGoBack1("分類刪除錯誤：" .$conn->error);
  exit;
}