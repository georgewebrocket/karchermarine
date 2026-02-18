<html>
    <head>
        <title>Test</title>
        
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
        <script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
        
        <script>
        
        $(function() {
            $('a.fancybox').fancybox(); 
            $("a.fancyframe").fancybox(
                {'type' : 'iframe', 'width' : 1200, 'height' : 600 });
            $("a.fancyframe600").fancybox(
                {'type' : 'iframe', 'width' : 600, 'height' : 600 });
            $("a.fancyframe800").fancybox(
                {'type' : 'iframe', 'width' : 800, 'height' : 600 });
         });
        
        </script>

    </head>
    <body>
        <?php if (isset($_GET['msg'])) { echo "<h1>".$_GET['msg']."</h1>"; } ?>
        <a href="test2.php?msg=A" class="fancyframe" data-fancybox-group="mygroup">1</a>
        <a href="test2.php?msg=B" class="fancyframe" data-fancybox-group="mygroup">2</a>
        <a href="test2.php?msg=d" class="fancyframe" data-fancybox-group="mygroup">3</a>
        
    </body>
</html>
