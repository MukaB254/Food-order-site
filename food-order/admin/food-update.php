<?php include('partials/menu.php'); ?>
<!-- Get details of the selected category -->
<?php

if(isset($_GET['id']))
{
    //Get id and other details
    $id = $_GET['id'];

    $sql = "SELECT * FROM tbl_food WHERE id=$id"; //SQL to get details of selected food
    $res = mysqli_query($conn, $sql); //Executing SQL

    //Get data from database
    $row = mysqli_fetch_assoc($res);

    $title = $row['title'];
    $description = $row['description'];
    $price = $row['price'];
    $current_category = $row['category_id'];
    $current_image = $row['image_name'];
    $featured = $row['featured'];
    $active = $row['active'];

}
else
{
    header('location:'. SITE_URL .'admin/manage-food.php');
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br><br>

            <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="21" rows="5"><?php echo $description;?></textarea></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <!-- Display image if available -->
                        <?php

                            if($current_image=="")
                            {
                                // image not available
                                echo "<div class='error'>No image uploaded!!</div>";
                            }
                            else
                            {
                                // Display available uploaded image
                                ?>
                                <img src='<?php echo SITE_URL; ?>images/food/<?php echo $current_image;?>' width='140'>;
                                <?php
                            }

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Update Image: </td>
                    <td><input type="file" name="new-image" value="Upload Image"></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <!-- Get Categories from database and display them in dropdown -->
                            <?php
                                $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'"; //Query to select active categories
                                $res2 = mysqli_query($conn, $sql2); //Executing the query
                                $count2 = mysqli_num_rows($res2); //Count rows to check if data is available

                                if($count2>0)
                                {
                                    //Active categories available in database
                                    while($row2 = mysqli_fetch_assoc($res2))
                                    {
                                        $category_title = $row2['title'];
                                        $category_id = $row2['id'];

                                        // echo "<option>$category_title</option>";
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id; ?>"> <?php echo $category_title; ?></option>    
                                        <?php
                                    }

                                }
                                else
                                {
                                    //Active categories not available
                                    ?>
                                    <option value='0' class='error'>No active Categories available</option>
                                    <?php
                                }
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="submit" name="submit" value="SAVE" class="btn-secondary">
                        
                    </td>
                    <td><input type="submit" name="cancel" value="CANCEL" class="btn-primary"></td>
                </tr>

            </table>
        </form>
        <!-- Process the form -->

        <?php 

            if(isset($_POST['cancel']))
            {
                $_SESSION['cancel'] = "<div class='error'>You have cancelled the operation. No changes were made.</div>";
                header('location:'.SITE_URL.'admin/manage-food.php');
                die();
            }
            elseif(isset($_POST['submit']))
            {
                //  Get details from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_img = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // Update image if upload button is clicked
                if(isset($_FILES['new-image']['name']))
                {
                    //update image
                    $img = $_FILES['new-image']['name']; //Image name for new image
                    // Check if a file is selected.
                    if($img !="")
                    {
                        //Image is selected. Proceed Upload
                        $ext = pathinfo($_FILES["new-image"]["name"], PATHINFO_EXTENSION);;
                        $image_name = "Food_Name_".rand(0000,9999).'.'.$ext;
                        // Upload Image
                        $dest_path = "../images/food/".$image_name; //Destination Path
                        $src_path = $_FILES['new-image']['tmp_name']; //SOurce Path
                        $upload = move_uploaded_file($src_path, $dest_path); //Moving the image

                        // Check if upload is successful and act accordingly
                        if($upload==false)
                        {
                            $_SESSION['img_update'] = "<div class='error'>Error Uploading image.</div>";
                            header('location:').SITE_URL.'admin/manage-food.php';
                            die();
                        }
                        // Remove current image if available
                        if($current_img !="")
                        {
                            //remove current image
                            $rem_path = "../images/food/".$current_image;

                            $remove = unlink($rem_path); //Removing the image

                            // Check if image is removed or not
                            if($remove==false)
                            {
                                //Failed to remove current image
                                $_SESSION['rem_fail'] = "<div class='error'>Failed to remove Current image</div>";
                                header('location:'.SITE_URL.'admin/manage-food.php');
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_img;
                    }
                }
                else
                {
                    $image_name = $current_img;
                }

                // Update database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";

                $res3 = mysqli_query($conn, $sql3);

                if($res3==true)
                {
                    $_SESSION['fd-upd'] = "<div class='success'> Food updated Successfully!</div>";
                    header('location:' . SITE_URL . 'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['fd-upd'] = "<div class='error'> Food could not be updated Successfully!</div>";
                    header('location:'.SITE_URL.'admin/manage-food.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>