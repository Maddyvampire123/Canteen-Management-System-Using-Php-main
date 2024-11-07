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
        // Insert new user into the database, setting Wallet to 0.00 by default
        $sql = "INSERT INTO users (User_Id, First_Name, Last_Name, Dob, Password, Phone, Mail, Wallet)
                VALUES ('" . $_POST["id"] . "', '" . $_POST["fname"] . "', '" . $_POST["lname"] . "', '" . $_POST["dob"] . "', '" . $_POST["pwd"] . "', '" . $_POST["phone"] . "', '" . $_POST["mail"] . "', 0.00)";
        
        if (mysqli_query($con, $sql)) {
            $_SESSION["id"] = $_POST["id"];
            header("Location: Dashboard.php");
            exit; // Ensure script stops after redirection
        } else {
            $message = "Error in registration: " . mysqli_error($con);
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

        <input type="text" name="fname" placeholder="First Name" class="email" required="required">

        <input type="text" name="lname" placeholder="Last Name" class="email" required="required">

        <input type="date" name="dob" placeholder="Date of Birth" class="email" required="required">

        <input type="password" name="pwd" placeholder="Password" class="pass" required="required">

        <input type="text" name="phone" placeholder="Phone" class="email" required="required">

        <input type="email" name="mail" placeholder="Email" class="email" required="required">

        <button type="submit">Create an account</button>
        <br><br>
        <div class="message"> <?php if($message != "") { echo $message; } ?> </div>
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

        // First name and Last name validation
        if (fname.trim() === "" || lname.trim() === "") {
            message += "First Name and Last Name are required.\n";
        }

        // Date of Birth validation (must be a past date)
        if (new Date(dob) >= new Date()) {
            message += "Date of Birth must be a past date.\n";
        }

        // Password validation (minimum 8 characters, at least one letter and one number)
        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!passwordPattern.test(pwd)) {
            message += "Password must be at least 8 characters long and include at least one letter and one number.\n";
        }

        // Phone validation (only numbers, minimum 10 digits)
        const phonePattern = /^[0-9]{10,}$/;
        if (!phonePattern.test(phone)) {
            message += "Phone number must be at least 10 digits long and contain only numbers.\n"; 
        }

        // Email validation
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(mail)) {
            message += "Please enter a valid email address.\n";
        }

        // Display validation messages
        if (message) {
            alert(message);
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }

    // Attach validateForm to the form's submit event
    document.forms[0].onsubmit = validateForm;
    </script>

</body>
</html>
