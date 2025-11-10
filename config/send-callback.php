<?php include('connection.php') ?>
<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

?>

<?php
if (isset($_POST['callback_form'])) {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $purpose = $_POST['purpose'];

    // Insert form data into database
    $sql = "INSERT INTO callback_enquiries (`Name`, `Email`, `Phone`, `Message`, `Purpose`) VALUES ('$name', '$email', '$phone', '$message', '$purpose')";

    if ($conn->query($sql) === TRUE) {
         echo "<script>
                alert('Your enquiry has been submitted successfully!');
                window.location.href='https://localhost/piyushproject/'; // Redirect to contact page or another page
              </script>";
        exit();
    } else {
         echo "<script>
                alert('There is some error, Please Fill the form again !');
                window.history.back();
              </script>";
    }
}

$conn->close();


?>