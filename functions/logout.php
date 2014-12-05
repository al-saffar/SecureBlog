<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/Web-Security/config/secure_session.php';
sec_session_start();
 
// delete vars in session
$_SESSION = array();
 
// get session parameters 
$params = session_get_cookie_params();
 
// delete the cookie 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// destroy session 
session_destroy();

//go to frontpage
header('Location: ../index.php');