<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
?>
<?php include('connection.php') ?>
<?php
if (isset($_POST['contact_form'])) {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $services = $_POST['services'];
    $message = $_POST['msg'];


    $sql = "INSERT INTO contact_enquiries (`Name`, `Email`, `Phone`, `Services`, `Message`) VALUES ('$name', '$email', '$phone', '$services' ,'$message')";


    if ($conn->query($sql) === TRUE) {
         echo "<script>
                alert('Your enquiry has been submitted successfully!');
                window.location.href='https://localhost/piyushproject/index.php/'; // Redirect to contact page or another page
              </script>";
        exit();
    } else {
         echo "<script>
                alert('Your enquiry has been sent, Please Fill the form again !');
                window.location.href='https://localhost/piyushproject/contact.php'; 
              </script>";
    }
}

$conn->close();


?>