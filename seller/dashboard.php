<?php
session_start();
error_reporting(0);
include('../include/connection.php');
if(strlen($_SESSION['sid'] AND $_SESSION['sname']) == 0)	{
header('location:../index.php');
}
else{
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Dashboard | StoreIt Warehouse Management System</title>

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
					 <h2 class="pg-heading">Dashboard</h2>
				 </div>
			 </div>

			<div class="row dash-card">
  		 	<div class="col-md-4">
    			<div class="card">
      			<div class="card-body">
							<?php
							$warehouse_count = "SELECT id FROM warehouse WHERE status='1'";
							$fire_Wcount = mysqli_query($conn, $warehouse_count);
							$result_wc = mysqli_num_rows($fire_Wcount);
							?>
							<h1 class="card-title">
								<?php echo htmlentities($result_wc);?>
							</h1>
        			<p class="card-text">WAREHOUSES</p>
      			</div>
						<div class="card-footer">
    					<a href="view-warehouse.php">Full Details</a>
  					</div>
    			</div>
  			</div>
				<div class="col-md-4">
    			<div class="card">
      			<div class="card-body">
							<?php
							$warehouse_count = "SELECT id FROM seller WHERE status='1'";
							$fire_Wcount = mysqli_query($conn, $warehouse_count);
							$result_wc = mysqli_num_rows($fire_Wcount);
							?>
							<h1 class="card-title">
								<?php echo htmlentities($result_wc);?>
							</h1>
        			<p class="card-text">SELLERS</p>
      			</div>
						<div class="card-footer">
    					<a href="view-seller.php">Full Details</a>
  					</div>
    			</div>
  			</div>
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
