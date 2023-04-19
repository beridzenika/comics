<?php
session_start();

$_SESSION = array();
setcookie(session_name(), '', time()-1000, '/');

header('location: index.php');
?>