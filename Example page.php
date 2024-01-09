<?php
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['email'])) {
  header("Location: Login page.php");
  exit();
}

// Include your database connection code here
mysqli_report(MYSQLI_REPORT_OFF);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "322627290_212604631";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the list ID is provided in the URL query parameter
if (!isset($_GET['list_id'])) {
  header("Location: index.php");
  exit();
}

$listId = $_GET['list_id'];

// Fetch the list details from the database
$listQuery = "SELECT * FROM Lists WHERE id = $listId";
$listResult = $conn->query($listQuery);
if ($listResult->num_rows != 1) {
  header("Location: index.php");
  exit();
}

$listRow = $listResult->fetch_assoc();

// Fetch shared users for the list
$sharedUsersQuery = "SELECT email FROM Users WHERE id IN (SELECT userId FROM SharedLists WHERE listId = $listId)";
$sharedUsersResult = $conn->query($sharedUsersQuery);
$sharedUsers = $sharedUsersResult->fetch_all(MYSQLI_ASSOC);

// Fetch relevant emails from Users table
$relevantEmailsQuery = "SELECT email FROM Users WHERE email IN (SELECT email FROM Users WHERE id IN (SELECT userId FROM SharedLists WHERE listId = $listId))";
$relevantEmailsResult = $conn->query($relevantEmailsQuery);
$relevantEmails = $relevantEmailsResult->fetch_all(MYSQLI_ASSOC);

