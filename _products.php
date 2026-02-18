<?php

ini_set('display_errors',0); 
//error_reporting(E_ALL);

//echo $_SERVER['REQUEST_URI']."<br/>" ;

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/start.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

$id = $_GET['id'];
$cat = new app_categories2($db1, $id);
$curpage = $_GET['curpage'];
$sort = $_GET['sort'];
//echo "_products-curpage".$curpage;

if ($cat->nodes()==1) { 
	$sql = "SELECT * FROM app_categories WHERE parent_id = $id AND active=1";
	$rs2 = $db1->getRS($sql);
	
	if ($id==2) { //professional
		for ($i=0;$i<count($rs2);$i++) {
			$cat = new app_categories2($db1, $rs2[$i]['id'], $rs2);	
			$anchorTitle = $cat->title();	
			echo '<div class="col-3 col-sm-6">';
			echo '<a title="'.$anchorTitle.'" href="category/'. $cat->get_id().'/'.$cat->friendlyUrl().'">';
			echo '<div style="background-color:#fff; margin:5px; padding:10px; height:220px; overflow:hidden; text-align:center">';
			echo '<img src="'. $cat->product_image(). '" style="height:170px; width:auto"  alt=""/><br><h3 style="padding:20px 0px">'.$cat->title().'</h3></div></a></div>';		
		}		
	}
	else {	
		switch (count($rs2)) {
			case 1:	case 2:
				$subCatClass = "col-6 col-vs-12"; break;
			case 3:	
				$subCatClass = "col-4 col-sm-6 col-vs-12"; break;
			default:
				$subCatClass = "col-3 col-sm-6 col-vs-12"; break;	
		}
		for ($i=0;$i<count($rs2);$i++) {
			$cat2 = new app_categories2($db1, $rs2[$i]['id'], $rs2);
			$anchorTitle = $cat2->title();
			echo '<div class="'.$subCatClass.' subcat2"><div>';
			echo '<a title="'.$anchorTitle.'" href="category/' .$cat2->get_id().'/'.$cat2->friendlyUrl().'"><img src="' . $cat2->product_image() . 
				'" width="100%" height="auto" alt="' . $cat2->title() . '"/></a>' ;
			echo '<a title="'.$anchorTitle.'" href="category/' .$cat2->get_id().'/'.$cat2->friendlyUrl().'"><h2>'.$cat2->title().'</h2></a>';
			echo "<div>".$cat2->short_description()."</div>";
			
			if ($cat2->nodes()==1) {
				$sql = "SELECT * FROM app_categories WHERE parent_id = " . 
					$cat2->get_id() . " AND active=1";
				$rs3 = $db1->getRS($sql);
				
				echo '<ul class="cat-list">';
				for ($k=0;$k<count($rs3);$k++) {
					$cat3 = new app_categories2($db1, $rs3[$k]['id'], $rs3);
					$anchorTitle = $cat3->title();
					echo '<li><a title="'.$anchorTitle.'" href="category/' .$cat3->get_id().'/'.$cat3->friendlyUrl().'">' . 
						$cat3->title() . "<a></li>";
				}
				echo "</ul>";
			}
			
			echo '</div>';			
			echo '</div>';
			if ($i % 2 == 1) {
			echo '<div class="col-0 col-sm-12"><div style="clear:both"></div></div>';
			}
			if ($i % 4 == 3) {
			echo '<div class="col-12 col-sm-12"><div style="clear:both"></div></div>';
			}
		}
	}

 } else { 
 	//products
	$str = file_get_contents(app::$host.'products-inc.php?CATEGORY_ID='.$id. 
		'&CATDESCR=' . func::normURL($cat->title()) . '&page=' . $curpage . 
		"&SORT=" . $sort);
	//echo func::normURL($cat->title())."<br/>";
	echo $str;
 
 } 
 
 echo '<div style="clear:both"></div>';
 
 ?>