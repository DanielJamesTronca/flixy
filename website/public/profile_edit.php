<?php
include_once("../src/controllers/utils.php");
include_once("../src/session_manager.php");
include_once("../src/db_manager.php");
include_once("../src/models/models.php");

// this controller is the target of the update user form action
if (!SessionManager::isUserLogged()) {
    echo "Error, no user logged";
    return;
}

// paremeters to get: name, surname, email, avatar(image)
if (!isset($_POST["name"]) || !isset($_POST["surname"]) || !isset($_POST["email"])) {
    echo "Error, Missing parameters";
    return;
}

$name = $_POST["name"]; $surname = $_POST["surname"]; $email = $_POST["email"];
if (!(isset($name) && !empty($name))) {
    echo "Error, invalid name";
    return;
}
if (!(isset($surname) && !empty($surname))) {
    echo "Error, invalid surname";
    return;
}
if (!(isset($email) && !empty($email) && Utils::is_email($email))) {
    echo "Error, invalid email";
    return;
}

// good to go on these parameters, now check image upload
$target_dir = "assets/images/avatars/";
if (isset($_FILES["avatar"])) {
    $upload_result = Utils::uploadImage($target_dir, $_FILES["avatar"]);
    if ($upload_result["success"] === false) {
        echo $upload_result["error"];
        return;
    }
    $user->avatarUrl = $upload_result["url"];
}

// now save user data
$userId = SessionManager::getUserId();
$user = User::getUser($userId);
$user->name = $name;
$user->surname = $surname;
$user->email = $email;

$user->saveUser();

header("Location: ".SessionManager::BASE_URL."profilo");

?>