<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br/><br/>

        <?php
            if(isset($_SESSION['fd_upload']))
            {
                echo $_SESSION['fd_upload'];
                unset($_SESSION['fd_upload']);
            }

            if(isset($_SESSION['invalid']))
            {
                echo $_SESSION['invalid'];
                unset($_SESSION['invalid']);
            }

            if(isset($_SESSION['add_fd']))
            {
                echo $_SESSION['add_fd'];
                unset($_SESSION['add_fd']);
            }

            if(isset($_SESSION['del_fd']))
            {
                echo $_SESSION['del_fd'];
                unset($_SESSION['del_fd']);
            }
            
            if(isset($_SESSION['acess']))
            {
                echo $_SESSION['acess'];
                unset($_SESSION['acess']);
            }

            if(isset($_SESSION['cancel']))
            {
                echo $_SESSION['cancel'];
                unset($_SESSION['cancel']);
            }

            if(isset($_SESSION['fd_update']))
            {
                echo $_SESSION['fd_update'];
                unset($_SESSION['fd_update']);
            }

            if(isset($_SESSION['nw_upload']))
            {
                echo $_SESSION['nw_upload'];
                unset($_SESSION['nw_upload']);
            }

            if(isset($_SESSION['fd_update_stat']))
            {
                echo $_SESSION['fd_update_stat'];
                unset($_SESSION['fd_update_stat']);
            }

            if(isset($_SESSION['fd-upd']))
            {
                echo $_SESSION['fd-upd'];
                unset($_SESSION['fd-upd']);
            }

            if(isset($_SESSION['img_upload']))
            {
                echo $_SESSION['img_upload'];
                unset($_SESSION['img_upload']);
            }

            if(isset($_SESSION['rem_fail']))
            {
                echo $_SESSION['rem_fail'];
                unset($_SESSION['rem_fail']);
            }

        ?>
        <br><br>

        <!-- Button to Add Food-->
        <a href="<?php echo SITE_URL ;?>admin/add-food.php" class="btn-primary">Add Food</a>

        <br/><br/><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title </th>
                <th>Price </th>
                <th>Image </th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <!-- Get data from Database -->
            <?php

                $sql = "SELECT * FROM tbl_food"; //Sql to get data rom the database
                $res = mysqli_query($conn, $sql); //Execute the query
                $count = mysqli_num_rows($res); //Count rows to see if data is availabe

                $sn = 1; //Set variable for S.N(serial Number)

                //Check if data is available in database
                if($count>0)
                {
                    //Get data from the database
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        //Display the data in the table
                        ?>
                        <tr>
                            <td> <?php echo $sn++; ?> </td>

                            <td> <?php echo $title; ?> </td>

                            <td> <?php echo $price; ?> </td>

                            <td>
                                <?php

                                    //Display image where image is available
                                    if($image_name !="")
                                    {
                                        //Fetch the image and display it
                                        ?>

                                        <img src="<?php echo SITE_URL; ?>images/food/<?php echo $image_name; ?>" width="100px">

                                        <?php
                                    }
                                    else
                                    {
                                        echo "<div class='error'> No image Added. </div>";
                                    }


                                ?>
                            </td>

                            <td> <?php echo $featured; ?> </td>

                            <td> <?php echo $active; ?> </td>

                            <td>
                                <a href="<?php echo SITE_URL; ?>admin/food-update.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                <a href="<?php echo SITE_URL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                            </td>

                        </tr>

                        <?php

                    }

                }
                else
                {
                    
                    echo "<tr> <td colspan='7' class='error'> No Food Added Yet!! </td> </tr>";

                }
            ?>

            

        </table>

    </div>
</div>

<?php include('partials/footer.php') ?>