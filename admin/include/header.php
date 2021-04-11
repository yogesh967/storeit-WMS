<?php
session_start();
error_reporting(0);
include('../include/connection.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:../index.php');
}
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
      <!-- Brand/logo -->
      <!-- <a class="navbar-brand" href="#">
        <img src="../images/users/1656-logo.jpg" alt="user" style="width:40px;">
      </a> -->

      <!-- Links -->
      <ul class="navbar-nav mr-auto">
      <li></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <?php echo $_SESSION['alogin'];?>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Logout</a>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</div>
