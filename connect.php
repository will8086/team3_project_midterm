<?php
$servername="localhost";
$username="root";
$password="";
$dbname="team3project";
$port="3306";

try{
    $conn=new mysqli($servername,$username,$password,$dbname,$port);
}catch(mysqli_sql_exception $exc){
    die("連線失敗:" .$exc->getMessage());
}