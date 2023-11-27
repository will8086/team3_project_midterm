<?php
require_once("../connect.php");
// require_once("./utilities/alertFunc.php");

if (!isset($_GET["id"])) {
  echo "請由正式方法進入頁面";
  exit;
}
$msg = "";
$id = $_GET["id"];
// $pid = $_GET["pid"];
$img = $_GET["img"];


$sql = "SELECT * FROM `product_img` WHERE `product_img` = '$img';";
$sqlDel = "DELETE FROM `product_img` WHERE `product_img`.`product_img` = '$img';";
// DELETE FROM `product_img` WHERE `product_img`.`product_img` = '1690444295.png';

$file = "";

try {
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $conn->query($sqlDel);
  
  $file = "../Product/product_img/".$row["product_img"];
  $result = $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $row = "ERROR";
}
// echo $file;


if($file!=""){
  try {
    deleteFile($file);
    $msg = "檔案已成功刪除";
  } catch (Exception $e) {
    $msg = $e->getMessage();
  }
}
// $url = "../utilities/navbar.php?webpage=product_updateOO.php&id=$id";
// alertAndBackToPage($msg, $url);


function deleteFile($file) {
  if(file_exists($file)) {
    if(!unlink($file)) {
      throw new Exception("檔案刪除失敗");
    }
  }else{
    throw new Exception("檔案不存在");
  }
}
echo "<script>
alert(\"$msg\");
window.location.href = \"../utilities/navbar.php?webpage=product_updateOO.php&id=$id\"
</script>";
?>