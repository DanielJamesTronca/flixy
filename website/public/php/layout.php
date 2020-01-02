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
    $output = str_replace("{link_to_profile_or_log_in}", $profile, $output);
    $output = str_replace("{login_O_username}", $username, $output);
    $output = str_replace("{link_to_log_out_or_register}", "Logout", $output);
    $output = str_replace("{logout_O_registrazione}", "Logout", $output);
}
else
{
    $output = str_replace("{link_to_profile_or_log_in}", "./php/login.php", $output);
    $output = str_replace("{login_O_username}", "Log in", $output);
    $output = str_replace("{link_to_log_out_or_register}", "./php/registrazione.php", $output);
    $output = str_replace("{logout_O_registrazione}", "Registrati", $output);
    $output = str_replace("{profile_photo_url}", "../public/assets/images/avatars/default.png", $output);
}

// <form> logic
if (isset($_POST["search"]))
{
    $varSearch = $_POST["search"];
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

switch ($_GET['page'])
{
    case 'home':
        $homepage = file_get_contents("../html/home.html");
        $output = str_replace("{content}", $homepage, $output);
        include_once ("./home.php");
    break;

    case 'feed':
        $feed = file_get_contents("../html/feed.html");
        $output = str_replace("{content}", $feed, $output);
        include_once ("./feed.php");
    break;

    case 'profilo':
        $profilo = file_get_contents("../html/profilo.html");
        $output = str_replace("{content}", $profilo, $output);
        include_once ("./profilo.php");
    break;

    case 'dettaglio':
        $dettaglio = file_get_contents("../html/dettaglio.html");
        $output = str_replace("{content}", $dettaglio, $output);
        include_once ("./dettaglio.php");
    break;
}

echo $output;
?>
