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

$cat_id = 0;$sort_id = '';$item_code = '';$title='';$querysort='';$strquery='';
$curpage = "";
$query = array();$arrrequest = array();
$strrequest = "";
$rs_sort = array(
    0 => array('id' => 'ORDER BY id ASC','description' => 'Ημερομηνία Αύξουσα'),
    1 => array('id' => 'ORDER BY id DESC','description' => 'Ημερομηνία Φθίνουσα'),
    2 => array('id' => 'ORDER BY title ASC','description' => 'Τίτλος Αύξουσα'),
    3 => array('id' => 'ORDER BY title DESC','description' => 'Τίτλος Φθίνουσα'),
	4 => array('id' => 'ORDER BY clicks_counter DESC','description' => 'Clicks Φθίνουσα')
);

//search with title
if(isset($_POST['t_title'])){
    if ($_POST['t_title']!='') {
        $title = $_POST['t_title'];
        $query[] = "title like '%".$title."%'";
        $arrrequest[] = "t_title=".$title;
    }
}
if(isset($_GET['t_title'])){
    if ($_GET['t_title']!='') {
        $title = $_GET['t_title'];
        $query[] = "title like '%".$title."%'";
        $arrrequest[] = "t_title=".$title;
    }
}

//search with item_code
if(isset($_POST['t_item_code'])){
    if ($_POST['t_item_code']!='') {
        $item_code = $_POST['t_item_code'];
        $query[] = "item_code like '%".$item_code."%'";
    }
}
if(isset($_GET['t_item_code'])){
    if ($_GET['t_item_code']!='') {
        $item_code = $_GET['t_item_code'];
        $query[] = "item_code like '%".$item_code."%'";
    }
}

//search with category_id
if(isset($_POST['c_category'])){
    if ($_POST['c_category']!=0) {
        $cat_id = $_POST['c_category'];
        $query[] = "category_id like '%[".$cat_id."]%'";
        $arrrequest[] = "c_category=".$cat_id;
    }
}
if(isset($_GET['c_category'])){
    if ($_GET['c_category']!=0) {
        $cat_id = $_GET['c_category'];
        $query[] = "category_id like '%[".$cat_id."]%'"; 
        $arrrequest[] = "c_category=".$cat_id;
    }
}

//sort
if(isset($_POST['c_sort'])){
    if ($_POST['c_sort']!= "" && $_POST['c_sort']!= "0") {
        $sort_id = $_POST['c_sort'];
        $querysort = " ".$sort_id;        
        $arrrequest[] = "c_sort=".$sort_id;
    }
}
if(isset($_GET['c_sort'])){
    if ($_GET['c_sort']!= "" && $_GET['c_sort']!= "0") {
        $sort_id = $_GET['c_sort'];
        $querysort = " ".$sort_id;
        $arrrequest[] = "c_sort=".$sort_id;
    }
}

if(count($query)>0){$strquery = " WHERE ".implode(" AND ", $query);}
$sql = "SELECT * FROM app_products ".$strquery.$querysort;

if (isset($_GET['page'])) {$curpage = $_GET['page'];}else{$curpage = 0;}

if(count($arrrequest)>0){$strrequest = "?".implode("&", $arrrequest)."&page=";}else{$strrequest = "?page=";}
$link = "products.php".$strrequest;

$nrOfRows = 20;
//echo $category->get_sql();
$rspage = new RS_PAGE($db1, $sql, "", "", 
	$nrOfRows, $curpage, NULL, $link);
$rs = $rspage->getRS();

