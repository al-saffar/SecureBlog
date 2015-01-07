<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/config.php';
//secure session, so hackers can't get access to the data we save in them
function sec_session_start() {
    $session_name = 'sec_session';   // name of the session
    $secure = SECURE;
    
    // make it http only against XSS
    $httponly = true;
    
    // check if cookie
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../index.php?error=3");
        exit();
    }
    // get current cookies params.
    $cookieParams = session_get_cookie_params();
    
    //set cookie params
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    
    session_name($session_name);// set session name
    session_start();// start the session 
    session_regenerate_id(); // generate a new session id
}

?>