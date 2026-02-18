<?php
//ini_set('display_errors',1); 
//error_reporting(E_ALL);
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
$attr_type_id = 0;
$title = '';
$description = '';
if(isset($_GET['id'])){$id = $_GET['id'];}

$attribute = new app_attributes($db1, $id);

$err = 0; $msg ="";
if (isset($_GET['save']) && $_GET['save'] == 1) {
    //validate
    if ($_POST['t_title']=="") {
        $err = 1;
        $msg .= "Ο τίτλος είναι κενός.<br/>";
    }
    
    if ($_POST['c_attr_category_id']=="") {
        $err = 1;
        $msg .= "Category είναι κενό.<br/>";
    }
    
    if ($_POST['c_attr_type_id']=="") {
        $err = 1;
        $msg .= "Type είναι κενό.<br/>";
    }
    
    if ($err == 0) {
        $attribute->attr_category_id($_POST['c_attr_category_id']);
        $attribute->attr_type_id($_POST['c_attr_type_id']);
        $attribute->description($_POST['t_description']);
        $attribute->title($_POST['t_title']);
        
        //save
        if ($attribute->Savedata()) {
            $msg .= "Τα δεδομένα αποθηκεύτηκαν.";
            $id = $attribute->get_id();
        }
        else {
            $msg .= "Παρουσιάστηκε σφάλμα. Παρακαλώ δοκιμάστε ξανά.<br/>";
        } 
    }
    
}

if($id > 0){
    $attr_category_id =  $attribute->attr_category_id();
    $attr_type_id = $attribute->attr_type_id();
    $title = $attribute->title();
    $description = $attribute->description();   
}
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
                    <h1>Καρτέλα Specifications</h1>   
                    <?php if ($msg!="") { echo $msg;} ?>
                    <form id="editForm" class="editForm" action="editattribute.php?id=<?php echo $id; ?>&save=1" method="POST" enctype="multipart/form-data">

                        <?php 
                        //id
                        $t_Id = new textbox("t_Id", "ΚΩΔΙΚΟΣ", $id, "");
                        $t_Id->set_disabled();
                        $t_Id->get_Textbox();  
                        
                        //attribute title
                        $t_title = new textbox("t_title", "Τίτλος", $title, "*");
                        $t_title->get_Textbox();
                        
                        //attribute category
                        $c_attr_category_id = new comboBox("c_attr_category_id", $db1, "SELECT * FROM app_attr_categories", 
                                "id","description",
                                $attr_category_id,
                                "Category");
                        $c_attr_category_id->get_comboBox();
                        
                        //attribute type
                        $c_attr_type_id = new comboBox("c_attr_type_id", $db1, "SELECT * FROM app_attr_types", 
                                "id","description",
                                $attr_type_id,
                                "Type");
                        $c_attr_type_id->get_comboBox();

                        //short description
                        $t_description = new textbox("t_description", "ΠΕΡΙΓΡΑΦΗ", $description, "");
                        $t_description->set_multiline();
			$t_description->get_Textbox();
                       
                        //submit
                        $btnOK = new button("BtnOk", "Αποθήκευση"); 
                        echo "<div class=\"col-4\"></div><div class=\"col-8\">";
                        $btnOK->get_button_simple();
                        
                        $btnCloseUpdate = new button("button", "Κλείσιμο και ενημέρωση", "close-update");
                        echo "&nbsp;";
                        $btnCloseUpdate->get_button_simple();
                        echo "</div>";

                        ?> 

                        <div style="clear: both;"></div>

                    </form>
                </div>
            </div>
            <div class="clear"> </div>
        </div>
    </body>
</html>