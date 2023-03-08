<?php include('../config/constant.php'); ?>

<html class="main-content">
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <br><br>
    
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br>
            <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            ?>
            <br>

            <!--Login form starts here -->
            <form action="" method="POST" class="text-center">
                Username : 
                <br>
                <input type="text" name="username" placeholder="Username Here">
                <br><br>
                Password : 
                <br>
                <input type="password" name="password" placeholder="password Here">
                <br><br>

                <input type="submit" name="submit" value="Login" class="btn-secondary">
                <br><br>
            </form>

            <p class="text-center">Created by - Broucewilies Mukaisi</p>

        </div>
        
    </body>

</html>

<?php 
    //Check whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // Get Data from the Form
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password'])); // Password encrypted with MD5 encryption

        // Check if the username and password exist in database
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'"; //sql to get the data from database
        $res = mysqli_query($conn, $sql); //execute query

        $count = mysqli_num_rows($res); // Check if data is available

        if($count==true)
        {
            //User exists and credentials are correct
            $_SESSION['login'] = "<div class='success'>Login Successful!</div>";
            $_SESSION['user'] = $username; //To check whether the user is logged in or not. Logout will unset it.
            //Redirect to  Dashboard
            header('location:'.SITE_URL.'admin/');

        }
        else
        {
            //Data does not match database
            $_SESSION['login'] = "<div class='error text-center'>Invalid Username or Password!</div>";
            //Re-direct to login page
            header('location:'.SITE_URL.'admin/login.php');

        }
    }

    
?>