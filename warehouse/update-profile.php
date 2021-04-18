<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['wid'] AND $_SESSION['wname']) == 0) {
header('location:../index.php');
}
else {
	$success="";
	$error="";
  $wid = $_SESSION['wid'];
  // Update user
	if (isset($_POST['update-btn'])) {
  	$name = mysqli_real_escape_string($conn,trim($_POST['Inputname']));
  	$contact = mysqli_real_escape_string($conn,trim($_POST['Inputcontact']));
  	$address = mysqli_real_escape_string($conn,trim($_POST['Inputaddress']));
  	$state = mysqli_real_escape_string($conn,trim($_POST['Inputstate']));
  	$city = mysqli_real_escape_string($conn,trim($_POST['Inputcity']));
  	$zip = $_POST['Inputzip'];

  	$update_query = mysqli_query($conn, "UPDATE warehouse SET name='$name', contact='$contact', address='$address', state='$state', city='$city', zip='$zip' WHERE id=$wid");
  	if ($update_query) {
  		$success = "Details Updated Successfully";
  		header("Location:update-profile.php?success=".$success);
  	}
  	else {
  		$error = "ERROR!";
  		header("Location:update-profile.php?error=".$error);
  	}
  }

  // display details
  $query3 = "SELECT * FROM warehouse WHERE id='$wid'";
  $fire_query3 =  mysqli_query($conn,$query3);
  $row3 = mysqli_fetch_array($fire_query3);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Profile | StoreIt Warehouse Management System</title>

		<!--bootstrap core-->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css.map" />
		<!--Jquery-->
		<script src="../js/jquery.js"></script>
		<!--bootstrap  icon-->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
		<!--Open sans font-->
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
		<!-- custom style -->
		<link rel="stylesheet" href="../admin/css/adminstyle.css">
	</head>

  <body>
		<?php include('include/header.php');?>

		<div class="d-flex" id="wrapper">
		<?php include('include/leftbar.php');?>
	 <!-- Page Content -->
	 	<div id="page-content-wrapper">

		 <div class="container-fluid">
			 <div class="row">
				 <div class="col-md-12 dash-heading">
					 <h2 class="pg-heading">Update Profile</h2>
				 </div>
			 </div>
			 <!-- popup message -->
			 <?php
			 if(isset($_GET['error']) && $_GET['error'] !='')
			 {?>
				 <div class="alert alert-danger alert-dismissible fade show" role="alert">
					 <?php
						 echo $_GET['error'];
						 unset($_GET['error']);
					 ?>
					 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						 <span aria-hidden="true">&times;</span>
					 </button>
				 </div>
			 <?php } ?>

			 <?php
			 if(isset($_GET['success']) && $_GET['success'] !='')
			 {?>
				 <div class="alert alert-success alert-dismissible fade show" role="alert">
					 <?php
						 echo $_GET['success'];
						 unset($_GET['success']);
					 ?>
					 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						 <span aria-hidden="true">&times;</span>
					 </button>
				 </div>
			 <?php } ?>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="update-profile" method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="Inputname">Name</label>
            <input type="text" class="form-control" name="Inputname" id="Inputname" value="<?php echo $row3['name']; ?> " required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="Inputcontact">Contact No.</label>
            <input type="text" class="form-control" name="Inputcontact" id="Inputcontact" value="<?php echo $row3['contact']; ?>" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="Inputaddress">Address</label>
            <input type="text" class="form-control" name="Inputaddress" id="Inputaddress" value="<?php echo $row3['address']; ?>" required />
          </div>
        </div>
        <div class="form-row">
					<div class="form-group col-md-6">
            <label for="Inputstate">State</label>
            <input type="text" class="form-control" name="Inputstate" id="Inputstate" value="<?php echo $row3['state']; ?>" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputcity">City</label>
            <input type="text" class="form-control" name="Inputcity" id="inputcity" value="<?php echo $row3['city']; ?>" required />
          </div>
        </div>
        <div class="form-row">
					<div class="form-group col-md-6">
            <label for="inputzip">Zip</label>
            <input type="text" class="form-control" name="Inputzip" id="inputzip" value="<?php echo $row3['zip']; ?>" required />
          </div>
        </div>
        <button type="submit" name="update-btn" class="btn btn-primary mt-3">Update</button>
      </form>
   </div>
	</div>
  </div>
  </body>
</html>
<!-- bootstrap core -->
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js.map"></script>
<script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
<?php } ?>

<!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
