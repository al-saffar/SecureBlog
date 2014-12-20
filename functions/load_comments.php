<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';
sec_session_start();
if(isset($_POST['id']) && isset($_POST['token'])) //is post id and token set
{
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT); //sanitize
    $token = $_POST['token']; //get token
    
    if($token == $_SESSION['token']) //compare token
    {
        $comms = get_comments($mysqli, $id); //get comments
    }
    
    if($comms != "") //if we got any comments
    {
        var_dump($comms);
    }
    else
    {
        echo "";
    }
}
else
{
    echo "";
}

?>