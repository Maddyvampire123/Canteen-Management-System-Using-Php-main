<?php
session_start();
$message = "";
if (count($_POST) > 0) {
    include('Connection.php');
    
    // Check if the username already exists
    $result = mysqli_query($con, "SELECT * FROM users WHERE User_Id = '" . $_POST["id"] . "'");
    $check = mysqli_num_rows($result);
    
    if ($check > 0) {
        $message = "Username already exists!";
    } else {
        // Insert new user into the database without the Wallet field
        $sql = "INSERT INTO users (User_Id, First_Name, Last_Name, Dob, Password, Phone, Mail)
                VALUES ('" . $_POST["id"] . "', '" . $_POST["fname"] . "', '" . $_POST["lname"] . "', '" . $_POST["dob"] . "', '" . $_POST["pwd"] . "', '" . $_POST["phone"] . "', '" . $_POST["mail"] . "')";
        
        if (mysqli_query($con, $sql)) {
            $_SESSION["id"] = $_POST["id"];
            header("Location:Dashboard.php");
        } else {
            $message = "Error in registration!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="./style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
    <br><br><br><br><br><br><br><br><br>
    <div id="bg"></div>

    <form action="" method="post">
        <input type="text" name="id" placeholder="Username" class="email" required="required">

        <input type="password" name="pwd" placeholder="Password" class="pass" required="required">
        <button type="submit" class="btn">Login to your account</button>
        <br><br>
</form>
<script src="js/index.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script>
    function validateForm() {
        let id = document.forms[0]["id"].value;
        let fname = document.forms[0]["fname"].value;
        let lname = document.forms[0]["lname"].value;
        let dob = document.forms[0]["dob"].value;
        let pwd = document.forms[0]["pwd"].value;
        let phone = document.forms[0]["phone"].value;
        let mail = document.forms[0]["mail"].value;
        let message = "";

         // Username validation
         if (id.length < 5) {
            message += "Username must be at least 5 characters long.\n";
         }
         // Password validation (minimum 8 characters, at least one letter and one number)
        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!passwordPattern.test(pwd)) {
            message += "Password must be at least 8 characters long and include at least one letter and one number.\n";
        }
        </body>
</html>
