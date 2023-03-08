<?php include('partials/menu.php')?>

        <!--Main Content Section Starts -->
        
        <div class="main-content">
            <div class="wrapper">
                <h1>Dashboard</h1>
                <br>
                <?php
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?>
                <br>

                <div class="col-4 text-center">
                    <?php 
                        // Get the categories
                        $sql = "SELECT * FROM tbl_category";
                        $res = mysqli_query($conn, $sql);
                        // Count the rows to get number of categories
                        $count = mysqli_num_rows($res);
                    ?>

                    <h1><?php echo $count;?></h1> <!-- Display the number of Categories -->
                    <br />
                    Categories
                </div>

                <div class="col-4 text-center">
                    <?php 
                        // Get the categories
                        $sql_fd = "SELECT * FROM tbl_food";
                        $res_fd = mysqli_query($conn, $sql_fd);
                        // Count the rows to get number of categories
                        $count_fd = mysqli_num_rows($res_fd);
                    ?>

                    <h1><?php echo $count_fd;?></h1>
                    <br />
                    Food
                </div>

                <div class="col-4 text-center">
                    <?php 
                        // Get the categories
                        $sql_order = "SELECT * FROM tbl_order";
                        $res_order = mysqli_query($conn, $sql_order);
                        // Count the rows to get number of categories
                        $count_order = mysqli_num_rows($res_order);
                    ?>
                    <h1><?php echo $count_order;?></h1>
                    <br />
                    Total Orders
                </div>

                <div class="col-4 text-center">
                    <?php 
                        // Get total revenue generated using aggregate function in sql
                        $sql_rev = "SELECT SUM(total) AS total FROM tbl_order WHERE status='Delivered'";
                        $res_rev = mysqli_query($conn, $sql_rev);
                        $row = mysqli_fetch_assoc($res_rev); //Getting the value
                        $total_revenue = $row['total'];
                    ?>

                    <h1>Kshs. <?php echo $total_revenue;?></h1>
                    <br />
                    Revenue Generated
                </div>

                <div class="clearfix"></div>
            </div>
        </div>

        <!--Main Content Section Ends -->

<?php include('partials/footer.php')?>