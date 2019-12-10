<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");



$output = file_get_contents("../html/layout.html");
$dbMan = DBManager::getInstance();


// <form> logic
if (isset($_POST["search"])) {
    $varSearch = $_POST["search"];
    $varReturnSearch = research('%'.$varSearch.'%');
} else {
    $varSearch = '';
    $varReturnSearch = '';
}


$userLogged = false;

if($userLogged) {
    $output = str_replace($registrazionePage, $logOutAction, $signup);
}

$registrazionePage = '"./registrazione.php"';
$logOutAction = '$logOut';
$signup = '<a id="sign-up" class="font-size-0-75 font-weight-light" href="./registrazione.php">';
$logout = str_replace($registrazionePage, $logOutAction, $signup);

function research($input) {
    $dbMan = DBManager::getInstance();
    if ($input) {
        $result = $dbMan->query("SELECT * FROM Media WHERE Media.name LIKE '$input'");
    }
    return $result;
}

$homePage = file_get_contents("../html/home.html");
$output = str_replace("{homePage}", $homePage, $output);

include_once("./home.php");

echo $output;
?>
