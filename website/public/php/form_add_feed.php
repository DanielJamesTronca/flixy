<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

if (!SessionManager::isUserLogged()) {
    echo "Error, no user logged";
    return;
}

// parametri in input: content, subtitle, mediaid, videoUrl, eventDate

if (!isset($_POST["content"]) || !isset($_POST["subtitle"]) || !isset($_POST["mediaid"]) || !isset($_POST["videoUrl"]) || !isset($_POST["eventDate"])) {
    echo "Error, Missing parameters";
    return;
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