<?php
require_once('php/config.php');
require_once('php/db.php');
require_once('php/utils.php');
require_once('php/wp.php');
require_once('php/start.php');
require_once('php/session.php');

//$sql = "SELECT B5iyk_terms.term_id AS id, B5iyk_terms.name, B5iyk_term_taxonomy.parent AS parent_id FROM  B5iyk_term_taxonomy "
//        . " INNER JOIN B5iyk_terms on B5iyk_term_taxonomy.term_id = B5iyk_terms.term_id WHERE  taxonomy =  'category'";
//
//$cat_menu_view = new categories_view($db1,$sql,0,0);
//
//$cat_id = 29;
//
//$arr_cat_menu = $cat_menu_view->get_tree($cat_id, 0);
//
//var_dump($arr_cat_menu);

?>

<style>
    .menu-item{
        padding-left: 30px;
    }
    
    .menu-level-1{
        padding: 10px; background-color: #fff;
    }
    
    .menu-level-1 img{
        width: 100%
    }
    
    .menu-level-1 h3{
        margin: 10px 0;
        font-weight: bold;
    }
    
    .menu-level-1 i{
        font-weight: bold;
        margin-right: 5px;
    }
    
    .menu-level-1 ul li{
        margin-top: 20px
    }
</style>
<div style="margin-left: -30px;">
    <div class="col-12">
        <div class="col-4">
            <div class="menu-item">
                <div class="menu-level-1">
                    <img src="http://karcher-marine.com/demo/img/home_amp_garden_service.jpg" />
                    <h3>Home & Garden</h3>
                    <ul>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Kärcher Service</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Product registration</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>FAQs</a></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-4">
            <div class="menu-item">
                <div class="menu-level-1">
                    <img src="http://karcher-marine.com/demo/img/professional_service.jpg" />
                    <h3>Professional</h3>
                    <ul>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Industry solutions</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Kärcher Fleet</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Kärcher Lease</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Kärcher Academy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="menu-item">
                <div class="menu-level-1">
                    <img src="http://karcher-marine.com/demo/img/service_support.jpg" />
                    <h3>Home & Garden </h3>
                    <ul>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Retailer search</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Spare parts</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Home & Garden FAQs</a></li>

                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Online shop information</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Download</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>Contact</a></li>
                        <li><a href ="#"><i class="fa fa-angle-right fa-lg"></i>InfoNet</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>