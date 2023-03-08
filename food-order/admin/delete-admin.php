<?php
//Include constants.php file
include('../config/constant.php');

//1.Get id of admin to be deleted
$id = $_GET['id'];

//2.Query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//3.Redirect to manage admin page with message of success or error
$res = mysqli_query($conn, $sql);

//4. Check if query is executed successfully or not
if($res==TRUE)
{
    //Query successfully executed
    //echo "Admin Successfully Deleted";
    //Create SESSION variable to display message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";

    //redirect to manage admin page
    header('location:'.SITE_URL.'admin/manage-admin.php');
}
else
{
       //Query not executed successfuly
    //echo "Admin could not be deleted. Please try again";
     //Create SESSION variable to display message
     $_SESSION['delete'] = "<div clas= 'error'>Admin Could not be Deleted. Please Try Again Later</div>";

     //redirect to manage admin page
     header('location:'.SITE_URL.'admin/manage-admin.php');
}
?>