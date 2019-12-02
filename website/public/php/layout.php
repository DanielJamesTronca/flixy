<?php
session_start();

$output = file_get_contents("../html/layout.html");

//inclusione del feed
$output = str_replace("{feed}",file_get_contents("../html/feed.html"),$output);
echo $output;

?>