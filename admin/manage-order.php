<?php include('partials/menu.php'); ?>

        <!--main content section start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>manage order</h1>
                <?php
    
                    if(isset($_SESSION['update']))//checkin sessin is set or not
                    {
                        echo $_SESSION['update'];//display message
                        unset($_SESSION['update']);//remove message
                    }

                ?>
                
                <table class="tbl-full">
                    <tr>
                        <th>s.no.</th>
                        <th>food</th>
                        <th>price(Rs)</th>
                        <th>qty</th>
                        <th>total(Rs)</th>
                        <th>order date</th>
                        <th>status</th>
                        <th>customer name</th>
                        <th>contact</th>
                        <th>email</th>
                        <th>address</th>
                        <th>action</th>
                    </tr>

                    <?php
                        //get all data from database
                        $sql="SELECT * FROM tbl_order ORDER BY id DESC";
                        //execute the query
                        $res=mysqli_query($conn,$sql);
                        //count the rows
                        $count=mysqli_num_rows($res);
                        
                        $sn=1;

                        if($count>0)
                        {
                            //order available
                            while($row=mysqli_fetch_assoc(($res)))
                            {
                                //get all the data
                                $id = $row['id'];
                                $food = $row['food'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $row['total'];
                                $order_date =$row['order_date'];
                                $status = $row['status'];
                                $customer_name=$row['customer_name'];
                                $customer_contact=$row['customer_contact'];
                                $customer_email=$row['customer_email'];
                                $customer_address=$row['customer_address'];
                                
                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $food; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $order_date; ?></td>

                                        <td>
                                            <?php 
                                                //ordered , on delivery, delivered, cancelled
                                                if($status=="ordered")
                                                {
                                                    echo "<lebel>$status</label>";
                                                }
                                                elseif($status=="on delivery")
                                                {
                                                    echo "<lebel style='color: orange;'>$status</label>";
                                                }
                                                elseif($status=="delivered")
                                                {
                                                    echo "<lebel style='color: green;'>$status</label>";
                                                }
                                                elseif($status=="cancelled")
                                                {
                                                    echo "<lebel style='color: red;'>$status</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $customer_name; ?></td>
                                        <td><?php echo $customer_contact; ?></td>
                                        <td><?php echo $customer_email; ?></td>
                                        <td><?php echo $customer_address; ?></td>
                                        <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id ?>" class="btn-secondary">update order</a>
                                        </td>
                                    </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //order not available
                            echo "<tr><td colspan='12' class='error'>order not availablr</td></tr>";
                        }
                    ?>
                   
                    
                </table>

                
                <div class="clearfix"></div>
            </div>
        </div>
        <!--main content section end -->


        <?php include('partials/footer.php'); ?>