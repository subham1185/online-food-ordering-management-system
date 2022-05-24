<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>add admin</h1>
        <br>
        <?php
                if(isset($_SESSION['add']))//checkin sessoin is set or not
                {
                     echo $_SESSION['add'];//display message
                     unset($_SESSION['add']);//remove message
                }
                ?><br>
        <form action="" method="POST">
            <table class="tbl-30">

                <tr>
                    <td>full name:</td>
                    <td><input type="text" name="full_name" placeholder="name"></td>
                </tr>

                <tr>
                    <td>username:</td>
                    <td><input type="text" name="username" placeholder="username"></td>
                </tr>

                <tr>
                    <td>password:</td>
                    <td><input type="password" name="password" placeholder="password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="add admin" class="btn-secondary">
                    </td>
            </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php  
    // process value from form and save in database
    if(isset($_POST['submit']))
    {
       //1. get data from form
       $full_name = $_POST['full_name'];
       $username = $_POST['username'];
       $password =md5($_POST['password']);

       //2. sql query to save data in database
       $sql = "INSERT INTO tbl_admin SET
       full_name='$full_name',
       username='$username',
       password='$password'
       ";
       //3. execute query and save data
       $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

       //4. check whether the query is executed or not and display message
       if($res==TRUE)
       {
         //  echo "data inserted";
         // create a session variable to display message
         $_SESSION['add']  = "<div class='sucess'>admin added successfuly</div>";
         //redirect page
         header("location:".SITEURL.'admin/manage-admin.php');
        }
       else
       {
         //echo "data is not inserted";
         // create a session variable to display message
         $_SESSION['add']  = "<div class='error'>failed to add admin</div>";
         //redirect page
         header("location:".SITEURL.'admin/add-admin.php');
       }

    }
    
?>