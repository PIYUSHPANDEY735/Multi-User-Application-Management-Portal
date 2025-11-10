<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
?>
<?php
// Define the connection variables
$servername = "localhost";  // The server (since it's local, it's 'localhost')
$username = "relictpharmaceut_taxbucket777";         // MySQL username
$password = "dRM;sgp.!fuH";             // Default MySQL password is empty
$dbname = "relictpharmaceut_taxbucket";     // The name of the database you created

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
