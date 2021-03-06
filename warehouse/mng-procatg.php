<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['wid'] AND $_SESSION['wname']) == 0) {
header('location:../index.php');
}
else {
  $w_id = $_SESSION['wid'];
  // insert Category
  if(isset($_POST['add-btn'])) {
    $cat_name = mysqli_real_escape_string($conn,trim($_POST['cat-name']));
    $cat_desc = mysqli_real_escape_string($conn,trim($_POST['cat-desc']));
    $success="";
    $error="";

    $query = "SELECT * FROM product_cat WHERE w_id='$w_id'";
    $fire_query =  mysqli_query($conn,$query);
    $row = mysqli_fetch_array($fire_query);
    $check_cat = $row ["p_category"];
    if ($cat_name == $check_cat) {
      $error = "Category Name already exist!";
      header("Location:mng-procatg.php?error=".$error);
    }

    else {
      $query_add = "INSERT INTO product_cat(w_id, p_category, cat_desc) VALUES('$w_id', '$cat_name', '$cat_desc')";
      $fire_add = mysqli_query($conn,$query_add);
      if ($fire_add) {
        $success = "Category added Successfully";
        header("Location:mng-procatg.php?success=".$success);
      }
      else {
        $error = "ERROR!";
        header("Location:mng-procatg.php?error=".$error);
      }
    }
  }

// Update Category
  if (isset($_POST['update-btn'])) {
    $c_id = $_POST['c_id'];
  	$update_catg = mysqli_real_escape_string($conn,trim($_POST['update_cname']));
  	$update_desc = mysqli_real_escape_string($conn,trim($_POST['update_desc']));

    $query = "SELECT * FROM product_cat WHERE w_id='$w_id'";
    $fire_query =  mysqli_query($conn,$query);
    $row = mysqli_fetch_array($fire_query);
    $check_cat = $row ["p_category"];

    if ($update_catg == $check_cat) {
      $error = "Category Name already exist!";
      header("Location:mng-procatg.php?error=".$error);
    }
    else {
      $update_query = mysqli_query($conn, "UPDATE product_cat SET p_category='$update_catg', cat_desc='$update_desc' WHERE id='$c_id'");
    	if ($update_query) {
    		$success = "Product Category Updated Successfully";
    		header("Location:mng-procatg.php?success=".$success);
    	}
    	else {
    		$error = "ERROR!";
    		header("Location:mng-procatg.php?error=".$error);
    	}
    }
  }

// Delete user
	if (isset($_GET['del'])) {
  	$id = $_GET['del'];
  	$del_query = mysqli_query($conn, "DELETE FROM product_cat WHERE id=$id");
  	if ($del_query) {
  		$success = "Product Category Deleted";
  		header("Location:mng-procatg.php?success=".$success);
  	}
  	else {
  		$error = "ERROR!";
  		header("Location:mng-procatg.php?error=".$error);
  	}
  }

  // display details
  	$sql = "SELECT * FROM product_cat WHERE w_id='$w_id'";
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
    <title>Manage product Category | StoreIt Warehouse Management System</title>

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
					 <h3 class="pg-heading">Add Product Category</h3>
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
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="add-catg" method="post" enctype="multipart/form-data">
         <div class="form-row mb-2">
           <div class="form-group col-md-6">
             <label for="cat-name">Category Name<span class="star"> *</span></label>
             <input type="text" class="form-control" name="cat-name" id="cat-name" placeholder="Enter Product Category Name" required />
           </div>
         </div>

         <div class="form-row mb-2">
           <div class="form-group col-md-6">
             <label for="cat-desc">Description</label>
             <input type="text" class="form-control" name="cat-desc" id="cat-desc" placeholder="Enter Description" />
           </div>
         </div>
         <button type="submit" name="add-btn" class="btn btn-primary mt-1">Submit</button>
       </form>
       <div class="row cat-table">
         <div class="col-md-12">
           <h3>Products Categories</h3>
    				<table id="catg-list" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
    							<th>#</th>
                  <th>Category Name</th>
                  <th>Description</th>
    							<th>Action</th>
                </tr>
            </thead>
    				<tbody>
    					<?php if(!empty($arr_users)) { ?>
                    <?php foreach($arr_users as $user) { ?>
    					<tr>
    						<td><?php echo $count; ?></td>
    						<td><?php echo $user['p_category']; ?></td>
    						<td><?php echo $user['cat_desc']; ?></td>

    						<td>
    							<button name="edit_btn" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal<?php echo $user['id']; ?>">
    			          Update
    			        </button>
    							<a href="mng-procatg.php?del=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" >Delete</a>

    							<div class="modal fade " id="myModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h5 class="modal-title">Update</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" style="text-align:left;">
													<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="update-category" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <input type="hidden" name="c_id" value="<?php echo $user['id']; ?>">
                                <label for="update_cname">Category Name<span class="star"> *</span></label>
                                <input type="text" class="form-control" name="update_cname" id="update_cname" value="<?php echo $user['p_category']; ?>" required />
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="update_desc">Description</label>
                                <input type="text" class="form-control" name="update_desc" id="update_desc" value="<?php echo $user['cat_desc']; ?>" />
                              </div>
                            </div>
					                  <button type="submit" name="update-btn" class="btn btn-primary mt-2">Update</button>
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
              <th>Category Name</th>
              <th>Description</th>
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
        $('#catg-list').DataTable({
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
