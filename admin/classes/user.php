<?php


class user {
    
    private $id;
    private $email;
    private $firstname;
    private $lastname;
    private $DOB;
    private $gender;
    private $type;
    private $timestamp;
    
    function __construct($id, $email, $firstname, $lastname, $DOB, $gender, $type, $timestamp) {
        $this->id = $id;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->DOB = $DOB;
        $this->gender = $gender;
        $this->type = $type;
        $this->timestamp = $timestamp;
        
    }

    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getFirstname() {
        return $this->firstname;
    }

    function getLastname() {
        return $this->lastname;
    }

    function getDOB() {
        return $this->DOB;
    }

    function getGender() {
        return $this->gender;
    }

    function getType() {
        return $this->type;
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    function setDOB($DOB) {
        $this->DOB = $DOB;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setType($type) {
        $this->type = $type;
    }


    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }


    
   
    

}
