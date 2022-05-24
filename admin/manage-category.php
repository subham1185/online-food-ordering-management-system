<?php include('partials/menu.php'); ?>


        <!--main content section start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>manage category</h1>
                <br><br>
                <?php

                    if(isset($_SESSION['add']))//checkin session is set or not
                    {
                        echo $_SESSION['add'];//display message
                        unset($_SESSION['add']);//remove message
                    }
                    if(isset($_SESSION['remove']))//checkin session is set or not
                    {
                        echo $_SESSION['remove'];//display message
                        unset($_SESSION['remove']);//remove message
                    }
                    if(isset($_SESSION['delete']))//checkin session is set or not
                    {
                        echo $_SESSION['delete'];//display message
                        unset($_SESSION['delete']);//remove message
                    }
                    if(isset($_SESSION['no-category-found']))//checkin session is set or not
                    {
                        echo $_SESSION['no-category-found'];//display message
                        unset($_SESSION['no-category-found']);//remove message
                    }
                    if(isset($_SESSION['update']))//checkin session is set or not
                    {
                        echo $_SESSION['update'];//display message
                        unset($_SESSION['update']);//remove message
                    }
                    if(isset($_SESSION['upload']))//checkin session is set or not
                    {
                        echo $_SESSION['upload'];//display message
                        unset($_SESSION['upload']);//remove message
                    }
                    if(isset($_SESSION['failed_remove']))//checkin session is set or not
                    {
                        echo $_SESSION['failed_remove'];//display message
                        unset($_SESSION['failed_remove']);//remove message
                    }

                ?>
                <br><br>
                <!--add admin button-->
                <a href="<?php echo SITEURL;?>admin/add-category.php" class="btn-primary" >add category</a>
                <br><br>
                <table class="tbl-full">
                    <tr>
                        <th>s.no.</th>
                        <th>Title</th>
                        <th>image</th>
                        <th>Featured</th>
                        <th>active</th>
                        <th>actions</th>
                    </tr>
                    <?php
                        //query to get data from database
                        $sql="SELECT * FROM tbl_category";

                        //execute query
                        $res = mysqli_query($conn,$sql);

                        // count rows
                        $count=mysqli_num_rows($res);

                        // create serial no variable and assign value as 1
                        $sn=1;

                        // check if data is in database
                        if($count>0)
                        {
                            //we have data
                            //get data and display
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id=$row['id'];
                                $title=$row['title'];
                                $image_name=$row['image_name'];
                                $featured=$row['featured'];
                                $active=$row['active'];
                                ?>
                                 
                                <tr>
                                    <td><?php echo $sn++;?></td>
                                    <td><?php echo $title;?></td>

                                    <td>
                                        <?php 
                                            //check if the image name is available or not
                                            if($image_name!="")
                                            {
                                                //display the image
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>" width="100px" >
                                                <?php
                                            }
                                            else
                                            {
                                                // display message
                                                echo "<div class='error'>image is not added</div>";
                                            }
                                        ?>
                                    </td>

                                    <td><?php echo $featured;?></td>
                                    <td><?php echo $active;?></td>
                                    <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">update category</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name?>" class="btn-danger"> delete category</a>
                                    </td>
                                </tr>
                                
                                <?php
                            }
                        }
                        else
                        {
                            // we do nat have data
                            //we'll display inside table
                            ?>

                            <tr>
                                <td colspan="6">
                                    <div class="error"> no category added</div>
                                </td>
                            </tr>

                            <?php
                        }
                    
                    ?>

                    
                   
                    
                </table>

                
                <div class="clearfix"></div>
            </div>
        </div>
        <!--main content section end -->


        <?php include('partials/footer.php'); ?>