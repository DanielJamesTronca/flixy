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



/*
$dbMan = DBManager::getInstance();
$IDK = $dbMan->query("SELECT * FROM Media WHERE genre='2'");
*/

$dbMan = DBManager::getInstance();
$actualGenre = $dbMan->query("SELECT * FROM Media WHERE id='$movieId'");
$actualGenre_aux= $actualGenre[0]->genre;
$realGenre= $dbMan->query("SELECT * FROM Media WHERE genre='$actualGenre_aux'");
console_log($realGenre);




function getMovieList($realGenre) {
  $movieList = [];
  for ($x = 0; $x < count($realGenre); $x++) {
    $titolo = $realGenre[$x]->name;
    $url = $realGenre[$x]->cover_url;

    
    $card = file_get_contents("../html/similar_content_card.html");
    $card = str_replace("{movieTitle}", $titolo, $card);

    $card = str_replace("{movieCover}", "../".$url, $card);
    array_push($movieList, $card);
  }
  return implode($movieList);
}


/*
$dbMan = DBManager::getInstance();
$genreList_card = $dbMan->query("SELECT Genre.name FROM Genre LEFT JOIN Media ON Genre.id = '$actualGenre_aux'");
console_log($genreList);

function displayGenre($genreList_card){
  $movieList_card = [];
  for ($x = 0; $x < count($genreList_card); $x++) {
    $genre2=$genreList_card[$x]->name;

    
    $card = file_get_contents("../html/similar_content_card.html");
    $card = str_replace("{movieGenre}", $genre2, $card);
    array_push($movieList_card, $card);
  }
  return implode($movieList_card);
}
 
$output = str_replace("{movieList}", displayGenre($genreList_card), $output);
*/








$output = str_replace("{movieList}", getMovieList($realGenre), $output);



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