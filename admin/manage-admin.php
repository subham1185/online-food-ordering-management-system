<?php include('partials/menu.php'); ?>


        <!--main content section start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>manage admin</h1>
                <br>
                <?php
                if(isset($_SESSION['add']))//checkin sessin is set or not
                {
                     echo $_SESSION['add'];//display message
                     unset($_SESSION['add']);//remove message
                }
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];//display message
                    unset($_SESSION['delete']);//remove message     
                }
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];//display message
                    unset($_SESSION['update']);//remove message     
                }
                if(isset($_SESSION['user-not-found']))
                {
                    echo $_SESSION['user-not-found'];//display message
                    unset($_SESSION['user-not-found']);//remove message     
                }
                if(isset($_SESSION['pwd-not-match']))
                {
                    echo $_SESSION['pwd-not-match'];//display message
                    unset($_SESSION['pwd-not-match']);//remove message     
                }
                if(isset($_SESSION['change-pwd']))
                {
                    echo $_SESSION['change-pwd'];//display message
                    unset($_SESSION['change-pwd']);//remove message     
                }
                ?>
                <br /><br>
                <!--add admin button-->
                <a href="add-admin.php" class="btn-primary" >add admin</a>
                <br><br>
                <table class="tbl-full">
                    <tr>
                        <th>s.no.</th>
                        <th>fullname</th>
                        <th>username</th>
                        <th>actions</th>
                    </tr>

                    <?php
                    // query  to get all admin
                    $sql= "SELECT * FROM tbl_admin";
                    // execution of query
                    $res = mysqli_query($conn,$sql);

                    // check whether query is executed or not
                    if($res==TRUE)
                    {
                        // count rows to ckeck data in databasde
                        $count = mysqli_num_rows($res);// function to get all rows

                        $sn=1;
                        
                        //check no of rows
                        if ($count>0)
                        {
                            // we have data
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                // get individual data
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];
                                // display value
                                ?>
                                    <tr>
                                         <td><?php echo $sn++?></td>
                                         <td><?php echo $full_name ?></td>
                                         <td><?php echo $username ?></td>
                                         <td>
                                            <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary"> change password</a>
                                            <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">update admin</a>
                                            <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">   delete admin</a>
                                         </td>
                                         </tr>   

                                <?php
                            }
                        } 
                        else 
                        {
                            // we don't have data
                        }
                        

                    }
                    
                    ?>

                    
                   
                    
                </table>
                <div class="clearfix"></div>
            </div>
        </div>
        <!--main content section end -->


        <?php include('partials/footer.php'); ?>