<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>
            <br><br>
            <?php 
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?>
            <br><br>     

            <!-- Form starts here --> 

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title::</td> 
                        <td><input type="text" name="title" placeholder="Category Title"></td>
                    </tr>

                    <tr>
                        <td>Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td> Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" ><input type="submit" name="submit" value="Add Category" class="btn-secondary"></td>
                    </tr>
                </table>
            </form>
            <!-- Form Ends here --> 

            <?php 
            
                if(isset($_POST['submit']))
                {
                    //Get value from form
                    $title = $_POST['title'];
                    //Check whether radio input is selected
                    if(isset($_POST['featured']))
                    {
                        //Get value from form
                        $featured = $_POST['featured'];
                
                    }
                    else
                    {
                        //Give default value
                        $featured = "No";
                    }

                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }
                    else
                    {
                        $active = "No";
                    }

                    //Check whether image is selected or not and set the value for image name
                    //print_r($_FILES['image']);
                    //die(); //Breaks the code from here
                    if(isset($_FILES['image']['name']))
                    {
                        //upload image
                        $image_name = $_FILES['image']['name']; //get image name

                        //upload only if file is selected
                        if($image_name !="")
                        {
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
                                header('location:'.SITE_URL.'admin/add-category.php');
                                //stop the process
                                die();
                            }
                        }
                    }
                    else
                    {
                        //Don't upload image and set image name value as blank
                        $image_name = "";
                    }
                    
                    //Insert data into database
                    $sql = "INSERT INTO tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        featured = '$featured',
                        active = '$active'
                    ";

                    //execute the query and save data in database
                    $res = mysqli_query($conn,$sql);

                    //check if query is executed successfully
                    if($res==true)
                    {
                        //Query executed and data added
                        $_SESSION['add'] = "<div class= 'Success'> Category Added Successfully <div> ";
                        //Re-direct to manage category page
                        header('location:'.SITE_URL.'admin/manage-category.php');
                    }
                    else
                    {
                        //Query not executed
                        $_SESSION['add'] = "<div class='error'> Could not Add Category</div>";
                        //Re-direct to Add category
                        header('location:'.SITE_URL.'admin/add-category.php');
                    }


                }

            ?>

        </div>
    </div>

<?php include('partials/footer.php'); ?>