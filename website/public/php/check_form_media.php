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
$_SESSION['hasEpisodes'] = $_GET["hasEpisodes"];
$_SESSION['numEpisodes'] = $_POST["numEpisodes"];
$_SESSION['numSeason'] = $_POST["numSeason"];
$_SESSION['trailerUrl'] = $_POST["trailerUrl"];
$_SESSION['airDate'] = $_POST["airDate"];

if (!SessionManager::isUserLogged()) {
    $_SESSION['error-message-media'] = "Devi prima autenticarti.";
    header("Location: ../php/form_media.php");
    return;
}

// parametri in input: content, subtitle, mediaid, videoUrl, eventDate

if (!isset($_POST["mediaTitle"]) || !isset($_POST["description"]) || !isset($_POST["genreid"]) || !isset($_POST["stars"]) || !isset($_POST["duration"]) || !isset($_POST["hasEpisodes"]) || !isset($_POST["numEpisodes"]) || !isset($_POST["numSeason"]) || !isset($_POST["trailerUrl"]) || !isset($_POST["airDate"])) {
    $_SESSION['error-message-media'] = "Parametri mancanti.";
    header("Location: ../php/form_media.php");
    return;
}

$id = null;
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}

$media = new Media();
$media->title = $_POST["mediaTitle"];
$media->description = $_POST["description"];
$media->genreId = $_POST["genreid"];
$media->stars = $_POST["stars"];
$media->duration = $_POST["duration"];
$media->hasEpisodes = $_POST["hasEpisodes"];
$media->numEpisodes = $_POST["numEpisodes"];
$media->numSeasons = $_POST["numSeason"];
$media->trailerUrl = Utils::convert_url_to_embedded($_POST["trailerUrl"]);
$media->airDate = $_POST["airDate"];

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