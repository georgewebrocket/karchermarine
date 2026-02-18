<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once 'php/config.php';
require_once 'php/db.php';
require_once 'php/utils.php';
require_once 'php/wp.php';
require_once 'php/start.php';

$id = 1;
$page = new wp_post($db1, $id, conn1::$tprefix);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">

<title><?php echo $page->get_custom_field('PAGE-TITLE'); ?></title>
<meta name="Description" content="<?php echo $page->get_custom_field('PAGE-DESCRIPTION'); ?>" />
<meta name="Keywords" content="<?php echo $page->get_custom_field('PAGE-KEYWORDS'); ?>" />

<meta property="og:title" content="<?php echo $page->get_custom_field('PAGE-TITLE'); ?>" />
<meta property="og:image" content="<?php echo $page->get_feature_image(); ?>" />
<meta property="og:description" content="<?php echo $page->get_custom_field('PAGE-DESCRIPTION'); ?>" />

<?php include "head.php"; ?>

</head>

<body>

<?php include "blocks/header.php"; ?>

<div class="main">

<div style="height:500px"></div>

</div>


<?php include "blocks/footer.php"; ?>

</body>
</html>