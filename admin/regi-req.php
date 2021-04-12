<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['alogin'])==0) {
header('location:../index.php');
}
else {
	$success="";
	$error="";
// update status
	if (isset($_GET['w_activate'])) {
	$id = $_GET['w_activate'];
	$update_query = mysqli_query($conn, "UPDATE warehouse SET status = 1 WHERE id=$id");
	if ($update_query) {
		$success = "Warehouse account activated Successfully";
		header("Location:regi-req.php?success=".$success);
	}

	else {
		$error = "ERROR!";
		header("Location:regi-req.php?error=".$error);
	}
}

if (isset($_GET['s_activate'])) {
$id = $_GET['s_activate'];
$update_query = mysqli_query($conn, "UPDATE seller SET status = 1 WHERE id=$id");
if ($update_query) {
	$success = "Seller account activated Successfully";
	header("Location:regi-req.php?success=".$success);
}

else {
	$error = "ERROR!";
	header("Location:regi-req.php?error=".$error);
}
}

// display details
	$sql1 = "SELECT * FROM warehouse WHERE status = 0";
	$result1 = $conn->query($sql1);
	$arr_users1 = [];
	$count1 = 1;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Requests | StoreIt Warehouse Management System</title>

		<!--bootstrap core-->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css.map" />
		<!-- custom style -->
		<link rel="stylesheet" href="css/adminstyle.css">
		<!--Jquery-->
		<script src="../js/jquery.js"></script>
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
					 <h2 class="pg-heading">Registration Requests</h2>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-md-12 pl-4 pt-2 pb-2">
					 <h3>Warehouse</h3>
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
			 <!-- success msg -->
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

			 <div class="table-responsive">
				<table id="seller-list" class="table table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
							<th>#</th>
                <th>Name</th>
                <th>Email</th>
								<th>Password</th>
                <th>Contact No</th>
                <th>Address</th>
                <th>State</th>
								<th>City</th>
								<th>Zip</th>
								<th>Action</th>
            </tr>
        </thead>
				<tbody>
					<?php
					if ($result1->num_rows > 0) {
				    $arr_users1 = $result1->fetch_all(MYSQLI_ASSOC);
					}
					if(!empty($arr_users1)) {
						foreach($arr_users1 as $user1) { ?>
					<tr>
						<td><?php echo $count1; ?></td>
						<td><?php echo $user1['name']; ?></td>
						<td><?php echo $user1['email']; ?></td>
						<td><?php echo $user1['password']; ?></td>
						<td><?php echo $user1['contact']; ?></td>
						<td><?php echo $user1['address']; ?></td>
						<td><?php echo $user1['state']; ?></td>
						<td><?php echo $user1['city']; ?></td>
						<td><?php echo $user1['zip']; ?></td>
						<td>
							<a href="regi-req.php?w_activate=<?php echo $user1['id']; ?>" class="btn btn-primary btn-sm" >Activate</a>
						</td>
					</tr>
					<?php $count1=$count1+1; }} ?>
				</tbody>
    		</table>

				<div class="row">
 				 <div class="col-md-12 pl-4 pt-2 pb-2">
 					 <h3>Seller</h3>
 				 </div>
 			 </div>
				<table id="warehouse-list" class="table table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
							<th>#</th>
                <th>Name</th>
                <th>Email</th>
								<th>Password</th>
                <th>Contact No</th>
                <th>Address</th>
                <th>State</th>
								<th>City</th>
								<th>Zip</th>
								<th>Action</th>
            </tr>
        </thead>
				<tbody>
					<?php
					$count2 = 1;
					$sql2 = "SELECT * FROM seller WHERE status = 0";
					$result2 = $conn->query($sql2);
					$arr_users12 = [];
					if ($result2->num_rows > 0) {
				    $arr_users2 = $result2->fetch_all(MYSQLI_ASSOC);
					}
					if(!empty($arr_users2)) {
						foreach($arr_users2 as $user2) { ?>
					<tr>
						<td><?php echo $count2; ?></td>
						<td><?php echo $user2['name']; ?></td>
						<td><?php echo $user2['email']; ?></td>
						<td><?php echo $user2['password']; ?></td>
						<td><?php echo $user2['contact']; ?></td>
						<td><?php echo $user2['address']; ?></td>
						<td><?php echo $user2['state']; ?></td>
						<td><?php echo $user2['city']; ?></td>
						<td><?php echo $user2['zip']; ?></td>
						<td>
							<a href="regi-req.php?s_activate=<?php echo $user2['id']; ?>" class="btn btn-primary btn-sm" >Activate</a>
						</td>
					</tr>
					<?php $count2=$count2+1; }} ?>
				</tbody>

    		</table>
			 </div>
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
  // File tye validation
  function fileValidation() {
    var fileInput = document.getElementById('UploadImage');
    var filePath = fileInput.value;

    // Allowing file type
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
      alert('Invalid file type');
      fileInput.value = '';
      return false;
    }
  }

// matching password
  function onChange() {
    const password = document.querySelector('input[name=enter-pass]');
    const confirm = document.querySelector('input[name=confirm-pass]');
    if (confirm.value === password.value) {
      confirm.setCustomValidity('');
    } else {
      confirm.setCustomValidity('Passwords do not match');
      document.getElementById('message').style.color = 'red';
      document.getElementById('message').innerHTML = 'password not matching';
    }
  }
  </script>
