<?php
    include('../config/constants.php');
    //echo "delete category" ;
    //check if the id and image_name is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        // remove the physical image file
        if($image_name!="")
        {
            // image is available so remove it
            $path = "../images/category/".$image_name;
            //remov ethe image
            $remove=unlink($path);
            //if failed to remove image then add error message and stop the process
            if($remove==false)
            {
                //shere the session message
                $_SESSION['remove']="<div class='error'>failed to remove category image</div>";
                //redirect to manage category page
                header("location:".SITEURL.'admin/manage-category.php');
                //stop the process
                die();
            }
        }

        //delete data from database
        //sql query to delete data from database
        $sql ="DELETE FROM tbl_category WHERE id=$id";

        //execute the query
        $res=mysqli_query($conn,$sql);

        //check if data is deleted or not
        if($res==true)
        {
            // success message and redirect
            $_SESSION['delete']="<div class='sucess'>category deleted successfully</div>";
            //redirect to manage category
            header("location:".SITEURL.'admin/manage-category.php');
        }
        else
        {
            //fail message and redirect
            // fail message and redirect
            $_SESSION['delete']="<div class='error'>category deletion failed</div>";
            //redirect to manage category
            header("location:".SITEURL.'admin/manage-category.php');
        }
         
    }
    else
    {
        //redirect to manage category page
        header("location:".SITEURL.'admin/manage-category.php');
    }
?>