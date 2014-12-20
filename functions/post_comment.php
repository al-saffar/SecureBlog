<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';

sec_session_start();
if(isset($_POST['post_id']) && isset($_POST['comment']))
{
    $id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['userID'];
    
    if(!is_numeric($user_id))
    {
        return 'false';
    }
    
    if(postComment($mysqli, $id, $_POST['comment'], $user_id))
    {
        echo 'true';
    }
    else {
        echo 'false';
    }
}

?>