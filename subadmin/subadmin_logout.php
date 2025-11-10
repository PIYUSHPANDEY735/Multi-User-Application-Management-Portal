<?php
session_start();

// Expire the session cookie by setting the expiration time to a past time
setcookie(session_name(), '', time() - 3600, '/');

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the home page
header('Location: https://localhost/piyushproject/config/subadmin.php');
exit();
?>
