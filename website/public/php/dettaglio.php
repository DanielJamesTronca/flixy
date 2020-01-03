<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$output = file_get_contents("../html/dettaglio.html");


function console_log ( $data)
{
echo '<script>';
echo 'console.log(' .json_encode($data).')';
echo '</script>';
}

$title="";
$genre="None";
$duration="0";
$cover_url="None";
$description="None";
$season="/";
$episode="/";
$trailer_url="None";


$serieTvEpisode="";
$serieTvEpisodeReal="Episodes:";
$serieTvSeason=" ";
$serieTvSeasonReal="Season:";


$dbMan = DBManager::getInstance();
$genreList = $dbMan->query("SELECT Genre.name FROM Genre LEFT JOIN Media ON Genre.id = Media.genre");




function loadInfo($id){
    $dbMan = DBManager::getInstance();

    $list=$dbMan->query("SELECT * FROM Media WHERE id='$id'") ;

    $title=$list[0]->name;
    $duration=$list[0]->duration;
    
    $cover_url=$list[0]->cover_url;
    $description=$list[0]->description;
    $episode=$list[0]->episodes;
    $season=$list[0]->seasons;
    $trailer_url=$list[0]->trailer_url;

    $arr=array($title,$duration, $cover_url, $description, $episode, $season, $trailer_url);
    return $arr;

}


$movieId=2;

$lista= loadInfo($movieId);  // $movieId instead of 1

$title=$lista[0];
$duration=$lista[1];
$cover_url=$lista[2];
$description=$lista[3];
$episode=$lista[4];
$season=$lista[5];
$trailer_url=$lista[6];

$genre=$genreList[$movieId-1]->name;



if($episode==null && $season==null){
    $output=str_replace("{serieTvEpisode}", $serieTvEpisode,$output);
    $output=str_replace("{serieTvSeason}", $serieTvSeason,$output);
}
    else { 
        $output=str_replace("{serieTvEpisode}", $serieTvEpisodeReal,$output );
        $output=str_replace("{serieTvSeason}", $serieTvSeasonReal,$output );
}


$dbMan = DBManager::getInstance();
$actualGenre = $dbMan->query("SELECT * FROM Media WHERE id='$movieId'");
$actualGenre_aux= $actualGenre[0]->genre;
$realGenre= $dbMan->query("SELECT * FROM Media WHERE genre='$actualGenre_aux'");

$genre_variable= $dbMan->query("SELECT name FROM Genre WHERE id='$actualGenre_aux'");


function getMovieList($realGenre, $genre_variable) {
  $movieList = [];
  $y=0;

  for ($x = 0; $x < count($realGenre); $x++) {
    $titolo = $realGenre[$x]->name;
    $url = $realGenre[$x]->cover_url;
    $genre_card=$genre_variable[$y]->name;

    
    $card = file_get_contents("../html/similar_content_card.html");
    $card = str_replace("{movieTitle}", $titolo, $card);
    $card = str_replace("{movieGenre}", $genre_card, $card);

    $card = str_replace("{movieCover}", "../".$url, $card);
    array_push($movieList, $card);
  }
  return implode($movieList);
}



$figaro=Comment::getCommentsFor($movieId);
console_log($figaro);


$lola=Comment::getAvatar(2);
console_log($lola);

function getCommentList($figaro) {
  $commentList = [];
 

  for ($x = 0; $x < count($figaro); $x++) {
    $y=0;


    $contenuto = $figaro[$x]->content;
    $nome_commento=$figaro[$x]->userFullName;

    $id_to_url=$figaro[$x]->userId;
    
    $lolito=Comment::getAvatar($id_to_url);

    $finally_url=$lolito[$y]->avatar_url;
    
    
    $commento = file_get_contents("../html/comment.html");
    $commento = str_replace("{nome_commento}", $nome_commento, $commento);
    $commento = str_replace("{contenuto_commento}", $contenuto, $commento);

    $commento = str_replace("{avatar_url_commento}", "../".$finally_url, $commento);
    array_push($commentList, $commento);
  }
  return implode($commentList);
}


/*
$stars=Media
function getMovieStar($stars) {
  $starNumber = [];

  for($i=0;$i<$stars;$i++) {
    array_push($starNumber, "<i class='fa fa-star'></i>");
  }
  $card = str_replace("{movieStars}", implode($starNumber), $stelline);
  return $stelline;
}
*/







$output = str_replace("{commentList}", getCommentList($figaro), $output);


$output = str_replace("{movieList}", getMovieList($realGenre, $genre_variable), $output);

$output=str_replace("{title}", $title,$output);
$output=str_replace("{duration}", $duration,$output);
$output=str_replace("{description}", $description,$output);
$output=str_replace("{episode}", $episode,$output);
$output=str_replace("{season}", $season,$output);
$output=str_replace("{cover_url}", "../../public".$cover_url,$output);
$output=str_replace("{genre}", $genre,$output);
$output=str_replace("{trailer_url}",$trailer_url,$output);


echo $output;


?>