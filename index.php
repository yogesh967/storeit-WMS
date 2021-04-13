<?php
include('include/connection.php');

// Login
if(isset($_POST['login-btn'])) {
  $user = mysqli_real_escape_string($conn,trim($_POST['userType']));
  $email = mysqli_real_escape_string($conn,trim($_POST['email']));
  $password = mysqli_real_escape_string($conn,trim($_POST['password']));
  $error="";

  $admin = "SELECT * FROM admin WHERE username='$email' AND password='$password'";
  $fire_admin =  mysqli_query($conn,$admin);

  $warehouse = "SELECT * FROM warehouse WHERE email='$email' AND password='$password' AND status='1'";
  $fire_warehouse =  mysqli_query($conn,$warehouse);

  $seller = "SELECT * FROM warehouse WHERE email='$email' AND password='$password' AND status='1'";
  $fire_seller =  mysqli_query($conn,$seller);

  $fetch_warehouse = mysqli_fetch_array($fire_warehouse);
  $fetch_seller = mysqli_fetch_array($fire_seller);
  $fetch_admin = mysqli_fetch_array($fire_admin);

  if ($user == 'Admin') {
    if (mysqli_num_rows($fire_admin) == 1) {
      session_start();
      $_SESSION['alogin'] = $fetch_admin['id'];
      $_SESSION['aname'] = $fetch_admin['username'];
      header("location:admin/dashboard.php");
    }

    else {
      $error = "Invalid username or Password";
    header("Location:index.php?error=".$error);
    }
  }

  elseif ($user == 'Warehouse') {
    if (mysqli_num_rows($fire_warehouse) == 1) {
      session_start();
      $_SESSION['wid'] = $fetch_warehouse['id'];
      $_SESSION['wname'] = $fetch_warehouse['name'];
      header("location:warehouse/dashboard.php");
    }

    else {
      $error = "Invalid Email or Password";
    header("Location:index.php?error=".$error);
    }
  }

  elseif ($user == 'Seller') {
    if (mysqli_num_rows($fire_seller) == 1) {
      session_start();
      $_SESSION['sid'] = $fetch['id'];
      $_SESSION['sname'] = $fetch['name'];
      header("location:seller/dashboard.php");
    }

    else {
      $error = "Invalid Email or Password";
    header("Location:index.php?error=".$error);
    }
  }
}

//  Signup
if(isset($_POST['signup-btn'])) {
  $choose_user = mysqli_real_escape_string($conn,trim($_POST['choose-user']));
  $inputname = mysqli_real_escape_string($conn,trim($_POST['Inputname']));
  $inputEmail = mysqli_real_escape_string($conn,trim($_POST['inputEmail']));
  $contact = mysqli_real_escape_string($conn,trim($_POST['contact']));
  $confirmpass = mysqli_real_escape_string($conn,trim($_POST['confirm-pass']));
  $inputaddress = mysqli_real_escape_string($conn,trim($_POST['inputAddress']));
  $state = mysqli_real_escape_string($conn,trim($_POST['stt']));
  $city = mysqli_real_escape_string($conn,trim($_POST['state']));
  $zip = mysqli_real_escape_string($conn,trim($_POST['inputZip']));
  $fileName = basename($_FILES["UploadImage"]["name"]);
  $w_email_valid = false;
  $w_contact_valid = false;
  $s_email_valid = false;
  $s_contact_valid = false;
  $success="";


// Duplicate validation
  $warehouse_e = "SELECT email FROM warehouse WHERE email='$inputEmail'";
  $warehouse_c = "SELECT contact FROM warehouse WHERE contact='$contact'";
  $w_res_e = mysqli_query($conn, $warehouse_e);
  $w_res_m = mysqli_query($conn, $warehouse_c);

  $seller_e = "SELECT email FROM seller WHERE email='$inputEmail'";
  $seller_c = "SELECT contact FROM seller WHERE contact='$contact'";
  $s_res_e = mysqli_query($conn, $seller_e);
  $s_res_m = mysqli_query($conn, $seller_c);

  if (mysqli_num_rows($w_res_e) > 0 && $choose_user == 'Warehouse') {
    $error = "Email id already exist, Try another";
    header("Location:index.php?error=".$error);
  }

  else {
    $w_email_valid = true;
  }

  if (mysqli_num_rows($w_res_m) > 0 && $choose_user == 'Warehouse') {
    $error = "Contact number already exist, Try another";
    header("Location:index.php?error=".$error);
  }

  else {
    $w_contact_valid = true;
  }

  if (mysqli_num_rows($s_res_e) > 0 && $choose_user == 'Seller') {
    $error = "Email id already exist, Try another";
    header("Location:index.php?error=".$error);
  }

  else {
    $s_email_valid = true;
  }

  if (mysqli_num_rows($s_res_m) > 0 && $choose_user == 'Seller') {
    $error = "Contact number already exist, Try another";
    header("Location:index.php?error=".$error);
  }

  else {
    $s_contact_valid = true;
  }

  if ($w_email_valid && $w_contact_valid || $s_email_valid && $s_contact_valid) {
    // Upload file
    $pname = rand(1000,10000)."-".$fileName;
    #temporary file name to store file
    $tname = $_FILES["UploadImage"]["tmp_name"];
    #upload directory path
    $uploads_dir = 'C:/xampp/htdocs/storeit-WMS/images/users';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);
  }

