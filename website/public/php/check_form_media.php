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

$mediaid = $_GET['mediaid'];

if (!SessionManager::isUserLogged()) {
    $_SESSION['error-message-media'] = "devi prima autenticarti.";
    if(isset($_GET['mediaid']))
        header("Location: ../php/form_media.php?mediaid=$mediaid");
    else
        header("Location: ../php/form_media.php");
    return;
}

/* START check if all parameters are ok */
if (!isset($_POST["mediaTitle"]) || !isset($_POST["description"]) || !isset($_POST["genreid"]) || !isset($_POST["stars"]) || !isset($_POST["duration"]) || !isset($_POST["hasEpisodes"]) || !isset($_POST["numEpisodes"]) || !isset($_POST["numSeasons"]) || (isset($_POST["trailerUrl"]) && !Utils::isValidUrl($_POST["trailerUrl"]))) {
    $_SESSION['error-message-media'] = "si prega di compilare tutti i campi.";
    if(isset($_GET['mediaid']))
        header("Location: ../php/form_media.php?mediaid=$mediaid");
    else
        header("Location: ../php/form_media.php");
    return;
}

if ($_POST["trailerUrl"]!="" && !Utils::isValidUrl($_POST["trailerUrl"])) {
    $_SESSION['error-message-media'] = "si prega di inserire un link video valido. Il parametro è opzionale.";
    if(isset($_GET['mediaid']))
        header("Location: ../php/form_media.php?mediaid=$mediaid");
    else
        header("Location: ../php/form_media.php");
    return;
}

if(!utils::isValidDate($_POST["day"],$_POST["month"],$_POST["year"])){
    $_SESSION['error-message-media'] = "si prega di inserire una data di rilascio valida.";
    if(isset($_GET['mediaid']))
        header("Location: ../php/form_media.php?mediaid=$mediaid");
    else
        header("Location: ../php/form_media.php");
    return;
}
/* END check if all parameters are ok */


// good to go on these parameters, now upload them to db
$id = null;
if (isset($_GET["mediaid"])) {
    $id = $_GET["mediaid"];
}

$media = new Media();
$media->title = $_POST["mediaTitle"];
$media->description = $_POST["description"];
$media->genreId = $_POST["genreid"]; 
$media->stars = $_POST["stars"];
$media->duration = $_POST["duration"];
$media->hasEpisodes = $_POST["hasEpisodes"];
$media->numEpisodes = $_POST["numEpisodes"];
$media->numSeasons = $_POST["numSeasons"];
$media->airDate = utils::createDate($_POST["day"],$_POST["month"],$_POST["year"]);
if (isset($_POST["trailerUrl"]))
    $media->trailerUrl = Utils::convert_url_to_embed($_POST["trailerUrl"]);


// good to go on these parameters, now check image upload
$target_dir = "/assets/images/covers/";
if (isset($_FILES["cover"])) {
    $upload_result = Utils::uploadImage($target_dir, $_FILES["cover"], "..");
    if ($upload_result["success"] === false) {
        echo $upload_result["error"];
        return;
    }
    $media->coverUrl = $upload_result["url"];
} else if (isset($_POST["coverUrl"])) {
    $media->coverUrl = $_POST["coverUrl"];
}

if ($id == null) {
    // create new
    $media->saveInDB();
} else {
    // update
    $media->id = $id;
    $media->updateInDB();
}

echo "TODO: redirect based on result";

?>