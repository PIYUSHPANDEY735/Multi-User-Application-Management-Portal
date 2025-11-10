<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

// Define the connection variables
$servername = "localhost";  // The server (since it's local, it's 'localhost')
$username = "root";         // MySQL username
$password = "";             // Default MySQL password is empty
$dbname = "project_complete";     // The name of the database you created

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
