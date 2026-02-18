<?php

require_once('abeautifulsite/SimpleImage.php');

$featuredImage = "http://karcher-marine.com/wp/wp-content/uploads/Product%20images-videos%20600x600/FEATURED%20IMAGE/UNIQUE/Karcher-Marine-Wet-and-Dry-vacuum-cleaner%20-Tact-class-NT-75-2-Tact%C2%B2-Me-16672880.jpg";

try {
    $img = new abeautifulsite\SimpleImage($featuredImage);
    $img->best_fit(600, 300)->save('fbimg/'.$id.'.gif');
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>