<?php
// Assuming the user is logged in and their userid or name is stored in the session
$name = $_SESSION['name'];

// Make sure that the name is available
if (!isset($name) || empty($name)) {
    echo "User is not logged in.";
    exit;
}

// Fetch assigned services for the logged-in sub-admin
$query = "SELECT Assigned_Services FROM user WHERE Name = ?";
$stmt = $conn->prepare($query);

// Bind the name as a string
$stmt->bind_param("s", $name); // Use "s" for string type
$stmt->execute();
$stmt->bind_result($Assigned_Services);
$stmt->fetch();
$stmt->close();

// If assigned services exist, split them into an array
$services = !empty($Assigned_Services) ? explode(',', $Assigned_Services) : [];

function serviceNameToUrl($service_name) {
    // Convert to lowercase, replace spaces with hyphens, remove special characters
    $url = strtolower(trim($service_name));
    $url = preg_replace('/[^a-z0-9\s-]/', '', $url); // Remove special characters
    $url = preg_replace('/\s+/', '-', $url); // Replace spaces with hyphens
    return $url . '.php'; // Append ".php" to make it a valid URL
}
?>  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!--copy rights start here-->
<div class="copyrights">
	 <p>© 2025 <strong>TaxBucket</strong> All Rights Reserved | Created By  <a href="https://sociosexperts.com/" target="_blank">Socio Media Experts</a> </p>
</div>	
<!--COPY rights end here-->
</div>
</div>
<!--slider menu-->
    <div class="sidebar-menu">
		  	<div class="logo"> <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="index.php"> <span id="logo" ></span> 
			      <!--<img id="logo" src="" alt="Logo"/>--> 
			  </a> </div>		  
		    <div class="menu">
		      <ul id="menu" style="background:#202121 !important;">
		        <li id="menu-home" ><a href="index.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
		         <?php foreach ($services as $service): 
		          $service_url = serviceNameToUrl($service); ?>
        <li id="menu-home">
            <a href="<?php echo htmlspecialchars($service_url); ?>"><i class="fa fa-id-card"></i> <span><?php echo htmlspecialchars($service); ?></span></a>
        </li>
    <?php endforeach; ?>
		        
		         <li id="menu-home" ><a href="./update_password.php"><i class="fa fa-key"></i><span>Update Password</span></a></li>
		         
		        <li id="menu-home" ><a href="./contact-enquiries.php"><i class="fa fa-envelope"></i><span>Contact Enquiries</span></a></li>
		        <li id="menu-home" ><a href="./callback-enquiries.php"><i class="fa fa-phone-alt"></i><span>Callback Enquiries</span></a></li>
		        <li id="menu-home" ><a href="./subadmin_profile.php"><i class="fa fa-user"></i><span>Sub Admin Profile</span></a></li>
		        
		        <li id="menu-home" ><a href="./subadmin_logout.php"><i class="fa fa-sign-out"></i><span>Log Out</span></a></li>
		      </ul>
		    </div>
	 </div>
	<div class="clearfix"> </div>
</div>
<!--slide bar menu end here-->
<script>
var toggle = true;
            
$(".sidebar-icon").click(function() {                
  if (toggle)
  {
    $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
    $("#menu span").css({"position":"absolute"});
  }
  else
  {
    $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
    setTimeout(function() {
      $("#menu span").css({"position":"relative"});
    }, 400);
  }               
                toggle = !toggle;
            });
</script>
<!--scrolling js-->
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<!--//scrolling js-->
<script src="js/bootstrap.js"> </script>
<!-- mother grid end here-->
</body>
</html>                     