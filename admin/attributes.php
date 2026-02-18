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

$cat_id = 0; 
$query = " id>0 ";
if(isset($_POST['c_category'])){
    if ($_POST['c_category']!=0) {
        $cat_id = $_POST['c_category'];
    }
}

if (isset($_GET['page'])) {$curpage = $_GET['page'];}else{$curpage = 0;}
if (isset($_GET['cat_id'])) {$cat_id = $_GET['cat_id'];}

if($cat_id > 0){$query .= " AND attr_category_id = ".$cat_id;}

$s_description = isset($_REQUEST['t_description'])? $_REQUEST['t_description'] : "";
if ($s_description!='') {
	$query .= " AND title LIKE '%$s_description%'";	
}

$sql = "SELECT * FROM app_attributes WHERE ".$query;

/*
if($cat_id > 0) {
	$link = "attributes.php?cat_id=".$cat_id."&page=";
}
else {
	$link = "attributes.php?id=10&page=";
}*/

$link = "attributes.php?cat_id=$cat_id&t_description=$s_description&page=";

$nrOfRows = 20;
//echo $category->get_sql();
$rspage = new RS_PAGE($db1, $sql, "", "", 
	$nrOfRows, $curpage, NULL, $link);
$rs = $rspage->getRS();

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
        
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/code.js"></script>
    <script>
    $(document).ready(function() {	
            $("a.fancybox").fancybox({'type' : 'iframe', 'width' : 800, 'height' : 1000 });	
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
                <div class="col-12"><h2>Attributes</h2></div>
                <div class="col-12">
                    <form class="form-search" action="attributes.php?" method="POST">
                        <h2>Αναζήτηση</h2>
                        <div class="col-12">
                            <div class="col-4">
                                <?php
                                
								//description
								$t_description = new textbox("t_description", "Description", $s_description, "");
								$t_description->get_Textbox();
								
								//category
                                $c_category = new comboBox("c_category", $db1, "SELECT * FROM app_attr_categories", 
                                        "id","description",
                                        $cat_id,
                                        "ΚΑΤΗΓΟΡΙΑ");
                                $c_category->get_comboBox();
                            ?>
                            </div>
                            <div class="col-4">
                                <input id="BtnOk" name="BtnOk" value="Αναζήτηση" type="submit"/>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </form>
                </div>
                <div class="col-12"><a class="button fancybox" href="editattribute.php?id=0">Προσθήκη</a></div>
                <div class="col-12"><div class="sep-h-10"> </div></div>
                <div class="col-12">
                    <div class="grid-container" style="padding: 10px 0px;">
                        <?php                       
                        if($rs){
                             
                            foreach ($rs as $key => $value) {
                                $rs[$key]['attr_type_id'] = func::vlookup('description', 'app_attr_types', 'id='.$rs[$key]['attr_type_id'], $db1);
                                $rs[$key]['attr_category_id'] = func::vlookup('description', 'app_attr_categories', 'id='.$rs[$key]['attr_category_id'], $db1);                                
                            }
                            $gridProducts = new datagrid("gridCats", $db1, $sql, 
                                array("id","title","attr_type_id","attr_category_id"), 
                                array("#","Τίτλος","Type","Category"), 
                                "l=gr", 0, TRUE, "editattribute.php", "Επεξεργασία", TRUE, "delattribute.php", "Διαγραφή", "id", "GR");
                            $gridProducts->set_rs($rs);
                            $gridProducts->set_colWidths(array("30","250","50","50","30","30"));
                            $gridProducts->get_datagrid();
                        }
                        ?>
                    </div>
                    <div class="pagination">
                        <?php 
                        if ($rspage->getCount() > $nrOfRows){
                            echo $rspage->getPrev();
                            echo $rspage->getPageLinks();
                            echo $rspage->getNext();
                        }
                    ?>
                    </div>
                </div>

            </div>
            <div class="clear"> </div>
        </div>
    </body>
</html>