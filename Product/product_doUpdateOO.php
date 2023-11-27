<?php
require_once("../connect.php");

if(!isset($_POST["name"])){
    echo "走開";
    exit;
}
$id=$_POST["id"];

$name = $_POST["name"];
$price= $_POST["price"];
$desc = $_POST["description"];
$spec = $_POST["specification"];
$type = $_POST["type"];
$typeList = $_POST["typeList"];
$discount = $_POST["discount"];
$isValid = $_POST["isValid"];

// $count = count($nameValues);
// $endWording = ($count>1)?"多筆":"";


// X
if(empty($name)){
    echo "<script>
    alert(\"請輸入商品名稱\");
    window.history.back();
    </script>";
    exit;
}
// V
if($price ===""){

    echo "<script>
    alert(\"請輸入價格\");
    window.history.back();
    </script>";
    exit;
}
if($desc ===""){

    echo "<script>
    alert(\"請輸入商品介紹\");
    window.history.back();
    </script>";
    exit;
}
if($spec ===""){

 echo "<script>
 alert(\"請輸入商品規格\");
 window.history.back();
 </script>";
 exit;
}
if($type ===""){

 echo "<script>
 alert(\"請點選分類\");
 window.history.back();
 </script>";
 exit;
}
if($typeList ===""){

 echo "<script>
 alert(\"請點選次分類\");
 window.history.back();
 </script>";
 exit;
}
if($discount ===""){

 echo "<script>
 alert(\"請輸入折扣數\");
 window.history.back();
 </script>";
 exit;
}
if($isValid !== "0" && $isValid !== "1"){

 echo "<script>
 alert(\"商品是否上架\");
 window.history.back();
 </script>";
 exit;
}


// $img = "";
// if($_FILES["myFile"]["error"] == 0){
//     $ext = pathinfo($_FILES["myFile"]["name"],PATHINFO_EXTENSION);
//     $timestamp = time();
//     $file = $timestamp.".".$ext;
//     $result = move_uploaded_file($_FILES["myFile"]["tmp_name"],"../product_img/".$file);
//     echo "222";
//     if($result){
//         $img = $file;
//     }
// }

$sql="UPDATE product SET 
    `product_name` = '$name',
    `price` = $price, 
    `product_description` = '$desc',
    `specification` = '$spec', 
    `product_type_id` = '$type', 
    `product_type_list_id` = '$typeList',
    `discount_rate_id` = '$discount',
    `isValid` = '$isValid'
    WHERE product_id = $id;";


try{
    $conn->query($sql);
   $msg="修改成功!!!";
  }catch(mysqli_sql_exception $exc){

    $msg="修改失敗" .$exc->getmessage();
  }

  $conn->close();

echo "<script>
alert(\"$msg\");
window.location.href = \"../utilities/navbar.php?webpage=product_list.php\"
</script>";