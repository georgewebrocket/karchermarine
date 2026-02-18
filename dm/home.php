<?php

/*ini_set('display_errors',1); 
error_reporting(E_ALL);*/

require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
//require_once('php/session.php');

$id = isset($_GET['id'])? $_GET['id']: 192;
$page = new wp_post($db1, $id, conn1::$tprefix);

$slides = explode("====", $page->get_custom_field('SLIDESHOW'));

//$banners_section_1 = explode("====", $page->get_custom_field('BANNER-SECTION-1'));
//$banners_section_2 = explode("====", $page->get_custom_field('BANNER-SECTION-2'));
//$banners_section_3 = explode("====", $page->get_custom_field('BANNER-SECTION-3'));
//$banners_section_4 = explode("====", $page->get_custom_field('BANNER-SECTION-4'));
//$banners_section_5 = explode("====", $page->get_custom_field('BANNER-SECTION-5'));

$banners_section = array();
for($sec=0;$sec<6;$sec++){
    $num_section = $sec+1;
    $str_banner_sec = 'BANNER-SECTION-'.$num_section;    
    if($page->get_custom_field($str_banner_sec) != ''){
        $banners_section[] = explode("====", $page->get_custom_field($str_banner_sec));
    }
}

$partners = explode("====", $page->get_custom_field('PARTNERS'));

$news = new wp_category($db1, 28, conn1::$tprefix, "post_date DESC");

