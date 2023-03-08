<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <!-- Get details of selected Category -->
        <?php
            if(isset($_GET['id']))
            {
                //Get id and other details            
                $id = $_GET['id']; // Get Id of the category from GET function

                //Get the details from database
                $sql = "SELECT * FROM tbl_category WHERE id=$id"; //sql to fetch the data
                $res = mysqli_query($conn, $sql); //executing sql

                //Check if the query is executed and get the data
                if($res==true)
                {
                    $count = mysqli_num_rows($res); //Count the collected data items in the database
                    //Check if data is available
                    if($count==1)
                    {
                        //echo "Category Available";
                        //Get the details of the category
                        $row = mysqli_fetch_assoc($res);
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    }
                    else
                    {
                        //Category not available or invalid input
                        $_SESSION['no-category-found'] = "<div class='error'> Category Not Found!!</div>";
                        header('location:'.SITE_URL.'admin/manage-category.php'); //Re-direct to manage category Page
                        
                    }
                    
                }
            }
            else
            {
                header('location:'.SITE_URL.'admin/manage-category.php'); //Re-direct to manage category page
            }

        ?>

        <!-- Form Starts Here -->

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value=<?php echo $title; ?>></td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                    <?php 
                                //Check whether image name is available or not
                                if($current_image!="")
                                {
                                    //Display the image
                                    ?>

                                    <img src="<?php echo SITE_URL; ?>images/category/<?php echo $current_image; ?>" width="100px">

                                    <?php
                                }
                                else
                                {
                                    //Display Message
                                    echo "<div class='error'>No Image Added</div>";
                                }
                            ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td><input type="file" name="image" ></td>
                </tr>
                
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){ echo "checked";}?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){ echo "checked";}?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){ echo "checked";}?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){ echo "checked";}?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <td><input type="submit" name="submit" value="SAVE CHANGES" class="btn-secondary"></td>
                    <td><input type="submit" name="cancel" value="CANCEL" class="btn-primary"></td>
                </tr>

            </table>
        </form>

        <!-- Form Ends Here -->

        <?php 
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //Get data from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //Update image if selected
                if(isset($_FILES['image']['name']))
                {
                    //if image is selected, we define a new image name
                    //Get the image Details
                    $image_name = $_FILES['image']['name'];

                    //check if theres image name
                    if($image_name !="")
                    {
                        //image available
                        //1. upload new image
                        //Auto-renaming Image
                        //Get image extension
                        $ext = end(explode('.',$image_name));

                        //Re-naming the image
                        $image_name = "Food_Category_".rand(000,999).".".$ext; //e.g Food_Category_103.jpg

                        $source_path = $_FILES['image']['tmp_name']; //Get source path
                        $destination_path = "../images/category/".$image_name; //Set destination path
                        $upload = move_uploaded_file($source_path,$destination_path); //Uploading the image

                        //Check if image is uploaded and if not we stop the process and re-direct with error message
                        if($upload==false)
                        {
                            //Upload error message
                            $_SESSION['upload'] = "<div class='error'> Failed to upload image!!</div>";
                            //Re-direct to add category page
                            header('location:'.SITE_URL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }
                        
                        //2. Remove current image.
                        if($current_image !="")
                        {
                            $rem_path = "../images/category/".$current_image; //the remove path

                            $remove = unlink($rem_path); //Remove the image file

                            //check if the image is removed and if not display error mesage and stop process
                            if($remove==false)
                            {
                                //Failed to remove image
                                $_SESSION['rem_fail'] = "<div class='error'>Failed to remove current image</div>";
                                header('location:'.SITE_URL.'admin/manage-category.php'); //re-direct to manage category page
                                die(); //Stop the process
                            }
                        }
                    }
                    else
                    {
                        //image not available, use current image
                        $image_name = $current_image;
                    }

                }
                else
                {
                    //if no image is selected, the image name will remain as was before
                    $image_name = $current_image;
                }

                //Update database
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                $res2 = mysqli_query($conn, $sql2);

                if($res2==true)
                {
                    //echo "success";
                    $_SESSION['update_cat'] = "<div class='success'>Category Updated Successfully!!</div>";
                    header('location:'.SITE_URL.'admin/manage-category.php'); //Re-direct to manage category page

                }
                else
                {
                    //echo "failed";
                    $_SESSION['update_cat'] = "<div class='error'>Could not update category details!!</div>";
                    header('location:'.SITE_URL.'admin/manage-category.php');
                }
            }
            elseif(isset($_POST['cancel']))
            {
                //Re-direct to manage category page with appropriate message
                $_SESSION['cancel'] = "<div class='error'> You have canceled the operation!</div>";
                header('location:'.SITE_URL.'admin/manage-category.php');
                
            }

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>