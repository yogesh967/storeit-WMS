<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['sid'] AND $_SESSION['sname']) == 0) {
header('location:../index.php');
}
else {
  $s_id = $_SESSION['sid'];

  // display details
  	$sql = "SELECT * FROM seller_order WHERE sid='$s_id'";
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
    <title>View Orders status | StoreIt Warehouse Management System</title>

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
					 <h2 class="pg-heading">View Order Status</h2>
				 </div>
			 </div>

       <div class="row">
         <div class="col-md-12">
    				<table id="order-list" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
    							<th>#</th>
                  <th>Product Name</th>
                  <th>Product Category</th>
                  <th>Quantity</th>
                  <th>Total Cost</th>
                  <th>date</th>
                  <th>image</th>
                  <th>Seller Details</th>
                  <th>Status</th>
                </tr>
            </thead>
    				<tbody>
    					<?php if(!empty($arr_users)) { ?>
                    <?php foreach($arr_users as $user) {
                      $s_id = $user['sid'];
                    ?>
    					<tr>
    						<td><?php echo $count; ?></td>
    						<td><?php echo $user['p_name']; ?></td>
                <td><?php echo $user['p_category']; ?></td>
                <td><?php echo $user['quantity']; ?></td>
                <td><?php echo $user['total_price']; ?></td>
                <td><?php echo $user['date']; ?></td>
                <td><?php
                $get_img = $user['p_img'];
                $img = "../warehouse/img/$get_img";
                ?>
                <img src="<?php echo $img; ?>" width="50px">
                </td>
                <td>
                  <button name="view_btn" class="btn btn-link" data-toggle="modal" data-target="#myModal1<?php echo $user['pid']; ?>">
    			          Seller Details
    			        </button>
                  <!-- View Details modal -->
                  <div class="modal fade " id="myModal1<?php echo $user['pid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <?php
                        $query3 = "SELECT * FROM seller WHERE id='$s_id'";
                        $fire_query3 =  mysqli_query($conn,$query3);
                        $row3 = mysqli_fetch_array($fire_query3);
                        if ($row3) {
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
                      <?php } ?>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <?php if($user['status']!='0')
											{ if($user['status']!='1') {
												?>
												<label class="text-danger">DENIED</label>
											<?php }
											else {
											?>
											<label class="text-success">ACCEPTED</label>
										<?php }
											}

										else {
										?>
										Pending
									<?php } ?>
                </td>
    					</tr>
    					<?php $count=$count+1; }} ?>
    				</tbody>
    				<tfoot>
              <th>#</th>
              <th>Product Name</th>
              <th>Product Category</th>
              <th>Quantity</th>
              <th>Total Cost</th>
              <th>date</th>
              <th>image</th>
              <th>Seller Details</th>
              <th>Status</th>
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
