<?php 
    //Authorization - Access Control
    //Check whether the user is logged in or not
    if(!isset($_SESSION['user']))
    {
        // User not logged in
        //Re-direct to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel</div>";
        header('location:'.SITE_URL.'admin/login.php'); //Re-direct to login page
    }
    
?>