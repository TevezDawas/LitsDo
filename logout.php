<?php
session_start();
session_unset();
session_destroy();


setcookie('remember_user', '', time() - 3600);

header("Location: Login page.php");
exit;
?>