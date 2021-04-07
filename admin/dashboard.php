<?php
session_start();
error_reporting(0);
include('include/connection.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
else{
	?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin | StoreIt Warehouse Management System</title>
  </head>
  <body>
    <h1>Hello <?php echo $_SESSION['alogin']; ?></h1>
  </body>
</html>
<?php } ?>
