<?php
//ini_set('display_errors',1); 
//error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
//require_once('php/session.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

if (isset($_GET['id'])) { $id = $_GET['id']; }

//update product click counter
$db1->execSQL("UPDATE app_products SET clicks_counter = IFNULL(clicks_counter,0) + 1 WHERE id = ".$id);

$product = new app_products($db1, $id);

$title = $product->title();
$item_code = "Order number: ".MyUtils::str_code_replace($product->item_code(), array(".","-","."), array(array(0,1),array(1,3),array(4,3),array(7,1)));
$category_id = $product->category_id();
$shortdescr = $product->short_description();
$description = $product->description();
$features_benefits = $product->features_benefits();
$featuredImage = $product->photo();
$extra_images = $product->extra_images();
$arr_extra_images = explode("====", $extra_images);
//create array for slide show
foreach ($arr_extra_images as $key => $slide) {
    $arr_extra_images[$key] = explode("==", $slide);
}
$downloads = $product->downloads();
$related_product_ids = MyUtils::get_codes($product->related_product_ids());
$accessories_ids = MyUtils::get_codes($product->accessories_ids());
$cleaning_agents_ids = MyUtils::get_codes($product->cleaning_agents_ids());
$compatible_machines_ids = $product->compatible_machines_ids();
$specifications = func::vlookup('id', "app_product_attributes", "product_id = ".$id, $db1);
$content = content::richcontent(product_content($db1,$id,$description,
        $features_benefits,$specifications,$downloads,$accessories_ids,$cleaning_agents_ids,$related_product_ids,$product->item_code()), $id);

/*============ begin breadcrumbs ================*/
$sql = "SELECT id, title AS name, parent_id FROM  app_categories";

$cat_view = new categories_view($db1,$sql,0,0);
$breadcrumbs = $cat_view->display_parent_nodes($category_id, TRUE);
$breadcrumbs_str = '';
$breadcrumbs_str = '<ul>';
$breadcrumbs_str .= '<li><a href="'.app::$host.'">Home</a>></li>';
foreach ($breadcrumbs as $key => $value) {
    $breadcrumbs_str .= '<li><a href="category/'.$breadcrumbs[$key]['id'].'">'.$breadcrumbs[$key]['name'].'</a>></li>';
}
$breadcrumbs_str .= '<li class="current-product">'.$title.'</li>';;
$breadcrumbs_str .= '</ul>';
/*============ end breadcrumbs ================*/

function product_content($conn,$id = NULL,$description="",
        $features_benefits="",$specifications="",$downloads="",$accessories_ids = "",
        $cleaning_agents_ids = "",$related_product_ids="",$product_code=""){
    $tabs = array();
    if($description !=""){
        $tabs[] = "Description==Description[LINE]==".$description;
    }
    
    if($features_benefits !=""){
        $tabs[] = "Features and benefits==Features and benefits[LINE]==".$features_benefits;
    }
    
    if($specifications !=""){
        $tabs[] = "Specifications==Specifications[LINE]==".Specifications($conn, $id);
    }
    
    if($downloads !=""){
        $tabs[] = "Downloads==Downloads[LINE]==".pdf_downloads($downloads);
    }
    
    if($accessories_ids !=""){
        $tabs[] = "Accessories==Accessories[LINE]==<div class=\"container-accessories\">".
                file_get_contents(app::$host.'products-inc.php?PRODUCT_CODES='.$accessories_ids.'&EXTRA_PRODUCTS=extra&PRODUCT-INC=accessories').
                "</div>";
        
    }
    if($cleaning_agents_ids !=""){
        $tabs[] = "Cleaning Agents==Cleaning Agents[LINE]==<div class=\"container-cleaning-agents\">".
                file_get_contents(app::$host.'products-inc.php?PRODUCT_CODES='.$cleaning_agents_ids.'&EXTRA_PRODUCTS=extra&PRODUCT-INC=cleaning_agents').
                "</div>";
        
    }
    if($related_product_ids !=""){
        $tabs[] = "Related Products==Related Products[LINE]==<div class=\"container-related-product\">".
                file_get_contents(app::$host.'products-inc.php?PRODUCT_CODES='.$related_product_ids.'&EXTRA_PRODUCTS=extra&PRODUCT-INC=related_product').
                "</div>";
        
    }
    $compatible_machines_ids = compatible_machines($conn,$product_code);
    if($compatible_machines_ids !=""){
        $tabs[] = "Compatible Machines==Compatible Machines[LINE]==".$compatible_machines_ids;
        
    }
    return "[TABS]".implode("====", $tabs)."[/TABS]";
}

