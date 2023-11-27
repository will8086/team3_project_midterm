<?php
require_once("../connect.php");

if(!isset($_POST["id"])){
echo "請由正常管道進入";
exit;
}
$id = $_POST["id"];
$name = $_POST["name"];
$content = $_POST["content"];
$updating_restaurant_ID =$_POST["updating_restaurant_ID"];
$restaurant_name =$_POST["updating_restaurant_name"];

if(empty($name)){
echo "請輸入標題";
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
alert(\"請輸入內文\");
window.history.back();
</script>";
exit;
}

if($restaurant === ""){
echo "<script>
alert(\"請輸入餐廳名\");
window.history.back();
</script>";
exit;
}

$img = "";
if($_FILES["myFile"]["error"] == 0){
$ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
$timestamp = time();
$file = $timestamp ."." .$ext;
$result = move_uploaded_file($_FILES["myFile"]["tmp_name"], "./img/" .$file);
if($result){
$img = "./img/" .$file;
}
}

if($img == ""){
$sql = "UPDATE `post` SET
`post_title` = '$name',
`post_content` = '$content',
`restaurant_name` = $restaurant_name,
`editing_date` = CURRENT_TIMESTAMP
WHERE post_ID = $id;";
}else{
$sql = "UPDATE post SET
`post_title` = '$name',
`post_content` = '$content',
`restaurant_name` = $restaurant_name,
`img` = '$img',
`editing_date` = CURRENT_TIMESTAMP
WHERE post_ID = $id;";
}

try{
$conn->query($sql);
$msg = "修改成功!!";
}catch(mysqli_sql_exception $exc){
$msg = "修改資料錯誤：" .$exc->getMessage();
}

$conn->close();

echo "<script>
alert(\"$msg\");
window.location.href = \"./navbar.php?webpage=post_ArticleList.php\";
</script>";


?>
