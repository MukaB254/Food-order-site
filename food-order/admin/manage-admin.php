<?php include('partials/menu.php')?>

        <!--Main Content Section Starts -->

        <div class="main-content">

            <div class="wrapper">
                <h1>Manage Admin</h1>

                <br/>
                <?php

                if(isset($_SESSION['add']))//Checking whether the session is Set or not
                {
                    echo $_SESSION['add'];//Displaying Session Message
                    unset($_SESSION['add']);//Removing Session message
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }  
                
                if(isset($_SESSION['not-found']))
                {
                    echo $_SESSION['not-found'];
                    unset($_SESSION['not-found']);
                }

                if(isset($_SESSION['No-admin']))
                {
                    echo $_SESSION['No-admin'];
                    unset($_SESSION['No-admin']);
                }

                if(isset($_SESSION['not-match']))
                {
                    echo $_SESSION['not-match'];
                    unset($_SESSION['not-match']);
                }

                if(isset($_SESSION['change-pwd']))
                {
                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }

                ?>
                <br><br>

                <!-- Button to Add Admin-->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>

                <br/><br/>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        $sql="SELECT * FROM tbl_admin"; //Query to get all admin
                        $res = mysqli_query($conn, $sql); //Executing the query

                        //Check if the query is executed or not
                        if($res==TRUE)
                        {
                            //Count rows to check if there is data in Database
                            $count = mysqli_num_rows($res);//function to get all rows in database

                            $sn = 1; //Create a variable and assign the Value

                            //Check the number of rows
                            if($count>0)
                            {
                                //We have data in Database
                                while($rows = mysqli_fetch_assoc($res))
                                {
                                    //Using while loop to get all the data from Database
                                    //While loop will execute itself while there is data in database

                                    //Get individual data
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    ?>
                                    <!--Display the values in the table -->

                                    <tr>
                                        <td><?php echo $sn++ ?></td>
                                        <td><?php echo $full_name ?></td>
                                        <td><?php echo $username ?></td>
                                        <td>
                                            <a href="<?php echo SITE_URL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITE_URL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITE_URL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                    </tr>
                                   <?php

                                }
                            }

                        }
                    ?>
                    
                </table>

            </div>

        </div>

        <!--Main Content Section Ends -->

    <?php include('partials/footer.php')?>