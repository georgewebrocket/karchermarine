<?php

$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array('secret' => '6LcOfhsTAAAAAIoKQbWpVes3Ezbof26l5wFyltmq', 
    'response' => $_REQUEST['g_recaptcha_response']);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

//var_dump($result);
$jsn = json_decode($result, true);
$recaptcha = $jsn["success"];

?>