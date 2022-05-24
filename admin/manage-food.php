<?php include('partials/menu.php'); ?>


        <!--main content section start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>manage food</h1>
                <br>
                <?php
                    if(isset($_SESSION['add']))//checkin session is set or not
                    {
                        echo $_SESSION['add'];//display message
                        unset($_SESSION['add']);//remove message
                    }
                    if(isset($_SESSION['delete']))//checkin session is set or not
                    {
                        echo $_SESSION['delete'];//display message
                        unset($_SESSION['delete']);//remove message
                    }
                    if(isset($_SESSION['upload']))//checkin session is set or not
                    {
                        echo $_SESSION['upload'];//display message
                        unset($_SESSION['upload']);//remove message
                    }
                    if(isset($_SESSION['unauthorize']))//checkin session is set or not
                    {
                        echo $_SESSION['unauthorize'];//display message
                        unset($_SESSION['unauthorize']);//remove message
                    }
                    if(isset($_SESSION['remove-failed']))//checkin session is set or not
                    {
                        echo $_SESSION['remove-failed'];//display message
                        unset($_SESSION['remove-failed']);//remove message
                    }
                    if(isset($_SESSION['update']))//checkin session is set or not
                    {
                        echo $_SESSION['update'];//display message
                        unset($_SESSION['update']);//remove message
                    }
                ?>
                <br><br>
                <br>
                <!--add admin button-->
                <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary" >add food</a>
                <br><br>
                <table class="tbl-full">
                    <tr>
                        <th>s.no.</th>
                        <th>title</th>
                        <th>price</th>
                        <th>image</th>
                        <th>featured</th>
                        <th>active</th>
                        <th>actions</th>
                    </tr>

                    <?php
                        //create sql query to get all food
                        $sql="SELECT * FROM tbl_food";
                        //execute the query
                        $res=mysqli_query($conn,$sql);
                        //count rows to check if we have food or not
                        $count=mysqli_num_rows($res);

                        //createserial no variable and set default value 1
                        $sn=1;

                        if($count>0)
                        {
                            // we have food in database
                            //get food from datbase and display
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //get data from individual columns
                                $id=$row['id'];
                                $title=$row['title'];
                                $price=$row['price'];
                                $image_name=$row['image_name'];
                                $featured=$row['featured'];
                                $active=$row['active'];
                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?>.</td>
                                        <td><?php echo $title; ?></td>
                                        <td>Rs.<?php echo $price; ?></td>
                                        <td>
                                            <?php 
                                                //check if we have image or not
                                                if($image_name=="")
                                                {
                                                    //we do nat have image display error message
                                                    echo"<div class='error'>image is not available</div>";
                                                }
                                                else
                                                {
                                                    //we have image
                                                    ?>
                                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px" >
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $featured; ?>
                                        </td>
                                        <td>
                                            <?php echo $active; ?>
                                        </td>
                                        <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">update food</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name?>" class="btn-danger"> delete food</a>
                                        </td>
                                    </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //food not added in database
                            echo "<tr><td colspan='7' class='error'>Food not added yet</tr>";
                        }
                    ?>
                    
                    
                    
                </table>

                
                <div class="clearfix"></div>
            </div>
        </div>
        <!--main content section end -->


        <?php include('partials/footer.php'); ?>

