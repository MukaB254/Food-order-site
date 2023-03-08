<?php include('partials/menu.php'); ?>

    

    <div class="main-content">
        <div class="wrapper">

            <h1>Add Food</h1>
            <br>

            <?php
                if(isset($_SESSION['fd_upload']))
                {
                    echo $_SESSION['fd_upload'];
                    unset($_SESSION['fd_upload']);
                }

                if(isset($_SESSION['add_fd']))
                {
                    echo $_SESSION['add_fd'];
                    unset($_SESSION['add_fd']);
                }
            ?>
            <br>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Food Name">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price"  >
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category">
                                
                                <?php  
                                    //SQL to get all active categories from database
                                    $sql = "SELECT * FROM tbl_category WHERE  active='Yes'"; //Only displays categories that are active
                                    $res = mysqli_query($conn, $sql); //Executing the query
                                    
                                    $count = mysqli_num_rows($res); //Count rows to check if there are categogies

                                    if($count>0)
                                    {
                                        //Active categories available
                                        while($row = mysqli_fetch_assoc($res))
                                        {
                                            //Get details from the database
                                            $id = $row['id'];
                                            $title = $row['title'];

                                            //Display the categories in dropdown
                                            ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        //No active categories found
                                        ?>
                                        <option value="0">No Categories Found</option>
                                        <?php
                                    }

                                ?>

                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>

                        <td> 
                            <input type="radio" name="featured" value="Yes"> Yes 
                            <input type="radio" name="featured" value="No"> No 
                        </td>

                    </tr>

                    <tr>

                        <td>Active: </td>

                        <td>
                            <input type="radio" name="active" value="Yes"> Yes 
                            <input type="radio" name="active" value="No"> No 
                        </td>

                    </tr>

                    <tr>

                        <td colspan="2">
                            <input type="Submit" name="submit" value="submit" class="btn-secondary">
                        </td>
                        
                    </tr>

                </table>
            </form>

            <?php
                //check if submit button is clicked and re-direct accordingly
                if(isset($_POST['submit']))
                {
                    //Process the Form
                    //1. Get data from form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                    //Check for featured and active radio if selected
                    if(isset($_POST['featured']))
                    {
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        $featured = "No"; //Default value for featured when not selected
                    }

                    if(isset($_POST['active']))
                    {
                        $active = $_POST['featured'];
                    }
                    else
                    {
                        $active = "No"; //Default value for active when not selected
                    }
                    
                    //2. Rename and Upload image to Website files if selected 
                    //Check whether select image is clicked and upload only if an image is selected
                    if(isset($_FILES['image']['name']))
                    {
                        //Get details of the selected image
                        $image_name = $_FILES['image']['name'];

                        //Upload image only if an image is selected
                        if($image_name !="")
                        {
                            //Rename  and Upload Image
                            //Get image extension
                            $ext = end(explode('.',$image_name));

                            //Re-naming the image
                            $image_name = "Food_Name_".rand(000,9999).".".$ext; //e.g Food_Name_653.jpg

                            $source_path = $_FILES['image']['tmp_name']; //Get source path. i.e current image location
                            $destination_path = "../images/food/".$image_name; //Set destination path
                            $upload = move_uploaded_file($source_path,$destination_path); //Uploading the image

                            //Check if image is uploaded and if not we stop the process and re-direct with error message
                            if($upload==false)
                            {
                                
                                $_SESSION['fd_upload'] = "<div class='error'> Failed to upload image!!</div>"; //Upload error message
                                header('location:'.SITE_URL.'admin/add-food.php'); //Re-direct to add category page
                                
                                die(); //stop the process
                            }

                        }
                    }
                    else
                    {
                        $image_name = ""; //Default value for image name
                    }
                    //3. Save data in Database and Re-direct to Manage food page
                    $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price=$price,
                        image_name = '$image_name',
                        category_id=$category,
                        featured='$featured',
                        active='$active'
                    ";

                    $res2 = mysqli_query($conn, $sql2); //Execute the query

                    //Check if data is inserted or not and re-direct accordingly
                    if($res2==true)
                    {
                        //Data inserted successfully
                        $_SESSION['add_fd'] = "<div class='success'> Food added successfully</div>";
                        header('location:'.SITE_URL.'admin/manage-food.php'); //re-direct to manage food page
                    }
                    else
                    {
                        //Failed to add data
                        $_SESSION['add_fd'] = "<div class='error'> Failed to add food. Try again.</div>";
                        header('location:'.SITE_URL.'admin/add-food.php'); //re-diret to add food page
                    }
                }
            
            ?>

        </div>
    </div>

<?php include('partials/footer.php'); ?>