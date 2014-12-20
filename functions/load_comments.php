<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';

if(isset($_POST['id']))
{
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $comms = get_comments($mysqli, $id);
    
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