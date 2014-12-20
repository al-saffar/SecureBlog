<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/config.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/classes/post.php';

function getPosts($mysqli)
{
    $posts;
    $userID = $_SESSION['userID'];
    
    // SELECT p.* FROM `friends` f, `posts` p WHERE `friend2_id` = 28 AND f.`friend1_id` = p.`poster_id` UNION SELECT p.* FROM `friends` f, `posts` p WHERE `friend1_id` = 28 AND f.`friend2_id` = p.`poster_id` ORDER BY `timestamp` DESC LIMIT 10
    
    //very long sql statement, that loads every posts: the users and his friends'
    if ($stmt = $mysqli->prepare("SELECT p.*, u.`firstname`, u.`lastname` FROM `friends` f, `posts` p, `users` u WHERE `friend2_id` = ? AND f.`friend1_id` = p.`poster_id` AND p.`poster_id` = u.`id` UNION "
            . "                   SELECT p.*, u.`firstname`, u.`lastname` FROM `friends` f, `posts` p, `users` u WHERE `friend1_id` = ? AND f.`friend2_id` = p.`poster_id` AND p.`poster_id` = u.`id`  UNION "
            . "                   SELECT p.*, u.`firstname`, u.`lastname` FROM `posts` p, `users` u WHERE p.`poster_id` = ? AND p.`poster_id` = u.`id`  ORDER BY `timestamp` DESC LIMIT 10")) 
    {
        $stmt->bind_param('iii', $userID, $userID, $userID);
 
        $stmt->execute();
        $stmt->store_result();
 
        $stmt->bind_result($postID, $poster, $has_image, $path, $post, $time, $firstname, $lastname);

        //go through all the posts
        while ($stmt->fetch()) {
            $po = htmlentities($post); //against XSS
            $po = nl2br($po); //make the newlines visible on the site
            $po = "<pre>$po</pre>";
            $p = new post($postID, $poster, $firstname, $lastname, $po, $time, $has_image, $path); //save the post on a new object
            
            $posts[] = $p; //put it in a array
        }
        
        return $posts;
    }
    else
    {
        return NULL;
    }
}

function uploadPost($mysqli, $post, $has_image = 0, $image_path = "")
{
    try{
        //save the post on the DB
        $stmt = $mysqli->prepare("INSERT INTO posts(poster_id,has_image,path,post_text) VALUES(?,?,?,?);");

        $user_id = $_SESSION['userID'];
        $stmt->bind_param('iiss', $user_id, $has_image, $image_path, $post);
        $stmt->execute();

        return true;
    }
    catch (Exception $e)
    {
        return false;
    }
}

//checks if the user is the owner for the post (used when trying to delete an post)
function i_am_owner_of_post($mysqli, $post_id, $user_id)
{
    if ($stmt = $mysqli->prepare("SELECT id FROM posts WHERE id = ? AND poster_id = ?")) {
        $stmt->bind_param('ii', $post_id, $user_id);
 
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
}

//deletes post and all its comments
function deletePost($mysqli, $post_id)
{
    try{
        $stmt = $mysqli->prepare("DELETE FROM `sbdb`.`comments` WHERE `post_id` = ?");

        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        
        $stmt = $mysqli->prepare("DELETE FROM `sbdb`.`posts` WHERE `id` = ?");

        $stmt->bind_param('i', $post_id);
        $stmt->execute();

        return true;
    }
    catch (Exception $e)
    {
        return false;
    }
}

//save comment on DB
function postComment($mysqli, $post_id, $comment, $commenter)
{
    try{
        $stmt = $mysqli->prepare("INSERT INTO `sbdb`.`comments` (`post_id`, `commenter`, `value`) VALUES (?,?,?);");

        $stmt->bind_param('iis', $post_id,$commenter, $comment);
        $stmt->execute();

        return true;
    }
    catch (Exception $e)
    {
        return false;
    }
}

//get all comments
function get_comments($mysqli, $post_id)
{
    $comms = "";
    if ($stmt = $mysqli->prepare("SELECT u.firstname, u.lastname, c.value FROM comments c, users u WHERE c.`post_id` = ? AND c.`commenter` = u.id ORDER BY c.time DESC LIMIT 10;")) 
    {
        $stmt->bind_param('i', $post_id);
 
        $stmt->execute();
        $stmt->store_result();
 
        $stmt->bind_result($firstname, $lastname, $comment);

        while ($stmt->fetch()) {
            $comms .= "".$firstname." ".$lastname.".".$comment."|";
        }
        
        return $comms;
    }
    else
    {
        return NULL;
    }
}