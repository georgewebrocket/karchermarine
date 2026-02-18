<?php
//ini_set('display_errors',1); 
//error_reporting(E_ALL);
require_once('php/config.php');
require_once('php/db.php');
require_once('php/dataobjects.php');
require_once('php/utils.php');
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
    <link href="fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
        
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/code.js"></script>
    <script>
    $(document).ready(function() {	
            $("a.fancybox").fancybox({'type' : 'iframe', 'width' : 1000, 'height' : 1000 });	
    });

    </script>       
    <style>
        #gridCats {
            
        }
    </style>
</head>
    <body>
        <!-- Header Begin-->
        <?php include 'blocks/header.php'; ?>
        <!-- Header End-->
        <div class="clear"> </div>
        <div class="wrap">
            <div class="content">
                <div class="col-12"><h2>Κατεγορίες</h2></div>
                <div class="col-12"><a class="button fancybox" href="editcategory.php?id=0">Προσθήκη</a></div>
                <div class="col-12"><div class="sep-h-10"> </div></div>
                <div class="col-12">
                    <div class="grid-container" style="padding: 10px 0px;">
                        <?php
                        $sql = "SELECT * FROM app_categories where parent_id = 0";
                        $gridCats = new datagrid("gridCats", $db1, $sql, 
                            array("id","title"), 
                            array("#","Τίτλος"), 
                            "l=gr", 0, TRUE, "editcategory.php", "Επεξεργασία", TRUE, "delcategory.php", "Διαγραφή", "id", "GR"); 
                        $gridCats->set_treeParams(TRUE,"addsubcategory.php","Προσθήκη","parent_id","app_categories","getcategory.php");
                        $gridCats->set_colWidths(array("30","30","250","30","30","30"));
                        if($gridCats->get_rs()){
                            $gridCats->get_datagrid();
                        }
                        ?>
                    </div>
                </div>

            </div>
            <div class="clear"> </div>
        </div>
    </body>
</html>