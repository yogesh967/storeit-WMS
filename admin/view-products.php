<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['alogin'] AND $_SESSION['aname']) == 0) {
header('location:../index.php');
}
else {
  // Delete product
	if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$del_query = mysqli_query($conn, "DELETE FROM products WHERE id=$id");
	if ($del_query) {
		$success = "Order Deleted";
		header("Location:view_products.php?success=".$success);
	}
	else {
		$error = "ERROR!";
		header("Location:view_products.php?error=".$error);
	 }
 }

  // display details
	$sql = "SELECT * FROM products";
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
    <title>Products | StoreIt Warehouse Management System</title>

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
					 <h2 class="pg-heading">Products</h2>
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
       <div class="row">
         <div class="col-md-12">
    				<table id="order-list" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
    							<th>#</th>
                  <th>Warehouse Name</th>
                  <th>Product Name</th>
                  <th>Product Category</th>
                  <th>Quantity</th>
                  <th>Price Per Quantity</th>
                  <th>Product Description</th>
                  <th>image</th>
                  <th>Warehouse Details</th>
    							<th>Action</th>
                </tr>
            </thead>
    				<tbody>
    					<?php if(!empty($arr_users)) { ?>
                    <?php foreach($arr_users as $user) {
                      $w_id = $user['wid'];
                    ?>
    					<tr>
    						<td><?php echo $count; ?></td>
    						<td><?php echo $user['wname']; ?></td>
    						<td><?php echo $user['pname']; ?></td>
                <td><?php echo $user['pcategory']; ?></td>
                <td><?php echo $user['quantity']; ?></td>
                <td><?php echo $user['price_pq']; ?></td>
                <td><?php echo $user['pdescription']; ?></td>
                <td><?php
                $get_img = $user['image'];
                $img = "../warehouse/img/$get_img";
                ?>
                <img src="<?php echo $img; ?>" width="50px">
                </td>
                <td>
                  <button name="view_btn" class="btn btn-link" data-toggle="modal" data-target="#myModal1<?php echo $user['pid']; ?>">
    			          View Warehouse Details
    			        </button>
                  <!-- View Details modal -->
                  <div class="modal fade " id="myModal1<?php echo $user['pid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <?php
                        $query3 = "SELECT * FROM warehouse WHERE id='$w_id'";
                        $fire_query3 =  mysqli_query($conn,$query3);
                        $row3 = mysqli_fetch_array($fire_query3);

                        ?>
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h5 class="modal-title">Details</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" style="text-align:left;">
                          <table class="table">
                            <thead>
                              <th>Title</th>
                              <th>Details</th>
                            </thead>

                            <tbody>
                              <tr>
                                <td>Name</td>
                                <td><?php echo $row3["name"]; ?></td>
                              </tr>

                              <tr>
                                <td>Email</td>
                                <td><?php echo $row3["email"]; ?></td>
                              </tr>

                              <tr>
                                <td>Contact No</td>
                                <td><?php echo $row3["contact"]; ?></td>
                              </tr>

                              <tr>
                                <td>Address</td>
                                <td><?php echo $row3["address"]; ?></td>
                              </tr>

                              <tr>
                                <td>State</td>
                                <td><?php echo $row3["state"]; ?></td>
                              </tr>

                              <tr>
                                <td>City</td>
                                <td><?php echo $row3["city"]; ?></td>
                              </tr>

                              <tr>
                                <td>Zip</td>
                                <td><?php echo $row3["zip"]; ?></td>
                              </tr>

                              <tr>
                                <td>Image</td>
                                <td>
                                <?php
                                $get_img2 = $row3['image'];
                                $img2 = "../images/users/$get_img2";
                                ?>
                                <img src="<?php echo $img2; ?>" width="50px">
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>

    						<td>
    							<a href="view-products.php?del=<?php echo $user['pid']; ?>" class="btn btn-danger btn-sm" >Delete</a>
    						</td>
    					</tr>
    					<?php $count=$count+1; }} ?>
    				</tbody>
    				<tfoot>
              <th>#</th>
              <th>Warehouse Name</th>
              <th>Product Name</th>
              <th>Product Category</th>
              <th>Quantity</th>
              <th>Price Per Quantity</th>
              <th>Product Description</th>
              <th>image</th>
              <th>Warehouse Details</th>
              <th>Action</th>
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
        $('#order-list').DataTable({
          "paging":   false,
        });
    });
</script>
<!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
