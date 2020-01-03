<?php
include_once("../../src/controllers/utils.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

get_media_name($output);

/* START show error message if set */
if(isset($_SESSION['error-message-episode'])) {
    $output = str_replace("<div class='margin-top-small hidden'>","<div class='margin-top-small' tabindex='0'>",$output);
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
        $output = str_replace("{seasonNum}",restore_seasons($_SESSION['seasonNum']),$output);
    }
    else{
        $output = str_replace("{seasonNum}",get_seasons(),$output);
    }
    if (isset($_SESSION['episodeNum'])){
        $output = str_replace("{episodeNum}",restore_id_episodes($_SESSION['episodeNum']),$output);
    }
    else{
        $output = str_replace("{episodeNum}",get_id_episodes(),$output); 
    }
    if (isset($_SESSION['day'])){
        $output = str_replace("{dayOption}",Utils::restoreOptionsDay($_SESSION['day']),$output);
    }
    else{
        $output = str_replace("{dayOption}",Utils::generateOptionsDay(),$output);
    }
    if (isset($_SESSION['month'])){
        $output = str_replace("{monthOption}",Utils::restoreOptionsMonth($_SESSION['month']),$output);
    }
    else{
        $output = str_replace("{monthOption}",Utils::generateOptionsMonth(),$output);
    }
    if (isset($_SESSION['year'])){
        $output = str_replace("{yearOption}",Utils::restoreOptionsYear($_SESSION['year']),$output);
    }
    else{
        $output = str_replace("{yearOption}",Utils::generateOptionsYear(),$output);
    }
    /*END restore form parameters if available */
}


function get_media_name(&$output){
    /* START get and set episode name */
    if(isset($_GET['mediaid'])){
        $mediaid = $_GET['mediaid'];
        $mediaName = Media::fetch($mediaid)->title;
    }
    else{
        $mediaid = NULL;
        $mediaName = "";
    }
    $pathGET = "./php/check_form_episode.php?mediaid=".$mediaid;
    $output = str_replace("./php/check_form_episode.php",$pathGET,$output);
    $output = str_replace("{mediaName}",$mediaName,$output);
    /* END get and set episode name */
}

function get_seasons(){
    $options="";
    $mediaList = Media::list();
    if(isset($_GET['mediaid'])){
        $numSeasons = $mediaList[$_GET['mediaid']-1]->numSeasons;
        for ($i=1; $i<=$numSeasons; $i++){
            $options.= "<option value='$i'>$i</option>"; 
        }
    }
    return $options;
}

function restore_seasons($valueToRestore){
    $options = "";
    $toRestore = "";
    $mediaList = Media::list();
    if(isset($_GET['mediaid'])){
        $numSeasons = $mediaList[$_GET['mediaid']-1]->numSeasons;
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
    }
    return $toRestore;
}


function get_id_episodes(){
    $options = "";
    $mediaList = Media::list();
    if(isset($_GET['mediaid'])){
        $numEpisodes = $mediaList[$_GET['mediaid']-1]->numEpisodes;
        for ($i=1; $i<=$numEpisodes; $i++){
            /*if(!in_array($i,get_id_episodes_already_defined())) */
                $options.= "<option value='$i'>$i</option>";
        }
    }
    return $options;
}

function get_id_episodes_already_defined(){
    $idDefinedEpisodes = [];
    if(isset($_GET['mediaid'])){
        $listEpisodes = Episode::getEpisodesFor($_GET['mediaid']);
        foreach($listEpisodes as $index=>$episode){
            $idDefinedEpisodes[$index] = $episode->id;
        }
    }
    return $idDefinedEpisodes;
}

function restore_id_episodes($valueToRestore){
    $options = "";
    $toRestore = "";
    $mediaList = Media::list();
    if(isset($_GET['mediaid'])){
        $numEpisodes = $mediaList[$_GET['mediaid']-1]->numEpisodes;
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
    }
    return $toRestore;
}

?>
