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
require_once ('php/SimpleImage.php');

$id = 0;
$attr_category_id = 0;
$product_id = 0;
$attribute_id = 0;
$value = ""; 
$attr_order = "";
$except_attribute_ids = "";

if(isset($_GET['id'])){$id = $_GET['id'];}
if(isset($_GET['attr_cat'])){$attr_category_id = $_GET['attr_cat'];}
$attr_category_descr = func::vlookup('description', 'app_attr_categories', 'id='.$attr_category_id, $db1);
if(isset($_GET['prod_id'])){$product_id = $_GET['prod_id'];}


$product_attribute = new app_product_attributes($db1, $id);

$err = 0; $msg ="";
if (isset($_GET['save']) && $_GET['save'] == 1) {
    //validate    
    if ($_POST['c_attribute']=="") {
        $err = 1;
        $msg .= $attr_category_descr." είναι κενό.<br/>";
    }
    
    //get ids for attributes that exist too
    if($id == 0){
        $arr_attribute_ids = $db1->getRS("SELECT attribute_id FROM app_product_attributes WHERE product_id = ".$product_id);
        if($arr_attribute_ids){
            $arr_except_attribute_ids = array();
            foreach ($arr_attribute_ids as $key => $value_arr) {
                $arr_except_attribute_ids[] = $value_arr['attribute_id'];
            }
            if($err == 0){
                if(in_array($_POST['c_attribute'], $arr_except_attribute_ids)){
                    $err = 1;
                    $msg .= "Attribute υπάρχει ήδη.<br/>";
                }
            }
        }
    }
    
    if ($_POST['t_attr_order']=="") {
        $err = 1;
        $msg .= "Η σειρά είναι κενή.<br/>";
    }
        
    if ($err == 0) {
        $product_attribute->product_id($product_id);
        $product_attribute->attribute_id($_POST['c_attribute']);
        $product_attribute->value($_POST['t_value']);
        $product_attribute->attr_order($_POST['t_attr_order']);
        
        //save
        if ($product_attribute->Savedata()) {
            $msg .= "Τα δεδομένα αποθηκεύτηκαν.";
            $id = $product_attribute->get_id();
        }
        else {
            $msg .= "Παρουσιάστηκε σφάλμα. Παρακαλώ δοκιμάστε ξανά.<br/>";
        } 
    }    
}

if($id > 0){
    $product_id = $product_attribute->product_id();
    $attribute_id = $product_attribute->attribute_id();
    $value = $product_attribute->value();
    $attr_order = $product_attribute->attr_order();
}
//if (isset($_POST['c_attribute'])) {$attribute_id = $_POST['c_attribute'];}
if (isset($_POST['t_value'])) {$value = $_POST['t_value'];}
if (isset($_POST['t_attr_order'])) {$attr_order = $_POST['t_attr_order'];}
if (isset($_POST['c_attribute'])) {$attribute_id = $_POST['c_attribute'];}


if($err == 0){
    $msg = "<h2 style='color:green;' class=\"msg\">".$msg."</h2>";
}else{
    $msg = "<h2 style='color:red;' class=\"msg\">".$msg."</h2>";
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
                    <h1>Καρτέλα Specifications <?php echo $attr_category_descr;?></h1>   
                    <?php if ($msg!="") { echo $msg;} ?>
                    <form id="editForm" class="editForm" action="editproductattribute.php?id=<?php echo $id; ?>&prod_id=<?php echo $product_id; ?>&attr_cat=<?php echo $attr_category_id; ?>&save=1" method="POST" enctype="multipart/form-data">

                        <?php 
                        //id
                        $t_Id = new textbox("t_Id", "ΚΩΔΙΚΟΣ", $id, "");
                        $t_Id->set_disabled();
                        $t_Id->get_Textbox();  
                        
                        //attribute
                        $sql_attributes = "SELECT * FROM app_attributes WHERE attr_category_id = ".$attr_category_id;
                        $c_attribute = new comboBox("c_attribute", $db1, $sql_attributes, 
                                "id","title",
                                $attribute_id,
                                $attr_category_descr);
                        $c_attribute->get_comboBox();
                        
                        //value
                        $t_value = new textbox("t_value", "Τιμή", $value, "");
                        $t_value->get_Textbox();
                        
                        //attribute order
                        $t_attr_order = new textbox("t_attr_order", "ΣΕΙΡΑ", $attr_order, "");
                        $t_attr_order->get_Textbox();                        
                       
                        //submit
                        $btnOK = new button("BtnOk", "Αποθήκευση"); 
                        echo "<div class=\"col-4\"></div><div class=\"col-8\">";
                        $btnOK->get_button_simple();
                        
                        $strUrl = app::$host."editproduct.php?id=".$product_id;
                        echo "<input style='margin-left:10px;' onclick='window.parent.location=\"".$strUrl."\";' type='button' value='Κλείσιμο και ενημέρωση' />";
                        echo "</div>";
                        echo '<div style="clear:both"></div>';

                        ?> 

                        <div style="clear: both;"></div>

                    </form>
                </div>
            </div>
            <div class="clear"> </div>
        </div>
    </body>
</html>