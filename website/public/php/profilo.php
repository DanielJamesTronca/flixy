<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$name="";
$surName="";
$userName="";
$email="";
$avatarUrl="";

$dbMan = DBManager::getInstance();

if(!SessionManager::isUserLogged()){
  header("Location: ".SessionManager::BASE_URL."home");
}

$userId = null;
$userId = SessionManager::getUserId();
$user=User::getUser($userId);

$output=str_replace("{name}", $user->name,$output);
$output=str_replace("{surname}", $user->surname,$output);
$output=str_replace("{avatar_url}", "../public/".$user->avatarUrl,$output);
$output=str_replace("{email}", $user->email,$output);
$output=str_replace("{username}",$user->username,$output);
  

$favourites=Media::getUserFavourites($userId);

function getFavouriteList($favourites) {
  $favouriteList = [];
  $y=0;

  for ($x = 0; $x < count($favourites); $x++) {
    
    $titolo = $favourites[$x]->title;
    $url = $favourites[$x]->coverUrl;
    $genre_card=$favourites[$x]->genreId;
    $media_id=$favourites[$x]->id;
    $fav=$favourites[$x]->isFavourite;
    if($fav==null){
      $fav==true;
    }
    else{
      $fav=false;
    }

    $genre_name=Genre::getNameGenre($genre_card);

    $card = file_get_contents("../html/favourite_card.html");
    
    $card = str_replace("{mediaNFav}", !($fav == false) ? "" : "hidden", $card);
    $card = str_replace("{mediaFav}", ($fav == false) ? "" : "hidden", $card);

    $finally_genre=$genre_name[$y]->name;
    $card = str_replace("{linkMovieFavourite}", "./php/layout.php?page=dettaglio&amp;movieId=".$media_id , $card);

    $card = str_replace("{mediaid}", $media_id, $card);
    $card = str_replace("{favouriteTitle}", $titolo, $card);
    $card = str_replace("{favouriteGenre}",$finally_genre , $card);
    $card = str_replace("{favouriteCover}", "../public/".$url, $card);
  
    array_push($favouriteList, $card);
  }
  return implode($favouriteList);
}
if (getFavouriteList($favourites)!=null)
  $output = str_replace("{favouriteList}", getFavouriteList($favourites), $output);
else
  $output = str_replace("{favouriteList}", "Non hai preferiti al momento. Aggiungi dei contenuti ai preferiti per visualizzarli qui!", $output);
?>