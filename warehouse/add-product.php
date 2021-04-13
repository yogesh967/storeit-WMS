<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['wid'] AND $_SESSION['wname']) == 0) {
header('location:../index.php');
}
else {
   // Add product
  if(isset($_POST['submit-btn'])) {
    $wid = $_POST['wid'];
    $inputEmail = mysqli_real_escape_string($conn,trim($_POST['w_name']));
    $contact = mysqli_real_escape_string($conn,trim($_POST['pro_name']));
    $confirmpass = mysqli_real_escape_string($conn,trim($_POST['pro_catlg']));
    $inputaddress = $_POST['quantity'];
    $state = mysqli_real_escape_string($conn,trim($_POST['p_disc']));
    $fileName = basename($_FILES["UploadImage"]["name"]);
    $success="";
    $error="";


  // Duplicate validation
    $warehouse_e = "SELECT email FROM warehouse WHERE email='$inputEmail'";
    $warehouse_c = "SELECT contact FROM warehouse WHERE contact='$contact'";
    $w_res_e = mysqli_query($conn, $warehouse_e);
    $w_res_m = mysqli_query($conn, $warehouse_c);

    if (mysqli_num_rows($w_res_e) > 0) {
      $error = "Email id already exist, Try another";
      header("Location:add-warehouse.php?error=".$error);
    }

    else {
      $w_email_valid = true;
    }

    if (mysqli_num_rows($w_res_m) > 0) {
      $error = "Contact number already exist, Try another";
      header("Location:add-warehouse.php?error=".$error);
    }

    else {
      $w_contact_valid = true;
    }

  if ($w_email_valid && $w_contact_valid) {
    // Upload file
    $pname = rand(1000,10000)."-".$fileName;
    #temporary file name to store file
    $tname = $_FILES["UploadImage"]["tmp_name"];
    #upload directory path
    $uploads_dir = 'C:/xampp/htdocs/storeit-WMS/images/users';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);
    $query_warehouse = "INSERT INTO warehouse(name, email, password, contact, address, state, city, zip, image, status)
    VALUES('$inputname', '$inputEmail', '$confirmpass', '$contact', '$inputaddress', '$state', '$city', '$zip', '$pname', '1')";
    $fire_warehouse1 = mysqli_query($conn,$query_warehouse);
    if ($fire_warehouse1) {
      $success = "Warehouse added Successfully";
      header("Location:add-warehouse.php?success=".$success);
    }
    else {
      $error = "ERROR!";
      header("Location:add-warehouse.php?error=".$error);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Warehouse | StoreIt Warehouse Management System</title>

		<!--bootstrap core-->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css.map" />
		<!-- custom style -->
		<link rel="stylesheet" href="../admin/css/adminstyle.css">
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
					 <h1 class="pg-heading">Add Product</h1>
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
             <input type="hidden" name="wid" value="<?php echo $_SESSION['wid']; ?>" />
             <label for="w_name">Warehouse Name</label>
             <select id="w_name" name="w_name" class="form-control">
               <option selected><?php echo $_SESSION['wname']; ?></option>
             </select>
           </div>
         </div>

         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="pro_name">Product Name<span class="star"> *</span></label>
             <input type="text" class="form-control" name="pro_name" id="pro_name" placeholder="Enter Product Name" required />
           </div>
         </div>
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="pro_catlg">Product Category<span class="star"> *</span></label>
             <input type="text" class="form-control" name="pro_catlg" id="pro_catlg" placeholder="Enter Product Category" required />
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
         <div class="form-group col-md-6">
           <label for="UploadImage">Product Image</label>
           <input type="file" class="form-control" name="UploadImage" id="UploadImage" onchange="return fileValidation()" required />
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
