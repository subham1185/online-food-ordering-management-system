<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>update food</h1>
        <br><br>
        <?php 
            //check if id is set or not
            if(isset($_GET['id']))
            {
                //set id and all the details
                $id=$_GET['id'];
                //sql query to get details
                $sql2 ="SELECT * FROM tbl_food WHERE id=$id";
                //execute the query
                $res2=mysqli_query($conn,$sql2);

                //get value based on executed query
                $row2 = mysqli_fetch_assoc($res2);

                ///get the individual dataof selected food
                $title=$row2['title'];
                $description=$row2['description'];
                $price=$row2['price'];
                $current_image=$row2['image_name'];
                $current_category=$row2['category_id'];
                $featured=$row2['featured'];
                $active=$row2['active'];
            }
            else
            {
                //redirect to manage food
                header("location:".SITEURL.'admin/manage-food.php');
            }
        ?>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" >
                    </td>
                </tr>
                <tr>
                    <td>description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>price</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>current image</td>
                    <td>
                    <?php
                        if($current_image=="")
                        {
                            //imagr not available anddisplay message 
                            echo"<div class='error'>image is not available</div>";
                            
                   
                        }
                        else
                        {
                            //image is available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>select new image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>category</td>
                    <td>
                        <select name="category" >
                            <?php
                                //sql query to get active categories
                                $sql="SELECT * FROM tbl_category WHERE active='yes'";
                                //execution of query
                                $res=mysqli_query($conn,$sql);
                                //count rows
                                $count=mysqli_num_rows($res);

                                //check if category is available or not
                                if($count>0)
                                {
                                    //category is available
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title=$row['title'];
                                        $category_id=$row['id'];
                                        echo "<option value='$category_id'>$category_title</option>";
                                    }
                                }
                                else
                                {
                                    //category is not available
                                    //echo "<option value='0'>category not available</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>featured:</td>
                    <td>
                        <input <?php if($featured=="yes"){echo"checked";} ?> type="radio" name="featured" value="yes" > Yes

                        <input <?php if($featured=="no"){echo"checked";} ?> type="radio" name="featured" value="no" > No
                    </td>
                </tr>
                <tr>
                    <td>active:</td>
                    <td>
                        <input <?php if($active=="yes"){echo"checked";} ?> type="radio" name="active" value="yes" > Yes

                        <input <?php if($active=="no"){echo"checked";} ?> type="radio" name="active" value="no" > No
                    </td>
                </tr>
                <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <input type="submit" name="submit" value="update food" class="btn-secondary">

                </td>
            </tr>
            </table>

        </form>
            
        <?php

            if(isset($_POST['submit']))
            {
                //echo"clicked";
                //1.get all values from form
                $id=$_POST['id'];
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $current_image=$_POST['current_image'];
                $category=$_POST['category'];

                $featured=$_POST['featured'];
                $active=$_POST['active'];

                //2. update new image if selected
                //check if image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get image details
                    $image_name=$_FILES['image']['name'];
                    //check if image is available or not
                    if($image_name!="")
                    {
                        //image is selected
                        //A. rename the image
                        // get extension of image(jpg,png,gif,etc) i.e. "specialfood1.jpg"
                        $ext=end(explode('.',$image_name));
                        //rename the image
                        $image_name="Food-Name-".rand(0000,9999).'.'.$ext;//Food-Name-5357.jpg
                        
                        //B. upload the image
                        $src_path=$_FILES['image']['tmp_name'];//current location and source path
                        
                        $dst_path="../images/food/".$image_name;//destination path

                        //finally upload the image
                        $upload = move_uploaded_file($src_path,$dst_path);
                        // check if the image is uploaded or not
                        //and if image is not uploaded then redirect with error message
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload']="<div class='error'>failed to upload image</div>";
                            //redirecting to manage food page
                            header("location:".SITEURL.'admin/manage-food.php');
                            // stop process
                            die();
                        }
                        //3. remove the image if new image is uploaded and current image exists
                        //C.remove current image if available
                        if($current_image!="")
                        {
                            $remove_path="../images/food/".$current_image;
                            $remove=unlink($remove_path);

                            //check if image is removed or not
                            //if failed then display message and stop process
                            if($remove==false)
                            {
                                //failes to remove
                                $_SESSION['remove-failed']="<div class='error'>failed to remove image</div>";
                                header("location:".SITEURL.'admin/manage-food.php');
                                die();//stop process
                            }
                        } 
                    }
                    else
                    {
                        $image_name=$current_image;
                    }
                }
                else
                {
                    $image_name=$current_image;
                }

                //4.update the food database
                $sql3="UPDATE tbl_food SET
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id='$category',
                featured='$featured',
                active='$active'
                WHERE id=$id
                ";

                //execute the query
                $res3=mysqli_query($conn,$sql3);

                //5.redirect to manage food with session message
                //check if query is executed or not 
                if($res3==true)
                {
                    //query executed and food updated
                    $_SESSION['update']="<div class='sucess'>food updated successfully</div>";
                    header("location:".SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update']="<div class='erroe'>failed to update food </div>";
                    header("location:".SITEURL.'admin/manage-food.php');
                }
            }
        ?>


    </div>
</div>


<?php include('partials/footer.php'); ?>