<?php
session_start();
unset($_SESSION["alogin"]);
unset($_SESSION["aname"]);
session_destroy();
header("Location:../index.php");
?>
