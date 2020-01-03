<?php
include_once("../../src/controllers/utils.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$output = file_get_contents("../html/form-feed.html");
if(!isset($_SESSION))
session_start();

/* START show error message if set */
if(isset($_SESSION['error-message-feed'])) {
    $output = str_replace("<div class='margin-top-small hidden'>","<div class='margin-top-small' tabindex='0'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message-feed'],$output);
    session_destroy();
}
/* END show error message if set */

restore_parameters($output);

function restore_parameters(&$output){
/* START restore form parameters if available */

    if (isset($_SESSION['mediaid'])){
        $output = str_replace("{mediaid}",restore_list_title_media($_SESSION['mediaid']),$output);
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
    if (isset($_SESSION['day'])){
        $output = str_replace("{dayOption}",utils::restoreOptionsDay($_SESSION['day']),$output);
    }
    else{
        $output = str_replace("{dayOption}",utils::generateOptionsDay(),$output);
    }
    if (isset($_SESSION['month'])){
        $output = str_replace("{monthOption}",utils::restoreOptionsMonth($_SESSION['month']),$output);
    }
    else{
        $output = str_replace("{monthOption}",utils::generateOptionsMonth(),$output);
    }
    if (isset($_SESSION['year'])){
        $output = str_replace("{yearOption}",utils::restoreOptionsYear($_SESSION['year']),$output);
    }
    else{
        $output = str_replace("{yearOption}",utils::generateOptionsYear(),$output);
    }
    if (isset($_SESSION['videoUrl'])){
        $output = str_replace("'{videoUrl}'",$_SESSION['videoUrl'],$output);
    }
    else{
        $output = str_replace("'{videoUrl}'","",$output);
    }
/*END restore form parameters if available */
}


function get_list_title_media(){
    $options = "";
    $media_list = Media::list();
    foreach ($media_list as $media){
        $options.= "<option value='$media->id'>$media->title</option>";
    }
    return $options;
}

function restore_list_title_media($valueToRestore){
    $options = "";
    $toRestore = "";
    $media_list = Media::list();
    foreach ($media_list as $media){
        if ($media->id == $valueToRestore){
            $toRestore = "<option value='$media->id'>$media->title</option><optgroup class='secondary-bg' label='--------'>";
        }
        else{
            $options.= "<option value='$media->id'>$media->title</option>";
        }
    }
    $toRestore .= $options;
    $toRestore .= "</optgroup>";

    return $toRestore;
}


echo $output;
?>