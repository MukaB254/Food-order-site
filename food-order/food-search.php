<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <?php 
                // Get the search keyword
                // $search = $_POST['search'];
                $search = mysqli_real_escape_string($conn, $_POST['search']);
            ?>
            
            <h2>Foods on Your Search <a href="<?php SITE_URL;?>foods.php" class="text-white">"<?php echo $search;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
 
                // Sql to ge food based on search
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
                $res = mysqli_query($conn, $sql); // Executing the query
                $count = mysqli_num_rows($res); // Count rows to check if we have the data
                
                if($count>0)
                {
                    // Food available... Get values
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $fd_id = $row['id'];
                        $title = $row[ 'title' ];
                        $price = $row[ 'price' ];
                        $description = $row[ 'description' ];
                        $image = $row[ 'image_name' ];

                        // Display Items on website
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    if($image=="")
                                    {
                                        // Image not available
                                        echo "Image Not Available";
                                    }
                                    else
                                    {
                                        // Image Available
                                        ?>
                                        <img src="<?php echo SITE_URL;?>images/food/<?php echo $image;?>"  class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title;?></h4>
                                <p class="food-price">Kshs. <?php echo $price;?></p>
                                <p class="food-detail">
                                    <?php
                                        if($description !="")
                                        {
                                            //Display Description
                                            echo $description;
                                        }
                                        else
                                        {
                                            echo "<div class='error'>No Food Details</div>";
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
                    echo "<div class='error'>Food Not Available!</div>";
                }
            ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>