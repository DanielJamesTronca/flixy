<?php
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

// IS USER LOGGED? 

if (!SessionManager::isUserLogged()) {
    echo "Error, no user logged";
    return;
}

if (!isset($_POST["message"])) {
    echo "Error, Missing comment";
    return;
}

$content = $_POST["message"];
if (!(isset($content) && !empty($content))) {
    echo "Error, invalid comment";
    return;
}

// SAVE COMMENT
$userId = SessionManager::getUserId();
$movieId=$_POST["movieId"];

Comment::createComment($userId,$movieId,htmlentities($content, ENT_QUOTES)); 

header("Location: ".SessionManager::BASE_URL."dettaglio"."&movieId=".$movieId);



?>

