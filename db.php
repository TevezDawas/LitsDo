<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "322627290_212604631"; // The name of your database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>