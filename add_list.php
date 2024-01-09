<?php
require_once "db.php";
session_start();

if (!isset($_SESSION['email'])) {
  http_response_code(401); // Unauthorized status code
  exit('User not logged in.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $users = $_POST['users'];

  // Insert the new list into the database
  $email = $_SESSION['email'];
  $userIdQuery = "SELECT id FROM users WHERE email = '$email'";
  $userIdResult = $conn->query($userIdQuery);
  if ($userIdResult->num_rows == 1) {
    $row = $userIdResult->fetch_assoc();
    $userId = $row['id'];

    $insertListQuery = "INSERT INTO Lists (title, creationDate, userId) VALUES ('$title', CURDATE(), $userId)";
    if ($conn->query($insertListQuery)) {
      $listId = $conn->insert_id;

      // Insert shared users into the SharedLists table
      foreach ($users as $user) {
        $insertSharedQuery = "INSERT INTO SharedLists (listId, userId) VALUES ($listId, $user)";
        $conn->query($insertSharedQuery);
      }

      // Return a success message to the AJAX request
      http_response_code(200);
      exit('List added successfully.');
    } else {
      http_response_code(500); // Internal server error status code
      exit('Error: ' . $conn->error);
    }
  } else {
    http_response_code(500); // Internal server error status code
    exit('Error: User not found.');
  }
} else {
  http_response_code(405); // Method not allowed status code
  exit('Method not allowed.');
}
