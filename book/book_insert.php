<?php
require_once("../connect.php");

if(!isset($_POST["user_id"])){
    echo "請由正常管道進入";
    exit;
}

$user_id_values = $_POST["user_id"];
$restaurant_id_values = $_POST["restaurant_id"];
$available_date_values = $_POST["available_date"];
$available_time_values = $_POST["available_time"];
$customer_nums_values = $_POST["customer_nums"];

$count = count($user_id_values);

$endWording = ($count>1)?"多筆":"";

$sql = "";
for($i=0; $i<$count; $i++){
    $user_id = $user_id_values[$i];
    $restaurant_id = $restaurant_id_values[$i];
    $available_date = $available_date_values[$i];
    $available_time = $available_time_values[$i];
    $customer_nums = $customer_nums_values[$i];
    $sql .= "INSERT INTO `book` (`book_id`, `user_id`, `restaurant_id`, `available_date`, `available_time`, `customer_nums`, `book_create_time`)
     VALUES 
    (NULL, '$user_id', '$restaurant_id','$available_date','$available_time','$customer_nums', CURRENT_TIMESTAMP);";
}

try{
  $conn->multi_query($sql);
  echo "資料新增成功";
}catch(mysqli_sql_exception $exc){
  echo "資料新增錯誤：" .$exc->getMessage();
}

$conn->close();

echo "<script>
alert(\"資料新增 $endWording 成功\");
window.location.href = \"./navbar.php?webpage=book_list.php\";
</script>";
