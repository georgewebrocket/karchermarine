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

$id = 0;$copy = 0;$source_id = 0;$category_id = 0;
$item_code = "";
$title = ""; $active = 0;       
$short_description = "";
$description = "";
$features_benefits = "";
$photo = "";$extra_images = "";$downloads = "";
$related_product_ids = "";
$accessories_ids = "";
$cleaning_agents_ids = "";
$clicks_counter = 0;
//$compatible_machines_ids = "";
$adapter_category = 0;

if(isset($_GET['id'])){$id = $_GET['id'];}

if(isset($_GET['copy'])){$copy = $_GET['copy'];}
if(isset($_GET['source_id'])){$source_id = $_GET['source_id'];}

$product = new app_products($db1,$id);

$err = 0; $msg ="";
if (isset($_GET['save']) && $_GET['save'] == 1) {
    //validate
    if ($_POST['t_item_code']=="") {
        $err = 1;
        $msg .= "Ο ΚΩΔΙΚΟΣ ΠΡΟΙΟΝΤΟΣ είναι κενός.<br/>";
    }
    
    $check_code = func::vlookup("id", "app_products", "item_code=".$_POST['t_item_code'], $db1);
    if ($check_code != "" && $check_code != $id){
        $err = 1;
        $msg .= "Αυτος ο κωδικός υπάρχει ήδη.<br/>";
    }
    
    if ($_POST['t_title']=="") {
        $err = 1;
        $msg .= "Ο τίτλος είναι κενός.<br/>";
    }
    
    
    
    if ($err == 0) {
        if(isset($_POST['c_category'])){
            $product->category_id(comboBox::get_ids($_POST['c_category'])); 
        }        
        $product->item_code($_POST['t_item_code']);
        $product->title($_POST['t_title']);
		
		$product->active(checkbox::getVal2($_POST, 'chk_active'));
		$product->clicks_counter($_POST['t_clicks_counter']);
		
        $product->short_description($_POST['t_short_description']);
        $product->description($_POST['t_description']);
        $product->features_benefits($_POST['t_features_benefits']);
        $product->photo($_POST['t_photo']); 
        $product->extra_images($_POST['t_extra_images']);
        $product->downloads($_POST['t_downloads']);
        $product->related_product_ids($_POST['t_related_product_ids']); 
        $product->accessories_ids(MyUtils::set_codes($_POST['t_accessories_ids']));
        $product->cleaning_agents_ids(MyUtils::set_codes($_POST['t_cleaning_agents_ids']));
        $product->standard_accessories_ids(MyUtils::set_codes($_POST['t_standard_accessories_ids']));
//        $product->compatible_machines_ids($_POST['t_compatible_machines_ids']);
        $product->adapter_category($_POST['c_adapter_category']);
        
        
        //save        
        if ($product->Savedata()) {            
            $id = $product->get_id();
            //copy attributes for product
            if($copy == 1){
                $sql_copy = "SELECT * FROM app_product_attributes WHERE product_id = ".$source_id;
                $rs_copy = $db1->getRS($sql_copy);
                foreach ($rs_copy as $key => $copy_attribute) {
                    $rs_res = $db1->execSQL("INSERT INTO app_product_attributes (product_id,attribute_id,value,attr_order) VALUES (?,?,?,?)", 
                    array($id, $copy_attribute['attribute_id'],$copy_attribute['value'],$copy_attribute['attr_order']));
                    if($rs_res === FALSE){
                        $msg .= "Παρουσιάστηκε σφάλμα, τα attributes δεν αντιγράφθηκαν σωστά.<br/>";
                        $err = 1;
                        break;
                    }
                }
            }
            $msg .= "Τα δεδομένα αποθηκεύτηκαν.";
        }
        else {
            $msg .= "Παρουσιάστηκε σφάλμα. Παρακαλώ δοκιμάστε ξανά.<br/>";
        } 
    }
    
}

