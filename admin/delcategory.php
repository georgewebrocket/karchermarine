<?php
//ini_set('display_errors',1); 
//error_reporting(E_ALL);
require_once('php/config.php');
require_once('php/db.php');
require_once('php/dataobjects.php');
require_once('php/utils.php');
require_once('php/start.php');
require_once('php/session.php');
require_once('php/controls.php');

$id=0;
$msg='';
if(isset($_GET['id'])){$id=$_GET['id'];}

if (isset($_GET['del']) && $_GET['del'] == 1) {
    $Cat = new app_categories($db1, $id);
    $parent_id = $Cat->parent_id();
    if($Cat->Delete()) {
        $id = 0;
        $msg = "<h2 style='color:green;' class='msg'>Κατηγορία διαγράφτηκε με επιτυχία</h2>";
    }
    else{
        $msg = "<h2 style='color:red;' class='msg'>Παρουσιάστηκε σφάλμα. Παρακαλώ δοκιμάστε ξανά.</h2>";
    }
    
    //Check for child categories into parent category
    $sqlCatChilds = "SELECT id FROM app_categories WHERE parent_id=".$parent_id;
    $catChilds = $db1->getRS($sqlCatChilds);
    if($catChilds){
        $db1->execSQL("UPDATE app_categories SET nodes=? WHERE id=?", array("1",$parent_id));
    }else{
        $db1->execSQL("UPDATE app_categories SET nodes=? WHERE id=?", array("0",$parent_id));
    }
}

if($id>0){
    $Cat = new app_categories($db1, $id);
    
    //Check for child categories
    $sqlCatsDel = "SELECT id FROM app_categories WHERE parent_id=".$id;
    
    $cats = $db1->getRS($sqlCatsDel);
    
    if($cats){
        $msg="Υπάρχουν υποκατεγορίες στην κατηγορία.</br>";
    }
    
    //Check for category products
    $sqlProductsDel = "SELECT id FROM app_products WHERE category_id=".$id;
    
    $products = $db1->getRS($sqlProductsDel);
    
    if($products){
        $msg="Υπάρχουν προϊοντα στην κατηγορία.</br>";
    }
    
    $msg.="Θέλετε να διαγράψετε την κατηγορία ".$Cat->title().";";
    $msg = "<h2 style='color:red;' class='msg'>".$msg."</h2>";    
}

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Kaercher-marine CRM</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css"  media="all" />
        <link href="css/style.css" rel="stylesheet" type="text/css"  media="all" />
        <link href="css/grid.css" rel="stylesheet" type="text/css"  media="all" />
    </head>
	<body>
            <div class="wrap">
                <div class="content">
                    <div class="col-12">
                        <h1>Διαγραφή κατηγορίας</h1>
                        <?php if ($msg!="") { echo $msg;}  ?>
                        <form id="formDel" action="delcategory.php?id=<?php echo $id; ?>&del=1" method="POST">
                            <?php
                            //submit
                            if(!isset($_GET['del'])){
                                $btnOK = new button("BtnOk", "Διαγραφή"); 
                                echo "<div class=\"col-4\"></div><div class=\"col-8\">";
                                $btnOK->get_button_simple();
                            }
                            $strUrl = app::$host."categories.php";
                            echo "<input style='margin-left: 10px;' onclick='window.parent.location=\"".$strUrl."\";' type='button' value='Κλείσιμο και ενημέρωση' />";                            
                            echo "</div>";
                            echo '<div style="clear:both"></div>';
                            ?>
                        </form>
                        <div style="clear:both"></div>
                    </div>                                 
                </div>
                <div class="clear"> </div>
            </div>
	</body>
</html>