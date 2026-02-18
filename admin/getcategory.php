<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
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
    
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" media="all"/>

</head>
    <body>
        <?php
        $parentid= $_GET['id'];
        $sql = "SELECT * FROM app_categories where parent_id = ".$parentid;
		$rs = $db1->getRS($sql);
		for ($i=0;$i<count($rs);$i++) {
			if ($rs[$i]['active']==1) {
				$rs[$i]['active'] = "<span class=\"fa fa-check\"></span>";
			}
			else {
				$rs[$i]['active'] = "<span class=\"fa fa-ban\"></span>";
			}
		}
        $gridCats = new datagrid("gridCats", $db1, "", 
            array("id","title","active"), 
            array("#","Title", "Active"), 
            "l=gr", 0, TRUE, "editcategory.php", "Επεξεργασία", TRUE, "delcategory.php", "Διαγραφή", "id", "GR"); 
		$gridCats->set_rs($rs);
        $gridCats->set_hasheaders(FALSE);
        $gridCats->set_treeParams(TRUE,"addsubcategory.php","Προσθήκη","parent_id","app_categories","getcategory.php");
        $gridCats->set_colWidths(array("30","30","250","50","30","30","30"));
        $gridCats->get_datagrid();
        ?>
    </body>
</html>