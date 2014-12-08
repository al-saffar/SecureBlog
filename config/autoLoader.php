<?php
try {
 
include_once '../SecureBlog/database/db_connect.php';
include_once '../SecureBlog/sql/loginMapper.php';
include_once '../SecureBlog/config/secure_session.php';   
include_once '../SecureBlog/admin/my.php'; 

} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}
?>