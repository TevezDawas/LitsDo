<?php
require_once "db.php";
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $results = $conn->query($sql);

    if ( mysqli_num_rows($results) == 1) {
      $_SESSION['email'] = $email;

      if (isset($_POST['remember'])) {
          $cookie_value = base64_encode($email); // Encode the email for security
          $expiry_time = time() + (30 * 24 * 60 * 60); // Set the expiration time to 30 days from now
          setcookie('remember_user', $cookie_value, $expiry_time);
      } else {
          setcookie('remember_user', '', time() - 3600); // Delete the cookie if not checked
      }
  
    
    
        header("Location: index.php");
        exit();
    } else {
        
        $error = "Invalid email or password";
    }
  }
?>
<!DOCTYPE html>
<html lang="he"dir="rtl">
    <link rel="stylesheet" href="index.css">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List ToDo</title>
  
    <meta charset="utf-8" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php if (isset($error)) { ?>
            alert('<?php echo $error; ?>');
            <?php } ?>
        });
    </script>
  
  
        
        <div class="Navbar">
              <nav>
                  <ul>
                      <li> <a href="">    </a> </li>
                      <li> <a href="index.php"> העמוד הראשי</a> </li>
                      <li> <a href="Login page.php"> עמוד התחברות </a> </li>
                      <li> <a href="Registration page.php"> עמוד הרשמה </a> </li>
                      <li> <a href="Example page.php">עמוד דוגמה </a> </li>
                      
                     
                   
                    </ul>
                </nav>
           </div>
      
  </div>
</head>

  
    
    <body background="images/1.jpg">
    <div class="bodyy">
       <form  method="POST">
     
     <label for="email">Email:</label>
      <input type="email"  name="email" required>
        
        
      <label for="password">password:</label>
      <input type="password"  name="password"  required> 
    
    
      <label for="remember"><input type="checkbox" id="remember" name="remember">   !!remember me </label> 
      <input type="submit" value="Login" name="login" >
    
       <h2> <a href="Registration page.php">Registration</a></h2>

       <h3> <a href="forgetpassword.php"><h2><b style='color:white ;'>Forget password</b></h3></a>
      
        <footer id="fotr"> &copy;כל הזכויות שמורות ל-212604631-322627290 </footer>
        </div>  
        </body>
        </form>
      
</html>