<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br/>

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['remove_img']))
            {
                echo $_SESSION['remove_img'];
                unset($_SESSION['remove_img']);
            }

            if(isset($_SESSION['delete_cat']))
            {
                echo $_SESSION['delete_cat'];
                unset($_SESSION['delete_cat']);
            }

            if(isset($_SESSION['no-category-found']))
            {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }

            if(isset($_SESSION['update_cat']))
            {
                echo $_SESSION['update_cat'];
                unset($_SESSION['update_cat']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['rem_fail']))
            {
                echo $_SESSION['rem_fail'];
                unset($_SESSION['rem_fail']);
            }

            if(isset($_SESSION['cancel']))
            {
                echo $_SESSION['cancel'];
                unset($_SESSION['cancel']);
            }
            
        ?>
        <br><br>

<!-- Button to Add Category-->
<a href="<?php echo SITE_URL;?>admin/add-category.php" class="btn-primary">Add Category</a>

<br/><br/>

<table class="tbl-full">
    <tr>
        <th>S.N</th>
        <th>Title</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>

    <!-- Get data from database-->
    <?php 
        $sql = "SELECT * FROM tbl_category"; //query to get all category
        $res = mysqli_query($conn,$sql); //execute the query
        $count = mysqli_num_rows($res); //count the rows

        $sn = 1; //Serial Number Variable

        //check whether we have data in database or not and display available data
        if($count>0)
        {
            //we have data to display
            while($row=mysqli_fetch_assoc($res))
            {
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];

                ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>
                            <?php 
                                //Check whether image name is available or not
                                if($image_name!="")
                                {
                                    //Display the image
                                    ?>

                                    <img src="<?php echo SITE_URL; ?>images/category/<?php echo $image_name; ?>" width="100px">

                                    <?php
                                }
                                else
                                {
                                    //Display Message
                                    echo "<div class='error'>No Image Added</div>";
                                }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITE_URL;?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITE_URL;?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                        </td>
                    </tr>

                <?php

            }

        }
        else
        {
            //we do not have data
           //message displayed.
           ?>

            <tr>
                <td colspan="6" class="error text-center">No Category Added.</td>
            </tr>

           <?php
        }
        
    ?>

    

</table>

    </div>
</div>

<?php include('partials/footer.php') ?>