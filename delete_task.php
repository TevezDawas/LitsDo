<?php require_once "db.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['task_id'])) {
    $taskId = $_POST['task_id'];

    // Delete the task from the database
    $deleteTaskQuery = "DELETE FROM Tasks WHERE id = $taskId";
    if ($conn->query($deleteTaskQuery)) {
      echo "Success";
    } else {
      echo "Error: " . $conn->error;
    }
  } else {
    echo "Invalid request parameters.";
  }
} else {
  echo "Invalid request method.";
}
?>
