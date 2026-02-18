<?php
require_once('../php/config.php');
session_start();

$_SESSION['KARCHER-AUTHORIZED'] = 0;
session_unset();
session_destroy();
header("Location: ".app::$host."login/login.php");
?>