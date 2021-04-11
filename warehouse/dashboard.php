<?php
session_start();
error_reporting(0);
include('include/connection.php');
if(strlen($_SESSION['wid'])==0)
	{
header('location:index.php');
}
else{
	?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard | StoreIt Warehouse Management System</title>
  </head>
  <body>
    <h1>Hello <?php echo $_SESSION['wname']; ?></h1>
    <h2>ID <?php echo $_SESSION['wid']; ?></h2>
  </body>
</html>
<?php } ?>
