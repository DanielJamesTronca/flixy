<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$output = file_get_contents("../html/profilo.html");

function console_log ( $data)
{
echo '<script>';
echo 'console.log(' .json_encode($data).')';
echo '</script>';
}

$name="";
$surName="";
$userName="";
$email="";
$avatarUrl="";

$dbMan = DBManager::getInstance();

//if(SessionManager::isUserLogged()){
    //$userId = SessionManager::getUserId();
   
    $userId=2;

    $user=User::getUser($userId);

    

    $name=$user->name;

    $surName=$user->surname;
    $userName=$user->username;
    $avatarUrl=$user->avatarUrl;
    $email=$user->email;
      
    $favoruites=Media::getUserFavourites($userId);
    console_log($favoruites);


    function getFavouriteList($favoruites) {
        $favouriteList = [];
        $y=0;

          for ($x = 0; $x < count($favoruites); $x++) {
          $titolo = $favoruites[$x]->title;
          $url = $favoruites[$x]->coverUrl;
          $genre_card=$favoruites[$x]->genreId;
          
          $aloah=Genre::getNameGenre($genre_card);
          console_log($aloah);

          $finally_genre=$aloah[$y]->name;

           
         
          
          $card = file_get_contents("../html/favourite_card.html");
          $card = str_replace("{favouriteTitle}", $titolo, $card);
          $card = str_replace("{favouriteGenre}",$finally_genre , $card);

         

          $card = str_replace("{favouriteCover}", "../".$url, $card);

      
         
          array_push($favouriteList, $card);
        }
        return implode($favouriteList);
      }


$output = str_replace("{favouriteList}", getFavouriteList($favoruites), $output);



$output=str_replace("{name}", $name,$output);
$output=str_replace("{surname}", $surName,$output);
$output=str_replace("{avatar_url}", "../../public".$avatarUrl,$output);


$output=str_replace("{email}", $email,$output);
$output=str_replace("{username}",$userName,$output);





echo $output;

?>










