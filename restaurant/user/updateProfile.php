<?php
session_start();
// print_r($_SESSION);

if(isset($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] === "POST" ){

    $mysqli = require("../database.php");

    $file = $_FILES['imgfile'];
    $fileName = $_FILES['imgfile']['name'];
    $fileTmpName = $_FILES['imgfile']['tmp_name'];
    $fileSize = $_FILES['imgfile']['size'];
    $fileError = $_FILES['imgfile']['error'];
    $fileType = $_FILES['imgfile']['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));


    $allowed = array('jpg','jpeg','png','webp');

    if(in_array($fileActualExt,$allowed)){
        if ($fileError === 0){
            if ($fileSize < 1000000){
                $fileNameNew = uniqid('',true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName,$fileDestination);
            }
            else{
                echo"太大了！！！";
            }
        }
        else{
            echo "There was an error uploading your file.";
        }
    }
    else{
        echo "you can't upload files of this type.";
    }
    



    $sql = "UPDATE `restaurant_user` SET 
    `restaurant_name` = ?,
    `restaurant_email` = ?,
    `restaurant_phonenumber` = ?,
    `restaurant_address` = ?,
    `Introduction` = ?,
    `img_file` = ?

    WHERE `restaurant_user`.`restaurant_id` = {$_SESSION["user_id"]}";
    
    $stmt = $mysqli ->  stmt_init();

    if(!$stmt-> prepare($sql)){
        die("SQL error:". $mysqli->error);
    }

    $stmt->bind_param("ssisss",$_POST["name"],$_POST["email"],$_POST["phone"],$_POST["address"],$_POST["intro"],$fileDestination);

    try {
        if($stmt->execute()){
            echo  "<script>
            alert(`修改成功`);
            window.location.href = \"./userProfile.php\";
            </script>";
            exit;
        }
    } catch (mysqli_sql_exception $exception) {
        die("Update failed: " . $exception->getMessage());
    }
}
?>