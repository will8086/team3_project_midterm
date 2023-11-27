<?php
require_once("../connect.php");

if(!isset($_GET["id"])){
    echo "請由正常管道進入";
    exit;
}

$id = $_GET["id"];

$sql = "UPDATE `book` SET `book_isValid` = '0' WHERE `book`.`book_id` = $id;";

try{
    $conn->query($sql);
    $msg = "刪除成功!!";
}catch(mysqli_sql_exception $exc){
    $msg = "刪除錯誤:".$exc->getMessage();
}
  
$conn->close();

echo "<script>
alert(\"$msg\");
window.location.href = \"./navbar.php?webpage=book_list.php\";
</script>";
