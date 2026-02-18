<?php

echo "------TEST FUNCTIONS---------------"."<br>";
if (function_exists('curl_exec')){
echo "curl_exec exist"."<br>";
}
if(function_exists('file_get_contents')){
echo "file_get_contents exist"."<br>";
}
if(function_exists('fopen')){
echo "fopen exist"."<br>";    
}
if(function_exists('stream_get_contents')){
echo "stream_get_contents exist"."<br>"; 
}
echo "----------------------------------"."<br>";

function url_get_contents ($url) {
    if (function_exists('curl_exec')){ 
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        $url_get_contents_data = (curl_exec($conn));
        curl_close($conn);
    }elseif(function_exists('file_get_contents')){
        $url_get_contents_data = file_get_contents($url);
    }elseif(function_exists('fopen') && function_exists('stream_get_contents')){
        $handle = fopen ($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
    }else{
        $url_get_contents_data = false;
    }
return $url_get_contents_data;
}

$data = url_get_contents("https://www.google.gr");


if($data){
echo "Done";
}

?>