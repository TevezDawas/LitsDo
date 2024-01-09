<?php
require_once "db.php";

session_start();

$message = ""; // Initialize an empty message variable

function generateToken($length = 32) {
    $token = bin2hex(random_bytes($length));
    
    // Save the token in the password_reset table
    global $conn;
    $email = $_POST['email'];
    $sql = "INSERT INTO password_reset (email, token) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    
    return $token;
}

if (isset($_POST['check-email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $results = $stmt->get_result();

   
    if ($results->num_rows == 1) {
        // Generate a secure token and save it in the password_reset table
        $token = generateToken();

        // Set the success message (This will simulate sending an email)
        $message = "An email with instructions to reset your password has been sent to your email address. Please check your inbox. If you don't receive the email within a few minutes, please check your spam folder. If you need further assistance, please contact our support team.";

        // Redirect to password reset page with the token as a URL parameter
        echo '
        <script>
            window.addEventListener("DOMContentLoaded", function() {
                alert("' . $message . '");
                window.location.href = "Login page.php";
            });
        </script>';
        exit; // Stop further execution of the script
    } else {
        // Set the error message
        $message = "Email not found in the system.";
    }
  
}


?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="resetpassword.css">
    
        <div class="Navbar">
              <nav>
                  <ul>
                      <li> <a href="">    </a> </li>
                      <li> <a href="forgetpassword.php" style='color:black ;'>עמוד דוגמה </a> </li> 
                      <li> <a href="Registration page.php" style='color:black ;'> עמוד הרשמה </a> </li>
                      <li> <a href="Login page.php" style='color:black ;'> עמוד התחברות </a> </li>
                      <li> <a href="forgetpassword.php" style='color:black ;'> העמוד הראשי</a> </li>
                     
                   
                    </ul>
                </nav>
           </div>
 
      
</head>

<body background="images/6.avif">

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="" method="POST" autocomplete="off">
                   
                    <h2 class="text-center"><em><strong>Forgot Password</strong></em></h2>
                    <br> <br>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button"style='color:white ;' type="submit" name="check-email" value="Check Email">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($message)): ?>
        <script>
            window.addEventListener("DOMContentLoaded", function() {
                var message = "<?php echo $message; ?>";
                alert(message);
            });
        </script>
    <?php endif; ?>
    <br>  <br>  <br>  <br>  <br>
    <center><strong><footer id="fotr"> &copy;כל הזכויות שמורות ל-212604631-322627290 </footer></strong> </center>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
        
</body>
</div>
</html>
