<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['status'])) {
    header("Location: ../config/subadmin.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's id
$id = $_SESSION['id'];

include("config/connection.php");

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM user WHERE id='$id' AND Status='Admin' "; 
$stmt = $conn->prepare($query);
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
    .market-update-block h3{
        font-size:35px;
        font-weight:normal;
    }
</style>

<!--inner block start here-->

<div class="inner-block">
<!--market updates updates-->
	 <div class="market-updates">
			<div class="col-md-4 market-update-gd">
			    <a href="registered-users.php">
				<div class="market-update-block clr-block-1">
					<div class="col-md-8 market-update-left">
						<h3>Registered </h3>
						<h3> Users</h3>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-users"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
			<div class="col-md-4 market-update-gd">
			    <a href="contact-enquiries.php">
				<div class="market-update-block clr-block-2">
				 <div class="col-md-8 market-update-left">
					<h3>Contact </h3>
					<h3> Enquiries</h3>
				  </div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-envelope"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
			<div class="col-md-4 market-update-gd">
			    <a href="callback-enquiries.php">
				<div class="market-update-block clr-block-3">
					<div class="col-md-8 market-update-left">
						<h3>Callback</h3>
						<h3> Enquiries</h3>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-phone-alt"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
		   <div class="clearfix"> </div>
		</div>
<!--market updates end here-->
<!--mainpage chit-chating-->
<div class="portlet-grid-page">  
    	<h2>Details of Admin Profile</h2>	
    	<div class="portlet-grid panel-info"> 
    		 <div class="panel-heading">
    		      <h3 class="panel-title">Id</h3>
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
    		      <h3 class="panel-title">Email</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Email']; ?>
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
    		      <h3 class="panel-title">Assigned Services</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	  <?php echo $data['Assigned_Services']; ?>
    		  </div>
		</div>

		<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Role</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	  <?php echo $data['Status']; ?>
    		  </div>
		</div>
		
		
		<div class="clearfix"> </div>
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
?>
<?php

include("includes/footer.php");

?>