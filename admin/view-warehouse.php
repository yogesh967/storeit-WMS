<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['alogin'] AND $_SESSION['aname']) == 0) {
header('location:../index.php');
}
else {
	$success="";
	$error="";
// Delete user
	if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$del_query = mysqli_query($conn, "DELETE FROM warehouse WHERE id=$id");
	if ($del_query) {
		$success = "User Deleted";
		header("Location:view-warehouse.php?success=".$success);
	}
	else {
		$error = "ERROR!";
		header("Location:view-warehouse.php?error=".$error);
	}
}

// Update user
	if (isset($_POST['update-btn'])) {
	$id = $_POST['id'];
	$name = mysqli_real_escape_string($conn,trim($_POST['Inputname']));
	$password = mysqli_real_escape_string($conn,trim($_POST['Inputpass']));
	$email = mysqli_real_escape_string($conn,trim($_POST['Inputemail']));
	$contact = mysqli_real_escape_string($conn,trim($_POST['Inputcontact']));
	$address = mysqli_real_escape_string($conn,trim($_POST['Inputaddress']));
	$state = mysqli_real_escape_string($conn,trim($_POST['Inputstate']));
	$city = mysqli_real_escape_string($conn,trim($_POST['Inputcity']));
	$zip = $_POST['Inputzip'];

	$update_query = mysqli_query($conn, "UPDATE warehouse SET name='$name', email='$email', password='$password', contact='$contact', address='$address', state='$state', city='$city', zip='$zip' WHERE id=$id");
	if ($update_query) {
		$success = "User Details Updated";
		header("Location:view-warehouse.php?success=".$success);
	}
	else {
		$error = "ERROR!";
		header("Location:view-warehouse.php?error=".$error);
	}
}

// display details
	$sql = "SELECT * FROM warehouse where status = 1";
	$result = $conn->query($sql);
	$arr_users = [];
	$count = 1;
	if ($result->num_rows > 0) {
    $arr_users = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Warehouses | StoreIt Warehouse Management System</title>

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
		<!-- data table -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>
		<!-- custom style -->
		<link rel="stylesheet" href="css/adminstyle.css">
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
					 <h2 class="pg-heading">Warehouses</h2>
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
				<table id="warehouse-list" class="table table-striped table-bordered" style="width:100%">
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
					<?php if(!empty($arr_users)) { ?>
                <?php foreach($arr_users as $user) { ?>
					<tr>
						<td><?php echo $count; ?></td>
						<td><?php echo $user['name']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<td><?php echo $user['password']; ?></td>
						<td><?php echo $user['contact']; ?></td>
						<td><?php echo $user['address']; ?></td>
						<td><?php echo $user['state']; ?></td>
						<td><?php echo $user['city']; ?></td>
						<td><?php echo $user['zip']; ?></td>
						<td>
							<button name="edit_btn" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal<?php echo $user['id']; ?>">
			          Update
			        </button>
							<a href="view-warehouse.php?del=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" >Delete</a>

							<div class="modal fade " id="myModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			                      <div class="modal-content">

			                        <!-- Modal Header -->
			                        <div class="modal-header">
			                          <h5 class="modal-title">Update</h5>
			                          <button type="button" class="close" data-dismiss="modal">&times;</button>
			                        </div>

			                        <!-- Modal body -->
			                        <div class="modal-body" style="text-align:left;">
																<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="update-warehouse" method="post" enctype="multipart/form-data">
								                  <div class="form-row">
								                    <div class="form-group col-md-6">
								                      <label for="Inputname">Name</label>
																			<input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
								                      <input type="text" class="form-control" name="Inputname" id="Inputname" value="<?php echo $user['name']; ?>" />
								                    </div>
																		<div class="form-group col-md-6">
								                      <label for="Inputpass">Password</label>
								                      <input type="text" class="form-control" name="Inputpass" id="Inputpass" value="<?php echo $user['password']; ?>" />
								                    </div>
								                  </div>
								                  <div class="form-row">
																		<div class="form-group col-md-6">
								                      <label for="Inputemail">Email</label>
								                      <input type="text" class="form-control" name="Inputemail" id="Inputemail" value="<?php echo $user['email']; ?>" />
								                    </div>
																		<div class="form-group col-md-6">
								                      <label for="Inputcontact">Contact No.</label>
								                      <input type="text" class="form-control" name="Inputcontact" id="Inputcontact" value="<?php echo $user['contact']; ?>" />
								                    </div>
								                  </div>
								                  <div class="form-row">
																		<div class="form-group col-md-6">
								                      <label for="Inputaddress">Address</label>
								                      <input type="text" class="form-control" name="Inputaddress" id="Inputaddress" value="<?php echo $user['address']; ?>" />
								                    </div>
																		<div class="form-group col-md-6">
								                      <label for="Inputstate">State</label>
								                      <input type="text" class="form-control" name="Inputstate" id="Inputstate" value="<?php echo $user['state']; ?>" />
								                    </div>
								                  </div>
								                  <div class="form-row">
																		<div class="form-group col-md-6">
									                    <label for="inputcity">City</label>
									                    <input type="text" class="form-control" name="Inputcity" id="inputcity" value="<?php echo $user['city']; ?>" />
									                  </div>
																		<div class="form-group col-md-6">
									                    <label for="inputzip">Zip</label>
									                    <input type="text" class="form-control" name="Inputzip" id="inputzip" value="<?php echo $user['zip']; ?>" />
									                  </div>
								                  </div>
								                  <button type="submit" name="update-btn" class="btn btn-primary mt-3">Update</button>
								                </form>
			                        </div>
			                        <!-- Modal footer -->
			                        <div class="modal-footer">
			                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			                        </div>
			                      </div>
			                    </div>
			                  </div>
						</td>
					</tr>
					<?php $count=$count+1; }} ?>
				</tbody>
				<tfoot>
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
				</tfoot>
    		</table>
   </div>
	</div>
</div>
  </body>
</html>
<!-- bootstrap core -->
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js.map"></script>
<script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<?php } ?>
<script>
    $(document).ready(function() {
        $('#warehouse-list').DataTable();
    });
    </script>
<!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
