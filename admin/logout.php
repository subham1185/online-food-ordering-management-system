<?php
    // include constants.php for SITEURL
    include('../config/constants.php');
    //1. destroy the session and redirect to login page
    session_destroy();// unsets $_SESSION['user']

    //2. redirection
    header("location:".SITEURL.'admin/login.php');

?>