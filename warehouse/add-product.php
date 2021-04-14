<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['wid'] AND $_SESSION['wname']) == 0) {
header('location:../index.php');
}
else {
  $wid = $_SESSION['wid'];
   // Add product
  if(isset($_POST['submit-btn'])) {
    $w_name = mysqli_real_escape_string($conn,trim($_POST['w_name']));
    $pro_name = mysqli_real_escape_string($conn,trim($_POST['pro_name']));
    $pro_catg = mysqli_real_escape_string($conn,trim($_POST['pro_catg']));
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $pdisc = mysqli_real_escape_string($conn,trim($_POST['p_disc']));
    $fileName = basename($_FILES["UploadImage"]["name"]);
    $success="";
    $error="";

    $query = "SELECT * FROM products WHERE wid='$wid'";
    $fire_query =  mysqli_query($conn,$query);
    $row = mysqli_fetch_array($fire_query);
    $check_pro= $row ["pname"];
    if ($check_pro == $pro_name) {
      $error = "Product already exist. Please go to VIEW PRODUCT and make changes you want.";
      header("Location:add-product.php?error=".$error);
    }

    else {
      // Upload file
      $pname = rand(1000,10000)."-".$fileName;
      #temporary file name to store file
      $tname = $_FILES["UploadImage"]["tmp_name"];
      #upload directory path
      $uploads_dir = 'C:/xampp/htdocs/storeit-WMS/warehouse/img';
      #TO move the uploaded file to specific location
      move_uploaded_file($tname, $uploads_dir.'/'.$pname);
      $add_pro = "INSERT INTO products(wid, wname, pname, pcategory, quantity, price_pq, pdescription, image, status)
      VALUES('$wid', '$w_name', '$pro_name', '$pro_catg', '$quantity', '$pdisc', '$pname', '1')";
      $fire_addpro = mysqli_query($conn, $add_pro);
      if ($fire_addpro) {
        $success = "Product added Successfully";
        header("Location:add-product.php?success=".$success);
      }
      else {
        $error = "ERROR!";
        header("Location:add-product.php?error=".$error);
      }
    }
  }

  // Product Category
  $pro_cat = "SELECT * FROM product_cat WHERE w_id = '$wid'";
  $fire_pcat = mysqli_query($conn, $pro_cat);
  $options = "";
  while ($row1 = mysqli_fetch_array($fire_pcat)) {
    $options = $options."<option>$row1[2]</option>";
  }

  // Product Name
  $pro_name = "SELECT * FROM pro_name WHERE w_id = '$wid'";
  $fire_pname = mysqli_query($conn, $pro_name);
  $options2 = "";
  while ($row2 = mysqli_fetch_array($fire_pname)) {
    $options2 = $options2."<option>$row2[2]</option>";
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product | StoreIt Warehouse Management System</title>

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
					 <h2 class="pg-heading">Add Product</h2>
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
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="add-product" method="post" enctype="multipart/form-data">
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="w_name">Warehouse Name</label>
             <select id="w_name" name="w_name" class="form-control">
               <option selected><?php echo $_SESSION['wname']; ?></option>
             </select>
           </div>
         </div>

         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="pro_name">Product Name<span class="star"> *</span></label>
             <select id="pro_name" name="pro_name" class="form-control" required>
               <?php echo $options2; ?>
             </select>
           </div>
         </div>
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="pro_catg">Product Category<span class="star"> *</span></label>
             <select id="pro_catg" name="pro_catg" class="form-control" required>
               <?php echo $options; ?>
             </select>
           </div>
         </div>
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="price">Price Per Quantity<span class="star"> *</span></label>
             <input type="number" class="form-control" name="price" id="price" min="1" required />
           </div>
         </div>
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="quantity">Quantity<span class="star"> *</span></label>
             <input type="number" class="form-control" name="quantity" id="quantity" min="1" required />
           </div>
         </div>
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="p_disc">Product Description</span></label>
             <input type="text" class="form-control" name="p_disc" id="p_disc" />
           </div>
         </div>
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="UploadImage">Product Image<span class="star"> *</span></label>
             <input type="file" class="form-control" name="UploadImage" id="UploadImage" onchange="return fileValidation()" required />
           </div>
       </div>
         <button type="submit" name="submit-btn" class="btn btn-primary mt-4">Submit</button>
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
  </script>
