<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$title="";
$genre="None";
$duration="0";
$cover_url="None";
$description="None";
$season="/";
$episode="/";
$trailer_url="None";
$stars="0";

$serieTvEpisode="";
$serieTvEpisodeReal="Episodes:";
$serieTvSeason="";
$serieTvSeasonReal="Season:";

$dbMan = DBManager::getInstance();

function loadInfo($id){
  $dbMan = DBManager::getInstance();
  $numeroStelle=[];
  $list=Media::fetch($id);
  $title=$list->title;
  $duration=$list->duration;
  $cover_url=$list->coverUrl;
  $description=$list->description;
  $episode=$list->numEpisodes;
  $season=$list->numSeasons;
  $trailer_url=$list->trailerUrl;
  $stars=$list->stars;
  $genre=$list->genreName;

  for($i=0;$i<$stars;$i++) {
    array_push($numeroStelle, "<i class='fa fa-star'></i>");
  }

  $arr=array($title,$duration, $cover_url, $description, $episode, $season, $trailer_url, $numeroStelle, $genre, $list->votesPositive, $list->votesTotal, $list->genreId);
  return $arr;
}


$movieId=$_GET["movieId"];

$lista= loadInfo($movieId);  
$likes= $lista[9];

$title=$lista[0];
$duration=$lista[1];
$cover_url=$lista[2];
$description=$lista[3];
$episode=$lista[4];
$season=$lista[5];
$trailer_url=$lista[6];
$numeroStelle=$lista[7];
$genre=$lista[8];
$genre_aux=$genre;

if($episode==null && $season==null){
  $output=str_replace("{serieTvEpisode}", $serieTvEpisode,$output);
  $output=str_replace("{serieTvSeason}", $serieTvSeason,$output);
}
else { 
  $output=str_replace("{serieTvEpisode}", $serieTvEpisodeReal,$output );
  $output=str_replace("{serieTvSeason}", $serieTvSeasonReal,$output );
}

$actualGenre_aux= $lista[11];
$realGenre= Media::getMediasWithGenre($actualGenre_aux);
$genre_variable=Genre::getNameGenre($actualGenre_aux);


function getSimilarMovies($realGenre, $genre_variable) {
  $movieList = [];
  $y=0;

  for ($x = 0; $x < count($realGenre); $x++) {
    if ($realGenre[$x]->id == $_GET["movieId"]) continue;
    $titolo = $realGenre[$x]->title;
    $url = $realGenre[$x]->coverUrl;
    $genre_card=$genre_variable[$y]->name;

    $card = file_get_contents("../html/similar_content_card.html");
    $card = str_replace("{movieTitle}", $titolo, $card);
    $card = str_replace("{movieGenre}", $genre_card, $card);
    $card = str_replace("{movieCover}", "../public/".$url, $card);
    array_push($movieList, $card);
  }
  return implode($movieList);
}


$comments=Comment::getCommentsFor($movieId);

function getCommentList($comments) {
  $commentList = [];
  $y=0;

  for ($x = 0; $x < count($comments); $x++) {
    
    $contenuto = $comments[$x]->content;
    $nome_commento=$comments[$x]->userFullName;
    $id_to_url=$comments[$x]->userId;

    $id_to_url_aux=Comment::getAvatar($id_to_url);
    $finally_url=$id_to_url_aux[$y]->avatar_url;
    
    $commento = file_get_contents("../html/comment.html");
    $commento = str_replace("{nome_commento}", $nome_commento, $commento);
    $commento = str_replace("{contenuto_commento}", $contenuto, $commento);
    $commento = str_replace("{avatar_url_commento}", "../public/".$finally_url, $commento);

    array_push($commentList, $commento);
  }
  return implode($commentList);
}

/* COMMENTO


if(!SessionManager::isUserLogged()){
  header("Location: ".SessionManager::BASE_URL."home");
}
$userIdentification=null;


function setComments(){
  $userIdentification = SessionManager::getUserId();

  if(isset($_POST['commentSubmit'])){
    $message = $_POST['message'];

    $sql=Comment::createComment($userIdentification, $movieId, $message);
  }
}
*/


$output = str_replace("{commentList}", getCommentList($comments), $output);
$output = str_replace("{movieList}", getSimilarMovies($realGenre, $genre_variable), $output);

$output=str_replace("{likes}", $likes,$output);
$output=str_replace("{dislikes}", $likes,$output);  //DA FARE C'E' LIKES E NON DISLIKES

$output=str_replace("{title}", $title,$output);
$output=str_replace("{media_id}", $movieId,$output);
$output=str_replace("{duration}", $duration,$output);
$output=str_replace("{description}", $description,$output);
$output=str_replace("{episode}", $episode,$output);
$output=str_replace("{season}", $season,$output);
$output=str_replace("{cover_url}", "../public/".$cover_url,$output);
$output=str_replace("{genre}", $genre_aux,$output);
$output=str_replace("{trailer_url}",$trailer_url,$output);
$output=str_replace("{mediaid}",$movieId,$output);
$output = str_replace("{movieStars}", implode($numeroStelle), $output);
// echo $output;
?>
