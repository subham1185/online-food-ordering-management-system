<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>add food</h1>
        <br><br>
        <?php
               
            if(isset($_SESSION['upload']))//checkin session is set or not
            {
                echo $_SESSION['upload'];//display message
                unset($_SESSION['upload']);//remove message
            }
            
            ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>title:</td>
                    <td>
                        <input type="text" name="title" placeholder="title of food">
                    </td>
                </tr>

                <tr>
                    <td>description:</td>
                    <td>
                        <textarea name="description"  cols="30" rows="5" placeholder="description of food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>select image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>category:</td>
                    <td>
                        <select name="category" >

                        <?php
                            //php code to display category from database
                            //1. sql query to display active category 
                            $sql="SELECT * FROM tbl_category WHERE active='yes'";

                            //execution of query
                            $res = mysqli_query($conn,$sql) ;

                            //count rows to check if we have category or not
                            $count=mysqli_num_rows($res);

                            //2.display dropdown

                            //if count is greater than zero then we have category else we do not have it
                            if($count>0)
                            {
                                //we have category
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get details of category
                                    $id=$row['id'];
                                    $title=$row['title'];
                                    ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                    <?php
                                }
                            }
                            else
                            {
                                //we do not have category
                                ?>
                                <option value="0">no category found</option>
                                <?php
                            }
                             
                            
                        ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>featured</td>
                    <td>
                        <input type="radio" name="featured" value="yes" > Yes
                        <input type="radio" name="featured" value="no" > No
                    </td>
                </tr>

                <tr>
                    <td>active</td>
                    <td>
                        <input type="radio" name="active" value="yes" > Yes
                       <input type="radio" name="active" value="no" > No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="add food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <?php

            //check if submit button is working
            if(isset($_POST['submit']))
            {
                //add food in database
                //echo"clicked";

                //1.get data from form 
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $category=$_POST['category'];

                //check if radio button for featured and active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured=$_POST['featured'];
                }
                else
                {
                    $featured="no"; //default value
                }

                if(isset($_POST['active']))
                {
                    $active=$_POST['active'];
                }
                else
                {
                    $active="no"; //default value
                }

                //2.upload image if selected

                //check if select image button is clicked or not and upload the image only if image is selected
                if(isset($_FILES['image']['name']))
                {
                    //get details of selected image
                    $image_name=$_FILES['image']['name'];

                    //check if image is selected or not and upload the image only if image is selected
                    if($image_name!="")
                    {
                        //image is selected
                        //A. rename the image

                         // get extension of image(jpg,png,gif,etc) i.e. "specialfood1.jpg"
                         $ext=end(explode('.',$image_name));

                         //rename the image
                         $image_name="Food-Name-".rand(0000,9999).'.'.$ext;//Food-Name-5357.jpg
                         
                         //B. upload the image
                         $src=$_FILES['image']['tmp_name'];//current location
                         
                         $dst="../images/food/".$image_name;//destination path
 
                         //finally upload the image
                         $upload = move_uploaded_file($src,$dst);

                         // check if the image is uploaded or not
                         //and if image is not uploaded then redirect with error message
                         if($upload==false)
                         {
                             //set message
                             $_SESSION['upload']="<div class='error'>failed to upload image</div>";
                             //redirecting to add food page
                             header("location:".SITEURL.'admin/add-food.php');
                             // stop process
                             die();
                         }
                        
                    }
                }
                else
                {
                    $image_name="";//default value is blank
                }

                //3.insert into database

                //create sql query 
                $sql2="INSERT INTO tbl_food SET
                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id=$category,
                    featured='$featured',
                    active='$active'
                ";

                //execute the query
                $res2=mysqli_query($conn,$sql2);

                //4.redirect with message to manage food page

                //check is data is inserte or not
                if($res2==true)
                {
                    //data added succesfully
                    $_SESSION['add']="<div class='sucess'>  added food sucessfully</dive>";
                    //redirecting to manage categoy page
                    header("location:".SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to add data
                    $_SESSION['add']="<div class='error'> failed to add food</dive>";
                    //redirecting to manage categoy page
                    header("location:".SITEURL.'admin/manage-food.php');
                }

                
            }

        ?>
    </div>
</div>



<?php include('partials/footer.php'); ?>
