<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hot water high-pressure cleaners</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<base href="http://karcher-marine.com/dm/" />

<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/grid.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/scripts.js"></script>
<script src="js/scripts2.js"></script>

<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<link href="css/font-awesome.css" rel="stylesheet" type="text/css" media="all"/>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<script>
jQuery(document).ready(function($) {
   
    $('#count-compare').text(0);
	$('#count-compare-mobile').text(0);
    $('#count-compare').show('slow');
    
    var arr = [];
    jQuery.each(arr, function(index, value){
        $(".chk-compare").each(function() {
            if($(this).val() == value){
                $(this).prop('checked', true);
                $(this).parent().parent(".compare").addClass('active-compare').removeClass('compare');
            }else{
                $(this).parent().parent('active-compare').addClass('compare').removeClass('active-compare');
            }
        });
    });

});
</script>
</head>

<body>

	<div class="header">
	<div class="container-100 col-sm-0" style="background-color:#ededed; border-bottom:1px solid #e3e3e3">
    	<div class="container-1260" style="text-align:right; padding:10px 0px">
            <a href="compare">Compare products <span id="count-compare" class="bage"></span></a> &nbsp;
            <a href="rfq">RFQ items <span id="count-rfq" class="bage">1</span></a> &nbsp;
            <div style="display:inline-block">
            <form action="search" method="post"><input name="t_search" type="text" placeholder="Search" /><input type="submit" value="OK" style="margin-left:-40px; width:40px"></form>
            </div>
	</div>
    </div>
    
    
    
    <div id="sticky-header" class="container-100 col-sm-0" style="border-bottom:3px solid #ededed; background-color:#fff; z-index:9999">
        <div id="nav" class="container-1260" style="position: relative">
            
            <div class="logo">
              <a href="http://karcher-marine.com/dm/">
              <img src="img/karcher-marine-logo.png" width="135" height="57" alt="karcher-marine-logo"/>
              </a>
            </div>            
            
            <div class="nav-item"><a class="navlink" href="menu-products.php">PRODUCTS</a></div>
            
            <div class="nav-item"><a class="navlink" href="services.php">SERVICES</a></div>
            
            <div class="nav-item"><a class="" href="inside-karcher-marine">INSIDE KARCHER-MARINE</a></div>     
            
            
        </div><!--nav-->
        
        <div style="clear:both"></div>
        
    </div><!--sticky-header-->
    
    
    <!--MOBILE-HEADER-->
    <div class="col-0 col-sm-12"><div style="padding:20px 2%">
    	<div id="logo-mobile" class="col-6 col-vs-12">
        	<img src="img/karcher-marine-logo.png" width="135" height="57" alt="karcher-marine-logo"/>
        </div>
        
        <div class="col-6 col-vs-12"><div style="padding-top:0px">
        	<div style="text-align:right">
            <span id="mobile-menu-launch" class="fa fa-align-justify"></span>
            </div>
            
        </div></div>
        
        <div style="clear:both"></div>
        
        <div id="mobile-menu">
        	
            <div style="background-color:#ededed; font-size:22px">
            	<div style="padding:20px">
                <a href="compare">Compare products<span id="count-compare-mobile" class="bage"></span></a>
                </div>
                <div style="padding:20px">
                <a href="rfq">RFQ items<span id="count-rfq-mobile" class="bage">1</span></a>
                </div>
                <div style="padding:20px">                
                <form action="search" method="post">
                <input name="t_search" type="text" placeholder="Search" style="width:75%; padding:10px 2%; font-size:20px" />
                <input type="submit" value="OK" style="width:15%; padding:10px 2%; font-size:20px"></form>
                </div>               
                
            </div>            
            
            <ul>
            	<li><a href="http://karcher-marine.com/dm/">HOME</a></li>
                <li><a href="category/2/professional">PRODUCTS</a></li>
                <li><a href="services">SERVICES</a></li>
                <li><a href="inside-karcher-marine">INSIDE KARCHER-MARINE</a></li>
            </ul>
        </div>
        
        
    </div></div>
    
    
    
    
    <div class="container-1260" style="position:relative">
        <div id="mega-menu" class="mega-menu">
            
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
</div>        </div>
    </div>
    
    

