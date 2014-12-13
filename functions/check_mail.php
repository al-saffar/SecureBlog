<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/registrationMapper.php';

if(isset($_POST['mail']))
{
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
    if(unique_mail($mail, $mysqli))
    {
        echo 'true';
    }
    else {
        echo 'false';
    }
}
?>