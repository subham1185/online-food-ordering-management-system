<?php include('../config/constants.php');?>
<html>
    <head>
        <title>login food order system</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
         
        <div class="login">
                <h1 class="text-center">login</h1>

                <?php
                    if(isset($_SESSION['login']))//checkin session is set or not
                    {
                         echo $_SESSION['login'];//display message
                         unset($_SESSION['login']);//remove message
                    }
                    if(isset($_SESSION['no-login-message']))//checkin session is set or not
                    {
                         echo $_SESSION['no-login-message'];//display message
                         unset($_SESSION['no-login-message']);//remove message
                    }
                    
                ?>
                <!--login form-->
                <form action="" method="POST" class="text-center">
                    <br> <br>
                    username:
                    <input type="text" name="username" placeholder="enter username">
                    <br>
                    <br/>
                    password:
                    <input type="password" name="password" placeholder="enter password">
                    <br>
                    <br>
                    <input type="submit" name="submit" value="login" class="btn-primary">
                    <br><br>
                </form>
                <p class="text-center">created by - <a href="#"> subham pathania </a></p>
        </div>
    </body>
</html>
<?php

    //check is submit button is working
    if(isset($_POST['submit']))
    {
        //process for login
        //1. get data from form
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $password=mysqli_real_escape_string($conn,md5($_POST['password']));
        
        //2. sql to check if the user with username and password exist
        $sql=" SELECT * FROM tbl_admin WHERE username='$username'AND password='$password'";

        //3. execute the query
        $res=mysqli_query($conn,$sql);


        //4. count rows to check if the user exist or not
        $count=mysqli_num_rows($res);

        if($count==1)
        {
            //user present login sucess
            $_SESSION['login']="<div class='sucess'>login sucessfull</div>";
            $_SESSION['user']=$username; // to check if user is logged in or not
            //redirect to manage admin page
            header("location:".SITEURL.'admin/');
        }
        else
        {
            // user not present login failed
            $_SESSION['login']="<div class='error text-center'>username ans password does not match</div>";
            //redirect to manage admin page
            header("location:".SITEURL.'admin/login.php');
        }
    }
?>