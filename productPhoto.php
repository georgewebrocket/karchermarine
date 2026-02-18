<?php
$photo = urldecode($_GET['photo']);
?>
<html>
    <head>
        <title>Karcher-Marine</title>
    </head>
    <body>
        <div style="text-align: center">
            <img src="<?php echo $photo; ?>" style="max-width: 100%; height: auto" />
        </div>

    </body>
</html>
