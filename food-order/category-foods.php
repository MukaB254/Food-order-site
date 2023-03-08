<?php include('partials-front/menu.php'); ?>

 <!-- Check if category id is passed or not -->
<?php
        if(isset($_GET['category_id']))
        {
            // Is passed
            $category_id = $_GET[ 'category_id' ];

            // Get category Title
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
            $res = mysqli_query($conn, $sql); //Execute the query
            $category_title = mysqli_fetch_assoc($res)[ 'title' ];

        }
        else
        {
            // Re-direct to homepage
            header('location:'.SITE_URL);
        }

    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="<?php echo SITE_URL ;?>categories.php" class="text-white">"<?php echo $category_title;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

   


    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <!-- Getting food based on category -->
            <?php

                $sql1 = "SELECT * FROM tbl_food WHERE category_id=$category_id";
                $res1 = mysqli_query($conn, $sql1); //executed query
                $count1 = mysqli_num_rows($res1); //Count rows to se if data is available

                // Check if theres data and display accordingly
                if($count1>0)
                {
                    // Food is available
                    while($row1 = mysqli_fetch_assoc($res1))
                    {
                        //Get the details
                        $fd_id = $row1[ 'id' ];
                        $fd_title = $row1[ 'title' ];
                        $price    = $row1[ 'price' ];
                        $description = $row1[ 'description' ];
                        $fd_image    = $row1[ 'image_name' ];

                        // Display the food
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <!-- Display image if one is available -->
                                <?php

                                    if($fd_image=="")
                                    {
                                        // No image available
                                        echo "<div class='error'> Image is Not Available!</div>";
                                    }
                                    else
                                    {
                                        // Image is available - Display Image
                                        ?>
                                        <img src="<?php SITE_URL;?>images/food/<?php echo $fd_image;?>" class="img-responsive img-curve">
                                        <?php
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
                    // Food not available
                    echo "<div class='error text-center'>No Food Available.</div>";
                }
            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php') ; ?>