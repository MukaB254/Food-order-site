<?php
    include('../config/constant.php');

    //check whether id and image_name values are set
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // Get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove Physical image file if available
        if($image_name !="")
        {
            //image is available. delete image
            $path = "../images/category/".$image_name;
            $remove = unlink($path);

            //If failed to remove image stop the process and show error message
            if($remove==false)
            {
                $_SESSION['remove_img'] = "<div class='error'>Failed to remove Category Image</div>"; //error message
                header('location:'.SITE_URL.'admin/manage-category.php'); //Re-direct to manage category page
                die();
            }

            //Delete data from database
            $sql = "DELETE FROM tbl_category WHERE id = $id"; //Sql query to delete the data
            $res = mysqli_query($conn, $sql); //Executing the query

            //Check if delete is successful
            if($res==true)
            {
                //deleted successful and re-direct
                $_SESSION['delete_cat'] = "<div class='success'>Deleted Successfully</div>"; //delete success msg
                header('location:'.SITE_URL.'admin/manage-category.php'); //Re-direct to manage category page
            }
            else
            {
                //Error Message and re-directt
                $_SESSION['delete_cat'] = "<div class='error'>Failed to delete Category. Try again later</div>";
                header('location'.SITE_URL.'admin/manage-category.php');
            }

        }
        else
        {
            //Delete data from database
            $sql = "DELETE FROM tbl_category WHERE id = $id"; //Sql query to delete the data
            $res = mysqli_query($conn, $sql); //Executing the query

            //Check if delete is successful
            if($res==true)
            {
                //deleted successful and re-direct
                $_SESSION['delete_cat'] = "<div class='success'>Deleted Successfully</div>"; //delete success msg
                header('location:'.SITE_URL.'admin/manage-category.php'); //Re-direct to manage category page
            }
            else
            {
                //Error Message and re-directt
                $_SESSION['delete_cat'] = "<div class='error'>Failed to delete Category. Try again later</div>";
                header('location'.SITE_URL.'admin/manage-category.php');
            }

        }
    }
    else
    {
        //Re-direct to manage-category page
        header('location:'.SITE_URL.'admin/manage-category.php');
    }


?>