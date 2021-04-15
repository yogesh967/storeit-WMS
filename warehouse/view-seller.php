<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['wid'] AND $_SESSION['wname']) == 0) {
header('location:../index.php');
}
else {
  // display details
  	$sql = "SELECT * FROM seller WHERE status = 1";
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
    <title>View Sellers | StoreIt Warehouse Management System</title>

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
					 <h2 class="pg-heading">View Sellers</h2>
				 </div>
			 </div>
       <div class="row">
         <div class="col-md-12">
    				<table id="seller-list" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
    							<th>#</th>
                  <th>Name</th>
                  <th>Email</th>
    							<th>Contact</th>
                  <th>Address</th>
                  <th>state</th>
                  <th>City</th>
                  <th>zip</th>
                  <th>image</th>
                </tr>
            </thead>
    				<tbody>
    					<?php if(!empty($arr_users)) { ?>
                    <?php foreach($arr_users as $user) { ?>
    					<tr>
    						<td><?php echo $count; ?></td>
    						<td><?php echo $user['name']; ?></td>
    						<td><?php echo $user['email']; ?></td>
                <td><?php echo $user['contact']; ?></td>
                <td><?php echo $user['address']; ?></td>
                <td><?php echo $user['state']; ?></td>
                <td><?php echo $user['city']; ?></td>
                <td><?php echo $user['zip']; ?></td>
                <td>
                <?php
                $get_img = $user['image'];
                $img = "../images/users/$get_img";
                ?>
                <img src="<?php echo $img; ?>" width="50px">
                </td>
    					</tr>
    					<?php $count=$count+1; }} ?>
    				</tbody>
    				<tfoot>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Address</th>
              <th>state</th>
              <th>City</th>
              <th>zip</th>
              <th>image</th>
    				</tfoot>
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
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<?php } ?>
<script>
    $(document).ready(function() {
        $('#seller-list').DataTable();

    });
</script>

<!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
