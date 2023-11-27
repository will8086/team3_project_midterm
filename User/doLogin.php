<?php
//引用連線檔案
session_start();
require("../connect.php");
//使用 POST 變數中的 email 檢查是不是正常方式進來的
if(!isset($_POST["email"])){
    alertgoBack("請透過正常方式進入");
    exit;
  }

//把 POST 變數中的電郵、密碼取出放進同名變數裡
$useremail = $_POST["email"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];


$msg="";//回應訊息
//抓取變數並搜尋資料庫內的相同資料
$sql="SELECT * FROM `user` WHERE `user_email` = '$useremail';";


try{
    $result=$conn->query($sql);//執行$sql並將結果存在$result
    $row=$result->fetch_assoc();//將$result以關聯陣列存$row
    if($result->num_rows>0){//如果資料>0
        if($password1=$row["user_password"]){//password_verify()<--解析加密密碼
            // $msg=true;
            $_SESSION["user"]=[
                "id"=>$row["user_id"],
                "email"=>$row["user_email"],
                "name"=>$row["user_name"],
                "img"=>$row["user_img"],
                "nickname"=>$row["nickname"],
                "phone"=>$row["user_phone"],
                "selfintr"=>$row["self_intr"],
                "createdate"=>$row["create_date"],
                "updatetime"=>$row["updatetime"],
                "lastlogintime"=>$row["last_login_time"],               
            ];
            //轉到這一頁
            header("location:../utilities/navbar.php");
        }else{
            $msg="不要再試惹!!";
        }
    }else{
        $msg="沒有這個人!!";
    }
  }catch (mysqli_sql_exception $exc) {
    $msg= "發生錯誤請洽管理人員";
  }

//檢查登錄是否有錯，如果有錯，則彈出視窗顯示錯誤信息並返回上一頁；如果登錄成功，則將使用者資料存在 $_SESSION。  
if($msg !==""){
    alertgoBack($msg);
}

//跳視窗回上一頁
function alertgoBack($msg){
    echo "<script>
            alert(\"$msg\")
                window.history.back();
        </script>";
    exit;
}