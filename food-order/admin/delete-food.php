<?php 
    include('../config/constant.php'); 

    //echo "delete food Page";

    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the values and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //1. Remove image from images folder if available
        if($image_name !="")
        {
            $path = "../images/food/".$image_name; //Specify the path for the image
            $remove = unlink($path); //Delete the image file

            //Check if image is removed successfully
            if($remove==false)
            {
                //Image was not removed. Re-direct with warning and stop the process
                $_SESSION['del_img'] = "<div class='error'> Failed! Could not remove Image. Try again Later!</div>";

                header('location:'.SITE_URL.'admin/manage-food.php'); //Re-direct to manage food page

                die(); //stop the process

            }
            
        }

        //2. Delete data from database
        $sql = "DELETE FROM tbl_food WHERE id=$id"; //Query to delete food from database
        $res = mysqli_query($conn, $sql); //executiing the query

        //Check if query is executed successfully and re-direct with appropriate message
        if($res==true)
        {
            $_SESSION['del_fd'] = "<div class='success'> Food Deleted Successfully! </div>"; //Success message
            header('location:'.SITE_URL.'admin/manage-food.php'); //Re-direct to manage food page
        }
        else
        {
            $_SESSION['del_fd'] = "<div class='error'> Failed! Unable to delete food. Try again later! </div>"; //Error message
            header('location:'.SITE_URL.'admin/manage-food.php'); //Re-direct to manage food page
        }
    }
    else
    {
        //Re-direct to manage food page
        $_SESSION['invalid'] = "<div class='error'> Access Denied!!</div>";
        header('location:'.SITE_URL.'admin/manage-food.php');
    }

?>
