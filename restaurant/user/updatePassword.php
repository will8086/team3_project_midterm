<?php

session_start();




if (isset($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    // 记得把两个条件合并就可以了，不用nest
    $mysqli = require("../database.php");

    $sql = "SELECT * FROM `restaurant_user` WHERE `restaurant_id` = {$_SESSION["user_id"]}";
 

    $result = $mysqli->query($sql);


    $user = $result->fetch_assoc();


    if ($user) {
        if (password_verify($_POST["password"], $user["restaurant_password_hash"])) {
            if (strlen($_POST["new_password"]) < 6) {
                die("Password must be at least 6 characters");
            } else if (!preg_match("/[a-z]/i", $_POST["new_password"])) {
                die("Password must contain at least one letter");
            } else if (!preg_match("/[0-9]/", $_POST["new_password"])) {
                die("Password must contain at least one number");
            } else if ($_POST["new_password"] !== $_POST["password_confirmation"]) {
                die("Passwords must match");
            } else {
                $password_hash = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

                $sql = "UPDATE `restaurant_user` SET 
                        `restaurant_password_hash` = ?
                        WHERE `restaurant_user`.`restaurant_id` = {$_SESSION["user_id"]}";

                $stmt = $mysqli->stmt_init();

                if (!$stmt->prepare($sql)) {
                    die("SQL error:" . $mysqli->error);
                }

                $stmt->bind_param("s", $password_hash);

                try {
                    if ($stmt->execute()) {
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
        }
        else{
            echo  "<script>
                    alert(`修改失敗，請檢查密碼是否正確！`);
                    window.location.href = \"./userProfile.php\";
                    </script>";
            exit;
        }
    }
}
?>
