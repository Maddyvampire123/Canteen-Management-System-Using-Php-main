<?php
$hostname="localhost:3306";
$user_name="root";
$password="admin";
$db="canteen";
$con=mysqli_connect($hostname,$user_name,$password,$db);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
