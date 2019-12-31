<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$_SESSION['error-message-feed'] = "";
$_SESSION['content'] = $_POST["content"];
$_SESSION['subtitle'] = $_POST["subtitle"];
$_SESSION['eventDate'] = $_POST["eventDate"];
$_SESSION['videoUrl'] = $_POST["videoUrl"];
$_SESSION['mediaid'] = $_POST["mediaid"];

if (!SessionManager::isUserLogged()) {
    $_SESSION['error-message-feed'] = "Devi prima autenticarti.";
    header("Location: ../php/form_feed.php");
    return;
}

// parametri in input: content, subtitle, mediaid, videoUrl, eventDate

if (!isset($_POST["content"]) || !isset($_POST["subtitle"]) || !isset($_POST["mediaid"]) || (isset($_POST["videoUrl"]) && !Utils::isValidUrl($_POST["videoUrl"])) || !isset($_POST["eventDate"])) {
    $_SESSION['error-message-feed'] = "Parametri mancanti: si prega di compilare tutti i campi.";
    header("Location: ../php/form_feed.php");
    return;
}

$episode = new Feed();
$episode->content = $_POST["content"];
$episode->subtitle = $_POST["subtitle"];
$episode->mediaId = $_POST["mediaid"];
$episode->authorId = SessionManager::getUserId();
$episode->eventDate = $_POST["eventDate"];
if (isset($_POST["videoUrl"]))
    $episode->videoUrl = Utils::convert_url_to_embed($_POST["videoUrl"]);


$episode->saveInDB();
echo "TODO: redirect based on result";

?>