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
require_once('php/controls.php');

$id = $_GET['id'];
$adapter_data = new app_adapter_data($db1, $id);

$msg = "";

if ($_POST) {
    if ($_POST['t_product1']!="") {
        $sql = "SELECT * FROM app_products WHERE item_code = ?";
        $rs = $db1->getRS($sql,array($_POST['t_product1']));
        if ($rs) {
            $adapter_data->product1($rs[0]['id']);
        }
    }
    
    if ($_POST['t_product2']!="") {
        $sql = "SELECT * FROM app_products WHERE item_code = ?";
        $rs = $db1->getRS($sql,array($_POST['t_product2']));
        if ($rs) {
            $adapter_data->product2($rs[0]['id']);
        }
    }
    
    if ($_POST['t_adapter']!="") {
        $sql = "SELECT * FROM app_products WHERE item_code = ?";
        $rs = $db1->getRS($sql,array($_POST['t_adapter']));
        if ($rs) {
            $adapter_data->adapter($rs[0]['id']);
        }
    }
    else {
        $adapter_data->adapter(0);
    }
    
    if ($adapter_data->Savedata()) {
        $msg .= "Τα δεδομένα αποθηκεύτηκαν.";
        $id = $adapter_data->get_id();
    }
    
}

$product1code = func::vlookup("item_code", "app_products", "id=" . $adapter_data->product1(), $db1);
$product2code = func::vlookup("item_code", "app_products", "id=" . $adapter_data->product2(), $db1);
$adapterCode = func::vlookup("item_code", "app_products", "id=" . $adapter_data->adapter(), $db1);

if ($id==0 && isset($_GET['product1'])) {
    $product1code = func::vlookup("item_code", "app_products", "id=" . $_GET['product1'], $db1);
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
        <h1>Adapter data</h1> 
        <form id="editForm" class="editForm" action="editAdapter.php?id=<?php echo $id; ?>" method="post">
            <?php 
            //id
            
            $t_id = new textbox("t_id", "ID", $id, "");
            $t_id->set_disabled();
            $t_id->get_Textbox(); 
            
            $t_product1 = new textbox("t_product1", "Product-1", $product1code, "");
            $t_product1->get_Textbox();
            
            $t_product2 = new textbox("t_product2", "Product-2", $product2code, "");
            $t_product2->get_Textbox();
            
            $t_adapter = new textbox("t_adapter", "Adapter", $adapterCode, "");
            $t_adapter->get_Textbox();
            
            //submit
            $btnOK = new button("BtnOk", "Αποθήκευση"); 
            echo "<div class=\"col-4\"></div><div class=\"col-8\">";
            $btnOK->get_button_simple();
            echo "</div>";
            
            ?>
            <div style="clear: both;"></div>
            
        </form>
        <div style="clear: both;"></div>
    </div>
    <div style="clear: both;"></div>
</div>
                
    
</body>
</html>