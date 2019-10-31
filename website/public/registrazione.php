<?php
session_start();

include_once("../src/db_manager.php");
include_once("../src/models/models.php");

// define variables and set to empty values
$errorMessage = "";
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
   
    
  if (checkParameters($username, $password, $confirmationPassword, $name, $surname, $email, $errorMessage)) // se true, i dati sono nel formato corretto, provo ad autentificare l'utente
  {
    $man = DBManager::getInstance();
    if ($man->register($username, $password, $name, $surname, $email)) // se registrato correttamente
    {
        userRegisteredCorrectly();
    } else {
      $errorMessage = "Le tue credenziali non sono valide";
    }
  }

}

function checkParameters($username, $password, $confirmationPassword, $name, $surname, $email, &$errorMessage) // controlla il formato dei dati e ritorna true se sono corretti, altrimenti ritorna false e setta le stringhe di errore nella variabile errormessage
{
	if (empty($username)) {
	  $errorMessage .= " L'username è richiesto! ";
		return false;
  }
  else if(!preg_match("/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/",$username)){
    $errorMessage .= " Controlla l'username! Il campo non può essere composto da caratteri speciali. ";
		return false;
  } 
  if (empty($name)) {
		$errorMessage .= " Il nome è richiesto! ";
		return false;
  }
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$name)){
    $errorMessage .= " Controlla il Nome! Il campo dev'essere composto solamente da lettere. ";
		return false;
  }
  if (empty($surname)) {
		$errorMessage .= " Il cognome è richiesto! ";
		return false;
  } 
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$surname)){
    $errorMessage .= " Controlla il Cognome! Il campo dev'essere composto solamente da lettere. ";
		return false;
  }
	if (empty($email)) {
		$errorMessage .= " L'email è richiesta! ";
		return false;
  }
  else if(!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",$email)){
    $errorMessage .= " Controlla l'email! Il campo non rispetta la sintassi corretta. ";
		return false;
  }
	if (empty($password)) {
		$errorMessage .= " La password è richiesta! ";
		return false;
  }
  else if(!preg_match("/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!.@#$%^&*]{6,32}$/",$password)){
    $errorMessage .= " Controlla la password! Dev'essere alfanumerica ed essere composta da almeno 6 caratteri. ";
    return false;
  }

  if (empty($confirmationPassword)) {
		$errorMessage .= " La password di conferma è richiesta! ";
    return false;
  }
  else if($confirmationPassword!=$password){
		$errorMessage .= " La password di conferma è diversa dalla password! ";
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
	header("Location: /index.php");
}

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
<base target="_self" href="http://192.168.121.241/flixy/website/public/"> <!--da cambiare!!!! -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"> <!-- per ottimizzazione visualizzazione smartphone -->
<link rel="stylesheet" media="screen" type="text/css" href="assets/style.css"/>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="action.js"></script>

<title>Flixy - Registrazione</title>
<meta name="title" content="Flixy - Registrazione" />
</head>
<body>

<div class="content">

    <div class="header">
        <img src="assets/images/icons/logo.png" alt="logo" class="logo"/> <h1 class="primary-color-gradient-text"> Flixy </h1>

    </div>
             
    <div class="form-title">
        <h1 class="text-center"> Registra un nuovo account </h1>
        <p class="text-center padding-top-small">Creando un nuovo account potrai salvare i tuoi contenuti preferiti ed essere sempre aggiornato</p>
    </div>

    <div class="margin-top-small <?php if (empty($errorMessage)) { echo "hidden"; } ?>">
        <div class="error-message-box">
            <p class="bold">Credenziali invalide</p>
            <p>Controlla le tue credenziali e riprova a fare l’accesso: <?php echo $errorMessage;?> </p>
        </div>
    </div>

    <div class="padding-top-medium">

      <form action="registrazione.php" method="post" id="regForm" onsubmit="return validateFormRegistration()">
          <div class="group">      
            <input type="text" name="username" id="username" value="<?php echo $username;?>"/>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Username</label>
          </div>
          <div class="group">      
            <input type="text" name="name" id="name" value="<?php echo $name;?>"/>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Nome</label>
          </div>
          <div class="group">      
            <input type="text" name="surname" id="surname" value="<?php echo $surname;?>"/>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Cognome</label>
          </div>
          <div class="group">      
            <input type="text" name="email" id="email" value="<?php echo $email;?>"/>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Email</label>
          </div>
          <div class="group">      
            <input type="password" name="password" id="password"/>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Password</label>
          </div>
          <div class="group">      
            <input type="password" name="confirmationPassword" id="confirmationPassword"/>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Ripeti password</label>
          </div>
          
          <div class="content-center">
            <input type="submit" value="Registrati" class="button primary-color-gradient-button"/>
          </div>
         
        </form>
    </div>
                
    <div class="text-center padding-top-medium">
      <p>Hai già un account? <a href="login.php" class="link"> Accedi </a> </p>
    </div>

    <div class="footer text-center">
      <p>Flixy © Un prodotto UNIPD. 2019. All rights reserved.</p>
    </div>
</div>


</body>
</html>

