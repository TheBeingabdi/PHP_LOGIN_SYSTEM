<?php
// core configuration
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_login_system/config/core.php";
 
// destroy session, it will remove ALL session settings
session_destroy();
  
//redirect to login page
header("Location: {$home_url}login.php");
?>