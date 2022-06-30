<?php
//delete 1 products

//khai báo database
$severName= "localhost";
$userName = "root";
$password = "";
$dbName = "quanlysanpham";

//connect db
$conn = new mysqli($severName, $userName, $password, $dbName);

//error -> die
if($conn->connect_error){
    die($conn->connect_error);  //die() = break;
}

//truy vấn xoá một product
$sql_txt = "DELETE FROM crud WHERE ID = " . $_GET["ID"];
$stt = $conn->query($sql_txt);

header("Location: list-product.php");