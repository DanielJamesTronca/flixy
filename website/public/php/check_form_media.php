<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$_SESSION['error-message-media'] = "";
$_SESSION['title'] = $_POST["mediaTitle"];
$_SESSION['description'] = $_POST["description"];
$_SESSION['genreid'] = $_POST["genreid"];
$_SESSION['stars'] = $_POST["stars"];
$_SESSION['duration'] = $_POST["duration"];
$_SESSION['hasEpisodes'] = $_POST["switch-one"];
$_SESSION['numEpisodes'] = $_POST["numEpisodes"];
$_SESSION['numSeasons'] = $_POST["numSeasons"];
$_SESSION['trailerUrl'] = $_POST["trailerUrl"];
$_SESSION['day'] = $_POST["day"];
$_SESSION['month'] = $_POST["month"];
$_SESSION['year'] = $_POST["year"];

$id = null;
if (isset($_GET["mediaid"])) {
    $id = $_GET["mediaid"];
}


if (!SessionManager::isUserLogged()) {
    $_SESSION['error-message-media'] = "devi prima autenticarti.";
    if(isset($_GET['mediaid']))
        header("Location: ".SessionManager::BASE_URL."formmedia&mediaid=".$id);
    else
        header("Location: ".SessionManager::BASE_URL."formmedia");
    return;
}

/* START check if all parameters are ok */
if (!isset($_POST["mediaTitle"]) || !isset($_POST["description"]) || !isset($_POST["genreid"]) || !isset($_POST["stars"]) || !isset($_POST["duration"]) 
     || !isset($_SESSION["hasEpisodes"]) || (isTvSeries() && (!isset($_POST["numSeasons"]) || !isset($_POST["numEpisodes"])))) {
         
    $_SESSION['error-message-media'] = "si prega di compilare tutti i campi.";
    if(isset($_GET['mediaid']))
        header("Location: ".SessionManager::BASE_URL."formmedia&mediaid=".$id);    
    else
        header("Location: ".SessionManager::BASE_URL."formmedia");
    return;
}

if ($_POST["trailerUrl"]!="" && !Utils::isValidUrl($_POST["trailerUrl"])) {
    $_SESSION['error-message-media'] = "si prega di inserire un link video valido. Il parametro è opzionale.";
    if(isset($_GET['mediaid']))
        header("Location: ".SessionManager::BASE_URL."formmedia&mediaid=".$id);
    else
        header("Location: ".SessionManager::BASE_URL."formmedia");
    return;
}

if(!Utils::isValidDate($_POST["day"],$_POST["month"],$_POST["year"])){
    $_SESSION['error-message-media'] = "si prega di inserire una data di rilascio valida.";
    if(isset($_GET['mediaid']))
        header("Location: ".SessionManager::BASE_URL."formmedia&mediaid=".$id);
    else
        header("Location: ".SessionManager::BASE_URL."formmedia");
    return;
}
/* END check if all parameters are ok */

// good to go on these parameters, now upload them to db

$media = new Media();
$media->title = htmlentities($_POST["mediaTitle"], ENT_QUOTES);
$media->description = htmlentities($_POST["description"], ENT_QUOTES);
$media->genreId = $_POST["genreid"]; 
$media->stars = $_POST["stars"];
$media->duration = $_POST["duration"];
$media->hasEpisodes = isTvSeries() ? 1 : 0;
if (isTvSeries()){
    $media->numEpisodes = $_POST["numEpisodes"];
    $media->numSeasons = $_POST["numSeasons"];
}

$media->airDate = Utils::createDate($_POST["day"],$_POST["month"],$_POST["year"]);

if (isset($_POST["trailerUrl"]))
    $media->trailerUrl = Utils::convert_url_to_embed($_POST["trailerUrl"]);

// good to go on these parameters, now check image upload
$target_dir = "assets/images/covers/";

if (isset($_FILES["cover"]) && $_FILES["cover"]["size"]>0) { 
    $upload_result = Utils::uploadImage($target_dir, $_FILES["cover"],"../");
    if ($upload_result["success"] === false) {
        echo $upload_result["error"];
        return;
    }
    $media->coverUrl = $upload_result["url"];
} else{
    $mediaAttributes = Media::fetch($id);
    $coverUrl = $mediaAttributes->coverUrl;
    if($coverUrl!="")
        $media->coverUrl = $coverUrl;
}

if ($id == null) {
    // create new
    $media->saveInDB();
    header("Location: ".SessionManager::BASE_URL."home");
} else {
    // update
    $media->id = $id;
    $media->updateInDB();
    header("Location: ".SessionManager::BASE_URL."dettaglio&movieId=".$id);
    
}
unset($_FILES);
Utils::unsetAll(array('error-message-media','title','description','genreid','stars','duration','hasEpisodes','numEpisodes','numSeasons','trailerUrl','day','month','year'));

function isTvSeries(){
    if ($_SESSION["hasEpisodes"] == 'true')
        return true;
    else
        return false;
}

?>