if ($choose_user=='Warehouse' && $w_email_valid && $w_contact_valid) {
  $query_warehouse = "INSERT INTO warehouse(name, email, password, contact, address, state, city, zip, image, status)
  VALUES('$inputname', '$inputEmail', '$confirmpass', '$contact', '$inputaddress', '$state', '$city', '$zip', '$pname', '0')";
  $fire_warehouse1 = mysqli_query($conn,$query_warehouse);
  if ($fire_warehouse1) {
    $success = "Sign Up as a warehouse Successfully";
    header("Location:index.php?success=".$success);
  }
  else {
    $error = "Sign Up as a warehouse failed!";
    header("Location:index.php?error=".$error);
  }
}

elseif ($choose_user=='Seller' && $s_email_valid && $s_contact_valid) {
  $query_seller = "INSERT INTO seller(name, email, password, contact, address, state, city, zip, image, status)
  VALUES('$inputname', '$inputEmail', '$confirmpass', '$contact', '$inputaddress', '$state', '$city', '$zip', '$pname', '0')";
  $fire_seller1 = mysqli_query($conn,$query_seller);
  if ($fire_seller1) {
    $success = "Sign Up as a seller Successfully";
    header("Location:index.php?success=".$success);
  }
  else {
    $error = "Sign Up as a seller failed!";
    header("Location:index.php?error=".$error);
  }
}
}

?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Login | StoreIt Warehouse Management System</title>

      <link rel="stylesheet" href="css/style.css" />
      <!--bootstrap core-->
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <link rel="stylesheet" href="css/bootstrap.min.css.map" />

      <!--Jquery-->
      <script src="js/jquery.js"></script>
      <!-- state city -->
      <script type="text/javascript" src="js/cities.js"></script>
      <!--bootstrap  icon-->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
      <!--Open sans font-->
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    </head>
    <body>
      <div class="container">
        <div class="row vertical-center">
          <div class="col-md-1"></div>

          <!-- Login and sign up box -->
          <div class="col-md-10 login-signup">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">Login</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="profile" aria-selected="false">Sign Up</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">

              <!-- login -->
              <div class="tab-pane fade show active login-box" id="login" role="tabpanel" aria-labelledby="login-tab">
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
                <!--Login form-->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="login" onsubmit="#" method="post">

                  <!-- User type -->
                  <div class="form-group col-md-6">
                    <label for="userType">User</label>
                      <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="bi bi-person-fill"></i>
                        </div>
                      </div>
                      <select id="userType" name="userType" class="form-control">
                        <option selected>Warehouse</option>
                        <option>Seller</option>
                        <option>Admin</option>
                      </select>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="form-group col-md-6">
                    <label for="email">Email ID</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="bi bi-envelope-fill"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Email" required />
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group col-md-6">
                  <label for="password">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="bi bi-key-fill"></i>
                      </div>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                  </div>
                </div>
                <button type="submit" id="login-btn" name="login-btn" class="btn btn-primary loginbtn mt-4"><i class="bi bi-box-arrow-in-right">
                </i>&nbsp;Login</button>

              </form>
              </div>

              <!-- Sign Up -->
              <div class="tab-pane fade show" id="signup" role="tabpanel" aria-labelledby="signup-tab">

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="signup" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="choose-user">Choose User</label>
                      <select id="choose-user" name="choose-user" class="form-control">
                        <option selected>Warehouse</option>
                        <option>Seller</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="Inputname">Name<span class="star"> *</span></label>
                      <input type="text" class="form-control" name="Inputname" id="Inputname" placeholder="Enter Warehouse or Seller full name" required />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail">Email<span class="star"> *</span></label>
                      <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Enter email address" required />
                    </div>
                    <div class="form-group col-md-6">
                      <label for="contact">Contact No.<span class="star"> *</span></label>
                      <input type="text" class="form-control" name="contact" id="contact" placeholder="Enter Contact Number" required />
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
                    <div class="form-group col-md-4">
                      <label for="sts">State<span class="star"> *</span></label>
                      <select onchange="print_city('state', this.selectedIndex);" id="sts" name ="stt" class="form-control" required></select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="state">City<span class="star"> *</span></label>
                      <select id="state" name="state" class="form-control" required></select>
                      <script language="javascript">print_state("sts");</script>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputZip">Zip<span class="star"> *</span></label>
                      <input type="text" class="form-control" name="inputZip" id="inputZip" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="UploadImage">Profile Image</label>
                    <input type="file" class="form-control" name="UploadImage" id="UploadImage" onchange="return fileValidation()" />
                  </div>
                  <button type="submit" name="signup-btn" class="btn btn-primary mt-4">Sign Up</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-1"></div>
      </div>
    </div>

    </body>
  </html>
  <!-- bootstrap core -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js.map"></script>
  <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
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
