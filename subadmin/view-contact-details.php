<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../config/subadmin.php"); // Redirect to login page if not logged in
    exit();
}

// Get the registration ID from the URL
$registration_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if a valid ID is provided
if ($registration_id == 0) {
    echo "Invalid registration ID.";
    exit();
}

// Prepare the SQL statement to fetch the registration details
$sql = "SELECT * FROM contact_enquiries WHERE id = $registration_id";
$stmt = $conn->prepare($sql);


// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

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
    	<h2>Overall Contact Enquiry Detail</h2>	
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
    		      <h3 class="panel-title">Service</h3>
    		  </div> 
    		  <div class="panel-body">
    		   <?php echo $data['Services']; ?>
    		  </div>
		</div>
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">
    		      <h3 class="panel-title">Message</h3>
    		  </div> 
    		  <div class="panel-body">
    		   <?php echo $data['Message']; ?>
    		  </div>
		</div>
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">
    		      <h3 class="panel-title">Submitted At</h3>
    		  </div> 
    		  <div class="panel-body">
    		   <?php echo $data['Submitted_at']; ?>
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

include("includes/footer.php");

?>