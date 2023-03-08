<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br><br>

        <?php
            if(isset($_SESSION['order_update'])) 
            {
                echo $_SESSION['order_update'];
                unset($_SESSION['order_update']);
            }
            if(isset($_SESSION['cancel']))
            {
                echo $_SESSION['cancel'];
                unset($_SESSION['cancel']);
            }
        ?>
        <br>   

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <!-- Get Data From Database And Display. - Allow Admin Actions -->
            <?php
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //dISPLAY LATEST ORDER FIRST
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $sn = 1;

                // Check if theres data in database and display
                if($count>0)
                {
                    // Data is available - fetch data
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // Get data
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $quantity = $row['qty'];
                        $total = $row['total'];
                        $date = $row['order_date'];
                        $status = $row['status'];
                        $cust_name = $row['customer_name'];
                        $contact = $row['customer_contact'];
                        $email = $row['customer_email'];
                        $address = $row['customer_address'];
                        
                        ?>
                        
                        <!-- Dispaly in table -->
                        <tr>
                            <td><?php echo $sn++;?></td>
                            <td><?php echo $food ;?></td>
                            <td><?php echo $price ;?></td>
                            <td class="text-center"><?php echo $quantity;?></td>
                            <td><?php echo $total;?></td>
                            <td><?php echo $date;?></td>
                            <td>
                                <?php
                                    if($status=="Ordered")
                                    {
                                        echo "<label style='color: black;'>$status</label>";
                                    }
                                    elseif($status=="On Delivery")
                                    {
                                        echo "<label style='color: orange;'>$status</label>";
                                    }
                                    elseif($status=="Delivered")
                                    {
                                        echo "<label style='color: green;'>$status</label>";
                                    }
                                    elseif($status=="Cancelled")
                                    {
                                        echo "<label style='color: red;'>$status</label>";
                                    }
                                ?>
                            </td>
                            <td><?php echo $cust_name;?></td>
                            <td><?php echo $contact;?></td>
                            <td><?php echo $email;?></td>
                            <td><?php echo $address;?></td>
                            <td>
                                <a href="<?php echo SITE_URL;?>admin/update-order.php?id=<?php echo $id;?>" class="btn-secondary">Manage</a>
                            </td>
                        </tr>

                        <?php
                    }

                }
                else
                {
                    // No data available
                    echo "<tr><td colspan='12' class='error'>No Orders Made Yet!</td></tr>";
                }
            ?>

        </table>

    </div>
</div>

<?php include('partials/footer.php') ?>