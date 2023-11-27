<?php
// 用來上傳多張圖片用
require_once("../connect.php");

if(!isset($_GET["id"])){
echo "請由正常管道進入";
exit;
}else{
$id = $_GET["id"];
}


$sql = "";
$timestamp = time();
$fileCount = count($_FILES["imgFile"]["name"]);
for($i=0; $i<$fileCount; $i++){
if($_FILES["imgFile"]["error"][$i] == 0){
$ext = pathinfo($_FILES["imgFile"]["name"][$i], PATHINFO_EXTENSION);
$file = ($timestamp + $i) ."." .$ext;
$pathFile = "./img/" .$file;
$result = move_uploaded_file($_FILES["imgFile"]["tmp_name"][$i], "./img/" .$file);
if($result){
$sql .="INSERT INTO `postimage`
(`postimage_ID`, `postID`, `postimage_name`, `post_image_isValid`)
VALUES
(NULL, '$id', '$pathFile', '1');";
}
}
}


try{
$conn->multi_query($sql);
$msg = "資料新增成功";
}catch(mysqli_sql_exception $exc){
$msg = "資料新增錯誤：" .$exc->getMessage();
}

$conn->close();

echo "<script>
alert(\"$msg\");
window.location.href = \"../utilities/navbar.php?webpage=post_ArticleList.php\";
</script>";
