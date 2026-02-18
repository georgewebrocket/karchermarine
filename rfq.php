<?php
/*
ini_set('display_errors',1); 
error_reporting(E_ALL);*/

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/dataobjects.php');
require_once('php/content.php');

//$id = $_GET['id'];

$post = new wp_post($db1, 232, conn1::$tprefix);
$title = $post->get_custom_field('H1');
$shortDescription = $post->get_custom_field('SUBTITLE');
$featuredImage = $post->get_feature_image();
$content = $post->get_post_content();
$content = content::richcontent($content);
$breadcrumbs_str = content::breadcrumbs('wp', $post);

/*$breadcrumbs_str = '<ul>';
$breadcrumbs_str .= '<li><a href="home.php">Home</a>></li>';
$breadcrumbs_str .= '<li class="current-product">RFQ</li>';;
$breadcrumbs_str .= '</ul>';*/


$rfqItems = array_filter($_SESSION['karcher_rfq']);
$rfqItemIds = '';
for ($i=0;$i<count($rfqItems);$i++) {
	//echo $rfqItems[$i][0]."<br/>";
	$rfqItemIds .= $rfqItems[$i][0].", ";
	$rfqItemIds = substr($rfqItemIds, 0, strlen($rfqItemIds)-1); 
}
$sql = "SELECT * FROM app_products WHERE id IN ($rfqItemIds)";
//echo $sql;
$items = $db1->getRS($sql);


$customer_company = isset($_COOKIE['karchermarine-company'])? 
	$_COOKIE['karchermarine-company'] : '';
	
$customer_vessel = isset($_COOKIE['karchermarine-vessel'])? 
	$_COOKIE['karchermarine-vessel'] : '';
$customer_imo = isset($_COOKIE['karchermarine-imo'])? 
	$_COOKIE['karchermarine-imo'] : '';
$customer_port = isset($_COOKIE['karchermarine-port'])? 
	$_COOKIE['karchermarine-port'] : '';
$customer_eta = isset($_COOKIE['karchermarine-eta'])? 
	$_COOKIE['karchermarine-eta'] : '';
	
	
$customer_contact = isset($_COOKIE['karchermarine-contact'])? 
	$_COOKIE['karchermarine-contact'] : '';
$customer_email = isset($_COOKIE['karchermarine-email'])? 
	$_COOKIE['karchermarine-email'] : '';
$customer_phone = isset($_COOKIE['karchermarine-phone'])? 
	$_COOKIE['karchermarine-phone'] : '';
$customer_address = isset($_COOKIE['karchermarine-address'])? 
	$_COOKIE['karchermarine-address'] : '';