if($id > 0){
    $category_id = comboBox::set_current_ids($product->category_id());
    $item_code = $product->item_code();
    $title = $product->title();
    $active = $product->active();
    $clicks_counter = $product->clicks_counter();
    $short_description = $product->short_description();
    $description = $product->description();
    $features_benefits = $product->features_benefits();
    $photo = $product->photo();
    $extra_images = $product->extra_images();
    $downloads = $product->downloads();
    $related_product_ids = $product->related_product_ids();
    $accessories_ids = MyUtils::get_codes($product->accessories_ids());
    $cleaning_agents_ids = MyUtils::get_codes($product->cleaning_agents_ids());
    $standard_accessories_ids = MyUtils::get_codes($product->standard_accessories_ids());
    
    $adapter_category = $product->adapter_category();
    

}

if(isset($_POST['c_category'])){$category_id = $_POST['c_category'];}
if(isset($_POST['t_item_code'])){$item_code = $_POST['t_item_code'];}
if(isset($_POST['t_title'])){$title = $_POST['t_title'];}
if(isset($_POST['t_short_description'])){$short_description = $_POST['t_short_description'];}
if(isset($_POST['t_description'])){$description = $_POST['t_description'];}
if(isset($_POST['t_features_benefits'])){$features_benefits = $_POST['t_features_benefits'];}
if(isset($_POST['t_photo'])){$photo = $_POST['t_photo'];}
if(isset($_POST['t_extra_images'])){$extra_images = $_POST['t_extra_images'];}
if(isset($_POST['t_downloads'])){$downloads = $_POST['t_downloads'];}
if(isset($_POST['t_related_product_ids'])){$related_product_ids = $_POST['t_related_product_ids'];}
if(isset($_POST['t_accessories_ids'])){$accessories_ids = $_POST['t_accessories_ids'];}
if(isset($_POST['t_cleaning_agents_ids'])){$cleaning_agents_ids = $_POST['t_cleaning_agents_ids'];}
//if(isset($_POST['t_compatible_machines_ids'])){$compatible_machines_ids = $_POST['t_compatible_machines_ids'];}
$adapter_category = isset($_POST['c_adapter_category'])? $_POST['c_adapter_category']: $adapter_category;

if($err == 0){
    $msg = "<h2 style='color:green;' class=\"msg\">".$msg."</h2>";
}else{
    $msg = "<h2 style='color:red;' class=\"msg\">".$msg."</h2>";
}
    
//for combo box category
$sql = "SELECT id, title AS name, parent_id FROM app_categories";
$cat_view = new categories_view($db1, $sql, 0, 0);

