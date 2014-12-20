<?php
/*
 * The loaded posts are saved in this class, to make it easier to handle
 */

class post {
    private $postID;
    private $posterID;
    private $pFirstname;
    private $pLastname;
    private $post;
    private $time;
    
    private $hasImage;
    private $path;
    
    function __construct($postID, $posterID, $pFirstname, $pLastname, $post, $time, $hasImage = NULL, $path = NULL) {
        $this->postID = $postID;
        $this->posterID = $posterID;
        $this->pFirstname = $pFirstname;
        $this->pLastname = $pLastname;
        $this->post = $post;
        $this->time = $time;
        $this->hasImage = $hasImage;
        $this->path = $path;
    }

    function getPostID() {
        return $this->postID;
    }

    function getPosterID() {
        return $this->posterID;
    }

    function getPFirstname() {
        return $this->pFirstname;
    }

    function getPLastname() {
        return $this->pLastname;
    }

    function getPost() {
        return $this->post;
    }

    function getTime() {
        return $this->time;
    }

    function getHasImage() {
        return $this->hasImage;
    }

    function getPath() {
        return $this->path;
    }
    
    function getPosterName(){
        return $this->pFirstname." ".$this->pLastname;
    }
}
