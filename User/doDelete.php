<?php
require_once("../connect.php");

if(!isset($_GET["id"])){
    echo "請透過正常方式進入";
    exit;
  }
  
  $id=$_GET["id"];

//   $sql="DELETE FROM msgs WHERE `msgs`.`id` = $id";
  $sql="UPDATE `user` SET `isValid` = '0' WHERE `user_id` = $id;";
  try {
    $conn->query($sql);
    $msg= "刪除成功";
    }catch (mysqli_sql_exception $exc) {
        $msg="刪除資料錯誤:" .$exc->getMessage();
      }
    $conn->close();

  echo "<script>
        alert(\"$msg\")
        window.location.href =\"../utilities/navbar.php?webpage=user_list.php\";
        </script>";