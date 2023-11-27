<?php
require_once("../connect.php");
session_start();

if(!isset($_POST["name"])){
echo "請由正式方法進入頁面";
exit;
}

$id =$_POST["id"];
$name = $_POST["name"];
$content = $_POST["content"];
$updating_restaurant_ID = $_POST["updating_restaurant_ID"];
$restaurant_name = $_POST["updating_restaurant_name"];
$user_ID=$_SESSION["user"]["id"];
$price_range_ID=$_POST["price_range_ID"];

$img = "";
if($_FILES["myFile"]["error"] == 0){
$ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
$timestamp = time();
$file = $timestamp ."." .$ext;
// $result = move_uploaded_file($_FILES["myFile"]["tmp_name"], "./img/" .$file);

$result = move_uploaded_file($_FILES["myFile"]["tmp_name"], "./img/" .$file);
// echo("./img/".$file);
// var_dump($result);
// exit;
if($result){
$img = "./img/" .$file;
}
}


$sql ="INSERT INTO `post`
(`post_title`, `post_content`, `img`,`updating_restaurant_ID`, `restaurant_name`, `price_range_ID`, `create_time`, `user_ID`, `editing_date`, `flag_ID`, `postisValid`)
VALUES
('$name', '$content', '$img','$updating_restaurant_ID', '$restaurant_name', '$price_range_ID', current_timestamp(), '$user_ID' , NULL, 1, 1);";



try {
$conn->query($sql);
echo "資料新增成功";
} catch (mysqli_sql_exception $exception) {
echo "資料新增錯誤：" .$exception->getMessage();
}

$conn->close();

echo "<script>
alert(\"資料新增成功\")
window.location.href = \"../utilities/navbar.php?webpage=post_ArticleList.php\";
</script>";
function alertGoBack(){
echo "<scrip>
alert(\"新增錯誤\");
window.history.back();
</script>";
}

?>
