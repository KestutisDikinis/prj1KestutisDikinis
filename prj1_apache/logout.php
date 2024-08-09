<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();

session_unset();
session_destroy();
 
// Redirect to index page
header("location: index.php");
exit;
?>