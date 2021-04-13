<?php
session_start();
unset($_SESSION["wid"]);
unset($_SESSION["wname"]);
session_destroy();
header("Location:../index.php");
?>
