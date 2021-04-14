<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['wid'] AND $_SESSION['wname']) == 0) {
header('location:../index.php');
}
else {
  $w_id = $_SESSION['wid'];

// Increase Quantity
  if (isset($_POST['increase-btn'])) {
    $p_id = $_POST['pid'];
  	$inc_quant = $_POST['increase_qnt'];

    $query = "SELECT * FROM products WHERE pid='$p_id'";
    $fire_query =  mysqli_query($conn,$query);
    $row = mysqli_fetch_array($fire_query);
    $curr_quant = $row ["quantity"];
    $total_quant = $inc_quant + $curr_quant;
    $update_quant = mysqli_query($conn, "UPDATE products SET quantity='$total_quant' WHERE pid='$p_id'");
    if ($update_quant) {
      $success = "Product Quantity Updated Successfully!";
      header("Location:view-products.php?success=".$success);
    }
  	else {
  		$error = "ERROR!";
  		header("Location:view-products.php?error=".$error);
  	}
  }

  // Decrease Quantity
    if (isset($_POST['decrease-btn'])) {
      $p_id = $_POST['pid'];
    	$dec_quant = $_POST['decrease_qnt'];

      $query = "SELECT * FROM products WHERE pid='$p_id'";
      $fire_query =  mysqli_query($conn,$query);
      $row = mysqli_fetch_array($fire_query);
      $curr_quant = $row ["quantity"];
      $total_quant = $curr_quant - $dec_quant;
      $update_quant = mysqli_query($conn, "UPDATE products SET quantity='$total_quant' WHERE pid='$p_id'");
      if ($update_quant) {
        $success = "Product Quantity Updated Successfully!";
        header("Location:view-products.php?success=".$success);
      }
    	else {
    		$error = "ERROR!";
    		header("Location:view-products.php?error=".$error);
    	}
    }

// Delete user
	if (isset($_GET['del'])) {
  	$id = $_GET['del'];
  	$del_query = mysqli_query($conn, "DELETE FROM products WHERE pid=$id");
  	if ($del_query) {
  		$success = "Product Category Deleted";
  		header("Location:view-products.php?success=".$success);
  	}
  	else {
  		$error = "ERROR!";
  		header("Location:view-products.php?error=".$error);
  	}
  }

  // display details
  	$sql = "SELECT * FROM products WHERE wid='$w_id'";
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
    <title>View Products | StoreIt Warehouse Management System</title>

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
    <link rel="stylesheet" href="css/warestyle.css">
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
       <div class="row cat-table">
         <div class="col-md-12">
    				<table id="pro-list" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
    							<th>#</th>
                  <th>Product Name</th>
                  <th>Product category</th>
                  <th>Quantity</th>
                  <th>Product Description</th>
                  <th>Image</th>
    							<th>Action</th>
                </tr>
            </thead>
    				<tbody>
    					<?php if(!empty($arr_users)) { ?>
                    <?php foreach($arr_users as $user) { ?>
    					<tr>
    						<td><?php echo $count; ?></td>
    						<td><?php echo $user['pname']; ?></td>
    						<td><?php echo $user['pcategory']; ?></td>
                <td><?php echo $user['quantity']; ?></td>
                <td><?php echo $user['pdescription']; ?></td>
                <td>
                  <?php
                  $get_img = $user['image'];
                	$img = "img/$get_img";
                  ?>
                  <img src="<?php echo $img; ?>" width="150px">
                </td>

    						<td>
    							<button name="increase_btn" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal1<?php echo $user['pid']; ?>">
    			          increase Quantity
    			        </button><br>
                  <button name="decrease_btn" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal2<?php echo $user['pid']; ?>">
    			          Decrease Quantity
    			        </button><br>
    							<a href="mng-procatg.php?del=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" >Delete</a>

                  <!-- Increase Quantity -->
    							<div class="modal fade" id="myModal1<?php echo $user['pid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h5 class="modal-title">Increase Quantity</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" style="text-align:left;">
													<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="increase_qnt" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <input type="hidden" name="pid" value="<?php echo $user['pid']; ?>">
                                <label for="pname">Product Name</label>
                                <input type="text" class="form-control" name="up_pname" id="up_pname" value="<?php echo $user['pname']; ?>" disabled />
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="increase_qnt">Quantity</label>
                                <input type="number" class="form-control" name="increase_qnt" id="increase_qnt" placeholder="Enter value to increase quantity" required />
                              </div>
                            </div>
					                  <button type="submit" name="increase-btn" class="btn btn-primary mt-2">Update</button>
					                </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Decrease Quantity -->
                  <div class="modal fade" id="myModal2<?php echo $user['pid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h5 class="modal-title">Decrease Quantity</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" style="text-align:left;">
													<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="decrease_qnt" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <input type="hidden" name="pid" value="<?php echo $user['pid']; ?>">
                                <label for="pname">Product Name</label>
                                <input type="text" class="form-control" name="up_pname" id="up_pname" value="<?php echo $user['pname']; ?>" disabled />
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="decrease_qnt">Quantity</label>
                                <input type="number" class="form-control" name="decrease_qnt" id="decrease_qnt" placeholder="Enter value to decrease quantity" required />
                              </div>
                            </div>
					                  <button type="submit" name="decrease-btn" class="btn btn-primary mt-2">Update</button>
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
              <th>Product Name</th>
              <th>Prod category</th>
              <th>Quantity</th>
              <th>PRod Description</th>
              <th>Image</th>
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
        $('#pro-list').DataTable();
    });
</script>

<!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
