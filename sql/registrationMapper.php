<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';

function register($email, $firstname, $lastname, $dob, $gender, $city, $password, $mysqli)
{
    try{
        $stmt = $mysqli->prepare("INSERT INTO users(email,firstname,lastname,DOB,gender,city_id) VALUES(?,?,?,?,?,?);");
    
        $stmt->bind_param('ssssii', $email, $firstname, $lastname, $dob, $gender, $city);
        $stmt->execute();

        $userID = $stmt->insert_id;

        $stmt2 = $mysqli->prepare("INSERT INTO prvlg(user_id,email,www) VALUES(?,?,?);");

        $stmt2->bind_param('iss', $userID, $email, $password);
        $stmt2->execute();
        
        return true;
    }
    catch (Exception $e)
    {
        return false;
    }
}
?>