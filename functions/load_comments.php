<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';
sec_session_start();
if(isset($_POST['id']) && isset($_POST['token']))
{
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $token = $_POST['token'];
    
    if($token == $_SESSION['token'])
    {
        $comms = get_comments($mysqli, $id);
    }
    
    if($comms != "")
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