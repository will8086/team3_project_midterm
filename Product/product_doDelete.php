

<?php
require_once("../connect.php");

if(!isset($_GET["id"])){
    echo "走開";
    exit;
}
$id=$_GET["id"];


//硬刪除
$sql="DELETE FROM `product` WHERE `product`.`product_id` = $id";
//軟刪除
// $sql="UPDATE `msgs` SET `isValid` = '0' WHERE `msgs`.`id` = $id;";


try{
    $conn->query($sql);
   $msg="刪除成功!!!";
  }catch(mysqli_sql_exception $exc){
    // echo "修改資料表失敗" .$exc->getmessage();
    //exit;
    //上面兩句=die("修改資料表失敗" .$exc->getmessage());
    $msg="刪除失敗" .$exc->getmessage();
  }

  $conn->close();

  echo "<script>
alert (\"$msg\");
window.location.href = \"../utilities/navbar.php?webpage=product_list.php\"
</script>";