function Specifications($conn,$id = NULL){
    //get Specifications data
    $str_technical_data = "<div class='col-6'><h2>Technical data</h2>";
    $str_equipment = "<div class='col-6'><h2>Equipment</h2>";    
    
    $sql="SELECT APA.id, APA.value, APA.attr_order, A.title, A.attr_type_id, A.attr_category_id "
        . "FROM app_product_attributes AS APA "
        ."INNER JOIN app_attributes AS A ON APA.attribute_id = A.id "
        . "WHERE APA.product_id = ".$id."  AND A.attr_category_id = 1 ORDER BY APA.attr_order";
    $technical_data = $conn->getRS($sql);
    if($technical_data){
        $str_technical_data .= "<table>";
        foreach ($technical_data AS $key => $value){
            $str_technical_data .= "<tr><td>".$value['title']."</td><td>".$value['value']."</td></tr>";
        }
        $str_technical_data .= "</table>";
    }
    $str_technical_data .= "</div>";
    
    
    

    $sql="SELECT APA.id, APA.value, APA.attr_order, A.title, A.attr_type_id, A.attr_category_id "
        . "FROM app_product_attributes AS APA "
        ."INNER JOIN app_attributes AS A ON APA.attribute_id = A.id "
        . "WHERE APA.product_id = ".$id."  AND A.attr_category_id = 2 ORDER BY APA.attr_order";
    $equipment = $conn->getRS($sql);
    
    //get standard accessories
    $sa_codes = get_standard_accessories($conn, $id);
    
    if(is_array($equipment) || $sa_codes != ""){
        $str_equipment .= "<ul>";
        
        //inset standart accesories codes into equipment
        if($sa_codes != ""){
            foreach ($sa_codes as $key => $sa_code) {
                $str_equipment .= "<li><a href=\"product/".$sa_code['id']."\">".$sa_code['title']."</a></li>";
            }
        }
        
        if(is_array($equipment)){
            foreach ($equipment AS $key => $value){
                if($value['value'] != ""){
                    $str_equipment .= "<li>".$value['title'].", ".$value['value']."</li>";                
                }else{
                    $str_equipment .= "<li>".$value['title']."</li>";
                }            
            }
        }
        $str_equipment .= "</ul>";
    } 
    $str_equipment .= "</div>";
    return "<div id='specifications'><div class='col-12'>".$str_technical_data.$str_equipment."</div><div style=\"clear:both;\"></div></div>";
}

function get_standard_accessories($conn, $id){
    $result = "";
    $RS_standard_accessories_codes = new app_products($conn, $id);
    
    $standard_accessories_codes = MyUtils::get_codes($RS_standard_accessories_codes->standard_accessories_ids());
    
    
    if($standard_accessories_codes){
        $result = $conn->getRS("SELECT id,title FROM app_products WHERE item_code in(".$standard_accessories_codes.")");
    }
    return $result;
}

function compatible_machines($conn, $product_code){
    //get Accessories data
    $result = "";
    $sql = "SELECT * FROM app_products WHERE accessories_ids like '%[".$product_code."]%' OR cleaning_agents_ids like '%[".$product_code."]%'";
    $rs_compatible_machines = $conn->getRS($sql);
    if($rs_compatible_machines){
        $result = "<div class=\"compatible-machines column-comp\">";
        if($rs_compatible_machines){
            $arCount = count($rs_compatible_machines);
            foreach ($rs_compatible_machines as $key => $compatible_machine) {
                $result .= "<div class=\"\"><i class=\"fa fa-angle-right fa-lg\"></i><a href=\"".
                        app::$host."product/".$compatible_machine['id']."\">".$compatible_machine['title']."</a></div>";
            }
        }       
        $result .="</div>";
    }
    return $result;
}

function pdf_downloads($str){
    //get Downloads data
    $result = "<div class=\"pdf-downloads\">";
        $arr_downloads = explode("====", $str);
        //$result .= "<div class=\"col-12\">";
        
        $div = -1;
        for ($i=0;$i<count($arr_downloads);$i++) { 
        $div = $i;
        if (fmod($i,6) == 0) {$result .= "<div class=\"col-12\">";}

        //foreach ($arr_downloads as $key => $download_parts) {
            $part = explode("==", $arr_downloads[$i]);
            $result .= "<div class=\"col-2 col-md-3 col-sm-6 \">";
            $result .= "<div class=\"pdf-download-part\">".$part[0]."</div>";
            $result .= "<div class=\"pdf-download-part\"><a href=\"".$part[2]."\" target=\"_blank\"><img src=\"".$part[1]."\"/></a></div>";
            $result .= "<div class=\"pdf-download-part\"><a class=\"button\" href=\"".$part[2].
                    "\" target=\"_blank\"><i class=\"fa fa-arrow-circle-o-down fa-lg\"></i>DOWNLOAD</a></div>";
            $result .= "<div class=\"pdf-download-part\">".$part[3]."</div>";
            $result .= "</div>";
            if (fmod($i,6) == 5) {$result .=  '</div>';}
        }
        if (fmod($div,6) <> 5 && $div <> -1){$result .=  '</div>';}
        //$result .= "</div>";
    $result .="</div><div style=\"clear:both;\"></div>";
    return $result;
}

