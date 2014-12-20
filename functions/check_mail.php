<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/registrationMapper.php';

if(isset($_POST['mail'])) //if mail is set
{
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL); //sanitize it
    if(unique_mail($mail, $mysqli)) //check if this email is used by another
    {
        echo 'true'; //it is unique
    }
    else {
        echo 'false';
    }
}
?>