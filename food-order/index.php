<?php include('partials-front/menu.php'); ?>
    <!-- Navbar Section Ends Here -->
    <?php include('partials-front/search.php'); ?>
    <!-- fOOD sEARCH Section Ends Here -->
    <br> <br>
    <!-- Session Messages -->
    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            
            <?php 
                // Get categories from database and display them
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3"; //SQL to get categories from database
                $res = $conn->query($sql); //executing the query
                $count = mysqli_num_rows($res); //count rows to check if categories are available

                if($count>0)
                {
                    //Categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values i.e Title, Image Name and id
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];

                        ?>

                        <a href="<?php echo SITE_URL; ?>category-foods.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">
                                <?php
                                    //Display Image when image name is available
                                    if($image_name=="")
                                    {
                                        //Image not available
                                        echo "<div class='error'>Image Not available</div>";
                                    }
                                    else
                                    {
                                        //Image available
                                        ?>
                                        <img src="<?php echo SITE_URL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title;?>" class="img-responsive img-curve">
                                        <?php

                                    }
                                ?>

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    // categories not available
                    echo "<div class='error'> Categories not available at the moment.</div>";
                }

            ?>
            
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                // Getting food from the database that is active and featured
            $sql1 = "SELECT * FROM tbl_food WHERE featured = 'Yes' AND active = 'Yes'"; //SQL query to get food from database
            $res1 = mysqli_query($conn, $sql1); // Execute the query
            $count1 = mysqli_num_rows($res1); //Count rows to see if data is available

            if($count1>0)
            {
                // There is data in the database
                while($row1 = mysqli_fetch_assoc($res1))
                {
                    $fd_id = $row1['id'];
                    $fd_title = $row1['title'];
                    $description = $row1['description'];
                    $price = $row1['price'];
                    $fd_img = $row1['image_name'];

                    // Display on the webpage
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <!-- cHECK IF IMAGE IS AVAILABLE AND DISPLAY -->
                            <?php
                                if($fd_img !="")
                                {
                                    // image is available
                                    ?>
                                    <img src="<?php echo SITE_URL;?>images/food/<?php echo $fd_img;?>" alt="<?php echo $fd_img;?>" class="img-responsive img-curve">
                                    <?php
                                }
                                else
                                {
                                    echo "<div class='error'> Food Image Not Available at the moment.</div>";
                                }
                            ?>
                            
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $fd_title;?></h4>
                            <p class="food-price">Kshs. <?php echo $price;?></p>
                            <p class="food-detail">
                                <!-- Check if there's a description. if not, display no description -->
                                <?php
                                    if($description !="")
                                    {
                                        //Display Description
                                        echo $description;
                                    }
                                    else
                                    {
                                        echo "No Food Details";
                                    }
                                ?>
                            </p>
                            <br>

                            <a href="<?php echo SITE_URL; ?>order.php?id=<?php echo $fd_id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
           {
                //No featured and active food in database
                echo "<div class='error'> No featured food yet. Check food or categories tab to view available food.</div>";
           }
            ?>

            <div class="clearfix"></div>

        </div>

        <p class="text-center">
            <a href="<?php echo SITE_URL;?>foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>