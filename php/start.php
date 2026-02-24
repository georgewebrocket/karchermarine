<?php

$db1 = new DB(conn1::$connstr, conn1::$username, conn1::$password);
//$base = "http://karcher-marine.com/";
$base = app::$host;

$cookiesEnabled = func::cookiesEnabled();

$seoTitle = "";
$featuredImage = "";
$seoDescription = "";
$shortdescr = "";
$description = "";
$fbimg = "";
$title = "";

register_shutdown_function(function () use ($db1) {
    if (isset($db1) && $db1 instanceof DB) {
        $db1->close();
    }
});