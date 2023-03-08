<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">

        <h1>Update Admin</h1>
        <br><br>

        <?php
            //1. Get ID of selected Admin
            $id=$_GET['id'];

            //2. SQL query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //Check if query is executed or not
            if($res==true)
            {
                //Check whether data is available or not
                $count = mysqli_num_rows($res);
                //check if we have admin data or not
                if($count==1)
                {
                    //Get the details
                    //echo "<div class='success'>Admin Available</div>";
                    $row = mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username = $row['username'];

                }
                else
                {
                    $_SESSION['No-admin'] = "<div class='error'>No admin matches your criteria</div>"; //session error message
                    header('location:'.SITE_URL.'admin/manage-admin.php'); //re-direct to manage admin page
                }
            
            }
        
        ?>

        <form action="" method="POST">

            <table class="tbl-30">

                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name?>">
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username ?>">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <input type="hidden" name = "id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>
<?php 
    //Check whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        //Get all the values from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //sql query to update admin details in database
        $sql2 = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";

        //Execute the query
        $res2 = mysqli_query($conn, $sql2);

        //Check if query is executed or not
        if($res2==true)
        {
            //Query executed and admin updated
            //echo "<div class='success'>Successful</div>";
            $_SESSION['update'] = "<div class='success'> Admin Details Updated. </div>";
            header('location:'.SITE_URL.'admin/manage-admin.php');
        }
        else
        {
            //failed to update admin
            $_SESSION['update'] = "<div class='error'> Could not update Admin Details. Try again Later. </div>";
            header('location:'.SITE_URL.'admin/manage-admin.php');
        }
        

    }
?>

<?php include('partials/footer.php');?>