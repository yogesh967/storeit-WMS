<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['alogin'] AND $_SESSION['aname']) == 0) {
header('location:../index.php');
}
else {
  if(isset($_POST['update-btn'])) {
    $current = $_POST['current-pass'];
    $new_pass = $_POST['confirm-new-pass'];
    $user = $_SESSION['alogin'];
    $success="";
    $error="";

    $current_query = "SELECT password FROM admin WHERE id='$user'";
    $fire_query =  mysqli_query($conn,$current_query);
    $row = mysqli_fetch_array($fire_query);
    $oldpassword = $row ["password"];
    if ($current == $oldpassword) {
      $update_query = "UPDATE admin SET password='$new_pass' WHERE id='$user'";
      $fire_update = mysqli_query($conn,$update_query);
      if ($update_query) {
        $success = "Password Changed";
        header("Location:change-pass.php?success=".$success);
      }
      else {
        $error = "ERROR";
        header("Location:change-pass.php?error=".$error);
      }
    }
    else {
      $error = "Current Password is NOT valid. Try another";
      header("Location:change-pass.php?error=".$error);
    }
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password | StoreIt Warehouse Management System</title>

		<!--bootstrap core-->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css.map" />
		<!-- custom style -->
		<link rel="stylesheet" href="css/adminstyle.css">
		<!--Jquery-->
		<script src="../js/jquery.js"></script>
		<!-- state city -->
		<script type="text/javascript" src="../js/cities.js"></script>
		<!--bootstrap  icon-->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
		<!--Open sans font-->
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
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
					 <h1 class="pg-heading">Change Admin Password</h1>
				 </div>
			 </div>
			 <!-- popup message -->
       <!-- Error msg -->
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
       <!-- Success msg -->
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
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="update_pass" method="post" enctype="multipart/form-data">
         <div class="form-row mb-2">
           <div class="form-group col-md-6">
             <?php echo $row ["password"]; ?>
             <label for="current-pass">Current Password<span class="star"> *</span></label>
             <input type="password" class="form-control" name="current-pass" id="current-pass" placeholder="Enter Current Password" required />
           </div>
         </div>

         <div class="form-row mb-2">
           <div class="form-group col-md-6">
             <label for="new-pass">New-Password<span class="star"> *</span></label>
             <input type="password" class="form-control" name="new-pass" id="new-pass" placeholder="Enter New Password" required />
           </div>
         </div>
         <div class="form-row mb-2">
           <div class="form-group col-md-6">
             <label for="confirm-new-pass">Confirm New Password<span class="star"> *</span></label>
             <input type="password" class="form-control" name="confirm-new-pass" id="confirm-new-pass" placeholder="Confirm New Password" onChange="onChange()" required />
             <div>
               <span id='message'></span>
             </div>
           </div>
         </div>
         <button type="submit" name="update-btn" class="btn btn-primary mt-1">Update</button>
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

  <script type="text/javascript">
// matching password
  function onChange() {
    const password = document.querySelector('input[name=new-pass]');
    const confirm = document.querySelector('input[name=confirm-new-pass]');
    if (confirm.value === password.value) {
      confirm.setCustomValidity('');
    } else {
      confirm.setCustomValidity('Passwords do not match');
      document.getElementById('message').style.color = 'red';
      document.getElementById('message').innerHTML = 'Password not matching';
    }
  }
  </script>
