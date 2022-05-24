<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>update category</h1>

        <br><br>

        <?php 
            //check if id is set or not
            if(isset($_GET['id']))
            {
                //set id and all the details
                $id=$_GET['id'];
                //sql query to get details
                $sql ="SELECT * FROM tbl_category WHERE id=$id";

                //execute the query
                $res=mysqli_query($conn,$sql);

                //count the rows to check if id is valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //get all data
                    $row = mysqli_fetch_assoc($res) ;
                    $title=$row['title'];
                    $current_image=$row['image_name'];
                    $featured=$row['featured'];
                    $active=$row['active'];
                }
                else
                {
                    //redirect to manage category withw message
                    $_SESSION['no-category-found']="<div class='error'>category not found</div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                //redirect to manage category
                header("location:".SITEURL.'admin/manage-category.php');
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

            <tr>
                <td>title</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title;?>">
                </td>
            </tr>
            <tr>
                <td>current image</td>
                <td>
                    <?php
                        if($current_image!="")
                        {
                            //display image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                        else
                        {
                            //display message
                            echo"<div class='error'>image is not available</div>";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>new image</td>
                <td>
                    <input type="file" name="image">
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
                    <input <?php if($active=="yes"){echo "checked";} ?> type="radio" name="active" value="yes" > Yes

                    <input <?php if($active=="no"){echo "checked";} ?> type="radio" name="active" value="no" > No
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                <input type="submit" name="submit" value="update category" class="btn-secondary">
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
                $current_image=$_POST['current_image'];
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
                        //image available
                        //A. upload new image 

                        //auto rename duplicate image
                        // get extension of image(jpg,png,gif,etc) i.e. "specialfood1.jpg"
                        $ext=end(explode('.',$image_name));

                        //rename the image
                        $image_name="Food_Category_".rand(000,999).'.'.$ext;//Food_Category_544.jpg
                        
                        $source_path=$_FILES['image']['tmp_name'];
                        
                        $destination_path="../images/category/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($source_path,$destination_path);
                        // check if the image is uploaded or not
                        //and if image is not uploaded then redirect with error message
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload']="<div class='error'>failed to upload image</div>";
                            //redirecting to add categoy page
                            header("location:".SITEURL.'admin/manage-category.php');
                            // stop process
                            die();
                        }
                        
                        //B. remove current image if available
                        if($current_image!="")
                        {
                            $remove_path="../images/category/".$current_image;
                            $remove=unlink($remove_path);

                            //check if image is removed or not
                            //if failed then display message and stop process
                            if($remove==false)
                            {
                                //failes to remove
                                $_SESSION['failed_remove']="<div class='error'>failed to remove image</div>";
                                header("location:".SITEURL.'admin/manage-category.php');
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

                //3. update to database
                 $sql2="UPDATE tbl_category SET
                 title='$title',
                 image_name='$image_name',
                 featured='$featured',
                 active='$active'
                 WHERE id=$id
                 ";

                //execute the query
                $res2=mysqli_query($conn,$sql2);                  
                 
                //4.redirect to manage category with message
                //check if query is executed or not 
                if($res2==true)
                {
                    //category updated
                    $_SESSION['update']="<div class='sucess'>category updated successfully</div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update']="<div class='erroe'>failed to update category </div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }
            }
        ?>
    </div>

</div>

<?php include('partials/footer.php'); ?>