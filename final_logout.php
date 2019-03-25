<?php
//start the session so we have the values to get rid of at sign out
session_start();

//unset the session variables
unset($_SESSION['user_name']);
unset($_SESSION['user_id']);
unset($_SESSION['user_level']);

//destroy the session and set signed in to false
session_destroy();
$_SESSION['signed_in'] = false;

//redirect to the main overview page
echo 'You have been logged out.';
header("Location: final_home.php");

?>