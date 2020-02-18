<?php
// redirectURL -> url a cui redirecto dopo l'aggiornamento
// mediaID -> id del media
// pos -> true/false stato preferenza
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$userId = null;
if (SessionManager::isUserLogged()) {
    $userId = SessionManager::getUserId();
} else {
    // Utente non autenticato
    header("Location: ./login.php");
    return;
}

if (isset($_POST["redirectURL"]) && isset($_POST["movieID"]) && isset($_POST["vote"])) {
    $redirectURL = $_POST["redirectURL"];
    $mediaID = $_POST["movieID"];
    $vote = $_POST["vote"];

    $media = Media::fetch($mediaID);
    switch ($vote) {
        case "like":
            $media->addVote($userId, $mediaID, 1);
        break;
        case "dislike":
            $media->addVote($userId, $mediaID, 0);
        break;
    }

    header("Location: ".SessionManager::BASE_URL.$redirectURL);
} else {
    echo "Parametri incorretti";
}

?>