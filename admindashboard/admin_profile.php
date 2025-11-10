<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's id
$id = $_SESSION['id'];

include("config/connection.php");

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM admin";
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
    	<h2>Details of Super Admin Profile</h2>	
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
    		      <h3 class="panel-title">Query Text</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Display_Name']; ?>
    		  </div>
		</div>
		
				<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Query Detail</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Designation']; ?>
    		  </div>
		</div>
		
				<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Email (Used for Login)</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Email']; ?>
    		  </div>
		</div>
		
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">All Email Addresses</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['All_Emails']; ?>
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
    		      <h3 class="panel-title">All Phone Numbers</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Phone_all']; ?>
    		  </div>
		</div>
		
				<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Address</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 <?php echo $data['Address']; ?>
    		  </div>
		</div>
		
			<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Second Address</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	  <!--echo Sdata['Address_second']; -->
    		  	 
    		  	   <?php
    		      
    		      if (empty($data['Address_second'])) {
                        echo "No Second Address";
                    } else {
                        echo $data['Address_second'];
                    }
    		      
    		      ?>
    		  </div>
		</div>
		
				<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Facebook Profile Link</h3>
    		  </div> 
    		  <div class="panel-body" style="overflow:auto !important;">
    		  	 <?php echo $data['Facebook']; ?>
    		  </div>
		</div>
		
				<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Instagram Profile Link</h3>
    		  </div> 
    		  <div class="panel-body" style="overflow:auto !important;">
    		  	 <?php echo $data['Instagram']; ?>
    		  </div>
		</div>
		
				<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Linkedin Profile Link</h3>
    		  </div> 
    		  <div class="panel-body" style="overflow:auto !important;">
    		  	 <?php echo $data['Linkedin']; ?>
    		  </div>
		</div>
		
				<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Youtube Profile Link</h3>
    		  </div> 
    		  <div class="panel-body" style="overflow:auto !important;">
    		  	 <?php echo $data['Youtube']; ?>
    		  </div>
		</div>
		
		<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Twitter Profile Link</h3>
    		  </div> 
    		  <div class="panel-body" style="overflow:auto !important;">
    		  	 <?php echo $data['Twitter']; ?>
    		  </div>
		</div>

		<div class="portlet-grid panel-info">
			 <div class="panel-heading">    
    		      <h3 class="panel-title">Role</h3>
    		  </div> 
    		  <div class="panel-body">
    		  	 Super Admin
    		  </div>
		</div>
		
			<div class="portlet-grid panel-info">
			 <div class="panel-heading">
    		      <h3 class="panel-title">Your QR Code</h3>
    		  </div> 
    		  <div class="panel-body">
    		      <?php
    		      
    		      if (!empty($data['QR_Code'])) {
                        // Assuming your images are stored in the 'uploads' folder, adjust the path accordingly
                        echo "<td><img src='../userdata/" . $data['QR_Code'] . "' alt='QR Code' style='width: 100%; height: auto;overflow:hidden;'></td>";
                    } else {
                        echo "<td>No QR Code</td>";
                    }
    		      
    		      ?>
    		  	
    		  </div>
		</div>
		
		<div class="clearfix"> </div>
  </div>
  <div class="panel-heading" style="background-color:#fff;border:1px solid #000;font-weight:600;width:fit-content;">
		    <a href="update-admin.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;"> Update Admin Profile</a>
		</div>
		<br>
		  <div class="panel-heading" style="background-color:#fff;border:1px solid #000;font-weight:600;width:fit-content;">
		 <a href="update_password.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;"> Update Admin Password</a>
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