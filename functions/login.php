<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/loginMapper.php';
sec_session_start(); // start secure session
 
//if username and password set
if (isset($_POST['mail'], $_POST['p'])) {
    
    //save in vars
    $mail = $_POST['mail'];
    $password = $_POST['p'];
    
    //try to login
    if (login($mail, $password, $mysqli) > -1) {
        // if logget in go to next page
        if(isset($_SESSION['type']))
        {
            if($_SESSION['type'] == 1)
            {
                header('Location: ../blog.php');
            }
            else if($_SESSION['type'] == 2)
            {
                header('Location: ../adminDashboard.php');
            }
        }
        else
        {
            header('Location: ../index.php?error=1');
        }
    } else {
        // else go to frontpage
        header('Location: ../index.php?error=1');
    }
} else {
    // if we try to access this page outside the login form
    echo 'Invalid Request';
}