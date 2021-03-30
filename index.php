<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | StoreIt Warehouse Management System</title>

    <!--CSS Links-->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css.map" />
    <link rel="stylesheet" href="css/style.css" />


    <!--bootstrap  icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

    <!--Open sans font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!--Script links-->
    <script src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js.map"></script>
    <script type="text/javascript" src="js/cities.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
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

              <!--Login form-->
              <form action="#" name="login" onsubmit="#" method="post">

                <!-- User type -->
                <div class="form-group col-md-6">
                  <label for="userType">User</label>
                    <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="bi bi-person-fill"></i>
                      </div>
                    </div>
                    <select id="userType" class="form-control">
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
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" />
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
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                </div>
              </div>

              <button type="submit" id="login-btn" name="login-btn" class="btn loginbtn mt-1"><i class="bi bi-box-arrow-in-right">
              </i>&nbsp;Login</button>
            </form>
            </div>

            <!-- Sign Up -->
            <div class="tab-pane fade show" id="signup" role="tabpanel" aria-labelledby="signup-tab">
              <form action="#" name="signup" onsubmit="#" method="post">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="choose-user">Choose User</label>
                    <select id="choose-user" class="form-control">
                      <option selected>Warehouse</option>
                      <option>Seller</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter Warehouse or Seller full name">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="inputEmail" placeholder="Enter email address">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="contact">Contact No.</label>
                    <input type="text" class="form-control" id="contact" placeholder="Enter Contact Number">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="Enter-pass">Password<span> *</span></label>
                    <input type="password" class="form-control" id="Enter-pass" placeholder="Enter password">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="confirm_pass">Confirm Password<span> *</span></label>
                    <input type="password" class="form-control" id="confirm_pass" placeholder="Confirm password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputAddress">Address</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="Enter Address">
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="sts">State</label>
                    <select onchange="print_city('state', this.selectedIndex);" id="sts" name ="stt" class="form-control" required></select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="state">City</label>
                    <select id="state" class="form-control" required></select>
                    <script language="javascript">print_state("sts");</script>

                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="text" class="form-control" id="inputZip">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Sign Up</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
    </div>
  </div>

  </body>
</html>