</div>    
    <div class="main">
        <div id="ribbon">
            <div class="wraper">
                <div id="breadcrumbs">
                    <ul><li><a href="home.php">Home</a>></li><li><a href="category/2">PROFESSIONAL</a>></li><li><a href="category/3">High-pressure cleaners</a>></li><li class="current-product">Hot water high-pressure cleaners</li></ul>                </div>
                <h1>Hot water high-pressure cleaners</h1>
                <strong>Hot water makes the difference.</strong> With hot water high-pressure cleaners and the same amount of pressure, cleaning results are realy impressive. Karcher machines set the standards with their highest level of usage comfort and the most up-to-date technology.            </div>
        </div>
        <div class="wraper">
            <div class="post-mar-bottom4">                
                                <div class="post-image post-mar-bottom">
                    <img src="http://karcher-marine.com/wp/wp-content/uploads/Hot Water HP Cleaner 1260x456.jpg"/>
                </div>
                               
                
                <div class="post-content post-mar-bottom5">
                    <p><p><div class="col-4 col-sm-12"><div style="margin-right:10px"></p>
<p><strong>Efficient with high pressure.</strong></p>
<p style="text-align: left;">Even more so with hot water. When it comes to efficiency, cleaning results and environmental friendliness, Karcher high-pressure cleaners have a clear advantage over pressureless cleaning procedures. With Karcher HDS hot water high-pressure cleaners, the difference is even more apparent when removing stubborn dirt. Karcher HDS machines deliver superior results on oil, grease and protein stains and encrustations.</p>
<p></div></div></p>
<p><div class="col-4 col-sm-12"><div style="margin-right:10px"></p>
<p><strong>Advantages of hot water</strong></p>
<ul style="list-style-type: square;">
<li>Shorter cleaning times and a reduction in labour costs.</li>
<li>Germ-reducing effect.</li>
<li>Shorter drying time.</li>
<li>Significantly reduced cleaning agent consumption.</li>
<li>Protection of sensitive surfaces and the same cleaning effect at a lower working pressure.</li>
</ul>
<p></div></div></p>
<p><div class="col-4 col-sm-12"><div style="margin-right:10px"></p>
<p><strong>Certified by EUnited</strong></p>
<p style="text-align: justify;">The independent European Cleaning Machines Association has certified K&auml;rcher, the world&rsquo;s first provider of hot water high-pressure cleaners, for efficiency and compliance with exhaust gas emissions standards. This guarantees:</p>
<ul style="list-style-type: square;">
<li>Highly efficient burners.</li>
<li>Low fuel consumption.</li>
<li>Low emissions.</li>
</ul>
<p></div></div></p>
<p><div style="clear:both"></div></p>
<p>
<div class="col-12">
<div class="col-3 col-sm-12 subcat2">
		<div>
			<a href="category/30">
				<img src="http://karcher-marine.com/wp/wp-content/uploads/Product images-videos 600x600/FEATURED IMAGE/COMMON/HDS Super-Middle-Special class.jpg" width="100%" height="auto" alt="Super class"/>
			</a>
			<a href="category/30">
				<h2>Super class</h2>
			</a>
			<div>Hot water super class – efficient in daily continuous use, offers top class performance where work had to be carried out quickly and with the best cleaning results. Ideal for heavy-duty use.</div>
		</div>
	</div>
	<div class="col-3 col-sm-12 subcat2"><div><a href="category/31"><img src="http://karcher-marine.com/wp/wp-content/uploads/Product images-videos 600x600/FEATURED IMAGE/COMMON/HDS Super-Middle-Special class.jpg" width="100%" height="auto" alt="Middle class"/></a><a href="category/31"><h2>Middle class</h2></a><div>Hot water middle class – for a wide range of applications. Cargo holds cleaning, deck cleaning, pipe cleaning and removal of stubborn dirt.</div></div>
	</div>
	<div class="col-3 col-sm-12 subcat2"><div><a href="category/32"><img src="http://karcher-marine.com/wp/wp-content/uploads/Product images-videos 600x600/FEATURED IMAGE/COMMON/HDS compact class.jpg" width="100%" height="auto" alt="Compact class"/></a><a href="category/32"><h2>Compact class</h2></a><div>Hot water compact class – simple operation for crew. Innovative technology – easy handling: the compact class features one-button operation, chassis with integrated tank and on-board high-pressure hose drum.</div></div>
	</div>
	<div class="col-3 col-sm-12 subcat2"><div><a href="category/33"><img src="http://karcher-marine.com/wp/wp-content/uploads/Product images-videos 600x600/FEATURED IMAGE/COMMON/HDS Upright class.jpg" width="100%" height="auto" alt="Upright class"/></a><a href="category/33"><h2>Upright class</h2></a><div>The upright class – mobility at its finest. A perfect choice for engine room use. These powerful and robust machines stand out due to their manoeuvrability.</div></div>
	</div>
