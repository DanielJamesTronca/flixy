<?php

$output = file_get_contents("../html/login.html");
if(!isset($_SESSION))
  session_start();
if(isset($_SESSION['login']) && !$_SESSION['login']) {
    $output = str_replace("<div class='margin-top-small hidden'>","<div class='margin-top-small'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message'],$output);
    session_destroy();
}


if (isset($_SESSION['username'])){
    $output = str_replace("'{username}'",$_SESSION['username'],$output);
}
else{
    $output = str_replace("'{username}'","",$output);
}

echo $output;
?>