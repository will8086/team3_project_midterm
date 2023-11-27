<?php
require_once("../connect.php");

if (!isset($_POST["id"])) {
  echo "請透過正常方式進入";
  exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$password = $_POST["password"];
$nickname = $_POST["nickname"];
$phone = $_POST["phone"];
$selfintr = $_POST["selfintr"];
$foodtagid = $_POST["food_tag_id"];
$foodtagids = $_POST["likefoodtag"];

// $level =intval($_POST["level"]);

//檢查密碼
$pwdCheck = false;
$sql = "SELECT * FROM `user` WHERE `user_id` = $id;";
try {
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} catch (mysqli_sql_exception $exc) {
  $pwdCheck = $exc->getMessage();
}

$img = "";
if ($_FILES["myfile"]["error"] == 0) {
  $ext = pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION);
  $timestamp = time();
  $file = $timestamp . "." . $ext;
  $result = move_uploaded_file($_FILES["myfile"]["tmp_name"], "./uimg/" . $file);
  if ($result == true) {
    $img = $file;
  }
};

if ($img == "") {
  $sql = "UPDATE user SET 
    `user_name` = '$name',
    `user_password`='$password',
    `nickname`='$nickname',
    `user_phone`='$phone',
    `self_intr`='$selfintr',
    `updatetime`=NOW()
      WHERE `user_id` = $id;";
} else {
  $sql = "UPDATE user SET
  `user_name` = '$name',
  `user_password`='$password',
  `nickname`='$nickname',
  `user_phone`='$phone',
  `user_img`='$img ',
  `self_intr`='$selfintr',
  `updatetime`=NOW()
    WHERE `user_id` = $id;";
}


try {
  $conn->query($sql);
  // 更新 user_tag 資料表
  // 先刪除原有的使用者食物種類標籤
  $delSql = "DELETE FROM `user_tag` WHERE `user_id` = $id;";
  $conn->query($delSql);
  // 再新增使用者選擇的食物種類標籤
  foreach ($foodtagids as $foodtagid) {
    $tagInsertSql = "INSERT INTO `user_tag` (`user_tag_id`,`user_id`, `food_tag_id`) VALUES (NULL,$id, $foodtagid);";
    $conn->query($tagInsertSql);
  }
  $msg = "修改成功";
} catch (mysqli_sql_exception $exc) {
  $msg = "修改資料錯誤:" . $exc->getMessage();
}

// try {
//   $conn->query($sql);
//   $msg= "修改成功";
// } catch (mysqli_sql_exception $exc) {
//   //echo "資料修改錯誤：" .$exc->getMessage();
//   //exit;
//   //上面兩句=die
//   $msg="修改資料錯誤:" .$exc->getMessage();
// }
$conn->close();

echo "<script>
        alert(\"$msg\")
          window.location.href=\"../utilities/navbar.php?webpage=user_list.php\";
        </script>";

function alertgoBack($msg2)
{
  echo "<script>
      alert(\"$msg2\")
      window.history.back();
      </script>";
  exit;
}
