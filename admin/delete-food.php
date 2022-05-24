<?php
    include('../config/constants.php');
    //echo "delete category" ;
    //check if the id and image_name is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
         //process to delete
        //1.get id and image name
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //2.remove image if available
        //checkif image is available or not and delete only if image is available
        if($image_name!="")
        {
            //it has image and need to delete
            // get the image
            $path="../images/food/".$image_name;

            //remove image from folder
            $remove=unlink($path);

            //check if the image is removed or not
            if($remove==false)
            {
                //failed to remove image
                $_SESSION['upload']="<div class='error'>failed to remove file</div>";
                //redirect to manage food page
                header("location:".SITEURL.'admin/manage-food.php');
                //stop the process
                die();
            }
        }

        //3.delete food from database
        $sql="DELETE FROM tbl_food WHERE id=$id";
        //execution 
        $res=mysqli_query($conn,$sql);

        //4.redirect to manage food page with session message
        //check if the query is executed or not set th session message
        if($res==true)
        {
            //food deleted
            $_SESSION['delete']="<div class='sucess'> food delete successfully</div>";
            header("location:".SITEURL.'admin/manage-food.php');
        }
        else
        {
            //failed to delete food
            $_SESSION['delete']="<div class='error'> failed to delete food</div>";
            header("location:".SITEURL.'admin/manage-food.php');
        }
    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauthorize']="<div class='error'>unauthorized access</div>";
        header("location:".SITEURL.'admin/manage-food.php');
    }

?>