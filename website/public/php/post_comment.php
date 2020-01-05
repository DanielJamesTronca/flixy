<?php
include_once("../src/controllers/utils.php");
include_once("../src/session_manager.php");
include_once("../src/db_manager.php");
include_once("../src/models/models.php");

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
$user = User::getUser($userId);
$movieId=$_GET["movieId"];

$comment->user_id=$user;
$comment->media_id=$movieId;
$comment->content=$comment;



/*
$user->name = $name;
$user->surname = $surname;
$user->email = $email;
*/


//MISSING GET COMMENT

/* getComment  -> createComment($user,$movieId,$comment); */

header("Location: ".SessionManager::BASE_URL."dettaglio");



?>

