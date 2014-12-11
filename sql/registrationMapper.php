<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';

function register($email, $firstname, $lastname, $dob, $gender, $city, $password, $mysqli)
{
    if(unique_mail($email, $mysqli))
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
    else
    {
        return false;
    }
}

function unique_mail($mail, $mysqli)
{
    if($stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?"))
    {
        $stmt->bind_param('s', $mail);
        $stmt->execute();
        $stmt->store_result();
        
        $stmt->bind_result($mail);
        $stmt->fetch();
        
        if($stmt->num_rows > 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}
?>