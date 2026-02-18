<?php
$shareUrl = "http://demo.karcher-marine.com" . $_SERVER['REQUEST_URI'];
?>

<div style="font-size:30px">

<!--<a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $shareUrl; ?>">-->
<span id="fb-share" class="fa fa-facebook" style="cursor:pointer"></span>
<!--</a>-->

<a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo $shareUrl; ?>">
<span class="fa fa-twitter"></span>
</a>

<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $shareUrl; ?>">
<span class="fa fa-linkedin"></span>
</a>

<a target="_blank" href="https://plus.google.com/share?url=<?php echo $shareUrl; ?>">
<span class="fa fa-googleplus"></span>
</a>

</div>