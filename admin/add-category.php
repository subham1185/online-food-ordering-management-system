<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>add category</h1>
        <br><br>

            <?php

                if(isset($_SESSION['add']))//checkin session is set or not
                {
                    echo $_SESSION['add'];//display message
                    unset($_SESSION['add']);//remove message
                }
                if(isset($_SESSION['upload']))//checkin session is set or not
                {
                    echo $_SESSION['upload'];//display message
                    unset($_SESSION['upload']);//remove message
                }
            
            ?>

        <br><br>
        <!--add category form starts-->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                   <tr>
                       <td>title</td>
                       <td>
                           <input type="text" name="title" placeholder="category title">
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
                       <td>Select image</td>
                       <td>
                           <input type="file" name="image">
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
                           <input type="submit" name="submit" value="add category" class="btn-secondary">
                       </td>
                       
                   </tr>
            </table>


        </form>
        
        <!--add category form ends-->

        <?php

            //check if submit button is working
            if(isset($_POST['submit']))
            {
                //echo "clicked";

                //1. get value from form
                $title=$_POST['title'];
                //for radio input type we need to check if the option is selected or not
                if(isset($_POST['featured']))
                {
                    //get value from form
                    $featured=$_POST['featured'];
                }
                else
                {
                    //set default value
                    $featured="no";
                }

                if(isset($_POST['active']))
                {
                    //get value from form
                    $active=$_POST['active'];
                }
                else
                {
                    //set default value
                    $active="no";
                }
                // check if image is selecyed or not and set image name accordingly
               // print_r($_FILES['image']);
               // die(); //break the code here
               if(isset($_FILES['image']['name']))
               {
                   //upload image
                   //to upload image weneed image_name and source path and  destination patha
                   $image_name=$_FILES['image']['name'];

                   //upload image only if image is selected
                   if($image_name!="")
                   {

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
                            header("location:".SITEURL.'admin/add-category.php');
                            // stop process
                            die();
                        }
                    }
               }
               else
               {
                   //don't upload image and set image_namevalue as blank
                   $image_name="";
               }

                //2. create sql query to insert data into datrabase
                $sql="INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";
                //3. execute the query and save in database
                $res = mysqli_query($conn,$sql);

                //4. check if query is executed or not and data added or not
                if($res==true)
                {
                    // query executed and category added
                    $_SESSION['add']="<div class='sucess'>category added sucessfully</dive>";
                    //redirecting to manage categoy page
                    header("location:".SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to add category
                    $_SESSION['add']="<div class='error'> failed to add category sucessfully</dive>";
                    //redirecting to manage categoy page
                    header("location:".SITEURL.'admin/add-category.php');
                }
            }
        
        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>