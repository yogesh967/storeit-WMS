<?php
if(isset($_POST['signup-btn'])) {
  $choose_user = mysqli_real_escape_string($conn,trim($_POST['choose-user']));
  $inputname = mysqli_real_escape_string($conn,trim($_POST['Inputname']));
  $inputEmail = mysqli_real_escape_string($conn,trim($_POST['inputEmail']));
  $contact = mysqli_real_escape_string($conn,trim($_POST['contact']));
  $confirmpass = mysqli_real_escape_string($conn,trim($_POST['confirm-pass']));
  $inputaddress = mysqli_real_escape_string($conn,trim($_POST['inputAddress']));
  $state = mysqli_real_escape_string($conn,trim($_POST['sst']));
  $city = mysqli_real_escape_string($conn,trim($_POST['state']));
  $zip = mysqli_real_escape_string($conn,trim($_POST['inputZip']));
  $w_email_valid = false;
  $w_contact_valid = false;
  $s_email_valid = false;
  $s_contact_valid = false;
  $file_valid = false;
  $error1="";
  $success="";

  // File upload path
  $targetDir = "images/users";
  $fileName = basename($_FILES["UploadImage"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  // Allow certain file formats
  $allowTypes = array('jpg','png','jpeg');

// Duplicate validation
  $warehouse_e = "SELECT email FROM warehouse WHERE email='$inputEmail'";
  $warehouse_c = "SELECT contact FROM warehouse WHERE contact='$contact'";
  $w_res_e = mysqli_query($conn, $warehouse_e);
  $w_res_m = mysqli_query($conn, $warehouse_m);

  $seller_e = "SELECT email FROM seller WHERE email='$inputEmail'";
  $seller_c = "SELECT contact FROM seller WHERE contact='$contact'";
  $s_res_e = mysqli_query($conn, $seller_e);
  $s_res_m = mysqli_query($conn, $seller_m);

  if (mysqli_num_rows($w_res_e) > 0 && $choose_user == 'Warehouse') {
    $error1 = "Email id already exist, Try another";
    header("Location:index.php?error=".$error1);
  }

  else {
    $w_email_valid = true;
  }

  if (mysqli_num_rows($w_res_c) > 0 && $choose_user == 'Warehouse') {
    $error1 = "Contact number already exist, Try another";
    header("Location:index.php?error=".$error1);
  }

  else {
    $w_contact_valid = true;
  }

  if (mysqli_num_rows($s_res_e) > 0 && $choose_user == 'Seller') {
    $error1 = "Email id already exist, Try another";
    header("Location:index.php?error=".$error1);
  }

  else {
    $s_email_valid = true;
  }

  if (mysqli_num_rows($s_res_e) > 0 && $choose_user == 'Seller') {
    $error1 = "Contact number already exist, Try another";
    header("Location:index.php?error=".$error1);
  }

  else {
    $s_contact_valid = true;
  }

  // File validation
  if(in_array($fileType, $allowTypes)) {
    $file_valid = true;
  }

  else {
    $error1 = "Only .jpg, .png and .jpeg format allowed";
    header("Location:index.php?error1=".$error1);
  }

  $query_warehouse = "INSERT INTO warehouse(name, email, password, contact, address, state, city, zip, image, status)
  VALUES('$inputname', '$inputEmail', '$confirmpass', '$contact', '$inputaddress', '$state', '$city', '$zip', '$fileName', '0')";

  $query_seller = "INSERT INTO seller(name, email, password, contact, address, state, city, zip, images, status)
  VALUES('$inputname', '$inputEmail', '$confirmpass', '$contact', '$inputaddress', '$state', '$city', '$zip', '$fileName', '0')";

if ($choose_user=='Warehouse' && $w_email_valid && $w_contact_valid && $file_valid) {
  $fire_warehouse1 = mysqli_query($conn,$query_warehouse)
  if ($fire_warehouse1) {
    $success = "Sign Up as a warehouse Successfully";
    header("Location:index.php?success=".$success);
  }
  else {
    $error1 = "Sign Up as a warehouse failed!";
    header("Location:index.php?error1=".$error1);
  }
}

elseif ($choose_user=='Seller' && $s_email_valid && $s_contact_valid && $file_valid) {
  $fire_seller1 = mysqli_query($conn,$query_seller)
  if ($fire_seller1) {
    $success = "Sign Up as a seller Successfully";
    header("Location:index.php?success=".$success);
  }
  else {
    $error1 = "Sign Up as a seller failed!";
    header("Location:index.php?error1=".$error1);
  }
}






}
 ?>
