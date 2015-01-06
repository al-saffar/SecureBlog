<?php

class loginAttemps {
    
private $ip;
private $email;
private $time;
private $timestamp;

function __construct($ip, $email, $time, $timestamp) {
    $this->ip = $ip;
    $this->email = $email;
    $this->time = $time;
    $this->timestamp = $timestamp;
}

function getIp() {
    return $this->ip;
}

function getEmail() {
    return $this->email;
}

function getTime() {
    return $this->time;
}

function getTimestamp() {
    return $this->timestamp;
}

function setIp($ip) {
    $this->ip = $ip;
}

function setEmail($email) {
    $this->email = $email;
}

function setTime($time) {
    $this->time = $time;
}

function setTimestamp($timestamp) {
    $this->timestamp = $timestamp;
}






}
?>

