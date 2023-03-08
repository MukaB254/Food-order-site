<?php include('partials-front/menu.php'); ?>

<?php
    // Check if ID is passed
    if(isset($_GET['id']))
    {
        // Id is passed - Get the id
        $fd_id = $_GET[ 'id' ];

        // Get details of the food 
        $sql   = "SELECT * FROM tbl_food WHERE id=$fd_id";
        $res   = mysqli_query($conn, $sql); //Execute the query
        $count = mysqli_num_rows($res);

        // Check if data is available or not
        if($count==1)
        {
            // We have data - Get data from database
            while($row = mysqli_fetch_assoc($res))
            {
                $fd_title = $row[ 'title' ];
                $price    = $row[ 'price' ];
                $image    = $row[ 'image_name' ];
            }
        }
        else
        {
            // We dont have data - Redirect to homepage
            header('location:') . SITE_URL;
        }
    }
    else
    {
        // id not passed. Re-direct to homepage
    header('location:' . SITE_URL);
    }
?>

<section class="food-search">
    <div class="container">
        
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <!-- Check if image is available and display -->
                    <?php
                        if($image=="")
                        {
                            // Image not available
                            echo "<div class='error'>Food Image Not Available!</div>";

                        }
                        else
                        {
                            // Image Available - Display the image
                            ?>
                            <img src="<?php echo SITE_URL;?>images/food/<?php echo $image;?>" class="img-responsive img-curve">
                            <?php
                        }
                    ?>                    
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $fd_title;?></h3>
                    <input type="hidden" name="food" value="<?php echo $fd_title;?>">

                    <p class="food-price">Kshs. <?php echo $price;?></p>
                    <input type="hidden" name="price" value="<?php echo $price;?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                    
                </div>

            </fieldset>
            
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <!-- Process the order -->
        <?php

            // Check if confirm order button is clicked or not
            if(isset($_POST['submit']))
            {
                // Clicked - Process the form and save order details
                $food = $_POST[ 'food' ];
                $price = $_POST[ 'price' ];
                $quantity = $_POST[ 'qty' ];
                $total    = $price * $quantity; // Tgotal price
                $order_date = date("y-m-d h:i:sa"); //Date order
                $status     = "ordered"; //status to be managed by admin i.e on-delivery, delivered, cancelled
                $cust_name  = $_POST[ 'full-name' ];
                $cust_contact = $_POST[ 'contact' ];
                $cust_email   = $_POST[ 'email' ];
                $cust_address = $_POST[ 'address' ];


                // Save order to database
            $sql1 = "INSERT INTO tbl_order SET
                food = '$food',
                price = $price,
                qty = $quantity,
                total = $total,
                order_date = '$order_date',
                status = '$status',
                customer_name = '$cust_name',
                customer_contact = '$cust_contact',
                customer_email = '$cust_email',
                customer_address = '$cust_address'
            ";

            // Execute the query
            $res1         = mysqli_query($conn, $sql1);
            // Check if data is saved successfully and re-direct
            if($res1==true)
            {
                // Order placed
                $_SESSION['order'] = "<div class='success'>Your Order is Successful. Please wait for Processing!</div>";
                header('location:' . SITE_URL); // Re-direct to homepage

            }
            else
            {
                // Order Not Placed
                $_SESSION['order'] = "<div class='error'>Could Not Place Order. Please Try Again Later!</div>";
                header('location:' . SITE_URL); // Re-direct to homepage
            }

            }

        ?>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>