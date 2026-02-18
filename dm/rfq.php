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

$post = new wp_post($db1, $id, conn1::$tprefix);
$title = $post->get_custom_field('H1');
$shortDescription = $post->get_custom_field('SUBTITLE');
$featuredImage = $post->get_feature_image();
$content = $post->get_post_content();
$content = content::richcontent($content);
$breadcrumbs_str = content::breadcrumbs('wp', $post);


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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $post->get_custom_field('SEO-PAGE-TITLE'); ?></title>
	<meta name="Description" content="<?php echo $post->get_custom_field('SEO-PAGE-DESCRIPTION'); ?>" />
    
	<?php include 'head.php'; ?>
    
    <style></style>
    
    <script>
    
    
    
    </script>
    
    
</head>

<body>
    <?php include "blocks/header.php"; ?>
        
    <div class="main">
        <div id="ribbon">
            <div class="wraper">
                <!--<div id="breadcrumbs"></div>-->
                <h1>RFQ list of items</h1>
                &nbsp;
            </div>
        </div>
        <div class="wraper">
            <div class="post-mar-bottom4">
                
                <div class="post-content post-mar-bottom5">
                    
                    
				<?php
                
                if ($rfqItems) {
					for ($i=0;$i<count($rfqItems);$i++) {
						$item = new app_products($db1, $rfqItems[$i][0], $items);
						$itemid = $item->get_id();
						echo "<div data-itemid=\"$itemid\" class=\"rfq-list-item\">";
						echo "<div class=\"col-2\"><img class=\"rfq-image\" src=\"".$item->photo()."\"/></div>";
						$itemcode = MyUtils::str_code_replace($item->item_code(), array(".","-","."), array(array(0,1),array(1,3),array(4,3),array(7,1)));
						echo "<div class=\"col-8\"><strong>$itemcode - ".$item->title()."</strong> <br/>". $item->short_description() ."</div>"; 
						echo "<div class=\"col-1\">Quantity <br/><input class=\"rfq-quantity\" type=\"number\" value=\"".$rfqItems[$i][1]."\" /></div>";
						echo "<div style=\"clear:both; height:10px; border-bottom:1px solid rgb(200,200,200)\"></div>";
						echo "<div style=\"clear:both; height:10px;\"></div></div>";
					}
                }
                
                
                ?>
                
                <div style="clear:both; height:20px;"></div> 
                
                <span id="rfq-update" class="button">UPDATE QUANTITIES</span> &nbsp;
                
                <div id="rfq-customer-data" style="clear:both; width:100%; max-width:600px; padding-top:40px; padding-bottom:40px;">
                
                    <input id="t_company" type="text" placeholder="COMPANY NAME" value="<?php echo $customer_company; ?>">
                    <input id="t_contact" type="text" placeholder="CONTACT NAME" value="<?php echo $customer_company; ?>">
                    <input id="t_email" type="text" placeholder="EMAIL" value="<?php echo $customer_email; ?>">
                    <input id="t_phone" type="text" placeholder="PHONE" value="<?php echo $customer_phone; ?>">
                    <input id="t_address" type="text" placeholder="ADDRESS" value="<?php echo $customer_address; ?>">
                    <textarea id="t_message" placeholder="YOUR MESSAGE"><?php echo $customer_message; ?></textarea>
                
                </div>
                
                 
                <span id="rfq-send" class="button">SEND RFQ</span>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
</body>
</html>

