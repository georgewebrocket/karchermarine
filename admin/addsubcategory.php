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


$refid = $_GET['id'];

$refcategories = new app_categories($db1, $refid);

echo "<h1><a href=\"editcategory.php?id=0&ParentId=".$refid."\">"."add-category-child"." (".$refcategories->title().".##) "."</a></h1><br/>";

if($refcategories->level() > 1){
    $parentCategory = func::vlookup("title","app_categories","id=".$refcategories->parent_id(),$db1);
    echo "<h1><a href=\"editcategory.php?id=0&ParentId=".$refcategories->parent_id()."\">"."add-category-same-level"." (".$parentCategory.".##) "."</a></h1><br/>";
}
else{
    echo "<h1><a href=\"editcategory.php?id=0&ParentId=".$refcategories->parent_id()."\">"."add-category-same-level"." (##) "."</a></h1><br/>";
}


?>