$normdescr = func::normURL($product->title());

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    
    <?php include 'head.php'; ?>
    
    <link rel="canonical" href="<?php echo app::$host."product/$id/$normdescr"; ?>" />
    
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <link rel="stylesheet"  href="css/lightslider.css"/>
    <script src="js/lightslider.js"></script> 
    <script>
        $(document).ready(function() {
            $('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                thumbItem:9,
                slideMargin: 0, 
                verticalHeight:295,
                slideEndAnimation: false,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }
            });
	});
    </script>
    
</head>

<body>

	<?php include "blocks/header.php"; ?>
    
    <div class="main">
        <div id="ribbon">
            <div class="wraper">
                <div class="col-9">
                    <div id="breadcrumbs">
                        <?php echo $breadcrumbs_str; ?>
                    </div>
                    <h1><?php echo $title; ?></h1>
                    <?php echo $shortdescr; ?>
                </div>
                <div class="col-3"></div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="wraper">
            <div class="col-12">
                <div >
                    <div class="col-8 col-sm-12">
                        <?php if ($featuredImage!='') { ?>
                        
<!--                        <div class="product-image" >
                            <img style="margin: 0 auto;height:474px;display: block;" src="<?php //echo $featuredImage; ?>" alt="<?php //echo $title; ?>"/>
                        </div>    -->
                        <div id="product-ssh" style="border: 3px solid #f8f8f8;border-right: none;">
                            <div >
                                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                    <li data-thumb="<?php echo $featuredImage; ?>"> 
                                        <div class="product-img-slide"><img src="<?php echo $featuredImage; ?>" /></div>
                                    </li>
                                    
                                    <?php foreach($arr_extra_images as $key => $product_slides){ 
                                        if(count($product_slides) == 3){  
                                        ?>                                    
                                        <li data-thumb="<?php echo $product_slides[1]; ?>">
                                            <?php if(trim($product_slides[0]) == "IMAGE") {?>
                                            <div class="product-img-slide"><img src="<?php echo $product_slides[2]; ?>"/></div>
                                            <?php } ?>
                                            <?php if(trim($product_slides[0]) == "VIDEO") {?>
                                            <!--<div class="product-img-slide"><iframe src="http://www.youtube.com/embed/<?php //echo $product_slides[2]; ?>?autoplay=1"></iframe></div>-->
                                            <div class="product-img-slide"><iframe src="http://www.youtube.com/embed/<?php echo $product_slides[2]; ?>" allowfullscreen></iframe></div>
                                            <?php } ?>
                                        </li>
                                    <?php    }
                                     } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?> 
                    </div>
                    <div class="col-4 col-sm-12">
                        <div style="background-color:#f8f8f8;">
                            <div class="product-box">
                                <?php echo  $item_code; ?><br/><br/>                                
                                <span id="item-rfq" data-productid="<?php echo $id; ?>" class="button-yellow" style="padding:15px; border-radius:20px">RFQ</span>
                            	QUANTITY: <input type="number" id="rfq-quantity" class="rfq-quantity" min="0" max="100" value="1"><br><br><br>
								 <i class="fa fa-angle-right fa-lg"></i> &nbsp; <a href="rfq">RFQ list</a>   
                            </div>
                            
                            <div class="product-box">
                                
                                <div style="padding-bottom:20px">
                                	<div style="float:left">
                                    <?php
									$checked = '';
									if(in_array($id, $_SESSION['COMPARE_PRODUCT_IDS'])){
										$checked = "checked=\"checked\"";	
									}
									?>
                                    <input id="chk-compare" style="width:30px; height:30px;" type="checkbox" <?php echo $checked; ?> value="<?php echo $id; ?>" ></div> 
                                    <div style="float:left; padding-top:12px"> &nbsp; COMPARE</div>
                                    <div style="clear:both"></div>
                                </div>
                                
                                <!--<div id="item-compare" data-productid="<?php echo $id; ?>" class="button btn">COMPARE</div><br/>-->
                                <i class="fa fa-angle-right fa-lg"></i><a id="cpa<?php echo $id ?>" class="product-addcompare" href="product-comparison.php">Compare list</a>
                            </div>
                            
                            <div class="product-box col-sm-0" style="height:241px"></div>
                            
                            
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            
            <div class="post-mar-bottom4">   
                <div class="post-content post-mar-bottom5">
                    <div class="product-content">
                        <?php 
                            echo $content;
                        ?>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col-12">
                <hr style="margin-top: 60px;margin-bottom: 40px;border: 0;border-top: 1px solid #eeeeee;"/>                   
            </div>
            <div style="clear: both;"></div>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div style="clear: both;"></div>
    <?php include "blocks/footer.php"; ?>

</body>
</html>