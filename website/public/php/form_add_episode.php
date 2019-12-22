<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

if (!SessionManager::isUserLogged()) {
    echo "Error, no user logged";
    return;
}

// parametri in input: title, description, promoUrl, mediaid, seasonNum, episodeNum, airDate

if (!isset($_POST["title"]) || !isset($_POST["description"]) || !isset($_POST["promoUrl"]) || !isset($_POST["mediaid"]) || !isset($_POST["seasonNum"]) || !isset($_POST["episodeNum"]) || !isset($_POST["airDate"]) ) {
    echo "Error, Missing parameters";
    return;
}

$episode = new Episode();
$episode->title = $_POST["title"];
$episode->description = $_POST["description"];
$episode->promoUrl = $_POST["promoUrl"];
$episode->mediaId = $_POST["mediaid"];
$episode->seasonNum = $_POST["seasonNum"];
$episode->episodeNum = $_POST["episodeNum"];
$episode->airDate = $_POST["airDate"];

$episode->saveInDB();
echo "TODO: redirect based on result";

?>