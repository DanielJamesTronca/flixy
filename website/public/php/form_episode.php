<?php
include_once("../../src/controllers/utils.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$media = Media::fetch($_GET["mediaid"]);
get_media_name($output);

/* START show error message if set */
if(isset($_SESSION['error-message-episode'])) {
    $output = str_replace("<div class='margin-top-2 hidden'>","<div class='margin-top-2' tabindex='0'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message-episode'],$output);
    restore_parameters($output);
    Utils::unsetAll(array('error-message-episode','title','description','promoUrl','seasonNum','episodeNum','day','month','year'));
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
    if (isset($_SESSION['seasonNum'])){
        $output = str_replace("<option>{seasonNum}</option>",restore_seasons($_SESSION['seasonNum']),$output);
    }
    else{
        $output = str_replace("<option>{seasonNum}</option>",get_seasons(),$output);
    }
    if (isset($_SESSION['episodeNum'])){
        $output = str_replace("<option>{episodeNum}</option>",restore_id_episodes($_SESSION['episodeNum']),$output);
    }
    else{
        $output = str_replace("<option>{episodeNum}</option>",get_id_episodes(),$output); 
    }
    if (isset($_SESSION['day'])){
        $output = str_replace("<option>{dayOption}</option>",Utils::restoreOptionsDay($_SESSION['day']),$output);
    }
    else{
        $output = str_replace("<option>{dayOption}</option>",Utils::generateOptionsDay(),$output);
    }
    if (isset($_SESSION['month'])){
        $output = str_replace("<option>{monthOption}</option>",Utils::restoreOptionsMonth($_SESSION['month']),$output);
    }
    else{
        $output = str_replace("<option>{monthOption}</option>",Utils::generateOptionsMonth(),$output);
    }
    if (isset($_SESSION['year'])){
        $output = str_replace("<option>{yearOption}</option>",Utils::restoreOptionsYear($_SESSION['year']),$output);
    }
    else{
        $output = str_replace("<option>{yearOption}</option>",Utils::generateOptionsYear(),$output);
    }
    /*END restore form parameters if available */
}

function get_media_name(&$output){
    global $media;
    /* START get and set episode name */
    $mediaName = $media->title;
    $pathGET = "./php/check_form_episode.php?mediaid=".$media->id;
    $output = str_replace("./php/check_form_episode.php",$pathGET,$output);
    $output = str_replace("{mediaName}",$mediaName,$output);
    /* END get and set episode name */
}

function get_seasons(){
    global $media;
    $options="";
        for ($i=1; $i <= $media->numSeasons; $i++){
            $options.= "<option value='$i'>$i</option>"; 
        }
    return $options;
}

function restore_seasons($valueToRestore){
    global $media;
    $options = "";
    $toRestore = "";
    
        $numSeasons = $media->numSeasons;
        for ($i=1; $i<=$numSeasons; $i++){
            if ($i == $valueToRestore){
                $toRestore = "<option value='$i'>$i</option><optgroup class='secondary-bg' label='--------'>";
            }
            else{
                $options.= "<option value='$i'>$i</option>";
            }
        }
        $toRestore .= $options;
        $toRestore .= "</optgroup>";
    
    return $toRestore;
}


function get_id_episodes(){
    global $media;
    $options = "";
    
        $numEpisodes = $media->numEpisodes;
        for ($i=1; $i<=$numEpisodes; $i++){
            /*if(!in_array($i,get_id_episodes_already_defined())) */
                $options.= "<option value='$i'>$i</option>";
        }
    
    return $options;
}

function get_id_episodes_already_defined(){
    global $media;
    $idDefinedEpisodes = [];
        $listEpisodes = Episode::getEpisodesFor($media->id);
        foreach($listEpisodes as $index=>$episode){
            $idDefinedEpisodes[$index] = $episode->id;
        }
    return $idDefinedEpisodes;
}

function restore_id_episodes($valueToRestore){
    global $media;
    $options = "";
    $toRestore = "";

        $numEpisodes = $media->numEpisodes;
        for ($i=1; $i<=$numEpisodes; $i++){
            if($i == $valueToRestore){
                $toRestore.= "<option value='$i'>$i</option><optgroup class='secondary-bg' label='--------'>";
            }
            else{
                $options.= "<option value='$i'>$i</option>";
            }
        }
        $toRestore .= $options;
        $toRestore .= "</optgroup>";
    
    return $toRestore;
}

?>
