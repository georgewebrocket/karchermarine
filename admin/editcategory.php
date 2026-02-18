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
$ParentId = 0;
$title = "";        
$short_description = "";
$description = "";
$photo = "";
$product_image = "";
$level = 0;
$nodes = 0;
$active = 0;
if(isset($_GET['id'])){$id = $_GET['id'];}
if(isset($_GET['ParentId'])){$ParentId = $_GET['ParentId'];}

$category = new app_categories($db1,$id);

$err = 0; $msg ="";
if (isset($_GET['save']) && $_GET['save'] == 1) {
    //validate
    if ($_POST['t_title']=="") {
        $err = 1;
        $msg .= "Ο τίτλος είναι κενός.<br/>";
    }
      
    if ($err == 0) {
        $category->parent_id($_POST['c_category']);
        $category->title($_POST['t_title']);        
        $category->short_description($_POST['t_short_description']);
        $category->description($_POST['t_description']);
        
        
        //get parent category level
        $parent_cat_level = func::vlookup("level","app_categories","id=".$category->parent_id(),$db1);
        if($parent_cat_level != ""){$level = $parent_cat_level + 1;}
        $category->level($level);
        //$category->nodes($val);
        
        //if category do not have child set category node 0 and
        if($id == 0){
            $category->nodes(0);        
        }
        
		$category->photo($_POST['t_photo']);
                $category->product_image($_POST['t_product_image']);
        
		$active = checkbox::getVal2($_POST, 'chk_active');		
		$category->active($active);
		
        //save
        if ($category->Savedata()) {
            $msg .= "Τα δεδομένα αποθηκεύτηκαν.";
            $id = $category->get_id();
        }
        else {
            $msg .= "Παρουσιάστηκε σφάλμα. Παρακαλώ δοκιμάστε ξανά.<br/>";
        } 
        //set parent category node 1
        if($category->parent_id() > 0){
            $rs = $db1->execSQL("UPDATE app_categories SET nodes=? WHERE id=?", array("1",$category->parent_id()));
        }
        if($ParentId > 0 ){ 
            $child_id = func::vlookup("id","app_categories","parent_id=".$ParentId,$db1);
            if($child_id == ""){
                $rs = $db1->execSQL("UPDATE app_categories SET nodes=? WHERE id=?", array("0",$ParentId));
            }
        }
        
    }
    
}

if($id > 0){
    $ParentId = $category->parent_id();
    $title = $category->title();        
    $short_description = $category->short_description();
    $description = $category->description();
    $photo = $category->photo();
    $product_image = $category->product_image();
    $level = $category->level();
    $nodes = $category->nodes();
	$active = $category->active();
}
if(isset($_POST['c_category'])){$ParentId = $_POST['c_category'];}
if(isset($_POST['t_title'])){$title = $_POST['t_title'];}
if(isset($_POST['t_short_description'])){$short_description = $_POST['t_short_description'];}
if(isset($_POST['t_description'])){$description = $_POST['t_description'];}
if(isset($_POST['t_photo'])){$photo = $_POST['t_photo'];}
if(isset($_POST['t_product_image'])){$product_image = $_POST['t_product_image'];}

if(isset($_POST['BtnOk'])) {
	$active = checkbox::getVal2($_POST, 'chk_active');
}

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

    <!-- Add jQuery library -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script> 
    
    <link href="fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
     
    <!-- Add tinymce -->
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    
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
    </script>
    <style>
        #editForm {
            /*min-height: 800px;*/
        }
    </style>
</head>
    <body>
       <div class="wrap">
            <div class="content">
                <div class="col-12">
                    <h1>Καρτέλα κατηγορίας</h1>   
                    <?php if ($msg!="") { echo $msg;} ?>
                    <form id="editForm" class="editForm" action="editcategory.php?id=<?php echo $id; ?>&ParentId=<?php echo $ParentId; ?>&save=1" method="POST" enctype="multipart/form-data">

                        <?php 
                        //id
                        $t_Id = new textbox("t_Id", "ΚΩΔΙΚΟΣ", $id, "");
                        $t_Id->set_disabled();
                        $t_Id->get_Textbox();  
                        
                        //PARENT category
                        $c_category = new comboBox("c_category", $db1, "", 
                                "id","description",
                                $ParentId,
                                "ΜΗΤΡΙΚΗ ΚΑΤΗΓΟΡΙΑ");
                        $c_category->set_rs($rs_categories);
                        $c_category->get_comboBox();

                        //title
                        $t_title = new textbox("t_title", "Title", $title, "*");
                        $t_title->get_Textbox();
						
						//active
						$chk_active = new checkbox("chk_active", "Active", $active);
						$chk_active->get_Checkbox();

                        //short description
                        $t_short_description = new textbox("t_short_description", "Description", $short_description, "");
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
                                <div class="col-4">PRODUCT IMAGE</div>
                                <div class="col-8">
                                    <?php if($product_image != ""){ ?>
                                    <img id="img-product-image" style="width: 80%; height:auto; margin-bottom:20px" src="<?php echo $product_image; ?>"/>
                                    <?php }?>
                                </div>
                                <div style="clear:both"></div>
                                
                                <div class="col-4"></div>
                                <div class="col-6">
                                    <?php
									$t_product_image = new textbox("t_product_image", "", $product_image, "product_image");
                       				echo $t_product_image->textboxSimple();
									?>
                                </div>
                                <div class="col-2" style="padding-top:10px">
                                    <a href="../elfinder/elfinder.php?mode=productimage" class="button fancybox">Add/edit</a>                                    
                                </div>
                                <div style="clear:both"></div>
                                
                            </div>
                        </div>
                        <div style="clear:both; height:20px"></div>
                        
                        <!--<a href="../elfinder/elfinder.src.html" class="button fancybox">Add media</a>
                        
                        
                        <div style="clear:both; height:20px"></div>-->
                        <?php
                        //description
                        echo '<textarea name="t_description" id="t_description" rows="30" cols="80">'.$description.'</textarea>';
                        echo '<div style="clear:both"></div>';
                        echo '<div class="sep-h-10"></div>';

                        //submit
                        $btnOK = new button("BtnOk", "Αποθήκευση"); 
                        echo "<div class=\"col-4\"></div><div class=\"col-8\">";
                        $btnOK->get_button_simple();

                        $btnCloseUpdate = new button("button", "Κλείσιμο και ενημέρωση", "close-update");
                        echo "&nbsp;";
                        $btnCloseUpdate->get_button_simple();
						
						echo "&nbsp;";
						$host = app::$sitehost;
						echo "<a target=\"_blank\" class=\"button\" href=\"".$host."category/$id\">Preview Category Page</a>";
						
						
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
                <a onclick="$('#cover').hide();$('#cover-msg').html(''); " class="button" id="hide-cover" style="color:black;">OK</a>
            </div>
        </div>
    </body>
</html>