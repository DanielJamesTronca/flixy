<?php

include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
$output = file_get_contents("../html/form-media.html");

if(!isset($_SESSION))
session_start();

/* START show error message if set */
if(isset($_SESSION['error-message-media'])) {
    $output = str_replace("<div class='margin-top-small hidden'>","<div class='margin-top-small'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message-media'],$output);
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
    if (isset($_SESSION['genreid'])){
        $output = str_replace("{genreid}",restore_list_genres(),$output);
    }
    else{
        $output = str_replace("{genreid}",get_list_genres(),$output);
    }
    if (isset($_SESSION['stars'])){
        $output = str_replace("'{stars}'",$_SESSION['stars'],$output);
    }
    else{
        $output = str_replace("'{stars}'","",$output); 
    }
    if (isset($_SESSION['duration'])){
        $output = str_replace("'{duration}'",$_SESSION['duration'],$output);
    }
    else{
        $output = str_replace("'{duration}'","",$output);
    }
    if (isset($_SESSION['episodeNum'])){
        $output = str_replace("'{hasEpisodes}'",$_SESSION['hasEpisodes'],$output);
    }
    else{
        $output = str_replace("'{hasEpisodes}'","",$output); 
    }
    if (isset($_SESSION['numEpisodes'])){
        $output = str_replace("'{numEpisodes}'",$_SESSION['numEpisodes'],$output);
    }
    else{
        $output = str_replace("'{numEpisodes}'","",$output); 
    }
    if (isset($_SESSION['numSeason'])){
        $output = str_replace("'{numSeason}'",$_SESSION['numSeason'],$output);
    }
    else{
        $output = str_replace("'{numSeason}'","",$output);
    }
    if (isset($_SESSION['trailerUrl'])){
        $output = str_replace("'{trailerUrl}'",$_SESSION['trailerUrl'],$output);
    }
    else{
        $output = str_replace("'{trailerUrl}'","",$output); 
    }
    if (isset($_SESSION['airDate'])){
        $output = str_replace("'{airDate}'",$_SESSION['airDate'],$output);
    }
    else{
        $output = str_replace("'{airDate}'","",$output);
    }
    /*END restore form parameters if available */
}

function get_list_genres(){
    $genresOptions = "";
    $genreList = Genre::getGenreList();
    foreach ($genreList as $index=>$genre){
        $genreList = Genre::getIdGenre($genre->name);
        $id = $genreList[0]->id;
        $genresOptions.= "<option value=$id>$genre->name</option>";
    }
    return $genresOptions;
}

function restore_list_genres(){
    $options = "";
    $temp = "";
    $genre_list = genre::getGenreList();
    foreach ($genre_list as $genre){
        $genreList = Genre::getIdGenre($genre->name);
        $id = $genreList[0]->id;
        if ($id == $_SESSION['genreid']){
            $options = "<option value=$id>$genre->name</option>";
        }
        else{
            $temp.= "<option value=$id>$genre->name</option>";
        }
        $options .= $temp;
    }
    return $options;
}

echo $output;
?>