<?php require_once "db.php"; ?>

<?php
// update_task_status.php

session_start();

if (!isset($_SESSION['email'])) {
  // Redirect if the user is not logged in
  header("Location: Login page.php");
  exit();
}

// Include your database connection code here (same as in your main file)

if (isset($_POST['task_id']) && isset($_POST['is_completed'])) {
  $taskId = $_POST['task_id'];
  $isCompleted = $_POST['is_completed'];

  // Update the task status in the database
  $updateTaskQuery = "UPDATE Tasks SET isCompleted = $isCompleted WHERE id = $taskId";
  if ($conn->query($updateTaskQuery)) {
    // Return success response
    echo "Task status updated successfully!";
  } else {
    // Return error response
    echo "Error: " . $conn->error;
  }
} else {
  // Return error response if required parameters are not provided
  echo "Error: Invalid parameters";
}
?>
