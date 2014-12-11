<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/registrationMapper.php';

if(isset($_POST['mail']))
{
    $mail = $_POST['mail'];
    if(unique_mail($mail, $mysqli))
    {
        echo 'true';
    }
    else {
        echo 'false';
    }
}
?>