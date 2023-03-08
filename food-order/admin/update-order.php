<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order Details</h1>
        <br><br>

        <!-- Check if order id is passed -->
        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                // ID is set - Get order details
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    // Get data from the database
                $row = mysqli_fetch_assoc($res);

                $food = $row['food'];
                $price = $row['price'];
                $quantity = $row['qty'];
                $status = $row['status'];
                $name = $row['customer_name'];
                $address = $row['customer_address'];
                $contact = $row['customer_contact'];
                $date = $row['order_date'];

                }
            }
            else
            {
                // Id not set - Re-direct to manage order page
            header('location:' . SITE_URL . 'admin/manage-order.php');
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">

                <tr>
                    <td>Customer Name: </td>
                    <td><b><?php echo $name;?></b></td>
                </tr>

                <tr>
                    <td>Food Name: </td>
                    <td><b><?php echo $food;?></b></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><b><?php echo $price;?></b></td>
                </tr>

                <tr>
                    <td>Order Date: </td>
                    <td><b><?php echo $date;?></b></td>
                </tr>

                <tr>
                    <td>Quantity: </td>
                    <td><input type="number" name="qty" value="<?php echo $quantity;?>"></td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td><input type="text" name="contact" value="<?php echo $contact;?>"></td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td><input type="text" name="address" value="<?php echo $address;?>"></td>
                </tr>

                <tr>
                    <td>Order Status: </td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";};?> value="Ordered">ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";};?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";};?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";};?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="price" value="<?php echo $price;?>">
                        <input type="submit" name="submit" value="SAVE" class="btn-secondary">
                        <input type="submit" name="cancel" value="CANCEL" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <!-- Check if update button is clicked and process form accordingly -->
        <?php
            if(isset($_POST['submit']))
            {
                // Get values from form and update database
                $id = $_POST['id'];
                $price = $_POST['price'];
                $quantity = $_POST['qty'];
                $total = $price * $quantity;
                $status = $_POST['status'];
                $address = $_POST['address'];
                $contact = $_POST['contact'];
                
                // Save in Database
                $sql1 = "UPDATE tbl_order SET
                    qty = $quantity,
                    total = $total,
                    status = '$status',
                    customer_address = '$address',
                    customer_contact = '$contact'
                    WHERE id=$id
                ";

                $res1 = mysqli_query($conn, $sql1);

                // Check if updated successfully and redirect
                if($res1==true)
                {
                    // Order Updated
                    $_SESSION['order_update'] = "<div class='success'><b>Order Details Updated Successfully!<b></div>";
                    header('location:' . SITE_URL . 'admin/manage-order.php');
                }
                else
                {
                    // Could Not Update
                    $_SESSION['order_update'] = "<div class='error'>Order Details Could not be Updated!</div>";
                    header('location:' . SITE_URL . 'admin/manage-order.php');
                }
            }
            elseif(isset($_POST['cancel']))
            {
                //Cancel Update operation
                $_SESSION['cancel'] = "<div class='error'> You have cancelled the operation. No changes made!<div>";
                header('location:' . SITE_URL . 'admin/manage-order.php');
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ;?>