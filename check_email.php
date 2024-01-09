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
if (isset($_POST['email'])) {
    // Retrieve the email from the AJAX request
    $email = $_POST['email'];

    // Check if email already exists in the database
    $emailQuery = "SELECT * FROM users WHERE email = '$email'";
    $emailResult = $conn->query($emailQuery);
    if ($emailResult->num_rows > 0) {
        echo "Email already exists";
    } else {
        echo "Email available";
    }
}
?>
