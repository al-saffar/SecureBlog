<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/loginMapper.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/functions/encryptDecrypt.php';
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
        if(isset($_SESSION['type']) && $_SESSION['type'] == 2)
        {
            $_SESSION['adminLogin'] = encrypt($mail, $_SERVER['REMOTE_ADDR']);
            header('Location: ../adminDashboard.php');
        }
        else
        {
            header('Location: ../my.php?error=1');
        }
    } else {
        // else go to frontpage
        header('Location: ../my.php?error=1');
    }
} else {
    // if we try to access this page outside the login form
    echo 'Invalid Request';
    echo '<br>mm'.$_POST['mail'];
    echo '<br>tt'.$_POST['token'];
    echo '<br>pp'.$_POST['password'];
}