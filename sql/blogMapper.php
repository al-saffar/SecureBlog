<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/config.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/classes/post.php';

function getPosts($mysqli)
{
    $posts;
    $userID = $_SESSION['userID'];
    
    // SELECT p.* FROM `friends` f, `posts` p WHERE `friend2_id` = 28 AND f.`friend1_id` = p.`poster_id` UNION SELECT p.* FROM `friends` f, `posts` p WHERE `friend1_id` = 28 AND f.`friend2_id` = p.`poster_id` ORDER BY `timestamp` DESC LIMIT 10
    
    if ($stmt = $mysqli->prepare("SELECT p.*, u.`firstname`, u.`lastname` FROM `friends` f, `posts` p, `users` u WHERE `friend2_id` = ? AND f.`friend1_id` = p.`poster_id` AND p.`poster_id` = u.`id` UNION "
            . "                   SELECT p.*, u.`firstname`, u.`lastname` FROM `friends` f, `posts` p, `users` u WHERE `friend1_id` = ? AND f.`friend2_id` = p.`poster_id` AND p.`poster_id` = u.`id`  UNION "
            . "                   SELECT p.*, u.`firstname`, u.`lastname` FROM `posts` p, `users` u WHERE p.`poster_id` = ? AND p.`poster_id` = u.`id`  ORDER BY `timestamp` DESC LIMIT 10")) 
    {
        $stmt->bind_param('iii', $userID, $userID, $userID);
 
        $stmt->execute();
        $stmt->store_result();
 
        $stmt->bind_result($postID, $poster, $has_image, $path, $post, $time, $firstname, $lastname);

        while ($stmt->fetch()) {
            $p = new post($postID, $poster, $firstname, $lastname, $post, $time, $has_image, $path);
            
            $posts[] = $p;
        }
        
        return $posts;
    }
    else
    {
        return NULL;
    }
}