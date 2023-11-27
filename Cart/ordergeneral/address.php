<?php

require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // 取得前端送來的表單資料
  $city = $_POST["city"];
  $district = $_POST["district"];
  $address = $_POST["address"];

  // 將資料寫入資料庫（這裡只是一個範例，實際上要依賴你的資料庫結構和連接方式）
  
  $sql = "INSERT INTO delivery_address (city, district, address) VALUES ('$city', '$district', '$address')";
  mysqli_query($conn, $sql);
}
?>