<?php
include("../include/connection.php");
session_start();
error_reporting(0);

if(strlen($_SESSION['alogin'] AND $_SESSION['aname']) == 0) {
header('location:../index.php');
}
else {
  //  Signup
  if(isset($_POST['submit-btn'])) {
    $inputname = mysqli_real_escape_string($conn,trim($_POST['Inputname']));
    $inputEmail = mysqli_real_escape_string($conn,trim($_POST['inputEmail']));
    $contact = mysqli_real_escape_string($conn,trim($_POST['contact']));
    $confirmpass = mysqli_real_escape_string($conn,trim($_POST['confirm-pass']));
    $inputaddress = mysqli_real_escape_string($conn,trim($_POST['inputAddress']));
    $state = mysqli_real_escape_string($conn,trim($_POST['stt']));
    $city = mysqli_real_escape_string($conn,trim($_POST['state']));
    $zip = mysqli_real_escape_string($conn,trim($_POST['inputZip']));
    $fileName = basename($_FILES["UploadImage"]["name"]);
    $s_email_valid = false;
    $s_contact_valid = false;
    $success="";
    $error="";


  // Duplicate validation
    $seller_e = "SELECT email FROM seller WHERE email='$inputEmail'";
    $seller_c = "SELECT contact FROM seller WHERE contact='$contact'";
    $s_res_e = mysqli_query($conn, $seller_e);
    $s_res_m = mysqli_query($conn, $seller_c);

    if (mysqli_num_rows($s_res_e) > 0) {
      $error = "Email id already exist, Try another";
      header("Location:add-seller.php?error=".$error);
    }

    else {
      $s_email_valid = true;
    }

    if (mysqli_num_rows($s_res_m) > 0) {
      $error = "Contact number already exist, Try another";
      header("Location:add-seller.php?error=".$error);
    }

    else {
      $s_contact_valid = true;
    }

  if ($s_email_valid && $s_contact_valid) {
    // Upload file
    $pname = rand(1000,10000)."-".$fileName;
    #temporary file name to store file
    $tname = $_FILES["UploadImage"]["tmp_name"];
    #upload directory path
    $uploads_dir = 'C:/xampp/htdocs/storeit-WMS/images/users';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);

    $query_seller = "INSERT INTO seller(name, email, password, contact, address, state, city, zip, image, status)
    VALUES('$inputname', '$inputEmail', '$confirmpass', '$contact', '$inputaddress', '$state', '$city', '$zip', '$pname', '1')";
    $fire_seller1 = mysqli_query($conn,$query_seller);
    if ($fire_seller1) {
      $success = "Seller added Successfully";
      header("Location:add-seller.php?success=".$success);
    }
    else {
      $error = "ERROR!";
      header("Location:add-seller.php?error=".$error);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Seller | StoreIt Warehouse Management System</title>

		<!--bootstrap core-->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css.map" />
		<!-- custom style -->
		<link rel="stylesheet" href="css/adminstyle.css">
		<!--Jquery-->
		<script src="../js/jquery.js"></script>
		<!-- state city -->
		<script type="text/javascript" src="../js/cities.js"></script>
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
					 <h1 class="pg-heading">Add Seller</h1>
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
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="signup" method="post" enctype="multipart/form-data">
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="Inputname">Name<span class="star"> *</span></label>
             <input type="text" class="form-control" name="Inputname" id="Inputname" placeholder="Enter Seller full name" required />
           </div>
           <div class="form-group col-md-6">
             <label for="inputEmail">Email<span class="star"> *</span></label>
             <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Enter email address" required />
           </div>
         </div>

         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="enter-pass">Password<span class="star"> *</span></label>
             <input type="password" class="form-control" name="enter-pass" id="enter-pass" placeholder="Enter password" required />
           </div>
           <div class="form-group col-md-6">
             <label for="confirm-pass">Confirm Password<span class="star"> *</span></label>
             <input type="password" class="form-control" name="confirm-pass" id="confirm-pass" placeholder="Confirm password" onChange="onChange()" required />
             <div>
               <span id='message'></span>
             </div>
           </div>
         </div>
         <div class="form-group">
           <label for="inputAddress">Address<span class="star"> *</span></label>
           <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Enter Address" required />
         </div>
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="sts">State<span class="star"> *</span></label>
             <select onchange="print_city('state', this.selectedIndex);" id="sts" name ="stt" class="form-control" required></select>
           </div>
           <div class="form-group col-md-6">
             <label for="state">City<span class="star"> *</span></label>
             <select id="state" name="state" class="form-control" required></select>
             <script language="javascript">print_state("sts");</script>
           </div>
         </div>
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="inputZip">Zip<span class="star"> *</span></label>
             <input type="text" class="form-control" name="inputZip" id="inputZip" required />
           </div>
           <div class="form-group col-md-6">
             <label for="contact">Contact No.<span class="star"> *</span></label>
             <input type="text" class="form-control" name="contact" id="contact" placeholder="Enter Contact Number" required />
           </div>
         </div>
         <div class="form-group">
           <label for="UploadImage">Profile Image</label>
           <input type="file" class="form-control" name="UploadImage" id="UploadImage" onchange="return fileValidation()" />
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
