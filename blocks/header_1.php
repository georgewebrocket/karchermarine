<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '956110144507897',
      xfbml      : true,
      version    : 'v2.6'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));



function myShare() {
	FB.ui(
	  {
		method: 'feed',
		name: '<?php echo $title; ?>',
		link: '<?php echo app::$host2 . $_SERVER['REQUEST_URI']; ?>',
		picture: '<?php echo $fbimg; ?>',			
		caption: '<?php echo "KARCHER-MARINE.COM"; ?>',
		description: '<?php echo strip_tags($shortdescr) . " / " . strip_tags($description); ?>'
	  },
	  function(response) {
		//
	  }
	);
}


</script>


<div class="header">
	
    <?php
	if ($cookiesEnabled) {
		$acceptCookies = 0;
		if (isset($_COOKIE['karchermarine_acceptcookies'])) {
			$acceptCookies = $_COOKIE['karchermarine_acceptcookies'];
		}
		if ($acceptCookies==0) {
	?>
    <div id="cookies-message-container" class="container-1260" style="padding:20px 0px">
    	<div class="col-1"></div>
        <div class="col-10">
        	 <h3 style="font-size:16px; font-weight:500; margin-bottom:10px">Our website uses cookies</h3>

			<p>Our site uses cookies. Some of the cookies we use are essential for parts of the site to function correctly. You may delete and block all cookies from this site, but parts of the site will not function correctly. To find out more about cookies on this website, see our <a href="privacy-policy">privacy policy</a>.</p>
            
            <span class="button" id="cookiesdirective_continue" style="margin:30px 0px; padding:10px 20px">
                Continue
            </span>
            
        </div>
        <div class="col-1"></div>
        <div style="clear:both"></div>
    </div>
    <?php
		}
	}
	?>
    
    <div class="container-100 col-sm-0" style="background-color:#ededed; border-bottom:1px solid #e3e3e3">
    	<div class="container-1260" style="text-align:right; padding:10px 0px">
            <a href="compare">Compare products <span id="count-compare" class="bage"></span></a> &nbsp;
            <a href="rfq">RFQ items <span id="count-rfq" class="bage"><?php echo $rfqListCount; ?></span></a> &nbsp;
            <div style="display:inline-block">
            <form action="search" method="post"><input name="t_search" type="text" placeholder="Search" /><input type="submit" value="OK" style="margin-left:-40px; width:40px"></form>
            </div>
	</div>
    </div>
    
    
    
    <div id="sticky-header" class="container-100 col-sm-0" style="background-color:#fff; z-index:9999">
        <div style="background-color: rgb(255,237,0);">
        <div id="nav0" class="container-1260" style="position: relative; border-bottom:3px solid #ededed; ">
            
            <div class="logo" style="background-color: #fff; padding: 20px 40px">
              <a href="<?php echo app::$host; ?>">
              <img src="img/karcher-logo.jpg" width="135" height="57" alt="karcher-marine-logo"/>
              </a>
            </div> 
            
            <div style="position: absolute; right: 0px; top:20px; padding: 20px 0px; font-size: 20px">
                <span style="font-weight: bold">KÄRCHER MARINE</span> A.K.M. MARINE
            </div>
            
            <div style="clear:both"></div>   
            
            
        </div><!--nav-->
        </div>
        
        <div id="nav" class="container-1260" style="position: relative;">
        <div style="padding: 5px 0px 0px">
            <div class="nav-item" style="padding:10px 10px 10px 0px"><a class="navlink" style="padding:10px 10px 10px 0px" href="menu-products.php">PRODUCTS</a></div>
            
            <div class="nav-item" style="padding:10px 10px 10px 0px"><a class="" style="padding:10px 10px 10px 0px" href="services">SERVICES</a></div>
            
            <div class="nav-item" style="padding:10px 10px 10px 0px"><a class="" style="padding:10px 10px 10px 0px" href="inside-karcher-marine">INSIDE KÄRCHER MARINE</a></div>  
        </div>
        </div>
        
        <div style="clear:both"></div>
        
    </div><!--sticky-header-->
    
    
    <!--MOBILE-HEADER-->
    <div class="col-0 col-sm-12"><div style="padding:20px 2%; background-color: rgb(255,237,0);">
        <div id="logo-mobile" class="col-6 col-vs-12" style="">
            <img src="img/karcher-logo-mobile.jpg" width="145" height="57" alt="karcher-marine-logo"/>
        </div>
        
        <div class="col-6 col-vs-12"><div style="padding-top:0px;">
        	<div style="text-align:right">
            <span id="mobile-menu-launch" class="fa fa-align-justify"></span>
            </div>
            
        </div></div>
        
        <div style="clear:both"></div>
        
        
        <div class="mobile-company-title" style="">
            <span style="font-weight: bold">KÄRCHER MARINE</span> <span class="sm-visible"><br/></span> A.K.M. MARINE
        </div>
        
        
        <div id="mobile-menu">
        	
            <div style="background-color:#ededed; font-size:22px">
            	<div style="padding:20px">
                <a href="compare">Compare products<span id="count-compare-mobile" class="bage" style="font-size:22px"></span></a>
                </div>
                <div style="padding:20px">
                <a href="rfq">RFQ items<span id="count-rfq-mobile" class="bage" style="font-size:22px"><?php echo $rfqListCount; ?></span></a>
                </div>
                <div style="padding:20px">                
                <form action="search" method="post">
                <input name="t_search" type="text" placeholder="Search" style="width:75%; padding:10px 2%; font-size:20px" />
                <input type="submit" value="OK" style="width:15%; padding:10px 2%; font-size:20px"></form>
                </div>               
                
            </div>            
            
            <ul>
            	<li><a href="<?php echo app::$host; ?>">HOME</a></li>
                <li><a href="category/2/professional">PRODUCTS</a></li>
                <li><a href="services">SERVICES</a></li>
                <li><a href="inside-karcher-marine">INSIDE KARCHER-MARINE</a></li>
            </ul>
        </div>
        
        
    </div></div>
    
    
    
    
    <div class="container-1260" style="position:relative">
        <div id="mega-menu" class="mega-menu">
            <?php include 'services.php'; ?>
        </div>
    </div>
    
    

</div>