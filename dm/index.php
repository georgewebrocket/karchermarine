<?php
require_once('php/session.php');
require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');


$tb = conn1::$tprefix;

$path = ltrim($_SERVER['REQUEST_URI'], '/');    // Trim leading slash(es)
$elements = explode('/', $path);                // Split path on slashes

$url1 = ""; $url2 = ""; $url3 = "";
if (count($elements)>=1) {$url1 = urldecode($elements[0]);} ///
if (count($elements)>=2) {$url2 = urldecode($elements[1]);} ///
if (count($elements)>=3) {$url3 = urldecode($elements[2]);} ///

$slug = $url1; //////////////////////
//$curpage = $url2;

switch($slug) {    
	case '':
		include 'home.php';
		exit();	
        break;
	
	case 'category':
		$id = $url2;
		include 'category.php';
		exit();	
        break;
		
	case 'product':
		$id = $url2;
		include 'product.php';
		exit();	
        break;
	 	
	case 'search':
		include 'search.php';
		exit();	
        break;
		
	case 'rfq':
		include 'rfq.php';
		exit();	
        break;
	
	default:
		//echo "hi";
		break;
}


$sql = "SELECT * FROM ".$tb."posts WHERE (post_type='post' OR post_type='page') AND post_name = '$slug' AND post_status='publish'";
//echo $sql;
$rs = $db1->getRS($sql);
if ($rs!==FALSE) {
	$id = $rs[0]['ID'];
	include 'page.php';
	exit();
}
else {
	/*$sql = "SELECT * FROM ".$tb."terms WHERE slug = '$slug' ";
	$rs = $db1->getRS($sql);
	if ($rs!==FALSE) {
		$id = $rs[0]['term_id'];
		if ($id==700) {
		include 'category.php';
		}
		else {
		include 'category2.php';
		}
		exit();
	}	*/
}


?>