$rs_categories = $cat_view->get_tree_for_combobox(0, 0) ;
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
    
    <!-- Add jQuery library -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
    
    <script type="text/javascript" src="js/code.js"></script>
    <script>
    $(document).ready(function() {	
            $("a.fancybox").fancybox({'type' : 'iframe', 'width' : 1000, 'height' : 1000 });	
    });

    </script>

     
    
    <link href="fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
     
    <!-- Add tinymce -->
    <script src="js/tinymce/tinymce.min.js"></script>
    
    <script>
        tinymce.init({
            selector: '#t_description',
                        relative_urls : false,
			remove_script_host : false,
			convert_urls : true,
			plugins: [
				'advlist autolink lists link image charmap print preview hr anchor pagebreak',
				'searchreplace wordcount visualblocks visualchars code fullscreen',
				'insertdatetime media nonbreaking save table contextmenu directionality',
				'emoticons template paste textcolor colorpicker textpattern imagetools'
			  ],
			  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			  toolbar2: 'print preview media | forecolor backcolor emoticons',
			  image_advtab: true,
			  file_browser_callback : elFinderBrowser 
          });
          
          tinymce.init({
            selector: '#t_features_benefits',
                        relative_urls : false,
			remove_script_host : false,
			convert_urls : true,
			plugins: [
				'advlist autolink lists link image charmap print preview hr anchor pagebreak',
				'searchreplace wordcount visualblocks visualchars code fullscreen',
				'insertdatetime media nonbreaking save table contextmenu directionality',
				'emoticons template paste textcolor colorpicker textpattern imagetools'
			  ],
			  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			  toolbar2: 'print preview media | forecolor backcolor emoticons',
			  image_advtab: true,
			  file_browser_callback : elFinderBrowser 
          });
    
	
	function elFinderBrowser (field_name, url, type, win) {
	  tinymce.activeEditor.windowManager.open({
		file: '/elfinder/elfinder.php?mode=tinymce',// use an absolute path!
		title: 'elFinder 2.0',
		width: 900,  
		height: 600,
		resizable: 'yes'
	  }, {
		setUrl: function (url) {
		  win.document.getElementById(field_name).value = url;
		}
	  });
	  return false;
	}
	
	
	function myalert(msg) {
        $('#cover').show();
        $('#status').html(msg);
    }
    
	
	function closeFancybox(){
    	$.fancybox.close();
	}
	
	
	$(document).ready(function()
    {
        
		$("a.fancybox").fancybox({'type' : 'iframe', 'width' : 1000, 'height' : 1000 });
		
		$('#UploadPhoto').change(function(){ 
            //validate file (image) and size first
            var file = this.files[0];
            var imagefile = file.type;
            var imageTypes= ["image/jpeg","image/png","image/jpg"];
            if(imageTypes.indexOf(imagefile) == -1) {
                    myalert('H φωτογραφία σου θα πρέπει να είναι της μορφής .JPG, .JPEG ή .PNG');
                    document.getElementById("BtnOk").disabled = true;
                    return false;
            }
            else{
                document.getElementById("BtnOk").disabled = false;
            }
            if(file.size > 2097152 ) {
                    myalert('Έχεις ξεπεράσει το μέγεθος των 2 MB. Δοκίμασε μια άλλη φωτογραφία!');
                    document.getElementById("BtnOk").disabled = true;
                    return false;
            }else{
                document.getElementById("BtnOk").disabled = false;
            }

            });
    });
    
    function copyProduct () {
        var form = document.getElementById("editForm");
        form.setAttribute('method', 'POST');
        form.setAttribute('action', 'editproduct.php?id=0&save=1&copy=1&source_id=<?php echo $id; ?>');
        form.submit();
    }
    </script>
    
    <!--multi select -->
    <script src="js/jquery.sumoselect.js"></script>
    <link href="css/sumoselect.css" rel="stylesheet" type="text/css" />
    <script>
        $(function() {
            $('#c_category').SumoSelect({ okCancelInMulti: true, selectAll: true });
        });
    </script>
    <!--multi select -->
    
    <style>
        #editForm {
            /*min-height: 800px;*/
        }
        .SumoSelect {
            margin: 0 0 8px 0;
            width: 100%;
        }
        .SumoSelect > .CaptionCont{
            width: 89.2%;
        }
        .SumoSelect > .optWrapper.open{
            width: 92%;
        }
    </style>
</head>
    <body>
       <div class="wrap">
            <div class="content">
                <div class="col-12">
                    <h1>Καρτέλα προϊόντος</h1>   
                    <?php if ($msg!="") { echo $msg;} ?>
                    <form id="editForm" class="editForm" action="editproduct.php?id=<?php echo $id; ?>&save=1" method="POST" enctype="multipart/form-data">

                        <?php 
                        //id
                        $t_Id = new textbox("t_Id", "ID", $id, "");
                        $t_Id->set_disabled();
                        $t_Id->get_Textbox();
                        
                        //item_code
                        $t_item_code = new textbox("t_item_code", "ΚΩΔΙΚΟΣ ΠΡΟΙΟΝΤΟΣ", $item_code, "*");
                        $t_item_code->get_Textbox();
                        
                        //category
                        $c_category = new comboBox("c_category[]", $db1, "", 
                                "id","description",
                                $category_id,
                                "ΚΑΤΗΓΟΡΙΑ");
                        $c_category->set_multiselect(TRUE);
                        $c_category->set_rs($rs_categories);
                        $c_category->get_comboBox();

                        //title
                        $t_title = new textbox("t_title", "ΤΙΤΛΟΣ", $title, "*");
                        $t_title->get_Textbox();
						
						
						//active
						$chk_active = new checkbox("chk_active", "Active", $active);
                        $chk_active->get_Checkbox();
						
						//clicks
                        $t_clicks_counter = new textbox("t_clicks_counter", "Clicks", $clicks_counter, "");
                        $t_clicks_counter->get_Textbox();
						
                        
                        //related prodact ids
                        $t_related_product_ids = new textbox("t_related_product_ids", "Related products", $related_product_ids, "");
                        $t_related_product_ids->get_Textbox();
                        
                        //accessories ids
                        $t_accessories_ids = new textbox("t_accessories_ids", "Accessories", $accessories_ids, "");
                        $t_accessories_ids->set_multiline();
                        $t_accessories_ids->get_Textbox();
                        
