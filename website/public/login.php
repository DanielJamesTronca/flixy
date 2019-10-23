<?php
session_start();

include_once("../src/db_manager.php");
include_once("../src/models/models.php");

// define variables and set to empty values
$errorMessage = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = $_POST["username"];
	$password = $_POST["password"];

  if (checkParameters($username, $password, $errorMessage)) // se false, i dati sono nel formato corretto, provo ad autentificare l'utente
  {
    $man = DBManager::getInstance();
    if ($man->login($username, $password)) // se loggato
    {
        userLoggedCorrectly();
    } else {
      $errorMessage = "Le tue credenziali non sono valide";
    }
  }

}

function checkParameters($username, $password, &$errorMessage) // controlla il formato dei dati e ritorna true se sono corretti, altrimenti ritorna false e setta le stringhe di errore nella variabile errormessage
{
	if (empty($username)) {
		$errorMessage .= " L'username è richiesto! ";
		return false;
	} 
	else if (empty($password)) {
		$errorMessage .= " La password è richiesta! ";
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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
<base target="_self" href="http://localhost/flixy/website/public/">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="assets/style.css"/>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="action.js"></script>

<title>Flixy - Login</title>
<meta name="title" content="Flixy - Login" />
</head>
<body>

<div class="content">

    <div class="header">
        <img src="assets/images/icons/logo.png" alt="Flixy logo" class="logo"/> <h1 class="primary-color-gradient-text"> Flixy </h1>

    </div>
             
    <div class="form-title">
        <h1 class="text-center"> Accedi al tuo account </h1>
        <p class="text-center padding-top-small">Inserisci il tuo username e password per accedere ai contenuti associati al tuo account</p>
    </div>

    <div class="margin-top-small <?php if (empty($errorMessage)) { echo "hidden"; } ?>">
        <div class="error-message-box">
            <p class="bold">Credenziali invalide</p>
            <p>Controlla le tue credenziali e riprova a fare l’accesso: <?php echo $errorMessage;?></p>
        </div>
    </div>


    <div class="padding-top-medium">

        <form action="login.php" method="POST">
            <div class="group">      
              <input type="text" name="username" value="<?php echo $username;?>"/>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label>Username</label>
            </div>


            <div class="group">      
              <input type="password" name="password"/>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label>Password</label>
            </div>

            
            <div class="content-center">
              <input type="submit" value="Login" class="button primary-color-gradient-button"/>
            </div>
         
        </form>
    </div>
                
    <div class="text-center padding-top-medium">
      <p>Non hai un account? <a href="registrazione.html" class="link"> Registrati </a> </p>
    </div>

    <div class="footer text-center">
      <p>Flixy © Un prodotto UNIPD. 2019. All rights reserved.</p>
    </div>
</div>


</body>
</html>
