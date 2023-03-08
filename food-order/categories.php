<?php include('partials-front/menu.php'); ?>

<!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Food By Category</h2>
            <br><br><br>

            <?php 
                // Display all active categories
            
            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res); //Count rows to see if there is data

            // Get data if there is data
            if($count>0)
            {
                // categories available
                while($row = mysqli_fetch_assoc($res))
                {
                    //Get the values
                    $id = $row['id'];
                    $title = $row['title'];
                    $image = $row['image_name'];

                    ?>
                    <a href="<?php echo SITE_URL;?>category-foods.php?category_id=<?php echo $id;?>">
                        <div class="box-3 float-container">
                            <img src="<?php echo SITE_URL;?>images/category/<?php echo $image;?>" class="img-responsive img-curve">

                            <h3 class="float-text text-white"><?php echo $title;?></h3>
                        </div>
                    </a>
                    
                    <?php
                }
            }
            else
            {
                // Categories not available
                echo "<div class='error'>Categories Unavailable at the moment. Check the foods tab.</div>";
            }
            ?>

            
           

            <div class="clearfix"></div>
        </div>
    </section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>