//                        $c_accessories_ids = new comboBox("c_accessories_ids[]", $db1, 
//                                        "SELECT id, item_code FROM app_products", 
//                                        "id","item_code",$accessories_ids,"Accessories");
//                        $c_accessories_ids->set_extraAttr("multiple=\"multiple\"");
//                        $c_accessories_ids->get_comboBox();
                        
                        //cleaning agents ids
                        $t_cleaning_agents_ids = new textbox("t_cleaning_agents_ids", "Cleaning agents", $cleaning_agents_ids, "");
                        $t_cleaning_agents_ids->set_multiline();
                        $t_cleaning_agents_ids->get_Textbox();
                        


			$t_standard_accessories_ids = new textbox("t_standard_accessories_ids", "Standard accessories", $standard_accessories_ids, "");
                        $t_standard_accessories_ids->set_multiline();
                        $t_standard_accessories_ids->get_Textbox();
						
						

                        //short description
                        $t_short_description = new textbox("t_short_description", "ΣΥΝΤΟΜΗ ΠΕΡΙΓΡΑΦΗ", $short_description, "");
                        $t_short_description->set_multiline();
			$t_short_description->get_Textbox();
                        ?>
                        <div class="col-12">
                            <div style="height: 50px; padding-bottom: 20px;">
                                <div class="col-4">FEATURED IMAGE</div>
                                <div class="col-8">
                                    <?php if($photo != ""){ ?>
                                    <img id="img-photo" style="width: 80%; height:auto; margin-bottom:20px" src="<?php echo $photo; ?>"/>
                                    <?php } ?>
                                </div>
                                <div style="clear:both"></div>
                                
                                <div class="col-4"></div>
                                <div class="col-6">
                                    <?php
					$t_photo = new textbox("t_photo", "", $photo, "photo");
                       			echo $t_photo->textboxSimple();
                                    ?>
                                </div>
                                <div class="col-2" style="padding-top:10px">
                                    <a href="../elfinder/elfinder.php?mode=featuredimage" class="button fancybox">Add/edit</a>                                    
                                </div>
                                <div style="clear:both"></div>
                                
                            </div>
                        </div>
                        <div style="clear:both; height:20px"></div>
                        
                        <div class="col-12">
                            <div style="height: 50px; padding-bottom: 20px;">
                                <!--<div class="col-4">SLIDE SHOW</div>-->