// Fetch tasks for the list
$tasksQuery = "SELECT * FROM Tasks WHERE listId = $listId";
$tasksResult = $conn->query($tasksQuery);
$tasks = $tasksResult->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['add_task'])) {
  $title = $_POST['title'];
  $responsibleUser = $_POST['responsible_user'];

  // Insert the new task into the database
  $insertTaskQuery = "INSERT INTO Tasks (title, dateAdded, isCompleted, responsibleUserId, listId) VALUES ('$title', CURDATE(), 0, '$responsibleUser', $listId)";
  if ($conn->query($insertTaskQuery)) {
    header("Location: Example page.php?list_id=$listId");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}

if (isset($_GET['delete_task'])) {
  $taskId = $_GET['delete_task'];

  // Delete the task from the database
  $deleteTaskQuery = "DELETE FROM Tasks WHERE id = $taskId";
  if ($conn->query($deleteTaskQuery)) {
    header("Location: Example page.php?list_id=$listId");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}

if (isset($_POST['update_task'])) {
  $taskId = $_POST['task_id'];
  $isCompleted = isset($_POST['is_completed']) ? 1 : 0;

  // Update the task's completion status in the database
  $updateTaskQuery = "UPDATE Tasks SET isCompleted = $isCompleted WHERE id = $taskId";
  if ($conn->query($updateTaskQuery)) {
    header("Location: Example page.php?list_id=$listId");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>

<head>
<title>List Tasks</title>
  <link rel="stylesheet" type="text/css" href="index.css">
  
  <title>List Tasks</title>

  <style>
        table {
            width: 100%;
            border: 2px solid #000;
            border-collapse: collapse;
          
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            border: 2px solid #ddd;
            

        }

        a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            text-align: center;

        }

        /* Add CSS for completed tasks */
        .completed-task {
            text-decoration: line-through;
        }

        .completed-line {
            border-top: 2px solid #000;
        }
    </style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to update task status using AJAX
        function updateTaskStatus(checkbox) {
            const taskId = $(checkbox).val();
            const isCompleted = checkbox.checked ? 1 : 0;

            $.ajax({
                url: "update_task_status.php",
                type: "POST",
                data: {
                    task_id: taskId,
                    is_completed: isCompleted
                },
                success: function(response) {
                    console.log(response);
                    const taskRow = $(checkbox).closest("tr"); // Find the parent row of the checkbox
                    if (isCompleted) {
                        // Add line-through style if task is completed
                        taskRow.addClass("completed-task");
                        // Add completed line above the task title
                    } else {
                        // Remove line-through style if task is marked incomplete
                        taskRow.removeClass("completed-task");
                        // Remove the completed line above the task title
                    }

                    // Store the task completed status in local storage
                    localStorage.setItem("task_" + taskId, isCompleted);
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        }

        // Function to apply completed styles when the page loads
        function applyCompletedStyles() {
            $("input[type='checkbox']").each(function() {
                const taskId = $(this).val();
                const isCompleted = localStorage.getItem("task_" + taskId);
                if (isCompleted === "1") {
                    // Add line-through style if task is completed
                    $(this).closest("tr").addClass("completed-task");
                    // Add completed line above the task title
                    $(this).closest("tr").before('<tr class="completed-line"></tr>');
                    // Check the checkbox
                    $(this).prop("checked", true);
                }
            });
        }

        // Apply completed styles when the page loads
        $(document).ready(function() {
            applyCompletedStyles();
        });
    </script>


<div class="Loginheader">
    <header>
        
        <div class="Navbar">
              <nav>
                  <ul>
                   
                      <li>   <a href="logout.php">להתנתק</a></li> 
                      <li> <a href="Example page.php">עמוד דוגמה </a> </li>
                      <li> <a href="Registration page.php"> עמוד הרשמה </a> </li>
                      <li> <a href="Login page.php"> עמוד התחברות </a> </li>
                      <li> <a href="index.php"> העמוד הראשי</a> </li>
                                     
                    </ul>
                </nav>
           </div>
       </header>
  </div>
    <br><br><br> 
</head>
<body background="images/4.jpg">
 
<div class="container">
    <br><br><br><br>
    
   <center><strong> <h1>List: <?php echo $listRow['title']; ?></h1></strong></center>
   <button  class="button5" onclick="window.location.href='index.php'"><-Back Min Lists</button>
   <h2>Add Tasks</h2>
    <form method="post" action="">
        <input type="text" name="title" placeholder="Title" required>
        <select name="responsible_user">
            <?php foreach ($relevantEmails as $email): ?>
                <option value="<?php echo $email['email']; ?>"><?php echo $email['email']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="add_task">Add Task</button>
    </form>
    <br>
    <h3>Tasks</h3>
    <?php if (count($tasks) > 0): ?>
        <table>
            <thead>
            <tr>
                <th>Task Title</th>
                <th>Date</th>
                <th>Users</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- ... (previous HTML code) -->

<?php foreach ($tasks as $task): ?>
  <tr data-task-id="<?php echo $task['id']; ?>">
        <td><?php echo $task['title']; ?></td>
        <td><?php echo $task['dateAdded']; ?></td>
        <td><?php echo $task['responsibleUserId']; ?></td>
        <td>
           
                <input type="checkbox" name="is_completed" value="<?php echo $task['id']; ?>" <?php echo $task['isCompleted'] ? 'checked' : ''; ?> onchange="updateTaskStatus(this)">
           
        </td>
        <td>
            <button onclick="confirmDelete(<?php echo $task['id']; ?>)">Delete</button>
        </td>
    </tr>
<?php endforeach; ?>

<!-- ... (remaining HTML code) -->

            </tbody>
        </table>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
    <br>
   
</div>
<footer id="fotr"> &copy;כל הזכויות שמורות ל-212604631-322627290 </footer>

<script>
    function confirmDelete(taskId) {
        if (confirm("Are you sure you want to delete this task?")) {
            // If the user confirms, call the AJAX function to delete the task
            deleteTask(taskId);
        }
    }

    // Function to delete the task using AJAX
    function deleteTask(taskId) {
        $.ajax({
            url: "delete_task.php",
            type: "POST",
            data: {
                task_id: taskId
            },
            success: function(response) {
                console.log(response);
                // If the deletion was successful, remove the task row from the table
                const taskRow = $(`tr[data-task-id="${taskId}"]`);
                taskRow.remove();
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }
</script>
</body>
</html>
