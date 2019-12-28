<?php
<<<<<<< Updated upstream
$output = file_get_contents("../html/login.html");
if(!isset($_SESSION))
  session_start();
if(isset($_SESSION['login']) && !$_SESSION['login']) {
    $output = str_replace("<div class='margin-top-small hidden'>","<div class='margin-top-small'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message'],$output);
    session_destroy();
=======
session_start();

include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

// define variables and set to empty values
$errorMessage = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = $_POST["username"];
	$password = $_POST["password"];

  if (checkParameters($username, $password, $errorMessage)) // se true, i dati sono nel formato corretto, provo ad autentificare l'utente
  {
    $man = DBManager::getInstance();
    if ($man->login($username, $password)) // se loggato
    {
        userLoggedCorrectly();
    } else {
      $errorMessage = "Le tue credenziali non sono valide";
    }
  }

>>>>>>> Stashed changes
}
if (isset($_SESSION['username'])){
    $output = str_replace("'{username}'",$_SESSION['username'],$output);
}
else{
    $output = str_replace("'{username}'","",$output);
}
echo $output;
?>