</div>
<div class="col-12">
	<div class="col-3 col-sm-12 subcat2"><div><a href="category/71"><img src="http://karcher-marine.com/wp/wp-content/uploads/Product images-videos 600x600/FEATURED IMAGE/COMMON/HDS Super-Middle-Special class.jpg" width="100%" height="auto" alt="Special class"/></a><a href="category/71"><h2>Special class</h2></a><div>The zero emission specialist. Wherever exhaust gazes are unwanted or prohibited.</div></div>
	</div>
	<div class="col-3 col-sm-12 subcat2"><div><a href="category/35"><img src="http://karcher-marine.com/wp/wp-content/uploads/Product images-videos 600x600/FEATURED IMAGE/COMMON/Combustion engine middle class.jpg" width="100%" height="auto" alt="Combustion engine"/></a><a href="category/35"><h2>Combustion engine</h2></a><div>High-pressure cleaners with combustion engine - the independent ones. Where there is no power source, high pressure cleaners with combustion engine – with optional biodiesel operation – offer maximum versatility and independence.</div></div>
	</div>
	<div class="col-3 col-sm-12 subcat2"><div><a href="category/36"><img src="http://karcher-marine.com/wp/wp-content/uploads/Product images-videos 600x600/FEATURED IMAGE/UNIQUE/15245202.jpg" width="100%" height="auto" alt="HDS Trailer"/></a><a href="category/36"><h2>HDS Trailer</h2></a><div>Outstanding mobility and reliability, whenever there is luck of power and water supply.</div></div>
	</div>
	</div>

	<div style="clear:both"></div></p>                 
                    
                    
                 </div>
            </div>
        </div>
    </div>
    
    <div class="scrollToTop"><i class="fa fa-arrow-circle-o-up fa-4x"></i></div>
<div class="footer">
	<div class="container-100" style="background-color:#ededed; border-top:1px solid #e3e3e3">
    	<div class="container-1260" style="padding:30px 0px">
        	<div class="col-4 col-sm-12">
            	<h2>LEGAL INFO</h2>
                
                <p>Copyright<br>
				Terms of use<br>
				Legal notice</p>
                
            </div>
            
            <div class="col-4 col-sm-12">
            	<h2>CONTACT</h2>
                
                <p>A.K.M. Marine Ltd.<br/>
                Ionos & Kimonos 1, Egkomi<br/>
                2406, Nicosia, Cyprus<br/>
                Tel. : +357 222 83 220<br/>
                Tel. Gr : +30 210 66 18 713-4<br/>
                E-mail : sales@karcher-marine.com</p>
                
            </div>
            
            <div class="col-4 col-sm-12">
            	<h2>SOCIAL MEDIA</h2>
                
                <p>
                <a href="#"><span class="fa fa-facebook-official social-link" style="font-size:40px; color:#3b579d"></span></a>
                <a href="#"><span class="fa fa-twitter-square social-link" style="font-size:40px; color:#61a9dd"></span></a>
                
                <a href="#"><span class="fa fa-youtube-square social-link" style="font-size:40px; color:#ff0000"></span></a>
                
                <div style="padding-top:10px;">                
                <img src="img/impa.jpg" width="110" height="60" alt=""/>
                </div>
                
                
                
                </p>
            </div>
            
            <div style="clear:both"></div>
            
        </div>
    </div>
    
    <div class="container-1260" style="padding:20px 0px 40px">
    	<div class="col-6" style="padding-top:20px">&copy; 2016 KARCHER-MARINE</div>
        <div class="col-6" style="text-align:right"></div>
        <div style="clear:both"></div>
  </div>

</div>

</body>
</html>