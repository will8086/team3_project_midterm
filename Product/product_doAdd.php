<?php
require_once("../connect.php");

if(!isset($_POST["name"])){
    echo "走開";
    exit;
}

$nameValues= $_POST["name"];
$priceValues= $_POST["price"];
$descValues = $_POST["description"];
$specValues = $_POST["specification"];
$typeValues = $_POST["type"];
$typeListValues = $_POST["typeList"];
$discountValues = $_POST["discount"];


$count = count($nameValues);


// $count2 = count($typeListValues);

// if($count != $count2){
//       alertGoBack("請點選分類!");
//       exit;
//   } 
  // $endWording = ($count>1)?"多筆":"";
  
  // // 檢查表單內容是否填寫
  // if(!isset($_POST["type"])){
  //   alertGoBack("請點選分類!");
  //   exit;
  // }
  $emptyCheck = false;
  
  for($i=0;$i<$count;$i++){
    $name = (isset($nameValues)) ? $nameValues[$i]:"";
    $price = (isset($priceValues)) ? $priceValues[$i]:"";
    $desc = (isset($descValues)) ? $descValues[$i]:"";
    $spec = (isset($specValues)) ? $specValues[$i]:"";
    $type = (isset($typeValues)) ? $typeValues[$i]:"";
    $typeList = (isset($typeListValues)) ? $typeListValues[$i]:"";
    $discount = (isset($discountValues)) ? $discountValues[$i]:"";


    // 數字文字格式檢查也可以都在這一次完成
    if(empty($name)){
      $emptyCheck=true;
  } if(empty($price)){
    $emptyCheck=true;
  } if(empty($desc)){
    $emptyCheck=true;
  } if(empty($spec)){
    $emptyCheck=true;
  }if(empty($type)){
    $emptyCheck=true;
  }if(empty($typeList)){
    $emptyCheck=true;
  }if(empty($discount)){
    $emptyCheck=true;
  }

}

if($emptyCheck === true){

  alertGoBack("請確認輸入欄位!");
  exit;

}

  //上傳檔案
// $imgValues = array();
// $timestamp = time();
// $fileCount = count($_FILES["myFile"]["name"]);

// for($i=0;$i<$fileCount;$i++){
// if($_FILES["myFile"]["error"][$i] == 0){
//   //取得副檔名
//     $ext = pathinfo($_FILES["myFile"]["name"][$i],PATHINFO_EXTENSION);
//   //設定統一檔名 > 時間戳記加.副檔名
//     $file = ($timestamp + $i).".".$ext;

//     $result = move_uploaded_file($_FILES["myFile"]["tmp_name"][$i],"./img/".$file);
//     //有成功移動檔案的話，把檔案名稱放進$imgValues變數中成為一個(圖片名)陣列
//     if($result){

//         $pathFile = $file;
//         array_push($imgValues,$pathFile);

//     }else{
//       array_push($imgValues, NULL);
//     }
// }}   
// if($discount == ""){

  // $sql="";
  // for($i=0;$i<$count;$i++){
  //   // 取出寫成資料庫內容時將標籤<>等轉為文字格式
  //   $name = htmlspecialchars($nameValues[$i]);
  //   $desc = htmlspecialchars($descValues[$i]);
  //   $spec = htmlspecialchars($specValues[$i]);
  //   //??? $category = intval($categoryValues[$i]);

  //   // $img = $imgValues[$i];
  //   $sql.=
  //   "INSERT INTO `product` (`product_id`, `product_name`, `price`, `product_description`, `specification`, `product_type_id`, `product_type_list_id`, `isValid`) VALUES (NULL, '$name', '$price', '$desc', '$spec', '$type', '$typeList', '1');";        
  // }
  
// }else{
  
  $sql="";
  for($i=0;$i<$count;$i++){
    // 取出寫成資料庫內容時將標籤<>等轉為文字格式
    $name = htmlspecialchars($nameValues[$i]);
    $desc = htmlspecialchars($descValues[$i]);
    $spec = htmlspecialchars($specValues[$i]);
    //??? $category = intval($categoryValues[$i]);
    
    // $img = $imgValues[$i];
    $sql.=
    "INSERT INTO `product` (`product_id`, `product_name`, `price`, `product_description`, `specification`, `product_type_id`, `product_type_list_id`, `discount_rate_id`, `isValid`) VALUES (NULL, '$name', '$price', '$desc', '$spec', '$type', '$typeList', '$discount', '1');";        
  }

// }


// try{
//     $conn->multi_query($sql);
   
//   }catch(mysqli_sql_exception $exc){
//     echo "修改資料表失敗" .$exc->getmessage();
//   }


// // exit;
//   $conn->close();



try{
    $conn->multi_query($sql);
   $msg="新增成功!!!";
  }catch(mysqli_sql_exception $exc){
     $msg="新增失敗" .$exc->getmessage();
  }

  $conn->close();

echo "<script>
alert(\"$msg\");
window.location.href = \"../utilities/navbar.php?webpage=product_list.php\"
</script>";

  
// echo "<script>
// alert (\" $msg 新增成功!\");
// window.location.href = \"../utilities/navbar.php?webpage=product_list.php\"
// </script>";

function alertGoBack($msg2){
    echo "<script>
    alert (\"$msg2\");
    window.history.back();
    </script>";
  }