    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--copy rights start here-->
    <div class="copyrights">
    	<p>Created By <a href="https://piyush4.netlify.app" target="_blank">Piyush Pandey</a> </p>
    </div>
    <!--COPY rights end here-->
    <!--COPY rights end here-->
    </div>
    </div>
    <!--slider menu-->
    <div class="sidebar-menu">
    	<div class="logo"> <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="index.php"> <span id="logo"></span>
    			<!--<img id="logo" src="" alt="Logo"/>-->
    		</a> </div>
    	<div class="menu">
    		<ul id="menu" style="background:#202121 !important;">
    			<li id="menu-home"><a href="index.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
    			<li id="menu-home"><a href="manage-categories.php"><i class="fa fa-file-contract"></i><span>Manage Categories</span></a></li>
    			<li id="menu-home"><a href="manage-submissions.php"><i class="fa fa-file"></i><span>Manage Submissions</span></a></li>
    			<li id="menu-home"><a href="manage-services.php"><i class="fa fa-file-contract"></i><span> Manage Services</span></a></li>
    			<li id="menu-home"><a href="manage-blogs.php"><i class="fa fa-blog"></i><span> Manage Blogs</span></a></li>
    			<li id="menu-home"><a href="manage-pages.php"><i class="fa fa-file"></i><span>Manage Pages</span></a></li>
    			<li id="menu-home"><a href="manage-jobs.php"><i class="fa fa-file"></i><span>Manage Job Openings</span></a></li>
    			<li id="menu-home"><a href="./update_password.php"><i class="fa fa-key"></i><span> Update Password</span></a></li>
    			<li id="menu-home"><a href="./registered-admins.php"><i class="fa fa-users"></i><span>Registered Admins</span></a></li>
    			<li id="menu-home"><a href="./admin_profile.php"><i class="fa fa-user"></i><span>Admin Profile</span></a></li>

    			<li id="menu-home"><a href="./admin_logout.php"><i class="fa fa-sign-out"></i><span>Log Out</span></a></li>
    		</ul>
    	</div>
    </div>
    <div class="clearfix"> </div>
    </div>
    <!--slide bar menu end here-->
    <script>
    	var toggle = true;

    	$(".sidebar-icon").click(function() {
    		if (toggle) {
    			$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
    			$("#menu span").css({
    				"position": "absolute"
    			});
    		} else {
    			$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
    			setTimeout(function() {
    				$("#menu span").css({
    					"position": "relative"
    				});
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