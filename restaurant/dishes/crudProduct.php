<?php
session_start();
// print_r($_SESSION);

if (isset($_SESSION["user_id"])) {
    $mysqli = require("../database.php");

    if (isset($_POST["editName"]) && isset($_POST["editPrice"]) && isset($_POST["editDescription"]) && isset($_POST["editDishesId"])) {

        $editName = $_POST["editName"];
        $editPrice = $_POST["editPrice"];
        $editDescription = $_POST["editDescription"];
        $editDishesId = $_POST["editDishesId"];

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



        $editSql = "UPDATE `restaurant_dishes` SET `dishes_name` = ?, `price` = ?, `description` = ?, `img_file` = ? WHERE `dishes_id` = ?";
        $stmt = $mysqli->prepare($editSql);

        if (!$stmt) {
            die("SQL error: " . $mysqli->error);
        }

        $stmt->bind_param("sissi", $editName, $editPrice, $editDescription,$fileDestination, $editDishesId);

        try {
            if ($stmt->execute()) {

                header("Location: ./product.php?success=updated");
                exit;
            }
        } catch (mysqli_sql_exception $exception) {
            die("Update failed: " . $exception->getMessage());
        }
    } 
    else if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
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
            

            $sql = "INSERT INTO `restaurant_dishes`(`restaurant_id`, `dishes_name`, `price`, `description`, `img_file`) VALUES (?,?,?,?,?)";

            $stmt = $mysqli ->  stmt_init();

            if(!$stmt-> prepare($sql)){
                die("SQL error:". $mysqli->error);
            }
            
            $stmt -> bind_param("isiss",$_SESSION["user_id"],$_POST["name"],$_POST["price"],$_POST["description"],$fileDestination);

            try {
                if ($stmt->execute()) {
                    header("location: ./product.php?success=added");
                    exit;
                } 
            } catch (mysqli_sql_exception $exception) {
                die("Update failed: " . $exception->getMessage());
            }

            }


    if (isset($_SESSION["user_id"]) && isset($_GET['del']) && $_GET['del'] > 0) {
    
        $mysqli = require("../database.php");

        $dishesId = $_GET['del'];
    
 
        $sql = "DELETE FROM `restaurant_dishes` WHERE `dishes_id` = ?";
    
        $stmt = $mysqli ->  stmt_init();
    
        if(!$stmt-> prepare($sql)){
            die("SQL error:". $mysqli->error);
        }
        
        $stmt -> bind_param("i",$dishesId);
    
        try {
            if ($stmt->execute()) {

                header("location: ./product.php?success=deleted");
                exit;
            }
        } catch (mysqli_sql_exception $exception) {
            die("Delete failed: " . $exception->getMessage());
        }
    }
    
}
?>