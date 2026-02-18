<?php
require_once('config.php');
session_start(); 
if (!isset($_SESSION['KARCHER-AUTHORIZED']) || $_SESSION['KARCHER-AUTHORIZED']==0) {
    header("Location: ".app::$host."login/login.php");
    exit;
}

if (isset($_SESSION['KARCHER-AUTHORIZED']) && $_SESSION['KARCHER-AUTHORIZED']<>1) {
    header("Location: ".app::$host."login/login.php");
    exit;
}

$_SESSION['KARCHER-START'] = time(); // taking now logged in time

if(!isset($_SESSION['KARCHER-EXPIRE'])){
    $_SESSION['KARCHER-EXPIRE'] = $_SESSION['KARCHER-START'] + (120) ; // ending a session in 8 hours
}
$now = time(); // checking the time now when home page starts

if(isset($_SESSION['KARCHER-EXPIRE'])){
    if($now > $_SESSION['KARCHER-EXPIRE'])
    {
        session_destroy();
        header("Location: ".app::$host."login/login.php");
    exit;
    }
}
?>