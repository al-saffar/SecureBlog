<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';
sec_session_start(); // start secure session

if(isset($_POST['new_post']) && isset($_POST['token'])) //every 'POST's set
{
    //get them
    $post = $_POST['new_post'];
    $token = $_POST['token'];
    
    if(strlen($post) > 0 && $token == $_SESSION['token']) //the user did post something and the tokens match
    {
        $imageIsSet = 0;
        $image_path = "";
        
        if(!empty($_FILES["post_image"]['name'])) //did the user add an image too?
        {
            $image_path = "".saveImage();
            if($image_path !="")
            {
                $imageIsSet = 1;
            }
            else
            {
                header("Location: ../blog.php?error=1");
            }
        }
        
        if(strlen($post) < 500 && uploadPost($mysqli, $post,$imageIsSet, $image_path)) //if its less then 500 chars and we could upload it
        {
            header("Location: ../blog.php?success=1");
        }
        else
        {
            header("Location: ../blog.php?error=1");
        }
    }
    else
    {
        header("Location: ../blog.php");
    }
}

function saveImage() //method that checks the image and makes sure it is an image
{
    if(!empty($_FILES["post_image"]['name']))
    {
        //get IP
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $file_info = new SplFileInfo($_FILES["post_image"]["name"]);
        $image_name = hash("SHA1", $_SESSION['userID'].time().$ip.$_SERVER['HTTP_USER_AGENT']) . ".".$file_info->getExtension(); //generate random name

        $target_dir = "../assets/uploads/"; //the folder, the images are saved in
        $target_file = $target_dir . $image_name;

        $isValidImage = true;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        // Check if it is an image
        $check = getimagesize($_FILES["post_image"]["tmp_name"]);
        if($check == false) {
            $isValidImage = false;
        }

        // make sure the image isn't too big
        if ($_FILES["post_image"]["size"] > 500000) {
            $isValidImage = false;
        }

        //check that the filetype is allowed
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $isValidImage = false;
        }

        //if we didn't pass the tests, then return nothing
        if ($isValidImage == false) {
            return "";
        } else { //else save the image on the server
            if (move_uploaded_file($_FILES["post_image"]["tmp_name"], $target_file)) {
                return $image_name;
            } else {
                return "";
            }
        }
    }
}

?>