<!--                                <div class="col-8">
                                    <img id="img-extra_images" style="width: 100px; height:70px; margin-bottom:20px" src="<?php //echo $extra_images; ?>"/>
                                </div>
                                <div style="clear:both"></div>-->
                                
                                <div class="col-10">
                                    <?php
					$t_extra_images = new textbox("t_extra_images", "SLIDE SHOW", $extra_images, "");
                                        $t_extra_images->set_multiline();
                                        $t_extra_images->get_Textbox();
                                    ?>
                                </div>
                                <div class="col-2" style="padding-top:10px">
                                    <a href="../elfinder/elfinder.php?mode=extraimages" class="button fancybox">Add/edit</a>                                    
                                </div>
                                <div style="clear:both"></div>
                                
                            </div>
                        </div>
                        <div style="clear:both; height:20px"></div>
                        
                        <!--DOWNLOADS-->
                        <div class="col-12">
                            <div style="height: 50px; padding-bottom: 20px;">
                                <div class="col-10">
                                    <?php
					$t_downloads = new textbox("t_downloads", "DOWNLOADS", $downloads, "");
                                        $t_downloads->set_multiline();
                                        $t_downloads->get_Textbox();
                                    ?>
                                </div>
                                <div class="col-2" style="padding-top:10px">
                                    <a href="../elfinder/elfinder.php?mode=pdf_downloads" class="button fancybox">Add/edit</a>                                    
                                </div>
                                <div style="clear:both"></div>
                                
                            </div>
                        </div>
                        <div style="clear:both; height:20px"></div>
                        
                        <!--<a href="../elfinder/elfinder.src.html" class="button fancybox">Add media</a>
                        
                        
                        <div style="clear:both; height:20px"></div>-->
                        <?php
                        //description
                        echo '<div>ΠΕΡΙΓΡΑΦΗ</div>';
                        echo '<div class="sep-h-10"></div>';
                        echo '<textarea name="t_description" id="t_description" rows="10" cols="80">'.$description.'</textarea>';
                        echo '<div style="clear:both"></div>';
                        echo '<div class="sep-h-10"></div>';
                        
                        //features and benefits
                        echo '<div>FEATURES AND BENEFITS</div>';
                        echo '<div class="sep-h-10"></div>';
                        echo '<textarea name="t_features_benefits" id="t_features_benefits" rows="30" cols="80">'.$features_benefits.'</textarea>';
                        echo '<div style="clear:both"></div>';
                        echo '<div class="sep-h-10"></div>';
                        ?>
                        
                        <?php
                        if($id > 0){
                            $sql="SELECT APA.id, APA.value, APA.attr_order, A.title, A.attr_type_id, A.attr_category_id "
                                    . "FROM app_product_attributes AS APA "
                                    ."INNER JOIN app_attributes AS A ON APA.attribute_id = A.id "
                                    . "WHERE APA.product_id = ".$id." ORDER BY APA.attr_order";
                            $rsATTR = $db1->getRS($sql);
                            $rsEQ = array();
                            $rsEQcount = 0;
                            $rsTD = array();
                            $rsTDcount = 0;
                            if($rsATTR){                                
                                foreach ($rsATTR as $key => $value) {
                                    //
                                    if($rsATTR[$key]['attr_type_id'] == '2'){
                                        $rsATTR[$key]['attr_type_id'] = '<i style="background-color: #fff; color:green;" class="fa fa-check-circle fa-2x"></i>';
                                    }
                                    if($rsATTR[$key]['attr_category_id'] == '1'){
                                        $rsTD[$rsTDcount] = $rsATTR[$key];
                                        $rsTDcount++;
                                    }
                                    if($rsATTR[$key]['attr_category_id'] == '2'){
                                        $rsEQ[$rsEQcount] = $rsATTR[$key];
                                        $rsEQcount++;
                                    }
                                    
                                }
                            }   
                            
                            ?>
                            <div class="col-12"><h2 style="border-bottom: 1px solid #e3e3e3;padding: 0 0 12px;">Specifications</h2></div>
                            <div class="col-12"><h2 style="">Technical data</h2></div>
                            <div class="col-12"><a class="button fancybox" href="editproductattribute.php?id=0&prod_id=<?php echo $id; ?>&attr_cat=1">Προσθήκη</a></div>
                            <div class="col-12"><div class="sep-h-10"> </div></div>
                            <div class="col-12">
                                <div class="grid-container" style="padding: 10px 0px;">
                                    <?php
                                    if(count($rsTD)>0){
                                        $gridProductAttributes = new datagrid("gridProductAttributes", $db1, "", 
                                            array("id","title","value","attr_order"), 
                                            array("#","Τίτλος","Τιμή","Σειρά"), 
                                            "attr_cat=1&l=gr", 0, TRUE, "editproductattribute.php", "Επεξεργασία", TRUE, "delproductattribute.php", "Διαγραφή", "id", "GR");
                                        $gridProductAttributes->set_rs($rsTD);
                                        $gridProductAttributes->set_colWidths(array("30","200","200","20","30","30"));
                                        $gridProductAttributes->get_datagrid();
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12"><h2 style="">Equipment</h2></div>
                            <div class="col-12"><a class="button fancybox" href="editproductattribute.php?id=0&prod_id=<?php echo $id; ?>&attr_cat=2">Προσθήκη</a></div>
                            <div class="col-12"><div class="sep-h-10"> </div></div>
                            <div class="col-12">
                                <div class="grid-container" style="padding: 10px 0px;">
                                    <?php
                                    if(count($rsEQ)>0){
                                        $gridProductAttributes = new datagrid("gridProductAttributes", $db1, "", 
                                            array("id","title","value","attr_order"), 
                                            array("#","Τίτλος","Τιμή","Σειρά"), 
                                            "attr_cat=2&l=gr", 0, TRUE, "editproductattribute.php", "Επεξεργασία", TRUE, "delproductattribute.php", "Διαγραφή", "id", "GR");
                                        $gridProductAttributes->set_rs($rsEQ);
                                        $gridProductAttributes->set_colWidths(array("30","200","200","20","30","30"));
                                        $gridProductAttributes->get_datagrid();
                                    }
                                    ?>
                                </div>
                            </div>
                        
                        
                            
                        <div class="col-12"><h2 style="">Adapter data</h2></div>
                        
                        <?php
                        
                        //adapter category
                        $c_adapter_category = new comboBox("c_adapter_category",
                                $db1, 
                                "SELECT id, title  FROM app_categories WHERE parent_id = 100", 
                                "id","title",
                                $adapter_category,
                                "ΚΑΤΗΓ. ADAPTER");
                        $c_adapter_category->get_comboBox();
                        
                        ?>
                        
                        <div class="col-12"><a class="button fancybox" href="editAdapter.php?id=0&product1=<?php echo $id; ?>">Προσθήκη</a></div>
                        <div class="col-12"><div class="sep-h-10"> </div></div>
                        <div class="col-12">
                            <div class="grid-container" style="padding: 10px 0px;">
                                <?php
                                $sql = "SELECT * FROM app_adapter_data WHERE product1=? OR product2 = ?";
                                $rsAdapter = $db1->getRS($sql, array($id,$id));
                                if(count($rsAdapter)>0){
                                    $gridAdapters = new datagrid("gridAdapters", $db1, "", 
                                        array("id","product1","product2","adapter"), 
                                        array("#","Προϊόν 1","Προϊόν 2","Adapter"), 
                                        "l=gr", 0, TRUE, "editAdapter.php", "Επεξεργασία", TRUE, "delAdapter.php", "Διαγραφή", "id", "GR");
                                    $gridAdapters->set_rs($rsAdapter);
                                    $gridAdapters->set_colWidths(array("20", "150","150","150","20","20"));
                                    $gridAdapters->get_datagrid();
                                }
                                ?>
                            </div>
                            
                        </div>
                        
                            
                        <?php
                        
                        
                        } // </ if id>0 >
                        
                        //submit
                        $btnOK = new button("BtnOk", "Αποθήκευση"); 
                        echo "<div class=\"col-4\"></div><div class=\"col-8\">";
                        $btnOK->get_button_simple();
                        
                        $btnCopyFood = new button("btnCopyFood", "Αντιγραφή προϊόντος", "Αντιγραφή προϊόντος");
                        echo "&nbsp;";
                        $btnCopyFood->set_method("copyProduct()");
                        $btnCopyFood->get_button_simple();

                        $btnCloseUpdate = new button("button", "Κλείσιμο και ενημέρωση", "close-update");
                        echo "&nbsp;";
                        $btnCloseUpdate->get_button_simple();
						
						
                        echo "&nbsp;";
                        $host = app::$sitehost;
                        echo "<a target=\"_blank\" class=\"button\" href=\"".$host."product/$id\">PREVIEW PRODUCT PAGE</a>";
						
                        echo "</div>";

                        ?> 

                        <div style="clear: both;"></div>

                    </form>
                </div>
            </div>
            <div class="clear"> </div>
        </div>
        <div id="cover" style="position:fixed; width:100%; height:2000px; top:0px; left:0px; background-color:rgba(0,0,0,0.5); text-align:center; display:none; padding-top:200px;">
            <div id="fb-login" class="err-msg" style="width:400px; margin:auto; padding:30px; background-color:#fff; border:10px solid #999; border-radius:10px">
                <div id="status" style="color:red; font-size:20px; margin-bottom:20px"></div>
                <a onClick="$('#cover').hide();$('#cover-msg').html(''); " class="button" id="hide-cover" style="color:black;">OK</a>
            </div>
        </div>
    </body>
</html>