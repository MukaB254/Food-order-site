<?php include('../admin/partials/menu.php');?>

<div class="main-content">

    <div class="wrapper">

        <h1>Add Admin</h1>

        <br/>
        <?php
                if(isset($_SESSION['add']))//Checking whether the session is Set or not
                {
                    echo $_SESSION['add'];//Displaying Session Message
                    unset($_SESSION['add']);//Removing Session message
                }
                ?>
                <br><br>

        <form action="" method="POST">

            <table class="tbl-30">

                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter a Username">
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="PASSWORD" name="password" placeholder="Enter Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

    </div>

</div>


<?php include('../admin/partials/footer.php');?>

<?php

//Process Data From the Form and Save it
//Check Whether Submit Button is clicked or not

if(isset($_POST['submit']))
{
    //Button Clicked
    //echo "Button Clicked";

    //1. Get Data from the Form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //Password encrypted with MD5 encryption

    //2. Sql query to save data into Database
    $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        Username = '$username',
        password = '$password'
        ";

    //3. Execute the Query  and Save data in Database
     $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //4. Check whether query is executed or not and display appropriate message
    if($res==true)
    {
        //Data inserted
       //echo "Data inserted";
        //Create Session Variable to Display Message
        $_SESSION['add'] = "Admin added Successfully";
        //redirect page
        header("location:".SITE_URL.'admin/manage-admin.php');
    }
    else
    {
        //Data not inserted
        //echo "Data not inserted";
        //Create Session Variable to Display Message
        $_SESSION['add'] = "Could not add admin. Please try again";
        //redirect page
        header("location:".SITE_URL.'admin/add-admin.php');
    }
    
}

?>