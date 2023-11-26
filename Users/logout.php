<?php 

session_start(); 

$_SESSION = array(); 

Session_destroy(); 

header("location: ../Users/index.php"); 
exit; 
?>
