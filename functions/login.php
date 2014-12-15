<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/loginMapper.php';
sec_session_start(); // start secure session
 
//if username and password set
if (isset($_POST['mail'], $_POST['token'], $_POST['password'])) {
    
    //save in vars
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
    $token = $_POST['password'];
    $password = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    
    $salt = hash("SHA512", $mail);
    $pass = hash("SHA512", $password.$salt);
    //try to login
    if ($token == $_SESSION['token'] && login($mail, $pass, $mysqli) > -1) {
        // if logget in go to next page
        if(isset($_SESSION['type']) && $_SESSION['type'] == 1)
        {
            header('Location: ../blog.php');
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