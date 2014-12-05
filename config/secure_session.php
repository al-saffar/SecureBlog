<?php
include 'config.php';
//secure session, so hackers can't get access to the data we save in them
function sec_session_start() {
    $session_name = 'sec_session';   // name of the session
    $secure = SECURE;
    
    // make it http only against XSS
    $httponly = true;
    
    // if not cookie, the error
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // get current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    
    session_name($session_name);// set session name
    session_start();// start the session 
    session_regenerate_id(); // generate the session and delete the old one
}

?>