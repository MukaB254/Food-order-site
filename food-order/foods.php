<?php include('partials-front/menu.php'); ?>

    <?php include('partials-front/search.php');?>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <!-- Display Food that is active -->
            <?php
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                
                // Check whether food is available
                if($count>0)
                {
                    // food is available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $fd_id       = $row[ 'id' ];
                        $title = $row['title'];
                        $image = $row['image_name'];
                        $price = $row['price'];
                        $description = $row['description'];

                        // Display on website
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <!-- Check if image is available to display -->
                                <?php
                                if ($image != "") 
                                {
                                    // Image available
                                    ?>
                                    <img src="<?php echo SITE_URL; ?>images/food/<?php echo $image; ?>" class="img-responsive img-curve">
                                    <?php
                                }   
                                else
                                {
                                    // Image Not Available
                                    echo "<div class='error'>Image not Available.</div>";
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
                    // Food is not available
                echo "<div class='error'> No food Available Now! Check In later!</div>";
                }
            ?>




            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>