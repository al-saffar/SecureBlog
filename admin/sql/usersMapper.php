<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/adminDashboard.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'../SecureBlog/config/config.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'../SecureBlog/config/secure_session.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/classes/user.php';

function getUsers($mysqli)
{
//    $posts;
//    $userID = $_SESSION['userID'];
        
    if ($stmt = $mysqli->prepare("SELECT id, email, firstname, lastname, DOB,"
            . "gender, type, timestamp FROM users")) 
    {
      //  $stmt->bind_param('iii', $userID, $userID, $userID);
 
        $stmt->execute();
        $stmt->store_result();
 
        $stmt->bind_result($id, $email, $firstname, $lastname, $DOB, $gender, $type, $timestamp);

        while ($stmt->fetch()) {
            $selID = $id;
          
            
            $users = new user($id, htmlentities($email), htmlentities($firstname), htmlentities($lastname), htmlentities($DOB), 
                    htmlentities($gender), htmlentities($type), htmlentities($timestamp));
            
            $userArray[] = $users;
        }
        
        return $userArray;
    }
    else
    {
        return NULL;
    }
    
}
    function getAdmins($mysqli)
{
//    $posts;
//    $userID = $_SESSION['userID'];
        
    if ($stmt = $mysqli->prepare("SELECT id, email, firstname, lastname, DOB,"
            . "gender, type, timestamp FROM users WHERE type='2'")) 
    {
      //  $stmt->bind_param('iii', $userID, $userID, $userID);
 
        $stmt->execute();
        $stmt->store_result();
 
        $stmt->bind_result($id, $email, $firstname, $lastname, $DOB, $gender, $type, $timestamp);

        while ($stmt->fetch()) {
            $selID = $id;
          
            
            $users = new user($id, htmlentities($email), htmlentities($firstname), htmlentities($lastname), htmlentities($DOB), 
                    htmlentities($gender), htmlentities($type), htmlentities($timestamp));
            
            $userArray[] = $users;
        }
        
        return $userArray;
    }
    else
    {
        return NULL;
    }
}


    function deleteUser($mysqli, $id)
{
    try{
        $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        

        return true;
    }
    catch (Exception $e)
    {
        return false;
    }
}

?>
