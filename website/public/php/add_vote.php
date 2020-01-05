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
    echo "Utente non autenticato";
}

if (isset($_POST["redirectURL"]) && isset($_POST["mediaID"]) && isset($_POST["vote"])) {
    $redirectURL = $_POST["redirectURL"];
    $mediaID = $_POST["mediaID"];
    $vote = $_POST["vote"];
    
    switch ($vote) {
        case "like":
            Media::addVote($userId, $mediaID, 1);
        break;
        case "dislike":
            Media::addVote($userId, $mediaID, 0);
        break;
    }

    
    header("Location: ".SessionManager::BASE_URL.$redirectURL);
} else {
    echo "Parametri incorretti";
}

?>