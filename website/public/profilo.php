<?php
session_start();
include_once("../src/db_manager.php");
include_once("../src/models/models.php");
// define variables and set to empty values
$errorMessage = "";
$name = "";
$surname = "";
$email = "";
$username = "";

$title= "";
$favourite=[];

// ----------------------------- LEFT VALIDATION FORM ----------------------------- 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
   
    
  if (checkParameters($name, $surname, $email, $username, $errorMessage)) // se true, i dati sono nel formato corretto, provo ad autentificare l'utente
  {
    $man = DBManager::getInstance();
    if ($man->register($username, $name, $surname, $email)) // se registrato correttamente
    {
        userChangedCorrectly();   // TO DO 
        DBManager::saveUser();
    } else {
      $errorMessage = "Le tue credenziali non sono valide";
    }
  }
}

function checkParameters($username, $name, $surname, $email, &$errorMessage) // controlla il formato dei dati e ritorna true se sono corretti, altrimenti ritorna false e setta le stringhe di errore nella variabile errormessage
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
	return true;
}
function RegUser($username, $name, $surname, $email)
{		
	// ask db manager to create a new account
	return false;
}
function userRegisteredCorrectly()
{
    // redirect to profile page with new data (and save session data and bla blah)
    
    //TO DO
	
}


// ----------------------------- FAVORUITES  ----------------------------- 



$man = DBManager::getInstance();
$favourites=$man->getUserFavourites(1);




?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">


<head>
<base target="_self" href="http://localhost/flixy/website/public/"> <!--da cambiare!!!! -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"> <!-- per ottimizzazione visualizzazione smartphone -->
<link rel="stylesheet" media="screen" type="text/css" href="prova.css"/>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="action.js"></script>
<title>Flixy - Profilo</title>
<meta name="title" content="Flixy - Profilo" />
</head>


<body>
<!-- The flexible grid (content) -->
<div class="row">
  <div class="side">
    
        <!-- AVATAR -->
        <div id="avatar"></div>
          <a href="registrazione.html" class="link"> Cambia immagine profilo </a> 

        <div class="margin-top-small <?php if (empty($errorMessage)) { echo "hidden"; } ?>">
            <div class="error-message-box">
                <p class="bold">Credenziali invalide</p>
                <p>Controlla le tue credenziali e riprova a fare l’accesso: <?php echo $errorMessage;?> </p>
            </div>
        </div>
       
        <!-- CAMPI -->
        <form action="registrazione.php" method="post" id="regForm" onsubmit="return validateFormRegistration()">
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
              <input type="text" name="username" id="username" value="<?php echo $username;?>"/>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label>Username</label>
            </div>
        </form>

        <!-- AGGIORNA PROFILO -->
    <div class="content-center">
      <input type="submit" value="Aggiorna profilo" class="button primary-color-gradient-button"/>
    </div>
    


  </div>
    <div class="main">
      <h2>Your favourites</h2>
        <?php
            for($x=0; $x<count($favourite); $x++){
            $url = $favourite[$x]->cover_url;
            $nome = $favourite[$x]->name;
            $genere =$favourite[$x]->genre;
            include('"./components/favourite_card.php"');
        }
        ?>
    </div>
</div>


</body>
</html>