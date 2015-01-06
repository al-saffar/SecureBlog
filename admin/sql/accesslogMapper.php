<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/accesslog.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'../SecureBlog/config/config.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'../SecureBlog/config/secure_session.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/classes/loginAttemps.php';

function getAccesslog($mysqli)
{
//    $posts;
//    $userID = $_SESSION['userID'];
        
    if ($stmt = $mysqli->prepare("SELECT ip, email, time, timestamp FROM login_attempts")) 
    {
      //  $stmt->bind_param('iii', $userID, $userID, $userID);
 
        $stmt->execute();
        $stmt->store_result();
 
        $stmt->bind_result($ip, $email, $time, $timestamp);

        while ($stmt->fetch()) {
            $selIP = $ip;
          
            
            $loginAttemps = new loginAttemps(htmlentities($ip), htmlentities($email), htmlentities($time), htmlentities($timestamp));
            
            $loginAtpArray[] = $loginAttemps;
        }
        
        return $loginAtpArray;
    }
    else
    {
        return NULL;
    }
}
?>
