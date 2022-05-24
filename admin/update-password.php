<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
       <h1>change password</h1>
       <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

       <form action="" method="POST">

            <table class="tbl30">
                <tr>
                    <td>current password</td>
                    <td>
                        <input type="password" name="current_password" placeholder="current password">
                    </td>
                </tr>

                <tr>
                    <td>new password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="new password">
                    </td>
                </tr>

                <tr>
                    <td>confirm password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirm password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id?>">
                        <input type="submit" name="submit" value="change password" class="btn-secondary">
                    </td>
                </tr>

            </table>

       </form>
    </div>
</div>
 
<?php
        // check whether submit button is clicked
        if(isset($_POST['submit']))
        {
            //echo "clicked";
            //1. get data from form
             $id = $_POST['id'];
             $current_password=md5($_POST['current_password']);
             $new_password=md5($_POST['new_password']);
             $confirm_password=md5($_POST['confirm_password']);

            //2. check if id and current password exist or not
             $sql=" SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

             // execute the query
             $res= mysqli_query($conn,$sql);

             if ($res==true) 
             {
                 //check if data is available
                 $count=mysqli_num_rows($res);

                 if($count==1)
                 {
                     // user exist and password can be changed
                     //echo "user found";

                     //check if the new and confirm password match
                     if($new_password==$confirm_password)
                     {
                         //update password
                         $sql2="UPDATE tbl_admin SET
                         password=$new_password
                         WHERE id=$id
                         ";
                         // execute the query
                         $res2=mysqli_query($conn,$sql2);
 
                         // check if query is executed
                         if($res2==true)
                         {
                            // display sucess message
                            // redirct to manage admin
                            $_SESSION['change-pwd']="<div class='sucess'> password changed sucessfully</div>";
                            //redirect the user
                            header("location:".SITEURL.'admin/manage-admin.php');
                         }
                         else
                         {
                             // display error message
                             // redirct to manage admin
                             $_SESSION['change-pwd']="<div class='error'>failed to change password</div>";
                             //redirect the user
                             header("location:".SITEURL.'admin/manage-admin.php');
                         }
                     }
                     else
                     {
                         //redirect to manage admin page
                         //password does not match and redirct to manage admin
                         $_SESSION['pwd-not-match']="<div class='error'> password did not match</div>";
                         //redirect the user
                         header("location:".SITEURL.'admin/manage-admin.php');
                     }
                 }
                 else
                 {
                     //urer does not exist and redirct to manage admin
                     $_SESSION['user-not-found']="<div class='error'> user not found</div>";
                     //redirect the user
                     header("location:".SITEURL.'admin/manage-admin.php');
                 }
             }
            //3. check if new and confirm password match or not
            

            //4. change password if all above is true

        }
?>
<?php include('partials/footer.php'); ?>