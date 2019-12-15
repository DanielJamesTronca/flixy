<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$output = file_get_contents("../html/dettaglio.html");

$output = file_get_contents("../html/dettaglio.html");

$output = file_get_contents("../html/dettaglio.html");

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






function console_log ( $data)
{
echo '<script>';
echo 'console.log(' .json_encode($data).')';
echo '</script>';
}


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
$queryGenre = $dbMan->query("SELECT Media.name FROM Media LEFT JOIN Genre ON Media.genre = Genre.id");
*/


$dbMan = DBManager::getInstance();
$IDK = $dbMan->query("SELECT Media.name FROM Media WHERE genre='2'");
console_log($IDK);










/*
$duration=$lista[1];
$cover_url=$lista[2];
$description=$lista[3];
$episode=$lista[4];
$season=$lista[5];
$trailer_url=$lista[6];
*/

echo $output;

?>

$output=str_replace("{title}", $title,$output);
$output=str_replace("{duration}", $duration,$output);
$output=str_replace("{description}", $description,$output);
$output=str_replace("{episode}", $episode,$output);
$output=str_replace("{season}", $season,$output);
$output=str_replace("{cover_url}", "../../public".$cover_url,$output);
$output=str_replace("{genre}", $genre,$output);
$output=str_replace("{trailer_url}",$trailer_url,$output);


echo $output;











/*
function filterList($genre){
    $dbMan = DBManager::getInstance();
    $result = [];

}

function getIdGenre($genre) {
    $dbMan = DBManager::getInstance();
    $result = $dbMan->query("SELECT id FROM Genre WHERE Genre.name = '$genre'");
    return (int)$result[0]->id;
  }



  function filterList($genre) {
    $dbMan = DBManager::getInstance();
    $result = [];
    $genreId = -1;
    if ($genre != "All") {
      $genreId = getIdGenre($genre);
    }
    if ($genre != "All") {
        $result = $dbMan->query("SELECT id FROM Media WHERE genre=$genreId");
    }
    return $result; 
}




function getMovieList($list) {
    $movieList = [];
    for ($x = 0; $x < count($list); $x++) {
      $title = $list[$x]->name;
      $url = $list[$x]->cover_url;
      $card = file_get_contents("../html/favourite_card.html");
      $card = str_replace("{movieTitle}", $title, $card);
      $card = str_replace("{coverURL}", "../public".$url, $card);
      array_push($movieList, $card);
    }
    return implode($movieList);
  }

$movieList = getMovieList($result);
$output = str_replace("{movieList}", $movieList, $output);

console_log($movieList);

*/



?>




