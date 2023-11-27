<?php
require_once("../connect.php");

if(!isset($_POST["user_id"])){
    echo "請由正常管道進入";
    exit;
}

$book_id = $_POST["book_id"];
$user_id = $_POST["user_id"];
$restaurant_id = $_POST["restaurant_id"];
$available_date = $_POST["available_date"];
$available_time = $_POST["available_time"];
$customer_nums = $_POST["customer_nums"];

if(empty($user_id)){
    echo "請輸入會員編號";
    echo "<button onclick='goBack()'>回上一頁</button>";
    echo "<script>
    function goBack(){
        window.history.back();
    }
    </script>";
    exit;
}


if($content === ""){
    echo "<script>
    alert(\"請輸入留言\");
    window.history.back();
    </script>";
    exit;
}

$sql = "UPDATE book SET 
`user_id` = $user_id,
`restaurant_id` = $restaurant_id,
`available_date` = '$available_date',
`available_time` = '$available_time',
`customer_nums` = $customer_nums 
WHERE book_id = $book_id;";


try{
    $conn->query($sql);
    $msg = "修改成功!!";
}catch(mysqli_sql_exception $exc){
    $msg = "修改資料錯誤:" .$exc->getMessage();
}

$conn->close();

echo "<script>
alert(\"$msg\");
window.location.href = \"./navbar.php?webpage=book_list.php\";
</script>";