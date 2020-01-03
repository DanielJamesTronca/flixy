<?php

include_once("../../src/controllers/utils.php");
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$_SESSION['error-message-episode'] = "";
$_SESSION['title'] = $_POST["titleEpisode"];
$_SESSION['description'] = $_POST["description"];
$_SESSION['promoUrl'] = $_POST["promoUrl"];
$_SESSION['seasonNum'] = $_POST["seasonNum"];
$_SESSION['episodeNum'] = $_POST["episodeNum"];
$_SESSION['day'] = $_POST["day"];
$_SESSION['month'] = $_POST["month"];
$_SESSION['year'] = $_POST["year"];

if(isset($_GET['mediaid']))
    $mediaid = $_GET['mediaid'];
else
    $mediaid = NULL;

if (!SessionManager::isUserLogged()) {
    $_SESSION['error-message-episode'] = "devi prima autenticarti.";
    header("Location: ../php/form_episode.php?mediaid=$mediaid");
    return;
}

/* START check if all paramters are ok */
if (!isset($_POST["titleEpisode"]) || !isset($_POST["description"]) || !isset($_GET["mediaid"]) || !isset($_POST["seasonNum"]) || !isset($_POST["episodeNum"])){

    $_SESSION['error-message-episode'] = "si prega di compilare tutti i campi.";
    header("Location: ../php/form_episode.php?mediaid=$mediaid");
    return;
}

if ($_POST["promoUrl"]!="" && !Utils::isValidUrl($_POST["promoUrl"])) {
    $_SESSION['error-message-episode'] = "si prega di inserire un link video valido. Il parametro è opzionale.";
    header("Location: ../php/form_episode.php?mediaid=$mediaid");
    return;
}

if(!Utils::isValidDate($_POST["day"],$_POST["month"],$_POST["year"])){
    $_SESSION['error-message-episode'] = "si prega di inserire una data di rilascio valida.";
    header("Location: ../php/form_episode.php?mediaid=$mediaid");
    return;
}
/* END check if all paramters are ok */


// good to go on these parameters, now upload them to db
$episode = new Episode();
$episode->title = $_POST["titleEpisode"];
$episode->description = $_POST["description"];
$episode->mediaId = $_GET["mediaid"];
$episode->seasonNum = $_POST["seasonNum"];
$episode->episodeNum = $_POST["episodeNum"];
$episode->airDate = Utils::createDate($_POST["day"],$_POST["month"],$_POST["year"]);

if (isset($_POST["promoUrl"]))
    $episode->promoUrl = Utils::convert_url_to_embed($_POST["promoUrl"]);

$episode->saveInDB();

Utils::unsetAll(array('error-message-episode','title','description','promoUrl','seasonNum','episodeNum','day','month','year'));
header("Location: ".SessionManager::BASE_URL."dettaglio&movieId=".$mediaid);
return;


?>