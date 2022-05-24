<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
    <?php
        if(isset($_SESSION['order']))//checkin sessin is set or not
        {
            echo $_SESSION['order'];//display message
         unset($_SESSION['order']);//remove message
        }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
            
                //create SQL query to display data
                $sql ="SELECT * FROM tbl_category WHERE active='yes' AND featured='yes' LIMIT 3";
                //execute the query
                $res=mysqli_query($conn,$sql);
                //count rowsto check if category is available
                $count=mysqli_num_rows($res);

                if($count>0)
                {
                    //category is available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get data like id, title, image etc.
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php
                                        // check if image is present or not
                                        if($image_name=="")
                                        {
                                            // display message 
                                            echo "<div class='error'>image is not available </div>";
                                        }
                                        else
                                        {
                                            // image present
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                    

                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                        <?php
                    }
                }
                else
                {
                    //category is not available
                    echo"<div class='error'>category is not added</div>";
                }

            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //get food from database that are active and featured
                $sql2 ="SELECT * FROM tbl_food WHERE active='yes' AND featured='yes' LIMIT 6";
                //execute the query
                $res2=mysqli_query($conn,$sql2);
                //count rows to check if category is available
                $count2=mysqli_num_rows($res2);

                if($count2>0)
                {
                    //food is available
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //get the data
                        $id=$row['id'];
                        $title=$row['title'];
                        $price=$row['price'];
                        $description=$row['description'];
                        $image_name=$row['image_name'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                            <?php
                                // check if image is present or not 
                                if($image_name=="")
                                {
                                    // display message 
                                    echo "<div class='error'>image is not available </div>";
                                }
                                else
                                {
                                    // image present
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                        </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">Rs <?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php

                    }
                }
                else
                {
                    //food is not available
                    echo"<div class='error'>food is not added</div>";
                }
            ?>

            

            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL; ?>foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
