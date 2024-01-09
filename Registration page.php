<?php
require_once "db.php";
mysqli_report(MYSQLI_REPORT_OFF);
$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn = new mysqli($servername, $username, $password, "322627290_212604631");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    // Validate registration form fields and add new user to the database
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $confirmPass = $_POST['confirmPassword'];

        // Check if email already exists in the database
        $emailQuery = "SELECT * FROM users WHERE email = '$email'";
        $emailResult = $conn->query($emailQuery);
        if ($emailResult->num_rows > 0) {
            echo "Email already exists";
        }

        // Check if password and confirm password match
        if ($pass !== $confirmPass) {
            echo "Password and Confirm Password must match";
        }

        $sql = "INSERT INTO `users` (`id`,`fname`, `lname`, `email`,`password`) VALUES (NULL,'$firstname', '$lastname', '$email','$pass')";

        if ($conn->query($sql)) {
            header('Location: Login page.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration page</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            $('#email').on('input', function() {
                var email = $(this).val();
                $.ajax({
                    url: 'check_email.php',
                    type: 'POST',
                    data: { email: email },
                    success: function(response) {
                        $('#emailAvailability').html(response);
                    }
                });
            });
        });

        $(document).ready(function() {
        $('#confirmPassword').on('input', function() {
            var password = $('#password').val();
            var confirmPassword = $(this).val();

            if (password != confirmPassword) {
                $('#passwordConfirm').text("Password and Confirm Password do not match").css('color', 'red');
            } else {
                $('#passwordConfirm').text("Password and Confirm Password match").css('color', 'green');
            }
        });
    });
    </script>
 
        <div class="Navbar">
              <nav>
                  <ul>
                     
                  <li> <a href="">    </a> </li>
                      <li> <a href="Example page.php" >עמוד דוגמה </a> </li>
                      <li> <a href="Registration page.php"> עמוד הרשמה </a> </li>
                      <li> <a href="Login page.php"> עמוד התחברות </a> </li>
                      <li> <a href="index.php"> העמוד הראשי</a> </li>
                   
                    </ul>
                </nav>
           </div>
    
  </div>
</head>

<body background="images/2.jpg">
<div class="bodyy">
    <div class="container">
        <form method="post" action="" onsubmit="return validateForm()">
            <!-- Registration form fields -->
           
            
            <center><h1><b style='color:black ;'>טופס הרשמה</b></h1></center>
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="lname" placeholder="Last Name" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <span id="emailAvailability"></span>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
            <span id="passwordConfirm"></span>
           
            <button type="submit" name="register"  class="button3">Register</button>
            <footer id="fotr"> &copy;כל הזכויות שמורות ל-212604631-322627290 </footer>
          
        </form>
    </div>
    <br>
 
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    </body>
    
 
    </div>

</html>
