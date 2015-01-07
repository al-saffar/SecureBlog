<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';

sec_session_start();

if(isset($_GET['id']) && isset($_GET['token']))
{
    $post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); //sanitize
    $user_id = $_SESSION['userID']; //get user ID from session
    
    $token = $_GET['token']; //get token
    
    if($token == $_SESSION['token'] && i_am_owner_of_post($mysqli, $post_id, $user_id)) //check if token is alright and the user is the owner of this post
    {
        if(deletePost($mysqli, $post_id)) //delete it
        {
            header("Location: ../blog.php");
        }
        else
        {
            header("Location: ../blog.php");
        }
    }
    else
    {
        header("Location: ../blog.php");
    }
}
else
{
    header("Location: ../blog.php");
}
?>