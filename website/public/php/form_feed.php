<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
$output = file_get_contents("../html/form-feed.html");
if(!isset($_SESSION))
session_start();

/* START restore form parameters if available */
if(isset($_SESSION['error-message-news'])) {
    $output = str_replace("<div class='margin-top-small hidden'>","<div class='margin-top-small'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message-news'],$output);
    session_destroy();
}
if (isset($_SESSION['mediaid'])){
    $output = str_replace("{mediaid}",restore_list_title_media(),$output);
}
else{
    $output = str_replace("{mediaid}",get_list_title_media(),$output); 
}
if (isset($_SESSION['content'])){
    $output = str_replace("{content}",$_SESSION['content'],$output);
}
else{
    $output = str_replace("{content}","",$output);
}
if (isset($_SESSION['subtitle'])){
    $output = str_replace("'{subtitle}'",$_SESSION['subtitle'],$output);
}
else{
    $output = str_replace("'{subtitle}'","",$output);
}
if (isset($_SESSION['username'])){
    $output = str_replace("'{eventDate}'",$_SESSION['eventDate'],$output); //va assemblata data con funzione
}
else{
    $output = str_replace("'{eventDate}'","",$output); 
}
if (isset($_SESSION['videoUrl'])){
    $output = str_replace("'{videoUrl}'",$_SESSION['videoUrl'],$output);
}
else{
    $output = str_replace("'{videoUrl}'","",$output);
}
/*END restore form parameters if available */


function get_list_title_media(){
    $options = "";
    $media_list = Media::list();
    foreach ($media_list as $media){
        $options.= "<option value=$media->id>$media->title</option>";
    }
    return $options;
}

function restore_list_title_media(){
    $options = "";
    $temp = "";
    $media_list = Media::list();
    foreach ($media_list as $media){
        if ($media->id == $_SESSION['mediaid']){
            $options = "<option value=$media->id>$media->title</option>";
        }
        else{
            $temp.= "<option value=$media->id>$media->title</option>";
        }
        $options .= $temp;
    }
    return $options;
    
}


echo $output;
?>