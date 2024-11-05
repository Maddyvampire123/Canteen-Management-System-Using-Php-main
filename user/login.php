<?php
session_start();
$message="";
if(count($_POST)>0) 
{
    include('Connection.php');
    $result = mysqli_query($con,"SELECT * FROM users WHERE User_Id = '" . $_POST["id"] . "' and Password = '". $_POST["pwd"]."';");

    $check = mysqli_num_rows($result);

    if($check > 0) {
        for($i = 0; $i < $check; $i++) {
            $_SESSION["pwd"] = $_POST["pwd"];
            $_SESSION["id"] = $_POST["id"];
        }
    } else {
        $message = "Invalid Username or Password!";
    }
}
if(isset($_SESSION["id"]))
{
    include('file.php');
    if($admin == $_SESSION["id"]) {
        header("Location:ADashboard.php");
    } else {
        header("Location:Dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="./style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <style>
    /* Button Styles */
    .btn {
      display: inline-block;
      padding: 12px 24px;
      font-size: 16px;
      color: white;
      background-color: #28a745;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-transform: uppercase;
      font-weight: bold;
      letter-spacing: 1px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    /* Hover effect */
    .btn:hover {
      background-color: #218838;
      transform: scale(1.05);
    }

    /* Active button state */
    .btn:active {
      background-color: #1e7e34;
      transform: scale(0.98);
    }

    /* Centering the form elements */
    form {
      text-align: center;
    }

    /* Message Styling */
    .message {
      color: red;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
    <br><br><br><br><br><br><br><br><br>
    <div id="bg"></div>

    <form action="" method="post">
        <label for=""></label>
        <input type="text" name="id" id="" placeholder="Username" class="email" required="required">

        <label for=""></label>
        <input type="password" name="pwd" id="" placeholder="Password" class="pass" required="required">

        <button type="submit" class="btn">Login to your account</button>
        <br><br>

        <!-- Styled Signup button -->
        <button type="button" class="btn" onclick="window.location.href='signup.php'">Sign Up</button>
        <br>
        <button type="button" class="btn" onclick="window.location.href='signup.php'">Admin Login</button>
        <br><br>

        <div class="message"> <?php if($message != "") { echo $message; } ?></div>
    </form>

    <script src="js/index.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>
</html>