for ($i=0;$i<count($rs);$i++) {
	if ($rs[$i]['active']==1) {
		$rs[$i]['active'] = "<span class=\"fa fa-check\"></span>";
	}
	else {
		$rs[$i]['active'] = "<span class=\"fa fa-ban\"></span>";
	}
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
    <!-- Add jQuery library -->
    <link href="fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" media="all"/>
        
    
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/code.js"></script>
    <script>
    $(document).ready(function() {	
            $("a.fancybox").fancybox({'type' : 'iframe', 'width' : 1000, 'height' : 1000 });	
    });

    </script>       
    <style>
        #gridProducts td {
            vertical-align: top;
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
                <div class="col-12"><h2>Προϊόντα</h2></div>
                <div class="col-12">
                    <form class="form-search" action="products.php?" method="POST">
                        <h2>Αναζήτηση</h2>
                        <div class="col-12 col-md-6">
                            <div class="col-4">
                                <?php
                                    $t_item_code = new textbox("t_item_code", "ΚΩΔΙΚΟΣ ΠΡΟΙΟΝΤΟΣ", $item_code, "");
                                    $t_item_code->get_Textbox();
                                ?>
                            </div>
                            <div class="col-4">
                                <?php
                                //category
                                $c_category = new comboBox("c_category", $db1, "", 
                                        "id","description",
                                        $cat_id,
                                        "ΚΑΤΗΓΟΡΙΑ");
                                $c_category->set_rs($rs_categories);
                                $c_category->get_comboBox();
                                ?>
                            </div>
                             <div class="col-4"></div> 
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="col-4">
                                <?php
                                    $t_title = new autocomplete("t_title", "app_products", "title", $db1);
                                    $t_title->set_label('ΤΙΤΛΟΣ');
                                    $t_title->set_text($title);
                                    $t_title->getAutocomplete();
                                ?>
                            </div>                                
                            <div class="col-4">
                                <?php
                                    //sort
                                    $c_sort = new comboBox("c_sort", $db1, "", 
                                            "id","description",
                                            $sort_id,
                                            "ΤΑΞΙΝΟΜΗΣΗ");
                                    $c_sort->set_rs($rs_sort);
                                    $c_sort->get_comboBox();
                                ?>

                            </div>                            
                            <div class="col-4">
                                <input id="BtnOk" name="BtnOk" value="Αναζήτηση" type="submit"/>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </form>
                </div>
                <div class="col-12"><a class="button fancybox" href="editproduct.php?id=0">Προσθήκη</a></div>
                <div class="col-12"><div class="sep-h-10"> </div></div>
                <div class="col-12">
                    <div class="grid-container" style="padding: 10px 0px;">
                        <?php
                        if($rs){
                            foreach ($rs as $key => $value) {
                                if($rs[$key]['photo'] !=''){
                                    $rs[$key]['photo'] = '<img style="width:50px; height:50px;" src="'.$rs[$key]['photo'].
                                            '" alt="'.$rs[$key]['title'].'"/>';
                                }
                                
                                //$rs[$key]['category_id'] = func::vlookup("title", "app_categories", "id = ".$rs[$key]['category_id'], $db1);
                                $temp_sql = "SELECT title FROM app_categories WHERE id IN (".str_replace(array("[","]"), "", $rs[$key]['category_id']). ")";
                                //echo $temp_sql;
                                $rs_temp_cats = $db1->getRS($temp_sql);
                                if($rs_temp_cats){
                                    $rs[$key]['category_id'] = "<ul>";
                                    foreach ($rs_temp_cats as $temp_key => $rs_temp_cat) {
                                        $rs[$key]['category_id'] .= "<li>".$rs_temp_cat['title']."</li>";
                                    }
                                    $rs[$key]['category_id'] .= "</ul>";
                                }
//                                $rs[$key]['category_id'] = func::vlookup("title", "app_categories", 
//                                        "id IN (".str_replace(array("[","]"), "", $rs[$key]['category_id']). ")", $db1);
                            }
                            $gridProducts = new datagrid("gridProducts", $db1, $sql, 
                                array("id","item_code","title","category_id","photo", "active", "clicks_counter"), 
                                array("#","Κωδικός προϊόντος","Τίτλος","Κατηγορία","Φωτογραφία", "Active", "Clicks"), 
                                "l=gr", 0, TRUE, "editproduct.php", "Επεξεργασία", TRUE, "delproduct.php", "Διαγραφή", "id", "GR");
                            $gridProducts->set_rs($rs);
                            $gridProducts->set_colWidths(array("30","50","250","100","50","30","30", "30","30"));
                            $gridProducts->get_datagrid();
                        }
                        ?>
                    </div>
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
            <div class="clear"> </div>
        </div>
    </body>
</html>