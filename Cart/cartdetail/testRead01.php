<?php
//將表單內容送出後, 新增至資料庫

require_once("../connect.php");

//沒有要輸入資料進來, 因此不需要
// if(!isset($_POST["product_id"])){
//     echo "請由正常管道進入";
//     exit;
// }

//也無需寫入資料庫, 因此無需變數
// $cart_id = $_POST["cart_id"];
// $product_id = $_POST["product_id"];
// $quantity = $_POST["quantity"];

$sql = "SELECT * FROM `CartProduct_detail`;";

try{
//使用result來承接內容
 $result = $conn->query($sql);
 //讀取成功後, 跳到錯誤或例外的區域
//  throw new Exception("TEST");
 echo "讀取成功";
}catch(mysqli_sql_exception $exc){
 die("讀取失敗:" .$exc->getMessage());
} catch(Exception $exc){
 echo "錯誤或例外" .$exc->getMessage();
}

$conn->close();

$msgNum = $result -> num_rows;


if($msgNum > 0):
  echo "一共有 $msgNum 筆資料<br>";
    while($row = $result->fetch_assoc()):
        echo "<pre>";
        var_dump($row);
        echo "</pre>";
    endwhile;
endif;

?>