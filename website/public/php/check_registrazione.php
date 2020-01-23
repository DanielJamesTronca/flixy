<?php
include_once("../../src/session_manager.php");
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

// define variables and set to empty values
$_SESSION['registration'] = false; //non registrato di default
$_SESSION['error-message'] = "";
$username = "";
$name = "";
$surname = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
	$username = $_POST["username"];
    $password = $_POST["password"];
    $confirmationPassword = $_POST["confirmationPassword"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    $_SESSION['email'] = $email;
   
    
  if (checkParameters($username, $password, $confirmationPassword, $name, $surname, $email, $errorMessage)) // se true, i dati sono nel formato corretto, provo ad autentificare l'utente
  {
    $man = DBManager::getInstance();
    $reg = $man->register($username, $password, $name, $surname, $email);
    if ($reg!=false) // se registrato correttamente
    {
      $_SESSION['registration'] = true;
      SessionManager::startSessionForUser($reg, $username, false);
      userRegisteredCorrectly();
    } else {
      $_SESSION['error-message'] = "Le tue credenziali non sono valide";
    }
  }
  else{
    header("Location: ../php/registrazione.php");
  }

}

function checkParameters($username, $password, $confirmationPassword, $name, $surname, $email, &$errorMessage) // controlla il formato dei dati e ritorna true se sono corretti, altrimenti ritorna false e setta le stringhe di errore nella variabile errormessage
{
	if (empty($username)) {
	  $_SESSION['error-message'] .= " L'username è richiesto! ";
		return false;
  }
  else if(!preg_match("/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/",$username)){
    $_SESSION['error-message'] .= " Controlla l'username! Il campo non può essere composto da caratteri speciali. ";
		return false;
  } 
  if (empty($name)) {
		$_SESSION['error-message'] .= " Il nome è richiesto! ";
		return false;
  }
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$name)){
    $_SESSION['error-message'] .= " Controlla il Nome! Il campo dev'essere composto solamente da lettere. ";
		return false;
  }
  if (empty($surname)) {
		$_SESSION['error-message'] .= " Il cognome è richiesto! ";
		return false;
  } 
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$surname)){
    $_SESSION['error-message'] .= " Controlla il Cognome! Il campo dev'essere composto solamente da lettere. ";
		return false;
  }
	if (empty($email)) {
		$_SESSION['error-message'] .= " L'email è richiesta! ";
		return false;
  }
  else if(!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",$email)){
    $_SESSION['error-message'] .= " Controlla l'email! Il campo non rispetta la sintassi corretta. ";
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

  if (empty($confirmationPassword)) {
		$_SESSION['error-message'] .= " La password di conferma è richiesta! ";
    return false;
  }
  else if($confirmationPassword!=$password){
		$_SESSION['error-message'] .= " La password di conferma è diversa dalla password! ";
		return false;
	} 

	return true;
}

function RegUser($username, $password, $confirmationPassword, $name, $surname, $email)
{		
	// ask db manager to create a new account
	return false;
}

function userRegisteredCorrectly()
{
	// redirect to home (and save session data and bla blah)
	header("Location: ".SessionManager::BASE_URL."home");
}

?>


