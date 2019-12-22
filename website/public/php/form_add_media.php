<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

if (!SessionManager::isUserLogged()) {
    echo "Error, no user logged";
    return;
}

// parametri in input: title, description, cover file, genreid, duration, stars, hasEpisodes, numEpisodes, numSeasons,trailerUrl, airDate

if (!isset($_POST["title"]) || !isset($_POST["description"]) || !isset($_POST["genreid"]) || !isset($_POST["stars"]) || !isset($_POST["duration"]) || !isset($_POST["hasEpisodes"]) || !isset($_POST["numEpisodes"]) || !isset($_POST["numSeasons"]) || !isset($_POST["airDate"]) ) {
    echo "Error, Missing parameters";
    return;
}

$media = new Media();
$media->title = $_POST["title"];
$media->description = $_POST["description"];
$media->genreId = $_POST["genreid"];
$media->stars = $_POST["stars"];
$media->duration = $_POST["duration"];
$media->hasEpisodes = $_POST["hasEpisodes"];
$media->numEpisodes = $_POST["numEpisodes"];
$media->numSeasons = $_POST["numSeasons"];
$media->trailerUrl = $_POST["trailerUrl"];
$media->airDate = $_POST["airDate"];

// good to go on these parameters, now check image upload
$target_dir = "/assets/images/covers/";
if (!isset($_FILES["cover"])) {
    echo "Error, no image selected";
    return;
}
$upload_result = Utils::uploadImage($target_dir, $_FILES["cover"], "..");
if ($upload_result["success"] === false) {
    echo $upload_result["error"];
    return;
}

$media->coverUrl = $upload_result["url"];

$media->saveInDB();
echo "TODO: redirect based on result";

?>