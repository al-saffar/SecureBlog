<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/registrationMapper.php';
sec_session_start();

if (isset($_POST['firstname'],$_POST['lastname'],$_POST['mail'],$_POST['token'],$_POST['dob'],$_POST['gen'], $_POST['cit'], $_POST['password'])) {

    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gen', FILTER_SANITIZE_NUMBER_INT);
    $city = filter_input(INPUT_POST, 'cit', FILTER_SANITIZE_NUMBER_INT);
    $token = $_POST['password'];
    
    $salt = hash("SHA512", $email);
    $pass = hash("SHA512", $password.$salt);
    if($token == $_SESSION['token'] && register($email, $firstname, $lastname, $dob, $gender, $city, $pass, $mysqli))
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
}

?>