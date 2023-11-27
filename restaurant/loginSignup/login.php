<?php 
$is_invalid = false;

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $mysqli = require("../database.php");


    $sql = sprintf("SELECT * FROM `restaurant_user` WHERE restaurant_email = '%s'",
    $mysqli -> real_escape_string($_POST["email"]));


    $result = $mysqli -> query($sql);


    $user = $result -> fetch_assoc();



    if($user){
        if(password_verify($_POST["password"], $user["restaurant_password_hash"])){
            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["restaurant_id"];

            header("Location: ../index.php");
            exit;
        }
    }

    $is_invalid = true;
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>餐廳登入系統</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/signup.css">
    <style>
        .bgg{
            background-color: #777e5c;
        }
    </style>
</head>

<body>
    <h1 class="text-center my-3">Log in</h1>

    <?php if($is_invalid): ?>
        <p class="fst-italic text-center text-danger">Incorrect email or password.</p>
    <?php endif; ?>

    <div class="loginbox border border-dark-subtle rounded bg-light">
        <form  method="post">
            <div class="d-flex flex-column">
                <label for="email">Email:</label>
                <input class="my-3 rounded" type="email" id="email" name="email" value=<?=htmlspecialchars($_POST["email"]??"") ?>>

            </div>
            <div class="d-flex flex-column">
                <label for="password">Password:</label>
                <input class="my-3 rounded" type="password" id="password" name="password">
            </div>
            <button type="submit" class="btn bgg my-3">Log in</button>
        </form>
    </div>
    
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>