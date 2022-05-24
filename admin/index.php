<?php include('partials/menu.php'); ?>

        <!--main content section start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Dashboard</h1>
                <br><br>

                <?php
                    if(isset($_SESSION['login']))//checkin session is set or not
                    {
                         echo $_SESSION['login'];//display message
                         unset($_SESSION['login']);//remove message
                    }
                ?>
                <br><br>

                <div class="col-4 text-center">
                    <?php
                        $sql="SELECT * FROM tbl_category";
                        //Execute the query
                        $res=mysqli_query($conn,$sql);
                        //count rows
                        $count=mysqli_num_rows($res);
                    ?>
                    <h1><?php echo $count; ?></h1>
                    <br  />
                    category
                </div>

                <div class="col-4 text-center">
                    <?php
                        $sql2="SELECT * FROM tbl_food";
                        //Execute the query
                        $res2=mysqli_query($conn,$sql2);
                        //count rows
                        $count2=mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $count2; ?></h1>
                    <br  />
                    foods
                </div>

                <div class="col-4 text-center">
                    <?php
                        $sql3="SELECT * FROM tbl_order";
                        //Execute the query
                        $res3=mysqli_query($conn,$sql3);
                        //count rows
                        $count3=mysqli_num_rows($res3);
                    ?>
                    <h1><?php echo $count3; ?></h1>
                    <br  />
                    total orders
                </div>

                <div class="col-4 text-center">
                    <?php
                    //aggerate function
                        $sql4="SELECT SUM(total) AS Total FROM tbl_order WHERE status='delivered'";
                        //Execute the query
                        $res4=mysqli_query($conn,$sql4);
                        //get value
                        $row=mysqli_fetch_assoc($res4);
                        //get total revenue
                        $total_revenue=$row['Total'];
                    ?>
                   
                    <h1>Rs <?php echo $total_revenue; ?></h1>
                    <br  />
                    revenue genrated
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
        <!--main content section end -->


        <?php include('partials/footer.php'); ?>