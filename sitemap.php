<?php

header('Content-type: application/xml');

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$sql = "SELECT * FROM app_categories WHERE active=1";
$rsCat = $db1->getRS($sql);

$sql2 = "SELECT * FROM app_products WHERE active=1";
$rsProducts = $db1->getRS($sql2);


$output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$output .= '<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';


echo $output;




?>

<url>
  <loc>http://www.karcher-marine.com/</loc>
  <changefreq>daily</changefreq>
</url>


<?php 
for($i = 0; $i < count($rsCat); $i++) { 
    $cat = new app_categories($db1, $rsCat[$i]['id'], $rsCat);
    $catTitle = $cat->title();
	$cat_seo_url = func::normURL($catTitle);    
    $catURL = "http://www.karcher-marine.com/category/".$cat->get_id()."/".$cat_seo_url;
    
?>
<url>
  <loc><?php echo $catURL; ?></loc>
  <changefreq>daily</changefreq>
</url>
<?php } ?>


<?php 
for($i = 0; $i < count($rsProducts); $i++) { 
    $product = new app_products($db1, $rsProducts[$i]['id'], $rsProducts);
    $product_seo_url = func::normURL($product->title());
    $productLink = "http://www.karcher-marine.com/product/".$product->get_id()."/$product_seo_url";
    
?>
<url>
  <loc><?php echo $productLink; ?></loc>
  <changefreq>daily</changefreq>
</url>
<?php } ?>



</urlset>