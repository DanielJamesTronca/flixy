<?php
session_start();

include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

// define session variables and set to empty values
$_SESSION['login'] = false; //non loggato di default
$_SESSION['error-message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST["username"];
  $password = $_POST["password"];
  $_SESSION['username'] = $username;

  if (checkParameters($username, $password, $errorMessage)) // se true, i dati sono nel formato corretto, provo ad autentificare l'utente
  {
    $man = DBManager::getInstance();
    if ($man->login($username, $password)) // se loggato
    {
      $_SESSION['login'] = true;
      userLoggedCorrectly(); 
    } else {
      $_SESSION['error-message'] = "Le tue credenziali non sono valide";
      header("Location: ../php/login.php");
    }
  }
  else{
    header("Location: ../php/login.php");
  }

}

function checkParameters($username, $password, &$errorMessage) // controlla il formato dei dati e ritorna true se sono corretti, altrimenti ritorna false e setta le stringhe di errore nella variabile errormessage
{
	if (empty($username)) {
	  $_SESSION['error-message'] .= " L'username è richiesto! ";
		return false;
  }
  else if(!preg_match("/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/",$username)){
    $_SESSION['error-message'] .= " Controlla l'username! Il campo non può essere composto da caratteri speciali. ";
		return false;
  } 
	if (empty($password)) {
		$_SESSION['error-message'] .= " La password è richiesta! ";
		return false;
  }
  else if(!preg_match("/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!.@#$%^&*]{6,32}$/",$password)){
    $_SESSION['error-message'] .= " Controlla la password! Dev'essere alfanumerica ed essere composta da almeno 6 caratteri. ";
    return false;
  }
	return true;
}

function logUser($username, $password)
{		
	// ask db manager if user credentials are correct
	return false;
}

function userLoggedCorrectly()
{
	// redirect to home (and save session data and bla blah)
	header("Location: /index.php");
}

?>
