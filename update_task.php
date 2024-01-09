<?php require_once "db.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['task_id']) && isset($_POST['is_completed'])) {
    $taskId = $_POST['task_id'];
    $isCompleted = $_POST['is_completed'];

    // Update task status in the database
    $updateTaskQuery = "UPDATE Tasks SET isCompleted = $isCompleted WHERE id = $taskId";
    if ($conn->query($updateTaskQuery)) {
      echo "Success";
    } else {
      echo "Error updating task status: " . $conn->error;
    }
  } else {
    echo "Invalid request parameters.";
  }
} else {
  echo "Invalid request method.";
}
?>
