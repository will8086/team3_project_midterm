<?php
require("../connect.php");

if(!isset($_POST["email"])){
    echo "請透過正常方式進入";
    exit;
  }
  
$name = $_POST["name"];
$nickname = $_POST["nickname"];
$email = $_POST["email"];
$phone=$_POST["phone"];
$password = $_POST["password"];
$password2 = $_POST["password2"];

$msg="";
$sql="SELECT * FROM `user` WHERE `user_email` = '$email';";
try{
  $result=$conn->query($sql);
  $count = $result->num_rows;
}catch (mysqli_sql_exception $exc) {
  $msg= "資料新增錯誤：" .$exc->getMessage();
}

if($msg!==""){
  alertgoBack("email空白喔!");
  exit;
}

if($count>0){
  alertgoBack("這個email已經有人用過囉!");
}

//上傳圖片
$img = "";
//error=0 沒有錯誤，檔案上傳成功
if($_FILES["myfile"]["error"]==0){
  //取得當下的時間戳記
  $timetemp=time();
  //pathinfo()取得副檔名,PATHINFO_EXTENSION：取得副檔名+name key值取得完整檔名
  $ext=pathinfo($_FILES["myfile"]['name'],PATHINFO_EXTENSION);
  //檔名=當下時間+.+副檔名
  $newfilename=$timetemp . "." .$ext;
  //move_uploaded_file() 函數來搬移上傳的檔案
  //上傳的檔案，會放在 tmp_name裡
  if(move_uploaded_file($_FILES["myfile"]["tmp_name"], "./uimg/".$newfilename)){
    $img=$newfilename;
  }
}

// $password=password_hash($password,PASSWORD_BCRYPT);

$sql = "INSERT INTO `user` 
    (`user_id`, `user_name`,`nickname`,`user_email`,`user_password`,`user_phone`,`user_img`,`create_date`, `updatetime`, `last_login_time`) VALUES 
    ('', '$name','$nickname','$email','$password','$phone','$img',NOW(),NOW(),NOW());";

  try {
    $conn->query($sql);
    $msg= "資料新增成功";
  } catch (mysqli_sql_exception $exc) {
    echo "資料新增錯誤：" .$exc->getMessage();
  }
  $conn->close();

  echo "<script>
          alert(\"$msg\")
            window.location.href=\"../utilities/navbar.php?webpage=user_list.php\";
        </script>";

function alertgoBack($msg2){
echo "<script>
        alert(\"$msg2\")
          window.history.back();
      </script>";
        exit;
      }
