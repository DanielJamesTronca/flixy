
<?php

include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
$output = file_get_contents("../html/form-media.html");

if(!isset($_SESSION))
session_start();

/* START show error message if set */
if(isset($_SESSION['error-message-media'])) {
    $output = str_replace("<div class='margin-top-small hidden'>","<div class='margin-top-small' tabindex='0'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message-media'],$output);
    session_destroy();
}
/* END show error message if set */

restore_parameters($output);

function restore_parameters(&$output){
    /* START restore form parameters if available */
    if (isUpdateMode()){
        $media = Media::fetch($_GET['mediaid']);
        if(isFilm()){
            $output = str_replace("{headTitle}","Flixy - Modifica film",$output);
            $output = str_replace("{pageTitle}","Modifica Film",$output);
            $output = str_replace("id='radioTvSeries' checked='checked'","id='radioTvSeries' tabindex='-1' disabled='disabled'",$output); //disabilita switch serie tv
            $output = str_replace("id='radioFilm'","id='radioFilm' checked='checked' tabindex='-1'",$output); //seleziona switch film, tabindex=-1 perchè ha solo una funzione grafica
        }
        else{
            $output = str_replace("{headTitle}","Flixy - Modifica serie",$output);
            $output = str_replace("{pageTitle}","Modifica Serie TV",$output);
            $output = str_replace("id='radioFilm'","id='radioFilm' tabindex='-1' disabled='disabled'",$output); //disabilita switch film
            $output = str_replace("id='radioTvSeries'","id='radioTvSeries' tabindex='-1'",$output); //tabindex=-1 perchè ha solo una funzione grafica
        }
        $output = str_replace("'{title}'",$media->title,$output);
        $output = str_replace("{description}",$media->description,$output);
        $output = str_replace("{genreid}",restore_list_genres($media->genreId),$output);
        $output = str_replace("{stars}",restore_rating($media->stars),$output);
        $output = str_replace("'{duration}'",$media->duration,$output);
        $output = str_replace("'{hasEpisodes}'",$media->hasEpisodes,$output);
        $output = str_replace("'{numEpisodes}'",$media->numEpisodes,$output);
        $output = str_replace("'{numSeasons}'",$media->numSeasons,$output);
        $output = str_replace("'{trailerUrl}'",$media->trailerUrl,$output);
        $output = str_replace("'{airDate}'",$media->airDate,$output);
        set_path_with_mediaid($output);
    }
    else{
        $output = str_replace("{headTitle}","Flixy - Inserisci media",$output);
        $output = str_replace("{pageTitle}","Aggiungi Media",$output);
    
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
            $output = str_replace("{genreid}",restore_list_genres($_SESSION['genreid']),$output);
        }
        else{
            $output = str_replace("{genreid}",get_list_genres(),$output);
        }
        if (isset($_SESSION['stars'])){
            $output = str_replace("{stars}",restore_rating($_SESSION['stars']),$output);
        }
        else{
            $output = str_replace("{stars}",generate_rating_options(),$output); 
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
        if (isset($_SESSION['numSeasons'])){
            $output = str_replace("'{numSeasons}'",$_SESSION['numSeasons'],$output);
        }
        else{
            $output = str_replace("'{numSeasons}'","",$output);
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
    }
    /*END restore form parameters if available */
}

function get_list_genres(){
    $genresOptions = "";
    $genreList = Genre::getGenreList();
    foreach ($genreList as $genre){
        $genreList = Genre::getIdGenre($genre->name);
        $id = $genreList[0]->id;
        $genresOptions.= "<option value='$id'>$genre->name</option>";
    }
    return $genresOptions;
}

function restore_list_genres($valueToRestore){
    $options = "";
    $toRestore = "";
    $genre_list = genre::getGenreList();
    foreach ($genre_list as $genre){
        $genreList = Genre::getIdGenre($genre->name);
        $id = $genreList[0]->id;
        if ($id == $valueToRestore){
            $toRestore = "<option value='$id'>$genre->name</option><optgroup class='secondary-bg' label='--------'>";
        }
        else{
            $options.= "<option value='$id'>$genre->name</option>";
        }
    }
    $toRestore .= $options;
    return $toRestore;
}

function isUpdateMode(){
    if (isset($_GET['mediaid']))
        return true;
    else
        return false;
}

function set_path_with_mediaid(&$output){
/* START set path with mediaid for submit form in updateMode */
    $mediaid = $_GET['mediaid'];
    $pathGET = "./php/check_form_media.php?mediaid=".$mediaid;
    $output = str_replace("./php/check_form_media.php",$pathGET,$output);
/* END set path with mediaid for updateMode */
}

function generate_rating_options(){
    return
   "<option value='1'>1 (min)</option>
    <option value='2'>2</option>
    <option value='3'>3</option>
    <option value='4'>4</option>
    <option value='5'>5 (max)</option>";
}

function restore_rating($valueToRestore){
    $options = "";
    $toRestore = "";
    for ($i=1; $i<=5; $i++){
        if ($i == $valueToRestore){
            if($i==1)
                $toRestore = "<option value='$i'>$i (min)</option><optgroup class='secondary-bg' label='--------'>";
            else if ($i==5)
                $toRestore = "<option value='$i'>$i (max)</option><optgroup class='secondary-bg' label='--------'>";
            else
                $toRestore = "<option value='$i'>$i</option><optgroup class='secondary-bg' label='--------'>";
        }
        else{
            if($i==1)
                $options .= "<option value='$i'>$i (min)</option>";
            else if ($i==5)
                $options .= "<option value='$i'>$i (max)</option>";
            else
                $options .= "<option value='$i'>$i</option>";
        }
    }
    $toRestore .= $options;
    $toRestore .= "</optgroup>";
    return $toRestore;
}

function isFilm(){
    return !(Media::fetch($_GET['mediaid'])->hasEpisodes);
}

echo $output;
?>