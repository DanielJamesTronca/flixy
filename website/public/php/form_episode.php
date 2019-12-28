<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
$output = file_get_contents("../html/form-episode.html");

if(!isset($_SESSION))
session_start();


get_media_name($output);

/* START show error message if set */
if(isset($_SESSION['error-message-episode'])) {
    $output = str_replace("<div class='margin-top-small hidden'>","<div class='margin-top-small'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message-episode'],$output);
    session_destroy();
}
/* END show error message if set */

restore_parameters($output);




function restore_parameters(&$output){
    /* START restore form parameters if available */
    if (isset($_SESSION['title'])){
        $output = str_replace("'{title}'",$_SESSION['title'],$output);  
    }
    else{
        $output = str_replace("'{title}'","",$output); 
    }
    if (isset($_SESSION['description'])){
        $output = str_replace("{description}",$_SESSION['description'],$output);
    }
    else{
        $output = str_replace("{description}","",$output);
    }
    if (isset($_SESSION['promoUrl'])){
        $output = str_replace("'{promoUrl}'",$_SESSION['promoUrl'],$output);
    }
    else{
        $output = str_replace("'{promoUrl}'","",$output);
    }
    if (isset($_SESSION['mediaid'])){
        $output = str_replace("'{mediaid}'",$_SESSION['mediaid'],$output);
    }
    else{
        $output = str_replace("'{mediaid}'","",$output); 
    }
    if (isset($_SESSION['seasonNum'])){
        $output = str_replace("'{seasonNum}'",$_SESSION['seasonNum'],$output);
    }
    else{
        $output = str_replace("'{seasonNum}'","",$output);
    }
    if (isset($_SESSION['episodeNum'])){
        $output = str_replace("'{episodeNum}'",$_SESSION['episodeNum'],$output);
    }
    else{
        $output = str_replace("'{episodeNum}'","",$output); 
    }
    if (isset($_SESSION['airDate'])){
        $output = str_replace("'{airDate}'",$_SESSION['airDate'],$output);
    }
    else{
        $output = str_replace("'{airDate}'","",$output);
    }
    /*END restore form parameters if available */
}



function get_media_name(&$output){
    /* START get and set episode name */
    if(isset($_GET['mediaName'])){
        $mediaName = $_GET['mediaName'];
    }
    else{
        $mediaName = "";
    }
    $pathGET = "./php/check_form_episode.php?mediaName=".$mediaName;
    $output = str_replace("./php/check_form_episode.php",$pathGET,$output);
    $output = str_replace("{mediaName}",$mediaName,$output); 
    /* END get and set episode name */
}

echo $output;
?>
