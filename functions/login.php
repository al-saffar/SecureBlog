<?php
include_once '../database/db_connect.php';
include_once '../sql/loginMapper.php';
 
sec_session_start(); // start secure session
 
//if username and password set
if (isset($_POST['username'], $_POST['p'])) {
    
    //save in vars
    $username = $_POST['username'];
    $password = $_POST['p'];
    
    //try to login
    if (login($username, $password, $mysqli) == true) {
        // if logget in go to next page
        header('Location: ../profile.php');
    } else {
        // else go to frontpage
        header('Location: ../index.php?error=1');
    }
} else {
    // if we try to access this page outside the login form
    echo 'Invalid Request';
}