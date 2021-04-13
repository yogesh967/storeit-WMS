<?php
session_start();
error_reporting(0);
include('../include/connection.php');
if(strlen($_SESSION['wid'] AND $_SESSION['wname']) == 0)
{
	header('location:../index.php');
}
else {
	$userid = $_SESSION['wid'];
	$query = "SELECT image FROM warehouse WHERE id='$userid'";
	$fire_query =  mysqli_query($conn,$query);
	$row = mysqli_fetch_array($fire_query);
	$get_img = $row["image"];
	$img = "../images/users/$get_img";
?>
<div class="flex-container sticky-top">
  <div class="flex-item-left">
    <button class="btn btn-warning" id="menu-toggle">Toggle Menu</button>
  </div>

  <div class="flex-item-center">
    <img src="../images/logo.png" alt="StoreIt warehouse Management System" title=""="StoreIt warehouse Management System" />
  </div>

  <div class="flex-item-right">
    <nav class="navbar navbar-expand-sm navbar-dark">
      <!-- Links -->
      <ul class="navbar-nav ml-auto">
				<a class="navbar-brand" href="#">
	        <img src="<?php echo $img; ?>" alt="user" style="width:40px;">
	      </a>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <?php
						echo $_SESSION['wname'];?>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</div>
<?php } ?>
