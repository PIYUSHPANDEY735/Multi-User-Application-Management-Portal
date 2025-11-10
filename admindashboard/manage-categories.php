<?php

error_reporting(E_ALL);
ini_set('display_errors',1); 

include("includes/header.php");
include("includes/navbar.php");


include("config/connection.php");

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM categories";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result(); // Execute and get the result

// Update Subcategory
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_subcategory'])) {
    $id = $_POST['id'];
    $subcategory_name = $conn->real_escape_string($_POST['subcategory_name']);
    $conn->query("UPDATE subcategories SET subcategory_name='$subcategory_name' WHERE id='$id'");
    echo "<script>alert('Subcategory updated'); window.location.href='manage-categories.php';</script>";
}

// Delete Subcategory
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM subcategories WHERE id='$id'");
    echo "<script>alert('Subcategory deleted'); window.location.href='manage-categories.php';</script>";
}


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
<div class="chit-chat-layer1">
	<div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading" style="font-size:30px;text-align:center;color:#000;margin-bottom:10px;display:flex;align-items:center;justify-content:space-around;">
                                  All Categories
                                  <div class="btn-effcts panel-widget" style="margin:0px;padding:0px;padding-left: 5px;padding-right: 5px;background: #d9d9d9;width:auto;">
                                      <a href="add-new-category.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;">Create New Category</a>
                                  </div>
                                  
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>Category ID</th>
                                      <th>Category Name</th>
                                      <th>Update</th>
                                      <th>Delete</th>
                                      <th>Created At</th>
                                  </tr>
                              </thead>
                              <tbody>
              <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['category_name'] . "</td>";
                        echo "<td><a class='btn btn-primary' href='update-category.php?id=" . $row['id'] . "'>Update Category</a></td>";
                        echo "<td><a class='btn btn-warning' href='#' onclick='confirmDelete(" . $row['id'] . ")'>Delete Category</a></td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                        
                    }
                } else {
                    echo "<tr><td colspan='6'>No data found</td></tr>";
                }
                ?>
                          </tbody>
                      </table>
                  </div>
             </div>
      </div>
      
      <div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading" style="font-size:30px;text-align:center;color:#000;margin-bottom:10px;display:flex;align-items:center;justify-content:space-around;">
                                  All Sub Categories
                                  <div class="btn-effcts panel-widget" style="margin:0px;padding:0px;padding-left: 5px;padding-right: 5px;background: #d9d9d9;width:auto;">
                                      <a href="add-new-subcategory.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;">Create New SubCategory</a>
                                  </div>
                                  
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>ID</th>
                                      <th>Category Name</th>
                                      <th>Sub Category</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
             <?php
    $result = $conn->query("SELECT subcategories.id, subcategories.subcategory_name, categories.category_name 
                            FROM subcategories 
                            JOIN categories ON subcategories.category_id = categories.id");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <form method='POST'>
                    <td>{$row['id']}</td>
                    <td>{$row['category_name']}</td>
                    <td>
                        <input type='text' style='color:#000;' name='subcategory_name' value='{$row['subcategory_name']}' required>
                        <input type='hidden' name='id' value='{$row['id']}'>
                    </td>
                    <td>
                        <button class='btn btn-primary' type='submit' name='update_subcategory'>Update</button>
                        <a class='btn btn-warning' href='?delete={$row['id']}' onclick=\"return confirm('Delete this subcategory?')\">Delete</a>
                    </td>
                </form>
              </tr>";
    }
    ?>
                          </tbody>
                      </table>
                  </div>
             </div>
      </div>
     <div class="clearfix"> </div>
</div>
<!--main page chit chating end here-->


</div>
<!--inner block end here-->

<script type="text/javascript">
  function confirmDelete(serviceId) {
    // Show a confirmation dialog
    if (confirm("Are you sure you want to delete this Category?")) {
      // Redirect to the PHP delete page if "Yes"
      window.location.href = "delete-category.php?id=" + serviceId;
    } else {
      // Redirect to the MCA services page if "No"
      window.location.href = "manage-categories.php";
    }
  }
</script>



<?php

include("includes/footer.php");

?>