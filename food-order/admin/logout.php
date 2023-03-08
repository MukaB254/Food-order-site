<?php
    include('../config/constant.php');
    
    //Destroy the session and re-direct to login page
    session_destroy(); //Destroy session and unset $_SESSION['user]
    header('location:'.SITE_URL.'admin/login.php'); //Re-direct to login page
?>