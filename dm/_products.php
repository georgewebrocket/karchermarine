<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/start.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$id = $_GET['id'];
$cat = new app_categories($db1, $id);


if ($cat->nodes()==1) { 
	$sql = "SELECT * FROM app_categories WHERE parent_id = $id";
	$rs2 = $db1->getRS($sql);
	
	switch (count($rs2)) {
		case 1:	case 2:
			$subCatClass = "col-6 col-sm-12"; break;
		case 3:	
			$subCatClass = "col-4 col-sm-12"; break;
		default:
			$subCatClass = "col-3 col-sm-12"; break;	
	}
	for ($i=0;$i<count($rs2);$i++) {
		$cat2 = new app_categories($db1, $rs2[$i]['id'], $rs2);
		echo '<div class="'.$subCatClass.' subcat2"><div>';
		echo '<a href="category/' .$cat2->get_id().'"><img src="' . $cat2->product_image() . 
			'" width="100%" height="auto" alt="' . $cat2->title() . '"/></a>' ;
		echo '<a href="category/' .$cat2->get_id().'"><h2>'.$cat2->title().'</h2></a>';
		echo "<div>".$cat2->short_description()."</div>";
		
		if ($cat2->nodes()==1) {
			$sql = "SELECT * FROM app_categories WHERE parent_id = " . 
				$cat2->get_id();
			$rs3 = $db1->getRS($sql);
			
			echo '<ul class="cat-list">';
			for ($k=0;$k<count($rs3);$k++) {
				$cat3 = new app_categories($db1, $rs3[$k]['id'], $rs3);
				echo '<li><span class="fa fa-angle-right"></span> &nbsp; <a href="category/' .$cat3->get_id().'">' . 
					$cat3->title() . "<a></li>";
			}
			echo "</ul>";
		}
		
		echo '</div></div>';
	}

 } else { 
 	//products
	$str = file_get_contents(app::$host.'products-inc.php?CATEGORY_ID='.$id);
	echo $str;
 
 } 
 
 echo '<div style="clear:both"></div>';
 
 ?>