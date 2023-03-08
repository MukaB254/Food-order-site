<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }

        ?>

        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Enter your current password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="Enter new password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm new password">
                    </td>
                </tr>                

                <tr>
                    <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="SAVE" class="btn-secondary">
                    </td>
                    <td>
                        <input type="submit" name="cancel" value="CANCEL" class="btn-primary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php 
    //check whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //1.Get Data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);


        //2. Check if the user with current ID exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        $res = mysqli_query($conn, $sql); //Execute the query

        if($res==true)
        {
            //Check if data is Available or not
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                //user exists and password is correct
                //echo "user exists";
                //Check if the new password and confirmed passwords match
                if($new_password==$confirm_password)
                {
                    //update the password
                    $sql2 = "UPDATE tbl_admin SET
                        password='$new_password'
                        WHERE id=$id
                    ";

                    $res2 = mysqli_query($conn, $sql2); //execute the query

                    //check if the query is executed
                    if($res2==true)
                    {
                        //Re-direct to manage admin page with success message
                        $_SESSION['change-pwd'] = "<div class='success'> Password changed Successfully. </div>";
                        header('location:'.SITE_URL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //Re-direct to manage admin page with error
                        $_SESSION['change-pwd'] = "<div class='error'> Error Changing Password, try again later. </div>";
                        header('location:'.SITE_URL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //Re-direct to manage admin page with error message
                    $_SESSION['not-match'] = "<div class='error'> Confirm password and new password should match. </div>";
                    header('location:'.SITE_URL.'admin/manage-admin.php');
                }
                
            }
            else
            {
                //user does not exist or passwords not match
                $_SESSION['not-found'] = "<div class='error'>User not found or invalid Password. Check credentials</div>";
                header('location:'.SITE_URL.'admin/manage-admin.php');
            }
        }

    }
    elseif(isset($_POST['cancel']))
    {
    header('location:' . SITE_URL . 'admin/manage-admin.php');
    }
?>

<?php include('partials/footer.php');?>