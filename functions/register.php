<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/registrationMapper.php';

if (isset($_POST['firstname'],$_POST['lastname'],$_POST['mail'],$_POST['token'],$_POST['dob'],$_POST['gen'], $_POST['cit'])) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['mail'];
    $password = $_POST['token'];
    $dob = $_POST['dob'];
    $gender = $_POST['gen']; 
    $city = $_POST['cit'];
    
    $pass = hash("SHA512", $password.$email);
    if(register($email, $firstname, $lastname, $dob, $gender, $city, $pass, $mysqli))
    {
        header('Location: ../index.php?success=1');
    }
    else {
        header('Location: ../index.php?error=2');
    }
}
else
{
    echo "REQUEST DENIED";
    echo $_POST['firstname'];
    echo $_POST['lastname'];
    echo $_POST['mail'];
    echo $_POST['p'];
    echo $_POST['dob'];
    echo $_POST['gen'];
    echo $_POST['cit'];
}

?>