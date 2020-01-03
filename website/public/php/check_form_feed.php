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
$_SESSION['day'] = $_POST["day"];
$_SESSION['month'] = $_POST["month"];
$_SESSION['year'] = $_POST["year"];

if (!SessionManager::isUserLogged()) {
    $_SESSION['error-message-feed'] = "devi prima autenticarti.";
    header("Location: ../php/form_feed.php");
    return;
}

// parametri in input: content, subtitle, mediaid, videoUrl, eventDate

if (!isset($_POST["content"]) || !isset($_POST["subtitle"]) || !isset($_POST["mediaid"]) || (isset($_POST["videoUrl"]) && !Utils::isValidUrl($_POST["videoUrl"]))) {
    $_SESSION['error-message-feed'] = "si prega di compilare tutti i campi.";
    header("Location: ../php/form_feed.php");
    return;
}

if ($_POST["videoUrl"]!="" && !Utils::isValidUrl($_POST["videoUrl"])) {
    $_SESSION['error-message-feed'] = "si prega di inserire un link video valido. Il parametro è opzionale.";
    header("Location: ../php/form_feed.php");
    return;
}

if(!Utils::isValidDate($_POST["day"],$_POST["month"],$_POST["year"])){
    $_SESSION['error-message-feed'] = "si prega di inserire una data di rilascio valida.";
    header("Location: ../php/form_feed.php");
    return;
}
/* END check if all paramters are ok */

$episode = new Feed();
$episode->content = $_POST["content"];
$episode->subtitle = $_POST["subtitle"];
$episode->mediaId = $_POST["mediaid"];
$episode->authorId = SessionManager::getUserId();
$episode->eventDate = Utils::createDate($_POST["day"],$_POST["month"],$_POST["year"]);
if (isset($_POST["videoUrl"]))
    $episode->videoUrl = Utils::convert_url_to_embed($_POST["videoUrl"]);


$episode->saveInDB();
Utils::unsetAll(array('error-message-feed','content','subtitle','eventDate','videoUrl','mediaid','day','month','year'));
echo "TODO: redirect based on result";

?>