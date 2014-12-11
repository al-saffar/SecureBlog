<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';

function register($email, $firstname, $lastname, $dob, $gender, $city, $password, $mysqli)
{
    try{
        $stmt = $mysqli->prepare("INSERT INTO users(email,firstname,lastname,DOB,gender,city_id) VALUES(?,?,?,?,?,?);");
    
        $stmt->bind_param('ssssii', $email, $firstname, $lastname, $dob, $gender, $city);
        $stmt->execute();

        $userID = $stmt->insert_id;

        $stmt2 = $mysqli->prepare("INSERT INTO prvlg(user_id,www) VALUES(?,?);");

        $stmt2->bind_param('is', $userID, $password);
        $stmt2->execute();
        
        return true;
    }
    catch (Exception $e)
    {
        return false;
    }
}
?>