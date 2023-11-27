<?php
// print_r($_POST);
// $_POST为关联阵列，列印出来看有没有成功submit
if(empty($_POST["name"])){
die("Name is required");
}
else if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
    die("E-mail is not valid");
}
else if(strlen($_POST["password"]) < 6){
    die("Password must be at least 6 characters") ;
}
else if(!preg_match("/[a-z]/i",$_POST["password"])){
    die ("Password must contain at least one letter");
}
else if(!preg_match("/[0-9]/",$_POST["password"])){
    die ("Password must contain at least one number");
}
else if($_POST["password"] !== $_POST["password_confirmation"]){
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"],PASSWORD_DEFAULT);

$mysqli = require("../database.php");
// 解决相对路径问题

$sql = "INSERT INTO restaurant_user (restaurant_name,restaurant_password_hash,	restaurant_email) VALUES (?,?,?)";

$stmt = $mysqli ->  stmt_init();

if(!$stmt-> prepare($sql)){
    die("SQL error:". $mysqli->error);
}

$stmt -> bind_param("sss",$_POST["name"],$password_hash,$_POST["email"]);

try {
    if ($stmt->execute()) {
        header("Location: signupSuccess.php");
        exit;
    } 
} catch (mysqli_sql_exception $exception) {
    die("Signup failed: " . $exception->getMessage());
}


?>