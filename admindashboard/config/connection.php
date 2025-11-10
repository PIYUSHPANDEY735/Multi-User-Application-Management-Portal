<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

$servername = "localhost";  
$username = "root";         
$password = "";         
$dbname = "project_complete"; 


$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
