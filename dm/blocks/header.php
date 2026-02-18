<div class="header">
	<div class="container-100 col-sm-0" style="background-color:#ededed; border-bottom:1px solid #e3e3e3">
    	<div class="container-1260" style="text-align:right; padding:10px 0px">
            <a href="compare">Compare products <span id="count-compare" class="bage"></span></a> &nbsp;
            <a href="rfq">RFQ items <span id="count-rfq" class="bage"><?php echo $rfqListCount; ?></span></a> &nbsp;
            <div style="display:inline-block">
            <form action="search" method="post"><input name="t_search" type="text" placeholder="Search" /><input type="submit" value="OK" style="margin-left:-40px; width:40px"></form>
            </div>
	</div>
    </div>
    
    
    
    <div id="sticky-header" class="container-100 col-sm-0" style="border-bottom:3px solid #ededed; background-color:#fff; z-index:9999">
        <div id="nav" class="container-1260" style="position: relative">
            
            <div class="logo">
              <a href="<?php echo app::$host; ?>">
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
                <a href="rfq">RFQ items<span id="count-rfq-mobile" class="bage"><?php echo $rfqListCount; ?></span></a>
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