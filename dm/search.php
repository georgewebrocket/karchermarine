<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/session.php');
require_once('php/content.php');
require_once('php/dataobjects.php');

/*$id = $_GET['id'];
$cat = new app_categories($db1, $id);

$title = $cat->title();
$shortdescr = $cat->short_description();
$content = $cat->description();
$content = content::richcontent($content, $id);
$featuredImage = $cat->photo();*/



?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    
    <?php include 'head.php'; ?>

</head>

<body>

	<?php include "blocks/header.php"; ?>
    
    <div class="main">
        <div id="ribbon">
            <div class="wraper">
                
                <h1>Search results</h1>
                
            </div>
        </div>
        <div class="wraper">
            <div class="post-mar-bottom4">                
                               
            <?php include "products-inc.php"; ?>    
                
            </div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>


</body>
</html>