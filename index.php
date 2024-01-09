<?php
require_once "db.php";
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['email'])) {
  header("Location: Login page.php");
  exit();
}

// Fetch users for the user selection dropdown in the modal
$fetchUsersQuery = "SELECT id, email FROM Users";
$usersResult = $conn->query($fetchUsersQuery);
$users = $usersResult->fetch_all(MYSQLI_ASSOC);

// Fetch lists for the logged-in user
$email = $_SESSION['email'];
$listQuery = "SELECT * FROM Lists WHERE userId IN (SELECT id FROM Users WHERE email = '$email')";
$listResult = $conn->query($listQuery);
$lists = $listResult->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>

<html>

<head>
  <title>To-Do List</title>
  <link rel="stylesheet" type="text/css" href="index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    a {
      text-decoration: none;
      color: #000;
      font-weight: bold;
    }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 40%;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
  </style>

    
        <div class="Navbar">
              <nav>
                  <ul>
                   
                  <li> <a href="logout.php" style='color:white ;'>להתנתק</a></li>
                  <li> <a href="Example page.php"style='color:white ;'>עמוד דוגמה </a> </li>
                      <li> <a href="Registration page.php"style='color:white ;'> עמוד הרשמה </a> </li>
                      <li> <a href="Login page.php"style='color:white ;'> עמוד התחברות </a> </li>
                      <li> <a href="index.php"style='color:white ;'> העמוד הראשי</a> </li>
                    </ul>
                </nav>
           </div>

</head>

<body background="images/3.jpg">

  <div class="container">
   
    <center style='color:white ;'><h1><b>My List</b></h1></center>
    <button id="addListBtn" class="button">Add New List</button>

    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Production date</th>
          <th> Users</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lists as $list): ?>
          <?php
          // Fetch shared users for the list
          $listId = $list['id'];
          $sharedUsersQuery = "SELECT email FROM users WHERE id IN (SELECT userId FROM SharedLists WHERE listId = $listId)";
          $sharedUsersResult = $conn->query($sharedUsersQuery);
          $sharedUsers = "";
          while ($userRow = $sharedUsersResult->fetch_assoc()) {
            $sharedUsers .= $userRow['email'] . "<br>";
          }
          ?>
          <tr>
            <td  ><a href="Example page.php?list_id=<?php echo $listId; ?>"><?php echo $list['title']; ?></a></td>
            <td ><?php echo $list['creationDate']; ?></td>
            <td ><?php echo $sharedUsers; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    
  </div>

  <!-- Modal for adding a new list -->
  <style>
  /* Add responsive styles for the modal */
  #addListModal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
  }

  /* Add responsive styles for the form elements */
  #addListForm input[type="text"],
  #addListForm select,
  #addListForm button {
    width: 70%;
    margin-bottom: 20px;
    box-sizing: border-box; /* Ensure padding and border are included in the width */
  }

  @media screen and (max-width: 600px) {
    .modal-content {
      margin: 30% auto;
    }
  }
</style>

<!-- Rest of your HTML code -->

<!-- Modal -->
<div id="addListModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <center><Strong><h2 style='color:blue ;'>Add New List</h2></strong></center>
    <form id="addListForm" method="post" action="">
      <input type="text" name="title" placeholder="List Title" required>
      <select name="users[]" multiple>
        <?php foreach ($users as $user): ?>
        <option value="<?php echo $user['id']; ?>"><?php echo $user['email']; ?></option>
        <?php endforeach; ?>
      </select>
      <button type="button" onclick="submitForm()" class="button5" style='color:blue ;'>Create List</button>
    </form>
  </div>
</div>


  <!-- Add this script after the HTML content -->
<script>
  // Function to close the modal
  function closeModal() {
    var modal = document.getElementById("addListModal");
    modal.style.display = "none";
  }

  // Function to show the modal
  function showModal() {
    var modal = document.getElementById("addListModal");
    modal.style.display = "block";
  }

  // Function to submit the form (you can modify this according to your needs)
  function submitForm() {
    document.getElementById("addListForm").submit();
  }
</script>


  <!-- Add jQuery library (you can download it and host it locally or use a CDN) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="script.js"></script>

<br><br>
  <center ><footer id="fotr"> &copy;כל הזכויות שמורות ל-212604631-322627290 </footer> </center >

</body>
</div>

</html>
