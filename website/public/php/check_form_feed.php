<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$_SESSION['error-message-news'] = "";
$_SESSION['content'] = $_POST["content"];
$_SESSION['subtitle'] = $_POST["subtitle"];
$_SESSION['eventDate'] = $_POST["eventDate"];
$_SESSION['videoUrl'] = $_POST["videoUrl"];
$_SESSION['mediaid'] = $_POST["mediaid"];

if (!SessionManager::isUserLogged()) {
    $_SESSION['error-message'] = "Devi prima autenticarti.";
    header("Location: ../php/form_feed.php");
}

// parametri in input: content, subtitle, mediaid, videoUrl, eventDate

if (!isset($_POST["content"]) || !isset($_POST["subtitle"]) || !isset($_POST["mediaid"]) || !isset($_POST["videoUrl"]) || !isset($_POST["eventDate"])) {
    $_SESSION['error-message-news'] = "Parametri mancanti.";
    header("Location: ../php/form_feed.php");
}

$episode = new Feed();
$episode->content = $_POST["content"];
$episode->subtitle = $_POST["subtitle"];
$episode->mediaId = $_POST["mediaid"];
$episode->authorId = SessionManager::getUserId();
$episode->eventDate = $_POST["eventDate"];
$episode->videoUrl = $_POST["videoUrl"];


$episode->saveInDB();
echo "TODO: redirect based on result";

?>