//var_dump($news[0]);
$allnews = $news->get_cat_arr_posts();
$arrSlidesNews = array();
$i = 0;$k = -1;
foreach ($news->get_cat_arr_posts() as $key => $post) {
    
    $arrSlidesNews[$k][$i] = $post;
    if(fmod($i,3) == 0){$i = 0; $k++;}
    $i++;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>kaercher-marine</title>
    <?php include 'head.php'; ?>
    
    <style>
        
        
    </style>
    <script src="js/slide/bjqs-1.3.js"></script>
    <link type="text/css" rel="Stylesheet" href="css/bjqs.css" />

    <script>

    jQuery(document).ready(function($) {

        $('#home-ss').bjqs({
        animtype : 'slide',
        height : 456,
        width : 1260,
        animduration : 1000,
        animspeed : 4000,
        nexttext : '', // Text for 'next' button (can use HTML)
        prevtext : '', // Text for 'previous' button (can use HTML)
        responsive : true
        
        });
		
		var w = window.innerWidth;
		var newsWidth = 0;
		var newsHeight = 0;
		if (w>=1260) {
			newsWidth = 1260;
			newsHeight = 250;
		}
		if (w<1260 && w>750) {
			newsWidth = w;
			newsHeight = 400;
		}
		console.log('w='+w);
		
        
        $('#home-news').bjqs({
        animtype : 'slide',
        animduration : 1000,
        animspeed : 4000,
        height : newsHeight,
        width : newsWidth,
        showcontrols : false,
//        nexttext : '<span class="fa fa-chevron-circle-right fa-2x"></span>', // Text for 'next' button (can use HTML)
//        prevtext : '<span class="fa fa-chevron-circle-left fa-2x"></span>', // Text for 'previous' button (can use HTML)
        responsive : true,
        showmarkers : true, 
        centermarkers : true,
        automatic : false
        
        });
        
        $( ".card-overlay" ).mouseover(function() {
            $(this).css('opacity', '0.95');
        });
        
        $( ".card-overlay" ).mouseout(function() {
            $(this).css('opacity', '0');
        });
        
    });

    </script>
    
</head>

<body>
    <?php include "blocks/header.php"; ?>
        
    <div class="main">
        <div class="wraper">
            <div class="col-12">
                <div class="slideshow">        
                    <div id="home-ss">
                        <ul class="bjqs">
                            <?php for ($i=0;$i<count($slides);$i++) { ?>
                        <li>
                            <?php
                            $slide = func::clearHtml($slides[$i]);
                            $slide_parts = explode("==",$slide);
                            $slide_img = ""; $slide_title=""; $slide_link=""; $slide_title_color="";
                            if (count($slide_parts)>=1) {$slide_img = $slide_parts[0];}
                            if (count($slide_parts)>=2) {$slide_title = $slide_parts[1];}
                            if (count($slide_parts)>=3) {$slide_link = trim($slide_parts[2]);}
                            if (count($slide_parts)>=4) {$slide_title_color = trim($slide_parts[3]);}
                            if ($slide_link!="") {
                                echo '<a href="'.$slide_link.'">';                               
                                echo "<img src='".$slide_img."' alt='".$slide_title."' />";

                                if ($slide_title!="") {
                                    echo '<div class="slide-caption" style="color:'.$slide_title_color.';">'.$slide_title.'</div>';
                                    }
                                }
                                echo '</a>';
                                ?>

                        </li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h1 class="centered"><?php echo $page->get_custom_field('H1'); ?></h1>            
            </div>
            <div class="col-12">
                <div class="post-content home-post post-mar-bottom3"><div class="column"><?php echo str_replace("\r\n\r\n","</p>",$page->get_post_content()); ?></div></div>            
            </div>
            
			<div class="col-12"><div class="hr-row post-mar-bottom4"><hr/></div></div> 
            <?php foreach ($banners_section as $key => $value_banners_section) {  ?>
            <div class="col-12">
                <div class="banner-section">                
                    <?php for ($i=0;$i<count($value_banners_section);$i++) { 
                        $banner_sec_text_color = '';
                        $banner_section = func::clearHtml($value_banners_section[$i]);
                        $banner_sec_parts = explode("==",$banner_section);
                        $banner_sec_img = trim($banner_sec_parts[0]); 
                        $banner_sec_text1 = trim($banner_sec_parts[1]); 
                        $banner_sec_text2 = trim($banner_sec_parts[2]); 
                        $banner_sec_link = trim($banner_sec_parts[3]);
                        if (count($banner_sec_parts)>=5) {$banner_sec_text_color = trim($banner_sec_parts[4]);}
                            else{$banner_sec_text_color = 'BLACK';}
                        if (count($banner_sec_parts)>=6) {
                            if(trim($banner_sec_parts[5]) != ''){
                                $banner_sec_text_bottom = trim($banner_sec_parts[5]);
                            }else{
                                $banner_sec_text_bottom = 20;
                            }
                        }
                        if (count($banner_sec_parts)>=7) {$banner_sec_text_overlay = trim($banner_sec_parts[6]);}
                            else{$banner_sec_text_overlay = '';} 
                        $col_num = 12/count($value_banners_section);
                        echo '<div class="col-'.$col_num.' col-sm-12">';
                            echo '<div class="banner">';
                                echo '<a href="'.$banner_sec_link.'">';
                                    echo '<div class="banner-bg" >';
                                        echo '<img src="'.$banner_sec_img.'"/>';
                                        echo '<div class="banner-text" style="color:'.$banner_sec_text_color.';bottom: '
                                                .$banner_sec_text_bottom.'px;">';
                                            echo '<h2>'.$banner_sec_text1.'</h2>';
                                            echo '<p>'.$banner_sec_text2.'</p>';
                                        echo '</div>';
                                        if($banner_sec_text_overlay != ''){
                                        echo '<div class="card-overlay">';
                                            echo '<div class="card-text">'.$banner_sec_text_overlay.'</div>';
                                        echo '</div>';
                                        }
                                    echo '</div>';
                                echo '</a>';
                            echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-12"><div class="post-mar-bottom3"></div></div>
            <div class="col-12"><div class="hr-row post-mar-bottom4"><hr/></div></div>            
            <?php } ?>
			
			<div class="col-12">
                <div class="news" >
                    <a href="#"><h2 >NEWS</h2></a>
                    <div id="home-news" class="col-12 col-sm-0">
                        <ul class="bjqs">
                            <?php 
                                $arrSlidesNews = array_reverse($arrSlidesNews);
                                foreach ($arrSlidesNews as $arrSlidesNews3) {
                                    echo '<li>';
                                        echo '<div class="col-12">';
                                        foreach ($arrSlidesNews3 as $post) {
                                            echo '<div class="col-4">';  
                                                echo '<div class="slide-post" style="padding-right: 30px;">';
                                                    $date=date_create(str_replace("/","-",$post->get_post_date()));
                                                    echo '<p class="slide-news-date" style="color: #757575;">'.date_format($date,"d. F Y").'</p>';
                                                    echo '<h3 style="font-size: 16px; color:#2B2B2B; margin-bottom: 10px;"><a href="post.php?id='.$post->get_id().'">'.$post->get_custom_field('H1').'</a></h3>';
                                                    echo '<p class="post-content" style="font-size: 13px; color:#2B2B2B;">'.$post->get_post_excerpt().'</p>';
                                                    echo '<a href="post.php?id='.$post->get_id().'">More</a>';
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    echo '</li>';
                            }?> 
                        </ul>
                    </div>
                    
                    
                    <div class="col-0 col-sm-12">
                    	<?php 
						foreach ($allnews as $allnew) { 
							echo '<h3 style="font-size: 16px; color:#2B2B2B; margin-bottom: 10px;"><a href="post.php?id='.$allnew->get_id().'">'.$allnew->get_custom_field('H1').'</a></h3>';
							echo '<p class="post-content" style="font-size: 13px; color:#2B2B2B;">'.$allnew->get_post_excerpt().'</p>';
						
						} ?>
                    
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-12"><div class="hr-row post-mar-bottom4"><hr/></div></div>
            <div class="col-12">    
                <div class="partners">
                    <!--<div class="col-12">-->
                        <?php 
                            $div = -1;
                            for ($i=0;$i<count($partners);$i++) { 
                            $div = $i;
                            if (fmod($i,3) == 0) {echo '<div class="col-12">';}
                            $partner = func::clearHtml($partners[$i]);
                            $partner_parts = explode("==",$partner);
                            $partner_img = trim($partner_parts[0]); 
                            $partner_title = trim($partner_parts[1]); 
                            $partner_text = trim($partner_parts[2]);
                                echo '<div class="col-4 col-sm-12">';
                                    echo '<div class="partner" style="height:100px; padding-bottom:20px;">';
                                        echo '<div class="col-4">';
                                            echo '<img src="'.$partner_img.'"/>';
                                        echo '</div>';
                                        echo '<div class="col-8">';
                                            echo '<p style="font-weight: bold;">'.$partner_title.'</p>';
                                            echo '<p>'.$partner_text.'</p>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            if (fmod($i,3) == 2) {echo '</div>';}
                        }
                        if (fmod($div,3) <> 2 && $div <> -1){echo '</div>';}
                        ?>
                    <!--</div>-->
                </div>
            </div>
            <div class="col-12"><div class="hr-row post-mar-bottom5"></div></div>
        </div>
    </div>
    
    <?php include "blocks/footer.php"; ?>
</body>
</html>

