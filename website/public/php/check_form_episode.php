<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$_SESSION['error-message-episode'] = "";
$_SESSION['title'] = $_POST["titleEpisode"];
$_SESSION['description'] = $_POST["description"];
$_SESSION['promoUrl'] = $_POST["promoUrl"];
$_SESSION['mediaid'] = $_POST["mediaid"];
$_SESSION['seasonNum'] = $_POST["seasonNum"];
$_SESSION['episodeNum'] = $_POST["episodeNum"];
$_SESSION['airDate'] = $_POST["airDate"];

$mediaid = $_GET['mediaid'];

if (!SessionManager::isUserLogged()) {
    $_SESSION['error-message-episode'] = "Devi prima autenticarti.";
    header("Location: ../php/form_episode.php?mediaid=$mediaid");
    return;
}

// parametri in input: title, description, promoUrl, mediaid, seasonNum, episodeNum, airDate

if (!isset($_POST["titleEpisode"]) || !isset($_POST["description"]) || !isset($_POST["promoUrl"]) || !isset($_POST["mediaid"]) || !isset($_POST["seasonNum"]) || !isset($_POST["episodeNum"]) || !isset($_POST["airDate"]) ) {
    $_SESSION['error-message-episode'] = "Parametri mancanti.";
    header("Location: ../php/form_episode.php?mediaid=$mediaid");
    return;
}

$episode = new Episode();
$episode->title = $_POST["titleEpisode"];
$episode->description = $_POST["description"];
$episode->promoUrl = Utils::convert_url_to_embedded($_POST["promoUrl"]);
$episode->mediaId = $_POST["mediaid"];
$episode->seasonNum = $_POST["seasonNum"];
$episode->episodeNum = $_POST["episodeNum"];
$episode->airDate = $_POST["airDate"];

$episode->saveInDB();
echo "TODO: redirect based on result";

?>