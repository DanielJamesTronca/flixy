<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

if (!SessionManager::isUserLogged() && !SessionManager::userCanPublish()) {
    echo "Error, no user logged";
    return;
}

if (!isset($_POST["object"]) || !isset($_POST["id"])) {
    echo "Error, Missing parameters";
    return;
}
$className = $_POST["object"];
$id = $_POST["id"];
if ($className != "Media" && $className != "Episode" && $className != "Feed") {
    echo "Invalid object";
    return;
}

$dbman = DBManager::getInstance();
return $dbman->deleteObject($id, $className);

?>