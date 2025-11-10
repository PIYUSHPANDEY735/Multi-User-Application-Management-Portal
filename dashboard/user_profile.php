<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's id
$userid = $_SESSION['userid'];

include("config/connection.php");

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM user WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid); // Bind the userid parameter
$stmt->execute();
$result = $stmt->get_result(); // Execute and get the result


// Check if any record is found
if ($result->num_rows == 1) {
    // Fetch the registration details
    $data = $result->fetch_assoc();
    ?>
    <style>
    .market-update-right i{
        font-size: 3em;
    color: #000;
    width: 80px;
    height: 80px;
    background: #fff;
    text-align: center;
    border-radius: 49px;
    -webkit-border-radius: 49px;
    -moz-border-radius: 49px;
    -o-border-radius: 49px;
    line-height: 1.7em;
    }
    .portlet-grid-page h2{
        font-size: 2em;
    font-weight: 700;
    color: #000;
    margin-bottom: 1em;
    margin-top: 1em;
    text-align: center;
    font-family: 'Carrois Gothic', sans-serif;
    }
</style>

<!--inner block start here-->

<div class="inner-block">

<!--market updates end here-->
<!--mainpage chit-chating-->
<div class="portlet-grid-page">  
    	<h2>Details of User Profile</h2>	
    	<div class="portlet-grid panel-info"> 
    		 <div class="panel-heading">
    		      <h3 class="panel-title">Id</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	  <?php echo $data['id']; ?>
    		  </div> 
    	</div>  	
	
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">
    		      <h3 class="panel-title">User ID</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	  <?php echo $data['userid']; ?>
    		  </div>
		</div>
		
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Name</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Name']; ?>
    		  </div>
		</div>
		
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Phone</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Phone']; ?>
    		  </div>
		</div>
<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Email</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Email']; ?>
    		  </div>
		</div>
<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">State</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['State']; ?>
    		  </div>
		</div>
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Pincode</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Pincode']; ?>
    		  </div>
		</div>
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Role</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 Normal User
    		  </div>
		</div>
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">
    		      <h3 class="panel-title">Registered At</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Created_At']; ?>
    		  </div>
		</div>
			<div class="clearfix"> </div>
		
		    <div class="panel-heading" style="background-color:#fff;border:1px solid #000;font-weight:600;width:fit-content;">
		    <a href="update-profile.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;"> Update Profile</a>
		</div>
  </div>
<!--main page chit chating end here-->


</div>
<!--inner block end here-->

 <?php
} else {
    echo "No registration details found for this ID.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<?php

include("includes/footer.php");

?>