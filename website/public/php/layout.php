<?php
include_once ("../../src/db_manager.php");
include_once ("../../src/models/models.php");
include_once ("../../src/session_manager.php");
include_once ("./utils.php");

$output = file_get_contents("../html/layout.html");
$dbMan = DBManager::getInstance();

$username = "";
$profile = "profile" . $username;
if (SessionManager::isUserLogged())
{
    $username = SessionManager::getUsername();
}
if ($username != "")
{
    $user = User::getUser(SessionManager::getUserId());
    
    $output = str_replace("{linkToFavs}", "./php/layout.php?page=profilo", $output);
    $output = str_replace("{link_to_profile_or_log_in}", $profile, $output);
    $output = str_replace("{login_O_username}", $user->name." ".$user->surname, $output);
    $output = str_replace("{link_to_log_out_or_register}", "Logout", $output);
    $output = str_replace("{logout_O_registrazione}", "Logout", $output);
    $output = str_replace("{profile_photo_url}", $user->avatarUrl, $output);
}
else
{
    $output = str_replace("{linkToFavs}", "./php/registrazione.php", $output);
    $output = str_replace("{link_to_profile_or_log_in}", "./php/login.php", $output);
    $output = str_replace("{login_O_username}", "Log in", $output);
    $output = str_replace("{link_to_log_out_or_register}", "./php/registrazione.php", $output);
    $output = str_replace("{logout_O_registrazione}", "Registrati", $output);
    $output = str_replace("{profile_photo_url}", "../public/assets/images/avatars/default.png", $output);
}

// <form> logic
if (isset($_GET["search"]))
{
    $varSearch = $_GET["search"];
    $varReturnSearch = research('%' . $varSearch . '%');
}
else
{
    $varSearch = '';
    $varReturnSearch = '';
}

$registrazionePage = '"./php/registrazione.php"';
$logOutAction = '$logOut';
$signup = '<a id="sign-up" class="font-size-0-75 font-weight-light" href="./php/registrazione.php">';
$logout = str_replace($registrazionePage, $logOutAction, $signup);


$output = str_replace("{linkToFeed}", "./php/layout.php?page=feed", $output);
$output = str_replace("{linkToFavs}", "./php/layout.php?page=profilo", $output);
$output = str_replace("{linkToTrending}", "./php/layout.php?page=home&amp;getMovies=trending", $output);

switch ($_GET['page'])
{
    case 'home':
        $homepage = file_get_contents("../html/home.html");
        $output = str_replace("{contentLayout}", "", $output);
        $output = str_replace("{content}", $homepage, $output);
        include_once ("./home.php");
    break;

    case 'feed':
        $feed = file_get_contents("../html/feed.html");
        $output = str_replace("{contentLayout}", "id='content-layout'", $output);
        $output = str_replace("{content}", $feed, $output);
        include_once ("./feed.php");
    break;

    case 'profilo':
        $profilo = file_get_contents("../html/profilo.html");
        $output = str_replace("{contentLayout}", "id='content-layout'", $output);
        $output = str_replace("{content}", $profilo, $output);
        include_once ("./profilo.php");
    break;

    case 'dettaglio':
        $dettaglio = file_get_contents("../html/dettaglio.html");
        $output = str_replace("{contentLayout}", "id='content-layout'", $output);
        $output = str_replace("{content}", $dettaglio, $output);
        include_once ("./dettaglio.php");
    break;

    case 'formmedia':
        $page = file_get_contents("../html/form-media.html");
        $output = str_replace("{contentLayout}", "id='content-layout'", $output);
        $output = str_replace("{content}", $page, $output);
        include_once ("./form_media.php");
    break;

    case 'formepisode':
        $page = file_get_contents("../html/form-episode.html");
        $output = str_replace("{contentLayout}", "id='content-layout'", $output);
        $output = str_replace("{content}", $page, $output);
        include_once ("./form_episode.php");
    break;

    case 'formfeed':
        $page = file_get_contents("../html/form-feed.html");
        $output = str_replace("{contentLayout}", "id='content-layout'", $output);
        $output = str_replace("{content}", $page, $output);
        include_once ("./form_feed.php");
    break;
}

echo $output;
?>
