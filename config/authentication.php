<?php

error_reporting(E_ALL);
ini_set('display_errors',1);


session_start();
include("connection.php");

if (isset($_POST['submit-user'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
	 $state = $_POST['state'];
	  $pincode = $_POST['pincode'];
	  
	   $hashed_password = password_hash($password, PASSWORD_DEFAULT);
	
	$query = "INSERT INTO `user`(`Name`, `Email`, `Phone`, `Password`, `State`, `Pincode`,`Status`) VALUES ('$name','$email','$phone','$hashed_password','$state','$pincode','User')";
    
	$res = mysqli_query($conn, $query);
	
    if ($res) {
       
        $last_id = mysqli_insert_id($conn);
        
        // Step 5: Use the last inserted ID to fetch user data
        $select_query = "SELECT * FROM `user` WHERE `id` = '$last_id'";
        $result = mysqli_query($conn, $select_query);

        if ($result) {
            // Fetch associative array
            $row_user = mysqli_fetch_assoc($result);
            
            // Step 6: Store user details in session variables
            $_SESSION['id'] = $row_user['id'];
            $_SESSION['userid'] = $row_user['userid'];  // assuming you have a `userid` field
            $_SESSION['name'] = $row_user['Name'];
            $_SESSION['email'] = $row_user['Email'];
            $_SESSION['Status'] = $row_user['Status'];
            
            // Step 7: Redirect to another page or index.php
            header("location: ../dashboard/index.php");
            exit();
        } else {
            echo "Error fetching user details: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }

// 	if ($res) {
	    
// 	    $row_user = mysqli_fetch_assoc($res);
// 	    $_SESSION['id'] = $row_user['id'];
//         $_SESSION['userid'] = $row_user['userid'];
//         $_SESSION['name'] = $row_user['Name'];
//         $_SESSION['email'] = $row_user['Email'];
// 		header("location: ../index.php");
// 		exit();
// 	} 
// 	else {
//         echo "Error in query: " . mysqli_error($conn);
// 	}
    
}

?>