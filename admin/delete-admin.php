<?php

    // include constants.php file
    include('../config/constants.php');
    // 1. get the id of admin to be deleted
    $id = $_GET['id'];
    //2. create sql query to delete admin
    $sql = " DELETE FROM tbl_admin WHERE id=$id";
    //execute the query
    $res = mysqli_query($conn,$sql);
    //check whether query is executed sucessfully or not
    if($res==true)
    {
        //query executed sucessfully to delete admin
        //echo"admin deleted";
        // create session variable to display message
        $_SESSION['delete'] = "<div class='sucess'>admin deleted </div>";
        //redirectingto manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to execute sucessfully to delete admin
        //echo"failed to delete admin";

        $_SESSION['delete'] = "<div class='error'>failed to delete admin</div>";

        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    //3. redirect to manage admin page with message(when success/error)


?>