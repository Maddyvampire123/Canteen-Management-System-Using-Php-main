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
  <style>
    /* Modal background overlay */
    #modalOverlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
    }

    /* Custom Alert Box */
    #customAlert {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      
      padding: 25px 30px;
      width: 350px;
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
      border-radius: 12px;
      text-align: center;
      z-index: 1001;
      opacity: 0;
      transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    /* Show animation */
    #customAlert.show {
      display: block;
      opacity: 1;
      transform: translate(-50%, -50%) scale(1);
    }

    /* Alert Colors */
    #customAlert.error {
      background: linear-gradient(145deg, #4caf50, #388e3c);
      color: #fff;
    }

    #customAlert.success {
      background: linear-gradient(145deg, #4caf50, #388e3c);
      color: #fff;
    }

    #customAlert.warning {
      background: linear-gradient(145deg, #ff9800, #f57c00);
      color: #fff;
    }

    /* OK button */
    #customAlert button {
      margin-top: 15px;
      padding: 12px 25px;
      background-color: #fff;
      color: #333;
      border: 2px solid #ddd;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    #customAlert button:hover {
      background-color: #ddd;
      transform: scale(1.05);
    }

    /* Input Fields Styling */
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 16px;
      transition: border 0.3s ease;
    }

    input:focus {
      border-color: #007BFF;
      outline: none;
    }

    /* Button Styling */
    button {
      width: 100%;
      padding: 12px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
    <br><br><br><br><br><br><br><br><br>
    <div id="bg"></div>

    <!-- Modal Overlay -->
    <div id="modalOverlay"></div>

    <!-- Custom Alert Box -->
    <div id="customAlert">
      <p id="alertMessage"></p>
      <button onclick="closeAlert()">OK</button>
    </div>

    <form action="" method="post">
        <input type="text" name="id" placeholder="Username" class="email" required="required" onblur="validateUsername()" onfocus="checkField('id')" id="usernameField">
        <input type="text" name="fname" placeholder="First Name" class="email" required="required" onblur="validateName()" onfocus="checkField('fname')" id="fnameField">
        <input type="text" name="lname" placeholder="Last Name" class="email" required="required" onblur="validateName()" onfocus="checkField('lname')" id="lnameField">
        <input type="password" name="pwd" placeholder="Password" class="pass" required="required" onblur="validatePassword()" onfocus="checkField('pwd')" id="pwdField">
        <input type="text" name="phone" placeholder="Phone" class="email" required="required" onblur="validatePhone()" onfocus="checkField('phone')" id="phoneField">
        <input type="email" name="mail" placeholder="Email" class="email" required="required" onblur="validateEmail()" onfocus="checkField('mail')" id="mailField">
        <button type="submit">Create an account</button>
        <br><br>
        <div class="message"> <?php if($message != "") { echo $message; } ?> </div>
    </form>

    <script src="js/index.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script>
      let formFields = document.querySelectorAll("input");
      let currentField = null;

      // Function to show alert with custom message and color
      function showAlert(message, type = "error") {
        const alertBox = document.getElementById("customAlert");
        const alertMessage = document.getElementById("alertMessage");
        
        // Set the message
        alertMessage.innerText = message;
        
        // Remove previous alert types
        alertBox.classList.remove("error", "success", "warning");

        // Add the correct type class
        alertBox.classList.add(type);

        // Show the alert box
        document.getElementById("modalOverlay").style.display = "block";
        alertBox.classList.add("show");
      }

      function closeAlert() {
        document.getElementById("modalOverlay").style.display = "none";
        document.getElementById("customAlert").classList.remove("show");
      }

      // Function to track the current field to be validated
      function checkField(fieldName) {
        if (currentField && currentField !== fieldName) {
          document.getElementById(currentField + 'Field').blur(); // Focus shifts when the next field is selected
        }
        currentField = fieldName;
      }

      // Prevent moving to the next field if validation fails
      function preventTabbing(event) {
        if (event.key === "Tab") {
          let currentElement = event.target;
          if (!validateField(currentElement)) {
            event.preventDefault(); // Prevent moving to the next field if validation fails
          }
        }
      }

      // Validation for each field
      function validateUsername() {
        let id = document.forms[0]["id"].value;
        if (id.length < 5) {
          showAlert("Username must be at least 5 characters long.", "error");
          document.getElementById("usernameField").focus();
          return false;
        }
        return true;
      }

      function validateName() {
        let fname = document.forms[0]["fname"].value;
        let lname = document.forms[0]["lname"].value;
        if (fname.trim() === "") {
          showAlert("First Name is required.", "error");
          document.getElementById("fnameField").focus();
          return false;
        } else if (lname.trim() === "") {
          showAlert("Last Name is required.", "error");
          document.getElementById("lnameField").focus();
          return false;
        }
        return true;
      }

      function validatePassword() {
        let pwd = document.forms[0]["pwd"].value;
        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!passwordPattern.test(pwd)) {
          showAlert("Password must be at least 8 characters long and include at least one letter and one number.", "error");
          document.getElementById("pwdField").focus();
          return false;
        }

        // Phone validation (only numbers, minimum 10 digits)
        const phonePattern = /^[0-9]{10,}$/;
        if (!phonePattern.test(phone)) {
            message += "Phone number must be at least 10 digits long and contain only numbers.\n"; 
        }
        return true;
      }

      function validateEmail() {
        let mail = document.forms[0]["mail"].value;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(mail)) {
          showAlert("Please enter a valid email address.", "error");
          document.getElementById("mailField").focus();
          return false;
        }
        return true;
      }

      // Add event listeners to prevent tabbing if validation fails
      formFields.forEach(input => {
        input.addEventListener("keydown", preventTabbing);
      });
    </script>
</body>
</html>