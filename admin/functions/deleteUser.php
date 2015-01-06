<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/sql/usersMapper.php';


if(isset($_POST['checkbox']) && isset($_POST['token']))
{
    $id = $_POST['checkbox']; 
    $token = $_POST['token']; //get token
    
    if($token == $_SESSION['token'] && deleteUser($mysqli, $id))
    {
        
        header("Location: ../admin/adminDashboard.php");
    }
    else
    {
        header("Location: ../admin/adminDashboard.php");
    }
}
else
{
    header("Location: ../admin/adminDashboard.php");
}
?>