$customer_message = isset($_COOKIE['karchermarine-message'])? 
	$_COOKIE['karchermarine-message'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title><?php echo $post->get_custom_field('SEO-PAGE-TITLE'); ?></title>
    <meta name="Description" content="<?php echo $post->get_custom_field('SEO-PAGE-DESCRIPTION'); ?>" />
	<meta name="Keywords" content="<?php echo $post->get_custom_field('SEO-PAGE-KEYWORDS'); ?>" />
    
    <meta property="og:title" content="<?php echo $post->get_custom_field('SEO-PAGE-TITLE'); ?>" />
    <meta property="og:image" content="<?php echo $post->get_feature_image(); ?>" />
	<meta property="og:image:url" content="<?php echo $post->get_feature_image(); ?>" />
	<meta property="og:description" content="<?php echo $post->get_custom_field('SEO-PAGE-DESCRIPTION'); ?>" />
    
	<?php include 'head.php'; ?>
    
    <script src='https://www.google.com/recaptcha/api.js'></script>
    
    <style></style>
    
    <script>
    
    
    
    </script>
    
    
</head>

<body>
    <?php include "blocks/header.php"; ?>
        
    <div class="main">
        <div id="ribbon">
            <div class="wraper">
                <div id="breadcrumbs"><?php echo $breadcrumbs_str; ?></div>
                <h1>RFQ list of items</h1>
                &nbsp;
            </div>
        </div>
        <div class="wraper">
            <div class="post-mar-bottom4">
                
                <div class="post-content post-mar-bottom5">
                    
                    
				<?php
				
				$rfqItems = $_SESSION['karcher_rfq'];
				for ($i=0;$i<count($rfqItems);$i++) {
					if ($rfqItems[$i][1]=='') {
						unset($rfqItems[$i]);	
					}
				}
				$rfqListCount = count($rfqItems);	
                
                if ($rfqListCount>0) {
					echo "<div id=\"items-container\">";
					for ($i=0;$i<count($rfqItems);$i++) {
						if ($rfqItems[$i][0]!='') {
							$item = new app_products($db1, $rfqItems[$i][0], $items);
							$itemid = $item->get_id();
							echo "<div data-itemid=\"$itemid\" class=\"rfq-list-item\">";
							echo "<div class=\"col-2 col-sm-3\"><img class=\"rfq-image\" src=\"".$item->photo()."\"/></div>";
							$itemcode = MyUtils::str_code_replace($item->item_code(), array(".","-","."), array(array(0,1),array(1,3),array(4,3),array(7,1)));
							echo "<div class=\"col-8 col-sm-7\"><a href=\"product/$itemid\"><strong>$itemcode - ".$item->title()."</strong></a> <br/>". $item->short_description() ."</div>"; 
							echo "<div class=\"col-2\">Quantity <br/><input class=\"rfq-quantity\" type=\"number\" value=\"".$rfqItems[$i][1]."\" /><span class=\"fa fa-trash-o del-rfq-item\" data-itemid=\"$itemid\" title=\"Delete item\"></span></div>";
							echo "<div style=\"clear:both; height:10px; border-bottom:1px solid rgb(200,200,200)\"></div>";
							echo "<div style=\"clear:both; height:10px;\"></div></div>";
						}
					}
                //}
                
                
                ?>
                
                <div style="clear:both; height:20px;"></div> 
                
                <div style="text-align:center; padding-bottom:40px"> 
                <span id="rfq-update" class="button">UPDATE QUANTITIES</span> &nbsp;
                <span id="rfq-delete-all" class="button">DELETE ALL ITEMS</span>
                </div>
                
                <h2>CONTACT INFO</h2>
                
                <div id="rfq-customer-data" style="clear:both; width:100%; padding-top:10px; padding-bottom:40px;">
                	
                    <div class="col-6 col-sm-12">
                        <input id="t_company" type="text" placeholder="Management/Ship Owning Company Name *" value="<?php echo $customer_company; ?>">                    
                        <input id="t_vessel" type="text" placeholder="Vessel Name/NB Vessel Hull Number *" value="<?php echo $customer_vessel; ?>">                    
                        <input id="t_imo" type="text" placeholder="IMO Number *" value="<?php echo $customer_imo; ?>">                    
                        <input id="t_port" type="text" placeholder="Next Port of Call" value="<?php echo $customer_port; ?>">                    
                        <input id="t_eta" type="text" placeholder="ETA" value="<?php echo $customer_eta; ?>">
                        
                    </div>
                    <div class="col-6 col-sm-12">                                      
                        <input id="t_contact" type="text" placeholder="CONTACT NAME *" value="<?php echo $customer_contact; ?>">
                        <input id="t_email" type="text" placeholder="EMAIL *" value="<?php echo $customer_email; ?>">
                        <input id="t_phone" type="text" placeholder="PHONE *" value="<?php echo $customer_phone; ?>">
                        <input style="height:80px" id="t_address" type="text" placeholder="ADDRESS" value="<?php echo $customer_address; ?>">
                                               
                        
                    </div>
                    
                    
                    <div class="col-12">
                    	<textarea id="t_message" placeholder="YOUR MESSAGE" rows="5"><?php echo $customer_message; ?></textarea>
                        
                        <div class="g-recaptcha" data-sitekey="6LcOfhsTAAAAAKGehwFfEX1YtEA46FxYDPQYPaGu"></div>
                        
                    </div>
                    
                    
                    
                    <div style="clear:both; padding:20px 0px">
                    <div>* mandatory fields</div>
                    </div>
                
                </div>
                
                <div style="text-align:center"> 
                <span id="rfq-send" class="button">SEND RFQ</span>
                <input id="rfq-send-copy" type="checkbox"> SEND ME A COPY
                </div>
                
                <?php
				}
				else {
					echo "<h2 style=\"margin-bottom:300px\">THERE ARE NO ITEMS IN THE LIST</h2>";	
				}
				echo "</div>";
				?>    
                <h2 id="no-items" style="margin-bottom:300px; display:none">THERE ARE NO ITEMS IN THE LIST</h2>    
                </div>
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
</body>
</html>

