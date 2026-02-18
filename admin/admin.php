<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
require_once('php/config.php');
require_once('php/db.php');
require_once('php/dataobjects.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/session.php');
require_once ('php/controls.php');

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Kaercher-marine CRM</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="css/reset.css" rel="stylesheet" type="text/css"  media="all" />
    <link href="css/style.css" rel="stylesheet" type="text/css"  media="all" />
    <link href="css/grid.css" rel="stylesheet" type="text/css"  media="all" />

    <!-- Add jQuery library -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>        
</head>
    <body>
        <!-- Header Begin-->
        <?php include 'blocks/header.php'; ?>
        <!-- Header End-->
        <div class="clear"> </div>
        <div class="wrap">
            <div class="content">
                <div class="col-12">

                </div>

            </div>
            <div class="clear"> </div>
        </div>
    </body>
</html>