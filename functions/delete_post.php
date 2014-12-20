<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';

sec_session_start();

if(isset($_GET['id']))
{
    $post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['userID'];
    
    if(i_am_owner_of_post($mysqli, $post_id, $user_id))
    {
        if(deletePost($mysqli, $post_id))
        {
            header("Location: ../blog.php?success=2");
        }
        else
        {
            header("Location: ../blog.php?error=2");
        }
    }
    else
    {
        header("Location: ../blog.php?error=2");
    }
}
else
{
    header("Location: ../blog.php");
}
?>