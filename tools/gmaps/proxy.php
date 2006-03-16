<?php
//Proxy only for the maps, not the controls.
$t = $_GET["t"];
header("Content-type: image/jpg");
$fp = fopen("http://kh3.google.com/kh?v=3&t=".$t,'rb');
fpassthru($fp);
?>
