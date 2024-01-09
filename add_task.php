<?php require_once "db.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['title']) && isset($_POST['responsible_user']) && isset($_POST['list_id'])) {
    $title = $_POST['title'];
    $responsibleUser = $_POST['responsible_user'];
    $listId = $_POST['list_id'];

    // Insert the new task into the database
    $insertTaskQuery = "INSERT INTO Tasks (title, dateAdded, isCompleted, responsibleUserId, listId) VALUES ('$title', CURDATE(), 0, '$responsibleUser', $listId)";
    if ($conn->query($insertTaskQuery)) {
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
